<?php

namespace App\Http\Livewire\Powergrid\Reports;

use App\Models\Tables\securityModel;

use DB;

use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class secreportPG extends PowerGridComponent
{
    use ActionButton;

    public $userVal = 'Security';

    public bool $showUpdateMessages = true;
    public $index = 0;
    public $perPage=10;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';
  	public string $primaryKey = 'security.id';

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\Tables\securityModel>
    */
    public function datasource(): Builder
    {
        return securityModel::query()
            ->leftjoin(DB::raw('
                (SELECT supervisor.spvr_id,supervisor.name as sp_name  FROM supervisor) as supervisor
            '), function ($leftjoin1) {
                $leftjoin1->on('supervisor.spvr_id', '=', 'security.supervised_by');
            })
            ->leftjoin(DB::raw('
                (SELECT client.building_id, client.c_name as cl_name,client.b_name as bl_name  FROM client) as client
            '), function ($leftjoin1) {
                $leftjoin1->on('client.building_id', '=', 'security.building_id');
            })
            ->select('security.*','supervisor.sp_name', 'client.bl_name', 'client.cl_name');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
		$setups = (array) $this->setUp["footer"];
        $this->perPage = $setups["perPage"];
        $this->index = $this->page > 1 ? ($this->page - 1) * $this->perPage : 0;
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('row',fn () => ++$this->index)
            ->addColumn('name')
            ->addColumn('gender', fn (securityModel $model) => ucfirst($model->gender))
            ->addColumn('status', fn (securityModel $model) => ucfirst($model->status))
            ->addColumn('usertype', fn () => $this->userVal)
            ->addColumn('name_lower', fn (securityModel $model) => strtolower(e($model->name)))
            ->addColumn('created_at', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
            ->addColumn('created_at_formatted', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('S.No', 'id')
                ->field('row')
                ->searchable()
                ->visibleInExport(false),

           Column::make('Created at', 'created_at_formatted', 'created_at')
                ->makeInputDatePicker('created_at')
                ->searchable('created_at'),

            Column::make('RCS EMP ID', 'scrt_id')
                ->makeInputText('scrt_id')
                ->searchable('scrt_id'),
                //->sortable(),
                //->sortable(),

            Column::make('Name', 'name')
                ->makeInputText('name')
                ->searchable('name'),
                //->sortable(),

            Column::make('User Type', 'usertype')
                ->makeInputText('usertype')
                ->searchable('usertype'),

            Column::make('Mobile', 'mobile')
                ->makeInputText('mobile')
                ->searchable('mobile'),
                //->sortable(),

            Column::make('Email', 'email')
                ->makeInputText('email')
                ->searchable('email'),
                //->sortable(),
            Column::make('Gender', 'gender')
                ->makeInputText('gender')
                ->searchable('gender'),
                //->sortable(),

            Column::make('Area', 'area')
                ->makeInputText('area')
                ->searchable('area'),
            Column::make('City', 'city')
                ->makeInputText('city')
                ->searchable('city'),

            Column::make('State', 'state')
                ->makeInputText('state')
                ->searchable('state'),

            Column::make('Address', 'address')
                ->makeInputText('address')
                ->searchable('address'),

            Column::make('Pin', 'pin')
                ->makeInputText('pin')
                ->searchable('pin'),

            Column::make('Adhaar No', 'adhaarno')
                ->makeInputText('adhaarno')
                ->searchable('adhaarno'),

            Column::make('Pan No', 'panno')
                ->makeInputText('panno')
                ->searchable('panno'),
            
            Column::make('Status', 'status')
                ->makeInputText('status')
                ->searchable('status'),
                //->sortable(),

            Column::make('supervised_by', 'sp_name')
                ->makeInputText('sp_name')
                ->searchable('sp_name'),
                //->sortable(),

            Column::make('Client Name', 'cl_name')
                ->makeInputText('cl_name')
                ->searchable('cl_name'),

            Column::make('Client Place', 'bl_name')
                ->makeInputText('bl_name')
                ->searchable('bl_name'),
                //->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid securityModel Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('security-model.edit', ['security-model' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('security-model.destroy', ['security-model' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid securityModel Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($security-model) => $security-model->id === 1)
                ->hide(),
        ];
    }
    */
}
