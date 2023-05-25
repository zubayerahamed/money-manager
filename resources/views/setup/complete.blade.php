<x-setup-layout pageTitle="{{ __('setup.page.complete.title') }}">
    <div class="card-body">
        <h1 class="text-center">{{ __('setup.text.setup.complete') }}</h1>
    </div>

    <div class="card-footer">
        <a href="{{ route('login') }}" class="btn btn-sm btn-light">{{ __('setup.btn.login') }}</a>
    </div>
</x-setup-layout>
