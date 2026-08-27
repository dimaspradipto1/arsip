<?php

namespace App\DataTables;

use App\Models\BebanKerjaDosen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BebanKerjaDosenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<BebanKerjaDosen> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('tahun_akademik', function ($item) {
                return $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-';
            })
            ->addColumn('ketua_panitia', function ($item) {
                return $item->ketuaPanitia ? $item->ketuaPanitia->name : '-';
            })
            ->addColumn('sekretaris', function ($item) {
                return $item->sekretaris ? $item->sekretaris->name : '-';
            })
            ->addColumn('dokumen_link', function ($item) {
                if (!$item->dokumen) return '<span class="text-muted text-xs">-</span>';

                $googleDriveLink = $item->dokumen;
                $url = $googleDriveLink;
                if (preg_match('/(?:drive\.google\.com\/(?:file\/d\/|open\?id=)|docs\.google\.com\/file\/d\/)([a-zA-Z0-9_-]+)/', $googleDriveLink, $matches)) {
                    $fileId = $matches[1];
                    $url = 'https://drive.google.com/uc?export=view&id=' . $fileId;
                }

                return '
                    <div class="d-flex flex-column align-items-center justify-content-center py-1">
                        <a href="' . e($url) . '" target="_blank" class="btn-doc-link mb-1">
                            <i class="fas fa-file-pdf"></i> <span>Lihat Dokumen</span>
                        </a>
                        <span class="doc-text-wrap">' . e($googleDriveLink) . '</span>
                    </div>
                ';
            })
            ->addColumn('action', function ($item) {
                if (Auth::check() && Auth::user()->roles === 'dosen') {
                    return '-';
                }

                $editUrl = route('bebankerjadosen.edit', $item->id);
                $deleteUrl = route('bebankerjadosen.destroy', $item->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="' . $editUrl . '" class="btn-action-edit" data-bs-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data Beban Kerja Dosen ini?\')">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn-action-delete" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['dokumen_link', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<BebanKerjaDosen>
     */
    public function query(BebanKerjaDosen $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->select('beban_kerja_dosens.*')
            ->with(['tahunakademik', 'ketuaPanitia', 'sekretaris'])
            ->latest('beban_kerja_dosens.created_at');

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->roles === 'dosen') {
                $query->where(function ($q) use ($user) {
                    $q->where('beban_kerja_dosens.ketua_panitia_id', $user->id)
                      ->orWhere('beban_kerja_dosens.sekretaris_id', $user->id);
                });
            } elseif ($user->roles !== 'admin') {
                $query->where(function ($q) use ($user) {
                    $q->whereHas('ketuaPanitia', function ($sub) use ($user) {
                        $sub->facultyScope($user);
                    })->orWhereHas('sekretaris', function ($sub) use ($user) {
                        $sub->facultyScope($user);
                    });
                });
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bebankerjadosen-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc')
            ->selectStyleSingle()
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
                'language' => [
                    'search' => 'Cari:',
                    'searchPlaceholder' => 'Ketik pencarian...',
                    'lengthMenu' => '_MENU_ per halaman',
                    'info' => 'Menampilkan _START_ s/d _END_ dari _TOTAL_ data',
                    'infoEmpty' => 'Tidak ada data',
                    'infoFiltered' => '(difilter dari _MAX_ data)',
                    'zeroRecords' => 'Data tidak ditemukan',
                    'paginate' => [
                        'first' => '«',
                        'previous' => '‹',
                        'next' => '›',
                        'last' => '»'
                    ]
                ]
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(40)
                ->addClass('text-center align-middle font-weight-bold text-xs'),
            Column::make('tahun_akademik')
                ->title('Tahun Akademik')
                ->data('tahun_akademik')
                ->name('tahunakademik.tahun_akademik')
                ->addClass('align-middle text-center text-xs'),
            Column::make('ketua_panitia')
                ->title('Ketua Panitia')
                ->data('ketua_panitia')
                ->name('ketuaPanitia.name')
                ->addClass('align-middle text-xs font-weight-bold'),
            Column::make('sekretaris')
                ->title('Sekretaris')
                ->data('sekretaris')
                ->name('sekretaris.name')
                ->addClass('align-middle text-xs font-weight-bold'),
            Column::computed('dokumen_link')
                ->title('Dokumen')
                ->width(350)
                ->addClass('text-center align-middle text-xs'),
        ];

        if (!Auth::check() || Auth::user()->roles !== 'dosen') {
            $columns[] = Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center align-middle');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BebanKerjaDosen_' . date('YmdHis');
    }
}
