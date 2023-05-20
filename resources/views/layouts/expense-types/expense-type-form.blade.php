<form id="transaction-form" action="{{ $expenseType->id == null ? route('expense-type.store') : route('expense-type.update', $expenseType->id) }}" method="POST">
    @csrf
    @if ($expenseType->id != null)
        @method('PUT')
    @endif

    <i class="{{ $expenseType->id == null || $expenseType->icon == null ? 'fab fa-korvue' : $expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>

    <div class="row mb-3">
        <label class="form-label">Icon:</label>
        <div class="input-group">
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $expenseType->id == null || $expenseType->icon == null ? 'fab fa-korvue' : $expenseType->icon }}" readonly>
            <button class="btn btn-light" type="button" onclick="openIconModal()">Choose</button>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Expense Type Name:</label>
        <div class="form-group">
            <input type="text" name="name" class="form-control" value="{{ $expenseType->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Note:</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note">{{ $expenseType->note }}</textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>

@include('icon-modal')
