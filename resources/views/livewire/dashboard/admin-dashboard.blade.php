<title>Rudhra Connect - Dashboard</title>

<div>

    <div class="container">
        @if(session()->has('login_success'))
            <div class="alert alert-success alert-dismissible px-3 bold">
                {{ session()->get('login_success') }}
                <button class="pull-right btn btn-large pt-0" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif
        <div class="row my-3">
            <div class="col-md-4 mt-3">
                <div class="card border-end rounded" style="border: 0 !important; border-left: 5px solid rgb(0, 102, 255) !important;border-radius: 15px !important; box-shadow: 2px 3px 10px rgb(226, 226, 226) !important;">
                    <div class="card-body">

                        <div class="row">

                        <div class="col-md-4">

                            <h2 class="card-title fw-bolder fs-1" style="color: rgb(0, 102, 255);"><i class="fa fa-users" style="font-size: 40px !important;" aria-hidden="true"></i></h2>
                            <p class="card-text fw-bold">Security</p>

                        </div>

                        <div class="col-md-8 text-end">

                            <h2 class="h2 me-2">{{$count_security}}</h2>
                        <a href="securities" class="btn btn-primary btn-sm rounded-pill px-4">View Entire Details</a>

                        </div>
                    </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card border-end rounded" style="border: 0 !important; border-left: 5px solid rgb(0, 102, 255) !important;border-radius: 15px !important; box-shadow: 2px 3px 10px rgb(226, 226, 226) !important;">
                    <div class="card-body">

                        <div class="row">

                        <div class="col-md-4">

                            <h2 class="card-title fw-bolder fs-1" style="color: rgb(0, 102, 255);"><i class="fa fa-users" style="font-size: 40px !important;" aria-hidden="true"></i></h2>
                            <p class="card-text fw-bold">Teams</p>

                        </div>

                        <div class="col-md-8 text-end">

                            <h2 class="h2 me-2">{{$count_supervisor}}</h2>
                        <a href="supervisor" class="btn btn-primary btn-sm rounded-pill px-4">View Entire Details</a>

                        </div>
                    </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card border-end rounded" style="border: 0 !important; border-left: 5px solid rgb(0, 102, 255) !important;border-radius: 15px !important; box-shadow: 2px 3px 10px rgb(226, 226, 226) !important;">
                    <div class="card-body">

                        <div class="row">

                        <div class="col-md-4">

                            <h2 class="card-title fw-bolder fs-1" style="color: rgb(0, 102, 255);"><i class="fa fa-users" style="font-size: 40px !important;" aria-hidden="true"></i></h2>
                            <p class="card-text fw-bold">Clients</p>

                        </div>

                        <div class="col-md-8 text-end">

                            <h2 class="h2 me-2">{{$count_client}}</h2>
                        <a href="client" class="btn btn-primary btn-sm rounded-pill px-4">View Entire Details</a>

                        </div>
                    </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 py-3 rounded">
                <h4 class="h6  text-center bg-primary text-white py-2 rounded">Recent Securities</h4>

                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>RCS EMP ID</th>
                                <th>Security Name</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            @foreach($security as $scrt)
                                <tr>
                                    <td>{{$scrt->scrt_id}}</td>
                                    <td>{{$scrt->name}}</td>
                                    <td>{{$scrt->mobile}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>

            <div class="col-md-6 py-3 rounded">
                <h4 class="h6  text-center bg-primary text-white py-2 rounded">Recent Operation Teams</h4>
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>RCS EMP ID</th>
                                <th>Name</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supervisor as $spvr)
                                <tr>
                                    <td>{{$spvr->spvr_id}}</td>
                                    <td>{{$spvr->name}}</td>
                                    <td>{{$spvr->mobile}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                        
        </div>

        <div class="row mt-5">
            <div class="col-md-6 py-3 rounded">
                <h4 class="h6  text-center bg-primary text-white py-2 rounded">Recent Clients</h4>

                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Client ID</th>
                                <th>Client Name</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            @foreach($client as $clnt)
                                <tr>
                                    <td>{{$clnt->clnt_id}}</td>
                                    <td>{{$clnt->c_name}}</td>
                                    <td>{{$clnt->mobile}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
                        
        </div>

        
    </div>
</div>