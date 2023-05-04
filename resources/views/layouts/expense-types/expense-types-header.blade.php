<div class="col-md-6 float-start text-start">
    <h5 class="mb-0">Total Expense : {{ $totalExpense }} TK</h5>
</div>

<div class="col-md-6 float-end text-end">
    <a href="{{ route('expense-type.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="Create expense type">
        <i class="fas fa-plus"></i>
        <div class="d-none d-md-block ms-1">Create expense type</div>
    </a>
</div>
