<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;

use PDF;

use App\Models\Tables\payslip as payslipModel;

class Payslip extends Component
{

    public $name, $empid, $designation, $uan, $esino, $monthandyear, $clientname, $bank, $bankaccno, $bankifsccode, $noofduties, $overtime, $totalworkingdays, $basicpay, $dapay, $otpay, $epf, $esi, $uniformdeduction, $advance, $others, $totaldeduction, $gross_salary, $net_pay, $psId,$empdtls=[], $slipfor, $clientloc,$dropdown,$customer_dropdown1,$search_customer1;
    
    protected $listeners = ['editPayslip' ,'downloadPayslip', 'deletePayslip'];
	
	protected $rules = [
        'name' => 'required|nullable',
        'designation' => 'required|nullable',
        'noofduties' => 'required|nullable|numeric',
        'overtime' => 'required|nullable|numeric',
        'totalworkingdays' => 'required|nullable|numeric',
        'basicpay' => 'required|nullable|numeric',
        'net_pay' => 'required|nullable|numeric',
    ];

    // protected $rules = [
    //     'name' => 'nullable',
    //     'empid' => 'nullable',
    //     'designation' => 'nullable',
    //     'uan' => 'nullable',
    //     'esino' => 'nullable',
    //     'monthandyear' => 'nullable',
    //     'clientname' => 'nullable',
    //     'bank' => 'nullable',
    //     'bankaccno' => 'nullable',
    //     'bankifsccode' => 'nullable',
    //     'noofduties' => 'nullable',
    //     'overtime' => 'nullable',
    //     'totalworkingdays' => 'nullable',
    //     'basicpay' => 'nullable',
    //     'dapay' => 'nullable',
    //     'otpay' => 'nullable',
    //     'epf' => 'nullable',
    //     'esi' => 'nullable',
    //     'uniformdeduction' => 'nullable',
    //     'advance' => 'nullable',
    //     'others' => 'nullable',
    //     'totaldeduction' => 'nullable',
    //     'gross_salary' => 'nullable',
    //     'net_pay' => 'nullable',
    // ];
	
	public function mount(){
		$this->slipfor = "";
		$this->name = "";
	}

	
      public function customer_selected1($id, $sId){
    //dd($id);
    $this->name=$id;
    $this->dropdown = !$this->dropdown;
        $empId = $sId;
        $empType = $this->slipfor;
          // dd($empId);
        $this->bank = '';
        $this->bankaccno = '';
        $this->bankifsccode = '';
        $this->esino = '';
        $this->uan = '';
        $this->designation = '';
        $this->clientname = '';
        $this->clientloc = '';

        if($empType == 'scrt'){
            // $getbase = securityModel::select('name', 'scrt_id as emp_id', 'mobile')->get();
            $getdtls = securityModel::select('*')->where('id', $empId)->first();
            // dd($getdtls);
            $this->designation = 'Security';
            if (!is_null($getdtls) && !empty($getdtls)) {
                $building_id=$getdtls->building_id;
            }else{
                $building_id='';
            }
            
            
            $getClntdtls = clientModel::select('c_name', 'area')->where('building_id', $building_id)->first();

            // dd($building_id);

            if(!is_null($getClntdtls) && $getClntdtls->count() > 0){

                $clName = !empty($getClntdtls->c_name)?$getClntdtls->c_name:'';
                $clLoc = !empty($getClntdtls->area)?$getClntdtls->area:'';

                $this->clientname = $clName;
                $this->clientloc = $clLoc;
            
            }
            
        }else{
            // $getbase = supervisorModel::select('name', 'spvr_id as emp_id', 'mobile')->get();
            $getdtls = supervisorModel::select('*')->where('id', $empId)->first();
            $this->designation = 'Operation Team';
        }

        // $this->empdtls = $getbase;
        
        //$this->slipforchange();

        $this->bank = !empty($getdtls->bankname)?$getdtls->bankname:'';
        $this->bankaccno = !empty($getdtls->bankacno)?$getdtls->bankacno:'';
        $this->bankifsccode = !empty($getdtls->ifsccode)?$getdtls->ifsccode:'';
        $this->esino =!empty($getdtls->esino)?$getdtls->esino:'';
        $this->uan = !empty($getdtls->uan)?$getdtls->uan:'';

        // dd($getdtls);
    
  }
  public function customer_dropdown1()
    {
        $this->dropdown = !$this->dropdown;
    }
	
	
    public function render()
    {
		//$this->slipfor = "";
    dd('j');
      

      $getbase = [];
// $this->search_customer1='sri';
        if($this->slipfor == 'scrt'){
            $getbase = securityModel::select('*')->where('name', 'like', '%' . $this->search_customer1 . '%')->get();
           
        }elseif($this->slipfor == 'spvr'){
            $getbase = supervisorModel::select('*')->where('name', 'like', '%' . $this->search_customer1 . '%')->get();
        }
        

        $this->empdtls = $getbase;
        // dd($getbase);
		$this->slipforchange();
        return view('livewire.dashboard.payslip')->extends('layouts.main');
    }

