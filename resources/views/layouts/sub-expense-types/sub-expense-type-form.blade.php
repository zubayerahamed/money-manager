<form id="transaction-form" action="{{ $subExpenseType->id == null ? route('sub-expense-type.store', ['expense_type_id' => $subExpenseType->expense_type_id]) : route('sub-expense-type.update', ['expense_type_id' => $subExpenseType->expense_type_id, 'id' => $subExpenseType->id]) }}" method="POST">
    @csrf
    @if ($subExpenseType->id != null)
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label class="form-label" for="name">Name</label>
        <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" value="{{ $subExpenseType->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="d-flex align-items-center">
            <input type="checkbox" id="active" name="active" {{ $subExpenseType->active ? 'checked' : '' }}>
            <label class="ms-2" for="active">Active?</label>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
