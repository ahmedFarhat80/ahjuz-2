<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Property;
use App\Enums\PropertyStatus;
use App\Enums\PropertyIsActive;
use App\Enums\PropertyIsSpecial;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PropertiesDataTable extends DataTable
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
            
            ->editColumn('owner', function (Property $model) {
                return $model->owner->full_name ?? '';
            })
            ->orderColumn('owner', fn($q, $order) =>
                $q
                ->leftJoin('owners', 'owners.id', 'properties.owner_id')
                ->orderBy('owners.first_name', $order)
            )
            ->filterColumn('owner', fn($q, $keyword) =>
                $q->whereExists(fn($q) =>
                    $q->select("*")
                    ->from('owners')
                    ->whereRaw('owners.id = properties.owner_id')
                    ->where(fn($q) => $q->where("first_name",  "like", ["%{$keyword}%"])->orWhere("last_name",  "like", ["%{$keyword}%"]))
                )
            )
            
            ->editColumn('address', function (Property $model) {
                return $model->gov_reg;
            })
            ->orderColumn('address', fn($q, $order) =>
                $q
                ->leftJoin('property_addresses', 'property_addresses.property_id', 'properties.id')
                ->leftJoin('governorates', 'property_addresses.governorate_id', 'governorates.id')
                ->leftJoin('regions', 'property_addresses.region_id', 'regions.id')
                ->orderBy('governorates.name', $order)
            )
            ->filterColumn('address', fn($q, $keyword) =>
                $q->whereExists(fn($q) =>
                    $q->select("*")
                    ->from('property_addresses')
                    ->whereRaw('property_addresses.property_id = properties.id')
                    ->leftJoin('governorates', 'property_addresses.governorate_id', 'governorates.id')
                    ->leftJoin('regions', 'property_addresses.region_id', 'regions.id')    
                    ->where(fn($q) => $q->where("governorates.name",  "like", ["%{$keyword}%"])->orWhere("regions.name",  "like", ["%{$keyword}%"]))
                )
            )

            ->editColumn('is_special', function (Property $model) {
                return PropertyIsSpecial::getDescription($model->is_special->value);
            })
            ->orderColumn('is_special', 'is_special $1')
            ->filterColumn('is_special', fn($q, $keyword) => 
                $q->whereIn('is_special', array_keys(array_filter(PropertyIsSpecial::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )

            ->editColumn('is_active', function (Property $model) {
                return PropertyIsActive::getDescription($model->is_active->value);
            })
            ->orderColumn('is_active', 'is_active $1')
            ->filterColumn('is_active', fn($q, $keyword) => 
                $q->whereIn('is_active', array_keys(array_filter(PropertyIsActive::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )
    
            ->editColumn('status', function (Property $model) {
                return PropertyStatus::getDescription($model->status->value);
            })
            ->orderColumn('status', 'status $1')
            ->filterColumn('status', fn($q, $keyword) => 
                $q->whereIn('status', array_keys(array_filter(PropertyStatus::asSelectArray(), fn($v) => stristr($v, $keyword))))
            )

            ->editColumn('created_at', function (Property $model) {
                return date_hour_ar($model->created_at);
            })

            ->editColumn('action', function (Property $model) {
                return view('admin.properties.table.action', compact('model'));
            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Property $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Property $model)
    {
        return $model->newQuery()
        ->with('owner', 'address')
        ->select('properties.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('properties-table')
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
            Column::make('name')->title('الاسم'),
            Column::make('owner')->title('المالك'),
            Column::make('address')->title('العنوان'),
            Column::make('is_special')->title('مميز'),
            Column::make('is_active')->title('جاهز للعرض'),
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
        return 'Properties_' . date('YmdHis');
    }
}
