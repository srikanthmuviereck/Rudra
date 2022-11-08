
<div>

    @include('modals.clients-modal')

    <div class="container">
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Client
            </h3>
        </div>
		
		@if(session()->has('dangerMessage'))
            <div class="alert alert-danger alert-dismissible px-3 bold">
                {{ session()->get('dangerMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        @if(session()->has('clientMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('clientMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <div class="my-3 text-end">
        <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#BranchtModal"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add Branch</button>
            <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#clientModal"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add Client</button>
        </div>
        <livewire:powergrid.client-p-g/>
    </div>
</div>


<script>
    window.addEventListener('clientEditModal', event => {
        $('#editClientModal').modal('show');
    });

    window.addEventListener('clientDeleteModal', event => {
        $('#deleteClientModal').modal('show');
    });
	
	window.addEventListener('securityview', event =>{
        $('#securitymodal').modal('show');
    });
</script>