<div>

    {{-- <title>Rudhra Connect - Settings</title> --}}
    
    <div class="container">

       
       <div class="row">
            <h3 class="text-center text-white bg-primary py-2 rounded">
            Other Settings
            </h3>
        </div>

        @if(session()->has('settingMessage'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('settingMessage') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif
         <div  class="row">
                    <div class="col-md-12">
                            
                        <label for="Image" class="fw-normal d-inline-block bg-primary px-4 py-1 text-white rounded"> <i class="fa fa-cog me-1"></i>Contact US</label><br>
                        <form wire:submit.prevent="updContactUS">

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-phone fw-bolder" aria-hidden="true"></i>
                                        Phone</label> <br> 
                                    <input wire:model.lazy="mobile" type="tel" name="" id="" class="form-control">

                                    <br>
                                    @error('mobile') <span class="text-danger fw-normal">{{ $message }}</span> @enderror
                                
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-whatsapp  fw-bolder" aria-hidden="true"></i>
                                        Whatsapp</label> <br>
                                    <input wire:model.lazy="whatsapp" type="tel" name="" id="" class="form-control" required>
                                    
                                    @error('whatsapp') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="fw-normal"><i class="fa fa-envelope-o  fw-bolder" aria-hidden="true"></i>
                                        EMail</label> <br>
                                    <input wire:model.lazy="mail" type="emal" name="" id="" class="form-control" required>
                                    @error('mail') <span class="text-danger fw-normal">{{$message}}</span>@enderror
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 my-4 float-end">Submit</button>
                        </form>

                    </div>
                    
                </div>
</div></div>
