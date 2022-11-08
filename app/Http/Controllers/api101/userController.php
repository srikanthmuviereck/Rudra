<?php

namespace App\Http\Controllers\Api\api101;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Hash;

use Carbon\Carbon;

// Database
use DB;
use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;

use App\Models\Tables\assign_buildingsModel;
use App\Models\Tables\buildingsModel;
use App\Models\Tables\attendanceModel;
use App\Models\Tables\tracklocModel;

class userController extends Controller
{
    

    public function userlogin(Request $req){

        if(!empty($req->mobile) && !empty($req->password) && !empty($req->user_type)){

            $u_mobile = $req->mobile;
            $u_pass = $req->password;

            $u_type = $req->user_type;

            if($u_type == 'SCRT'){
                $userlist = securityModel::select('*')->where('mobile', '=', $u_mobile)->get();
            }elseif ($u_type == 'SPVR') {
                $userlist = supervisorModel::select('*')->where('mobile', '=', $u_mobile)->get();                
            }elseif ($u_type == 'CLNT') {
                $userlist = clientModel::select('*')->where('mobile', '=', $u_mobile)->get();                
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Unknown User Type!'                      
                ]);
            }
                        
            $userCount = $userlist->count();

            if($userCount > 0){

                foreach($userlist as $chk_sts){
                    $status = $chk_sts->status;
                    $password = $chk_sts->password;
                }

                if($status == 'inactive'){

                    return response()->json([
                        'error'=>true,
                        'code'=>201,
                        'message'=>'User Inactive State!'                      
                    ]);

                }

                if (Hash::check($u_pass, $password)) {
                    
                    $api_token = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

                    if(!empty($req-> fcm_id)){
                        $upd['fcm_id'] = $req-> fcm_id;
                    }
                    if(!empty($req-> device_name)){
                        $upd['device_name'] = $req-> device_name;
                    }
                    if(!empty($req-> device_model)){
                        $upd['device_model'] = $req-> device_model;
                    }

                    if(!empty($req-> os_version)){
                        $upd['os_version'] = $req-> os_version;
                    }

                    if(!empty($req-> latitude)){
                        $upd['latitude'] = $req-> latitude;
                    }
                    if(!empty($req-> longitude)){
                        $upd['longitude'] = $req-> longitude;
                    }


                    $upd['api_token'] = $api_token;

                    if($u_type == 'SCRT'){
                        $updOldUser = securityModel::where('mobile','=',$u_mobile)->update($upd);

                        $updUserlist = securityModel::select('scrt_id','name','mobile','email','gender','api_token','fcm_id','device_name','device_model','os_version','latitude','longitude','status','supervised_by','assign','building_id')->where('mobile', '=', $u_mobile)->get();

                        foreach($updUserlist as $key => $scrtList){

                            $secId = $scrtList->scrt_id;
                            
                            $building_id = $scrtList->building_id;

                            $getBuildName = clientModel::select('b_name')->where('building_id', $building_id)->get();
							
							$build_name = "NA";

                            foreach($getBuildName as $bname){
                                $build_name = $bname->b_name;
                            }

                            $updUserlist[$key]->building_name = $build_name;
							$updUserlist[$key]->location_interval = 10; // in minutes
                        }

                        $user_type = 'SCRT';

                        $get_attId = attendanceModel::where('user_id', $secId)->orderByDesc('id')->first();

                        if(!is_null($get_attId) && $get_attId->count() > 0){

                            if(empty($get_attId->logout)){

                                $logout = Carbon::now('Asia/Kolkata')->toDateTimeString();

                                $updArr = [
                                    'logout' => $logout,
                                ];
                                
                                $updAtt = attendanceModel::where('id', $get_attId->id)->update($updArr);

                            }

                        }

                    }elseif ($u_type == 'SPVR') {
                        $updOldUser = supervisorModel::where('mobile','=',$u_mobile)->update($upd); 
                        $updUserlist = supervisorModel::select('spvr_id','name','mobile','email','gender','api_token','fcm_id','device_name','device_model','os_version','latitude','longitude','status')->where('mobile', '=', $u_mobile)->get(); 

                        foreach($updUserlist as $spkey => $spvrList){
                            $updUserlist[$spkey]->location_interval = 3;
                        }

                        $user_type = 'SPVR';            
                    }elseif ($u_type == 'CLNT') {
                        $updOldUser = clientModel::where('mobile','=',$u_mobile)->update($upd);
                        $updUserlist = clientModel::select('clnt_id','c_name','mobile','email','gender','api_token','fcm_id','device_name','device_model','os_version','latitude','longitude','status')->where('mobile', '=', $u_mobile)->get(); 
                        $user_type = 'CLNT';              
                    }

                    return response()->json([
                        'success'=>true,
                        'code'=>200,
                        'message'=>'Login Successfully!',
                        'user_type' => $user_type,
                        'res'=>$updUserlist
                        
                    ]);
                }else{

                    return response()->json([
                        'error'=>true,
                        'code'=>201,
                        'message'=>'Incorrect Password!'                      
                    ]);

                }

            }else{
                return response()->json([
                    'success'=>true,
                    'code'=>201,
                    'message'=>'Mobile Not Registered!'                      
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

    public function userlogout(Request $req)
    {
        $user_id = $req->user_id;
        $u_type = $req->user_type;

        if($u_type == 'SCRT'){
            $get_dtl = securityModel::select('*')->where('scrt_id', '=', $user_id)->get();
        }elseif ($u_type == 'SPVR') {
            $get_dtl = supervisorModel::select('*')->where('spvr_id', '=', $user_id)->get();                
        }elseif ($u_type == 'CLNT') {
            $get_dtl = clientModel::select('*')->where('clnt_id', '=', $user_id)->get();                
        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'Unknown User Type!'                      
            ]);
        }

        if(!is_null($get_dtl) && $get_dtl->count() > 0){

            $updUser = [
                'fcm_id' => '',
                'api_token' => '',
            ];

            if($u_type == 'SCRT'){
                $updOldUser = securityModel::where('scrt_id','=',$user_id)->update($updUser);

                $get_attId = attendanceModel::where('user_id', $user_id)->orderByDesc('id')->first();

                if(!is_null($get_attId) && $get_attId->count() > 0){

                    if(empty($get_attId->logout)){

                        $logout = Carbon::now('Asia/Kolkata')->toDateTimeString();

                        $updArr = [
                            'logout' => $logout,
                        ];
                        
                        $updAtt = attendanceModel::where('id', $get_attId->id)->update($updArr);

                    }

                }                

            }elseif ($u_type == 'SPVR') {
                $updOldUser = supervisorModel::where('spvr_id','=',$user_id)->update($updUser);             
            }elseif ($u_type == 'CLNT') {
                $updOldUser = clientModel::where('clnt_id','=',$user_id)->update($updUser);            
            }

            return response()->json([
                'success'=>true,
                'code'=>200,
                'message'=>'Logout Successfully!'
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'code'=>201,
                'message'=>'No Users Found!'
            ]);
        }
    }

    // Security

    public function worklogin(Request $req)
    {
        if(!empty($req->latitude) && !empty($req->longitude)){

            $user_id = $req->user_id;
            $user_type = $req->user_type;

            $latitude = $req->latitude;
            $longitude = $req->longitude;

            $getSupId = securityModel::select('*')->where('scrt_id', '=', $user_id)->get();
			
			$secName = "NA";

            foreach($getSupId as $sid){
				$secName = $sid->name;
                $assign = $sid->assign;
				$building_id = $sid->building_id;
                // $assign_by = $sid->supervised_by;
            }

            $assign_by = $req->supervised_by;
            // dd($assign_by);

            if($assign == 'U'){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'You are not Assigned!'
                ]);
            }

            $login = Carbon::now('Asia/Kolkata')->toDateTimeString();

            $attArr = [

                'user_id' => $user_id,
                'user_type' => $user_type,
                'building_id' => $building_id,
                'supervised_by' => $assign_by,
                'login' => $login,
                // 'logout' => '0000-00-00 00:00:00',
                'latitude' => $latitude,
                'longitude' => $longitude,

            ];
			
			// $getCPID = securityModel::select('building_id','supervised_by')->where('scrt_id', $user_id)->first();

            // return $getCPID;

          $building_id_in=$req->building_id;

            $getlatlng = clientModel::select('bl_lat', 'bl_lng')->where('building_id', $building_id_in)->first();

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

                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'You are not in Client Place!'
                ]);
                
            }
            
            $insAtt = attendanceModel::insertGetId($attArr);

            if($insAtt > 0){
				
				$title = 'Work Login'; $body = 'Security Logged In. Name : '.$secName;

                $content = [
                    'title' => $title,
                    'body' => $body,
                ];

                $getSfcmId = supervisorModel::select('fcm_id')->where('spvr_id','=',$assign_by)->get();

                $this->send_notification($getSfcmId, $content);

                $getCfcmId = clientModel::select('fcm_id')->where('building_id','=',$building_id)->get();

                $this->send_notification($getCfcmId, $content);
				
				$locArr = [
                    'user_id' => $user_id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
    
                $insLoc = tracklocModel::insertGetId($locArr);

                $getLogDtls = attendanceModel::select('id as attendance_id','building_id','supervised_by','login','logout','latitude','longitude')->where('id', $insAtt)->get();

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Login Successfully!',
					'location_interval' => 10,
                    'res' => $getLogDtls
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Login Failed!'
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


    public function worklogout(Request $req)
    {
        if(!empty($req->attendance_id)){

            $attendance_id = $req->attendance_id;
            $user_id = $req->user_id;
            $user_type = $req->user_type;

            $chkAtt = attendanceModel::where('id', $attendance_id)->where('user_id', $user_id)->get();

            if($chkAtt->count() > 0){
				
				
				$getSupId = securityModel::select('*')->where('scrt_id', '=', $user_id)->get();
				$secName = "NA";

				foreach($getSupId as $sid){
					$secName = !empty($sid->name)?$sid->name:'';
					$assign = !empty($sid->assign)?$sid->assign:'';
					// $building_id = !empty($sid->building_id)?$sid->building_id:'';
					// $assign_by = !empty($sid->supervised_by)?$sid->supervised_by:'';
				}
                $building_id = $req->building_id;
					$assign_by = $req->supervised_by;
				
                // dd($secName,$assign,$building_id,$assign_by);

                $logout = Carbon::now('Asia/Kolkata')->toDateTimeString();

                $updArr = [
                    'logout' => $logout,
                ];
                
                $updAtt = attendanceModel::where('id', $attendance_id)->update($updArr);

                if($updAtt > 0){
					
					$title = 'Work Logout'; $body = 'Security Logged Out. Name : '.$secName;

                    $content = [
                        'title' => $title,
                        'body' => $body,
                    ];

                    $getSfcmId = supervisorModel::select('fcm_id')->where('spvr_id','=',$assign_by)->get();

                    $this->send_notification($getSfcmId, $content);

                    $getCfcmId = clientModel::select('fcm_id')->where('building_id','=',$building_id)->get();

                    $this->send_notification($getCfcmId, $content);
					
                    return response()->json([
                        'success'=>true,
                        'code'=>200,
                        'message'=>'Logout Successfully!'
                    ]);

                }else{
                    return response()->json([
                        'success'=>true,
                        'code'=>200,
                        'message'=>'Logout Failed!'
                    ]);
                }

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Id Not Available!'
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

    // Supervisor

    public function listsecurites(Request $req){

        if(!empty($req->listby) && !empty($req->building_id)){
            //
            $building_id=$req->building_id;
            $listby = $req->listby;
            $user_id = $req->user_id;

            $scrt = securityModel::select('scrt_id', 'name', 'mobile', 'supervised_by', 'assign', 'building_id')->get();

            // start security value 
            $security=array();
            foreach($scrt as $value){
                $supervised = explode(',', $value->supervised_by);
              if (in_array($user_id, $supervised))
              {
                $security[]=$value; 
              }

            }

            if(count($security)==0){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No data Found!',
                    'res' => []
                ]);
            }
           // end security value 


          // start   active user unactive user 


        //   return $building_id;
        $active=array();
        $unactive=array();
          foreach($security as $sec){
           $type=DB::table('assign_buildings')->where('assign','A')->where('building_id',$building_id)->where('scrt_id',$sec->scrt_id)->where('assign_by',$user_id)->count();
        //    dd($type);
          if ($type==1)
          {
            $active[]=$sec; 
          }else{
            $unactive[]=$sec;
          }

        }
        // dd(count($active),count($unactive));
        
        if($listby=='U'){
            // $getSecList=$active;
            $getSecList=$security;

        }
        if($listby=='A'){
            $getSecList=$unactive;
        }

          // end   active user unactive user 
           
            if(count($getSecList) > 0){

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Data Found!',
                    'res' => $getSecList
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'No data Found!',
                    'res' => []
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

    public function assignBuilding(Request $req)
    {
        if(!empty($req->scrt_id) && !empty($req->building_id) && !empty($req->assign)){

            $user_id = $req->user_id;
            $scrt_id = $req->scrt_id;
            $building_id = $req->building_id;
            $assign = $req->assign;

            $getAssDtl = clientModel::where('building_id', $building_id)->get();

            

            foreach($getAssDtl as $assbuild){
                $b_assign = $assbuild->assign;
                $scrt_count = $assbuild->scrt_count;
                $build_name = $assbuild->b_name;
            }

            if($assign == 'U' && $b_assign == 'U'){
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Building Already In Unassigned State!'
                ]);         
            }   
            
            
            // assign buildings delete
$att=assign_buildingsModel::where('scrt_id',$scrt_id)->where('building_id',$building_id)->where('assign_by',$user_id)->delete();

// return $att;
// assign buildings delete

            $assArr = [
                'scrt_id' => $scrt_id,
                'building_id' => $building_id,
                'assign' => $assign,
                'assign_by' => $user_id,
            ];

            $insBuild = assign_buildingsModel::insertGetId($assArr);

            if($insBuild > 0){

                $build_name = !empty($build_name)?$build_name:'NA';

                $title = 'Assign Building'; 

                if($assign == 'U'){
                    $body = 'You are Unassigned from '.$build_name;
                }else{
                    $body = 'You Assigned, Building Name : '.$build_name;
                }

                $content = [
                    'title' => $title,
                    'body' => $body,
                ];

                $getSfcmId = securityModel::select('name','fcm_id')->where('scrt_id','=',$scrt_id)->get();

                $secName = 'NA';

                foreach ($getSfcmId as $fcmVal) {
                    $secName = $fcmVal->name;
                }

                $this->send_notification($getSfcmId, $content);

                $getCfcmId = clientModel::select('fcm_id')->where('building_id','=',$building_id)->get();

                if($assign == 'U'){
                    $body = 'Your building Unassigned from '.$secName;
                }else{
                    $body = 'Your building Assigned to Security. Name : '.$secName;
                }

                $content = [
                    'title' => $title,
                    'body' => $body,
                ];

                $this->send_notification($getCfcmId, $content);

                $updSec = [
                    'assign' => $assign,
                    'building_id' => ($assign != 'U')?$building_id:'',
                    // 'supervised_by' => $user_id
                ];

                securityModel::where('scrt_id', $scrt_id)->update($updSec);

                if($assign == 'U'){
                    $sc = $scrt_count-1;
                    $updBuild = [
                        //'assign' => $assign,
                        'scrt_count' => $sc
                    ];    
					
					if($sc == 0){
                        $updBuild['assign'] = $assign;
                    }


                    clientModel::where('building_id', $building_id)->update($updBuild);          
                }

                if($assign == 'A'){
                    $sc = $scrt_count+1;
                    $updBuild = [
                        'assign' => $assign,
                        'scrt_count' => $sc
                    ];      
                    
                    clientModel::where('building_id', $building_id)->update($updBuild);
                }

                return response()->json([
                    'success'=>true,
                    'code'=>200,
                    'message'=>'Assign Building Successfully!'
                ]);


            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Assign Building Failed!'
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

    public function send_notification($getfcmId, array $content)
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

            

            $data = json_encode($json_data);
                // print_r($data);
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
   curl_close($ch);
        }
        // return $result;
     
    }
}
