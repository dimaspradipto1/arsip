<?php

namespace App\DataTables;

use App\Models\SkKepanitiaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SkKepanitiaanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SkKepanitiaan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('tahunakademik_id', function ($item) {
                return $item->tahunakademik->tahun_akademik;
            })
            ->addColumn('kategorysk_id', function ($item) {
                return $item->kategorysk->kategory_sk;
            })
            ->addColumn('dokumen', function ($item) {
                $googleDriveLink = $item->dokumen;
                preg_match('/\/d\/(.*?)\//', $googleDriveLink, $matches);

                if (isset($matches[1])) {
                    $fileId = $matches[1];
                    $driveLink = 'https://drive.google.com/uc?export=view&id=' . $fileId;

                    return '<a href="' . $driveLink . '" class="text-success" target="_blank">Lihat Dokumen</a>';
                }

                return 'Dokumen tidak tersedia';
            })

            ->addColumn('action', function ($item) {
                if (Auth::check() && Auth::user()->roles === 'dosen') {
                    return '<span class="text-muted text-xs"><i class="fas fa-lock me-1"></i>Read Only</span>';
                }

                return '
                    <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                        <a href="' . route('skkepanitiaan.edit', $item->id) . '" class="btn btn-warning text-white mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                        <form action="' . route('skkepanitiaan.destroy', $item->id) . '" method="POST" style="display: inline-block; margin: 0;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" onclick="return confirm(\'Yakin ingin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'tahunakademik_id', 'kategorysk_id', 'dokumen']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SkKepanitiaan>
     */
    public function query(SkKepanitiaan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('skkepanitiaan-table')
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
            Column::make('kategorysk_id')
                ->title('Kategory SK')
                ->addClass('text-center'),
            Column::make('nomor_sk')
                ->title('Nomor SK')
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
        return 'SkKepanitiaan_' . date('YmdHis');
    }
}
