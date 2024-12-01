<form id="transaction-form" action="{{ $expenseType->id == null ? route('expense-type.store') : route('expense-type.update', $expenseType->id) }}" method="POST">
    @csrf
    @if ($expenseType->id != null)
        @method('PUT')
    @endif

    @if ($fromtransaction != null)
    <div class="row mb-3">
        <div class="col text-end">
            @if ($trnId != null && $trnId != '')
                <a  href="{{ route('tracking.edit', [$trnId]) }}" 
                    class="btn btn-primary btn-sm transaction-btn" 
                    data-title="Edit transaction" 
                    type="button">Back To Transaction</a>
            @else
            <a  href="{{ $fromtransaction == 'INCOME' ? route('add-income') : ($fromtransaction == 'EXPENSE' ? route('add-expense') : route('do-transfer')) }}" 
                class="btn btn-primary btn-sm transaction-btn" 
                data-title="{{ $fromtransaction == 'INCOME' ? 'Add Income' : ($fromtransaction == 'EXPENSE' ? 'Add Expense' : 'Do Transfer') }}" 
                type="button">Back To Transaction</a>
            @endif
        </div>
    </div>
    @endif

    <input type="hidden" name="fromtransaction" value="{{ $fromtransaction == null ? "" : $fromtransaction }}"/>
    <input type="hidden" name="trnId" value="{{ $trnId == null ? "" : $trnId }}"/>

    <i class="{{ $expenseType->id == null || $expenseType->icon == null ? 'fab fa-korvue' : $expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>

    <div class="row mb-3">
        <label class="form-label" for="icon">{{ __('expense-type.label.icon') }}</label>
        <div class="input-group">
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $expenseType->id == null || $expenseType->icon == null ? 'fab fa-korvue' : $expenseType->icon }}" readonly>
            <button class="btn btn-light" type="button" onclick="openIconModal()">Choose</button>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label" for="name">{{ __('expense-type.label.name') }}</label>
        <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" value="{{ $expenseType->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label" for="note">{{ __('expense-type.label.note') }}</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note" id="note">{{ $expenseType->note }}</textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="d-flex align-items-center">
            <input type="checkbox" id="active" name="active" {{ $expenseType->active ? 'checked' : '' }}>
            <label class="ms-2" for="active">Active?</label>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>

@include('icon-modal')
