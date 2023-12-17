<x-layout pageTitle="{{ __('income-source.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <input type="hidden" id="sections-reloader" value="{{ route('income-source.sections') }}">

                <!-- Income Source Section -->
                <div class="card">

                    <div class="card-header income-sources-header">
                        @include('layouts.income-sources.income-sources-header')
                    </div>

                    <div class="card-body income-sources-pie-chart">
                        @include('layouts.income-sources.income-sources-pie-chart')
                    </div>

                    <div class="accordion accordion-flush income-sources-accordion" id="accordion_flush">
                        @include('layouts.income-sources.income-sources-accordion')
                    </div>

                </div>
                <!-- ./Income Source Section -->

            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
