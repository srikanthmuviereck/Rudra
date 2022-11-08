<!-- Button trigger modal -->

<style>
  .select2-selection__choice__remove{
    background-color: transparent !important;
    border: none !important;
  }
  .select2-search__field{
    display: none !important;
  }
  .select2_design{
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 0 5px;
  }
  ul {
  list-style-type: none; 
  padding: 0px;
  margin: 0px;
 
}
.style_mul{
  border: 1px solid;
    padding: 5px 5px;
     overflow: scroll;
     width: 100%;
     height: 110px;
}
</style>

<!-- Modal -->

<div wire:ignore.self class="modal fade" id="addSupervisorModal" data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addSupervisorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSupervisorModalLabel">Add Team</h5>
          <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        
        <div class="modal-body">
          <form>
  
          <div class="row g-3">
          
          <div class="col-md-6">
              <label for="name" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Name</label><br>
              <input type="text" class="form-control" id="name" wire:model.lazy="name">
              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
            <label for="email" class="fw-normal bg-primary px-4 py-1 text-white rounded">Email ID</label><br>
            <input type="text" class="form-control" id="email" wire:model.lazy="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
      </div>
      <br>
      <div class="row g-3">
          

        <div class="col-md-6">
            <label for="mobile" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Mobile</label><br>
            <input type="text" class="form-control" id="mobile" wire:model.lazy="mobile">
            @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
          <div class="col-md-6">
            <label for="password" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Password</label><br>
            <input type="text" class="form-control" id="password" wire:model.lazy="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
          
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="gender" class="fw-normal bg-primary px-4 py-1 text-white rounded">Gender</label><br>
              <!-- <input type="text" class="form-control" id="gender" wire:model.lazy="gender"> -->
              <input type="radio" name="gender" value="male"  wire:model.lazy="gender"> Male
              <input type="radio" name="gender" value="female"  wire:model.lazy="gender"> Female

              <br>  
              @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="area" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Area</label><br>
              <input type="text" class="form-control" id="area" wire:model.lazy="area">
              @error('area') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="city" class="fw-normal bg-primary px-4 py-1 text-white rounded">City</label><br>
              <input type="text" class="form-control" id="city" wire:model.lazy="city">
              @error('city') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="state" class="fw-normal  bg-primary px-4 py-1 text-white rounded">State</label><br>
              <input type="text" class="form-control" id="state" wire:model.lazy="state">
              @error('state') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="address" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Address</label><br>
              <input type="text" class="form-control" id="address" wire:model.lazy="address">
              @error('address') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="pin" class="fw-normal  bg-primary px-4 py-1 text-white rounded">PinCode</label><br>
              <input type="number" class="form-control" id="pin" wire:model.lazy="pin">
              @error('pin') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="status" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Status</label><br>
              <!-- <input type="text" class="form-control" id="status" wire:model.lazy="status"> -->
              <input type="radio" name="status" value="active"  wire:model.lazy="status"> Active
              <input type="radio" name="status" value="inactive"  wire:model.lazy="status"> Inactive

              <br>
              @error('status') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

         <!--    <div wire:ignore class="col-md-6" style="overflow:hidden;">
              <label for="building" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Client Place </label><br>
              <select  name="building" id="building" class="select" wire:model.lazy="building" multiple data-live-search="true" title="Select Building..." data-selected-text-format="count" data-size="5" data-actions-box="true" data-container="body" data-width="75%">
                  {{--<option value="" selected >Select Building </option>--}}
                  @foreach($client as $clnts)
                      <option value="{{ $clnts->building_id }}" >{{ $clnts->b_name }}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}}</option>
                  @endforeach()
              </select>
              @error('building') <span class="text-danger">{{ $message }}</span> @enderror
          </div> -->

          <div class="col-md-6">
            <label for="building_id" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Place *</label><br>

<div class="style_mul"  wire:click.prevent='customer_dropdown1' wire:keydown.shift='customer_dropdown1'>
  
  <ul class="">
    @if(count($value_arr)>0)
    @foreach($value_arr as $key=>$value)
    <li class="select2_design"><span wire:click="removerow('{{$key}}')" class="me-2">×</span>{{$value}}</li>
    @endforeach
    @endif
   
   
   
</ul>

