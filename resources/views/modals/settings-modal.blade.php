<!-- Modal -->
<div wire:ignore.self class="modal fade " id="editadminuser" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="editadminuserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">

    <form wire:submit.prevent="updateAdminUser">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editadminuserLabel"> <strong>Edit Admin User</strong> </h5>
        <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="" id="" wire:model="admin_id">

          <div class="row g-3">
              
              <div class="col-md-12">
                <label for="admin_mail" class="form-label bg-primary px-4 py-1 rounded fw-normal text-white">Email</label>
                <input type="text" name="" id="" class="form-control" id="admin_mail" wire:model="admin_mail">
                @error('admin_mail') <span class="text-danger fw-bold">{{ $message }}</span> @enderror

              </div>

              <div class="col-md-12">
                <label for="admin_pass" class="form-label bg-primary px-4 py-1 rounded fw-normal text-white">Password</label>
                <input type="text" name="" placeholder="You Can Change the password..." id="" class="form-control" id="admin_pass" wire:model="admin_pass">
                @error('admin_pass') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
              </div>

              <div class="col-md-12">
                <label for="admin_super" class="form-label bg-primary px-4 py-1 rounded fw-normal text-white">Super Admin Access</label>

                <select name="" id="" class="form-select" wire:model="admin_super">
                  <option value="" selected disabled>--Select--</option>
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
                
                @error('admin_super') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
              </div>
              
          </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary px-4 py-1"> Update</button>
      </div>
    </div>
  </form>
  </div>
</div>





{{-- Delete Banner Modal --}}
 
<div wire:ignore.self class="modal fade " id="deleteadminuser" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deleteadminuserLabel" aria-hidden="true">
  <div class="modal-dialog">

    <form wire:submit.prevent="removeAdminUser">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteadminuserLabel"> <strong>Delete Admin User</strong> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
      </div>
      <div class="modal-body px-4">

        <input type="hidden" name="" wire:model="admin_id" id="">

        Do you want to delete this User...?

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger px-4 py-1">Delete</button>
      </div>
    </div>
  </form>
  </div>
</div> 