<x-layout pageTitle="{{ __('budget.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">

                <!-- Budget Section -->
                <div class="card">

                    <div class="card-header">
                        <div class="text-center col-md-12">
                            <h3 class="mb-0">{{ __('budget.header.budget') }}</h3>
                            <h4 class="mb-0">
                                <a href="{{ route('budget.index', [$month, $year - 1]) }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $year }}
                                <a href="{{ route('budget.index', [$month, $year + 1]) }}"><i class="fas fa-arrow-alt-circle-right"></i></a>
                            </h4>
                            <h4 class="mb-0">
                                <a href="{{ route('budget.index', [$month == 1 ? $month : $month - 1, $year]) }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $monthText }}
                                <a href="{{ route('budget.index', [$month == 12 ? $month : $month + 1, $year]) }}"><i class="fas fa-arrow-alt-circle-right"></i></a>
                            </h4>
                        </div>
                    </div>

                    <div class="budgets-accordion">
                        @include('layouts.budgets.budgets-accordion')
                    </div>

                </div>
                <!-- ./Budget Section -->

            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
