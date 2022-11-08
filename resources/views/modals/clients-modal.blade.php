<!-- Modal -->
<div wire:ignore.self class="modal fade" id="clientModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <form wire:submit.prevent="addnewClient">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clientModalLabel"> <strong>Add Client</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Client Name</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_name">
                    @error('c_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Email</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_email">
                    @error('c_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Mobile</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_mobile">
                    @error('c_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Password</label><br>
                  <input type="text" class="form-control" id="Image" wire:model.lazy="c_pass">
                  @error('c_pass') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="row g-3 mt-2">
              
              <div class="col-md-6">
                <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Gender</label><br>
                <div class="mt-2">

                  <input class="form-check-input" type="radio" wire:model.lazy="c_gen" name="genderRadio1" id="genderRadio1" value="1">
                  <label class="fw-normal" for="genderRadio1">Male</label>

                  <input class="form-check-input ms-3" type="radio" wire:model.lazy="c_gen" name="genderRadio2" id="genderRadio2" value="0">
                  <label class="fw-normal" for="genderRadio2">Female</label>

                </div>
                @error('c_gen') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Client Place</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_buildname">
                    @error('c_buildname') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Area</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_area">
                    @error('cb_area') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">City</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_city">
                    @error('cb_city') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">State</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_state">
                    @error('cb_state') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            
              <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pincode</label><br>
                  <input type="text" class="form-control" id="Image" wire:model.lazy="cb_pin">
                  @error('cb_pin') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

            </div>

            <div class="row g-3 mt-2">
              <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Address</label><br>
                  <textarea name="" id="" cols="30" rows="4" class="form-control" wire:model.lazy="cb_addr"></textarea>
                  @error('cb_addr') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
          
            <div class="col-md-6">
                <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Status</label><br>
                <div class="mt-2">

                  <input class="form-check-input" type="radio" wire:model.lazy="c_sts" name="clientStatus" id="clientStatus" value="active">
                  <label class="fw-normal" for="clientStatus">Active</label>

                  <input class="form-check-input ms-3" type="radio" wire:model.lazy="c_sts" name="clientInctiveStatus" id="clientInctiveStatus" value="inactive">
                  <label class="fw-normal" for="clientInctiveStatus">Inactive</label>

                </div>
                @error('c_sts') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-6">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Representative Name</label><br>
              <input type="text" name="" id="" class="form-control">
              @error('crep_name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
    </div>

        <div class="row">

          <div class="col-md-6">
              <input wire:model.lazy.lazy="latitude" class="form-control" placeholder="lat" name="latitude" id="lat"  type="hidden">
          </div>
          <div class="col-md-6">
              <input wire:model.lazy.lazy="longitude" class="form-control" placeholder="lng" name="longitude" id="lng"  type="hidden">
          </div>
      </div>

      <div class="row g-3 mt-2">
          <div class="col-md-6">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Choose Location</label>
          </div>
      </div>

<div class="">
  
  <div class="col-md-6">
  <input id="pac-input"  class="form-control mb-3" type="search"  placeholder="Search Location"/>
  </div>
  <div wire:ignore id="map" style="height:300px"></div>
</div>

      <br>
      @error('latitude') <span class="text-danger">{{$message}}</span> @enderror

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add</button>
        </div>
      </div>
    </form>
  </div>
</div>   



<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editClientModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <form wire:submit.prevent="updateClient">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editClientModalLabel"> <strong>Edit Client</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

          <input wire:model.lazy="clnt_id" type="hidden" name=""  id="">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded required">Client Name</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_name">
                    @error('c_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Email</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_email">
                    @error('c_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Mobile</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_mobile">
                    @error('c_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Password</label><br>
                  <input type="text" class="form-control" id="Image" wire:model.lazy="c_pass">
                  @error('c_pass') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="row g-3 mt-2">
              
              <div class="col-md-6">
                <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Gender</label><br>
                <div class="mt-2">

                  <input class="form-check-input" type="radio" wire:model.lazy="c_gen" name="genderRadio1" id="genderRadio1" value="male">
                  <label class="fw-normal" for="genderRadio1">Male</label>

                  <input class="form-check-input ms-3" type="radio" wire:model.lazy="c_gen" name="genderRadio2" id="genderRadio2" value="female">
                  <label class="fw-normal" for="genderRadio2">Female</label>

                </div>
                @error('c_gen') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Client Place</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="c_buildname">
                    @error('c_buildname') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Area</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_area">
                    @error('cb_area') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">City</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_city">
                    @error('cb_city') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">State</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="cb_state">
                    @error('cb_state') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            
              <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Pincode</label><br>
                  <input type="text" class="form-control" id="Image" wire:model.lazy="cb_pin">
                  @error('cb_pin') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

            </div>

            <div class="row g-3 mt-2">
              <div class="col-md-6">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Address</label><br>
                  <textarea name="" id="" cols="30" rows="4" class="form-control" wire:model.lazy="cb_addr"></textarea>
                  @error('cb_addr') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
          
            <div class="col-md-6">
                <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Status</label><br>
                <div class="mt-2">

                  <input class="form-check-input" type="radio" wire:model.lazy="c_sts" name="clientStatus" id="clientStatus" value="active">
                  <label class="fw-normal" for="clientStatus">Active</label>

                  <input class="form-check-input ms-3" type="radio" wire:model.lazy="c_sts" name="clientInctiveStatus" id="clientInctiveStatus" value="inactive">
                  <label class="fw-normal" for="clientInctiveStatus">Inactive</label>

                </div>
                @error('c_sts') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-6">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Representative Name</label><br>
              <input type="text" name="" id="" class="form-control">
              @error('crep_name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
    </div>

        <div class="row">

          <div class="col-md-6">
              <input wire:model.lazy.lazy="latitude" class="form-control" placeholder="lat" name="latitude" id="lat"  type="hidden">
          </div>
          <div class="col-md-6">
              <input wire:model.lazy.lazy="longitude" class="form-control" placeholder="lng" name="longitude" id="lng"  type="hidden">
          </div>
      </div>

        <div class="row g-3 mt-2">
          <div class="col-md-6">
              <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Choose Location</label>
          </div>
      </div>

        <div class="">
        
          <div class="col-md-6">
          <input id="edit-pac-input"  class="form-control mb-3" type="search"  placeholder="Search Location"/>
          </div>
          <div wire:ignore id="edit_map" style="height:300px"></div>
        </div>

        @error('latitude') <span class="text-danger">{{$message}}</span> @enderror

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Update</button>
        </div>
      </div>
    </form>
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
                      <th>S.No</th>
                      <th>Security Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Address</th>
                      <th>Operation Team</th>
                    
                  </tr>
                  </thead> 
              <tbody>

                @if(!empty($secData))

                  <?php $i = 1; ?>

                  @foreach($secData as $sData)
                      <tr>
                        <td>{{$i}}</td>
                     
                       
                            <td>{{!empty($sData->name)?$sData->name:''}}</td>
                            <td>{{!empty($sData->email)?$sData->email:''}}</td>
                            <td>{{!empty($sData->mobile)?$sData->mobile:''}}</td>
                            <td>{{!empty($sData->address)?$sData->address:''}}</td>
                            <td>{{!empty($sData->s_name)?$sData->s_name:''}}
                            </td>
      
                          </td>
                      </tr>

                      <?php $i++; ?>
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


{{-- Modal Delete --}}

<div wire:ignore.self class="modal fade " id="deleteClientModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <form wire:submit.prevent="removeClient">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="deleteClientModalLabel"> <strong>Delete Client</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
          </div>
          <div class="modal-body px-4">
  
          <input wire:model.lazy="clnt_id" type="hidden" name=""  id="">
  
          Do you want to delete this Client ...?
  
          </div>
          <div class="modal-footer">
          <button type="submit" class="btn btn-danger px-4 py-1">Delete</button>
          </div>
      </div>
      </form>
  </div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvRTpxDkGBIPFAAo2ww33zCcZYoLLXo9k&callback=initAutocomplete&libraries=places&v=weekly&channel=2"  async></script>


<!--- Add Map Script Start---->

<script id="editScriptMap" type="text/javascript">

let g_marker;let g_marker1;
let g_markers = [];

// ------------
var marker;var marker1;
let markers = [];
var map, infoWindow, g_map;

function initMap() {
var lat = 13.06458590664855;
var long = 80.23260826830573;
const defaults = { lat: lat, lng: long };
map = new google.maps.Map(document.querySelector("#map"), {
  center: { lat: lat, lng: long },
  zoom: 20,
  streetViewControl: false,
});

infoWindow = new google.maps.InfoWindow();


const locationButton = document.createElement("button");
locationButton.id = "location_button";
locationButton.type = "button";
locationButton.title = "Current Location";


//locationButton.textContent = "<i class='fa fa-map-marker'></i>";
locationButton.classList.add("custom-map-control-button");
map.controls[google.maps.ControlPosition.TOP_RIGHT].push(locationButton);
$(locationButton).html("<i class='fa fa-map-marker p-2 fs-5'></i>");
locationButton.addEventListener("click", () => {
 if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        let pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        // infoWindow.setPosition(pos);
        // infoWindow.setContent(marker);
        infoWindow.open(map);
        map.setCenter(pos);
        @this.latitude = position.coords.latitude;
        @this.longitude = position.coords.longitude;
        
      //   $('#lat').val(position.coords.latitude);
      //   $('#lng').val(position.coords.longitude);
        if (marker1 && marker1.setMap) {marker1.setMap(null);}
         marker1 = new google.maps.Marker({
            position: pos,
            map,
            title: "Your Location",
          });
            var geocoder = new google.maps.Geocoder();
             geocoder.geocode({'latLng': pos}, function(results, status) {
            if(status == google.maps.GeocoderStatus.OK) {
               
            }
        });

      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
  }
  // $('#location').trigger('change');        
});

 if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        let pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        // infoWindow.setPosition(pos);
        // infoWindow.setContent(marker);
        infoWindow.open(map);
        map.setCenter(pos);
      //   $('#lat').val(position.coords.latitude);
      //   $('#lng').val(position.coords.longitude);
        @this.latitude = position.coords.latitude;
        @this.longitude = position.coords.longitude;
        if (marker1 && marker1.setMap) {marker1.setMap(null);}        
         marker1 = new google.maps.Marker({
            position: pos,
            map,
            title: "Your Location",
          });
            var geocoder = new google.maps.Geocoder();
           

      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
       
  // $('#location').trigger('change');    

  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }

  // Create the search box and link it to the UI element.
const input = document.getElementById("pac-input");
const searchBox = new google.maps.places.SearchBox(input);
//map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// Bias the SearchBox results towards current map's viewport.
map.addListener("bounds_changed", () => {
  searchBox.setBounds(map.getBounds());
});




google.maps.event.addListener(map, 'click', function (e) {
  //$('#lat').val(e.latLng.lat());
  //$('#lng').val(e.latLng.lng());
  @this.latitude = e.latLng.lat();//position.coords.latitude;
  @this.longitude = e.latLng.lng();//position.coords.longitude;
  var geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
    var dpos = {
          lat: e.latLng.lat(),
          lng: e.latLng.lng(),
        };
        if (marker1 && marker1.setMap) {marker1.setMap(null);}
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  markers = [];
  marker1 = new google.maps.Marker({
            position: dpos,
            map,
            title: "Your Location",
          });  
  });


// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener("places_changed", () => {
  const places = searchBox.getPlaces();

  if (places.length == 0) {
    return;
  }
  // Clear out the old markers.
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  markers = [];
  // For each place, get the icon, name and location.
  const bounds = new google.maps.LatLngBounds();
  places.forEach((place) => {
    if (!place.geometry || !place.geometry.location) {
      console.log("Returned place contains no geometry");
      return;
    }
    const icon = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25),
    };
    // Create a marker for each place.
    markers.push(
      new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
      })
    );

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
  // alert(JSON.stringify(place));

  // alert(place.formatted_address);

  // alert(place.geometry.location.lat());
 
  // alert(place.geometry.location.lng());

  // $('#lat').val(place.geometry.location.lat());
  // $('#lng').val(place.geometry.location.lng());
  @this.latitude = place.geometry.location.lat();
  @this.longitude = place.geometry.location.lng();
  });
  map.fitBounds(bounds);
});

}

