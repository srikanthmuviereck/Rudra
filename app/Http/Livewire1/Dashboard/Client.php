<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Tables\clientModel;
use App\Models\Tables\securityModel;

use DB;

use Hash;

class Client extends Component
{

    public $c_name, $c_email, $c_mobile, $c_pass, $c_gen,$secData=[], $c_buildname, $cb_area, $cb_city;
    public $cb_state, $cb_pin, $cb_addr, $c_sts, $clnt_id, $crep_name, $latitude, $longitude, $bl_lat = "0.0", $bl_lng  = "0.0";

    protected $rules = [
        'c_name' =>'required|min:4',
        'c_email' =>'nullable|email',
        'c_mobile' =>'required|numeric|digits:10',
        'c_pass' =>'nullable|min:4',
        'c_buildname' =>'required|min:4',
        'cb_area' => 'nullable|min:4',
        'cb_city' => "nullable|min:5",
        'cb_state' =>'nullable|min:5',
        'cb_pin' => "nullable|min:5",
        'cb_addr' => "nullable|min:5",
        'c_sts' =>'required',
		'latitude' => 'required',
        'crep_name' => "nullable|min:3",
    ];

    protected $messages = [
        'c_name.required' => 'This Field is Mandatory',
        'c_mobile.required' => 'This Field is Mandatory',
        'c_pass.required' => 'This Field is Mandatory',
        'c_buildname.required' => 'This Field is Mandatory',
        'c_sts.required' => 'This Field is Mandatory',
		'latitude.required' => 'This Field is Mandatory',
    ];

    protected $listeners = ['editClient','deleteClient', 'securitydata'];

    public function render()
    {
        return view('livewire.dashboard.client')->extends('layouts.main');
    }

    public function addnewClient()
    {

        $this->validate();
		
		$mble = $this -> c_mobile;

        $chkMble = clientModel::where('mobile',$mble)->get();

        if($chkMble->count() > 0){
            session()->flash('dangerMessage','Mobile Number Already Exists!');
            $this->closeModal();
            return redirect()->to('client');
        } 
        
        $eml = $this -> c_email;

        $chkEmail = clientModel::where('email',$eml)->get();

        if(!empty($eml) && $chkEmail->count() > 0){
            session()->flash('dangerMessage','Email Already Exists!');
            $this->closeModal();
            return redirect()->to('client');
        } 

        // dd(12);

        $tmp_id = rand(1000,8989);

        $clntId = 'TMPCL'.$tmp_id;
        $buldId = 'TMPBL'.$tmp_id;

        // dd($clntId);

        $insClnt = [
            'clnt_id' => $clntId,
            'c_name' => $this->c_name,
            'email' => $this->c_email,
            'mobile' => $this->c_mobile,
			'password' => Hash::make($this->c_pass),
            'gender' => $this->c_gen,
            'building_id' => $buldId,
            'b_name' => $this->c_buildname,
            'area' => $this->cb_area,
            'city' => $this->cb_city,
            'state' => $this->cb_state,
            'pin' => $this->cb_pin,
            'address' => $this->cb_addr,
            'status' => $this->c_sts,
            'api_token' => md5($tmp_id),
			'bl_lat' => $this->bl_lat,
            'bl_lng' => $this->bl_lng,
            'rep_name' => $this->crep_name
        ];

        $insGetId = clientModel::insertGetId($insClnt);

        if($insGetId > 0){

            $clId ='RCCL'.str_pad($insGetId, 5, "0", STR_PAD_LEFT);
            $blId ='RCBL'.str_pad($insGetId, 5, "0", STR_PAD_LEFT);

            $updClnt = [
                'clnt_id' => $clId,
                'building_id' => $blId,
            ];

            clientModel::where('id', $insGetId)->update($updClnt);
            session()->flash('clientMessage', 'Client Added Successfully!');
            return redirect()->to('/client');

        }else{
            session()->flash('clientMessage', 'Client Added Failed!');
            return redirect()->to('/client');
        }
    }

