<x-layout pageTitle="Add Income">

    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Add Income</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/transaction') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="transaction_type" value="INCOME" />

                                    <div class="row mb-3">
                                        <label class="form-label">Amount:</label>
                                        <div class="form-group">
                                            <input type="number" name="amount" class="form-control" value="{{ old('amount', 0.0) }}" min="0" step="any" required>
                                            @error('amount')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Transaction Charge:</label>
                                        <div class="form-group">
                                            <input type="number" name="transaction_charge" class="form-control" value="{{ old('transaction_charge', 0.0) }}" min="0" step="any">
                                            @error('transaction_charge')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">To Wallet:</label>
                                        <div class="input-group">
                                            <select class="form-control" name="to_wallet" required>
                                                <option value="">-- Select Wallet --</option>
                                                @foreach ($wallets as $wallet)
                                                    <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                                @endforeach
                                            </select>
                                            <a href="/wallet" target="_blank" class="btn btn-light" type="button">Create Wallet</a>
                                            @error('to_wallet')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Income Source:</label>
                                        <div class="input-group">
                                            <select class="form-control" name="income_source" required>
                                                <option value="">-- Select Income Source --</option>
                                                @foreach ($incomeSources as $incomeSource)
                                                    <option value="{{ $incomeSource->id }}">{{ $incomeSource->name }}</option>
                                                @endforeach
                                            </select>
                                            <a href="/income-source" target="_blank" class="btn btn-light" type="button">Create Income Source</a>
                                            @error('income_source')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Transaction Date:</label>
                                        <div class="form-group">
                                            <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                            @error('transaction_date')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Transaction Time:</label>
                                        <div class="form-group">
                                            <input type="time" name="transaction_time" class="form-control" value="{{ old('transaction_time', date('H:i')) }}" required>
                                            @error('transaction_time')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <div class="form-group">
                                            <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /centered card -->

                <!-- /marketing campaigns -->

            </div>
        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->

</x-layout>
