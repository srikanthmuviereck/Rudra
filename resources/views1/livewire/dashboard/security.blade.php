<div>

  <title>Rudhra Connect - Securities</title>
        
    @include('modals.security-modal')

    <div class="container">
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Securities
            </h3>
        </div>
		
		@if(session()->has('dangerMessage'))
            <div class="alert alert-danger alert-dismissible px-3 bold">
                {{ session()->get('dangerMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        @if(session()->has('securityMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('securityMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <div class="my-3 text-end">
            <button type="button"  class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#securityTrack"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Track Securities</button>
            <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#addSecurityModal"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add Security</button>
        </div>
        <livewire:powergrid.securities-p-g/>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  window.addEventListener('securityEdit', event =>{
        $('#editSecurityModal').modal('show');
    });

    window.addEventListener('securityDelete', event =>{
        $('#deleteSecurityModal').modal('show');
    });
</script>
