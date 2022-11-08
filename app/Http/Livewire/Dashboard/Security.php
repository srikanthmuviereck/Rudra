<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Tables\securityModel;
use App\Models\Tables\tracklocModel;

use DB;
use Hash;

use Carbon\Carbon;

class Security extends Component
{

    public $scrt_id,$name,$email,$mobile,$gender,$area,$city,$state,$address,$pin,$status,$password,$supervised_by,$ids, $sec_id, $secdate, $latitude, $longitude, $trackdtl,$panno, $adhaarno,$bankname,$bankacno,$ifsccode, $scrtVal, $location, $clnt_id,$search_customer,$dropdown,$customer_dropdown1,$search_customer1, $uan,$esino;

    public $trackMap = false;

    protected $listeners = ['editSecurity','deleteSecurity'];

    protected $rules = [
        'name' =>'required|min:5',
        'email' =>'nullable|email',
        'mobile' =>'required|numeric|digits:10',
        'address' =>'required|min:5',            
        'status' =>'required',
        'password' => 'nullable|min:4',
        'supervised_by' =>'required',
        'area' => "nullable|min:5",
        'city' =>'nullable|min:5',
        'state' => "nullable|min:5",
        'pin' => "nullable|numeric|digits:6",
		'bankname' => "nullable|min:3",
        'bankacno' => "nullable|min:3",
        'ifsccode' => "nullable|min:3",
        'panno' => "nullable",
        'adhaarno' => "nullable",
        'location' => 'nullable|min:4',
		'clnt_id' => 'nullable|min:4',
        'uan' => 'nullable|min:4',
        'esino' => 'nullable|min:4',
    ];

    protected $messages = [
        'name.required'=> 'This Field is Mandatory',
        'email.required'=> 'This Field is Mandatory',
        'mobile.required'=> 'This Field is Mandatory',
        'address.required'  => 'This Field is Mandatory',
        'status.required'=> 'This Field is Mandatory',
        'password.required'=> 'This Field is Mandatory',
        'supervised_by.required'=> 'This Field is Mandatory',
    ];

    public function render()
    {

           $h= DB::table('supervisor')->select('*')->where('name', 'like', '%' . $this->search_customer1 . '%')
      ->get();
      $this->h=$h;
      //dd($h);
        $supervisor = DB::table('supervisor')->select('*')->get();

        return view('livewire.dashboard.security',['supervisors'=>$supervisor])->extends('layouts.main');
    }
    public $select_id;
      public function customer_selected1($val,$id){
    //dd($id);
         // dd($val,$id);
    $this->supervised_by=$val;
    $this->select_id=$id;

    $this->dropdown = !$this->dropdown;
    
  }
  public function customer_dropdown1()
    {
        $this->dropdown = !$this->dropdown;
    }
    public function store(){

        $this->validate();

        $api_token = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

        $tmpId = 'TMPSC'.rand(1000,8989);
		
		$mble = $this -> mobile;

        $chkMble = securityModel::where('mobile',$mble)->get();

        if($chkMble->count() > 0){
            // $this->addError('check', 'Mobile Number Already Exists.');

            session()->flash('dangerMessage','Mobile Number Already Exists!');
            $this->closeModal();
            return redirect()->to('securities');
        } 
        
        $eml = $this -> email;

        $chkEmail = securityModel::where('email',$eml)->get();

        if(!empty($eml) && $chkEmail->count() > 0){
            // $this->addError('check', 'Mobile Number Already Exists.');

            session()->flash('dangerMessage','Email Already Exists!');
            $this->closeModal();
            return redirect()->to('securities');
        } 

        $insertSec = [
            'scrt_id' =>$tmpId,
            'name' => $this -> name,
            'email' => $this -> email,
            'mobile' => $this -> mobile,
            'address' =>$this -> address,
            'gender' => $this -> gender,
            'area' => $this -> area,
            'city' => $this -> city,
            'state' => $this -> state,
            'state' => $this -> address,
            'pin' => $this -> pin,
            'status' => $this -> status,
            'password' => Hash::make($this->password),
            'supervised_by' => $this ->select_id,
            'fcm_id' => '',
            'device_name' => '',
            'device_model' => '',
            'os_version' => '',
            'latitude' => '',
            'longitude' => '',
            'building_id' => '',
            'assign' => 'U',
            'api_token' => $api_token,
			'bankname' => $this->bankname,
            'bankacno' => $this->bankacno,
            'ifsccode' => $this->ifsccode,
            'panno' => $this->panno,
            'adhaarno' => $this->adhaarno,
            'location' => $this->location,
			'clnt_id' => $this->clnt_id,
            'uan' => $this->uan,
            'esino' => $this->esino,
        ];
        
        $insSec = securityModel::insertGetId($insertSec);

        if($insSec > 0){

            $secId ='RCS'.str_pad($insSec, 5, "0", STR_PAD_LEFT);

            $updSec = [
                'scrt_id' => $secId,
            ];

            securityModel::where('id', $insSec)->update($updSec);
            session()->flash('securityMessage','Security Added sucessfully');

        }else{
            session()->flash('securityMessage','Security Added failed');
        }
        
        $this->closeModal();
        return redirect()->to('securities');
    }

