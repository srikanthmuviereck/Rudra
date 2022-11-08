<?php

namespace App\Http\Controllers\Api\api101;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// DataBase
use DB;
use App\Models\Tables\buildingsModel;
use App\Models\Tables\leavereasonsModel;
use App\Models\Tables\leaverequestsModel;

use App\Models\Tables\attendanceModel;

use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;
use App\Models\Tables\notificationModel;
use App\Models\Tables\tracklocModel;

use App\Models\Tables\trackSPVRlocModel;
use App\Models\Tables\spvrVisitModel;

use App\Models\Tables\supervisor_field_tracking;

use Carbon\Carbon;

class siteController extends Controller
{

    public function listbuildings(Request $req)
    {

        if(!empty($req->listby)){

            $listby = $req->listby;

            $userId = $req->user_id;

            if($req->offset){ $offset=$req->offset;}else{$offset=0;}
            if($req->limit){ $limit=$req->limit;}else{$limit=10;}

            $getBuildingList = supervisorModel::select('*')->where('spvr_id', $userId)->first();

            if(empty($getBuildingList->building_id)){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Buildings Found!',
                    'res'=>[]
                ]);
            }

            $buildIds = explode(',', $getBuildingList->building_id);

            // return $buildId;

            $buildDtls = [];

            foreach ($buildIds as $valId) {

                $tId = $valId;

                $get_list = clientModel::select('clnt_id', 'c_name', 'mobile', 'building_id', 'b_name')
                ->where('building_id', $tId)->where('assign', $listby)
                ->get();

                if($get_list->count() > 0){

                    array_push($buildDtls, $get_list);

                }                
            }
            // dd($buildDtls);

            if(empty($buildDtls)){

                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Buildings Found!',
                    'res'=>[]
                ]);

            }

            $finalBuildings = []; 

            foreach ($buildDtls as $childFac) 
            { 
                foreach ($childFac as $cvalue) 
                { 
                $finalBuildings[] = $cvalue; 
                } 
            }


            if(!empty($finalBuildings)){
				
				if($listby == 'A'){

                    foreach($finalBuildings as $bKey => $glist){
						
						$mtArr = array();

                        $bId = $glist->building_id;
                        // dd($bId);
                        // $getSecdtl = securityModel::select('scrt_id', 'name')->where('building_id', $bId)->get();

                        $getSecdtl = DB::table('assign_buildings')
                        ->join('security', 'security.scrt_id', '=', 'assign_buildings.scrt_id')
                        ->select('security.scrt_id', 'security.name')
                        ->where('assign_buildings.building_id', $bId)
                        ->where('assign_buildings.assign','A')
                        
                        // ->groupBy('security.scrt_id')
                        ->get();
                        // dd($getSecdtl);



                        foreach($getSecdtl as $secdtls){
                            $mtArr[] = $secdtls;
                        }

                        $finalBuildings[$bKey]->security_details = $mtArr;

                    }    
                }



            //    star limit  offset
// dd($offset,$limit);
if($req->offset && $req->limit){
    // dd('h');
          $fullvalue=array_slice($finalBuildings, $offset, $limit);
}else{
    // dd('y');
    $fullvalue=$finalBuildings;
}

            //    end  limit  offset

           $this->array_sort_by_column($fullvalue, 'b_name');

            // print_r($inventory);
            
            
				
                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'res'=>$fullvalue
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Data!',
                    'res'=>[]
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>200,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
    }

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
    
        array_multisort($sort_col, $dir, $arr);
    }

    public function listleavereasons(Request $req)
    {
        $get_list = leavereasonsModel::select('reason')->get();

        if($get_list->count() > 0){
            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Data Found!',
                'res'=>$get_list
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Data!',
                'res'=>[]
            ]);
        }
    }

    public function save_leaverequest(Request $req)
    {
        if(!empty($req->reason) && !empty($req->start_date)){
			
			

            $reason = $req->reason;
            $user_id = $req->user_id;
            $user_type = $req->user_type;

            $startDate = date('Y-m-d', strtotime($req->start_date));
			
            $endDate = !empty($req->end_date)?date('Y-m-d', strtotime($req->end_date)):$startDate;

            $date = Carbon::now('Asia/Kolkata')->toDateTimeString();
			
            $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');

            // dd($startDate,$endDate,$date,$currentDate);

            if($startDate < date('Y-m-d')){

                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Please Select a Start Date After '. $currentDate .' !',
                ]);

            }

            if($endDate < $startDate){

                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Please Select a End Date After '. date('d-m-Y', strtotime($req->start_date)) .' !',
                ]);

            }

           
