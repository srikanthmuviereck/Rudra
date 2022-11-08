
<style>
    .nav-item .active{
        background: rgb(12, 117, 238) !important;
        color: #fff !important;
    }

    .nav-link:hover{
        background: rgb(12, 117, 238) !important;
        color: #fff !important;
    }
</style>

<div>
    
    <div class="container">

        @include('modals.settings-modal')
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Reports
            </h3>
        </div>

        <div class="row my-2">
            <ul class="nav nav-tabs nav-fill" id="myTab">
                <li class="nav-item">
                    <a href="#secreport" class="nav-link {{ $tab == 'secreport' ? 'active' : '' }}" wire:click="$set('tab', 'secreport')" data-bs-toggle="tab">Security</a>
                </li>
                <li class="nav-item">
                    <a href="#spvrreport" class="nav-link {{ $tab == 'spvrreport' ? 'active' : '' }}" wire:click="$set('tab', 'spvrreport')" data-bs-toggle="tab">Operation Team</a>
                </li>

                <li class="nav-item">
                    <a href="#clntreport" class="nav-link {{ $tab == 'clntreport' ? 'active' : '' }}" wire:click="$set('tab', 'clntreport')" data-bs-toggle="tab">Client</a>
                </li>

            </ul>
        </div>

        <div class="tab-content mt-3">

            {{-- Security --}}

            <div wire:ignore class="tab-pane fade show active mb-5" id="secreport">
 
                <div class="p-4 mt-4">

                    <livewire:powergrid.reports.secreport-p-g/>
                    
                </div>
    
            </div>

            {{-- Operation Team --}}

            <div wire:ignore class="tab-pane fade show mb-5" id="spvrreport">
 
                <div class="p-4 mt-4">

                    <livewire:powergrid.reports.spvrreport-p-g/>
                    
                </div>
    
            </div>

            {{-- Client --}}

            <div wire:ignore class="tab-pane fade show mb-5" id="clntreport">
 
                <div class="p-4 mt-4">

                    <livewire:powergrid.reports.clntreport-p-g/>
                    
                </div>
    
            </div>

        </div>
    </div>
</div>

