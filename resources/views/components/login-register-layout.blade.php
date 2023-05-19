<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        @isset($pageTitle)
            MM | {{ $pageTitle }}
        @else
            Money Manager
        @endisset
    </title>

    <!-- Stylesheets -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/favicon-32x32.png') }}">

    <!-- Global stylesheets -->
    <link href="{{ asset('/assets/fonts/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <link href="{{ asset('/assets/css/kit-bootstrap.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-components.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/kit-layout.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- ./Stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->
</head>

<body>
    <!-- Content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">
                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    {{ $slot }}

                </div>
                <!-- ./Content area -->
            </div>
            <!-- ./Inner content -->
        </div>
        <!-- ./Main content -->
    </div>
    <!-- ./Content -->
</body>

</html>