    public function editSecurity($id){
		
		//dd($id);
		
		$sid = $id['id'];//dd($sid);

        $security=securityModel::leftjoin('supervisor', 'supervisor.spvr_id', '=', 'security.supervised_by')
           ->select('security.*','supervisor.name  as supervisor_name')->where('security.id',$sid)->first();
//dd($security);
        $this->sec_id = $sid;
        $this->scrt_id = $security->scrt_id;
        $this->name = $security->name;
        $this->address = $security->address;
        $this->email = $security->email;
        $this->mobile = $security->mobile;
        $this->gender = $security->gender;
        $this->area = $security->area;
        $this->city = $security->city;
        $this->state = $security->state;
        $this->address = $security->address;
        $this->pin = $security->pin;
        $this->status = $security->status;
        $this->supervised_by = $security->supervisor_name;
        $this->select_id = $security->supervised_by;
        // dd($security->select_id);
        // dd($this->supervised_by);
		$this->bankname = $security->bankname;
        $this->bankacno = $security->bankacno;
        $this->ifsccode = $security->ifsccode;
        $this->panno = $security->panno;
        $this->adhaarno = $security->adhaarno;
        $this->location = $security->location;
		$this->clnt_id = $security->clnt_id;
        $this->uan = $security->uan;
        $this->esino = $security->esino;

        $this->dispatchBrowserEvent('securityEdit');
    }

    public function update(){

        $this->validate();

        $sId = $this->sec_id;
		
		$mble = $this -> mobile;

        $chkMble = securityModel::where('mobile',$mble)->where('id', '!=', $sId)->get();

        if($chkMble->count() > 0){
            session()->flash('dangerMessage','Mobile Number Already Exists!');
            $this->closeModal();
            return redirect()->to('securities');
        } 
        
        $eml = $this -> email;

        $chkEmail = securityModel::where('email',$eml)->where('id', '!=', $sId)->get();

        if(!empty($eml) && $chkEmail->count() > 0){
            session()->flash('dangerMessage','Email Already Exists!');
            $this->closeModal();
            return redirect()->to('securities');
        } 

        $updSecdtls = [
            'name' =>  $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'gender' => $this->gender,
            'area' => $this->area,
            'city' => $this->city,
            'state' => $this->state,
            'address' => $this->address,
            'pin' => $this->pin,
            'status' => $this->status,
            'supervised_by' => $this->select_id,
			'bankname' => $this->bankname,
            'bankacno' => $this->bankacno,
            'ifsccode' => $this->ifsccode,
            'panno' => $this->panno,
            'adhaarno' => $this->adhaarno,
            'location' => $this->location,
			'clnt_id' => $this->clnt_id,
            'uan' => $this->uan,
            'esino' => $this->esino,
        ];

        if(isset($this->password)){
            $updSecdtls['password'] = Hash::make($this->password);
        }
		
		if($this->status == 'inactive'){
			$updSecdtls['fcm_id'] = '';
			$updSecdtls['api_token'] = '';
		}

        securityModel::where('id', $sId)->update($updSecdtls);

        session()->flash('securityMessage','Security updated successfully');
        $this->closeModal();
        return redirect()->to('securities');
    }

    public function deleteSecurity($obj)
    {
        $this->sec_id = $obj['id'];
        $this->dispatchBrowserEvent('securityDelete');
    }
    public function removeSecurity()
    {
        DB::table('security')->where('id', $this->sec_id)->delete();
        session()->flash('securityMessage', 'Security Delete successfully!');
        return redirect()->to('securities');
    }


    public function securityTracker()
    {

        $this->validate([
            'secdate' => 'required'
        ]);

        $getDate = date('Y-m-d H:i:s', strtotime($this->secdate));
        $dtlDate1 = Carbon::createFromFormat('Y-m-d H:i:s', $getDate)->addDays(1);
        
        // dd($dtlDate1);


        $getLocDtl = DB::table('tracksecuritylocations')
            ->leftjoin('security','security.scrt_id','=','tracksecuritylocations.user_id')
            ->leftjoin('client','client.building_id','=','security.building_id')
            ->select('tracksecuritylocations.*', 'security.name', 'security.mobile', 'client.b_name')
            ->whereRaw('tracksecuritylocations.id IN (select MAX(tracksecuritylocations.id) FROM tracksecuritylocations WHERE tracksecuritylocations.created_at BETWEEN ? and ? GROUP BY tracksecuritylocations.user_id)',[$getDate, $dtlDate1])
            ->orderBy('tracksecuritylocations.id','desc',)
            ->get();

            // $this->trackdtl = json_decode($getLocDtl);

            $this->dispatchBrowserEvent('securityTrackDetails',['dtl'=>$getLocDtl]);

        // dd(json_decode($getLocDtl));

    }

    public function closeModal(){

        $this->resetErrorBag();

        $this->sec_id='';
        $this->name='';
        $this->email='';
        $this->mobile='';
        $this->gender='';
        $this->area='';
        $this->city='';
        $this->state='';
        $this->address='';
        $this->pin='';
        $this->status='';
        $this->password='';
        $this->supervised_by='';
    }
}
