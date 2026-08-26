<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->addColumn('role_status', function ($user) {
                $badges = [
                    'admin'       => '<span class="badge bg-danger">Admin</span>',
                    'tatausaha'   => '<span class="badge bg-primary">Tata Usaha</span>',
                    'dosen'       => '<span class="badge bg-info">Dosen</span>',
                    'dekan'       => '<span class="badge bg-success">Dekan</span>',
                    'wakilDekan1' => '<span class="badge bg-warning text-dark">Wakil Dekan 1</span>',
                    'wakilDekan2' => '<span class="badge bg-warning text-dark">Wakil Dekan 2</span>',
                    'kaprodi'     => '<span class="badge bg-dark">Kaprodi</span>',
                    'sekprodi'    => '<span class="badge bg-secondary">Sekprodi</span>',
                ];

                return $badges[$user->roles] ?? '<span class="badge bg-light text-dark">' . e($user->roles) . '</span>';
            })
            ->addColumn('action', function($user){
                return '
                    <a href="'.route('user.updatePassword', $user->id).'" class="btn btn-sm btn-dark text-white" title="Ubah Password"><i class="fa-solid fa-key"></i></a>
                    <a href="'.route('user.edit', $user->id).'" class="btn btn-sm btn-warning text-white" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="'.route('user.destroy', $user->id).'" method="POST" style="display: inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                    </form>
                ';
            })
            ->setRowId('DT_RowIndex')
            ->rawColumns(['action', 'role_status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
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
                ->title('NO')
                ->width(60)
                ->addClass('text-center'),
            Column::make('name')->title('Nama'),
            Column::make('email')->title('Email'),
            Column::make('fakultas')->title('Fakultas'),
            Column::make('homebase')->title('Homebase'),
            Column::computed('role_status')
                ->title('Status')
                ->addClass('text-center'),
            Column::computed('action')->title('Aksi')
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
        return 'User_' . date('YmdHis');
    }
}
