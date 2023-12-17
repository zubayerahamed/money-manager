<x-layout pageTitle="{{ __('wallet.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <input type="hidden" id="sections-reloader" value="{{ route('wallet.sections') }}">

                <!-- Wallet Section -->
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
                <!-- ./Wallet Section -->
            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