// dd('success');

            // $chkReason = leavereasonsModel::select('reason')->where('id', $reason_id)->get();

            $getSecDtl = DB::table('security')->where('scrt_id',$user_id)->first();
            

            // foreach($getSecDtl as $secval){
            //     $supervised_by = $secval->supervised_by;
            // }
           

            if($getSecDtl){


                // $supervised = explode(',', $getSecDtl->supervised_by);
                
                // foreach($supervised as $value){

                    //dd($supervised);

                $reqArr = [

                    'user_id' => $user_id,
                    'user_type' => $user_type,
                    'reason' => $reason,
                    'approved' => 2,
                    'approved_by' => $getSecDtl->supervised_by,
                    'start_date' => date('d-m-Y', strtotime($req->start_date)),
                    'end_date' => date('d-m-Y', strtotime($req->end_date)),
                    'created_at' => $date,
                    'updated_at' => $date,
    
                ];
                $submit = leaverequestsModel::insertGetId($reqArr);
            // }
            }else{
                $submit=0;
            }

           

            // $chkExist = leaverequestsModel::select('*')->where('user_id', $user_id)->get();
            // if($chkExist->count() > 0){

            //     foreach($chkExist as $extReq){
            //         $createdDate = $extReq->created_at;
            //     }

            //     $extDate = Carbon::createFromFormat('Y-m-d H:i:s', $createdDate)->format('d-m-Y');

            //     if($currentDate == $extDate){
            //         return response()->json([
            //             'error'=>true,
            //             'code'=>201,
            //             'message'=>'Request Already Submitted!',
            //         ]);
            //     }

            // }

           
            
            if($submit > 0){

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Leave Submitted Successfully!',
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Leave Submission Failed!',
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>200,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
    }

    public function listleaverequest(Request $req)
    {

        if(isset($req->listby)){

            $listby = $req->listby;

            $user_id = $req->user_id;
            $custName = 'NA';

            $leave = leaverequestsModel::select('id as request_id', 'user_id','reason','approved','start_date','end_date','approved_by')
            // ->where('approved_by', $user_id)
            ->where('approved', $listby)->orderBy('id', 'desc')->get();
            // dd(count($leave));
if(count($leave)>0){
            $leave_req=array();
            foreach($leave as $value){
                $marks = array(100, 65, 70, 87);
                $supervised = explode(',', $value->approved_by);
              if (in_array($user_id, $supervised))
              {
                $leave_req[]=$value; 
              }
            //   else
            //   {
            //     return "not found";
            //   }

            }


// return $leave_req;

$get_list=$leave_req;


        }else{
            $get_list=[];
        }
        // dd(count($get_list));

            if(count($get_list) > 0){

                foreach($get_list as $key => $leaveList){

                    $sec_id = $leaveList->user_id;

                    $getCust = securityModel::where('scrt_id', $sec_id)->get();

                    foreach($getCust as $custDtl){
                        $custName = $custDtl->name;
                    }

                    $get_list[$key]->security_name = $custName;
                }
                
                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'res'=>$get_list
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Data!',
                    'res'=>[]
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>200,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
        
    }

    public function listmyleaverequest(Request $req)
    {

        $user_id = $req->user_id;
// dd($user_id);
        $get_list = leaverequestsModel::select('id','reason','approved','approved_by','start_date','end_date')->where('user_id', $user_id)->orderBy('id', 'desc')->get();


        if($get_list->count() > 0){

            foreach($get_list as $key => $leaveList){

                $getCust = securityModel::where('scrt_id', $user_id)->get();

                foreach($getCust as $custDtl){
                    $custName = $custDtl->name;
                }

                $get_list[$key]->security_name = $custName;
            }

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Data Found!',
                'res'=>$get_list
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Data!',
                'res'=>[]
            ]);
        }
        
    }

    public function approve_leaverequest(Request $req)
    {
        if(!empty($req->request_id)){

            $req_id = $req->request_id;
            $approved = !empty($req->approved)?$req->approved:0;

            $get_list = leaverequestsModel::select('*')->where('id', $req_id)->get();

            if($get_list->count() > 0){

                $date = Carbon::now('Asia/Kolkata')->toDateTimeString();

                $updReq = [
                    'approved' => $approved,
                    'updated_at' => $date
                ];

                $updateReq = leaverequestsModel::where('id', $req_id)->update($updReq);

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Leave Request Successfully!',
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Request Found!'
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
    }

    public function listnotifications(Request $req){

        $user_id = $req->user_id;
        $user_type = $req->user_type;
		
		$umethod = ($req->user_type == 'SCRT')?'security':(($req->user_type == 'SPVR')?'Operation Team':(($req->user_type == 'CLNT')?'client':""));

        $getNot = notificationModel::select('id','user_type', 'title','message','type')->where('user_type', $umethod)->get();

        if(!empty($getNot)){
            

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Data Found!',
                'res'=>$getNot
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Data!',
                'res'=>[]
            ]);
        }

    }

    public function listsecurityworkdtls(Request $req){

        $user_id = $req->user_id;
        $user_type = $req->user_type;
        

        $limit = 5;
        $offset = 0;

        if(!empty($req->limit)){
            $limit = $req->limit;
        }

        if(!empty($req->offset)){
            $offset = $req->offset;
        }

        if($user_type == 'SPVR'){
            $getWorkDtls = attendanceModel::select('id','user_id','building_id','supervised_by','login','logout','latitude','longitude')->where('supervised_by', $user_id)->offset($offset)->limit($limit)->orderBy('id', 'desc')->get();
        }elseif($user_type == 'CLNT'){
           
            $updCLntDtl = clientModel::where('clnt_id',$user_id)->where('building_id',$req->building_id)->get();
            // return $updCLntDtl;

            foreach($updCLntDtl as $dtl){

                $building_id =  $dtl->building_id;

            }


            $getWorkDtls = attendanceModel::select('id','user_id','building_id','supervised_by','login','logout','latitude','longitude')->where('building_id', $building_id)->offset($offset)->limit($limit)->orderBy('id', 'desc')->get();
        }else{

            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Unknown Access!'
            ]);
        }

        if(!empty($getWorkDtls)){

            foreach($getWorkDtls as $key => $leaveList){
				
				$getWorkDtls[$key]->login = !empty($leaveList->login)?date('d-m-Y h:i:s A', strtotime($leaveList->login)):"";
                $getWorkDtls[$key]->logout = !empty($leaveList->logout)?date('d-m-Y h:i:s A', strtotime($leaveList->logout)):"";

                // Security Name

                $sec_id = $leaveList->user_id;

                $getCust = securityModel::where('scrt_id', $sec_id)->get();
				
				$custName = "NA";

                foreach($getCust as $custDtl){
                    $custName = $custDtl->name;
                }

                $getWorkDtls[$key]->security_name = $custName;

                $getTrackDtls = tracklocModel::where('user_id', $sec_id)->orderBy('id', 'desc')->first();

                if($getTrackDtls->count() > 0){

                    $getWorkDtls[$key]->latitude = $getTrackDtls->latitude;
                    $getWorkDtls[$key]->longitude = $getTrackDtls->longitude;

                }

                // Supervisor Name

                // $sup_id = $leaveList->supervised_by;

                // $getSup = supervisorModel::where('spvr_id', $sup_id)->get();

                // foreach($getSup as $supDtl){
                //     $supName = $supDtl->name;
                // }

                $sup_id = $leaveList->supervised_by;

                $getSup = supervisorModel::where('spvr_id', $sup_id)->get();

                foreach($getSup as $supDtl){
                    $supName = $supDtl->name;
                }

                $getWorkDtls[$key]->supervisor_name = $supName;

                // Building Name

                $build_id = $leaveList->building_id;

                $getBuild = clientModel::where('building_id', $build_id)->get();
				
				

                foreach($getBuild as $buildDtl){
                    $buildName = $buildDtl->b_name;
                }

                $getWorkDtls[$key]->building_name = $buildName;
            }

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Data Found!',
                'res'=>$getWorkDtls
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Data!',
                'res'=>[]
            ]);
        }

    }

    public function listsecurityworkdtlsbydate(Request $req){

        if(!empty($req->dtl_date)){

            $dtl_date = $req->dtl_date;

            $dtlDate = Carbon::createFromFormat('d-m-Y', $dtl_date)->format('Y-m-d 00:00:00');

            $dtlDate1 = Carbon::createFromFormat('d-m-Y', $dtl_date)->addDays(1)->format('Y-m-d 00:00:00');

            $user_id = $req->user_id;
            $user_type = $req->user_type;

            if($user_type == 'SPVR'){
                $getWorkDtls = attendanceModel::select('id','user_id','building_id','supervised_by','login','logout','latitude','longitude')->where('supervised_by', $user_id)->whereBetween('login',[$dtlDate, $dtlDate1])->orderBy('id', 'desc')->get();
            }elseif($user_type == 'CLNT'){
                $updCLntDtl = clientModel::where('clnt_id','=',$user_id)->where('building_id',$req->building_id)->get();

                foreach($updCLntDtl as $dtl){

                    $building_id =  $dtl->building_id;

                }
                
                $getWorkDtls = attendanceModel::select('id','user_id','building_id','supervised_by','login','logout','latitude','longitude')->where('building_id', $building_id)->whereBetween('login',[$dtlDate, $dtlDate1])->orderBy('id', 'desc')->get();
                // return $updCLntDtl;

            }else{

                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Unknown Access!'
                ]);
            }

            if($getWorkDtls->count() > 0){

                foreach($getWorkDtls as $key => $leaveList){
					
					$getWorkDtls[$key]->login = !empty($leaveList->login)?date('d-m-Y h:i:s A', strtotime($leaveList->login)):"";
                    $getWorkDtls[$key]->logout = !empty($leaveList->logout)?date('d-m-Y h:i:s A', strtotime($leaveList->logout)):"";

                    // Security Name
    
                    $sec_id = $leaveList->user_id;
    
                    $getCust = securityModel::where('scrt_id', $sec_id)->get();
    
                    foreach($getCust as $custDtl){
                        $custName = $custDtl->name;
                    }
    
                    $getWorkDtls[$key]->security_name = $custName;
					
					$getTrackDtls = tracklocModel::where('user_id', $sec_id)->orderBy('id', 'desc')->first();

                    if($getTrackDtls->count() > 0){

                        $getWorkDtls[$key]->latitude = $getTrackDtls->latitude;
                        $getWorkDtls[$key]->longitude = $getTrackDtls->longitude;

                    }
    
                    // Supervisor Name
    
                    // $sup_id = $leaveList->supervised_by;
    
                    // $getSup = supervisorModel::where('spvr_id', $sup_id)->get();
    
                    // foreach($getSup as $supDtl){
                    //     $supName = $supDtl->name;
                    // }
    
                    $sup_id = $leaveList->supervised_by;
    
                    $getSup = supervisorModel::where('spvr_id', $sup_id)->get();
    
                    foreach($getSup as $supDtl){
                        $supName = $supDtl->name;
                    }
    
                    $getWorkDtls[$key]->supervisor_name = $supName;
    
                    // Building Name
    
                    $build_id = $leaveList->building_id;
    
                    $getBuild = clientModel::where('building_id', $build_id)->get();
    
                    foreach($getBuild as $buildDtl){
                        $buildName = $buildDtl->b_name;
                    }
    
                    $getWorkDtls[$key]->building_name = $buildName;
                }

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'res'=>$getWorkDtls
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Data not found!',
                    'res'=>[]
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
    }

    public function save_worklocations(Request $req)
    {
        
        if(!empty($req->latitude) && !empty($req->longitude) && !empty($req->building_id) && !empty($req->supervised_by)){

            $latitude = $req->latitude;
            $longitude = $req->longitude;
            $building_id = $req->building_id;
            $supervised_by=$req->supervised_by;

            $user_id = $req->user_id;
			$currentTime = Carbon::now('Asia/Kolkata')->toDateTimeString();

            $locArr = [
                'user_id' => $user_id,
                'latitude' => $latitude,
                'longitude' => $longitude,
				'created_at' => $currentTime
            ];

            $insLoc = tracklocModel::insertGetId($locArr);

            if($insLoc > 0){
				
				$getCPID = securityModel::select('name','building_id','supervised_by')->where('scrt_id', $user_id)->first();

                // return $getCPID;

                $getlatlng = clientModel::select('bl_lat', 'bl_lng')->where('building_id', $building_id)->first();

                // return $getlatlng;
                        
                $blat = $getlatlng->bl_lat;
                $blng = $getlatlng->bl_lng;

                $clat = $req->latitude; #"11.6199498";
                $clng = $req->longitude; #"78.1459979";

                $fm = "0";
                $unit = "K";

                if (($blat == $clat) && ($blng == $clng)) {
                    $fm = 0;
                }
                else {
                    $theta = $blng - $clng;
                    $dist = sin(deg2rad($blat)) * sin(deg2rad($clat)) +  cos(deg2rad($blat)) * cos(deg2rad($clat)) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = $dist * 60 * 1.1515;
                    $unit = strtoupper($unit);

                    if ($unit == "K") {
                        $fm = ($miles * 1.609344);
                    } elseif ($unit == "N") {
                        $fm = ($miles * 0.8684);
                    } else {
                        $fm = $miles;
                    }
                }
// dd($fm);
                if( $fm > 0.1 ){

                    $title = 'Work Alert!'; 

                    $body = 'Security not in Client Place. Name : '.$getCPID->name;

                    $content = [
                        'title' => $title,
                        'body' => $body,
                    ];

                    $getSfcmId = supervisorModel::select('name','fcm_id')->where('spvr_id',$supervised_by)->get();
                    // dd($getSfcmId);

                    $this->send_site_notification($getSfcmId, $content);
                    
                }
				
                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Location Updated Successfully!'
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Location Updated Failed!'
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]); 
        }
    }
	
	public function save_spvr_worklocations(Request $req)
    {
        if(!empty($req->latitude) && !empty($req->longitude)){

            $latitude = $req->latitude;
            $longitude = $req->longitude;

            $user_id = $req->user_id;

            $currentTime = Carbon::now('Asia/Kolkata')->toDateTimeString();

            // return $currentTime;

            $locArr = [
                'user_id' => $user_id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'created_at' => $currentTime
            ];

            $insLoc = trackSPVRlocModel::insertGetId($locArr);

            if($insLoc > 0){
                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Location Updated Successfully!'
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Location Updated Failed!'
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]); 
        }
    }

    public function lastworklocation(Request $req)
    {
        $user_id = $req->user_id;
        $getLoc = tracklocModel::select('user_id', 'latitude', 'longitude')->where('user_id',$user_id)->orderBy('id', 'desc')->limit(1)->get();

        if($getLoc->count() > 0){
            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Location Found!',
                'res' => $getLoc
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Location Not Found!'
            ]);
        } 
    }
	
	   
    public function listsecutiylocationsbymap(Request $req)
    {
        $user_id = $req->user_id;
        
        $user_type = $req->user_type;

        if($user_type == 'SPVR'){
            $getSecDtls = attendanceModel::select('*')->where('supervised_by', $user_id)->WhereNull('logout')->where('user_type','SCRT')->get();
// return $getSecDtls;
            if($getSecDtls->count() == 0){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Securities Found!',
                    'res' => []
                ]);
            }

        }elseif($user_type == 'CLNT'){
// dd($getSecDtls);
            $getClntDtl = clientModel::select('building_id')->where('clnt_id', $user_id)->get();

            if($getClntDtl->count() == 0){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Securities Found!',
                    'res' => []
                ]);
            }

            foreach($getClntDtl as $clntDtl){
                $building_id = $clntDtl->building_id;
            }
            

            $getSecDtls = securityModel::select('scrt_id','building_id','supervised_by')->where('assign', 'A')->where('building_id', $building_id)->get();

            // return $getSecDtls;

        }else{

            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Unknown Access!'
            ]);
        }

        if($getSecDtls->count() > 0){

            $loactionArr = $finalLoc = array();

            foreach($getSecDtls as $secdtl){
                
                $scrt_id = $secdtl->user_id;
                $building_id = $secdtl->building_id;
                $supervised_by = $secdtl->supervised_by;


                // Get Locations 

                $getLoc = tracklocModel::select('user_id as scrt_id', 'latitude', 'longitude')->where('user_id',$scrt_id)->orderBy('id', 'desc')->limit(1)->get();

                // supervisorModel
                // clientModel

                // Security Name


                $getCust = securityModel::where('scrt_id', $scrt_id)->get();
                
                $custName = "NA";

                foreach($getCust as $custDtl){
                    $custName = $custDtl->name;
                }

                $security_name = $custName;

                // Supervisor Name


                $getSup = supervisorModel::where('spvr_id', $supervised_by)->get();

                foreach($getSup as $supDtl){
                    $supName = $supDtl->name;
                }

                $supervisor_name = $supName;

                // Building Name

                $getBuild = clientModel::where('building_id', $building_id)->get();
                
                $buildName = "NA";

                foreach($getBuild as $buildDtl){
                    $buildName = $buildDtl->b_name;
                }

                $building_name = $buildName;

                foreach($getLoc as $locKey => $location){
                    $getLoc[$locKey]->security_name = $security_name;
                    $getLoc[$locKey]->building_id = $building_id;
                    $getLoc[$locKey]->supervisor_name = $supervisor_name;
                    $getLoc[$locKey]->building_name = $building_name;
                }

                array_push($loactionArr, $getLoc);
            }
// return $loactionArr;
            foreach ($loactionArr as $childFac) 
            { 
                foreach ($childFac as $cvalue) 
                { 
                $finalLoc[] = $cvalue; 
                } 
            }

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Data Found!',
                'res' => $finalLoc
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Securities Found!',
                'res' => []
            ]);
        }
    }
	
	public function sp_visit_notify(Request $req){

        if(!empty($req->building_id)){

            $user_id = $req->user_id;
           
            $user_type = $req->user_type;

            $building_id = $req->building_id;
            $currentTime = Carbon::now('Asia/Kolkata')->toDateTimeString();

            $insArr = [

                'user_id' => $user_id,
                'building_id' => $building_id,
                'created_at' => $currentTime

            ];

            $addVisit = spvrVisitModel::insertGetId($insArr);

            if($addVisit > 0){

                // $getFcmId = clientModel::select('fcm_id')->where('building_id', $building_id)->get();

                $getC = clientModel::select('clnt_id')->where('building_id',$building_id)->first();
                $getFcmId = clientModel::select('fcm_id')->where('clnt_id',$getC->clnt_id)->offset(0)->limit(1)->get();

                $title = "Operation Team Visit Update";
                $body = "Operation Team decide to visit your building";

                $get_server_key = 'AAAAJFP-zhI:APA91bHNXwX71Q_-QJ4Qtm041Toq8ubxeJK8_HTT4zOu-LX-4LEoReKPRnJGyGOJKpBBYr_LPb32vadPYd2N6RTCkQq-uduszUlQFXD2bFJnC6_fG4g6Tb0_159WxrX4951TGM-baMZj';

                foreach($getFcmId as $fcm){

                    // return $fcm;

                    $json_data =[
                        "to" => $fcm->fcm_id,
                            "data"=>[
                                "android_channel_id"=>"default",
                                "title"=>$title,
                                "body"=>$body,
                                "image"=>'',
                                "click_action"=>'normal',
                                ],
                            "notification"=>[
                                "android_channel_id"=>"default",
                                "title"=>$title,
                                "body"=>$body,
                                "image"=>'',
                                "click_action"=>'normal',
                            ]
                        ];

                        // return $json_data;

                    $data = json_encode($json_data);
                    //FCM API end-point
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
                    
                    //header with content_type api key
                    $headers = array(
                        'Content-Type:application/json',
                        'Authorization:key='.$get_server_key
                    );
                    //CURL request to route notification to FCM connection server (provided by Google)
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    $result = curl_exec($ch);
                    $err = curl_error($ch);

                    if ($err) {
                        return $err;
                    }

                }
                // return $result;
                curl_close($ch);

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Punch in successfully!'
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Please Try Again!'
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
    }
	
	public function save_field_tracking(Request $req)
    {

        if(!empty($req->building_id)){

            $insForm = [

                'user_id' => $req->user_id,
                'building_id' => $req->building_id,
                'check_uniform' => !empty($req->check_uniform)?$req->check_uniform:'',
                'meet_client_update' => !empty($req->meet_client_update)?$req->meet_client_update:'',
                'invoice_status' => !empty($req->invoice_status)?$req->invoice_status:'',
                'night_check_update' => !empty($req->night_check_update)?$req->night_check_update:'',
                'current_strength_details' => !empty($req->current_strength_details)?$req->current_strength_details:'',
                'post_vacancy' => !empty($req->post_vacancy)?$req->post_vacancy:'',
                'client_feedback' => !empty($req->client_feedback)?$req->client_feedback:'',
                'day_visit_update' => !empty($req->day_visit_update)?$req->day_visit_update:'',
                'guards_training' => !empty($req->guards_training)?$req->guards_training:'',
				'notes' => !empty($req->notes)?$req->notes:'',

            ];

            $input=$req->all();
			
			$image= false;
			
			if(isset($req->guards_images)){
				$image = $input['guards_images'];
			}            

            if($image){
                $array=explode('data:image/png;base64,', $image[0]);				
                $file = array();
                foreach($input['guards_images'] as $name)
                {
                    $img = str_replace('data:image/png;base64,', '', $name);   
                    $img = str_replace(' ', '+', $img); 
                    $data = base64_decode($img);
                    $imagename= uniqid().rand(1,10000).'.png';
                    $destinationPath = public_path('storage/assets/images/');
                    $path = $destinationPath.$imagename;
                    $res = file_put_contents($path, $data);
                    $file[]='assets/images/'.$imagename;
                }

                $photovalue=implode(",",$file);                

                $insForm['guards_images'] = $photovalue;

            }

            // $table->longtext('guards_images')->nullable();

            supervisor_field_tracking::insertGetId($insForm);

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Form Submitted Succesfully!'
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }
        
    }
	
	public function send_site_notification($getfcmId, array $content)
    {

        $get_server_key = 'AAAAJFP-zhI:APA91bHNXwX71Q_-QJ4Qtm041Toq8ubxeJK8_HTT4zOu-LX-4LEoReKPRnJGyGOJKpBBYr_LPb32vadPYd2N6RTCkQq-uduszUlQFXD2bFJnC6_fG4g6Tb0_159WxrX4951TGM-baMZj';

        $listFcm = $getfcmId;

        $title = $content["title"];
        $body = $content["body"];
  $tmpid=  rand(1000,9909);
        foreach($listFcm as $fcm){

            // return $fcm;

            $json_data =[
                "to" => $fcm->fcm_id,
                    "data"=>[
                        "android_channel_id"=>"default",
                        "title"=>$title,
                        "body"=>$body,
                        "image"=>'',
                                 "tag"=>$tmpid,

                        "click_action"=>'normal',
                        ],
                    "notification"=>[
                        "android_channel_id"=>"default",
                        "title"=>$title,
                           "tag"=>$tmpid,
                        "body"=>$body,
                        "image"=>'',
                        "click_action"=>'normal',
                    ]
                ];

                // return $json_data;

            $data = json_encode($json_data);
            //FCM API end-point
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            
            //header with content_type api key
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key='.$get_server_key
            );
            //CURL request to route notification to FCM connection server (provided by Google)
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            $err = curl_error($ch);

            if ($err) {
                return $err;
            }

        }
        // return $result;
        curl_close($ch);
    }


    // Contact Details

    public function company_dtls(Request $req){

        if(!empty($req->action)){

            $action = $req->action;
			
			if($action == 'contact'){

                $get_phone = DB::table('settings')->select('value')->where('field','phone')->get();
                $get_mail = DB::table('settings')->select('value')->where('field','mail')->get();
                $get_wapp = DB::table('settings')->select('value')->where('field','whatsapp')->get();
                
                $c_mble = "";
                $c_mail = "";
                $c_wapp = "";

                foreach($get_phone as $phone){
                    $mble = $phone->value;
                }

                foreach($get_mail as $mail){
                    $email = $mail->value;
                }

                foreach($get_wapp as $wapp){
                    $whatsapp = $wapp->value;
                }

                $c_mble = !empty($mble)?$mble:'';
                $c_mail = !empty($email)?$email:'';
                $c_wapp = !empty($whatsapp)?$whatsapp:'';

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'phone' => $c_mble,
                    'mail' => $c_mail,
                    'whatsapp' => $c_wapp,
                ]);
            }

            $get_cmpny_dtl = DB::table('settings')->select('value')->where('field',$action)->get();

            $val = "";

            if($get_cmpny_dtl->count() > 0){

                foreach ($get_cmpny_dtl as $cval) {
                    $val = $cval->value;
                }

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'content'=>$val,
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No Action Found!'
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Please Fill Mandatory Fields!'
            ]);
        }

    }

    public function setting_app_update(Request $req){

        return response()->json([
            'success'=>true,
            'code'=>200,
            'message'=>'Data Found!',
            'customer_current_version'=>'1.0',
            'customer_minimum_version'=>'1.0'
        ]);

    }
}
