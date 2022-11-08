<?php

namespace App\Http\Controllers\Api\api100;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SecurityController extends Controller
{

   

    public function assign_buildings(Request $req){


$building=DB::table('assign_buildings')->where('assign_buildings.assign','A')->where('assign_buildings.scrt_id',$req->user_id)
->leftjoin('client', 'client.building_id', '=', 'assign_buildings.building_id')
->select('client.building_id','client.b_name')
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




}
