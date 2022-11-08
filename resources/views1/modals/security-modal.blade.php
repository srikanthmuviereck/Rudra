

{{-- Create Security --}}

<style>
    .maplabelcustom{
        background-color:white !important;
        /*padding:20px 30px !important;*/
    }
	.label-title{
		font-weight:bold;
	}
</style>

<div wire:ignore.self class="modal fade" id="addSecurityModal" tabindex="-1" aria-labelledby="addSecurityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- wire:click.prevent="store()" --}}

            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSecurityModalLabel">Add Security</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"  wire:click="closeModal"></button>
                </div>

                <div class="modal-body">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Name</label><br>
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
                            <label for="mobile" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Mobile </label><br>
                            <input type="text" class="form-control" id="mobile" wire:model.lazy="mobile">
                            @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Password</label><br>
                            <input type="text" class="form-control" id="password" wire:model.lazy="password" required>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="gender" class="fw-normal bg-primary px-4 py-1 text-white rounded">Gender </label><br>
                            <!-- <input type="text" class="form-control" id="gender" wire:model.lazy="gender"> -->
                            <input type="radio" name="gender" value="male" class="mx-1" wire:model.lazy="gender"> Male
                            <input type="radio" name="gender" value="female" class="mx-1" wire:model.lazy="gender"> Female

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
                            <textarea name="" id="" class="form-control" wire:model.lazy="address"></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pin" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pin </label><br>
                            <input type="number" class="form-control" id="pin" wire:model.lazy="pin">
                            @error('pin') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Status </label>
                            <br>
                            <!-- <input type="text" class="form-control" id="status" wire:model.lazy="status"> -->
                            <input type="radio" name="status" value="active" class="mx-1" wire:model.lazy="status"> Active
                            <input type="radio" name="status" value="inactive" class="mx-1" wire:model.lazy="status"> Inactive
                            <br>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
