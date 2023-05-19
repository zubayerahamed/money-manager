<x-login-register-layout pageTitle="Register">
    <!-- Registration form -->
    <form class="login-form" action="{{ route('register') }}" method="POST">
        @csrf

        <div class="card mb-0">
            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
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
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </div>

            </div>
        </div>
    </form>
    <!-- /registration form -->
</x-login-register-layout>
