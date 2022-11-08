
<div>

    @include('modals.payslip-modal')

    <div class="container">
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Payslip
            </h3>
        </div>

        @if(session()->has('payslipMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('payslipMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

         <div class="my-3 text-end">
            <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addPayslipModal"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add Payslip</button>
        </div>

        <livewire:powergrid.payslip-p-g/>

    </div>
</div>

<script>
    window.addEventListener('downloadPdf', event => {
        // alert(event.detail.downloadLink);

        console.log(event.detail.downloadLink);
        var dw = event.detail.downloadLink;
        var name = event.detail.fileName;
        let link = document.createElement("a");
        link.setAttribute('target', '_blank');
        link.download = name;
        link.href = dw;
        link.click();
        link.remove();

    });

    window.addEventListener('editPSEntry', event => {

        $('#editPayslipModal').modal('show');

    });

    window.addEventListener('deletePSEntry', event => {

        $('#deletePayslipModal').modal('show');

    });
</script>
