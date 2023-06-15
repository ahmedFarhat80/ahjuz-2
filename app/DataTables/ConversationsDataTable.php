<?php

namespace App\DataTables;

use App\Models\Conversation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ConversationsDataTable extends DataTable
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

            ->editColumn('property.name', function (Conversation $model) {
                return $model->property->name;
            })

            ->editColumn('owner', function (Conversation $model) {
                return $model->property->owner->full_name;
            })
            ->orderColumn('owner', fn($q, $order) =>
                $q
                ->leftJoin('properties', 'conversations.property_id', 'properties.id')
                ->leftJoin('owners', 'owners.id', 'properties.owner_id')
                ->orderBy('owners.first_name', $order)
            )
            ->filterColumn('owner', fn($q, $keyword) =>
                $q->whereExists(fn($q) =>
                    $q->select("*")
                    ->from('owners')
                    ->leftJoin('properties', 'conversations.property_id', 'properties.id')
                    ->whereRaw('conversations.property_id = properties.id')
                    ->whereRaw('owners.id = properties.owner_id')
                    ->where(fn($q) => $q->where("first_name",  "like", ["%{$keyword}%"])->orWhere("last_name",  "like", ["%{$keyword}%"]))
                )
            )

            ->editColumn('customer', function (Conversation $model) {
                return $model->customer->full_name;
            })
            ->orderColumn('customer', fn($q, $order) =>
                $q
                ->leftJoin('customers', 'customers.id', 'conversations.customer_id')
                ->orderBy('customers.first_name', $order)
            )
            ->filterColumn('customer', fn($q, $keyword) =>
                $q->whereExists(fn($q) =>
                    $q->select("*")
                    ->from('customers')
                    ->whereRaw('conversations.customer_id = customers.id')
                    ->where(fn($q) => $q->where("first_name",  "like", ["%{$keyword}%"])->orWhere("last_name",  "like", ["%{$keyword}%"]))
                )
            )

            ->editColumn('created_at', function (Conversation $model) {
                return date_hour_ar($model->created_at);
            })

            ->editColumn('action', function (Conversation $model) {
                return view('admin.conversations.table.action', compact('model'));
            });
         }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Conversation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Conversation $model)
    {
        return $model->newQuery()
        ->with('property', 'property.owner', 'customer')
        ->select('conversations.*');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('conversations-table')
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
            Column::make('owner')->title('المالك'),
            Column::make('customer')->title('الزبون'),
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
        return 'Conversations_' . date('YmdHis');
    }
}
