<form id="transaction-form" action="{{ $wallet->id == null ? route('wallet.store') : route('wallet.update', $wallet->id) }}" method="POST">
    @csrf
    @if ($wallet->id != null)
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
                <a  href="{{ $fromtransaction == 'INCOME' ? route('add-income') : ($fromtransaction == 'EXPENSE' ? route('add-expense') : ($fromtransaction == 'LOAN' ? route('get-loan') : route('do-transfer'))) }}" 
                    class="btn btn-primary btn-sm transaction-btn" 
                    data-title="{{ $fromtransaction == 'INCOME' ? 'Add Income' : ($fromtransaction == 'EXPENSE' ? 'Add Expense' : ($fromtransaction == 'LOAN' ? 'Get Loan' : 'Do Transfer')) }}" 
                    type="button">Back To Transaction</a>
            @endif
        </div>
    </div>
        
    @endif
    
    <input type="hidden" name="fromtransaction" value="{{ $fromtransaction == null ? "" : $fromtransaction }}"/>
    <input type="hidden" name="trnId" value="{{ $trnId == null ? "" : $trnId }}"/>

    <i class="{{ $wallet->id == null || $wallet->icon == null ? 'fab fa-korvue' : $wallet->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>

    <div class="row mb-3">
        <label class="form-label" for="icon">{{ __('wallet.label.icon') }}</label>
        <div class="input-group">
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $wallet->id == null || $wallet->icon == null ? 'fab fa-korvue' : $wallet->icon }}" readonly>
            <button class="btn btn-light" onclick="openIconModal()" type="button">Choose</button>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label" for="name">{{ __('wallet.label.name') }}</label>
        <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" value="{{ $wallet->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label" for="current_balance">{{ __('wallet.label.current_balance') }}</label>
        <div class="form-group">
            <input type="number" name="current_balance" id="current_balance" class="form-control" value="{{ $wallet->currentBalance == null ? 0 : $wallet->currentBalance }}" min="0" step="any" required {{ $wallet->id != null ? 'disabled' : '' }}>
        </div>
    </div>

    @if ($fromtransaction == null)
    <div class="mb-3">
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="excluded" name="excluded" {{ $wallet->excluded ? 'checked' : '' }}>
            <label class="form-check-label" for="excluded">Exclude balance from current balance</label>
        </div>
    </div>
    @endif

    <div class="row mb-3">
        <label class="form-label" for="note">{{ __('wallet.label.note') }}</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note" id="note">{{ $wallet->note }}</textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>

@include('icon-modal')
