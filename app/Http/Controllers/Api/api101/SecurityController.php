<?php

namespace App\Http\Controllers\Api\api101;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SecurityController extends Controller
{

   

    public function assign_buildings(Request $req){


$building=DB::table('assign_buildings')->where('assign_buildings.assign','A')->where('assign_buildings.scrt_id',$req->user_id)
->leftjoin('client', 'client.building_id', '=', 'assign_buildings.building_id')
->select('client.building_id','client.b_name','assign_buildings.assign_by as supervised_by')
->get();

if(count($building)>0){
        return response()->json([
            'success'=>true,
            'code'=>200,
            'message'=>'Data Found!',
            'res'=>$building,
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

    public function Security_supervisor_contact(Request $req){


        $building=DB::table('security')->where('scrt_id',$req->user_id)->first();
        
        
if($building){

    $super = explode(',', $building->supervised_by);
    // dd($super);
    $fullvalue=array();
    foreach($super as $value){
        $supervisor=DB::table('supervisor')->where('spvr_id',$value)->select('name','mobile','email')->get();
        if(count($supervisor)>0){
            $fullvalue[]=$supervisor[0];
        } 

    }



    if(count($fullvalue)>0){
        return response()->json([
            'success'=>true,
            'code'=>200,
            'message'=>'Data Found!',
            'res'=>$fullvalue,
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
        'code'=>201,
        'message'=>'No Data!',
        'res'=>[]
    ]); 
}
            }
    


                    public function client_branch_list(Request $req){


                        $building=DB::table('client')->select('building_id','b_name','branch','clnt_id')->where('clnt_id',$req->user_id)->get();
        
//                         $branch=DB::table('client')->select('building_id','b_name','branch')->where('branch_id',$building[0]->clnt_id)->get();
//                         // return $branch;

//                         $fullvalue=array();
//                         $fullvalue[]=$building[0];
//                         if(count($fullvalue)>0){
                        
// foreach($branch as $v){
//     $fullvalue[]=$v;
// }
//                         }
                        if(count($building)>0){
                            return response()->json([
                                'success'=>true,
                                'code'=>200,
                                'message'=>'Data Found!',
                                'res'=>$building,
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






}
