
<!-- Modal -->
<div wire:ignore.self class="modal fade " id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">

    <form wire:submit.prevent="addnewNotification">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel"> <strong>Send Notification</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body p-3">

            <div class="row g-3">
                <div class="col-md-12">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Send To</label>
                    <select class="form-select" wire:model.lazy="not_type">
                        <option selected>Select Type</option>
                        <option value="security"><?=ucfirst('security')?></option>
                        <option value="Operation Team"><?=ucfirst('Operation Team')?></option>
                        <option value="client"><?=ucfirst('client')?></option>
                    </select>

                    @error('not_type') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-12">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Title</label><br>
                    <input type="text" class="form-control" id="Image" wire:model.lazy="not_title">
                    @error('not_title') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="col-md-12">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded required">Message</label><br>
                    <textarea type="text" class="form-control" id="Image" wire:model.lazy="not_msg"></textarea>
                    @error('not_msg') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                
                {{-- <div class="col-md-12">
                    <label for="Image" class="fw-normal  bg-primary px-4 py-1 text-white rounded">Image</label><br>
                    <input type="file" class="form-control-file" id="Image" wire:model.lazy="not_img">

                    <br>
                  

                    <br>
                </div> --}}
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary px-4">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Delete Notify Modal -->
<div wire:ignore.self class="modal fade " id="deletenotify" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deletenotifyLabel" aria-hidden="true">
  <div class="modal-dialog">

    <form wire:submit.prevent="removeNot">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deletenotifyLabel"> <strong>Delete Gym</strong> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
        </div>
        <div class="modal-body p-3">

          <input type="hidden" name="" id="" wire:model.lazy="not_id">

          Do You Want Delete this Notification...?

        </div>
                    
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger px-4">Delete</button>
        </div>
      </div>

    </form>
  </div>
</div>


