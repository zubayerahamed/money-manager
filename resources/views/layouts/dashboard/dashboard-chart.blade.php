<a class="month-line-chart-link" href="{{ route('month.line-chart') }}"></a>
<a class="year-line-chart-link" href="{{ route('year.line-chart') }}"></a>

<!-- Tabs -->
<ul class="nav nav-tabs nav-tabs-underline nav-justified">
    <li class="nav-item">
        <a href="#messages-monthly" class="nav-link active" data-bs-toggle="tab">
            {{ date('M, Y') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="#messages-yearly" class="nav-link" data-bs-toggle="tab">
            {{ __('home.text.yearly') }}
        </a>
    </li>
</ul>
<!-- ./Tabs -->

<!-- Tabs content -->
<div class="tab-content card-body">

    <!-- Monthly Tab -->
    <div class="tab-pane active fade show" id="messages-monthly">
        <a href="{{ route('tracking.monthly', [date('m'), date('Y')]) }}" class="btn btn-light btn-sm mb-2" title="{{ __('home.text.transaction.details.view') }}"><i class="far fa-eye"></i></a>

        <!-- Current Month Line Chart -->
        <div class="chart-container">
            <div class="chart has-fixed-height" id="line_basic" style="height: 440px;"></div>
        </div>
        <!-- ./Current Month Line Chart -->

        <!-- Current Month Details -->
        @foreach ($monthWiseGroup as $key => $val)
            @if ($val['month'] == date('m'))
                <div class="row">

                    <!-- Current Balance -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ $currentBalance }} {{ auth()->user()->currency }}</h4>
                                    {{ __('home.text.current-balance') }}
                                </div>

                                <i class="ph-wallet ph-2x opacity-75 ms-3"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./Current Balance -->

                    <!-- Income -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="ph-mask-happy ph-2x opacity-75 me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ $val['income'] }} {{ auth()->user()->currency }}</h4>
                                    {{ __('home.text.income') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./Income -->

                    <!-- Expense -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ $val['expense'] + $val['trancharge'] }} {{ auth()->user()->currency }}</h4>
                                    {{ __('home.text.expense.charge') }} ({{ $val['trancharge'] }})
                                </div>

                                <i class="ph-mask-sad ph-2x opacity-75 ms-3"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./Expense -->

                    <!-- Saving -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body bg-indigo text-white">
                            <div class="d-flex align-items-center">
                                <i class="ph-bank ph-2x opacity-75 me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ $val['saving'] }} {{ auth()->user()->currency }}</h4>
                                    {{ __('home.text.saving') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./Saving -->

                </div>
            @endif
        @endforeach
        <!-- ./Current Month Details -->

        <!-- Previous Months Details -->
        <div class="row mt-2">
            @foreach ($monthWiseGroup as $key => $val)
                @if ($val['month'] != date('m'))
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-header bg-light text-dark fw-semibold">
                                <div class="col-md-10 float-start">
                                    <h5 class="mb-0">{{ $key }} {{ date('Y') }}</h5>
                                </div>
                                <div class="col-md-2 float-end text-end">
                                    <a href="{{ route('tracking.monthly', [$val['month'], date('Y')]) }}" title="{{ __('home.text.transaction.details.view') }}"><i class="far fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex">
                                    {{ __('home.text.income') }}
                                    <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['income'] }} {{ auth()->user()->currency }}</span>
                                </div>
                                <div class="list-group-item d-flex">
                                    {{ __('home.text.expense') }}
                                    <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['expense'] }} {{ auth()->user()->currency }}</span>
                                </div>
                                <div class="list-group-item d-flex">
                                    {{ __('home.text.charge') }}
                                    <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['trancharge'] }} {{ auth()->user()->currency }}</span>
                                </div>
                                <div class="list-group-item d-flex">
                                    {{ __('home.text.saving') }}
                                    <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['saving'] }} {{ auth()->user()->currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <!-- ./Previous Months Details -->
    </div>
    <!-- ./Monthly Tab -->

    <!-- Yearly Tab -->
    <div class="tab-pane fade" id="messages-yearly">
        <a href="{{ route('tracking.years.summary') }}" class="btn btn-light btn-sm mb-2" title="{{ __('home.text.transaction.details.view') }}"><i class="far fa-eye"></i></a>

        <!-- Current Year Line Chart -->
        <div class="chart-container">
            <div class="chart has-fixed-height" id="line_basic_yearly" style="height: 440px;"></div>
        </div>
        <!-- ./Current Year Line Chart -->

        <!-- Previous Years Details -->
        <div class="row mt-2">
            @foreach ($yearWiseGroup as $key => $val)
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header bg-light text-dark fw-semibold">
                            <div class="col-md-10 float-start">
                                <h5 class="mb-0">{{ $key }}</h5>
                            </div>
                            <div class="col-md-2 float-end text-end">
                                <a href="{{ route('tracking.yearly', $val['year']) }}" title="{{ __('home.text.transaction.details.view') }}"><i class="far fa-eye"></i></a>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex">
                                {{ __('home.text.income') }}
                                <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['income'] }} {{ auth()->user()->currency }}</span>
                            </div>
                            <div class="list-group-item d-flex">
                                {{ __('home.text.expense') }}
                                <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['expense'] }} {{ auth()->user()->currency }}</span>
                            </div>
                            <div class="list-group-item d-flex">
                                {{ __('home.text.charge') }}
                                <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['trancharge'] }} {{ auth()->user()->currency }}</span>
                            </div>
                            <div class="list-group-item d-flex">
                                {{ __('home.text.saving') }}
                                <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['saving'] }} {{ auth()->user()->currency }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <!-- ./Previous Years Details -->
    </div>
    <!-- ./Yearly Tab -->

</div>
<!-- /tabs content -->

<script>
    $(document).ready(function() {

        // Calling month line chart
        $.ajax({
            url: $('.month-line-chart-link').attr('href'),
            type: 'GET',
            success: function(data) {
                prepareCurrentMonthLineChart(data);
            },
            error: function(jqXHR, status, errorThrown) {
                showMessage(status, "Something went wrong .... ");
            }
        });

        // Calling year line chart
        $.ajax({
            url: $('.year-line-chart-link').attr('href'),
            type: 'GET',
            success: function(data) {
                prepareYearlyLineChart(data);
            },
            error: function(jqXHR, status, errorThrown) {
                showMessage(status, "Something went wrong .... ");
            }
        });

        function prepareYearlyLineChart(data) {
            var labels = [];
            var incomeAmounts = [];
            var expenseAmounts = [];
            for (var i = 0; i < data.length; i++) {
                labels.push(data[i].month);
                incomeAmounts.push(data[i].income_amount);
                expenseAmounts.push(data[i].expense_amount);
            }

            if (typeof echarts == 'undefined') {
                console.warn('Warning - echarts.min.js is not loaded.');
                return;
            }

            // Define element
            var line_stacked_element_yearly = document.getElementById('line_basic_yearly');

            //
            // Charts configuration
            //
            if (line_stacked_element_yearly) {

                // Initialize chart
                var line_stacked = echarts.init(line_stacked_element_yearly, null, {
                    renderer: 'svg'
                });

                // Options
                line_stacked.setOption({

                    // Define colors
                    color: ['#66BB6A', '#EF5350'],

                    // Global text styles
                    textStyle: {
                        fontFamily: 'var(--body-font-family)',
                        color: 'var(--body-color)',
                        fontSize: 14,
                        lineHeight: 22,
                        textBorderColor: 'transparent'
                    },

                    // Chart animation duration
                    animationDuration: 750,

                    // Setup grid
                    grid: {
                        left: 10,
                        right: 20,
                        top: 40,
                        bottom: 80,
                        containLabel: true
                    },

                    // Add legend
                    legend: {
                        data: ["{{ __('home.text.income') }}", "{{ __('home.text.expense') }}"],
                        itemHeight: 8,
                        itemGap: 30,
                        textStyle: {
                            color: 'var(--body-color)'
                        }
                    },

                    // Title
                    title: [{
                        left: 'center',
                        text: "{{ __('home.linechart.yearly.title') }}",
                        top: 380,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500,
                            color: 'var(--body-color)'
                        }
                    }],

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        className: 'shadow-sm rounded',
                        backgroundColor: 'var(--white)',
                        borderColor: 'var(--gray-400)',
                        padding: 15,
                        textStyle: {
                            color: '#000'
                        }
                    },

                    // Horizontal axis
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: labels,
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)'
                            }
                        }
                    }],

                    // Vertical axis
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'var(--gray-300)'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                            }
                        }
                    }],

                    // Axis pointer
                    axisPointer: [{
                        lineStyle: {
                            color: 'var(--gray-600)'
                        }
                    }],

                    // Add series
                    series: [{
                            name: 'Income',
                            type: 'line',
                            data: incomeAmounts,
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                        },
                        {
                            name: 'Expense',
                            type: 'line',
                            data: expenseAmounts,
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                        }
                    ]
                });
            }

            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                line_stacked_element_yearly && line_stacked.resize();
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

        function prepareCurrentMonthLineChart(data) {

            var labels = [];
            var incomeAmounts = [];
            var expenseAmounts = [];
            for (var i = 0; i < data.length; i++) {
                labels.push(data[i].date);
                incomeAmounts.push(data[i].income_amount);
                expenseAmounts.push(data[i].expense_amount);
            }

            if (typeof echarts == 'undefined') {
                console.warn('Warning - chart is not loaded.');
                return;
            }

            // Define element
            var line_stacked_element = document.getElementById('line_basic');

            if (line_stacked_element) {

                // Initialize chart
                var line_stacked = echarts.init(line_stacked_element, null, {
                    renderer: 'svg'
                });

                // Options
                line_stacked.setOption({

                    // Define colors
                    color: ['#66BB6A', '#EF5350'],

                    // Global text styles
                    textStyle: {
                        fontFamily: 'var(--body-font-family)',
                        color: 'var(--body-color)',
                        fontSize: 14,
                        lineHeight: 22,
                        textBorderColor: 'transparent'
                    },

                    // Chart animation duration
                    animationDuration: 750,

                    // Setup grid
                    grid: {
                        left: 10,
                        right: 20,
                        top: 40,
                        bottom: 80,
                        containLabel: true
                    },

                    // Add legend
                    legend: {
                        data: ["{{ __('home.text.income') }}", "{{ __('home.text.expense') }}"],
                        itemHeight: 8,
                        itemGap: 30,
                        textStyle: {
                            color: 'var(--body-color)'
                        }
                    },

                    // Title
                    title: [{
                        left: 'center',
                        text: "{{ __('home.linechart.monthly.title') }}",
                        top: 380,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500,
                            color: 'var(--body-color)'
                        }
                    }],

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        className: 'shadow-sm rounded',
                        backgroundColor: 'var(--white)',
                        borderColor: 'var(--gray-400)',
                        padding: 15,
                        textStyle: {
                            color: '#000'
                        }
                    },

                    // Horizontal axis
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: labels,
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)'
                            }
                        }
                    }],

                    // Vertical axis
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'var(--gray-300)'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                            }
                        }
                    }],

                    // Axis pointer
                    axisPointer: [{
                        lineStyle: {
                            color: 'var(--gray-600)'
                        }
                    }],

                    // Add series
                    series: [{
                            name: 'Income',
                            type: 'line',
                            data: incomeAmounts,
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                        },
                        {
                            name: 'Expense',
                            type: 'line',
                            data: expenseAmounts,
                            smooth: true,
                            symbol: 'circle',
                            symbolSize: 8,
                            areaStyle: {
                                normal: {
                                    opacity: 0.25
                                }
                            },
                        }

                    ]
                });
            }

            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                line_stacked_element && line_stacked.resize();
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

    });
</script>