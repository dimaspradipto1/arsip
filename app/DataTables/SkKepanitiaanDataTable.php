<?php

namespace App\DataTables;

use App\Models\SkKepanitiaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
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
            ->addColumn('tahunakademik_id', function($item){
                return $item->tahunakademik->tahun_akademik;
            })
            ->addColumn('kategorysk_id', function($item){
                return $item->kategorysk->kategory_sk;
            })
            ->addColumn('action', function($item){
                return '
                    <a href="'.route('skkepanitiaan.edit', $item->id).'" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                    <form action="'.route('skkepanitiaan.destroy', $item->id).'" method="POST" class="d-inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'tahunakademik_id', 'kategorysk_id']);
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
                ->width(60)
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
