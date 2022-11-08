<div>

    @include('modals.notify-modal')

    <div class="container">
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Notifications
            </h3>
        </div>

        @if(session()->has('notifyMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('notifyMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <div class="my-3 text-end">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#notificationModal"><i class="fa fa-paper-plane me-2" aria-hidden="true"></i> Send Notification</button>
        </div>

        <livewire:powergrid.notification-p-g/>


    </div>
</div>

<script>
    window.addEventListener('notifyDelete', event => {
        $('#deletenotify').modal('show');
    })
</script>