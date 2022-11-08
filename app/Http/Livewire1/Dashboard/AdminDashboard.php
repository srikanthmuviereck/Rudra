<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use DB;
use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;

class AdminDashboard extends Component
{
    public function render()
    {
        $security = securityModel::select('*')->orderBy('id','desc')->limit(5)->get();

        $supervisor = supervisorModel::select('*')->orderBy('id','desc')->limit(5)->get();

        $client = clientModel::select('*')->orderBy('id','desc')->limit(5)->get();

        $count_security = $security->count();
        $count_supervisor = $supervisor->count();
        $count_client = $client->count();

        return view('livewire.dashboard.admin-dashboard',['count_security'=>$count_security,'count_supervisor'=>$count_supervisor, 'count_client'=>$count_client, 'security'=> $security, 'supervisor' => $supervisor,'client'=>$client])->extends('layouts.main');
    }
}
