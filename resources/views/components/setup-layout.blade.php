<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        @isset($pageTitle)
            Setup | {{ $pageTitle }}
        @else
            Setup
        @endisset
    </title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/favicon-32x32.png') }}">

    <!-- Global stylesheets -->
    <link href="{{ asset('/assets/fonts/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/fonts/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <link href="{{ asset('/assets/css/kit-bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-components.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-layout.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/noty.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('/assets/js/kit.js') }}"></script>
    <script src="{{ asset('/assets/js/kit-custom.js') }}"></script>
    <!-- /theme JS files -->
</head>

<body>
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">
                <!-- Content area -->
                <div class="content d-flex justify-content-center">
                    <!-- Login form -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="d-inline-flex align-items-center justify-content-center mb-0 mt-0">
                                    <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
                                </div>
                                <h6 class="mb-0">{{ __('setup.install.wizard.title') }}</h6>
                            </div>

                            {{ $slot }}

                        </div>
                    </div>
                    <!-- /login form -->
                </div>
                <!-- /content area -->
            </div>
            <!-- /inner content -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>
