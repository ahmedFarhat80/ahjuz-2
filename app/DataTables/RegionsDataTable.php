<?php

namespace App\DataTables;

use App\Models\Region;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RegionsDataTable extends DataTable
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
            
            ->editColumn('action', function (Region $model) {
                return view('admin.regions.table.action', compact('model'));
            });   
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Region $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Region $model)
    {
        return $model->newQuery()
            ->with('governorate:id,name')
            ->select('regions.*');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('regions-table')
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
            Column::make('governorate.name')->title('المحافظة'),
            Column::make('name')->title('الاسم'),
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
        return 'Regions_' . date('YmdHis');
    }
}
