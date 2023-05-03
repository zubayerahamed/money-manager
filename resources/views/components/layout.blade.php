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
    <link href="{{ asset('/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>

    <script src="{{ asset('/assets/demo/charts/echarts/pies/pie_donut.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <!-- /theme JS files -->

    <style>
        .nodisplay {
            display: none;
        }

.toast-msg-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    min-width: 350px;
    z-index: 9999999;
}

        .box-item {
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

        .box-item-success {
            color: #fff;
            background-color: #059669;
        }

        .box-item-danger {
            color: #fff;
            background-color: #EF4444
        }

        .box-item-primary {
            color: #fff;
            background-color: #0c83ff;
        }

        .box-item h2,
        .box-item h3 {
            padding: 0;
            margin: 0;
        }

        input#avatar,
        input.dream-image {
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

        .section {
            margin-top: 150px;
            background: #fff;
            padding: 50px 30px;
        }

        /* ===============
=== Loading mask 2
================== */
        #loadingdots {
            position: relative;
            height: 100px;
            width: 200px;
            top: calc(50% - 50px);
            left: calc(50% - 100px);
        }

        #loadingdots_1 {
            left: 0;
            -moz-animation-delay: 0s;
            -webkit-animation-delay: 0s;
            -ms-animation-delay: 0s;
            -o-animation-delay: 0s;
            animation-delay: 0s;
        }

        #loadingdots_2 {
            left: 30px;
            -moz-animation-delay: 0.2s;
            -webkit-animation-delay: 0.2s;
            -ms-animation-delay: 0.2s;
            -o-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        #loadingdots_3 {
            left: 60px;
            -moz-animation-delay: 0.4s;
            -webkit-animation-delay: 0.4s;
            -ms-animation-delay: 0.4s;
            -o-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        #loadingdots_4 {
            left: 90px;
            -moz-animation-delay: 0.6s;
            -webkit-animation-delay: 0.6s;
            -ms-animation-delay: 0.6s;
            -o-animation-delay: 0.6s;
            animation-delay: 0.6s;
        }

        #loadingdots_5 {
            left: 120px;
            -moz-animation-delay: 0.8s;
            -webkit-animation-delay: 0.8s;
            -ms-animation-delay: 0.8s;
            -o-animation-delay: 0.8s;
            animation-delay: 0.8s;
        }

        #loadingdots_6 {
            left: 150px;
            -moz-animation-delay: 1s;
            -webkit-animation-delay: 1s;
            -ms-animation-delay: 1s;
            -o-animation-delay: 1s;
            animation-delay: 1s;
        }

        #loadingdots_7 {
            left: 180px;
            -moz-animation-delay: 1.2s;
            -webkit-animation-delay: 1.2s;
            -ms-animation-delay: 1.2s;
            -o-animation-delay: 1.2s;
            animation-delay: 1.2s;
        }

        @-moz-keyframes bounce_loadingdots {
            0% {
                -moz-transform: scale(1);
                opacity: 0.5;
            }

            25% {
                -moz-transform: scale(1.5);
                opacity: 1;
            }

            50% {
                -moz-transform: scale(1);
                opacity: 0.5;
            }

            100% {
                -moz-transform: scale(1);
                opacity: 0.5;
            }
        }

        @-webkit-keyframes bounce_loadingdots {
            0% {
                -webkit-transform: scale(1);
                opacity: 0.5;
            }

            25% {
                -webkit-transform: scale(1.5);
                opacity: 1;
            }

            50% {
                -webkit-transform: scale(1);
                opacity: 0.5;
            }

            100% {
                -webkit-transform: scale(1);
                opacity: 0.5;
            }
        }

        @-ms-keyframes bounce_loadingdots {
            0% {
                -ms-transform: scale(1);
                opacity: 0.5;
            }

            25% {
                -ms-transform: scale(1.5);
                opacity: 1;
            }

            50% {
                -ms-transform: scale(1);
                opacity: 0.5;
            }

            100% {
                -ms-transform: scale(1);
                opacity: 0.5;
            }
        }

        @-o-keyframes bounce_loadingdots {
            0% {
                -o-transform: scale(1);
                opacity: 0.5;
            }

            25% {
                -o-transform: scale(1.5);
                opacity: 1;
            }

            50% {
                -o-transform: scale(1);
                opacity: 0.5;
            }

            100% {
                -o-transform: scale(1);
                opacity: 0.5;
            }
        }

        @keyframes bounce_loadingdots {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            25% {
                transform: scale(1.5);
                opacity: 1;
            }

            50% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 0.5;
            }
        }

        .loadingdots {
            -webkit-animation-duration: 1.5s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: bounce_loadingdots;
            -moz-animation-duration: 1.5s;
            -moz-animation-iteration-count: infinite;
            -moz-animation-name: bounce_loadingdots;
            animation-duration: 1.5s;
            animation-iteration-count: infinite;
            animation-name: bounce_loadingdots;
            background-color: #FF6C60;
            border-radius: 2px;
            position: absolute;
            top: 0;
            color: #fff;
            padding: 40px 5px;
            text-align: center;
            padding: 5px 5px;
        }

        #loadingmask2 {
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, 0.8);
            width: 100%;
            height: 100%;
            z-index: 99999;
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

                        <li class="nav-item">
                            <a href="{{ url('/wallet/all') }}" class="nav-link {{ Request::is('wallet/all') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i> Wallet Status
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/income-source/all') }}" class="nav-link {{ Request::is('income-source/all') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i> Income Status
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/expense-type/all') }}" class="nav-link {{ Request::is('expense-type/all') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i> Expense Status
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/budget/' . date('m') . '/' . date('Y') . '/list') }}" class="nav-link {{ Request::is('budget/**') ? 'active' : '' }}">
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

                        <h4 class="page-title text-center m-0">

                            <div class="btn-group" role="group">
                                <a href="{{ url('/transaction/add-income') }}" class="transaction-btn btn btn-light text-success" data-title="Add Income">
                                    <i class="fas fa-plus-circle"></i>
                                    <div class="d-none d-md-block ms-2">Add Income</div>
                                </a>
                                <a href="{{ url('/transaction/add-expense') }}" class="transaction-btn btn btn-light text-danger" data-title="Add Expense">
                                    <i class="fas fa-minus-circle"></i>
                                    <div class="d-none d-md-block ms-2">Add Expense</div>
                                </a>
                                <a href="{{ url('/transaction/do-transfer') }}" class="transaction-btn btn btn-light text-primary" data-title="Do Transfer">
                                    <i class="fas fa-retweet"></i>
                                    <div class="d-none d-md-block ms-2">Transfer</div>
                                </a>
                            </div>

                        </h4>

                    </div>
                </div>
                <!-- /page header -->

                <!-- Notification Message -->
                <div class="col-md-12 toast-msg-wrapper d-none" style="padding: 20px; padding-bottom: 0px;">
                    <div class="alert alert-dismissible fade show toast-msg" style="margin-bottom: 0px;">
                        <span class="fw-semibold toast-msg-status"></span> <span class="toast-msg-body"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>

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

    <!-- Transaction Modal -->
    <div class="modal fade" id="transaction-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title transaction-modal-title">Modal Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 transaction-form-wrapper">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ./Transaction Modal -->

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

    <script>
        $(document).ready(function() {

            $('body').on('click', '.transaction-btn', function(e) {
                e.preventDefault();

                var url = $(this).attr("href");
                var modalTitle = $(this).data('title');
                $('.transaction-modal-title').html(modalTitle);

                loadingMask2.show();
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        loadingMask2.hide();
                        $(".transaction-form-wrapper").html("");
                        $('#transaction-modal').modal('show');
                        $(".transaction-form-wrapper").append(data);
                    },
                    error: function(jqXHR, status, errorThrown) {
                        loadingMask2.hide();
                        showMessage("error", jqXHR.responseJSON.message);
                    },
                });
            });

            $('body').on('click', '.transaction-submit-btn', function(e) {
                e.preventDefault();

                var url = $('#transaction-form').attr('action');
                var data = $('#transaction-form').serializeArray();

                loadingMask2.show();
                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
                    },
                    data: data,
                    success: function(data) {
                        loadingMask2.hide();
                        showMessage(data.status, data.message, data.reload);
                        if (data.status == 'success') {
                            $(".transaction-form-wrapper").html("");
                            $('#transaction-modal').modal('hide');
                        }
                        if(data.reload == true){
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(jqXHR, status, errorThrown) {
                        loadingMask2.hide();
                        showMessage("error", jqXHR.responseJSON.message);
                    },
                });
            })
        })
    </script>
</body>

</html>
