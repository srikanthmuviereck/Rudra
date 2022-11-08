
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="viewFTModal" tabindex="-1" aria-labelledby="viewFTModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">

    {{-- <form wire:submit.prevent=""> --}}
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewFTModalLabel"> <strong>View Tracking Details</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

          {{-- <input wire:model.lazy="trackid" type="hidden" name=""  id=""> --}}

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Check Uniform</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="check_uniform">
                    @error('check_uniform') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Meet Client Update</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="meet_client_update">
                    @error('meet_client_update') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Invoice Status</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="invoice_status">
                    @error('invoice_status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Night Check Update</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="night_check_update">
                    @error('night_check_update') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            
                <div class="col-md-4">
                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded"> Current Strength Details</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="current_strength_details">
                    @error('current_strength_details') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded"> Post Vacancy</label><br>
                    <input readonly type="text" class="form-control" id="Image" wire:model="post_vacancy">
                    @error('post_vacancy') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

          <div class="row g-3 mt-2">
              <div class="col-md-4">
                  <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Client Feedback</label><br>
                  <input readonly type="text" class="form-control" id="Image" wire:model="client_feedback">
                  @error('client_feedback') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              <div class="col-md-4">
                  <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Day Visit Update</label><br>
                  <input readonly type="text" class="form-control" id="Image" wire:model="day_visit_update">
                  @error('day_visit_update') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
          
            <div class="col-md-4">
                <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Guards Training</label><br>
                <input readonly type="text" class="form-control" id="Image" wire:model="guards_training">
                @error('guards_training') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

          </div>
			
			<div class="row g-3 mt-2">
            <div class="col-md-6">

              <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Remarks</label><br>
              <textarea readonly type="text" class="form-control" id="Image" wire:model="notes"></textarea>

            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Guards Images</label><br>
                {{-- <input readonly type="text" class="form-control" id="Image" wire:model="guards_images">
                @error('guards_images') <span class="text-danger">{{ $message }}</span> @enderror --}}

                @if($guards_images)
                    <div class="row">
                      @foreach($guards_images as $key => $val)

                        
                          <div class="col-md-2">
                              <img src="{{ asset('storage/'.$val) }}" width="100" class="m-2">
                              <a class="btn btn-sm btn-success rounded-circle text-sm" type="button" href="{{ asset('storage/'.$val) }}" target="_blank"><i class="fa fa-eye"></i></a>
                          </div>
                        
                      @endforeach
                    </div>
				
				@else
                    <span class="text-danger text-bold">No Images</span>
                  @endif
            </div>
        </div>
            
        </div>

        </div>
        {{-- <div class="modal-footer">
          <button type="submit" class="btn btn-primary px-4"><i class="fa fa-plus me-1" aria-hidden="true"></i> Update</button>
        </div> --}}
      </div>
    {{-- </form> --}}
  </div>



{{-- Modal Delete --}}


<div wire:ignore.self class="modal fade" id="deleteFTModal" tabindex="-1" aria-labelledby="deleteFTModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <form wire:submit.prevent="removeTrackDtls">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteFTModalLabel"> <strong>Delete Tracking Details</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body">

          <input wire:model="trackid" type="hidden" name=""  id="">

          Do You Want to Delete this Entry...?
            
        </div>

        
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger px-4"> Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>   