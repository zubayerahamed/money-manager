<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>
    @isset($pageTitle)
        {{ $pageTitle }}    
    @else
        Money Manager
    @endisset
    </title>

    <!-- Global stylesheets -->
    <link href="/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="/assets/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/assets/js/vendor/forms/selects/select2.min.js"></script>
    <script src="/assets/js/vendor/notifications/noty.min.js"></script>
    <script src="/assets/js/vendor/visualization/echarts/echarts.min.js"></script>
    <script src="/assets/js/vendor/visualization/d3/d3.min.js"></script>
    <script src="/assets/js/vendor/visualization/d3/d3_tooltip.js"></script>

    <script src="/assets/js/app.js"></script>

    <script src="/assets/demo/charts/echarts/pies/pie_donut.js"></script>
    <script src="/assets/demo/pages/form_select2.js"></script>
    <!-- /theme JS files -->

    <style>
        .box-item{
            width: 48%;
            margin-left: 1%;
            margin-right: 1%;
            border-radius: 10px;
            padding: 10px !important;
            box-sizing: border-box;
            box-shadow: 0px 0px 5px #ddd;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .box-item-success{
            color: #fff;
            background-color: #059669;
        }
        .box-item-danger{
            color: #fff;
            background-color: #EF4444
        }
        .box-item-primary{
            color: #fff;
            background-color: #0c83ff;
        }
        .box-item h2, .box-item h3{
            padding: 0; 
            margin: 0;
        }

        input#avatar, input.dream-image{
            display: none;
        }
        #image {
            display: block;
            max-width: 100%;
        }
        .preview {
            text-align: center;
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 0 auto;
            border: 1px solid red;
        }
        .section{
            margin-top:150px;
            background:#fff;
            padding:50px 30px;
        }
    </style>
</head>

