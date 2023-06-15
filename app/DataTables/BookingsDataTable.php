<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Booking;
use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BookingsDataTable extends DataTable
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

            ->editColumn('property.name', function (Booking $model) {
                return $model->property->name ?? '';
            })

            ->editColumn('customer', function (Booking $model) {
                return $model->customer->full_name ?? '';
            })
            ->orderColumn('customer', fn($q, $order) =>
                $q
                ->leftJoin('customers', 'customers.id', 'bookings.customer_id')
                ->orderBy('customers.first_name', $order)
            )
            ->filterColumn('customer', fn($q, $keyword) =>
                $q->whereExists(fn($q) =>
                    $q->select("*")
                    ->from('customers')
                    ->whereRaw('customers.id = bookings.customer_id')
                    ->where(fn($q) => $q->where("first_name",  "like", ["%{$keyword}%"])->orWhere("last_name",  "like", ["%{$keyword}%"]))
                )
            )

            ->editColumn('payment_method', function (Booking $model) {
                return PaymentMethod::getDescription($model->payment_method->value);
            })
            ->orderColumn('payment_method', 'payment_method $1')
            ->filterColumn('payment_method', fn($q, $keyword) => 
                $q->whereIn('payment_method', array_keys(array_filter(PaymentMethod::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )
    
            ->editColumn('status', function (Booking $model) {
                return BookingStatus::getDescription($model->status->value);
            })
            ->orderColumn('bookings.status', 'status $1')
            ->filterColumn('status', fn($q, $keyword) => 
                $q->whereIn('bookings.status', array_keys(array_filter(BookingStatus::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )

            ->editColumn('starts_at', function (Booking $model) {
                return date_ar($model->starts_at);
            })
            ->editColumn('ends_at', function (Booking $model) {
                return date_ar($model->ends_at);
            })
            ->editColumn('created_at', function (Booking $model) {
                return date_hour_ar($model->created_at);
            })            
            ->editColumn('action', function (Booking $model) {
                return view('admin.bookings.table.action', compact('model'));
            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Booking $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Booking $model)
    {
        return $model->newQuery()
                ->with('property:id,name', 'customer')
                ->notForeign()
                ->select('bookings.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('bookings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()

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
            Column::make('property.name')->title('الوحدة'),
            Column::make('customer')->title('الزبون'),
            Column::make('payment_method')->title('وسيلة الدفع'),
            Column::make('total_price')->title('السعر الكلي'),
            Column::make('commission')->title('العمولة'),
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
        return 'Bookings_' . date('YmdHis');
    }
}
