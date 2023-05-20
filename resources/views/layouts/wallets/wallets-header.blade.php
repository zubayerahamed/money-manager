<div class="col-md-6 float-start text-start">
    <h5 class="mb-0">Balance : {{ $totalBalance == null ? 0 : $totalBalance }} {{ auth()->user()->currency }}</h5>
</div>

<div class="col-md-6 float-end text-end">
    <a href="{{ route('wallet.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="Create wallet">
        <i class="ph-plus"></i>
        <div class="d-none d-md-block ms-1">Create wallet</div>
    </a>
</div>
