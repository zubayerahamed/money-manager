<div class="col-md-6 float-start text-start">
    <h5 class="mb-0">{{ __('expense-type.header.expense') }} : {{ $totalExpense == null ? 0 : $totalExpense }} {{ auth()->user()->currency }}</h5>
</div>

<div class="col-md-6 float-end text-end">
    <a href="{{ route('expense-type.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="{{ __('expense-type.btn.create-expense-type') }}">
        <i class="ph-plus"></i>
        <div class="d-none d-md-block ms-1">{{ __('expense-type.btn.create-expense-type') }}</div>
    </a>
</div>
