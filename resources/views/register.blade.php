<x-login-register-layout pageTitle="{{ __('register.page.title') }}">
    <!-- Registration form -->
    <form class="login-form" action="{{ route('register') }}" method="POST">
        @csrf

        <div class="card mb-0">
            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
                    </div>
                    <h5 class="mb-0">{{ __('register.header.title') }}</h5>
                </div>

                <div class="text-center text-muted content-divider mb-3">
                    <span class="px-2">{{ __('register.header.des') }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('register.label.name') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        <div class="form-control-feedback-icon">
                            <i class="ph-user-circle text-muted"></i>
                        </div>
                    </div>
                    @error('name')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">{{ __('register.label.email') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        <div class="form-control-feedback-icon">
                            <i class="ph-at text-muted"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('register.label.password') }}</label>
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
                    <button type="submit" class="btn btn-teal w-100">{{ __('register.btn.register') }}</button>
                </div>

                <div class="text-center">
                    {{ __('register.text.already-have-account') }} <a href="{{ route('login') }}">{{ __('register.btn.login.here') }}</a>
                </div>

            </div>
        </div>
    </form>
    <!-- /registration form -->
</x-login-register-layout>
