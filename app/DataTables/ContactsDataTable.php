<?php

namespace App\DataTables;

use App\Models\Contact;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactsDataTable extends DataTable
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

            ->editColumn('created_at', function (Contact $model) {
                return date_hour_ar($model->created_at);
            })

            ->editColumn('action', function (Contact $model) {
                return view('admin.contacts.table.action', compact('model'));
            });     
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Contact $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contact $model)
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
                    ->setTableId('contacts-table')
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
            Column::make('name')->title('الاسم'),
            Column::make('phone')->title('رقم الجوال')->addClass('ltr_col'),
            Column::make('email')->title('الإيميل')->addClass('ltr_col'),
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
        return 'Contacts_' . date('YmdHis');
    }
}
