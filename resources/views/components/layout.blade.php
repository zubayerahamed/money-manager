<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>
        @isset($pageTitle)
            MM | {{ $pageTitle }}
        @else
            MM - Money Manager
        @endisset
    </title>

    <!-- Favicon icon -->
    <link href="{{ asset('/assets/images/favicon-32x32.png') }}" rel="icon" type="image/png" sizes="32x32">

    <!-- Stylesheets -->
    <link href="{{ asset('/assets/fonts/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/material/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <link href="{{ asset('/assets/css/kit-bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-components.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-layout.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <link href="{{ asset('/assets/css/cropper.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/bootstrap-iconpicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/kit-custom.css') }}" rel="stylesheet" />
    <!-- ./Stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ./Core JS files -->

    <!-- Vendor JS files -->
    <script src="{{ asset('/assets/js/cropper.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/echarts.min.js') }}"></script>
    <script src="{{ asset('/assets/js/d3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/d3_tooltip.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/noty.min.js') }}"></script>
    <!-- ./Vendor JS files -->

    <!-- Custom Js Files -->
    <script src="{{ asset('/assets/js/kit.js') }}"></script>
    <script src="{{ asset('/assets/js/kit-custom.js') }}"></script>
    <script src="{{ asset('/assets/js/kit-image-upload.js') }}"></script>
    <!-- ./Custom Js Files -->
</head>

<body>

    <!-- Project Base Path -->
    <a href="{{ route('home') }}" class="basePath"></a>

    <!-- Top Navbar -->
    <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
        <div class="container-fluid">

            <!-- Sidebar Toggle Button -->
            <div class="d-flex d-lg-none me-2">
                <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                    <i class="ph-list"></i>
                </button>
            </div>
            <!-- ./Sidebar Toggle Button -->

            <!-- Logo and Site Title -->
            <div class="navbar-brand flex-1 flex-lg-0 justify-content-center justify-content-md-start">
                <a href="{{ route('home') }}"><img src="{{ systemsettingsNow('site_logo') }}" class="h-40px me-2" alt=""></a>
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center d-none d-md-block" style="text-decoration: none;">
                    <h1 class="m-0 text-light">{{ systemsettingsNow('site_title') }}</h1>
                </a>
            </div>
            <!-- ./Logo and Site Title -->

            <!-- User Profile Section -->
            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                       data-bs-toggle="dropdown">
                        <div class="status-indicator-container">
                            <img src="{{ auth()->user()->avatar }}" class="w-32px h-32px rounded-pill" alt="{{ auth()->user()->name }}">
                            <span class="status-indicator bg-success"></span>
                        </div>
                        <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="ph-user-circle me-2"></i> My profile
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="ph-sign-out me-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
            <!-- ./User Profile Section -->
        </div>
    </div>
    <!-- ./Top Navbar -->

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
            <!-- Sidebar content -->
            <div class="sidebar-content">
                <!-- Sidebar Close Button -->
                <div class="sidebar-section d-block d-lg-none">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <div>
                            <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                <i class="ph-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ./Sidebar Close Button -->

                <!-- Sidebar Main Navigation -->
                <div class="sidebar-section">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                <i class="ph-house"></i>
                                <span>{{ __('menu.home') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('wallet.index') }}" class="nav-link {{ Request::is('wallet/all') ? 'active' : '' }}">
                                <i class="ph-wallet"></i>
                                <span>{{ __('menu.wallet.status') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('income-source.index') }}" class="nav-link {{ Request::is('income-source/all') ? 'active' : '' }}">
                                <i class="ph-chart-line-up"></i>
                                <span>{{ __('menu.income.status') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('expense-type.index') }}" class="nav-link {{ Request::is('expense-type/all') ? 'active' : '' }}">
                                <i class="ph-chart-bar-horizontal"></i>
                                <span>{{ __('menu.expense.status') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('budget.index', [date('m'), date('Y')]) }}" class="nav-link {{ Request::is('budget/**') ? 'active' : '' }}">
                                <i class="ph-calculator"></i>
                                <span>{{ __('menu.budget') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('tracking.today') }}" class="nav-link {{ Request::is('/tracking/details/today') ? 'active' : '' }}">
                                <i class="ph-calendar-check"></i>
                                <span>{{ __('menu.day.history') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('dream.index') }}" class="nav-link {{ Request::is('/dream/**') ? 'active' : '' }}">
                                <i class="ph-cloud-moon"></i>
                                <span>{{ __('menu.dreams') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- ./Sidebar Main Navigation -->
            </div>
            <!-- ./Sidebar content -->
        </div>
        <!-- ./Main sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-light page-header-static shadow">
                <div class="page-header-content d-lg-flex">

                    <!-- Transaction Action Buttons -->
                    <h4 class="page-title text-center m-0">
                        <div class="btn-group" role="group">
                            <a href="{{ route('add-income') }}" class="transaction-btn btn btn-light text-success" data-title="{{ __('transaction.btn.add-income') }}" title="{{ __('transaction.btn.add-income') }}">
                                <i class="fas fa-plus-circle"></i>
                                <div class="d-none d-md-block ms-2">{{ __('transaction.btn.add-income') }}</div>
                            </a>

                            <a href="{{ route('add-expense') }}" class="transaction-btn btn btn-light text-danger" data-title="{{ __('transaction.btn.add-expense') }}" title="{{ __('transaction.btn.add-expense') }}">
                                <i class="fas fa-minus-circle"></i>
                                <div class="d-none d-md-block ms-2">{{ __('transaction.btn.add-expense') }}</div>
                            </a>

                            <a href="{{ route('do-transfer') }}" class="transaction-btn btn btn-light text-primary" data-title="{{ __('transaction.btn.do-transfer') }}" title="{{ __('transaction.btn.do-transfer') }}">
                                <i class="fas fa-exchange-alt"></i>
                                <div class="d-none d-md-block ms-2">{{ __('transaction.btn.do-transfer') }}</div>
                            </a>

                            <a href="#" class="btn btn-light text-warning" onclick="location.reload()" title="{{ __('transaction.btn.reload-page') }}">
                                <i class="fas fa-sync-alt"></i>
                                <div class="d-none d-md-block ms-2">{{ __('transaction.btn.reload-page') }}</div>
                            </a>
                        </div>
                    </h4>
                    <!-- ./Transaction Action Buttons -->

                </div>
            </div>
            <!-- ./Page header -->

            <!-- Content Inner -->
            <div class="content-inner">
                <!-- Notification Message -->
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
                <!-- ./Notification Message -->

                {{ $slot }}

                <!-- Footer -->
                <div class="navbar navbar-sm navbar-footer border-top">
                    <div class="container-fluid justify-content-center">
                        {!! systemsettingsNow('copyright_text') !!}
                    </div>
                </div>
                <!-- /Footer -->

            </div>
            <!-- ./Content Inner -->
        </div>
        <!-- ./Content Wrapper -->

    </div>
    <!-- /Page content -->

    <!-- Transaction Modal -->
    <div class="modal fade" id="transaction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title transaction-modal-title">Modal Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- ./Modal Header -->

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 transaction-form-wrapper"></div>
                    </div>
                </div>
                <!-- ./Modal body -->

            </div>
        </div>
    </div>
    <!-- ./Transaction Modal -->

    <!-- Image Cropper Modal -->
    <div id="avatar-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Crop & Resize your avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- ./Modal Header -->

                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Modal body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger crop-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
                <!-- ./Modal footer -->

            </div>
        </div>
    </div>
    <!-- ./Image Cropper Modal -->

    <!-- Loading Mask -->
    <div>
        <div id="loadingmask2" class="nodisplay">
            <div id="loadingdots" class="nodisplay">
                <div id="loadingdots_1" class="loadingdots nodisplay">L</div>
                <div id="loadingdots_2" class="loadingdots nodisplay">O</div>
                <div id="loadingdots_3" class="loadingdots nodisplay">A</div>
                <div id="loadingdots_4" class="loadingdots nodisplay">D</div>
                <div id="loadingdots_5" class="loadingdots nodisplay">I</div>
                <div id="loadingdots_6" class="loadingdots nodisplay">N</div>
                <div id="loadingdots_7" class="loadingdots nodisplay">G</div>
            </div>
        </div>
    </div>
    <!-- ./Loading Mask -->

</body>

</html>
