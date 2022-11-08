<div>

    @include('modals.fieldtracking-modal')

    <div class="container">
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Field Tracking
            </h3>
        </div>

        @if(session()->has('ftMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('ftMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <div class="my-3 text-end">
            {{-- <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#clientModal"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add Client</button> --}}
        </div>
        <livewire:powergrid.fieldtracking-p-g/>
    </div>
</div>

<script>
    window.addEventListener('viewTrackDetails', event => {
        $('#viewFTModal').modal('show');
    });

    window.addEventListener('deleteTrackDetails', event => {
        $('#deleteFTModal').modal('show');
    });

</script>