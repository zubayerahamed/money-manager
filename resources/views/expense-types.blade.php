<x-layout pageTitle="Expense Types Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
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
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
