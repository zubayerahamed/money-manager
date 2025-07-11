<x-login-register-layout pageTitle="{{ __('password.forgot.page.title') }}">
    <!-- Login form -->
    <form class="login-form" action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="card mb-0">
            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-2 mt-2">
                        <img src="{{ asset('/assets/images/money-manager-logo.png') }}" class="h-48px" alt="">
                    </div>

                    <h5 class="mb-2">{{ __('password.forgot.page.header') }}</h5>

                    <span class="d-block text-muted">{{ __('password.forgot.page.desc') }}</span>

                    @if (Session::has('status'))
                        <span class="d-block text-success mt-2">{{ Session::get('status') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="form-control-feedback form-control-feedback-start">
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="test@example.com">
                        <div class="form-control-feedback-icon">
                            <i class="ph-at text-muted"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">{{ __('password.forgot.btn.submit') }}</button>
                </div>

            </div>
        </div>
    </form>
    <!-- /login form -->
</x-login-register-layout>
