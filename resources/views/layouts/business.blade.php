<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$brand}} - {{$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link href="{{ asset('admin/assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/dist/css/pages/dashboard4.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/dist/css/pages/inbox.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    {{-- <link href="{{ asset('admin/assets/dist/css/pages/ribbon-page.css') }}" rel="stylesheet"> --}}
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
</head>

<body class="skin-purple fixed-layout">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RUBI</p>
        </div>
    </div>
    
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand profile-pic" href="{{ route('rubi.dashboard') }}">
                        <img src="{{ auth()->guard('business')->user()->photo }}" class="light-logo" />
                    </a>
                </div>
                
                <div class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        
                    </ul>
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ auth()->guard('business')->user()->photo }}" alt="user" class=""> 
                                <span class="hidden-md-down">{{ auth()->guard('business')->user()->name }} &nbsp;<i class="fa fa-angle-down"></i></span> 
                            </a>
                            <div class="dropdown-menu dropdown-menu-end animated flipInY">
                                <!-- text-->
                                <a data-bs-toggle="modal" data-bs-target="#profileModal" class="dropdown-item"><i class="ti-user"></i> Business Profile</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="{{ route('business.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->

                                <form id="logout-form" action="{{ route('business.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">--- GENERAL</li>
                        <li><a class="waves-effect waves-dark" href="{{ route('business.dashboard') }}"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li><a class="waves-effect waves-dark" href="{{ route('business.departments') }}"><i class="icon-notebook"></i><span class="hide-menu">Departments</span></a></li>
                        <li><a class="waves-effect waves-dark" href="{{ route('business.admins') }}"><i class="icon-user"></i><span class="hide-menu">Admins</span></a></li>
                        <li><a class="waves-effect waves-dark" href="{{ route('business.activities') }}"><i class="icon-mouse"></i><span class="hide-menu">Activities</span></a></li>
                        
                        <li class="nav-small-cap">--- OTHER</li>
                        <li><a class="waves-effect waves-dark" href="{{ route('business.cashOutFlow') }}"><i class="icon-credit-card"></i><span class="hide-menu">Cash Outflow</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                
                
                
                
                
                
                
                
                
                
                
                
                @yield('content')
                @yield('script')
                
                
                
                
                
                
                
            </div>
        </div>
        <footer class="footer">© <?php echo date('Y'); ?> Rubi </footer>
    </div>
    <script src="{{ asset('admin/assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/waves.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/skycons/skycons.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/dashboard4.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/pages/toastr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('admin/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('admin/assets/upload.js') }}"></script>
    <script src="{{ asset('admin/assets/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/Chart.js/chartjs.init.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>


    {{-- Profile modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="profileModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Business Profile</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="row" id="updateForm" enctype="multipart/form-data" method="post">
                            <div class="form-group col-12">
                                <label class="form-label"><b>Name:</b> {{ auth()->guard('business')->user()->name }}</label><br>
                                <label class="form-label"><b>Type:</b> {{ auth()->guard('business')->user()->type }}</label><br>
                                <label class="form-label"><b>Product:</b> {{ auth()->guard('business')->user()->product }}</label><br>
                                <label class="form-label"><b>Email:</b> {{ auth()->guard('business')->user()->email }}</label><br>
                                <label class="form-label"><b>Website:</b> {{ auth()->guard('business')->user()->website }}</label><br>
                                <label class="form-label"><b>Country:</b> {{ auth()->guard('business')->user()->country }}</label><br>
                                <label class="form-label"><b>Verified On:</b> {{ auth()->guard('business')->user()->verifiedDate }}</label><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
</body>

</html>