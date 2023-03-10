<x-layout pageTitle="Home">


    <!-- Content area -->
    <div class="content">


        <!-- Dashboard content -->
        <div class="row">


            <div class="col-xl-12">



                <!-- My messages -->
                <div class="card">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified">
                        <li class="nav-item">
                            <a href="#messages-monthly" class="nav-link active" data-bs-toggle="tab">
                                {{ date('M, Y') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#messages-yearly" class="nav-link" data-bs-toggle="tab">
                                Yearly
                            </a>
                        </li>
                    </ul>
                    <!-- /tabs -->



                    <!-- Tabs content -->
                    <div class="tab-content card-body">

                        <div class="tab-pane active fade show" id="messages-monthly">
                            <a href="{{ url('/tracking/details/month/' . date('m') . '/' . date('Y')) }}" class="btn btn-success btn-sm">View Details</a>
                            <div class="chart-container">
                                <div class="chart has-fixed-height" id="line_basic" style="height: 440px;"></div>
                            </div>

                            @foreach ($monthWiseGroup as $key => $val)
                                @if ($val['month'] == date('m'))
                                    <div class="row">
                                        <div class="text-center box-item box-item-success">
                                            <h2>Monthly Income</h2>
                                            <h3>{{ $val['income'] }} TK</h3>
                                        </div>
                                        <div class="text-center box-item box-item-danger">
                                            <h2>Monthly Expense</h2>
                                            <h3>Expense : {{ $val['expense'] }} TK , TRNC : {{ $val['trancharge'] }} TK</h3>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="text-center box-item box-item-primary">
                                            <h2>Monthly Saving</h2>
                                            <h3>{{ $val['saving'] }} TK</h3>
                                        </div>
                                        <div class="text-center box-item box-item-success">
                                            <h2>Current Balance</h2>
                                            <h3>{{ $currentBalance }} TK</h3>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>

                        <div class="tab-pane fade" id="messages-yearly">
                            <a href="{{ url('/tracking/details/year/' . date('Y')) }}" class="btn btn-success btn-sm">View Yearly Details</a>
                            <div class="chart-container">
                                <div class="chart has-fixed-height" id="line_basic_yearly" style="height: 440px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /tabs content -->

                </div>
                <!-- /my messages -->
            </div>

            @foreach ($monthWiseGroup as $key => $val)
                @if ($val['month'] != date('m'))
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <div class="col-md-10">
                                    <h5 class="mb-0">{{ $key }} {{ date('Y') }}</h5>
                                </div>
                                <div class="col-md-2" style="text-align:right">
                                    <a href="{{ url('/tracking/details/month/' . $val['month'] . '/' . date('Y')) }}"><i class="far fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <div class="list-group">
                                    <div class="list-group-item d-flex">
                                        Income
                                        <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['income'] }}/-</span>
                                    </div>
                                    <div class="list-group-item d-flex">
                                        Expense
                                        <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['expense'] }}/-</span>
                                    </div>
                                    <div class="list-group-item d-flex">
                                        Transaction Charge
                                        <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['trancharge'] }}/-</span>
                                    </div>
                                    <div class="list-group-item d-flex">
                                        Saving
                                        <span class="badge border border-teal text-teal rounded-pill ms-auto">{{ $val['saving'] }}/-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach



        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->

    <script>
        $(document).ready(function() {

            $.ajax({
                url: $('.basePath').attr('href') + "/current-month/line-chart",
                type: 'GET',
                success: function(data) {
                    prepareCurrentMonthLineChart(data);
                },
                error: function(jqXHR, status, errorThrown) {

                }
            });

            $.ajax({
                url: $('.basePath').attr('href') + "/current-year/line-chart",
                type: 'GET',
                success: function(data) {
                    prepareYearlyLineChart(data);
                },
                error: function(jqXHR, status, errorThrown) {

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


                    //
                    // Chart config
                    //

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
                            data: ['Income', 'Expense'],
                            itemHeight: 8,
                            itemGap: 30,
                            textStyle: {
                                color: 'var(--body-color)'
                            }
                        },

                        // Title
                        title: [{
                            left: 'center',
                            text: 'Income Vs Expense monthly increment',
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


                //
                // Charts configuration
                //

                if (line_stacked_element) {

                    // Initialize chart
                    var line_stacked = echarts.init(line_stacked_element, null, {
                        renderer: 'svg'
                    });


                    //
                    // Chart config
                    //

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
                            data: ['Income', 'Expense'],
                            itemHeight: 8,
                            itemGap: 30,
                            textStyle: {
                                color: 'var(--body-color)'
                            }
                        },

                        // Title
                        title: [{
                            left: 'center',
                            text: 'Income Vs Expense daily increment',
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

        })
    </script>


</x-layout>
