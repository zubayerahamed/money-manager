<x-layout pageTitle="{{ __('home.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <input type="hidden" id="sections-reloader" value="{{ route('home.sections') }}">

                <!-- Dashboard -->
                <div class="card">
                    <div class="dashboard-content-section">
                        @include('layouts.dashboard.dashboard-chart')
                    </div>
                </div>
                <!-- ./Dashboard -->

            </div>
        </div>
    </div>
    <!-- ./Content -->

</x-layout>
