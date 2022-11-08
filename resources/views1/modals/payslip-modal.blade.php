<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addPayslipModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPayslipModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-xl">

    <form wire:submit.prevent="addPaySlip">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPayslipModalLabel"> <strong>Add Payslip</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pay Slip For</label><br>

              <select name="" id="" class="form-select"  wire:change="slipforchange()" wire:model.lazy="slipfor">
                <option value="" selected disabled>--Select--</option>
                <option value="scrt">Security</option>
                <option value="spvr">Operation Team</option>
              </select>
              {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="empid"> --}}
              @error('slipfor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
       <!--      <div  class="col-md-4">
                <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Name</label><br>
                {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="name"> --}}
                
                <select  name="" id="" class="form-select"  wire:change="empchange" wire:model.lazy.lazy="name">
                  <option value="" selected disabled>--Select--</option>
                  @if(!empty($empdtls))
                    
                    @foreach($empdtls as $dtls)
                      <option value="{{$dtls->emp_id}}">{{$dtls->name}}({{$dtls->mobile}})</option>
                    @endforeach
                  @endif
                </select>

                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div> -->
               <div class="col-md-4">
            <label for="name" class="fw-normal bg-primary px-4 py-1 text-white rounded">Name *</label><br>
            <div class="input-group" wire:click.prevent='customer_dropdown1'   wire:keydown.shift='customer_dropdown1'>
                <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='name'>
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Securities.."  wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select</th>
                        </thead>
                       
                       @if(count($empdtls)>0)
                       @foreach($empdtls as $key => $value)

                   
                    <tr  tabindex="{{$key}}" wire:keydown.enter="{{$value->name}}" wire:click.prevent="customer_selected1('{{$value->name}}', '{{$value->id}}')" class="cursor-hand table-select" ><td>{{$value->name}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            
        </div>
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Month & Year</label><br>
              <input type="month" class="form-control" id="Image" wire:model.lazy="monthandyear">
              @error('monthandyear') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Designation</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="designation" readonly>
            @error('designation') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">UAN</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="uan">
            @error('uan') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="esino">
            @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bank" readonly>
            @error('bank') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank A/C No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankaccno" readonly>
            @error('bankaccno') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank IFSC Code</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankifsccode" readonly>
            @error('bankifsccode') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Name</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="clientname">
            @error('clientname') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Location</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="clientloc">
            @error('clientloc') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">No. of Duties</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="noofduties">
            @error('noofduties') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Over Time (OT)</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="overtime">
            @error('overtime') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Total Working Days</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totalworkingdays">
            @error('totalworkingdays') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Basic Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="basicpay">
            @error('basicpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">DA</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="dapay">
            @error('dapay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">OT Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="otpay">
            @error('otpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">EPF</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="epf">
            @error('epf') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="esi">
            @error('esi') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Uniform Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="uniformdeduction">
            @error('uniformdeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Advance</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="advance">
            @error('advance') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Others</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="others">
            @error('others') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Gross Salary</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="gross_salary">
            @error('gross_salary') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Total Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totaldeduction">
            @error('totaldeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Net Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="net_pay">
            @error('net_pay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->

<div wire:ignore.self class="modal fade" id="editPayslipModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPayslipModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-xl">

    <form wire:submit.prevent="updPaySlip">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPayslipModalLabel"> <strong>Add Payslip</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">
<input wire:model.lazy="psId" type="hidden" name=""  id="">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pay Slip For</label><br>

              <select name="" id="" class="form-select"  wire:change="slipforchange()" wire:model.lazy="slipfor">
                <option value="" selected disabled>--Select--</option>
                <option value="scrt">Security</option>
                <option value="spvr">Supervisor</option>
              </select>
              {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="empid"> --}}
              @error('slipfor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div  class="col-md-4">
                <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Name</label><br>
                {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="name"> --}}
                
                <select  name="" id="" class="form-select"  wire:change="empchange" wire:model.lazy.lazy="name">
                  <option value="" selected disabled>--Select--</option>
                  @if(!empty($empdtls))
                    
                    @foreach($empdtls as $dtls)
                      <option value="{{$dtls->emp_id}}">{{$dtls->name}}({{$dtls->mobile}})</option>
                    @endforeach
                  @endif
                </select>

                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Month & Year</label><br>
              <input type="month" class="form-control" id="Image" wire:model.lazy="monthandyear">
              @error('monthandyear') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Designation</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="designation" readonly>
            @error('designation') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">UAN</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="uan">
            @error('uan') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="esino">
            @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bank" readonly>
            @error('bank') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank A/C No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankaccno" readonly>
            @error('bankaccno') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank IFSC Code</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankifsccode" readonly>
            @error('bankifsccode') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Name</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="clientname">
            @error('clientname') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">No. of Duties</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="noofduties">
            @error('noofduties') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Over Time (OT)</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="overtime">
            @error('overtime') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Total Working Days</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totalworkingdays">
            @error('totalworkingdays') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Basic Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="basicpay">
            @error('basicpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">DA</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="dapay">
            @error('dapay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">OT Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="otpay">
            @error('otpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">EPF</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="epf">
            @error('epf') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="esi">
            @error('esi') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Uniform Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="uniformdeduction">
            @error('uniformdeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Advance</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="advance">
            @error('advance') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Others</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="others">
            @error('others') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Gross Salary</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="gross_salary">
            @error('gross_salary') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Total Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totaldeduction">
            @error('totaldeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Net Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="net_pay">
            @error('net_pay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Update</button>
        </div>
      </div>
    </form>
  </div>
</div>



{{-- Modal Delete --}}

<div wire:ignore.self class="modal fade " id="deletePayslipModal" tabindex="-1" aria-labelledby="deletePayslipModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <form wire:submit.prevent="removePayslip">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="deletePayslipModalLabel"> <strong>Delete Enrty</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
          </div>
          <div class="modal-body px-4">
  
            <input wire:model.lazy="psId" type="hidden" name=""  id="">
    
            Do you want to delete this Entry ...?
  
          </div>
          <div class="modal-footer">
          <button type="submit" class="btn btn-danger px-4 py-1">Delete</button>
          </div>
      </div>
      </form>
  </div>
</div>


<!-- Branch -->

<div wire:ignore.self class="modal fade" id="branchmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPayslipModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-xl">

    <form wire:submit.prevent="addPaySlip">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPayslipModalLabel"> <strong>Add Payslip</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pay Slip For</label><br>

              <select name="" id="" class="form-select"  wire:change="slipforchange()" wire:model.lazy="slipfor">
                <option value="" selected disabled>--Select--</option>
                <option value="scrt">Security</option>
                <option value="spvr">Operation Team</option>
              </select>
              {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="empid"> --}}
              @error('slipfor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
       <!--      <div  class="col-md-4">
                <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Name</label><br>
                {{-- <input type="text" class="form-control" id="Image" wire:model.lazy="name"> --}}
                
                <select  name="" id="" class="form-select"  wire:change="empchange" wire:model.lazy.lazy="name">
                  <option value="" selected disabled>--Select--</option>
                  @if(!empty($empdtls))
                    
                    @foreach($empdtls as $dtls)
                      <option value="{{$dtls->emp_id}}">{{$dtls->name}}({{$dtls->mobile}})</option>
                    @endforeach
                  @endif
                </select>

                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div> -->
               <div class="col-md-4">
            <label for="name" class="fw-normal bg-primary px-4 py-1 text-white rounded">Name *</label><br>
            <div class="input-group" wire:click.prevent='customer_dropdown1'   wire:keydown.shift='customer_dropdown1'>
                <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='name'>
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Securities.."  wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select</th>
                        </thead>
                       
                       @if(count($empdtls)>0)
                       @foreach($empdtls as $key => $value)

                   
                    <tr  tabindex="{{$key}}" wire:keydown.enter="{{$value->name}}" wire:click.prevent="customer_selected1('{{$value->name}}', '{{$value->id}}')" class="cursor-hand table-select" ><td>{{$value->name}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            
        </div>
            <div class="col-md-4">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Month & Year</label><br>
              <input type="month" class="form-control" id="Image" wire:model.lazy="monthandyear">
              @error('monthandyear') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Designation</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="designation" readonly>
            @error('designation') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">UAN</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="uan">
            @error('uan') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="esino">
            @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bank" readonly>
            @error('bank') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank A/C No</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankaccno" readonly>
            @error('bankaccno') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank IFSC Code</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="bankifsccode" readonly>
            @error('bankifsccode') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Name</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="clientname">
            @error('clientname') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
			<div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Location</label><br>
            <input type="text" class="form-control" id="Image" wire:model.lazy="clientloc">
            @error('clientloc') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">No. of Duties</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="noofduties">
            @error('noofduties') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Over Time (OT)</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="overtime">
            @error('overtime') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Total Working Days</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totalworkingdays">
            @error('totalworkingdays') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Basic Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="basicpay">
            @error('basicpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">DA</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="dapay">
            @error('dapay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">OT Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="otpay">
            @error('otpay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">EPF</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="epf">
            @error('epf') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">ESI</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="esi">
            @error('esi') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Uniform Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="uniformdeduction">
            @error('uniformdeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Advance</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="advance">
            @error('advance') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Others</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="others">
            @error('others') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Gross Salary</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="gross_salary">
            @error('gross_salary') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Total Deduction</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="totaldeduction">
            @error('totaldeduction') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4">
            <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Net Pay</label><br>
            <input type="number" class="form-control" id="Image" wire:model.lazy="net_pay">
            @error('net_pay') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- end Branch  -->


<script>
  $(document).ready(function(){

    var inputs = document.getElementsByTagName('input');

    inputs.autocomplete = "off";

  });
</script>
