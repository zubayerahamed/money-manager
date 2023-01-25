<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Global stylesheets -->
    <link href="/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="/assets/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/assets/js/vendor/notifications/noty.min.js"></script>
    <script src="/assets/js/vendor/visualization/echarts/echarts.min.js"></script>
    <script src="/assets/js/vendor/visualization/d3/d3.min.js"></script>
    <script src="/assets/js/vendor/visualization/d3/d3_tooltip.js"></script>

    <script src="/assets/js/app.js"></script>
    <script src="/assets/demo/pages/dashboard.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/streamgraph.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/sparklines.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/lines.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/areas.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/donuts.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/bars.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/progress.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/heatmaps.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/pies.js"></script>
    <script src="/assets/demo/charts/pages/dashboard/bullets.js"></script>

    <script src="/assets/demo/charts/echarts/pies/pie_donut.js"></script>
    <script src="/assets/demo/charts/echarts/lines/lines_basic.js"></script>
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
    </style>
</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
        <div class="container-fluid">
            <div class="d-flex d-lg-none me-2">
                <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                    <i class="ph-list"></i>
                </button>
            </div>

            <div class="navbar-brand flex-1 flex-lg-0">
                <a href="/" class="d-inline-flex align-items-center" style="text-decoration: none;">
                    <img src="/assets/images/logo_icon.png" alt="">
                    <h1 style="margin: 0; padding: 0; padding-left: 15px; color: #fff;">Money Manager</h1>
                </a>
            </div>


            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                        data-bs-toggle="dropdown">
                        <div class="status-indicator-container">
                            <img src="/assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill"
                                alt="">
                            <span class="status-indicator bg-success"></span>
                        </div>
                        <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">
                            <i class="ph-user-circle me-2"></i>
                            My profile
                        </a>
                        <a href="/logout" class="dropdown-item">
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
                        <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

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
                            <a href="/" class="nav-link {{ Request::is('/') || Request::is('transaction/**') ? 'active' : '' }}">
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
								<li class="nav-item"><a href="/wallet/all" class="nav-link {{ Request::is('wallet/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"><a href="/wallet" class="nav-link {{ Request::is('wallet') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
						</li>

                        <li class="nav-item nav-item-submenu {{ Request::is('income-source/**') || Request::is('income-source') ? 'nav-item-expanded nav-item-open' : '' }}">
							<a href="#" class="nav-link">
								<i class="ph-trend-up"></i>
								<span>Income Source</span>
							</a>
							<ul class="nav-group-sub collapse {{ Request::is('income-source/**') || Request::is('income-source') ? 'show' : '' }}">
								<li class="nav-item"> <a href="/income-source/all" class="nav-link {{ Request::is('income-source/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"> <a href="/income-source" class="nav-link {{ Request::is('income-source') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
						</li>
                        
                        <li class="nav-item nav-item-submenu {{ Request::is('expense-type/**') || Request::is('expense-type') ? 'nav-item-expanded nav-item-open' : '' }}">
							<a href="#" class="nav-link">
                                <i class="ph-trend-down"></i>
								<span>Expense Type</span>
							</a>
							<ul class="nav-group-sub collapse {{ Request::is('expense-type/**') || Request::is('expense-type') ? 'show' : '' }}">
								<li class="nav-item"> <a href="/expense-type/all" class="nav-link {{ Request::is('expense-type/all') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Status</a></li>
								<li class="nav-item"> <a href="/expense-type" class="nav-link {{ Request::is('expense-type') ? 'active' : '' }}"><i class="fas fa-plus-square"></i> Create</a></li>
							</ul>
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
                                    <a href="/transaction/add-income" class="btn btn-success">
                                       <i class="fas fa-plus-circle"></i> &nbsp; Add Income
                                    </a>
                                    <a href="/transaction/add-expense" class="btn btn-danger" style="margin-left: 10px;">
                                        <i class="fas fa-minus-circle"></i> &nbsp;  Add Expense
                                    </a>
                                    <a href="/transaction/do-transfer" class="btn btn-primary" style="margin-left: 10px;">
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
                        <span>&copy; {{ date('Y') }} <a href="https://www.karigorit.com">Karigor IT</a></span>
                    </div>
                </div>
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>

    </div>
    <!-- /page content -->


    <!-- Notifications -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
        <div class="offcanvas-header py-0">
            <h5 class="offcanvas-title py-3">Activity</h5>
            <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
                data-bs-dismiss="offcanvas">
                <i class="ph-x"></i>
            </button>
        </div>

        <div class="offcanvas-body p-0">
            <div class="bg-light fw-medium py-2 px-3">New notifications</div>
            <div class="p-3">
                <div class="d-flex align-items-start mb-3">
                    <a href="#" class="status-indicator-container me-3">
                        <img src="/assets/images/demo/users/face1.jpg" class="w-40px h-40px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-success"></span>
                    </a>
                    <div class="flex-fill">
                        <a href="#" class="fw-semibold">James</a> has completed the task <a
                            href="#">Submit documents</a> from <a href="#">Onboarding</a> list

                        <div class="bg-light rounded p-2 my-2">
                            <label class="form-check ms-1">
                                <input type="checkbox" class="form-check-input" checked disabled>
                                <del class="form-check-label">Submit personal documents</del>
                            </label>
                        </div>

                        <div class="fs-sm text-muted mt-1">2 hours ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <a href="#" class="status-indicator-container me-3">
                        <img src="/assets/images/demo/users/face3.jpg" class="w-40px h-40px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-warning"></span>
                    </a>
                    <div class="flex-fill">
                        <a href="#" class="fw-semibold">Margo</a> has added 4 users to <span
                            class="fw-semibold">Customer enablement</span> channel

                        <div class="d-flex my-2">
                            <a href="#" class="status-indicator-container me-1">
                                <img src="/assets/images/demo/users/face10.jpg" class="w-32px h-32px rounded-pill"
                                    alt="">
                                <span class="status-indicator bg-danger"></span>
                            </a>
                            <a href="#" class="status-indicator-container me-1">
                                <img src="/assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill"
                                    alt="">
                                <span class="status-indicator bg-success"></span>
                            </a>
                            <a href="#" class="status-indicator-container me-1">
                                <img src="/assets/images/demo/users/face12.jpg" class="w-32px h-32px rounded-pill"
                                    alt="">
                                <span class="status-indicator bg-success"></span>
                            </a>
                            <a href="#" class="status-indicator-container me-1">
                                <img src="/assets/images/demo/users/face13.jpg" class="w-32px h-32px rounded-pill"
                                    alt="">
                                <span class="status-indicator bg-success"></span>
                            </a>
                            <button type="button"
                                class="btn btn-light btn-icon d-inline-flex align-items-center justify-content-center w-32px h-32px rounded-pill p-0">
                                <i class="ph-plus ph-sm"></i>
                            </button>
                        </div>

                        <div class="fs-sm text-muted mt-1">3 hours ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-pill">
                            <i class="ph-warning p-2"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        Subscription <a href="#">#466573</a> from 10.12.2021 has been cancelled. Refund
                        case <a href="#">#4492</a> created
                        <div class="fs-sm text-muted mt-1">4 hours ago</div>
                    </div>
                </div>
            </div>

            <div class="bg-light fw-medium py-2 px-3">Older notifications</div>
            <div class="p-3">
                <div class="d-flex align-items-start mb-3">
                    <a href="#" class="status-indicator-container me-3">
                        <img src="/assets/images/demo/users/face25.jpg" class="w-40px h-40px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-success"></span>
                    </a>
                    <div class="flex-fill">
                        <a href="#" class="fw-semibold">Nick</a> requested your feedback and approval in
                        support request <a href="#">#458</a>

                        <div class="my-2">
                            <a href="#" class="btn btn-success btn-sm me-1">
                                <i class="ph-checks ph-sm me-1"></i>
                                Approve
                            </a>
                            <a href="#" class="btn btn-light btn-sm">
                                Review
                            </a>
                        </div>

                        <div class="fs-sm text-muted mt-1">3 days ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <a href="#" class="status-indicator-container me-3">
                        <img src="/assets/images/demo/users/face24.jpg" class="w-40px h-40px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-grey"></span>
                    </a>
                    <div class="flex-fill">
                        <a href="#" class="fw-semibold">Mike</a> added 1 new file(s) to <a
                            href="#">Product management</a> project

                        <div class="bg-light rounded p-2 my-2">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <img src="/assets/images/icons/pdf.svg" width="34" height="34"
                                        alt="">
                                </div>
                                <div class="flex-fill">
                                    new_contract.pdf
                                    <div class="fs-sm text-muted">112KB</div>
                                </div>
                                <div class="ms-2">
                                    <button type="button"
                                        class="btn btn-flat-dark text-body btn-icon btn-sm border-transparent rounded-pill">
                                        <i class="ph-arrow-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="fs-sm text-muted mt-1">1 day ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <div class="me-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="ph-calendar-plus p-2"></i>
                        </div>
                    </div>
                    <div class="flex-fill">
                        All hands meeting will take place coming Thursday at 13:45.

                        <div class="my-2">
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="ph-calendar-plus ph-sm me-1"></i>
                                Add to calendar
                            </a>
                        </div>

                        <div class="fs-sm text-muted mt-1">2 days ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <a href="#" class="status-indicator-container me-3">
                        <img src="/assets/images/demo/users/face4.jpg" class="w-40px h-40px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-danger"></span>
                    </a>
                    <div class="flex-fill">
                        <a href="#" class="fw-semibold">Christine</a> commented on your community <a
                            href="#">post</a> from 10.12.2021

                        <div class="fs-sm text-muted mt-1">2 days ago</div>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <div class="me-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-pill">
                            <i class="ph-users-four p-2"></i>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <span class="fw-semibold">HR department</span> requested you to complete internal
                        survey by
                        Friday

                        <div class="fs-sm text-muted mt-1">3 days ago</div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /notifications -->



</body>

</html>
