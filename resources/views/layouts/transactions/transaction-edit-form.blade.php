<form id="transaction-form" action="{{ route('tracking.update', $trackingHistory->id) }}" method="POST">
    @method('PUT')
    @csrf

    <input type="hidden" id="tracking_history_id" value="{{ $trackingHistory->id }}"/>
    <input type="hidden" name="transaction_type" value="{{ $transaction_type }}" />

    <div class="row">
        <div class="col-md-12 main-trn-form-container">
            <div class="row">

                <div class="col sm-6">
                    <div class="row mb-3">
                        <label class="form-label" for="amount">{{ __('transaction.label.amount') }}</label>
                        <div class="form-group">
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ $trackingHistory->amount }}" min="0" step="any" required>
                        </div>
                    </div>
                </div>

                <div class="col sm-6">
                    <div class="row mb-3">
                        <label class="form-label" for="transaction_charge">{{ __('transaction.label.charge') }}</label>
                        <div class="form-group">
                            <input type="number" name="transaction_charge" id="transaction_charge" class="form-control" value="{{ $trackingHistory->transaction_charge }}" min="0" step="any">
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
                                <option value="{{ $wallet->id }}" {{ $trackingHistory->from_wallet == $wallet->id ? 'selected' : '' }}>{{ $wallet->name }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('wallet.create') . '?fromtransaction=' . $transaction_type . '&trnid=' . $trackingHistory->id }}" class="btn btn-light transaction-btn" data-title="{{ __('wallet.btn.create-wallet') }}" title="{{ __('wallet.btn.create-wallet') }}" type="button"><i class="fas fa-plus"></i></a>
                    </div>
                </div>

                @if ($transaction_type == 'EXPENSE')
                    <div class="row mb-3">
                        <label class="form-label" for="expense_type">{{ __('transaction.label.expense_type') }}</label>
                        <div class="input-group">
                            <select class="form-control" name="expense_type" id="expense_type" required>
                                <option value="">-- Select Expense Type --</option>
                                @foreach ($expenseTypes as $expenseType)
                                    <option class="{{ $expenseType->active ? '' : 'text-danger' }}" value="{{ $expenseType->id }}" {{ $trackingHistory->expense_type == $expenseType->id ? 'selected' : '' }}>
                                        {{ $expenseType->name }}
                                    </option>
                                @endforeach
                            </select>
                            <a href="{{ route('expense-type.create') . '?fromtransaction=' . $transaction_type . '&trnid=' . $trackingHistory->id }}" class="btn btn-light transaction-btn" data-title="{{ __('expense-type.btn.create-expense-type') }}" title="{{ __('expense-type.btn.create-expense-type') }}" type="button"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                @endif
            @endif

            @if ($transaction_type == 'INCOME' || $transaction_type == 'TRANSFER' || $transaction_type == 'LOAN')
                <div class="row mb-3">
                    <label class="form-label" for="to_wallet">{{ __('transaction.label.to_wallet') }}</label>
                    <div class="input-group">
                        <select class="form-control" name="to_wallet" id="to_wallet" required>
                            <option value="">-- Select Wallet --</option>
                            @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ $trackingHistory->to_wallet == $wallet->id ? 'selected' : '' }}>{{ $wallet->name }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('wallet.create') . '?fromtransaction=' . $transaction_type . '&trnid=' . $trackingHistory->id }}" class="btn btn-light transaction-btn" data-title="{{ __('wallet.btn.create-wallet') }}" title="{{ __('wallet.btn.create-wallet') }}" type="button"><i class="fas fa-plus"></i></a>
                    </div>
                </div>

                @if ($transaction_type == 'INCOME' || $transaction_type == 'LOAN')
                    <div class="row mb-3">
                        <label class="form-label" for="income_source">{{ __('transaction.label.income_source') }}</label>
                        <div class="input-group">
                            <select class="form-control" name="income_source" id="income_source" required>
                                <option value="">-- Select Income Source --</option>
                                @foreach ($incomeSources as $incomeSource)
                                    <option value="{{ $incomeSource->id }}" {{ $trackingHistory->income_source == $incomeSource->id ? 'selected' : '' }}>{{ $incomeSource->name }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('income-source.create') . '?fromtransaction=' . $transaction_type . '&trnid=' . $trackingHistory->id }}" class="btn btn-light transaction-btn" data-title="{{ __('income-source.btn.create-income-source') }}" title="{{ __('income-source.btn.create-income-source') }}" type="button"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                @endif
            @endif

            <div class="row">

                <div class="col sm-6">
                    <div class="row mb-3">
                        <label class="form-label" for="transaction_date">{{ __('transaction.label.transaction_date') }}</label>
                        <div class="input-group">
                            <input type="text"
                                   name="transaction_date"
                                   id="transaction_date"
                                   class="form-control datepicker-date-format"
                                   placeholder="yyyy-mm-dd format"
                                   required="required"
                                   value="{{ $trackingHistory->transaction_date }}" maxDate="{{ date('Y-m-d') }}">
                            <span class="input-group-text">
                                <i class="ph-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col sm-6">
                    <div class="row mb-3">
                        <label class="form-label" for="transaction_tile">{{ __('transaction.label.transaction_time') }}</label>
                        <div class="input-group time date-time-wrapper timepicker">
                            <input class="form-control"
                                   data-type="timepicker"
                                   id="transaction_time"
                                   name="transaction_time"
                                   required="required"
                                   value="{{ $trackingHistory->transaction_time }}" />
                            <span class="input-group-text input-group-append input-group-addon">
                                <i class="fa fa-clock"></i>
                            </span>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row mb-3">
                <label class="form-label" for="note">{{ __('transaction.label.note') }}</label>
                <div class="form-group">
                    <textarea rows="3" cols="3" class="form-control" name="note" id="note">{{ $trackingHistory->note }}</textarea>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary transaction-submit-btn mb-2">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
            </div>
        </div>

        @if ($transaction_type == 'EXPENSE')
            <div class="col-md-4 xub-expenses-wrapper d-none">
                @include('layouts.sub-expense-types.sub-expense-list')
            </div>
        @endif
    </div>


</form>


<script>
    $(document).ready(function() {

        $('#expense_type').on('change', function() {

            var expenseType = $(this).val();
            var tracking_history_id = $('#tracking_history_id').val();
            
            if(expenseType == undefined || expenseType == null || expenseType == '') {
                $('.xub-expenses-wrapper').addClass('d-none');
                $('.main-trn-form-container').removeClass('col-md-8');
                $('.main-trn-form-container').addClass('col-md-12');
                return;
            } 

            var url = '{{ route('sub-expense-type.section.list', ['tracking_history_id' => ':tracking_history_id', 'expense_type_id' => ':expenseType']) }}';
            url = url.replace(':expenseType', expenseType);
            url = url.replace(':tracking_history_id', tracking_history_id);

            sectionReloadAjaxReq(['xub-expenses-wrapper', url]);

        })

    })
</script>