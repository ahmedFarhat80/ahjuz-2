<?php

namespace App\DataTables;

use App\Models\Ad;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            ->editColumn('cover', function (Ad $model) {
                return "<img src='$model->cover' style='width: 50px;height: 50px;'>";
            })   

            ->editColumn('created_at', function (Ad $model) {
                return date_hour_ar($model->created_at);
            })

            ->editColumn('action', function (Ad $model) {
                return view('admin.ads.table.action', compact('model'));
            })

            ->rawColumns(['cover']);  
        }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Ad $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ad $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('ads-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()

                    // ->dom('Bfrtip')
                    ->dom("<'row'" .
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" .
                    "<'col-sm-6 d-flex align-items-center justify-content-end'>" .
                    ">" .
                  
                    "<'table-responsive'tr>" .
                  
                    "<'row'" .
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'>" .
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" .
                    ">")

                    ->orderBy(0)
                    ->stateSave(true)
                    ->responsive()
                    ->autoWidth(false)
                    // ->parameters(['scrollX' => true, "scrollY" => "500px", "scrollCollapse" => true,])
                    ->addTableClass('align-middle table-row-dashed fs-6 gy-5 text-center')
                    ->setTableAttribute('direction', 'rtl')
                    ->buttons(
                        Button::make('pdf'),
                        Button::make('excel'),
                        Button::make('print'),
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('الرقم المعرف'),
            Column::computed('cover')
            ->title('الصورة')
            ->exportable(false)
            ->printable(false),
            Column::make('created_at')->title('تاريخ الإنشاء'),
            Column::computed('action')->title('الإجراءات')
                ->exportable(false)
                ->printable(false)
                ->responsivePriority(-1)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Ads_' . date('YmdHis');
    }
}
