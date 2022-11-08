<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use DB;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class Supervisor extends Component
{
    public $spvr_id,$name,$email,$mobile,$gender,$area,$city,$state,$address,$pin,$status,$password, $panno,$adhaarno,$bankname,$bankacno,$ifsccode,$esino,$clnt_id, $location,$search_customer,$dropdown,$customer_dropdown1,$search_customer1,$b_name;
   
    public $ids, $building = [], $secdate, $secData = [];

    protected $listeners = ['editSupervisor','deleteSupervisor','securitydata'];

    protected $rules = [
        'name' =>'required|min:5',
        // 'email' =>'nullable|email',
        'mobile' =>'required|numeric|digits:10',
        'address' =>'required|min:10',
        'status' =>'required',
        // 'building' =>'required',
        'password' => 'nullable|min:4',
        // 'area' => "nullable|min:5",
        // 'city' =>'nullable|min:5',
        // 'state' => "nullable|min:5",
        // 'pin' => "nullable|numeric|digits:6",
		// 'bankname' => "nullable|min:3",
        // 'bankacno' => "nullable|min:3",
        // 'ifsccode' => "nullable|min:3",
        // 'clnt_id' => "nullable|min:3",
        // 'panno' => "nullable",
        // 'adhaarno' => "nullable",  
    ];

    protected $messages = [
        'name.required' => 'This Field is Mandatory',
        'email.required' => 'This Field is Mandatory',
        'mobile.required' => 'This Field is Mandatory',
        'address.required' => 'This Field is Mandatory',
        'status.required' => 'This Field is Mandatory',
        'password.required' => 'This Field is Mandatory',
        'building.required' => 'This Field is Mandatory',
        'secdate.required' => 'This Field is Mandatory'
    ];

    public function closeModal(){

        $this->resetErrorBag();

        $this->spvr_id='';
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
        $this->id;
		$this->building = [];
      
    }
        public $users = [],$multiselect;

    public function mount()
    {
            $h= DB::table('client')->select('*')->where('b_name', 'like', '%' . $this->search_customer1 . '%')->orwhere('area', 'like', '%' . $this->search_customer1 . '%')->orwhere('b_name', 'like', '%' . $this->search_customer1 . '%')->orwhere('b_name', 'like', '%' . $this->search_customer1 . '%')
      ->get();
        $this->users= $h;
    }


    public function render()
    {

           $h= DB::table('client')->select('*')->where('b_name', 'like', '%' . $this->search_customer1 . '%')->orwhere('area', 'like', '%' . $this->search_customer1 . '%')->orwhere('b_name', 'like', '%' . $this->search_customer1 . '%')->orwhere('b_name', 'like', '%' . $this->search_customer1 . '%')
      ->get();

      $this->h=$h;
        $security_datas = DB::table('security')
        ->join('supervisor', 'supervisor.spvr_id', '=', 'security.supervised_by')
        // ->where('supervisor.id','=',$this->id)
        ->select('security.*')
        ->get();

        $client = DB::table('client')->select('*')->get();


        return view('livewire.dashboard.supervisor',['security'=>$security_datas, 'client'=>$client])->extends('layouts.main');
    }

    public function store(){
    
   
            $this->validate();
            // dd($this->value_arr);
            if(count($this->value_arr)==0){
                $this->validate([
              'multiselect' =>'required',

                ]);
            }
		

 $value_a=array();
       foreach($this->value_arr as $val){
       $v=explode(',/',$val);
       $value_a[]=$v[1];
   }
      


			$mble = $this -> mobile;

			$chkMble = supervisorModel::where('mobile',$mble)->get();

			if($chkMble->count() > 0){
				session()->flash('dangerMessage','Mobile Number Already Exists!');
				$this->closeModal();
				return redirect()->to('supervisor');
			} 

			$eml = $this -> email;

			$chkEmail = supervisorModel::where('email',$eml)->get();

			if(!empty($eml) && $chkEmail->count() > 0){
				session()->flash('dangerMessage','Email Already Exists!');
				$this->closeModal();
				return redirect()->to('supervisor');
			} 

            $tmp_id = rand(1000,8989);

            $supId = 'TMPSP'.$tmp_id;

            // dd($this->building);

            $insertSupv = [
                'spvr_id' =>$supId,
                'name' => $this -> name,
                'email' => $this -> email,
                'mobile' => $this -> mobile,
                'address' =>$this -> address,
                'gender' => $this -> gender,
                'area' => $this -> area,
                'city' => $this -> city,
                'state' => $this -> state,
                'pin' => $this -> pin,
                'status' => $this -> status,
                'password' => Hash::make($this->password),
                'fcm_id' => '',
                'device_name' => '',
                'device_model' => '',
                'os_version' => '',
                'latitude' => '',
                'longitude' => '',
                'building_id' => implode(',',$value_a),
				'bankname' => $this->bankname,
				'bankacno' => $this->bankacno,
				'ifsccode' => $this->ifsccode,
				'location' => $this->location,
				'clnt_id' => $this->clnt_id,
				'panno' => $this->panno,
				'adhaarno' => $this->adhaarno,
            ];
            
            $api_token = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

            $insertSupv['api_token'] = $api_token;

            $addSup = supervisorModel::insertGetId($insertSupv);
            
            if($addSup > 0){

                $spId ='RCS-'.str_pad($addSup, 4, "0", STR_PAD_LEFT);

                $updSupId = [
                    'spvr_id' => $spId,
                ];

                supervisorModel::where('id', $addSup)->update($updSupId);
                session()->flash('message','Operation Team created Sucessfully');
                $this->closeModal();
                return redirect()->to('supervisor');

            }else{
                session()->flash('message','Add Operation Team Failed');
                return redirect()->to('supervisor');
            }
    
        }

    public function editSupervisor($id){

        $supervisorData = supervisorModel::where('id',$id['id'])->get();
        // dd($supervisorData[0]->building_id);

        foreach($supervisorData as $supData){
            $id = $supData->id;
            $spvr_id = $supData->spvr_id;
            $name = $supData->name;
            $email = $supData->email;
            $mobile = $supData->mobile;
            $gender = $supData->gender;
            $area = $supData->area;
            $city = $supData->city;
            $state = $supData->state;
            $address = $supData->address;
            $pin = $supData->pin;
            $status = $supData->status;
            $building_id = $supData->building_id;
			$bankname = $supData->bankname;
			$bankacno = $supData->bankacno;
			$ifsccode = $supData->ifsccode;
			$location = $supData->location;
			$clnt_id = $supData->clnt_id;
			$panno = $supData->panno;
			$adhaarno = $supData->adhaarno;
        }

        $this->ids = $id;
        $this->spvr_id = $spvr_id;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->gender = $gender;
        $this->area = $area;
        $this->city = $city;
        $this->state = $state;
        $this->address = $address;
        $this->pin = $pin;
        $this->status = $status;
        $this->value_arr = explode(',', $building_id);


$value_arr=array();
       foreach(explode(',', $building_id) as $val){


 $h= DB::table('client')->select('*')->where('building_id',$val)->first();
 // dd($h);
 if (!empty($h)) {
     
 
$b_name=$h->b_name;
$area=$h->area;
$city=$h->city;
$pin=$h->pin;
$building_id=$h->building_id;
}
else{
 
$b_name='';
$area='';
$city='';
$pin='';
$building_id='';

}


$value_a[]=$b_name.",".$area.",".$city.",".$pin.",/".$building_id;

   }
   $this->value_arr=$value_a;

		
		$this->bankname = $bankname;
        $this->bankacno = $bankacno;
        $this->ifsccode = $ifsccode;
        $this->location = $location;
        $this->clnt_id = $clnt_id;
        $this->panno = $panno;
        $this->adhaarno = $adhaarno;
		
		
		$this->emit('openSelect2');

        $this->dispatchBrowserEvent('supervisorEdit');

    }


    public function securitydata($obj){

// dd($this->value_arr);

        
        

        $supervisorId = $obj['id'];

        $getSecData = securityModel::
            leftjoin(DB::raw('
                (SELECT building_id,b_name FROM client) as client
            '), function ($join) {
                $join->on('security.building_id', '=', 'client.building_id');
            })->select('security.*', 'client.b_name')->where('supervised_by', $supervisorId)->where('assign', 'A')->get();

            // dd(json_decode($getSecData));

$this->secData=[];
        $this->secData = json_decode($getSecData);

        $this->dispatchBrowserEvent('securityview');
        
    }

    public function update(){

        $this->validate();
         if(count($this->value_arr)==0){
                $this->validate([
              'multiselect' =>'required',

                ]);
            }
		
		$mble = $this -> mobile;

		$chkMble = supervisorModel::where('mobile',$mble)->where('id', '!=', $this->ids)->get();

		if($chkMble->count() > 0){
			session()->flash('dangerMessage','Mobile Number Already Exists!');
			$this->closeModal();
			return redirect()->to('supervisor');
		} 

		$eml = $this -> email;

		$chkEmail = supervisorModel::where('email',$eml)->where('id', '!=', $this->ids)->get();

		if(!empty($eml) && $chkEmail->count() > 0){
			session()->flash('dangerMessage','Email Already Exists!');
			$this->closeModal();
			return redirect()->to('supervisor');
		} 

        $value_a=array();
       foreach($this->value_arr as $val){
       $v=explode(',/',$val);
       $value_a[]=$v[1];
   }
      

        if($this->ids){

            $secUpd = [

                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'area' => $this->area,
                'city' => $this->city,
                'state' => $this->state,
                'address' => $this->address,
                'pin' => $this->pin,
                'status' => $this->status,
                // 'password' => Hash::make($this->password),
                'building_id' => implode(',',$value_a),
				'bankname' => $this->bankname,
                'bankacno' => $this->bankacno,
                'ifsccode' => $this->ifsccode,
                'location' => $this->location,
                'clnt_id' => $this->clnt_id,
                'panno' => $this->panno,
                'adhaarno' => $this->adhaarno,
            ];

            if(isset($this->password)){
                $secUpd['password'] = Hash::make($this->password);
            }
			
			if($this->status == 'inactive'){
				$updClnt['fcm_id'] = '';
				$updClnt['api_token'] = '';
			}

            $supervisor = supervisorModel::where('id', $this->ids)->update($secUpd);

            session()->flash('supervisorMessage','Operation Team updated successfully');
            $this->closeModal();
            return redirect()->to('supervisor');

        }
    }
    public function deleteSupervisor($obj)
    {
        // dd($obj);
        $this->s_id = $obj['id'];
        $this->dispatchBrowserEvent('supervisorDelete');
    }
    public function removeSupervisor()
    {
       $dd= DB::table('supervisor')->where('id', $this->s_id)->delete();
     
        session()->flash('supervisorMessage', 'Operation Team Delete successfully!');
        return redirect()->to('supervisor');

    }
public $value_arr=array();
   public function customer_selected1($id){


if(count($this->value_arr)>0){
    $array=array();
    foreach($this->value_arr as $key=>$value){
        if($value==$id){
$if=false;
$this->removerow($key);
        }
    else{
            $array[]=$value;
            $if=true;

        }

    }
}else{
    $if=true;
}


if($if){
   $arr[]=$id;
   
   $a= $this->value_arr;
   $b=$arr;
    // array_push($this->value_arr,$id);
   $d= array_merge($a,$b);
   $this->value_arr=$d;
   //
    // dd($this->value_arr);
    // $this->building_id=$id;
    // $this->array2=$id;
    // dd($this->array2);

    // $this->dropdown = !$this->dropdown;
}else{
    // dd('h');
    $this->value_arr=$array;
}
    
  }

public function removerow($id){
        unset($this->value_arr[$id]);
    }

  public function customer_dropdown1()
    {
        $this->dropdown = !$this->dropdown;
    }
    public function supervisorTracker()
    {
        $this->validate([
            'secdate' => 'required'
        ]);

        $getDate = date('Y-m-d H:i:s', strtotime($this->secdate));
        $dtlDate1 = Carbon::createFromFormat('Y-m-d H:i:s', $getDate)->addDays(1);
        
        // dd($dtlDate1);

        $getLocDtl = DB::table('tracksupervisorlocations')
            ->leftjoin('supervisor','supervisor.spvr_id','=','tracksupervisorlocations.user_id')
            ->leftjoin('client','client.building_id','=','supervisor.building_id')
            ->select('tracksupervisorlocations.*', 'supervisor.name', 'supervisor.mobile', 'client.b_name')
            ->whereRaw('tracksupervisorlocations.id IN (select MAX(tracksupervisorlocations.id) FROM tracksupervisorlocations WHERE tracksupervisorlocations.created_at BETWEEN ? and ? GROUP BY tracksupervisorlocations.user_id)',[$getDate, $dtlDate1])
            ->orderBy('tracksupervisorlocations.id','desc',)
            ->get();

            // $this->trackdtl = json_decode($getLocDtl);

            $this->dispatchBrowserEvent('supervisorTrackDetails',['dtl'=>$getLocDtl]);

        // dd(json_decode($getLocDtl));
    }
    

}

