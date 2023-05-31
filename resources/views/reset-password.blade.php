<x-login-register-layout pageTitle="Reset password">
    <!-- Login form -->
    <form class="login-form" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="card mb-0">
            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-2 mt-2">
                        <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
                    </div>

                    <h5 class="mb-2">Reset your account password</h5>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">{{ __('login.label.email') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $email) }}" readonly>
                        <div class="form-control-feedback-icon">
                            <i class="ph-at text-muted"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">New password</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="form-control-feedback-icon">
                            <i class="ph-lock text-muted"></i>
                        </div>
                    </div>
                    @error('password')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">{{ __('register.label.password_confirmation') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        <div class="form-control-feedback-icon">
                            <i class="ph-lock text-muted"></i>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Reset password</button>
                </div>
            </div>
        </div>
    </form>
    <!-- /login form -->
</x-login-register-layout>
