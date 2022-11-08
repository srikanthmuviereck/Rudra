<?php

namespace App\Http\Livewire\Powergrid\Reports;

use App\Models\Tables\clientModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class clntreportPG extends PowerGridComponent
{
    use ActionButton;

    public $userVal = 'Client';

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
            ->addColumn('userType', fn() => $this->userVal)
            ->addColumn('gender', fn (clientModel $model) => ucfirst($model->gender))
            ->addColumn('status', fn (clientModel $model) => ucfirst($model->status))
            ->addColumn('name_lower', fn (clientModel $model) => strtolower(e($model->name)))
            ->addColumn('created_at', fn (clientModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
            ->addColumn('created_at_formatted', fn (clientModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));
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
                ->searchable(),

            Column::make('Client ID', 'clnt_id')
                ->makeInputText('clnt_id')
                ->searchable('clnt_id'),
                //->sortable(),
                //->sortable(),

            Column::make('Client Name', 'c_name')
                ->makeInputText('name')
                ->searchable('name'),
                //->sortable(),

            Column::make('User Type', 'userType')
                ->makeInputText('userType')
                ->searchable('userType'),

            Column::make('Mobile', 'mobile')
                ->makeInputText('mobile')
                ->searchable('mobile'),
                //->sortable(),

            Column::make('Email', 'email')
                ->makeInputText('email')
                ->searchable('gender'),
                //->sortable(),
            Column::make('Gender', 'gender')
                ->makeInputText('gender')
                ->searchable(),
                //->sortable(),
            Column::make('Status', 'status')
                ->makeInputText('status')
                ->searchable('status'),
                //->sortable(),

            Column::make('Client Place', 'b_name')
                ->makeInputText('b_name')
                ->searchable('b_name'),
                //->sortable(),

            Column::make('Security Count', 'scrt_count')
                ->makeInputText('scrt_count')
                ->searchable('scrt_count'),
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
     * PowerGrid clientModel Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('client-model.edit', ['client-model' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('client-model.destroy', ['client-model' => 'id'])
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
                ->when(fn($client-model) => $client-model->id === 1)
                ->hide(),
        ];
    }
    */
}
