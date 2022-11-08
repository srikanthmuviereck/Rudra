
{{-- <title>Rudhra Connect - Attendance</title> --}}

<div>

    {{-- @include('modals.clients-modal') --}}

    {{-- Modal Delete --}}

    <div wire:ignore.self class="modal fade " id="deleteAttModal" tabindex="-1" aria-labelledby="deleteAttModalLabel" aria-hidden="true">
        <div class="modal-dialog">
    
          <form wire:submit.prevent="removeAttendance">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="deleteAttModalLabel"> <strong>Delete Attendance</strong> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body px-4">
        
                <input wire:model="att_id" type="hidden" name=""  id="">
        
                Do you want to delete this Attendance Entry ...?
        
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-danger px-4 py-1">Delete</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    {{-- Main Content --}}

    <div class="container">
        <div class="row mb-4">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Attendance
            </h3>
        </div>

        @if(session()->has('attendanceMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('attendanceMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <livewire:powergrid.attendance-p-g/>
    </div>

</div>


<script>
    window.addEventListener('attendanceDelete', event =>{
        $('#deleteAttModal').modal('show');
    });
</script>