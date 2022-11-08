<?php

namespace App\Http\Livewire\Powergrid;

use App\Models\Tables\supervisor_field_tracking;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

use DB;

final class fieldtrackingPG extends PowerGridComponent
{
    use ActionButton;

    public bool $showUpdateMessages = true;
    public $index = 0;
    public $perPage=10;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public string $primaryKey = 'supervisor_field_trackings.id';

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
    * @return Builder<\App\Models\Tables\supervisor_field_tracking>
    */
    public function datasource(): Builder
    {
        return supervisor_field_tracking::query()
            ->leftjoin(DB::raw('
                (SELECT spvr_id, name as sp_name FROM supervisor) as supervisor
            '), function ($leftjoin) {
                $leftjoin->on('supervisor.spvr_id', '=', 'supervisor_field_trackings.user_id');
            })
            ->leftjoin(DB::raw('
                (SELECT building_id, b_name as bl_name FROM client) as client
            '), function ($leftjoin) {
                $leftjoin->on('client.building_id', '=', 'supervisor_field_trackings.building_id');
            })
            ->select('supervisor_field_trackings.*','client.bl_name', 'supervisor.sp_name');
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
            ->addColumn('name')
            ->addColumn('row',fn () => ++$this->index)
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (supervisor_field_tracking $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i:s A'));
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

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->makeInputDatePicker('created_at')
                ->searchable(),

            Column::make('RCS EMP ID', 'user_id')
                ->searchable()
                ->makeInputText('user_id')
                ->sortable(),

            Column::make('Operation Team Name', 'sp_name')
                ->searchable()
                ->makeInputText('sp_name')
                ->sortable(),

           //  Column::make('Building Id', 'building_id')
           //      ->searchable()
           //      ->makeInputText('building_id')
           //      ->sortable(),

            Column::make('Client Place', 'bl_name')
                ->searchable()
                ->makeInputText('bl_name')
                ->sortable(),
            
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
     * PowerGrid supervisor_field_tracking Action Buttons.
     *
     * @return array<int, Button>
     */

    // /*
    public function actions(): array
    {
       return [

            Button::make('view', '<i class="fa fa-eye"></i>')
                ->class('text-primary border-0 text-center mx-auto')
                ->emit('viewtrackdtls', ['ftid' => 'id']),

        //    Button::make('edit', '<i class="fa fa-pencil"></i>')
        //        ->class('text-primary bg-white border-0 text-center mx-auto button-edit')
        //        ->emit('editClient', ['clntid' => 'id']),

           Button::make('destroy', '<i class="fa fa-times"></i>')
               ->class('text-danger border-0 text-center mx-auto')
               ->emit('deletetrackdtls', ['ftid' => 'id'])
            //    ->method('delete')
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
     * PowerGrid supervisor_field_tracking Action Rules.
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
