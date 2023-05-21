<form id="transaction-form" action="{{ $budget->id == null ? route('budget.store') : route('budget.update', $budget->id) }}" method="POST">
    @csrf
    @if ($budget->id != null)
        @method('PUT')
    @endif

    @if ($budget->id == null)
        @if ($expenseType->icon)
            <i class="{{ $expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>
        @endif

        <div class="row mb-3">
            <label class="form-label" for="expense_type">{{ __('budget.label.expense_type') }}</label>
            <div class="form-group">
                <input type="hidden" name="expense_type" value="{{ $expenseType->id }}" />
                <input type="hidden" name="month" value="{{ $month }}" />
                <input type="hidden" name="year" value="{{ $year }}" />
                <input type="text" class="form-control" id="expense_type" value="{{ $expenseType->name }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label" for="amount">{{ __('budget.label.amount') }}</label>
            <div class="form-group">
                <input type="number" name="amount" id="amount" class="form-control" value="0.0" min="0" step="any" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label" for="note">{{ __('budget.label.note') }}</label>
            <div class="form-group">
                <textarea rows="3" cols="3" class="form-control" name="note" id="note"></textarea>
            </div>
        </div>
    @else
        @if ($budget->expenseType->icon)
            <i class="{{ $budget->expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>
        @endif

        <div class="row mb-3">
            <label class="form-label" for="expense_type">{{ __('budget.label.expense_type') }}</label>
            <div class="form-group">
                <input type="hidden" name="expense_type" value="{{ $budget->expense_type }}" />
                <input type="text" class="form-control" id="expense_type" value="{{ $budget->expenseType->name }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label" for="amount">{{ __('budget.label.amount') }}</label>
            <div class="form-group">
                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', $budget->amount) }}" min="0" step="any" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label" for="note">{{ __('budget.label.note') }}</label>
            <div class="form-group">
                <textarea rows="3" cols="3" class="form-control" name="note" id="note">{{ old('note', $budget->note) }}</textarea>
            </div>
        </div>
    @endif

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
