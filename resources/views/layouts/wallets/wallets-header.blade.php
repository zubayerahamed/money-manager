<div class="d-flex justify-content-between align-itmes-center">
    <div class="col-md-6 float-start text-start">
        <h5 class="mb-0">Current Balance : {{ $totalBalance == null ? 0 : $totalBalance }} {{ auth()->user()->currency }}</h5>
        <h5 class="mb-0 text-warning">Excluded Balance : {{ $totalBalanceEx == null ? 0 : $totalBalanceEx }} {{ auth()->user()->currency }}</h5>
    </div>

    <div class="col-md-6 float-end text-end d-flex align-itmes-center justify-content-end">
        <a href="{{ route('wallet.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="{{ __('wallet.btn.create-wallet') }}">
            <i class="ph-plus"></i>
            <div class="d-none d-md-block ms-1">{{ __('wallet.btn.create-wallet') }}</div>
        </a>
    </div>
</div>
