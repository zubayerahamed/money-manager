<x-layout pageTitle="Create Wallet">
    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Budget Limit for {{ $budget->expenseType->name }} - <span class="text-primary">{{ $monthText }}, {{ $year }}</span></h5>
        
                                <div class="d-inline-flex ms-auto">
                                    <a href="{{ url('/budget/'.$month.'/'.$year.'/list') }}" class="btn btn-primary" style="margin-left: 10px;">
                                        Back To Budget List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/budget/'. $budget->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    @if ($budget->expenseType->icon)
                                        <i class="{{ $budget->expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>
                                    @endif

                                    <div class="row mb-3">
                                        <label class="form-label">Expense Type:</label>
                                        <div class="form-group">
                                            <input type="hidden" name="expense_type" value="{{ $budget->expense_type }}"/>
                                            <input type="text" class="form-control" value="{{ $budget->expenseType->name }}" readonly>
                                            @error('expense_type')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>    
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Amount:</label>
                                        <div class="form-group">
                                            <input type="number" name="amount" class="form-control" value="{{ old('amount', $budget->amount) }}" min="0" step="any" required>
                                        </div>
                                        @error('amount')
                                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>    
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <div class="form-group">
                                            <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note', $budget->note) }}</textarea>
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



    @include('icon-modal');

</x-layout>
