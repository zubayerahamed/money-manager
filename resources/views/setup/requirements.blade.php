<x-setup-layout pageTitle="{{ __('setup.page.requirements.title') }}">
    <div class="card-body">
        <h6 class="text-center">{{ __('setup.page.heading.requirements') }}</h6>

        <div class="list-group">
            @foreach ($results as $key => $successful)
                <div class="list-group-item d-flex align-items-center">
                    <b>{{ $key }}</b>
                    @if ($successful)
                        <i class="ph-thumbs-up text-success ms-auto"></i>
                    @else
                        <i class="ph-thumbs-down text-danger ms-auto"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('setup.welcome') }}" class="btn btn-sm btn-light"><i class="ph-arrow-fat-lines-left me-2"></i> {{ __('setup.btn.previous') }}</a>
        <a href="{{ route('setup.database') }}" class="btn btn-sm {{ $success ? 'btn-success' : ' btn-danger disabled' }} float-end">{{ __('setup.btn.next') }} <i class="ph-arrow-fat-lines-right ms-2"></i></a>
    </div>
</x-setup-layout>
