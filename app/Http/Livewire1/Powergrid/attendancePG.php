<?php

namespace App\Http\Livewire\Powergrid;

use DB;
use App\Models\Tables\attendanceModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class attendancePG extends PowerGridComponent
{
    use ActionButton;

    public bool $showUpdateMessages = true;
    public $index = 0;
    public $perPage=10;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public string $primaryKey = 'attendance.id';

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
    * @return Builder<\App\Models\Tables\attendanceModel>
    */
    public function datasource(): Builder
    {
        return attendanceModel::query()
            ->join(DB::raw('(SELECT scrt_id,name, mobile FROM security) as security'), function ($join) {$join->on('security.scrt_id', '=', 'attendance.user_id');})
            ->leftjoin(DB::raw('(SELECT b_name, building_id FROM client) as client'), function ($leftjoin) {$leftjoin->on('client.building_id', '=', 'attendance.building_id');})
            ->leftjoin(DB::raw('(SELECT spvr_id, name as sup_name FROM supervisor) as supervisor'), function ($leftjoin1) {$leftjoin1->on('supervisor.spvr_id', '=', 'attendance.supervised_by');})
            ->select('attendance.*','security.name', 'security.mobile', 'supervisor.sup_name', 'client.b_name');
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
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('row',fn () => ++$this->index)
            ->addColumn('name')
            ->addColumn('created_at')
            ->addColumn('logout', function(attendanceModel $model){ 

                if($model->logout != '0000-00-00 00:00:00' && $model->logout != ''){
                    return Carbon::parse($model->logout)->format('d/m/Y h:i:s A');
                }else{
                    return 'Actively Working...';
                }
            
            })
            ->addColumn('logout_at_formatted', fn (attendanceModel $model) => Carbon::parse($model->logout)->format('d/m/Y h:i:s A'))
            ->addColumn('created_at_formatted', fn (attendanceModel $model) => Carbon::parse($model->login)->format('d/m/Y h:i:s A'));
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
                // ->sortable(),

            Column::make('RCS EMP Id', 'user_id')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Mobile', 'mobile')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Client Place', 'b_name')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::make('Operation Team', 'sup_name')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Login At', 'created_at_formatted', 'login')
                ->makeInputDatePicker('login')
                ->searchable(),

            Column::make('Logout at', 'logout')
                ->makeInputDatePicker('logout')
                ->searchable(),

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
     * PowerGrid attendanceModel Action Buttons.
     *
     * @return array<int, Button>
     */

    // /*
    public function actions(): array
    {
       return [

            // Button::make('edit', '<i class="fa fa-pencil"></i>')
            //    ->class('text-primary bg-white border-0 text-center mx-auto button-edit')
            // //    ->route('banner.edit', ['banner' => 'id']),
            //     ->emit('editAttendance', ['id'=>'id']),

            Button::make('destroy', '<i class="fa fa-times"></i>')
               ->class('text-danger border-0 text-center mx-auto')
               ->emit('deleteAttendance', ['attid' => 'id'])
        ];
    }
    // */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid attendanceModel Action Rules.
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
