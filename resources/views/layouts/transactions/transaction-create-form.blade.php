<form id="transaction-form" action="{{ url('/transaction') }}" method="POST">
    @csrf

    <input type="hidden" name="transaction_type" value="{{ $transaction_type }}" />

    <div class="row">

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label" for="amount">{{ __('transaction.label.amount') }}</label>
                <div class="form-group">
                    <input type="number" name="amount" id="amount" class="form-control" value="0.0" min="0" step="any" required>
                </div>
            </div>
        </div>

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label" for="transaction_charge">{{ __('transaction.label.charge') }}</label>
                <div class="form-group">
                    <input type="number" name="transaction_charge" id="transaction_charge" class="form-control" value="0.0" min="0" step="any">
                </div>
            </div>
        </div>

    </div>

    @if ($transaction_type == 'EXPENSE' || $transaction_type == 'TRANSFER')
        <div class="row mb-3">
            <label class="form-label" for="from_wallet">{{ __('transaction.label.from_wallet') }}</label>
            <div class="input-group">
                <select class="form-control" name="from_wallet" id="from_wallet" required>
                    <option value="">-- Select Wallet --</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('wallet.create') }}" class="btn btn-light transaction-btn" data-title="{{ __('wallet.btn.create-wallet') }}" title="{{ __('wallet.btn.create-wallet') }}" type="button"><i class="fas fa-plus"></i></a>
            </div>
        </div>

        @if ($transaction_type == 'EXPENSE')
            <div class="row mb-3">
                <label class="form-label" for="expense_type">{{ __('transaction.label.expense_type') }}</label>
                <div class="input-group">
                    <select class="form-control" name="expense_type" id="expense_type" required>
                        <option value="">-- Select Expense Type --</option>
                        @foreach ($expenseTypes as $expenseType)
                            <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('expense-type.create') }}" class="btn btn-light transaction-btn" data-title="{{ __('expense-type.btn.create-expense-type') }}" title="{{ __('expense-type.btn.create-expense-type') }}" type="button"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        @endif
    @endif

    @if ($transaction_type == 'INCOME' || $transaction_type == 'TRANSFER')
        <div class="row mb-3">
            <label class="form-label" for="to_wallet">{{ __('transaction.label.to_wallet') }}</label>
            <div class="input-group">
                <select class="form-control" name="to_wallet" id="to_wallet" required>
                    <option value="">-- Select Wallet --</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('wallet.create') }}" class="btn btn-light transaction-btn" data-title="{{ __('wallet.btn.create-wallet') }}" title="{{ __('wallet.btn.create-wallet') }}" type="button"><i class="fas fa-plus"></i></a>
            </div>
        </div>

        @if ($transaction_type == 'INCOME')
            <div class="row mb-3">
                <label class="form-label" for="income_source">{{ __('transaction.label.income_source') }}</label>
                <div class="input-group">
                    <select class="form-control" name="income_source" id="income_source" required>
                        <option value="">-- Select Income Source --</option>
                        @foreach ($incomeSources as $incomeSource)
                            <option value="{{ $incomeSource->id }}">{{ $incomeSource->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('income-source.create') }}" class="btn btn-light transaction-btn" data-title="{{ __('income-source.btn.create-income-source') }}" title="{{ __('income-source.btn.create-income-source') }}" type="button"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        @endif
    @endif

    <div class="row">

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label" for="transaction_date">{{ __('transaction.label.transaction_date') }}</label>
                <div class="form-group">
                    <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label" for="transaction_tile">{{ __('transaction.label.transaction_time') }}</label>
                <div class="form-group">
                    <input type="time" name="transaction_time" id="transaction_time" class="form-control" value="{{ date('H:i') }}" required>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3">
        <label class="form-label" for="note">{{ __('transaction.label.note') }}</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note" id="note"></textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
