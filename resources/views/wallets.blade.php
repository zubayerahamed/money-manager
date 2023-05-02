<x-layout pageTitle="Wallets Status">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header">
                        <div class="col-md-6 float-start text-start">
                            <h5 class="mb-0">Balance : {{ $totalBalance }} TK</h5>
                        </div>

                        <div class="col-md-6 float-end text-end">
                            <a href="{{ url('/wallet') }}" class="btn btn-success btn-sm" title="Create wallet">
                                <i class="fas fa-plus"></i>
                                <div class="d-none d-md-block ms-1">Create wallet</div>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="pie_rose_labels"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <tbody>
                                <thead>
                                    <tr>
                                        <th>Wallet</th>
                                        <th class="text-center">Balance (TK)</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                @foreach ($wallets as $wallet)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div style="width: 70px; text-align: center;">
                                                    <i class="{{ $wallet->icon }} fa-2x me-3"></i>
                                                </div>
                                                <div>
                                                    <div style="text-transform: uppercase; font-weight: bold;">{{ $wallet->name }}</div>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $wallet->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-center">{{ $wallet->currentBalance }}</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ url('/wallet') . '/' . $wallet->id }}/saving }}" data-wallet-id="{{ $wallet->id }}" data-wallet-name="{{ $wallet->name }}" data-wallet-amount="{{ $wallet->currentBalance }}" class="btn-saving btn btn-success btn-labeled btn-labeled-start btn-sm" title="Do Saving">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="far fa-save"></i></span> Do Savings
                                            </a>
                                            <a href="{{ url('/wallet') . '/' . $wallet->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm" title="Edit">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="{{ url('/wallet') . '/' . $wallet->id }}/delete" style="display: inline-block" method="POST">
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
    <!-- /content area -->


    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form id="create-wallet-form-modal" action="{{ url('/wallet') }}" method="POST">
                                @csrf

                                <i class="fab fa-korvue fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>

                                <div class="row mb-3">
                                    <label class="form-label">Icon:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="icon" id="icon" value="fab fa-korvue" readonly>
                                        <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Choose</button>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Wallet name:</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Current Balance:</label>
                                    <div class="form-group">
                                        <input type="number" name="current_balance" class="form-control" value="0" min="0" step="any" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="form-label">Note:</label>
                                    <div class="form-group">
                                        <textarea rows="3" cols="3" class="form-control" name="note"></textarea>
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
        </div>
    </div>


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


            $.ajax({
                url: $('.basePath').attr('href') + "/wallet/status",
                type: 'GET',
                success: function(data) {
                    preparePieChart(data);
                },
                error: function(jqXHR, status, errorThrown) {
                    showMessage(status, "Something went wrong .... ");
                    loadingMask2.hide();
                }
            });


            function preparePieChart(data) {

                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var pie_rose_labels_element = document.getElementById('pie_rose_labels');


                if (pie_rose_labels_element) {


                    // extract data first
                    // create name array
                    var labels = [];
                    for (var i = 0; i < data.length; i++) {
                        labels.push(data[i].name);
                    }


                    // Initialize chart
                    var pie_rose_labels = echarts.init(pie_rose_labels_element, null, {
                        renderer: 'svg'
                    });
                    //
                    // Chart config
                    //

                    // Options
                    pie_rose_labels.setOption({

                        // Colors
                        color: [
                            '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
                            '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
                            '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
                            '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089'
                        ],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            lineHeight: 22,
                            textBorderColor: 'transparent'
                        },

                        // Add title
                        title: {
                            text: 'Wallet Status',
                            subtext: '',
                            left: 'center',
                            textStyle: {
                                fontSize: 18,
                                fontWeight: 500,
                                color: 'var(--body-color)'
                            },
                            subtextStyle: {
                                fontSize: 12,
                                color: 'rgba(var(--body-color-rgb), 0.5)'
                            }
                        },

                        // Add tooltip
                        tooltip: {
                            trigger: 'item',
                            className: 'shadow-sm rounded',
                            backgroundColor: 'var(--white)',
                            borderColor: 'var(--gray-400)',
                            padding: 15,
                            textStyle: {
                                color: '#000'
                            },
                            formatter: '{a} <br/>{b}: {c}TK ({d}%)'
                        },

                        // Add legend
                        legend: {
                            orient: 'vertical',
                            top: 'center',
                            left: 0,
                            data: labels,
                            itemHeight: 8,
                            itemWidth: 8,
                            textStyle: {
                                color: 'var(--body-color)'
                            },
                            itemStyle: {
                                borderColor: 'transparent'
                            }
                        },

                        // Add series
                        series: [{
                            name: 'Wallets',
                            type: 'pie',
                            top: 20,
                            radius: ['15%', '80%'],
                            center: ['50%', '57.5%'],
                            roseType: 'radius',
                            itemStyle: {
                                borderColor: 'var(--card-bg)'
                            },
                            label: {
                                color: 'var(--body-color)'
                            },
                            data: data
                        }]
                    });

                }

            }

        })
    </script>

</x-layout>
