<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration - Money Manager</title>

    <!-- Global stylesheets -->
    <link href="/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/assets/js/app.js"></script>
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
                <div class="content d-flex justify-content-center align-items-center">
                    <!-- Registration form -->
                    <form class="login-form" action="{{ url('/register') }}" method="POST">
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                        <img src="/assets/images/logo_icon.svg" class="h-48px" alt="">
                                    </div>
                                    <h5 class="mb-0">Create account</h5>
                                </div>
                                <div class="text-center text-muted content-divider mb-3">
                                    <span class="px-2">Your Details</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                    @error('name')
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Your email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-at text-muted"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password" class="form-control">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="password" name="password_confirmation" class="form-control">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-teal w-100">Register</button>
                                </div>
                                <div class="text-center">
                                    Already have an account? <a href="{{ url('/login') }}">Login here</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /registration form -->
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
