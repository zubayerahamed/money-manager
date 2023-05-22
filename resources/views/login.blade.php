<x-login-register-layout pageTitle="{{ __('login.page.title') }}">
    <!-- Login form -->
    <form class="login-form" action="{{ route('login') }}" method="POST">
        @csrf

        <div class="card mb-0">
            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
                    </div>

                    <h5 class="mb-0">{{ __('login.header.title') }}</h5>

                    @if (Session::has('error'))
                        <span class="d-block text-danger mt-2">{{ Session::get('error') }}</span>
                    @else
                        <span class="d-block text-muted">{{ __('login.header.des') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">{{ __('login.label.email') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        <div class="form-control-feedback-icon">
                            <i class="ph-at text-muted"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('login.label.password') }}</label>
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
                    <button type="submit" class="btn btn-primary w-100">{{ __('login.btn.sign-in') }}</button>
                </div>

                <div class="text-center">
                    {{ __('login.text.dont-have-account') }} <a href="{{ route('register') }}">{{ __('login.btn.register.here') }}</a>
                </div>
            </div>
        </div>
    </form>
    <!-- /login form -->
</x-login-register-layout>
