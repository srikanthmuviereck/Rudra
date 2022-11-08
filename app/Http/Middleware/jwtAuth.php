<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Http\Controllers\jwtController as JWT;

class jwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $secret = env('JWT_SECRET');
        $algo = 'HS256';#env('JWT_ALGO');

        $jwt = new JWT();

        // $payload = [
        //     'iat' => time(), /* issued at time */
        //     'iss' => 'LjG8Lv29L0UrVJfaWsQhPS6irkLjs1eR',
        //     'exp' => time() + (3060), /* expires after 1 minute */
        //     'sub' => 'Muviereck Authentication'
        // ];

        // $token = $jwt::encode($payload,$secret);

        try{
            $token = $jwt->getBearerToken();
        }catch(Exception $e){
            return response()->json([
                'error'=>true,
                'code'=>401,
                'message'=>$e->getMessage()
            ]);
        }

        if(!empty($token) && $token != ''){

            try{
                // JWT::$leeway = 60;
                $payload = $jwt->decode($token, $secret, [$algo]);

                // return $payload;
                if(!isset($payload->iss) || $payload->iss != 'LjG8Lv29L0UrVJfaWsQhPS6irkLjs1eR'){
                    return response()->json([
                        'error'=>true,
                        'code'=>401,
                        'message'=>'Invalid Hash!',
						//'payload' => $payload
                    ]);
                }else{
                    return $next($request);
                }
            }catch (Exception $e){
                return response()->json([
                    'error'=>true,
                    'code'=>401,
                    'message'=>$e->getMessage()
                ]);
            }

        }else{
            return response()->json([
                'error'=>true,
                'code'=>401,
                'message'=>'Unauthorized access not allowed!'
            ]);
        }        
        
    }
}
