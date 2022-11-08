<?php

namespace App\Http\Livewire\Login;

use Livewire\Component;

use DB;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Component
{

    public $email, $password, $remember_me;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.login.login-form')->extends('layouts.login');
    }
	
	public function mount()
    {
        if(session()->has('authToken') != '' && session()->has('authMail')){

            $token = session()->get('authToken');
            $mail = session()->get('authMail');

            $get_sess = DB::table('rudhra_adminlogin')->where('token',$token)->where('email',$mail)->get();

            if($get_sess->count() > 0){
                    return redirect()->route('welcome');
            }
        }
    }

    public function submit()
    {

        $attributes = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = DB::table('rudhra_adminlogin')->where('email', '=', $this->email)->get();

        if($data->count() > 0){

            $u_pass = $this->password;

            $password = "";

            foreach($data as $udata){
                $password = $udata->password;
            }

            if(Hash::check($u_pass, $password)){

            

            // Hash::check($u_pass, $password)


            // auth()->login($data);

                $token = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

                $updToken = [
                    'token'=> $token
                ];

                $updData = DB::table('rudhra_adminlogin')->where('email', '=', $this->email)->update($updToken);

                session()->put('authToken',$token);
                session()->put('authMail',$this->email);
                
                return redirect()->route('welcome')->back()->with(['login_success'=> 'Hi, Welcome Back!']);

            }else{
                $this->addError('login_error','Invalid Password');
            }
        }
        else{
            $this->addError('login_error','Invalid Email / Password');
        }
        // return redirect()->route('welcome');
    }
}
