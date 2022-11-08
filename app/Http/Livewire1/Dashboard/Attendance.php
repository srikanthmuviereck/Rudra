<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use App\Models\Tables\attendanceModel;

class Attendance extends Component
{

    public $att_id;

    protected $listeners = ['deleteAttendance'];

    public function render()
    {
        return view('livewire.dashboard.attendance')->extends('layouts.main');
    }

    public function deleteAttendance($obj)
    {
        $attid = $obj['attid'];
        $this->att_id  = $attid;
        $this->dispatchBrowserEvent('attendanceDelete');
    }

    public function removeAttendance()
    {
        attendanceModel::where('id', $this->att_id)->delete();
        $this->closeModal();
        session()->flash('attendanceMessage', 'Attendance Deleted successfully!');
        return redirect()->to('/attendance');
    }

    public function closeModal()
    {
        $this->resetErrorBag();

        $this->att_id = '';
        
    }
}
