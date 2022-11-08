<?php

namespace App\Http\Livewire\Powergrid;

use App\Models\Tables\securityModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class securitiesPG extends PowerGridComponent
{
    use ActionButton;

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
        return securityModel::query();
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
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('row',fn () => ++$this->index)
            ->addColumn('name')
            ->addColumn('gender', fn (securityModel $model) => ucfirst($model->gender))
            ->addColumn('status', fn (securityModel $model) => ucfirst($model->status))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i:s A'));
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
                ->makeInputDatePicker()
                ->searchable(),

            Column::make('RCS EMP ID', 'scrt_id')
                ->makeInputText('scrt_id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->makeInputText('name')
                ->searchable()
                ->sortable(),

            Column::make('Mobile', 'mobile')
                ->makeInputText('mobile')
                ->searchable()
                ->sortable(),

            Column::make('Email', 'email')
                ->makeInputText('email')
                ->searchable()
                ->sortable(),
            Column::make('Gender', 'gender')
                ->makeInputText('gender')
                ->searchable()
                ->sortable(),

            Column::make('Client Id', 'clnt_id')
                ->makeInputText('clnt_id')
                ->searchable()
                ->sortable(),

            Column::make('Location', 'location')
                ->makeInputText('location')
                ->searchable()
                ->sortable(),
            Column::make('Status', 'status')
                ->makeInputText('status')
                ->searchable()
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
     * PowerGrid securityModel Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [

            Button::make('edit', '<i class="fa fa-pencil"></i>')
               ->class('text-primary bg-white border-0 text-center mx-auto button-edit')
               ->emit('editSecurity', ['id' => 'id']),

           Button::make('destroy', '<i class="fa fa-times"></i>')
               ->class('text-danger border-0 text-center mx-auto')
               ->emit('deleteSecurity', ['id' => 'id'])
        ];
    }
    

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
