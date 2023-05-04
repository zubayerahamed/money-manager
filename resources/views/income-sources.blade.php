<x-layout pageTitle="Income Sources Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
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
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
