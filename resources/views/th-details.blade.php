<x-layout pageTitle="Transaction Details">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <h5 class="text-center">Transaction Details</h5>
                <div class="transaction-detail-accordion">
                    @include('layouts.transactions.transaction-detail-accordion')
                </div>
            </div>

        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
