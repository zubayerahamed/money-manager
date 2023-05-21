<x-layout pageTitle="{{ __('dream.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">

                <!-- Dreams Section -->
                <div class="card">

                    <div class="card-header">
                        <div class="col-md-6 float-start text-start">
                            <h5 class="mb-0">{{ __('dream.header.dreams') }}</h5>
                        </div>

                        <div class="col-md-6 float-end text-end">
                            <a href="{{ route('dream.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="{{ __('dream.btn.create-dream') }}" title="{{ __('dream.btn.create-dream') }}">
                                <i class="ph-plus"></i>
                                <div class="d-none d-md-block ms-1">{{ __('dream.btn.create-dream') }}</div>
                            </a>
                        </div>
                    </div>

                    <div class="accordion accordion-flush dreams-accordion" id="accordion_flush">
                        @include('layouts.dreams.dreams-accordion')
                    </div>

                </div>
                <!-- ./Dreams Section -->

            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
