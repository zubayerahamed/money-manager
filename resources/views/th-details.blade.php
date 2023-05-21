<x-layout pageTitle="{{ __('transaction.details.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">

            <!-- Transaction Details -->
            <div class="col-xl-12">
                <h5 class="text-center">{{ __('transaction.details.page.title') }}</h5>
                <div class="transaction-detail-accordion">
                    @include('layouts.transactions.transaction-detail-accordion')
                </div>
            </div>
            <!-- ./Transaction Details -->

        </div>
    </div>
    <!-- ./Content -->
</x-layout>
