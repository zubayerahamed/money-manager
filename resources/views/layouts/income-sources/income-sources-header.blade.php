<div class="col-md-6 float-start text-start">
    <h5 class="mb-0">Total Income : {{ $totalIncome }} TK</h5>
</div>

<div class="col-md-6 float-end text-end">
    <a href="{{ route('income-source.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="Add income source">
        <i class="fas fa-plus"></i>
        <div class="d-none d-md-block ms-1">Add income source</div>
    </a>
</div>