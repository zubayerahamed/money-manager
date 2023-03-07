<x-layout pageTitle="Wallets Status">

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Accounts</h5><a href="#" class="btn btn-indigo" style="margin-left: 10px;">{{ $totalBalance }} TK</a>

                        <div class="d-inline-flex ms-auto">
                            <a href="{{ url('/account') }}" class="btn btn-success" style="margin-left: 10px;">Create Account</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <tbody>
                                <thead>
                                    <tr>
                                        <th>Account</th>
                                        <th class="text-center">Current Balance</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <div style="text-transform: uppercase; font-weight: bold;">{{ $account->name }}</div>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $account->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-center">{{ $account->currentBalance }}</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ url('/account') . '/' . $account->id }}/withdraw }}" data-account-id="{{ $account->id }}" data-account-name="{{ $account->name }}" data-account-amount="{{ $account->currentBalance }}" class="btn-withdraw btn btn-danger btn-labeled btn-labeled-start btn-sm" title="Withdraw">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="fas fa-money-bill-wave"></i></span> Withdraw
                                            </a>
                                            <a href="{{ url('/account') . '/' . $account->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm" title="Edit">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="{{ url('/account') . '/' . $account->id }}/delete" style="display: inline-block" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-labeled btn-labeled-start btn-sm" title="Delete">
                                                    <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-trash ph-sm"></i> </span> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>


    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Make Withdraw</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form id="ac-transaction-form" action="{{ url('/ac-tracking/withdraw') }}" method="POST">
                                @csrf

                                <input type="hidden" name="transaction_type" value="OUT" />
                                <input type="hidden" name="account_id" id="account_id" />

                                <div class="row mb-3">
                                    <label class="form-label">From Account:</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control from-account">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Amount:</label>
                                    <div class="form-group">
                                        <input type="number" name="amount" id="amount" class="form-control" min="0" step="any" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">To Wallet:</label>
                                    <div class="input-group">
                                        <select class="form-control" name="wallet_id" required>
                                            <option value="">-- Select Wallet --</option>
                                            @foreach ($wallets as $wallet)
                                                <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary submit-btn">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.btn-withdraw').off('click').on('click', function(e) {
                e.preventDefault();

                $('#myModal').modal('show');

                var accountId = $(this).data('account-id');
                var accountName = $(this).data('account-name');
                var accountAmount = $(this).data('account-amount');

                $('input#account_id').val(accountId);
                $('input.from-account').val(accountName);
                $('input#amount').val(accountAmount);
                $('input#amount').attr('max', accountAmount);
            });

            $('button.submit-btn').off('click').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    'type': 'POST',
                    'url': $('#ac-transaction-form').attr('action'),
                    'data': $('#ac-transaction-form').serialize(),
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.status == 'success') {
                            $('#myModal').modal('hide');
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    }
                });

            });
        })
    </script>

</x-layout>
