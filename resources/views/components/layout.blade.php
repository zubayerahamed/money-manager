<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/favicon-32x32.png') }}">

    <title>
        @isset($pageTitle)
            {{ $pageTitle }}
        @else
            Money Manager
        @endisset
    </title>

    <!-- Global stylesheets -->
    <link href="{{ asset('/assets/fonts/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/material/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/cropper.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/bootstrap-iconpicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" />
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('/assets/js/cropper.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/echarts.min.js') }}"></script>
    <script src="{{ asset('/assets/js/d3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/d3_tooltip.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>

    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <!-- /theme JS files -->
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

            <div class="navbar-brand flex-1 flex-lg-0 justify-content-center justify-content-md-start">
                <a href="{{ route('home') }}"><img src="{{ asset('/assets/images/money-manager-logo-light.png') }}" class="h-40px me-2" alt=""></a>
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center d-none d-md-block" style="text-decoration: none;">
                    <h1 class="m-0" style="color: #fff;">Money Manager</h1>
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
                <div class="sidebar-section d-block d-lg-none">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <div>
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
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') || Request::is('transaction/**') ? 'active' : '' }}">
                                <i class="ph-house"></i>
                                <span>
                                    Home
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('wallet.index') }}" class="nav-link {{ Request::is('wallet/all') ? 'active' : '' }}">
                                <i class="ph-wallet"></i> <span>Wallet Status</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('income-source.index') }}" class="nav-link {{ Request::is('income-source/all') ? 'active' : '' }}">
                                <i class="ph-chart-line-up"></i> <span>Income Status</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('expense-type.index') }}" class="nav-link {{ Request::is('expense-type/all') ? 'active' : '' }}">
                                <i class="ph-chart-bar-horizontal"></i> <span>Expense Status</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('budget.index', [date('m'), date('Y')]) }}" class="nav-link {{ Request::is('budget/**') ? 'active' : '' }}">
                                <i class="ph-calculator"></i>
                                <span>
                                    Budget - {{ date('M, Y') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/tracking/details/today') }}" class="nav-link {{ Request::is('/tracking/details/today') ? 'active' : '' }}">
                                <i class="ph-calendar-check"></i>
                                <span>
                                    Today's History
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dream.index') }}" class="nav-link {{ Request::is('/dream/**') ? 'active' : '' }}">
                                <i class="ph-cloud-moon"></i>
                                <span>
                                    Dreams
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
                                    <i class="fas fa-exchange-alt"></i>
                                    <div class="d-none d-md-block ms-2">Transfer</div>
                                </a>
                                <a href="#" class="btn btn-light text-warning" onclick="location.reload()" title="Reload Page">
                                    <i class="fas fa-sync-alt"></i>
                                    <div class="d-none d-md-block ms-2">Reload Page</div>
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
                    <div class="container-fluid justify-content-center">
                        Copyright <span>&copy; {{ date('Y') }} <a href="https://www.karigorit.com" target="_blank">Karigor IT</a></span>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title transaction-modal-title">Modal Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 transaction-form-wrapper"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ./Transaction Modal -->

    <!-- Image Cropper Modal -->
    <div id="avatar-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop & Resize your avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

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

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger crop-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
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

    <script>
        $('body').on('click', '.avatar-upload', function(e) {
            e.preventDefault();
            $(this).siblings(".avatar-image:hidden").trigger('click');
            submitUrl = $(this).attr('href');
        });

        var $modal = $('#avatar-modal');
        var image = document.getElementById('image');
        var cropper;
        var submitUrl;

        $("body").on("change", ".avatar-image", function(e) {

            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        // Init cropper js when modal show and destroy cropper js when modal hide
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });


        $('.crop-cancel').off('click').on('click', function() {
            $modal.modal('hide');
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);

                reader.onloadend = function() {
                    var base64data = reader.result;
                    loadingMask2.show();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: submitUrl,
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data
                        },
                        success: function(data) {
                            loadingMask2.hide();
                            showMessage(data.status, data.message, data.reload);
                            if (data.status == 'success') {
                                $modal.modal('hide');
                            }
                            if (data.reload == true) {
                                if (data.sections.length > 0) {
                                    $.each(data.sections, function(ind, section) {
                                        sectionReloadAjaxReq(section);
                                    });
                                } else {
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        },
                        error: function(jqXHR, status, errorThrown) {
                            loadingMask2.hide();
                            showMessage("error", jqXHR.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
