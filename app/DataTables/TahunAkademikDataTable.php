<?php

namespace App\DataTables;

use App\Models\TahunAkademik;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TahunAkademikDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<TahunAkademik> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_Rowindex', '')
            ->addColumn('action', function ($tahunAkademik) {
                return '
                    <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                        <a href="'.route('tahunakademik.edit', $tahunAkademik->id).'" class="btn btn-warning text-white mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                        <form action="'.route('tahunakademik.destroy', $tahunAkademik->id).'" method="POST" style="display: inline-block; margin: 0;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-danger mb-0" style="padding: 7px 12px; font-size: 13px; border-radius: 6px;" onclick="return confirm(\'Yakin ingin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>';
            })
            ->setRowId('DT_Rowindex')
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<TahunAkademik>
     */
    public function query(TahunAkademik $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tahunakademik-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
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
            Column::computed('DT_RowIndex')
                  ->title('NO')
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('tahun_akademik')
                ->title('Tahun Akademik')
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
        return 'TahunAkademik_' . date('YmdHis');
    }
}
