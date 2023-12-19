<x-layout pageTitle="{{ __('transaction.details.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">

            <!-- Transaction Details -->
            <div class="col-xl-12">
                <input type="hidden" id="sections-reloader" value="{{ route('tracking.sections') }}" data-defined-route="{{ $sectionReloadRoute }}">

                @if ($displayType == 'yearWiseSummary')
                    <h5 class="text-center">Year wise transactions summary</h5>
                @else
                    <h5 class="text-center">{{ __('transaction.details.page.title') }}</h5>
                @endif
               
                <div class="transaction-detail-accordion">
                    @if ($displayType == 'yearWiseSummary')
                        @include('layouts.transactions.transaction-detail-yearwise-summary-accordion')
                    @else
                        @include('layouts.transactions.transaction-detail-accordion')
                    @endif
                </div>
            </div>
            <!-- ./Transaction Details -->

        </div>
    </div>
    <!-- ./Content -->
</x-layout>
