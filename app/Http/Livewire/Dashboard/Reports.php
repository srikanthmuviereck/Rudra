<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use DB;
use Illuminate\Support\Facades\Hash;

use App\Providers\Functions\hashValues;

use Carbon\Carbon;

class Reports extends Component
{   
    public $sf_date,$st_date,$st_cat;

    public $tab = 'scrt';

    public $getSecData = [];

    protected $rules = [

        'sf_date' => 'required',
        'st_date' => 'required',
        'st_cat' => 'required',

    ];

    protected $messages = [
        'sf_date.required' => 'This Field is Mandatory',
        'st_date.required' => 'This Field is Mandatory',
        'st_cat.required' => 'This Field is Mandatory',
    ];

    public function mount()
    {
        $getData = securityModel::
            leftjoin(DB::raw('
                (SELECT spvr_id, name as sp_name FROM supervisor) as supervisor
            '), function ($join) {
                $join->on('security.supervised_by', '=', 'supervisor.spvr_id');
            })
            ->leftjoin(DB::raw('
                (SELECT building_id, b_name as bl_name FROM client) as client
            '), function ($join1) {
                $join1->on('security.building_id', '=', 'client.building_id');
            })
            ->select('security.*', 'supervisor.sp_name', 'client.bl_name')->orderByDesc('security.id')->get();

        $this->getSecData = $getData;
    }

    public function render()
    {

        // $getSec = securityModel::get();

        if(!empty(request()->for)){
            $this->sf_date = request()->f_date;
            $this->st_date = request()->t_date;
            $this->st_cat = request()->for; 
        }
        
        return view('livewire.dashboard.reports')->extends('layouts.main');
    }

    public function sbmt_scrtForm()
    {
        // dd(1);

        $this->validate();

        $wCat = $this->st_cat;

        $fDate = $this->sf_date;
        $tDate = $this->st_date;

        return redirect()->route('reports.filter',['for'=> $wCat, 'f_date' => $fDate, 't_date' => $tDate]);

        // dd($this->sf_date.'-'.$this->st_date.'-'.$this->st_cat);

    }
    

}

