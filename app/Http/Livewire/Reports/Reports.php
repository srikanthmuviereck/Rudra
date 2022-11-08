<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;

class Reports extends Component
{

    public $tab = 'secreport';

    public function render()
    {
        return view('livewire.reports.reports')->extends('layouts.main');
    }
}
