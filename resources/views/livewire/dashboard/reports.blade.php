{{-- <title>Rudhra Connect - Reports</title> --}}

<div>
   
        {{-- @include('modals.supervisor-modal') --}}

        <div class="container">
            <div class="row">
                <h3 class="text-center text-white bg-primary py-2 rounded">
                    Reports
                </h3>
            </div>
    
            @if(session()->has('supervisorMessage'))
                <div class="alert alert-success alert-dismissible px-3 bold">
                    {{ session()->get('supervisorMessage') }}
                    <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            @endif

            
{{-- 
            <div class="row">
                <ul class="nav nav-tabs nav-fill" id="myTab">
                    <li class="nav-item">
                        <a href="#scrt" class="nav-link {{ $tab == 'scrt' ? 'active' : '' }}" wire:click="$set('tab', 'scrt')" data-bs-toggle="tab">Security</a>
                    </li>
                    <li class="nav-item">
                        <a href="#spvr" class="nav-link {{ $tab == 'spvr' ? 'active' : '' }}" wire:click="$set('tab', 'spvr')" data-bs-toggle="tab">Operation Team</a>
                    </li>
    
                    <li class="nav-item">
                        <a href="#clnt" class="nav-link {{ $tab == 'clnt' ? 'active' : '' }}" wire:click="$set('tab', 'clnt')" data-bs-toggle="tab">Client</a>
                    </li>

                </ul>
            </div> --}}

            {{-- <div class="tab-content mt-3">

                <div wire:ignore class="tab-pane fade show active mb-5" id="scrt"> --}}

                    

                    <div class="row">

                    <form wire:submit.prevent="sbmt_scrtForm">
                        <div class="row py-4">
                            {{-- <div class=""> --}}
                                <div class="col-md-4">
                                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">From</label><br>
                                    <input type="date" class="form-control mb-1" id="Image" wire:model="sf_date">
                                    @error('sf_date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">To</label><br>
                                    <input type="date" class="form-control mb-1" id="Image" wire:model="st_date">
                                    @error('st_date') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded">Category</label><br>
                                    <select name="" id="" class="form-select mb-1" wire:model="st_cat">
                                        <option value="">--Select--</option>
                                        <option value="client">Client</option>
                                        <option value="operationteam">Operation Team</option>
                                        <option value="all">Security</option>
                                        {{-- <option value="">Individual Security</option> --}}
                                    </select>
                                    @error('st_cat') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            {{-- </div> --}}
                        </div>

                        <div>
                            {{-- <a href="/reports" class="btn btn-sm btn-danger px-3"> <i class="fa fa-arrow-left me-1" aria-hidden="true"></i> Back</a> --}}
                            <button type="submit"  class="btn btn-sm btn-primary px-3 float-end"><i class="fa fa-filter me-1" aria-hidden="true"></i> Filter</button>
                        </div>

                    </form>

                    <div class="my-4">
                        <livewire:powergrid.reports-p-g/>
                    </div>

                </div>
                {{-- </div> --}}

                {{-- <div wire:ignore class="tab-pane fade  mb-5" id='spvr'>

                    Abcd

                </div>

                <div wire:ignore class="tab-pane fade  mb-5" id='clnt'>

                    Abcdclnt

                </div>
            </div> --}}


            
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    

    
    