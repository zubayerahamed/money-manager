<x-layout pageTitle="Expense Types Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header">
                        <div class="text-center col-md-12">
                            <h3 class="mb-0">Budget Details</h3>
                            <h4 class="mb-0"><a href="{{ route('budget.index', [$month, $year - 1]) }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $year }} <a href="{{ route('budget.index', [$month, $year + 1]) }}"><i class="fas fa-arrow-alt-circle-right"></i></a></h4>
                            <h4 class="mb-0"><a href="{{ route('budget.index', [$month == 1 ? $month : $month - 1, $year]) }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $monthText }} <a href="{{ route('budget.index', [$month == 12 ? $month : $month + 1, $year]) }}"><i class="fas fa-arrow-alt-circle-right"></i></a></h4>
                        </div>
                    </div>

                    <div class="card-body budgets-body">
                        @include('layouts.budgets.budgets-body')
                    </div>

                    <div class="accordion accordion-flush budgets-accordion" id="accordion_flush">
                        @include('layouts.budgets.budgets-accordion')
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
