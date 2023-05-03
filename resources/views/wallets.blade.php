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
                            <a href="{{ url('/wallet') }}" class="btn btn-success btn-sm create-wallet-btn" data-title="Create wallet">
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


                // Resize function
                var triggerChartResize = function() {
                    pie_rose_labels_element && pie_rose_labels.resize();
                };

                // On sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', triggerChartResize);
                    });
                }
                var tabToggle = document.querySelectorAll('.nav-link');
                if (tabToggle) {
                    tabToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', triggerChartResize);
                    });
                }

                // On window resize
                var resizeCharts;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeCharts);
                    resizeCharts = setTimeout(function() {
                        triggerChartResize();
                    }, 200);
                });

            }

        })
    </script>

</x-layout>
