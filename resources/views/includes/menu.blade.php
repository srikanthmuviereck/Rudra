<style>
    .activeNav, .menu-list-group-item-action:hover{
        color: #0d6efc !important;
        font-weight: 600 !important;
        background: #fff !important;
		border-radius: 0 30px 30px 0 !important;
    }
	
	.admin-logo{
		background: #fff !important;
	}
</style>

{{-- <span class="float-end text-success"><i class="fa fa-dot-circle-o" title="Active"></i></span> --}}

<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class=" bg-primary" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom admin-logo fw-bolder text-white cursive">
            <img src="{{ asset('index_img/logo-admin.png') }}" alt="" width="170">
        </div>


        <div class="menu-list-group menu-list-group-flush mt-2">
            @php  $route = Route::current()->getName(); @endphp

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='welcome') activeNav @endif" href="/welcome"><i class="fa fa-tachometer me-1"></i> Dashboard</a> 

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='notification') activeNav @endif" href="/notification"><i class="fa fa-bell-o  me-1"></i> Notification </a> 

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='attendance') activeNav @endif" href="/attendance"><i class="fa fa-clock-o  me-1"></i> Attendance</a> 

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='securities') activeNav @endif" href="/securities"><i class="fa fa-users me-1"></i> Securities </a> 

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='supervisor') activeNav @endif" href="/supervisor"><i class="fa fa-users me-1"></i> Operation Team </a> 

            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='client') activeNav @endif" href="/client"><i class="fa fa-users me-1"></i> Clients </a> 
			
			<a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='fieldtracking') activeNav @endif" href="/fieldtracking"><i class="fa fa-location-arrow me-1"></i> Field Tracking  </a>
			
			<a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='payslip') activeNav @endif" href="/payslip"><i class="fa fa-inr me-1"></i> Salary Payslip </a>
			
			<a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white text-white p-3 @if($route=='reports') activeNav @endif" href="/reports"><i class="fa fa-bar-chart me-1"></i> Reports </a>  
            
            
            <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white p-3 @if($route=='settings') activeNav @endif"  href="/settings"><i class="fa fa-cog me-1"></i> Settings</a>
               <a class="menu-list-group-item menu-list-group-item-action menu-list-group-item-dark bg-primary border-0 text-white p-3 @if($route=='others') activeNav @endif"  href="/others"><i class="fa fa-cog me-1"></i>Other  Settings</a>

                           

        </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-0 ">
            <div class="container-fluid">
                <button class="btn btn-light text-primary shadow-lg" id="sidebarToggle"><i class="fa fa-bars"></i></button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-user"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item px-3 rounded"><a class="nav-link" href="/logout">Logout <i class="fa fa-sign-out ms-2"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div>
        <div class="container mt-4">

            <!--Creating a panel-->
                @yield('content')


        </div>
        </div>

    </div>
</div>
