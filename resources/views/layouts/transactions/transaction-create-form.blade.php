<form id="transaction-form" action="{{ url('/transaction') }}" method="POST">
    @csrf

    <input type="hidden" name="transaction_type" value="{{ $transaction_type }}" />

    <div class="row">

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label">Amount:</label>
                <div class="form-group">
                    <input type="number" name="amount" class="form-control" value="0.0" min="0" step="any" required>
                </div>
            </div>
        </div>

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label">Charge:</label>
                <div class="form-group">
                    <input type="number" name="transaction_charge" class="form-control" value="0.0" min="0" step="any">
                </div>
            </div>
        </div>

    </div>

    @if ($transaction_type == 'EXPENSE' || $transaction_type == 'TRANSFER')
        <div class="row mb-3">
            <label class="form-label">From Wallet:</label>
            <div class="input-group">
                <select class="form-control" name="from_wallet" required>
                    <option value="">-- Select Wallet --</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('wallet.create') }}" class="btn btn-light transaction-btn" data-title="Add wallet" type="button"><i class="fas fa-plus"></i></a>
            </div>
        </div>

        @if ($transaction_type == 'EXPENSE')
            <div class="row mb-3">
                <label class="form-label">Expense Type:</label>
                <div class="input-group">
                    <select class="form-control" name="expense_type" required>
                        <option value="">-- Select Expense Type --</option>
                        @foreach ($expenseTypes as $expenseType)
                            <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('expense-type.create') }}" class="btn btn-light transaction-btn" data-title="Create expense type" type="button"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        @endif
    @endif

    @if ($transaction_type == 'INCOME' || $transaction_type == 'TRANSFER')
        <div class="row mb-3">
            <label class="form-label">To Wallet:</label>
            <div class="input-group">
                <select class="form-control" name="to_wallet" required>
                    <option value="">-- Select Wallet --</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('wallet.create') }}" class="btn btn-light transaction-btn" data-title="Add wallet" type="button"><i class="fas fa-plus"></i></a>
            </div>
        </div>

        @if ($transaction_type == 'INCOME')
            <div class="row mb-3">
                <label class="form-label">Income Source:</label>
                <div class="input-group">
                    <select class="form-control" name="income_source" required>
                        <option value="">-- Select Income Source --</option>
                        @foreach ($incomeSources as $incomeSource)
                            <option value="{{ $incomeSource->id }}">{{ $incomeSource->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('income-source.create') }}" class="btn btn-light transaction-btn" data-title="Create income source" type="button"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        @endif
    @endif

    <div class="row">

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label">Date:</label>
                <div class="form-group">
                    <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>

        <div class="col sm-6">
            <div class="row mb-3">
                <label class="form-label">Time:</label>
                <div class="form-group">
                    <input type="time" name="transaction_time" class="form-control" value="{{ date('H:i') }}" required>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3">
        <label class="form-label">Note:</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note"></textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