</div>



            <div>
              <!--   <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='building_id'> -->
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Client Place.." wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select Building</th>
                        </thead>
                      
                       @if(count($h)>0)
                     @foreach($h as $clnts)
                   
                    <tr tabindex="{{ $clnts->building_id }}" wire:keydown.enter="{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}}" wire:click.prevent="customer_selected1('{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}},/{{ $clnts->building_id}}')" class="cursor-hand table-select" ><td>{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
            @error('multiselect') <span class="text-danger">This Field is Mandatory</span> @enderror
            
        </div>
        
          
      </div>

   
      <br>
        
  <div class="row g-3">
        <div class="col-md-6">
            <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">Location </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="location">
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client ID </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="clnt_id">
            @error('clnt_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="ifsccode" class="fw-normal bg-primary px-4 py-1 text-white rounded">PAN No </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="panno">
            @error('ifsccode') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="esino" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Adhaar No </label><br>
            <input type="text" class="form-control" id="pin" wire:model.lazy="adhaarno">
            @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="bankname" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank Name </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="bankname">
            @error('bankname') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="bankacno" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank A/C No </label><br>
            <input type="text" class="form-control" id="pin" wire:model.lazy="bankacno">
            @error('bankacno') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>
    
    <div class="row g-3">
        <div class="col-md-6">
            <label for="ifsccode" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank IFSC Code </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="ifsccode">
            @error('ifsccode') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
          <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">UAN </label><br>
          <input type="text" name="" id="" class="form-control" wire:model.lazy="uan">
          @error('uan') <span class="text-danger">{{ $message }}</span> @enderror
      </div>
    </div>
    <br>

    <div class="row g-3">
      <div class="col-md-6">
        <label for="esino" class="fw-normal bg-primary px-4 py-1 text-white rounded">ESI No </label><br>
        <input type="text" name="" id="" class="form-control" wire:model.lazy="esino">
        @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  </div>
  <br>
      
          </form>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-primary px-4" wire:click.prevent="store()">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="securitymodal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deletecustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <form wire:submit.prevent="removeSupervisor">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Security List</h5>
          <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <div class="table-responsive">
            <table class= "table table-striped">
                    <thead>
                    <tr>
                        <th>Security Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Building</th>
                      
                    </tr>
                    </thead> 
                <tbody>

                  @if(!empty($secData))
                    @foreach($secData as $sData)
                        <tr>
                            <td>{{!empty($sData->name)?$sData->name:''}}</td>
                            <td>{{!empty($sData->email)?$sData->email:''}}</td>
                            <td>{{!empty($sData->mobile)?$sData->mobile:''}}</td>
                            <td>{{!empty($sData->address)?$sData->address:''}}</td>
                            <td>{{!empty($sData->b_name)?$sData->b_name:''}}, {{!empty($sData->area)?$sData->area:''}},{{!empty($sData->city)?$sData->city:''}} , {{!empty($sData->pin)?$sData->pin:''}}
                            </td>
        
                            </td>
                        </tr>
                    @endforeach
                  @else
                    <p class="text-danger text-center fw-bold">No Securities Found</p>
                  @endif
                </tbody>   
            </table>
          </div>
          </div>
          {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">Close</button>
          </div> --}}
        </div>
      </form>
  
    </div>
  </div>
  


  <div wire:ignore.self class="modal fade" id="editframesModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="editframesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editframesModalLabel">Update Team</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        
        <div class="modal-body">
          <form>
  
          <div class="row g-3">
          
          <div class="col-md-6">
              <label for="name" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Name *</label><br>
              <input type="text" class="form-control" id="name" wire:model.lazy="name">
              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
            <label for="email" class="fw-normal bg-primary px-4 py-1 text-white rounded">Email ID </label><br>
            <input type="text" class="form-control" id="email" wire:model.lazy="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
      </div>
      <br>
      <div class="row g-3">
          

        <div class="col-md-6">
            <label for="mobile" class="fw-normal  bg-primary px-4 py-1 text-white rounded">mobile *</label><br>
            <input type="text" class="form-control" id="mobile" wire:model.lazy="mobile">
            @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
          <div class="col-md-6">
            <label for="password" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Password </label><br>
            <input type="text" class="form-control" id="password" wire:model.lazy="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
          
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="gender" class="fw-normal bg-primary px-4 py-1 text-white rounded">Gender </label><br>
              <!-- <input type="text" class="form-control" id="gender" wire:model.lazy="gender"> -->
              <input type="radio" name="gender" value="male"  wire:model.lazy="gender"> Male
              <input type="radio" name="gender" value="female"  wire:model.lazy="gender"> Female
  
              @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="area" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Area </label><br>
              <input type="text" class="form-control" id="area" wire:model.lazy="area">
              @error('area') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="city" class="fw-normal bg-primary px-4 py-1 text-white rounded">City </label><br>
              <input type="text" class="form-control" id="city" wire:model.lazy="city">
              @error('city') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="state" class="fw-normal  bg-primary px-4 py-1 text-white rounded">State </label><br>
              <input type="text" class="form-control" id="state" wire:model.lazy="state">
              @error('state') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="address" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Address </label><br>
              <input type="text" class="form-control" id="address" wire:model.lazy="address">
              @error('address') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-6">
              <label for="pin" class="fw-normal  bg-primary px-4 py-1 text-white rounded">PinCode</label><br>
              <input type="number" class="form-control" id="pin" wire:model.lazy="pin">
              @error('pin') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
      </div>
      <br>
      <div class="row g-3">
          <div class="col-md-6">
              <label for="status" class="fw-normal bg-primary px-4 py-1 text-white text-sm rounded">Status </label><br>
              <!-- <input type="text" class="form-control" id="status" wire:model.lazy="status"> -->
              <input type="radio" name="status" value="active"  wire:model.lazy="status"> Active
              <input type="radio" name="status" value="inactive"  wire:model.lazy="status"> Inactive
  
              @error('status') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
          <div class="col-md-6">
            <label for="building_id" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Place *</label><br>

<div class="style_mul" wire:click.prevent='customer_dropdown1' wire:keydown.shift='customer_dropdown1'>
  
  <ul class="">
    @if(count($value_arr)>0)
    @foreach($value_arr as $key=>$value)
    <li class="select2_design"><span wire:click="removerow('{{$key}}')" class="me-2">×</span>{{$value}}</li>
    @endforeach
    @endif
   
   
   
</ul>

</div>



            <div>
              <!--   <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='building_id'> -->
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Client Place.." wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select Building</th>
                        </thead>
                      
                       @if(count($h)>0)
                     @foreach($h as $clnts)
                   
                    <tr tabindex="{{ $clnts->building_id }}" wire:keydown.enter="{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}}" wire:click.prevent="customer_selected1('{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}},/{{ $clnts->building_id}}')" class="cursor-hand table-select" ><td>{{ $clnts->b_name}}, {{$clnts->area}}, {{$clnts->city}}, {{$clnts->pin}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
           @error('multiselect') <span class="text-danger">This Field is Mandatory</span> @enderror
            
        </div>
          
      </div>
      <br>
        
    <div class="row g-3">
        <div class="col-md-6">
            <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">Location </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="location">
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client ID </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="clnt_id">
            @error('clnt_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="ifsccode" class="fw-normal bg-primary px-4 py-1 text-white rounded">PAN No </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="panno">
            @error('ifsccode') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="esino" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Adhaar No </label><br>
            <input type="text" class="form-control" id="pin" wire:model.lazy="adhaarno">
            @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="bankname" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank Name </label><br>
            <input type="text" name="" id="" class="form-control" wire:model.lazy="bankname">
            @error('bankname') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="bankacno" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Bank A/C No </label><br>
            <input type="text" class="form-control" id="pin" wire:model.lazy="bankacno">
            @error('bankacno') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <br>
    
    <div class="row g-3">
      <div class="col-md-6">
          <label for="ifsccode" class="fw-normal bg-primary px-4 py-1 text-white rounded">Bank IFSC Code </label><br>
          <input type="text" name="" id="" class="form-control" wire:model.lazy="ifsccode">
          @error('ifsccode') <span class="text-danger">{{ $message }}</span> @enderror
      </div>
      <div class="col-md-6">
        <label for="uan" class="fw-normal bg-primary px-4 py-1 text-white rounded">UAN </label><br>
        <input type="text" name="" id="" class="form-control" wire:model.lazy="uan">
        @error('uan') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  </div>
  <br>

  <div class="row g-3">
    <div class="col-md-6">
      <label for="esino" class="fw-normal bg-primary px-4 py-1 text-white rounded">ESI No </label><br>
      <input type="text" name="" id="" class="form-control" wire:model.lazy="esino">
      @error('esino') <span class="text-danger">{{ $message }}</span> @enderror
  </div>
</div>
<br>
      
          </form>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-primary px-4" wire:click.prevent="update()">Update</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Button trigger modal -->


  <!-- Edit Customer Modal -->
  <div wire:ignore.self class="modal fade" id="deletecustomerModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deletecustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
  
      <form wire:submit.prevent="removeSupervisor">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
          <div class="modal-body">
            <input type="hidden" wire:model.lazy="s_id">
            Do you want delete this Team...?
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-danger px-4">Delete</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  
  

  <!-- Security Tracking Map Modal --> 
  <div wire:ignore.self class="modal fade" id="supervisorTrack" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="supervisorTrackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
  
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="supervisorTrackLabel">Operation Team Location Tracker</h5>
        <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">

          <div class="row">
              <div class="col-md-12">
                  <label for="password" class="fw-normal bg-primary px-4 py-1 text-white rounded">Select Date</label><br>
              </div>
          </div>

          <div class="row">

              <div class="col-md-6 p-2">
                  
                  <input type="date" name="" id="" class="form-control" wire:model.lazy="secdate">
                  @error('secdate') <span class="text-danger">{{$message}}</span> @enderror
              </div>
  
              <div class="col-md-6 p-2">
                  <button type="button" class="btn btn-primary px-3" wire:click="supervisorTracker" id="" >Submit</button>
              </div>

          </div>

          <div class="row mt-3">
              <div class="col-md-12">

                  <div class="">
                      <div wire:ignore id="map" style="height:400px"></div>
                    </div>

              </div>
          </div>
          
        </div>
        {{-- <div class="modal-footer">
          <button type="submit" class="btn btn-danger px-4">Delete</button>
        </div> --}}
      </div>
  </div>
</div>



  
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvRTpxDkGBIPFAAo2ww33zCcZYoLLXo9k&callback=initAutocomplete&libraries=places&v=weekly&channel=2"  async></script>


<!--- Add Map Script Start---->

<script id="editScriptMap" type="text/javascript">

    var map, infoWindow, marker1;
    
    function initMap() {
        
        var lat = 10.003500;//13.06458590664855;
        var long = 77.476461;//80.23260826830573;
        const defaults = { lat: lat, lng: long };
        map = new google.maps.Map(document.querySelector("#map"), {
            center: { lat: lat, lng: long },
            zoom: 5,
            streetViewControl: false,
        });
        
        infoWindow = new google.maps.InfoWindow();

        window.addEventListener('supervisorTrackDetails', event => {
      
      document.querySelector("#map").innerHtml = "";
      
      map = new google.maps.Map(document.querySelector("#map"), {
        center: { lat: lat, lng: long },
        zoom: 5,
        streetViewControl: false,
      });
      
            var trackdtl = event.detail.dtl;
      
            trackdtl.forEach((element) => {

                // console.log(element['id']+' - '+element['name']);
                
                //console.log(dpos);

                marker1 = new google.maps.Marker({
                    position: {
                        lat:Number(element['latitude']),
                        lng:Number(element['longitude']),
                    },
          animation: google.maps.Animation.DROP,
                    map,
                });
        
        var contentString = '<div><span class="'+"label-title"+'"> Operation Team : </span> '+element['name']+'('+element['mobile']+')</p> </div>';
        
        //<br /> <span class="'+"label-title"+'"> Client Place : </span> '+element['b_name']+
        
        //console.log(contentString);
        
        var iw1 = new google.maps.InfoWindow({
           content:contentString
        });
        
        google.maps.event.addListener(marker1, "click", function (e) { iw1.open(map, this); });

            });
        });
    
    
    }
    
    function initAutocomplete() {
        initMap();
    
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>


<script>
    //$('select').select2();
  
</script>

<script>
  
$('.select').select2();
  
  $('.select').on('change', function (e) {
      var data = $('.select').val();
      // alert(data);
      @this.set('building', data);
  });
      
  
  window.livewire.on('openSelect2', () => {
    $('.select1').select2();
    $('.select1').on('change', function (e) {
      var data = $('.select1').val();
      @this.set('building', data);
    });
  });
  //$('select').selectpicker();
  //$('#buildings').selectpicker();
  
  $(document).on("keydown", "form", function(event) { 
      return event.key != "Enter";
  });
  
  </script>

<!--- Add Map Script End---->

  