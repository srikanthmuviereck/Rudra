<div>

    <section class="mt-5 " >
        <div class="container ">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-lg" style="border: 0 !important;border-radius: 1rem;">
                <div class="card-body p-5">

                  <div class="text-center mb-4">
                    <img src="{{ asset('index_img/logo.png') }}" alt="" width="150">
                  </div>
                

                  @error('login_error')
                    <span class="error text-center mt-2" role="alert">
                      <strong>{{ $message }}</strong><br/><br/>
                    </span>
                  @enderror

                  <form method="post" wire:submit.prevent="submit">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email</label>
                      <input type="email" class="form-control" wire:model="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    @error('email')
                    <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="mb-4">
                      <label for="loginpassword" class="form-label">Password</label>
                      <input type="password" class="form-control" wire:model="password" id="loginpassword">
                      @error('password')
                      <span class="error" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="text-center mt-2">
    
                        <button type="submit" wire:click.prevent='submit' class="btn btn-primary btn-block px-5 py-2 rounded-pill"><i class="fa fa-sign-in me-1" aria-hidden="true"></i> Login</button>
    
                    </div>

                  
                    
                  </form>
        
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    
</div>