<!-- 
                        <div class="col-md-6">
                            <label for="supervised_by" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Operation Team </label><br>
                            <select  name="supervised_by" id="supervised_by" class="form-select" wire:model.lazy="supervised_by">
                                <option value="" >Select </option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->spvr_id }}" >{{ $supervisor->name }}</option>
                                @endforeach()
                            </select>
                            @error('supervised_by') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> -->
        <div class="col-md-6">
            <label for="name" class="fw-normal bg-primary px-4 py-1 text-white rounded">Operation Team *</label><br>
            <div class="input-group" wire:click.prevent='customer_dropdown1' wire:keydown.shift='customer_dropdown1'>
                <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='supervised_by'>
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Operation Team.." wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select</th>
                        </thead>
                      
                       @if(count($h)>0)
                       @foreach($h as $key => $value)
                   
                    <tr tabindex="{{$key}}" wire:keydown.enter="{{$value->name}}" wire:click.prevent="customer_selected1('{{$value->name}}','{{$value->spvr_id}}')" class="cursor-hand table-select" ><td>{{$value->name}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
            @error('supervised_by') <span class="text-danger">{{ $message }}</span> @enderror
            
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
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary px-3" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Security --}}

<div wire:ignore.self class="modal fade" id="editSecurityModal" tabindex="-1" aria-labelledby="editSecurityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- wire:click.prevent="store()" --}}

            <form wire:submit.prevent="update">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSecurityModalLabel">Edit Security</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  wire:click="closeModal"></button>
                </div>

                <input type="hidden" name="" id="" wire:model.lazy="sec_id">

                <div class="modal-body">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Name</label><br>
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
                            <label for="mobile" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Mobile </label><br>
                            <input type="text" class="form-control" id="mobile" wire:model.lazy="mobile">
                            @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Password</label><br>
                            <input type="text" class="form-control" id="password" wire:model.lazy="password">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="gender" class="fw-normal bg-primary px-4 py-1 text-white rounded">Gender </label><br>
                            <!-- <input type="text" class="form-control" id="gender" wire:model.lazy="gender"> -->
                            <input type="radio" name="gender" value="male" class="mx-1" wire:model.lazy="gender"> Male
                            <input type="radio" name="gender" value="female" class="mx-1" wire:model.lazy="gender"> Female

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
                            <textarea name="" id="" class="form-control" wire:model.lazy="address"></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pin" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pin </label><br>
                            <input type="number" class="form-control" id="pin" wire:model.lazy="pin">
                            @error('pin') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Status </label>
                            <br>
                            <!-- <input type="text" class="form-control" id="status" wire:model.lazy="status"> -->
                            <input type="radio" name="status" value="active" class="mx-1" wire:model.lazy="status"> Active
                            <input type="radio" name="status" value="inactive" class="mx-1" wire:model.lazy="status"> Inactive
                            <br>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                 <!--        <div class="col-md-6">
                            <label for="supervised_by" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Operation Team </label><br>
                            <select  name="supervised_by" id="supervised_by" class="form-select" wire:model.lazy="supervised_by">
                                <option value="" >Select </option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->spvr_id }}" >{{ $supervisor->name }}</option>
                                @endforeach()
                            </select>
                            @error('supervised_by') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> -->


   <div class="col-md-6">
            <label for="name" class="fw-normal bg-primary px-4 py-1 text-white rounded">Operation Team *</label><br>
            <div class="input-group" wire:click.prevent='customer_dropdown1' wire:keydown.shift='customer_dropdown1'>
                <input type="text" class="form-control cursor-hand" readonly="" value=""  wire:model.lazy='supervised_by'>
               
                <span class="input-icon cursor-hand"><i
                    class="fa fa-angle-down"></i></span>
                </div>  
          
          @if($dropdown)
          
           <div class="searchable-dropdown" >
                    <div class="sticky bg-white input-group pd-10 col-md-10">
                        <span class="input-icon cursor-hand"><i class="fa fa-search-plus"></i></span>
                        <input type="search" class="form-control" placeholder="Search Operation Team.." wire:model.lazy='search_customer1'>
                </div>
                <div class="table">
                  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Select</th>
                        </thead>
                      
                       @if(count($h)>0)
                       @foreach($h as $key => $value)
                       
                   
                    <tr tabindex="{{$key}}" wire:keydown.enter="{{$value->name}}" wire:click.prevent="customer_selected1('{{$value->name}}','{{$value->spvr_id}}')" class="cursor-hand table-select" ><td>{{$value->name}}</td></tr>
                    @endforeach
                      @endif
                </table>
                </div>
                    <div class="footer-fixed">
                        <button type="button" class="btn btn-sm btn-danger btn-round close mx-auto text-center d-block" wire:click.lazy='customer_dropdown1'><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
          
          @endif
            
            
            @error('supervised_by') <span class="text-danger">{{ $message }}</span> @enderror
            
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
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary px-3" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

  
  
  <!-- Delete Modal -->
  <div wire:ignore.self class="modal fade" id="deleteSecurityModal" tabindex="-1" aria-labelledby="deleteSecurityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
  
      <form wire:submit.prevent="removeSecurity">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteSecurityModalLabel">Delete Security</h5>
          <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
          <div class="modal-body">
            <input type="hidden" wire:model.lazy="sec_id">
            Do you want delete this Security...?
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger px-4">Delete</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <!-- Security Tracking Map Modal -->
  <div wire:ignore.self class="modal fade" id="securityTrack" tabindex="-1" aria-labelledby="securityTrackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
  
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="securityTrackLabel">Security Location Tracker</h5>
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
                </div>
    
                <div class="col-md-6 p-2">
                    <button type="button" class="btn btn-primary px-3" wire:click="securityTracker" id="" >Submit</button>
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

        window.addEventListener('securityTrackDetails', event => {
			
			document.querySelector("#map").innerHtml = "";
			
			map = new google.maps.Map(document.querySelector("#map"), {
				center: { lat: lat, lng: long },
				zoom: 5,
				streetViewControl: false,
			});
			
            trackdtl = event.detail.dtl;
			
            // console.log(trackdtl.length);
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
					//label: element['name'],
                });
				
				var contentString = '<div><span class="'+"label-title"+'"> Security Name : </span> '+element['name']+'('+element['mobile']+') <br /> <span class="'+"label-title"+'"> Building Name : </span> '+element['b_name']+' </p> </div>';
				
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

<script>
  $(document).on("keydown", "form", function(event) { 
      return event.key != "Enter";
  });
  
  </script>

<!--- Add Map Script End---->

  
  
  