    public function convert_number($number){
            
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");

        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }

    public function addPaySlip()
    {
		
		$this->validate();
		
		$empId = $this->name;
		
		$gName = "";
        // dd($empId);
		
		if($this->slipfor == 'scrt'){
            $getName = securityModel::select('name')->where('name', 'like', '%' . $this->search_customer1 . '%')->first();
             // dd($getName);
			$gName = $getName->name;
        }elseif($this->slipfor == 'spvr'){
            $getName = supervisorModel::select('name')->where('name', 'like', '%' . $this->search_customer1 . '%')->first();
			$gName = $getName->name;
        }
		
		//dd($getName);

        $insPaySlip = [

            'name' => $gName,
            'empid' => $this->name,
            'designation' => $this->designation,
            'uan' => $this->uan,
            'esino' => $this->esino,
            'monthandyear' => $this->monthandyear,
            'clientname' => $this->clientname,
            'bank' => $this->bank,
            'bankaccno' => $this->bankaccno,
            'bankifsccode' => $this->bankifsccode,
            'noofduties' => $this->noofduties,
            'overtime' => $this->overtime,
            'totalworkingdays' => $this->totalworkingdays,
            'basicpay' => $this->basicpay,
            'dapay' => $this->dapay,
            'otpay' => $this->otpay,
            'epf' => $this->epf,
            'esi' => $this->esi,
            'uniformdeduction' => $this->uniformdeduction,
            'advance' => $this->advance,
            'others' => $this->others,
            'totaldeduction' => $this->totaldeduction,
            'gross_salary' => $this->gross_salary,
            'net_pay' => $this->net_pay,
        ];

        $payId = payslipModel::insertGetId($insPaySlip);

        if($payId > 0){

            ini_set('max_execution_time', 6000);
            ini_set('memory_limit', '4000M');

            $monthYear =   str_replace('/','_',$this->monthandyear).'_'.strtotime(rand(1000, 8980));

            // $name = $this->name;
            // $empId = $this->empid;
            // $month_and_year = $this->monthandyear;

            $name = $gName;
            $empid = $this->name;
            $designation = $this->designation;
            $uan = $this->uan;
            $esino = $this->esino;
            $monthandyear = $this->monthandyear;
            $clientname = $this->clientname;
            $bank = $this->bank;
            $bankaccno = $this->bankaccno;
            $bankifsccode = $this->bankifsccode;
            $noofduties = $this->noofduties;
            $overtime = $this->overtime;
            $totalworkingdays = $this->totalworkingdays;
            $basicpay = $this->basicpay;
            $dapay = $this->dapay;
            $otpay = $this->otpay;
            $epf = $this->epf;
            $esi = $this->esi;
            $uniformdeduction = $this->uniformdeduction;
            $advance = $this->advance;
            $others = $this->others;
            $totaldeduction = $this->totaldeduction;
            $gross_salary = $this->gross_salary;
            $net_pay = $this->net_pay;
            
            $netpayinwords = $this->convert_number($net_pay);
            
            // dd($monthYear);

            $pdf = PDF::loadView('layouts.invoice', compact('name','empid','designation','uan','esino','monthandyear','clientname','bank','bankaccno','bankifsccode','noofduties','overtime','totalworkingdays','basicpay','dapay','otpay','epf','esi','uniformdeduction','advance','others','totaldeduction','gross_salary','net_pay', 'netpayinwords'));

            $path = 'assets/invoice';
            $rootFolder = 'storage/'.$path;
            $fileName = $name.'_'.'Payslip'.'_'.$monthYear.'_'.$empid.'.pdf';
            // $fileName = 'Payslip.pdf';
            $pdf->save($rootFolder . '/' . $fileName);
            $saveInvoice = $pdf->download($fileName);

            $updPay = [
                'pdf_file' => $path.'/'.$fileName,
            ];

            $updPaySlip = payslipModel::where('id', $payId)->update($updPay);

            $downloadLink = 'http://'.request()->getHost(). '/' .$rootFolder . '/' . $fileName;

            $this->dispatchBrowserEvent('downloadPdf',['downloadLink' => $downloadLink,'fileName'=>$fileName]);

            session()->flash('payslipMessage', 'Payslip Added Successfully!');
            return redirect()->to('/payslip');
            
        }else{
            session()->flash('payslipMessage', 'Payslip Added Failed!');
            return redirect()->to('/payslip');
        }

    }
	
