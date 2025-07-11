<div class="d-flex justify-content-between align-items-center">
    <div class="col-md-6 text-start">
        <h5 class="mb-0">{{ __('income-source.header.income') }} : {{ $totalIncome == null ? 0 : $totalIncome }} {{ auth()->user()->currency }}</h5>
        <h5 class="mb-0">Loan : <span class="text-warning">{{ $totalLoan == null ? 0 : $totalLoan }} {{ auth()->user()->currency }}</span></h5>
    </div>
    
    <div class="col-md-6 text-end">
        <a href="{{ route('income-source.create') }}" class="btn btn-success btn-sm transaction-btn" title="{{ __('income-source.btn.create-income-source') }}" data-title="{{ __('income-source.btn.create-income-source') }}">
            <i class="ph-plus"></i>
            <div class="d-none d-md-block ms-1">{{ __('income-source.btn.create-income-source') }}</div>
        </a>
    </div>
</div>