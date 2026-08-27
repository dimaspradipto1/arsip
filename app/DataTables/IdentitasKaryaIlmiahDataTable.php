<?php

namespace App\DataTables;

use App\Models\IdentitasKaryaIlmiah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IdentitasKaryaIlmiahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<IdentitasKaryaIlmiah> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('doi_link', function ($item) {
                if (empty($item->doi_artikel)) return '-';
                $url = str_starts_with($item->doi_artikel, 'http') ? $item->doi_artikel : 'https://doi.org/' . $item->doi_artikel;
                return '<a href="' . e($url) . '" target="_blank" class="badge badge-sm bg-gradient-secondary text-white text-decoration-none px-2 py-1">
                    <i class="fas fa-external-link-alt me-1"></i> ' . e(substr($item->doi_artikel, 0, 25)) . (strlen($item->doi_artikel) > 25 ? '...' : '') . '
                </a>';
            })
            ->addColumn('web_link', function ($item) {
                if (empty($item->alamat_web)) return '-';
                return '<a href="' . e($item->alamat_web) . '" target="_blank" class="badge badge-sm bg-gradient-info text-white text-decoration-none px-2 py-1">
                    <i class="fas fa-globe me-1"></i> Buka Link
                </a>';
            })
            ->addColumn('indexing_badge', function ($item) {
                if (empty($item->indexing)) return '-';
                return '<span class="badge badge-sm bg-gradient-success text-white px-2 py-1">' . e($item->indexing) . '</span>';
            })
            ->addColumn('kategori_badge', function ($item) {
                if (empty($item->kategori_publikasi)) return '-';
                return '<span class="badge badge-sm bg-gradient-primary text-white px-2 py-1">' . e($item->kategori_publikasi) . '</span>';
            })
            ->addColumn('action', function ($item) {
                if (Auth::check() && Auth::user()->roles === 'dosen') {
                    return '-';
                }

                $editUrl = route('identitaskaryailmiah.edit', $item->id);
                $deleteUrl = route('identitaskaryailmiah.destroy', $item->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <a href="' . $editUrl . '" class="btn-action-edit" data-bs-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn-action-delete" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['doi_link', 'web_link', 'indexing_badge', 'kategori_badge', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<IdentitasKaryaIlmiah>
     */
    public function query(IdentitasKaryaIlmiah $model): QueryBuilder
    {
        return $model->newQuery()->latest('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('identitaskaryailmiah-table')
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
            Column::make('tahun')
                  ->title('Tahun')
                  ->addClass('align-middle text-center text-xs font-weight-bold'),
            Column::make('judul_karya_ilmiah')
                  ->title('Judul Karya Ilmiah')
                  ->addClass('align-middle text-xs font-weight-bold text-dark'),
            Column::make('nama_jurnal')
                  ->title('Nama Jurnal')
                  ->addClass('align-middle text-xs'),
            Column::make('nomor_issn')
                  ->title('Nomor ISSN')
                  ->addClass('align-middle text-xs'),
            Column::make('volume_nomor_tahun')
                  ->title('Volume, Nomor, Tahun')
                  ->addClass('align-middle text-xs'),
            Column::computed('doi_link')
                  ->title('DOI Artikel')
                  ->data('doi_link')
                  ->name('doi_artikel')
                  ->addClass('align-middle text-xs text-center'),
            Column::computed('web_link')
                  ->title('Alamat Web')
                  ->data('web_link')
                  ->name('alamat_web')
                  ->addClass('align-middle text-xs text-center'),
            Column::computed('indexing_badge')
                  ->title('Indexing')
                  ->data('indexing_badge')
                  ->name('indexing')
                  ->addClass('align-middle text-center text-xs'),
            Column::computed('kategori_badge')
                  ->title('Kategori Publikasi')
                  ->data('kategori_badge')
                  ->name('kategori_publikasi')
                  ->addClass('align-middle text-center text-xs'),
        ];

        if (Auth::check() && Auth::user()->roles !== 'dosen') {
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
        return 'IdentitasKaryaIlmiah_' . date('YmdHis');
    }
}
