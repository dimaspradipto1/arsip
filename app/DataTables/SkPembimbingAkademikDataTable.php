<?php

namespace App\DataTables;

use App\Models\SkPembimbingAkademik;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SkPembimbingAkademikDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SkPembimbingAkademik> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('tahunakademik_id', function ($item) {
                return $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-';
            })
            ->addColumn('user_id', function ($item) {
                return $item->user ? $item->user->name : '-';
            })
            ->addColumn('prodi', function ($item) {
                return $item->prodi ?: ($item->user && $item->user->homebase ? $item->user->homebase : '-');
            })
            ->addColumn('dokumen', function ($item) {
                $googleDriveLink = $item->dokumen;
                if (!$googleDriveLink) return '<span class="text-muted text-xs">-</span>';

                $url = $googleDriveLink;
                if (preg_match('/(?:drive\.google\.com\/(?:file\/d\/|open\?id=)|docs\.google\.com\/file\/d\/)([a-zA-Z0-9_-]+)/', $googleDriveLink, $matches)) {
                    $fileId = $matches[1];
                    $url = 'https://drive.google.com/uc?export=view&id=' . $fileId;
                }

                return '
                    <div class="d-flex flex-column align-items-center justify-content-center py-1">
                        <a href="' . e($url) . '" class="btn-doc-link mb-1" target="_blank">
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

                $editUrl = route('skpembimbingakademik.edit', $item->id);
                $deleteUrl = route('skpembimbingakademik.destroy', $item->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="' . $editUrl . '" class="btn-action-edit" data-bs-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus SK PA ini?\')">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn-action-delete" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'tahunakademik_id', 'user_id', 'dokumen']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SkPembimbingAkademik>
     */
    public function query(SkPembimbingAkademik $model): QueryBuilder
    {
        $query = $model->newQuery()->select('sk_pembimbing_akademiks.*')->with(['tahunakademik', 'user']);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->roles === 'dosen') {
                $query->where('sk_pembimbing_akademiks.user_id', $user->id);
            } elseif ($user->roles !== 'admin') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->facultyScope($user);
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
            ->setTableId('skpembimbingakademik-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
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
            ])
            ->buttons([
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('DT_RowIndex')
                ->title('No')
                ->addClass('text-center'),
            Column::make('tahunakademik_id')
                ->title('Tahun Akademik')
                ->addClass('text-center'),
        ];

        if (!Auth::check() || Auth::user()->roles !== 'dosen') {
            $columns[] = Column::make('user_id')
                ->title('Nama Dosen')
                ->addClass('text-start font-weight-bold');
        }

        $columns[] = Column::make('nomor_sk')
            ->title('Nomor SK')
            ->addClass('text-start');
        $columns[] = Column::make('prodi')
            ->title('Prodi')
            ->addClass('text-start');
        $columns[] = Column::make('dokumen')
            ->title('Dokumen')
            ->width(350)
            ->addClass('text-center align-middle');

        if (Auth::check() && Auth::user()->roles !== 'dosen') {
            $columns[] = Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SkPembimbingAkademik_' . date('YmdHis');
    }
}