function initEditMap() {
var marker;var marker1;
let markers = [];
var map, infoWindow, g_map;
let lat = $('#lat').val();//13.06458590664855;
let long = $('#lng').val();//80.23260826830573;
const defaults = { lat: lat, lng: long };
map = new google.maps.Map(document.querySelector("#edit_map"), {
  center: { lat: lat, lng: long },
  zoom: 20,
  streetViewControl: false,
});
  
  

infoWindow = new google.maps.InfoWindow();
  
  


const locationButton = document.createElement("button");
locationButton.id = "location_button";
locationButton.type = "button";
locationButton.title = "Current Location";


//locationButton.textContent = "<i class='fa fa-map-marker'></i>";
locationButton.classList.add("custom-map-control-button");
map.controls[google.maps.ControlPosition.TOP_RIGHT].push(locationButton);
$(locationButton).html("<i class='fa fa-map-marker p-2 fs-5'></i>");
locationButton.addEventListener("click", () => {
 if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        let pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        // infoWindow.setPosition(pos);
        // infoWindow.setContent(marker);
        infoWindow.open(map);
        map.setCenter(pos);
        @this.latitude = position.coords.latitude;
        @this.longitude = position.coords.longitude;
        
      //   $('#lat').val(position.coords.latitude);
      //   $('#lng').val(position.coords.longitude);
        if (marker1 && marker1.setMap) {marker1.setMap(null);}
         marker1 = new google.maps.Marker({
            position: pos,
            map,
            title: "Your Location",
          });
            var geocoder = new google.maps.Geocoder();
             geocoder.geocode({'latLng': pos}, function(results, status) {
            if(status == google.maps.GeocoderStatus.OK) {
               
            }
        });

      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
  }
  // $('#location').trigger('change');        
});
  
  

 let pos = {};
  pos['lat'] = lat;
  pos['lng'] = long;
  
  //console.log(pos);
  
  
  
  
  // infoWindow.setPosition(pos);
  // infoWindow.setContent(marker);
  
  
  window.addEventListener('clientEdit', event => {

    lat = event.detail.latitude;
    long = event.detail.longitude;
    
    pos['lat'] = Number(lat);
  pos['lng'] = Number(long);
    
    //console.log(pos);
    
    infoWindow.open(map);
  map.setCenter(pos);

  if (marker1 && marker1.setMap) {marker1.setMap(null);}        
  marker1 = new google.maps.Marker({
    position: pos,
    map,
    title: "Your Location",
  });

  });

  // Create the search box and link it to the UI element.
