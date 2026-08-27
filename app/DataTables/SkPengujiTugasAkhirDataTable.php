<?php

namespace App\DataTables;

use App\Models\SkPengujiTugasAkhir;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SkPengujiTugasAkhirDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SkPengujiTugasAkhir> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('dosen', function ($item) {
                if ($item->users->isEmpty()) {
                    return '<span class="text-muted text-xs">-</span>';
                }
                return '<div class="d-flex flex-wrap gap-1">' . $item->users->map(function ($u) {
                    return '<span class="badge badge-sm bg-gradient-success text-white px-2 py-1" style="font-size: 11px;">
                        <i class="fas fa-user-tie me-1"></i>' . e($u->name) . '
                    </span>';
                })->implode(' ') . '</div>';
            })
            ->addColumn('tahun_akademik', function ($item) {
                return $item->tahunakademik ? $item->tahunakademik->tahun_akademik : '-';
            })
            ->addColumn('tanggal_sk_formatted', function ($item) {
                return $item->tanggal_sk ? \Carbon\Carbon::parse($item->tanggal_sk)->translatedFormat('d M Y') : '-';
            })
            ->addColumn('dokumen_link', function ($item) {
                if (!$item->dokumen) return '<span class="text-muted text-xs">-</span>';
                $url = $item->dokumen;
                return '
                    <div class="d-flex flex-column align-items-center justify-content-center py-1">
                        <a href="' . e($url) . '" target="_blank" class="btn-doc-link mb-1">
                            <i class="fas fa-file-pdf"></i> <span>Lihat Dokumen</span>
                        </a>
                        <span class="doc-text-wrap">' . e($url) . '</span>
                    </div>
                ';
            })
            ->addColumn('action', function ($item) {
                if (Auth::check() && Auth::user()->roles === 'dosen') {
                    return '-';
                }

                $editUrl = route('skpengujitugasakhir.edit', $item->id);
                $deleteUrl = route('skpengujitugasakhir.destroy', $item->id);
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
            ->rawColumns(['dosen', 'dokumen_link', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SkPengujiTugasAkhir>
     */
    public function query(SkPengujiTugasAkhir $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->select('sk_penguji_tugas_akhirs.*')
            ->with(['tahunakademik', 'users'])
            ->latest('sk_penguji_tugas_akhirs.created_at');

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
                    ->setTableId('skpengujitugasakhir-table')
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
            Column::make('tahun_akademik')
                  ->title('Tahun Akademik')
                  ->data('tahun_akademik')
                  ->name('tahunakademik.tahun_akademik')
                  ->addClass('align-middle text-xs'),
        ];

        if (!Auth::check() || Auth::user()->roles !== 'dosen') {
            $columns[] = Column::computed('dosen')
                  ->title('Nama Dosen Penguji')
                  ->addClass('align-middle text-xs font-weight-bold');
        }

        $columns[] = Column::make('nomor_sk')
              ->title('Nomor SK')
              ->addClass('align-middle text-xs');
        $columns[] = Column::make('nama_mahasiswa')
              ->title('Nama Mahasiswa')
              ->addClass('align-middle text-xs font-weight-bold text-dark');
        $columns[] = Column::make('npm')
              ->title('NPM')
              ->addClass('align-middle text-xs');
        $columns[] = Column::make('tanggal_sk_formatted')
              ->title('Tanggal SK')
              ->data('tanggal_sk_formatted')
              ->name('tanggal_sk')
              ->addClass('align-middle text-xs text-center');
        $columns[] = Column::computed('dokumen_link')
              ->title('Dokumen')
              ->width(350)
              ->addClass('text-center align-middle text-xs');

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
        return 'SkPengujiTugasAkhir_' . date('YmdHis');
    }
}
