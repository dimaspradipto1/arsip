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
            ->addColumn('role_status', function ($user) {
                $badges = [
                    'admin'       => '<span class="badge bg-danger mb-1">Admin</span>',
                    'tatausaha'   => '<span class="badge bg-primary mb-1">Tata Usaha</span>',
                    'dosen'       => '<span class="badge bg-info mb-1">Dosen</span>',
                    'dekan'       => '<span class="badge bg-success mb-1">Dekan</span>',
                    'wakilDekan1' => '<span class="badge bg-warning text-dark mb-1">Wakil Dekan 1</span>',
                    'wakilDekan2' => '<span class="badge bg-warning text-dark mb-1">Wakil Dekan 2</span>',
                    'kaprodi'     => '<span class="badge bg-dark mb-1">Kaprodi</span>',
                    'sekprodi'    => '<span class="badge bg-secondary mb-1">Sekprodi</span>',
                ];

                $userRoles = $user->roles;
                if (!is_array($userRoles)) {
                    $userRoles = (array) $userRoles;
                }

                $output = '<div class="d-flex flex-wrap justify-content-center gap-1">';
                foreach ($userRoles as $r) {
                    $r = trim($r);
                    if (!$r) continue;
                    $output .= $badges[$r] ?? ('<span class="badge bg-light text-dark mb-1">' . e($r) . '</span>');
                }
                $output .= '</div>';

                return $output;
            })
            ->addColumn('action', function($user){
                if (Auth::check() && Auth::user()->isOnlyDosen()) {
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
            ->setRowId('id')
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
        if (Auth::check() && !Auth::user()->hasRole('admin')) {
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
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(40)
                ->addClass('text-center align-middle font-weight-bold text-xs'),
            Column::make('name')
                ->title('Nama')
                ->addClass('align-middle text-xs font-weight-bold'),
            Column::make('email')
                ->title('Email')
                ->addClass('align-middle text-xs'),
            Column::make('fakultas')
                ->title('Fakultas')
                ->addClass('align-middle text-xs'),
            Column::make('homebase')
                ->title('Homebase')
                ->addClass('align-middle text-xs'),
            Column::computed('role_status')
                ->title('Status Role')
                ->width(150)
                ->addClass('text-center align-middle text-xs'),
        ];

        if (!Auth::check() || !Auth::user()->isOnlyDosen()) {
            $columns[] = Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(130)
                ->addClass('text-center align-middle');
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
