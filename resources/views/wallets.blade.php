<x-layout pageTitle="Wallets Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header wallets-header">
                        @include('layouts.wallets.wallets-header')
                    </div>

                    <div class="card-body wallets-pie-chart">
                        @include('layouts.wallets.wallets-pie-chart')
                    </div>

                    <div class="accordion accordion-flush wallets-accordion" id="accordion_flush">
                        @include('layouts.wallets.wallets-accordion')
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->


    <div class="modal fade" id="smyModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Make Saving</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form id="ac-transaction-form" action="{{ url('/ac-tracking/saving') }}" method="POST">
                                @csrf

                                <input type="hidden" name="transaction_type" value="IN" />
                                <input type="hidden" name="wallet_id" id="wallet_id" />

                                <div class="row mb-3">
                                    <label class="form-label">From Wallet:</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control from-wallet">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Amount:</label>
                                    <div class="form-group">
                                        <input type="number" name="amount" id="amount" class="form-control" min="0" step="any" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">To Account:</label>
                                    <div class="input-group">
                                        <select class="form-control" name="account_id" required>
                                            <option value="">-- Select Account --</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
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

            $('body').on('click', '.create-wallet-btn, .wallet-edit-btn', function(e){
                e.preventDefault();

                var url = $(this).attr("href");
                var modalTitle = $(this).data('title');
                $('.transaction-modal-title').html(modalTitle);

                loadingMask2.show();
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        loadingMask2.hide();
                        $(".transaction-form-wrapper").html("");
                        $('#transaction-modal').modal('show');
                        $(".transaction-form-wrapper").append(data);
                    },
                    error: function(jqXHR, status, errorThrown) {
                        loadingMask2.hide();
                        showMessage("error", jqXHR.responseJSON.message);
                    },
                });
            })

            $('.btn-saving').off('click').on('click', function(e) {
                e.preventDefault();

                $('#myModal').modal('show');

                var walletId = $(this).data('wallet-id');
                var walletName = $(this).data('wallet-name');
                var walletAmount = $(this).data('wallet-amount');

                $('input#wallet_id').val(walletId);
                $('input.from-wallet').val(walletName);
                $('input#amount').val(walletAmount);
                $('input#amount').attr('max', walletAmount);
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
