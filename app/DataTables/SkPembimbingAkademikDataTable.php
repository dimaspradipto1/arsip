<?php

namespace App\DataTables;

use App\Models\SkPembimbingAkademik;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
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
                preg_match('/\/d\/(.*?)\//', $googleDriveLink, $matches);

                if (isset($matches[1])) {
                    $fileId = $matches[1];
                    $driveLink = 'https://drive.google.com/uc?export=view&id=' . $fileId;

                    return '<a href="' . $driveLink . '" class="text-success font-weight-bold" target="_blank"><i class="fas fa-file-pdf me-1"></i>Lihat Dokumen</a>';
                }

                if (filter_var($googleDriveLink, FILTER_VALIDATE_URL)) {
                    return '<a href="' . $googleDriveLink . '" class="text-success font-weight-bold" target="_blank"><i class="fas fa-external-link-alt me-1"></i>Lihat Dokumen</a>';
                }

                return '<span class="text-muted">Dokumen tidak tersedia</span>';
            })
            ->addColumn('action', function ($item) {
                return '
                    <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                        <a href="' . route('skpembimbingakademik.edit', $item->id) . '" class="btn btn-warning text-white mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                        <form action="' . route('skpembimbingakademik.destroy', $item->id) . '" method="POST" style="display: inline-block; margin: 0;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" onclick="return confirm(\'Yakin ingin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash"></i></button>
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
        return $model->newQuery()->select('sk_pembimbing_akademiks.*')->with(['tahunakademik', 'user']);
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
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->addClass('text-center'),
            Column::make('tahunakademik_id')
                ->title('Tahun Akademik')
                ->addClass('text-center'),
            Column::make('user_id')
                ->title('Nama Dosen')
                ->addClass('text-start'),
            Column::make('nomor_sk')
                ->title('Nomor SK')
                ->addClass('text-start'),
            Column::make('prodi')
                ->title('Prodi')
                ->addClass('text-start'),
            Column::make('dokumen')
                ->title('Dokumen')
                ->addClass('text-start'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SkPembimbingAkademik_' . date('YmdHis');
    }
}
