{{--  --}}

<div>

    {{-- <title>Rudhra Connect - Settings</title> --}}
    
    <div class="container">

        @include('modals.settings-modal')
        <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
                Admin Settings
            </h3>
        </div>

        @if(session()->has('settingMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('settingMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        <div class="row">
            <ul class="nav nav-tabs nav-fill" id="myTab">
                <li class="nav-item">
                    <a href="#tandc" class="nav-link {{ $tab == 'tandc' ? 'active' : '' }}" wire:click="$set('tab', 'tandc')" data-bs-toggle="tab">Terms & Conditions</a>
                </li>
                <li class="nav-item">
                    <a href="#pp" class="nav-link {{ $tab == 'pp' ? 'active' : '' }}" wire:click="$set('tab', 'pp')" data-bs-toggle="tab">Privacy Policy</a>
                </li>

                <li class="nav-item">
                    <a href="#abt_us" class="nav-link {{ $tab == 'abt_us' ? 'active' : '' }}" wire:click="$set('tab', 'abt_us')" data-bs-toggle="tab">About US</a>
                </li>

                <li class="nav-item" wire:click="getDtl">
                    <a href="#cus" class="nav-link {{ $tab == 'cus' ? 'active' : '' }}" wire:click="$set('tab', 'cus')" data-bs-toggle="tab">Others</a>
                </li>
            </ul>
        </div>

        <div class="tab-content mt-3">

            <div wire:ignore class="tab-pane fade show active mb-5" id="tandc">
 
                <div class="p-4 mt-4">
                    <form wire:submit.prevent="updTerms">
        
                        <div class="col-md-12">
                            <label for="Image" class="fw-normal d-inline-block bg-primary px-4 py-1 text-white rounded">Terms and Conditions</label><br>
        
                            @foreach($get_terms as $terms)
                                <textarea wire:model.lazy="terms" class="form-control " name="terms" id="terms" style="height:300px;">{{$terms->value}}</textarea>
                            @endforeach
        
                            @error('terms') <span class="text-danger">{{$message}}</span>@enderror
        
                        </div>
        
                        <button type="submit" class="btn btn-primary px-4 my-3 float-end">Submit</button>
        
                    </form>
                </div>
    
            </div>

            <div wire:ignore class="tab-pane fade  mb-5" id='pp'>

                <div class="p-4 mt-4">

                    <form wire:submit.prevent="updPrivacy">
                
                        <div class="col-md-12">
            
                            <label for="Image" class="fw-normal d-inline-block bg-primary px-4 py-1 text-white rounded">Privacy Policy</label><br>
                            @foreach($get_privacy as $privacy)
                                <textarea wire:model="privacy" class="form-control required" name="privacy" id="privacy" style="height:300px;">{{$privacy->value}}</textarea>
                            @endforeach
                        </div>
            
                    
                        <button type="submit" class="btn btn-primary px-4 my-3 float-end">Submit</button>
                    </form>

                </div>
            </div>

            <div wire:ignore class="tab-pane fade  mb-5" id='abt_us'>

                <div class="p-4 mt-4">

                    <form wire:submit.prevent="updAbout">
                
                        <div class="col-md-12">
            
                            <label for="Image" class="fw-normal d-inline-block bg-primary px-4 py-1 text-white rounded">About US</label><br>
                            @foreach($get_about as $abt)
                                <textarea wire:model="abt" class="form-control required" name="abt" id="abt" style="height:300px;">{{$abt->value}}</textarea>
                            @endforeach
                        </div>
            
                    
                        <button type="submit" class="btn btn-primary px-4 my-3 float-end">Submit</button>
                    </form>

                </div>
            </div>

            <div wire:ignore class="tab-pane fade  mb-5" id='cus'>

               <!--  <div  class="row">
                    <div class="col-md-12">
                            
                        <label for="Image" class="fw-normal d-inline-block bg-primary px-4 py-1 text-white rounded"> <i class="fa fa-cog me-1"></i>Contact US</label><br>
                        <form wire:submit.prevent="updContactUS">

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-phone fw-bolder" aria-hidden="true"></i>
                                        Phone</label> <br> 
                                    <input wire:model.lazy="c_mble" type="tel" name="" id="" class="form-control">

                                    <br>
                                    @error('c_mble') <span class="text-danger fw-normal">{{ $message }}</span> @enderror
                                
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-whatsapp  fw-bolder" aria-hidden="true"></i>
                                        Whatsapp</label> <br>
                                    <input wire:model.lazy="c_wapp" type="tel" name="" id="" class="form-control" required>
                                    
                                    @error('c_wapp') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-envelope-o  fw-bolder" aria-hidden="true"></i>
                                        EMail</label> <br>
                                    <input wire:model.lazy="c_mail" type="emal" name="" id="" class="form-control" required>
                                    @error('c_mail') <span class="text-danger fw-normal">{{$message}}</span>@enderror
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 my-4 float-end">Submit</button>
                        </form>

                    </div> -->
                    
                </div>

                <?php
                
                $get_super = 0;

                foreach($chk_super as $sup){
                    $get_super = $sup->superuser;
                }
                
                ?>

                @if($get_super == 1)

                <div class="row border p-3 mt-4">

                    <div wire:ignore class="col-md-12">

                        <div class="my-3">

                            <label for="Image" class="fw-normal bg-primary px-4 py-1 text-white rounded"> <i class="fa fa-cog me-1"></i>Admin Users</label>

                            <button class="btn btn-sm px-4 btn-primary float-end" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus me-1" aria-hidden="true"></i> Add User</button>

                        </div>

                        <div class="collapse my-3" id="collapseExample">
                            <div class="card card-body">
                                <form wire:submit.prevent="InsUser">
                                    <div class="row">

                                        <label for="" class="">Add User</label>
                                        <div class="col-md-4 p-2">
                                            <input wire:model="admin_email_new" type="email" name="" id="" class="form-control" placeholder="Enter Email..." required>
                                        </div>
                                        <div class="col-md-4 p-2">
                                            <input wire:model="admin_pass_new" type="text" name="" id="" class="form-control" placeholder="Enter Password..." required>
                                        </div>
                                        <div class="col-md-4 p-2">
                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">

                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Email</th>
                                        <th>Super User</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php $tmpid = 1;?>

                                @foreach($get_admin_dtl as $dtl)

                                    <tr>
                                        <td class="align-middle">{{$tmpid}}</td>
                                        <td class="align-middle">{{$dtl->email}}

                                            @if(session()->get('authMail') == $dtl->email)

                                            <i class="ms-2 text-success fa fa-check" title="Active User" aria-hidden="true"></i>

                                            @endif
                                        
                                        </td>
                                        <td class="align-middle">{{($dtl->superuser == 1)?'Yes':'No'}}</td>
                                        <td class="align-middle">{{$dtl->created_at}}</td>
                                        <td class="align-middle"><button type="button"  class="btn btn-sm btn-primary rounded" data-bs-toggle="modal" data-bs-target="#editadminuser" wire:click='editAdminUser({{$dtl->id}})'><i class="fa fa-pencil"></i></button>
                                            <button  type="button" class="btn btn-sm btn-danger rounded" data-bs-toggle="modal" data-bs-target="#deleteadminuser" wire:click='deleteAdminUser({{$dtl->id}})'><i class="fa fa-times"></i></button></td>
                                    </tr>

                                    <?php $tmpid++; ?>
                                @endforeach
                                </tbody>

                            </table>
                        </div>

                        
                    </div>
                </div>

                @endif
            </div>
        </div>
       
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

<script>
     ClassicEditor
       .create(document.querySelector('#terms'))
       .then(editor => {
           editor.model.document.on('change:data', () => {
           @this.set('terms', editor.getData());
          })
       });


    ClassicEditor
       .create(document.querySelector('#privacy'))
       .then(editor => {
           editor.model.document.on('change:data', () => {
           @this.set('privacy', editor.getData());
          })
       });

    ClassicEditor
       .create(document.querySelector('#abt'))
       .then(editor => {
           editor.model.document.on('change:data', () => {
           @this.set('abt', editor.getData());
          })
       });
       
</script>