	public function slipforchange()
    {
        // dd($this->slipfor);
		
		// $getbase = "";

  //       if($this->slipfor == 'scrt'){
  //           $getbase = securityModel::select('name', 'scrt_id as emp_id', 'mobile')->get();
  //       }elseif($this->slipfor == 'spvr'){
  //           $getbase = supervisorModel::select('name', 'spvr_id as emp_id', 'mobile')->get();
  //       }

  //       $this->empdtls = $getbase;
        
        // dd($this->empdtls);

    }
	
	public function empchange()
    {
      

        $empId = $this->name;
        $empType = $this->slipfor;
		  // dd($empId);
		$this->bank = '';
        $this->bankaccno = '';
        $this->bankifsccode = '';
        $this->esino = '';
        $this->uan = '';
        $this->designation = '';
        $this->clientname = '';
        $this->clientloc = '';

        if($empType == 'scrt'){
            // $getbase = securityModel::select('name', 'scrt_id as emp_id', 'mobile')->get();
            $getdtls = securityModel::select('*')->where('scrt_id', $empId)->first();
            // dd($getdtls);
            $this->designation = 'Security';
			
			$getClntdtls = clientModel::select('c_name', 'area')->where('building_id', $getdtls->building_id)->first();

            if(!is_null($getClntdtls) && $getClntdtls->count() > 0){

                $clName = !empty($getClntdtls->c_name)?$getClntdtls->c_name:'';
                $clLoc = !empty($getClntdtls->area)?$getClntdtls->area:'';

                $this->clientname = $clName;
                $this->clientloc = $clLoc;
            
            }
			
        }else{
            // $getbase = supervisorModel::select('name', 'spvr_id as emp_id', 'mobile')->get();
            $getdtls = supervisorModel::select('*')->where('spvr_id', $empId)->first();
            $this->designation = 'Operation Team';
        }

        // $this->empdtls = $getbase;
		
		//$this->slipforchange();

        $this->bank = $getdtls->bankname;
        $this->bankaccno = !empty($getdtls->bankacno)?!empty($getdtls->bankacno):'';
        $this->bankifsccode = !empty($getdtls->ifsccode)?!empty($getdtls->ifsccode):'';
        $this->esino =!empty($getdtls->esino)?!empty($getdtls->esino):'';
        $this->uan = !empty($getdtls->uan)?!empty($getdtls->uan):'';

        // dd($getdtls);

    }

    public function editPayslip($obj)
    {
        // dd($obj['ps_id']);

        $ps_id = $obj['ps_id'];

        $this->psId = $ps_id;

        $editPaySlip = payslipModel::where('id', $ps_id)->first();

        $this->name = $editPaySlip->name;
        $this->empid = $editPaySlip->empid;
        $this->designation = $editPaySlip->designation;
        $this->uan = $editPaySlip->uan;
        $this->esino = $editPaySlip->esino;
        $this->monthandyear = $editPaySlip->monthandyear;
        $this->clientname = $editPaySlip->clientname;
        $this->bank = $editPaySlip->bank;
        $this->bankaccno = $editPaySlip->bankaccno;
        $this->bankifsccode = $editPaySlip->bankifsccode;
        $this->noofduties = $editPaySlip->noofduties;
        $this->overtime = $editPaySlip->overtime;
        $this->totalworkingdays = $editPaySlip->totalworkingdays;
        $this->basicpay = $editPaySlip->basicpay;
        $this->dapay = $editPaySlip->dapay;
        $this->otpay = $editPaySlip->otpay;
        $this->epf = $editPaySlip->epf;
        $this->esi = $editPaySlip->esi;
        $this->uniformdeduction = $editPaySlip->uniformdeduction;
        $this->advance = $editPaySlip->advance;
        $this->others = $editPaySlip->others;
        $this->totaldeduction = $editPaySlip->totaldeduction;
        $this->gross_salary = $editPaySlip->gross_salary;
        $this->net_pay = $editPaySlip->net_pay;

        $this->dispatchBrowserEvent('editPSEntry');

    }

