<x-setup-layout pageTitle="{{ __('setup.page.welcome.title') }}">
    <div class="card-body">
        <h6 class="text-center">{{ __('setup.page.heading.welcome') }}</h6>

        <ol>
            <li>{{ __('setup.text.all-requirements-ok') }}</li>
            <li>{{ __('setup.text.connection-db-ok') }}</li>
        </ol>
    </div>

    <div class="card-footer">
        <a href="{{ route('setup.requirements') }}" class="btn btn-sm btn-success float-end">{{ __('setup.btn.next') }}<i class="ph-arrow-fat-lines-right ms-2"></i></a>
    </div>
</x-setup-layout>
