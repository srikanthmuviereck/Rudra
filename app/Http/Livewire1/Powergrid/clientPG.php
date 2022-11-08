<?php

namespace App\Http\Livewire\Powergrid;

use App\Models\Tables\clientModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class clientPG extends PowerGridComponent
{
    use ActionButton;

    public bool $showUpdateMessages = true;
    public $index = 0;
    public $perPage=10;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public string $primaryKey = 'client.id';

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
    * @return Builder<\App\Models\Tables\clientModel>
    */
    public function datasource(): Builder
    {
        return clientModel::query();
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
            ->addColumn('created_at_formatted', fn (clientModel $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i:s A'));
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

            Column::make('ID', 'clnt_id')
                ->searchable()
                ->makeInputText('clnt_id')
                ->sortable(),

            Column::make('Name', 'c_name')
                ->searchable()
                ->makeInputText('c_name')
                ->sortable(),

            Column::make('Mobile', 'mobile')
                ->searchable()
                ->makeInputText('mobile')
                ->sortable(),

            Column::make('Email', 'email')
                ->searchable()
                ->makeInputText('email')
                ->sortable(),

            Column::make('Client Place', 'b_name')
                ->searchable()
                ->makeInputText('b_name')
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
     * PowerGrid clientModel Action Buttons.
     *
     * @return array<int, Button>
     */

    // /*
    public function actions(): array
    {
       return [

            Button::make('securitydata', '<i class="fa fa-eye"></i>')
                ->class('text-primary border-0 text-center mx-auto')
                ->emit('securitydata', ['buildid' => 'building_id']),

           Button::make('edit', '<i class="fa fa-pencil"></i>')
               ->class('text-primary bg-white border-0 text-center mx-auto button-edit')
               ->emit('editClient', ['clntid' => 'id']),

           Button::make('destroy', '<i class="fa fa-times"></i>')
               ->class('text-danger border-0 text-center mx-auto')
               ->emit('deleteClient', ['clntid' => 'id'])
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
     * PowerGrid clientModel Action Rules.
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