    public function updPaySlip()
    {

        $pId = $this->psId;

        $updPaySlip = [

            'name' => $this->name,
            'empid' => $this->empid,
            'designation' => $this->designation,
            'uan' => $this->uan,
            'esino' => $this->esino,
            'monthandyear' => $this->monthandyear,
            'clientname' => $this->clientname,
            'bank' => $this->bank,
            'bankaccno' => $this->bankaccno,
            'bankifsccode' => $this->bankifsccode,
            'noofduties' => $this->noofduties,
            'overtime' => $this->overtime,
            'totalworkingdays' => $this->totalworkingdays,
            'basicpay' => $this->basicpay,
            'dapay' => $this->dapay,
            'otpay' => $this->otpay,
            'epf' => $this->epf,
            'esi' => $this->esi,
            'uniformdeduction' => $this->uniformdeduction,
            'advance' => $this->advance,
            'others' => $this->others,
            'totaldeduction' => $this->totaldeduction,
            'gross_salary' => $this->gross_salary,
            'net_pay' => $this->net_pay,
        ];

        $payId = payslipModel::where('id', $pId)->update($updPaySlip);
		
		if($payId){

            ini_set('max_execution_time', 6000);
            ini_set('memory_limit', '4000M');

            $monthYear = str_replace('/','_',$this->monthandyear).'_'.strtotime(rand(1000, 8980));

            // $name = $this->name;
            // $empId = $this->empid;
            // $month_and_year = $this->monthandyear;

            $name = $this->name;
            $empid = $this->empid;
            $designation = $this->designation;
            $uan = $this->uan;
            $esino = $this->esino;
            $monthandyear = $this->monthandyear;
            $clientname = $this->clientname;
            $bank = $this->bank;
            $bankaccno = $this->bankaccno;
            $bankifsccode = $this->bankifsccode;
            $noofduties = $this->noofduties;
            $overtime = $this->overtime;
            $totalworkingdays = $this->totalworkingdays;
            $basicpay = $this->basicpay;
            $dapay = $this->dapay;
            $otpay = $this->otpay;
            $epf = $this->epf;
            $esi = $this->esi;
            $uniformdeduction = $this->uniformdeduction;
            $advance = $this->advance;
            $others = $this->others;
            $totaldeduction = $this->totaldeduction;
            $gross_salary = $this->gross_salary;
            $net_pay = $this->net_pay;
            
            $netpayinwords = $this->convert_number($net_pay);
            
            // dd($monthYear);

            $pdf = PDF::loadView('layouts.invoice', compact('name','empid','designation','uan','esino','monthandyear','clientname','bank','bankaccno','bankifsccode','noofduties','overtime','totalworkingdays','basicpay','dapay','otpay','epf','esi','uniformdeduction','advance','others','totaldeduction','gross_salary','net_pay', 'netpayinwords'));

            $path = 'assets/invoice';
            $rootFolder = 'storage/'.$path;
            $fileName = $name.'_'.'Payslip'.'_'.$monthYear.'_'.$empid.'.pdf';
            // $fileName = 'Payslip.pdf';
            $pdf->save($rootFolder . '/' . $fileName);
            $saveInvoice = $pdf->download($fileName);

            $updPay = [
                'pdf_file' => $path.'/'.$fileName,
            ];

            $updPaySlip = payslipModel::where('id', $pId)->update($updPay);
        }

        session()->flash('payslipMessage', 'Payslip Successfully Updated!');
        return redirect()->to('/payslip');
    }

    public function downloadPayslip($obj)
    {
        // dd($obj['ps_id']);
        $ps_id = $obj['ps_id'];

        $updPaySlip = payslipModel::where('id', $ps_id)->first();

        $fileName = str_replace("assets/invoice/","", $updPaySlip->pdf_file);

        $downloadLink = 'http://'.request()->getHost().'/storage/'.$updPaySlip->pdf_file;

        // dd($downloadLink);

        $this->dispatchBrowserEvent('downloadPdf',['downloadLink' => $downloadLink,'fileName'=>$fileName]);

    }
    
    public function deletePayslip($obj)
    {
        // dd($obj['ps_id']);
        $ps_id = $obj['ps_id'];

        $this->psId = $ps_id;

        $this->dispatchBrowserEvent('deletePSEntry');

    }

    public function removePayslip()
    {
        $pId = $this->psId;

        $delPayslip = payslipModel::where('id', $pId)->delete();

        session()->flash('payslipMessage', 'Payslip Deleted Successfully!');
        return redirect()->to('/payslip');

    }
	public function closeModal()
    {
                
        $this->name = "";
        $this->empid = "";
        $this->designation = "";
        $this->uan = "";
        $this->esino = "";
        $this->monthandyear = "";
        $this->clientname = "";
        $this->bank = "";
        $this->bankaccno = "";
        $this->bankifsccode = "";
        $this->noofduties = "";
        $this->overtime = "";
        $this->totalworkingdays = "";
        $this->basicpay = "";
        $this->dapay = "";
        $this->otpay = "";
        $this->epf = "";
        $this->esi = "";
        $this->uniformdeduction = "";
        $this->advance = "";
        $this->others = "";
        $this->totaldeduction = "";
        $this->gross_salary = "";
        $this->net_pay = "";
		$this->slipfor = "";
		$this->clientloc = "";
    }

}
