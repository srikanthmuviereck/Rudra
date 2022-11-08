<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use Illuminate\Support\Facades\Hash;
use DB;

class Settings extends Component
{

    public $terms, $privacy, $abt, $c_mble,$c_wapp,$c_mail;

    public $admin_email_new, $admin_pass_new ,$admin_mail,$admin_super, $admin_pass, $admin_id;

    public $tab = 'tandc';

    // public $get_super;

    protected $rules = [
        'c_mble' => 'required|numeric|digits:10',
        'c_wapp' => 'required|numeric|digits:10',
        'c_mail' => 'required|email',        
    ];

    protected $messages = [
        'c_mble' => 'This Field is Mandatory',
        'c_wapp' => 'This Field is Mandatory',
        'c_mail' => 'This Field is Mandatory',   
    ];

    public function render()
    {

        $get_terms = DB::table('settings')->select('value')->where('field','terms')->get();
        $get_privacy = DB::table('settings')->select('value')->where('field','policy')->get();
        $get_about = DB::table('settings')->select('value')->where('field','about')->get();

        $get_admin_dtl = DB::table('rudhra_adminlogin')->select('*')->get();    
        
        $token = session()->get('authToken');
        $mail = session()->get('authMail');

        $chk_super = DB::table('rudhra_adminlogin')->select('superuser')->where('email',$mail)->where('token',$token)->get();
        
        return view('livewire.dashboard.settings',['get_admin_dtl' => $get_admin_dtl, 'get_terms'=>$get_terms, 'get_privacy'=>$get_privacy, 'get_about' => $get_about, 'chk_super'=>$chk_super])->extends('layouts.main');
    }

    public function updTerms()
    {
        // dd($this->terms);  
		if(empty($this->terms)){
			session()->flash('settingMessage', 'No Updates in Terms & Condition, Existing Data Found!');
			return redirect()->to('settings');
		}

        $terms = ['value' => $this->terms];

        DB::table('settings')->where('field','terms')->update($terms);
        session()->flash('settingMessage', 'Settings Terms & Condition Updated Successfully!');
        return redirect()->to('settings');
        
    }

    
    public function updPrivacy()
    {
        // dd($this->terms);
		
		if(empty($this->privacy)){
			session()->flash('settingMessage', 'No Updates in Privacy Policy, Existing Data Found!');
			return redirect()->to('settings');
		}

        $privacy = ['value' => $this->privacy];

        DB::table('settings')->where('field','policy')->update($privacy);
        session()->flash('settingMessage', 'Settings Privacy Policy Updated Successfully!');
        return redirect()->to('settings');
        
    }

    public function updAbout()
    {
        // dd($this->terms);
		
		if(empty($this->abt)){
			session()->flash('settingMessage', 'No Updates in Privacy Policy, Existing Data Found!');
			return redirect()->to('settings');
		}

        $abt = ['value' => $this->abt];

        DB::table('settings')->where('field','about')->update($abt);
        session()->flash('settingMessage', 'Settings About US Updated Successfully!');
        return redirect()->to('settings');
        
    }

    public function getDtl()
    {

        $get_phone = DB::table('settings')->select('value')->where('field','phone')->get();
        $get_mail = DB::table('settings')->select('value')->where('field','mail')->get();
        $get_wapp = DB::table('settings')->select('value')->where('field','whatsapp')->get();


        foreach($get_phone as $phone){
            $mble = $phone->value;
        }

        foreach($get_mail as $mail){
            $email = $mail->value;
        }

        foreach($get_wapp as $wapp){
            $whatsapp = $wapp->value;
        }
        // dd(1);

        $this->c_mble = $mble;
        $this->c_mail = $email;
        $this->c_wapp = $whatsapp;
    }

    public function updContactUS()
    {

        // dd(1);

        $this->validate();

        $mble = [
            'value' => $this->c_mble
        ];
        $email = [
            'value' => $this->c_mail
        ];

        $whatsapp = [
            'value' => $this->c_wapp
        ];

        $upd_phone = DB::table('settings')->where('field','phone')->update($mble);
        $upd_mail = DB::table('settings')->where('field','mail')->update($email);
        $upd_wapp = DB::table('settings')->where('field','whatsapp')->update($whatsapp);

        session()->flash('settingMessage', 'Contact US Policy Updated Successfully!');
        return redirect()->to('settings');
        
    }

    public function InsUser()
    {

        // admin_email,admin_pass

        $email = $this->admin_email_new;
        $pass = $this->admin_pass_new;

        $chk_ext = DB::table('rudhra_adminlogin')->where('email', $email)->get();

        if($chk_ext->count() > 0){
            session()->flash('settingMessage', 'This Email Already Exist!');
            return redirect()->to('settings');
        }

        $ins = [
            'email' => $email,
            'password' => Hash::make($pass),
            'token' => ''
        ];

        DB::table('rudhra_adminlogin')->insertGetId($ins);
        session()->flash('settingMessage', 'User Registered Sucessfully!');
        return redirect()->to('settings');
        
    }

    public function editAdminUser($aid)
    {
        $this->admin_id = $aid;

        $get_admin_dtl = DB::table('rudhra_adminlogin')->where('id', $aid)->get();

        if($get_admin_dtl->count() > 0){

            foreach($get_admin_dtl as $admin){

                $email = $admin->email;
                $super = $admin->superuser;

            }

            $this->admin_mail = $email;
            $this->admin_super = !empty($super)?$super:"";

        }else{
            session()->flash('settingMessage', 'No Users Found!');
            return redirect()->to('settings');
        }
    }

    public function updateAdminUser()
    {
        $id = $this->admin_id;
        // dd($this->admin_super);

        $upd = [
            'email' => $this->admin_mail,
            // 'superuser' => $this->admin_super,
        ];

        // dd($upd);

        if(!empty($this->admin_super)){
            $upd['superuser'] = $this->admin_super;
        }

        if(!empty($this->admin_pass)){
            $upd['password'] = Hash::make($this->admin_pass);
        }

        DB::table('rudhra_adminlogin')->where('id', $id)->update($upd);


        session()->flash('settingMessage', 'Admin User Updated Successfully!');
        return redirect()->to('settings');


    }

    public function deleteAdminUser($aid)
    {
        $this->admin_id = $aid;
    }

    public function removeAdminUser()
    {
        $id = $this->admin_id;

        DB::table('rudhra_adminlogin')->where('id', $id)->delete();
        session()->flash('settingMessage', 'Admin User Deleted Successfully!');
        return redirect()->to('settings');
    }

    public function closeModal()
    {
		$this->resetErrorBag();
		
        $this->admin_id = '';
        $this->admin_mail = '';
        $this->admin_super = '';
        $this->admin_pass  = '';
    } 

}
