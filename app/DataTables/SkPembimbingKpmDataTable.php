<?php

namespace App\DataTables;

use App\Models\SkPembimbingKpm;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SkPembimbingKpmDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SkPembimbingKpm> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('tahunakademik_id', function ($item) {
                return $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-';
            })
            ->addColumn('dosen', function ($item) {
                if ($item->users->isEmpty()) {
                    return '<span class="text-muted">-</span>';
                }
                return '<div class="d-flex flex-wrap" style="gap: 4px;">' . $item->users->map(function ($u) {
                    return '<span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px; font-weight: 600;"><i class="fas fa-user-tie text-success me-1"></i>' . e($u->name) . '</span>';
                })->implode('') . '</div>';
            })
            ->addColumn('prodi', function ($item) {
                if (!empty($item->prodi)) {
                    return $item->prodi;
                }
                // fallback to prodi of first user if available
                $firstUser = $item->users->first();
                return $firstUser && $firstUser->homebase ? $firstUser->homebase : '-';
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

                $editUrl = route('skpembimbingkpm.edit', $item->id);
                $deleteUrl = route('skpembimbingkpm.destroy', $item->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="' . $editUrl . '" class="btn-action-edit" data-bs-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus SK KPM ini?\')">
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
            ->rawColumns(['action', 'tahunakademik_id', 'dosen', 'dokumen']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SkPembimbingKpm>
     */
    public function query(SkPembimbingKpm $model): QueryBuilder
    {
        $query = $model->newQuery()->select('sk_pembimbing_kpms.*')->with(['tahunakademik', 'users']);

        if (Auth::check() && Auth::user()->roles === 'dosen') {
            $query->whereHas('users', function ($q) {
                $q->where('users.id', Auth::id());
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('skpembimbingkpm-table')
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
            $columns[] = Column::make('dosen')
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
        return 'SkPembimbingKpm_' . date('YmdHis');
    }
}
