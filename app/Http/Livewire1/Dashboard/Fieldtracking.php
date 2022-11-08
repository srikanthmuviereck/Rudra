<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Tables\supervisor_field_tracking;
use Livewire\Component;

class Fieldtracking extends Component
{

    public $check_uniform,$meet_client_update,$invoice_status,$night_check_update,$current_strength_details,$post_vacancy,$client_feedback,$day_visit_update,$guards_training,$guards_images , $trackid, $notes;

    protected $listeners = ['viewtrackdtls', 'deletetrackdtls'];

    public function render()
    {
        return view('livewire.dashboard.fieldtracking')->extends('layouts.main');
    }

    public function viewtrackdtls($obj)
    {
        // dd($obj['ftid']);

        $ftId = $obj['ftid'];        

        $viewTrackingdtls = supervisor_field_tracking::where('id', $ftId)->first();

// check_uniform
// meet_client_update
// invoice_status
// night_check_update
// current_strength_details
// post_vacancy
// client_feedback
// day_visit_update
// guards_training
// guards_images

        $this->check_uniform = $viewTrackingdtls->check_uniform;
        $this->meet_client_update = $viewTrackingdtls->meet_client_update;
        $this->invoice_status = $viewTrackingdtls->invoice_status;
        $this->night_check_update = $viewTrackingdtls->night_check_update;
        $this->current_strength_details = $viewTrackingdtls->current_strength_details;
        $this->post_vacancy = $viewTrackingdtls->post_vacancy;
        $this->client_feedback = $viewTrackingdtls->client_feedback;
        $this->day_visit_update = $viewTrackingdtls->day_visit_update;
        $this->guards_training = $viewTrackingdtls->guards_training;
		$this->notes = $viewTrackingdtls->notes;
        $this->guards_images = !empty($viewTrackingdtls->guards_images)?explode(',',$viewTrackingdtls->guards_images):'';

        $this->dispatchBrowserEvent('viewTrackDetails');

    }

    public function deletetrackdtls($obj)
    {
        // dd($obj['ftid']);
        $ftId = $obj['ftid'];
        $this->trackid = $obj['ftid'];

        // dd($this->ft_id);
        $this->dispatchBrowserEvent('deleteTrackDetails');
    }

    public function removeTrackDtls()
    {
        $ftId = $this->trackid;

        // dd($ftId);

        $delFT = supervisor_field_tracking::where('id', $ftId)->delete();

        session()->flash('ftMessage', 'Entry Deleted Successfully!');
        return redirect()->to('/fieldtracking');

    }

    public function closeModal()
    {
        $this->check_uniform = '';
        $this->meet_client_update = '';
        $this->invoice_status = '';
        $this->night_check_update = '';
        $this->current_strength_details = '';
        $this->post_vacancy = '';
        $this->client_feedback = '';
        $this->day_visit_update = '';
        $this->guards_training = '';
        $this->guards_images = '';
        $this->ft_id = '';
    }
}
