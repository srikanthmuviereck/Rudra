<?php

namespace App\Http\Livewire\Powergrid;

use Illuminate\Http\Request;
use App\Providers\Functions\hashValues;
use DB;

use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;

use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class reportsPG extends PowerGridComponent
{
    use ActionButton;

    public $fd, $td, $cat, $userVal = 'Security';

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

        if(!empty(request()->for)){

            // dd(hashValues::secured_decrypt(request()->f_date));

            $this->fd = date('Y-m-d H:i:s', strtotime(request()->f_date));
            $this->td = date('Y-m-d H:i:s', strtotime(request()->t_date));
            $this->cat = request()->for;

            $this->userVal = ($this->cat == 'all')?'Security':(($this->cat == 'client')?'Client':(($this->cat == 'operationteam')?'Operation Team':''));


            if($this->cat == 'all'){

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
                    ->select('security.*','supervisor.sp_name', 'client.bl_name')->where('security.created_at', '>=',$this->fd)
                    ->where('security.created_at', '<=',$this->td);

            }elseif($this->cat == 'operationteam'){

                // dd(1);

                return supervisorModel::query()
                    ->select('supervisor.*')->where('supervisor.created_at', '>=',$this->fd)
                    ->where('supervisor.created_at', '<=',$this->td);

            }else{

                // dd($this->userVal);
                
                return clientModel::query()
                    ->select('client.*')->where('client.created_at', '>=',$this->fd)
                    ->where('client.created_at', '<=',$this->td);

            }

        }else{

            return securityModel::query();
        
        }

        
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
    |--------------------------------------------------------------------------
    */


    public function addColumns(): PowerGridEloquent
    {

        if(!empty(request()->for)){

            // dd(hashValues::secured_decrypt(request()->f_date));

            $this->cat = request()->for;

            $this->userVal = ($this->cat == 'all')?'Security':(($this->cat == 'client')?'Client':(($this->cat == 'operationteam')?'Operation Team':''));


            if($this->cat == 'all'){

                return PowerGrid::eloquent()
                    ->addColumn('id')
                    ->addColumn('row',fn () => ++$this->index)
                    ->addColumn('name', fn (securityModel $model) => $model->name)
                    ->addColumn('scrt_id')
                    ->addColumn('userType', fn() => $this->userVal)
                    ->addColumn('gender', fn (securityModel $model) => ucfirst($model->gender))
                    ->addColumn('status', fn (securityModel $model) => ucfirst($model->status))
                    ->addColumn('created_at', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
                    ->addColumn('created_at_formatted', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));

            }elseif($this->cat == 'operationteam'){

                return PowerGrid::eloquent()
                    ->addColumn('id')
                    ->addColumn('row',fn () => ++$this->index)
                    ->addColumn('name', fn (supervisorModel $model) => $model->name)
                    ->addColumn('spvr_id')
                    ->addColumn('userType', fn() => $this->userVal)
                    ->addColumn('gender', fn (supervisorModel $model) => ucfirst($model->gender))
                    ->addColumn('status', fn (supervisorModel $model) => ucfirst($model->status))
                    ->addColumn('created_at', fn (supervisorModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
                    ->addColumn('created_at_formatted', fn (supervisorModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));

            }else{

                return PowerGrid::eloquent()
                    ->addColumn('id')
                    ->addColumn('row',fn () => ++$this->index)
                    ->addColumn('name', fn (clientModel $model) => $model->c_name)
                    ->addColumn('clnt_id')
                    ->addColumn('userType', fn() => $this->userVal)
                    ->addColumn('gender', fn (clientModel $model) => ucfirst($model->gender))
                    ->addColumn('status', fn (clientModel $model) => ucfirst($model->status))
                    ->addColumn('created_at', fn (clientModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
                    ->addColumn('created_at_formatted', fn (clientModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));

            }

        }else{
            return PowerGrid::eloquent()
                ->addColumn('id')
                ->addColumn('row',fn () => ++$this->index)
                ->addColumn('name', fn (securityModel $model) => $model->name)
                ->addColumn('scrt_id')
                ->addColumn('userType', fn() => $this->userVal)
                ->addColumn('gender', fn (securityModel $model) => ucfirst($model->gender))
                ->addColumn('status', fn (securityModel $model) => ucfirst($model->status))
                ->addColumn('created_at', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'))
                ->addColumn('created_at_formatted', fn (securityModel $model) => Carbon::parse($model->created_at)->format('d-m-Y h:i:s A'));
        }
        
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

        if(!empty(request()->for)){
            $this->cat = request()->for;
            

            if($this->cat == 'all'){

                return [
                    Column::make('S.No', 'id')
                        ->field('row')
                        ->searchable()
                        ->visibleInExport(false),

                    Column::make('Created at', 'created_at')
                        ->makeInputDatePicker('created_at')
                        ->searchable(),

                    Column::make('RCS EMP ID', 'scrt_id')
                        ->makeInputText('scrt_id')
                        ->searchable('scrt_id'),
                        //->sortable(),

                    Column::make('User Type', 'userType')
                        ->makeInputText('userType')
                        ->searchable('userType'),
                        //->sortable(),

                    Column::make('Name', 'name')
                        ->makeInputText('name')
                        ->searchable('name'),
                        //->sortable(),

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

            }elseif($this->cat == 'operationteam'){


                return [
                    Column::make('S.No', 'id')
                        ->field('row')
                        ->searchable()
                        ->visibleInExport(false),

                    Column::make('Created at', 'created_at')
                        ->makeInputDatePicker('created_at')
                        ->searchable(),

                    Column::make('RCS EMP ID', 'spvr_id')
                        ->makeInputText('spvr_id')
                        ->searchable('spvr_id'),
                        //->sortable(),

                    Column::make('User Type', 'userType')
                        ->makeInputText('userType')
                        ->searchable('userType'),
                        //->sortable(),

                    Column::make('Name', 'name')
                        ->makeInputText('name')
                        ->searchable('name'),
                        //->sortable(),

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
                    Column::make('Status', 'status')
                        ->makeInputText('status')
                        ->searchable('status'),
                        //->sortable(),

                    Column::make('Created at', 'created_at')
                        ->hidden(),

                    
                ];

            }else{

                return [
                    Column::make('S.No', 'id')
                        ->field('row')
                        ->searchable()
                        ->visibleInExport(false),

                    Column::make('Created at', 'created_at')
                        ->makeInputDatePicker('created_at')
                        ->searchable('created_at'),

                    Column::make('Client ID', 'clnt_id')
                        ->makeInputText('clnt_id')
                        ->searchable('clnt_id'),
                        //->sortable(),

                    Column::make('User Type', 'userType')
                        ->makeInputText('userType')
                        ->searchable('userType'),
                        //->sortable(),

                    Column::make('Client Name', 'name')
                        ->makeInputText('name')
                        ->searchable('name'),
                        //->sortable(),

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

        }else{

            return [
                Column::make('S.No', 'id')
                    ->field('row')
                    ->searchable()
                    ->visibleInExport(false),

                Column::make('Created at', 'created_at')
                    ->makeInputDatePicker('created_at')
                    ->searchable(),

                Column::make('RCS EMP ID', 'scrt_id')
                    ->makeInputText('scrt_id')
                    ->searchable('scrt_id'),
                        //->sortable(),

                Column::make('User Type', 'userType')
                    ->makeInputText('userType')
                    ->searchable('userType'),
                        //->sortable(),

                Column::make('Name', 'name')
                    ->makeInputText('name')
                    ->searchable('name'),
                        //->sortable(),

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
                Column::make('Status', 'status')
                    ->makeInputText('status')
                    ->searchable('status'),
                        //->sortable(),

                Column::make('Created at', 'created_at')
                    ->hidden(),
                
            ];

        }
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

    
    // public function actions(): array
    // {
    //    return [

    //         Button::make('edit', '<i class="fa fa-pencil"></i>')
    //            ->class('text-primary bg-white border-0 text-center mx-auto button-edit')
    //            ->emit('editSecurity', ['id' => 'id']),

    //        Button::make('destroy', '<i class="fa fa-times"></i>')
    //            ->class('text-danger border-0 text-center mx-auto')
    //            ->emit('deleteSecurity', ['id' => 'id'])
    //     ];
    // }
    

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