const input = document.getElementById("edit-pac-input");
const searchBox = new google.maps.places.SearchBox(input);
//map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// Bias the SearchBox results towards current map's viewport.
map.addListener("bounds_changed", () => {
  searchBox.setBounds(map.getBounds());
});




google.maps.event.addListener(map, 'click', function (e) {
  //$('#lat').val(e.latLng.lat());
  //$('#lng').val(e.latLng.lng());
  @this.latitude = e.latLng.lat();//position.coords.latitude;
  @this.longitude = e.latLng.lng();//position.coords.longitude;
  var geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
    var dpos = {
          lat: e.latLng.lat(),
          lng: e.latLng.lng(),
        };
        if (marker1 && marker1.setMap) {marker1.setMap(null);}
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  markers = [];
  marker1 = new google.maps.Marker({
            position: dpos,
            map,
            title: "Your Location",
          });  
  });


// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener("places_changed", () => {
  const places = searchBox.getPlaces();

  if (places.length == 0) {
    return;
  }
  // Clear out the old markers.
  markers.forEach((marker) => {
    marker.setMap(null);
  });
  markers = [];
  // For each place, get the icon, name and location.
  const bounds = new google.maps.LatLngBounds();
  places.forEach((place) => {
    if (!place.geometry || !place.geometry.location) {
      console.log("Returned place contains no geometry");
      return;
    }
    const icon = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25),
    };
    // Create a marker for each place.
    markers.push(
      new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
      })
    );

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }
  // alert(JSON.stringify(place));

  // alert(place.formatted_address);

  // alert(place.geometry.location.lat());
 
  // alert(place.geometry.location.lng());

  // $('#lat').val(place.geometry.location.lat());
  // $('#lng').val(place.geometry.location.lng());
  @this.latitude = place.geometry.location.lat();
  @this.longitude = place.geometry.location.lng();
  });
  map.fitBounds(bounds);
});

}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
infoWindow.setPosition(pos);
infoWindow.setContent(
  browserHasGeolocation
    ? "Error: The Geolocation service failed."
    : "Error: Your browser doesn't support geolocation."
);
infoWindow.open(map);
}

function changeMarkerPosition(marker) {
  var latlng = new google.maps.LatLng(-24.397, 140.644);
  marker.setPosition(latlng);
}

function initAutocomplete() {
    
    initMap();   
    initEditMap(); 
    
    // alert(tmp);
}

$(function(){
// var keyStop = {
//   //8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
//   13: "input:text, input:password", // stop enter = submit

//   end: null
// };
// $(document).bind("keydown", function(event){
// var selector = keyStop[event.which];

// if(selector !== undefined && $(event.target).is(selector)) {
//     event.preventDefault(); //stop event
// }
// return true;
// });
});

</script>


<script>
  $(document).on("keydown", "form", function(event) { 
      return event.key != "Enter";
  });
  
  </script>