<body>

    <a href="{{ url('/') }}" class="basePath"></a>

    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
        <div class="container-fluid">
            <div class="d-flex d-lg-none me-2">
                <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                    <i class="ph-list"></i>
                </button>
            </div>

            <div class="navbar-brand flex-1 flex-lg-0">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center" style="text-decoration: none;">
                    <img src="/assets/images/logo_icon.png" alt="">
                    <h1 style="margin: 0; padding: 0; padding-left: 15px; color: #fff;">Money Manager</h1>
                </a>
            </div>


            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                        data-bs-toggle="dropdown">
                        <div class="status-indicator-container">
                            <img src="{{ auth()->user()->avatar }}" class="w-32px h-32px rounded-pill"
                                alt="">
                            <span class="status-indicator bg-success"></span>
                        </div>
                        <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ url('/profile') }}" class="dropdown-item">
                            <i class="ph-user-circle me-2"></i>
                            My profile
                        </a>
                        <a href="{{ url('/logout') }}" class="dropdown-item">
                            <i class="ph-sign-out me-2"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Sidebar header -->
                <div class="sidebar-section">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <div>
                            <button type="button"
                                class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="ph-arrows-left-right"></i>
                            </button>
                            <button type="button"
                                class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                <i class="ph-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /sidebar header -->


                <!-- Main navigation -->
                <div class="sidebar-section">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">

                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') || Request::is('transaction/**') ? 'active' : '' }}">
                                <i class="ph-house"></i>
                                <span>
                                    Home
                                </span>
                            </a>
                        </li>

                        <li class="nav-item nav-item-submenu {{ Request::is('wallet/**') || Request::is('wallet') ? 'nav-item-expanded nav-item-open' : '' }}">
							<a href="#" class="nav-link">
								<i class="ph-wallet"></i>
								<span>Wallet</span>
							</a>
							<ul class="nav-group-sub collapse {{ Request::is('wallet/**') || Request::is('wallet') ? 'show' : '' }}">
								<li class="nav-item"><a href="{{ url('/wallet/all') }}" class="nav-link {{ Request::is('wallet/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"><a href="{{ url('/wallet') }}" class="nav-link {{ Request::is('wallet') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
						</li>

                        <li class="nav-item nav-item-submenu {{ Request::is('income-source/**') || Request::is('income-source') ? 'nav-item-expanded nav-item-open' : '' }}">
							<a href="#" class="nav-link">
								<i class="ph-trend-up"></i>
								<span>Income Source</span>
							</a>
							<ul class="nav-group-sub collapse {{ Request::is('income-source/**') || Request::is('income-source') ? 'show' : '' }}">
								<li class="nav-item"> <a href="{{ url('/income-source/all') }}" class="nav-link {{ Request::is('income-source/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"> <a href="{{ url('/income-source') }}" class="nav-link {{ Request::is('income-source') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
						</li>
                        
                        <li class="nav-item nav-item-submenu {{ Request::is('expense-type/**') || Request::is('expense-type') ? 'nav-item-expanded nav-item-open' : '' }}">
							<a href="#" class="nav-link">
                                <i class="ph-trend-down"></i>
								<span>Expense Type</span>
							</a>
							<ul class="nav-group-sub collapse {{ Request::is('expense-type/**') || Request::is('expense-type') ? 'show' : '' }}">
								<li class="nav-item"> <a href="{{ url('/expense-type/all') }}" class="nav-link {{ Request::is('expense-type/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"> <a href="{{ url('/expense-type') }}" class="nav-link {{ Request::is('expense-type') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
						</li>

                        <li class="nav-item">
                            <a href="{{ url('/budget/'.date('m').'/'.date('Y').'/list') }}" class="nav-link {{ Request::is('budget/**') ? 'active' : '' }}">
                                <i class="fas fa-calculator"></i>
                                <span>
                                    Budget - {{ date('M, Y') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/tracking/details/today') }}" class="nav-link {{ Request::is('/tracking/details/today') ? 'active' : '' }}">
                                <i class="far fa-calendar-check"></i>
                                <span>
                                    Today's History
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/dream/all') }}" class="nav-link {{ Request::is('/dream/**') ? 'active' : '' }}">
                                <i class="fas fa-allergies"></i>
                                <span>
                                    Dreams
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/account/all') }}" class="nav-link {{ Request::is('/account/**') ? 'active' : '' }}">
                                <i class="fas fa-piggy-bank"></i>
                                <span>
                                    Accounts
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex">
                       
                            <h4 class="page-title text-center" style="margin: 0px;">
                                
                                <div class="d-inline-flex ms-auto" style="width: 100%">
                                    <a href="{{ url('/transaction/add-income') }}" class="btn btn-success">
                                       <i class="fas fa-plus-circle"></i> &nbsp; Add Income
                                    </a>
                                    <a href="{{ url('/transaction/add-expense') }}" class="btn btn-danger" style="margin-left: 10px;">
                                        <i class="fas fa-minus-circle"></i> &nbsp;  Add Expense
                                    </a>
                                    <a href="{{ url('/transaction/do-transfer') }}" class="btn btn-primary" style="margin-left: 10px;">
                                        <i class="fas fa-retweet"></i> &nbsp; Transfer
                                    </a>
                                </div>

                            </h4>
                        

                    </div>

                    
                </div>
                <!-- /page header -->

                @if (Session::has('success'))
                    <div class="col-md-12" style="padding: 20px; padding-bottom: 0px;">
                        <div class="alert alert-success alert-dismissible fade show" style="margin-bottom: 0px;">
                            <span class="fw-semibold">Well done!</span> {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="col-md-12" style="padding: 20px; padding-bottom: 0px;">
                        <div class="alert alert-danger alert-dismissible fade show" style="margin-bottom: 0px;">
                            <span class="fw-semibold">Oh snap!</span> {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif
                

                {{ $slot }}

                <!-- Footer -->
                <div class="navbar navbar-sm navbar-footer border-top">
                    <div class="container-fluid text-center">
                        <span>&copy; {{ date('Y') }} <a href="https://www.karigorit.com" target="_blank">Karigor IT</a></span>
                    </div>
                </div>
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>

    </div>
    <!-- /page content -->

</body>

</html>
