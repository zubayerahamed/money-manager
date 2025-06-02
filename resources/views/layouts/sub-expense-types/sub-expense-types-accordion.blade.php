@if (!$expenseType->subExpenseTypes->isEmpty())
    <div class="col-md-12 mt-2 mb-2">
        <div class="table-responsive">
            <table class="table table-stripped no-wrap" style="text-wrap-mode: nowrap;">
                <tbody>
                    @foreach ($expenseType->subExpenseTypes as $subExpenseType)
                        <tr>
                            <td style="width: 15px; text-align: left;">
                                <a href="{{ route('expense-type.chart.sub-expense.data', ['id' => $subExpenseType->id]) }}" data-sub-expense-type-id="{{ $subExpenseType->id }}" class="m-2 text-primary sub-expense-type-line-chart-btn" title="View Chart" data-title="Expense Chart of {{ $subExpenseType->name }}">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="{{ route('sub-expense-type.monthlygrouped', ['sub_expense_type_id' => $subExpenseType->id]) }}" class="m-2 text-primary transaction-btn" title="View Details" data-title="Expense Details of {{ $subExpenseType->name }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form id="form-id-sub{{ $subExpenseType->id }}"
                                      action="{{ route('sub-expense-type.destroy', ['expense_type_id' => $expenseType->id, 'id' => $subExpenseType->id]) }}"
                                      method="POST" style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <a href="#" class="delete-btn text-danger m-2 text-sm"
                                       onclick="deleteData(this)"
                                       data-form-id="{{ 'form-id-sub' . $subExpenseType->id }}"
                                       title="Delete sub expense type">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                </form>
                            </td>
                            <td style="text-align: left; font-weight: bold">
                                <a href="{{ route('sub-expense-type.edit', ['expense_type_id' => $subExpenseType->expense_type_id, 'id' => $subExpenseType->id]) }}"
                                   class="transaction-btn text-muted"
                                   title="Edit Sub Expense Type"
                                   data-title="Edit Sub Expense Type">
                                    <span>
                                        {{ $subExpenseType->name }}
                                    </span>
                                    <div class="text-muted fs-sm">
                                        <span class="d-inline-block {{ $subExpenseType->active ? 'bg-primary' : 'bg-danger' }} rounded-pill p-1 me-1"></span> <span>{{ $subExpenseType->totalExpense == null ? 0 : $subExpenseType->totalExpense }} {{ auth()->user()->currency }}</span>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.sub-expense-type-line-chart-btn').off('click').on('click', function(e) {
                e.preventDefault();
                var subExpenseTypeId = $(this).data('sub-expense-type-id');
                var url = $(this).attr('href');
                var title = $(this).data('title');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        // Assuming data contains the chart HTML
                        var chartContainer = '<div id="expense-type-line-chart" class="chart has-fixed-height expense-type-line-chart d-none" style="height: 440px; width: 100%;"></div>';
                        $('#chart-modal .modal-body').html(chartContainer);

                        var chartElement = $('#expense-type-line-chart');
                        chartElement.html("");
                        chartElement.removeClass('d-none');

                        $('#chart-modal .chart-modal-title').text(title);
                        $('#chart-modal').modal('show');

                        // Call the function after modal fully loaded
                        $('#chart-modal').on('shown.bs.modal', function () {
                            prepareYearlyLineChart(chartElement.attr('id'), data);
                        });

                    },
                    error: function(xhr) {
                        console.error('Error fetching chart data:', xhr);
                    }
                });
            });



            function prepareYearlyLineChart(elid, data) {
                var months = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];
                var labels = data.map(d => months[d.month - 1]);
                var amounts = data.map(d => d.amount);

                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var chartElement  = document.getElementById(elid);


                //
                // Charts configuration
                //
                if (chartElement) {

                    // Initialize chart
                    var line_stacked = echarts.init(chartElement, null, {
                        renderer: 'svg'
                    });

                    // Options
                    line_stacked.setOption({

                        // Define colors
                        color: ['#EF5350'],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            //lineHeight: 22,
                            //textBorderColor: 'transparent'
                        },

                        // Chart animation duration
                        animationDuration: 750,

                        // Setup grid
                        grid: {
                            left: 10,
                            right: 20,
                            top: 40,
                            bottom: 60,
                            containLabel: true
                        },

                        // Add legend

                        // Title

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
                                name: 'Expense',
                                type: 'line',
                                data: amounts,
                                smooth: true,
                                symbol: 'circle',
                                symbolSize: 8,
                                areaStyle: {
                                    normal: {
                                        opacity: 0.25
                                    }
                                },
                            },
                        ]
                    });
                }
                //
                // Resize charts
                //

                // Resize function
                var triggerChartResize = function() {
                    chartElement && line_stacked.resize();
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
@endif
