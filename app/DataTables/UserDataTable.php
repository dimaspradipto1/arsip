<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
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
                if (Auth::check() && Auth::user()->roles === 'dosen') {
                    return '-';
                }

                $pwdUrl = route('user.updatePassword', $user->id);
                $editUrl = route('user.edit', $user->id);
                $deleteUrl = route('user.destroy', $user->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="' . $pwdUrl . '" class="btn-action-view bg-dark text-white" data-bs-toggle="tooltip" title="Ubah Password">
                            <i class="fas fa-key"></i>
                        </a>
                        <a href="' . $editUrl . '" class="btn-action-edit" data-bs-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus user ini?\')">
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
            ->rawColumns(['action', 'role_status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery();
        if (Auth::check() && Auth::user()->roles !== 'admin') {
            $query->facultyScope(Auth::user());
        }
        return $query;
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
        ];

        if (Auth::check() && Auth::user()->roles !== 'dosen') {
            $columns[] = Column::computed('action')->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(140)
                ->addClass('text-center');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
