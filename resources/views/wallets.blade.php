<x-layout pageTitle="Wallets Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header wallets-header">
                        @include('layouts.wallets.wallets-header')
                    </div>

                    <div class="card-body wallets-pie-chart">
                        @include('layouts.wallets.wallets-pie-chart')
                    </div>

                    <div class="accordion accordion-flush wallets-accordion" id="accordion_flush">
                        @include('layouts.wallets.wallets-accordion')
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
