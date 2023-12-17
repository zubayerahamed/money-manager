<x-layout pageTitle="{{ __('expense-type.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <input type="hidden" id="sections-reloader" value="{{ route('expense-type.sections') }}">

                <!-- Expense Type Section -->
                <div class="card">

                    <div class="card-header expense-types-header">
                        @include('layouts.expense-types.expense-types-header')
                    </div>

                    <div class="card-body expense-types-pie-chart">
                        @include('layouts.expense-types.expense-types-pie-chart')
                    </div>

                    <div class="accordion accordion-flush expense-types-accordion" id="accordion_flush">
                        @include('layouts.expense-types.expense-types-accordion')
                    </div>

                </div>
                <!-- ./Expense Type Section -->

            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
