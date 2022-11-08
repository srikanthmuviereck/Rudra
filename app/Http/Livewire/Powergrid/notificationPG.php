<?php

namespace App\Http\Livewire\Powergrid;

use App\Models\Tables\notificationModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class notificationPG extends PowerGridComponent
{
    use ActionButton;

    public bool $showUpdateMessages = true;
    public $index = 0;
    public $perPage=10;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public string $primaryKey = 'notification.id';

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
    * @return Builder<\App\Models\Tables\notificationModel>
    */
    public function datasource(): Builder
    {
        return notificationModel::query();
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
            ->addColumn('user_type', function (notificationModel $model){
                return ucfirst($model->user_type);
            })
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (notificationModel $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i:s A'));
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

            Column::make('Title', 'title')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Message', 'message')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Type', 'type')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::make('Send To', 'user_type')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            
            // Column::make('Client Name', 's_name')
            //     ->searchable()
            //     ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->searchable()
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
     * PowerGrid notificationModel Action Buttons.
     *
     * @return array<int, Button>
     */

    // /*
    public function actions(): array
    {
       return [
        //    Button::make('edit', 'Edit')
        //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
        //        ->route('notification-model.edit', ['notification-model' => 'id']),

            Button::make('destroy', '<i class="fa fa-times"></i>')
            ->class('text-danger border-0 text-center mx-auto')
            ->emit('deleteNotify', ['id' => 'id'])
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
     * PowerGrid notificationModel Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($notification-model) => $notification-model->id === 1)
                ->hide(),
        ];
    }
    */
}