    public function editClient($obj)
    {
        // dd($obj);
        $cid = $obj['clntid'];
        $this->clnt_id = $cid;
		
		

        $getClDtl = clientModel::where('id', $cid)->get();

        foreach($getClDtl as $clDtls){

            $c_name = $clDtls->c_name;
            $email = $clDtls->email;
            $mobile = $clDtls->mobile;
            $password = $clDtls->password;
            $gender = $clDtls->gender;
            $building_id = $clDtls->building_id;
            $b_name = $clDtls->b_name;
            $area = $clDtls->area;
            $city = $clDtls->city;
            $state = $clDtls->state;
            $pin = $clDtls->pin;
            $address = $clDtls->address;
            $status = $clDtls->status;
			$bl_lat = !empty($clDtls->bl_lat)?$clDtls->bl_lat:'0.0';
            $bl_lng = !empty($clDtls->bl_lng)?$clDtls->bl_lng:'0.0';
            $rep_name = !empty($clDtls->rep_name)?$clDtls->rep_name:'';


        }

        $this->c_name = $c_name;
        $this->c_email = $email;
        $this->c_mobile = $mobile;
        // $this->c_pass = $password;
        $this->c_gen = $gender;
        $this->buldId = $building_id;
        $this->c_buildname = $b_name;
        $this->cb_area = $area;
        $this->cb_city = $city;
        $this->cb_state = $state;
        $this->cb_pin = $pin;
        $this->cb_addr = $address;
        $this->c_sts = $status;
        $this->crep_name = $rep_name;
		
		$this->dispatchBrowserEvent('clientEdit',['latitude' => $bl_lat, 'longitude' => $bl_lng]);

        $this->dispatchBrowserEvent('clientEditModal');

    }

    public function updateClient()
    {
		$this->validate();

        $clntId = $this->clnt_id;
		
		$mble = $this -> c_mobile;

        $chkMble = clientModel::where('mobile',$mble)->where('id', '!=', $clntId)->get();

        if($chkMble->count() > 0){
            session()->flash('dangerMessage','Mobile Number Already Exists!');
            $this->closeModal();
            return redirect()->to('client');
        } 
        
        $eml = $this -> c_email;

        $chkEmail = clientModel::where('email',$eml)->where('id', '!=', $clntId)->get();

        if(!empty($eml) && $chkEmail->count() > 0){
            session()->flash('dangerMessage','Email Already Exists!');
            $this->closeModal();
            return redirect()->to('client');
        } 

        $updClnt = [
            'c_name' => $this->c_name,
            'email' => $this->c_email,
            'mobile' => $this->c_mobile,
            'gender' => $this->c_gen,
            'b_name' => $this->c_buildname,
            'area' => $this->cb_area,
            'city' => $this->cb_city,
            'state' => $this->cb_state,
            'pin' => $this->cb_pin,
            'address' => $this->cb_addr,
            'status' => $this->c_sts,
			'bl_lat' => $this->latitude,
            'bl_lng' => $this->longitude,
            'rep_name' => $this->crep_name
        ];

        if(isset($this->c_pass)){
            $updClnt['password'] = Hash::make($this->c_pass);
        }
		
		if($this->c_sts == 'inactive'){
			$updClnt['fcm_id'] = '';
			$updClnt['api_token'] = '';
		}

        $updateClient = clientModel::where('id', $clntId)->update($updClnt);
        session()->flash('clientMessage', 'Client Updated Successfully!');
        return redirect()->to('/client');
        
    }

    public function deleteClient($obj)
    {
        $clntid = $obj['clntid'];
        $this->clnt_id  = $clntid;
        $this->dispatchBrowserEvent('clientDeleteModal');
    }

    public function removeClient()
    {
        clientModel::where('id', $this->clnt_id)->delete();
        session()->flash('clientMessage', 'Client Deleted Successfully!');
        return redirect()->to('/client');
    }
	
	public function securitydata($obj){

        $clientId = $obj['buildid'];

        $getSecData = securityModel::
            leftjoin(DB::raw('
                (SELECT building_id,name as s_name FROM supervisor) as supervisor
            '), function ($join) {
                $join->on('security.building_id', '=', 'supervisor.building_id');
            })->select('security.*', 'supervisor.s_name')->where('assign', 'A')->where('security.building_id', $clientId)->get();

            // dd(json_decode($getSecData));

$this->secData=[];
        $this->secData = json_decode($getSecData);

        $this->dispatchBrowserEvent('securityview');
        
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        
        $this->clnt_id = '';

        $this->c_name = '';
        $this->c_email = '';
        $this->c_mobile = '';
        $this->password = '';
        $this->c_gen = '';
        $this->buldId = '';
        $this->c_buildname = '';
        $this->cb_area = '';
        $this->cb_city = '';
        $this->cb_state = '';
        $this->cb_pin = '';
        $this->cb_addr = '';
        $this->c_sts = '';
		$this->crep_name = '';
    }
}
