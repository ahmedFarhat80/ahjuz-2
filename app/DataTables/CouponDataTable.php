<?php

namespace App\DataTables;

use App\Enums\CouponStatus;
use App\Enums\CouponType;
use App\Models\Coupon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
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

            ->editColumn('type', function (Coupon $model) {
                return CouponType::getDescription($model->type->value);
            })
            ->orderColumn('type', 'type $1')
            ->filterColumn('type', fn($q, $keyword) => 
                $q->whereIn('type', array_keys(array_filter(CouponType::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )
    
            ->editColumn('status', function (Coupon $model) {
                return CouponStatus::getDescription($model->status->value);
            })
            ->orderColumn('status', 'status $1')
            ->filterColumn('status', fn($q, $keyword) => 
                $q->whereIn('status', array_keys(array_filter(CouponStatus::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )

            ->editColumn('starts_at', function (Coupon $model) {
                return date_ar($model->starts_at);
            })
            ->editColumn('ends_at', function (Coupon $model) {
                return date_ar($model->ends_at);
            })
            ->editColumn('created_at', function (Coupon $model) {
                return date_hour_ar($model->created_at);
            })

            ->editColumn('action', function (Coupon $model) {
                return view('admin.coupons.table.action', compact('model'));
            });   
         }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Coupon $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Coupon $model)
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
                    ->setTableId('coupons-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()

                    // ->dom('Bfrtip')
                    ->dom("<'row'" .
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" .
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" .
                    ">" .
                  
                    "<'table-responsive'tr>" .
                  
                    "<'row'" .
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'B>" .
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
            Column::make('code')->title('الرمز'),
            Column::make('type')->title('النوع'),
            Column::make('value')->title('القيمة'),
            Column::make('use_count')->title('عدد مرات الاستخدام'),
            Column::make('max_use_count')->title('أقصى عدد مرات الاستخدام'),
            Column::make('starts_at')->title('يبدأ'),
            Column::make('ends_at')->title('ينتهي'),
            Column::make('status')->title('الحالة'),
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
        return 'Coupon_' . date('YmdHis');
    }
}
