@foreach ($expenseTypes as $expenseType)
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $expenseType->id }}">
                <div class="d-flex align-items-center">

                    <div style="width: 70px; text-align: center;">
                        <i class="{{ $expenseType->icon }} fa-2x me-3"></i>
                    </div>

                    <div>
                        <div style="text-transform: uppercase; font-weight: bold;">{{ $expenseType->name }}</div>
                        <div class="text-muted fs-sm">
                            <span class="d-inline-block rounded-pill p-1 me-1 {{ $expenseType->active? 'bg-primary' : 'bg-danger' }}"></span> <span>{{ $expenseType->totalExpense == null ? 0 : $expenseType->totalExpense }} {{ auth()->user()->currency }}</span>
                        </div>
                    </div>

                </div>
            </button>
        </h2>

        <div id="flush_item{{ $expenseType->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
            <div class="accordion-body">
                <div class="col-md-12 text-center">

                    @if ($expenseType->note != '')
                        <div class="col-md-12 text-center mb-2">
                            <span class="fw-semibold">{{ $expenseType->note }}</span>
                        </div>
                    @endif

                    <span class="badge border border-teal text-teal rounded-pill m-auto">
                        <a href="{{ route('expense-type.chart.data', ['id' => $expenseType->id]) }}" data-expense-type-id="{{ $expenseType->id }}" class="m-2 text-primary line-chart-btn" title="View Chart" data-title="Expense Chart of {{ $expenseType->name }}">
                            <i class="fas fa-chart-line"></i>
                        </a>

                        <a href="{{ route('tracking.monthlygrouped', [$expenseType->id, 'EXPENSE']) }}" class="m-2 text-primary transaction-btn" title="View Details" data-title="Expense Details of {{ $expenseType->name }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('expense-type.edit', $expenseType->id) }}" class="m-2 text-primary transaction-btn" title="{{ __('expense-type.btn.edit-expense-type') }}" data-title="{{ __('expense-type.btn.edit-expense-type') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="form-id{{ $expenseType->id }}"
                              action="{{ route('expense-type.destroy', $expenseType->id) }}"
                              method="POST" style="display: inline-block;">
                            @method('DELETE')
                            @csrf
                            <a href="#" class="delete-btn text-danger m-2"
                               onclick="deleteData(this)"
                               data-form-id="{{ 'form-id' . $expenseType->id }}"
                               title="{{ __('expense-type.btn.delete-expense-type') }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </span>

                    <span class="badge border border-teal text-teal rounded-pill m-auto">
                        <a href="{{ route('sub-expense-type.create', ['expense_type_id' => $expenseType->id]) }}" class="m-2 text-primary transaction-btn" title="Add Sub Expense Type" data-title="Add Sub Expense Type">
                            <i class="fas fa-plus"></i>
                        </a>
                    </span>

                     <!-- Expense Line Chart -->
                    <div class="chart-container mt-3">
                        <div class="chart has-fixed-height expense-type-chart d-none" 
                            data-chart-url="{{ route('expense-type.chart.data', ['id' => $expenseType->id]) }}"
                            id="line_basic_{{ $expenseType->id }}" 
                            data-expense-type-id="{{ $expenseType->id }}" 
                            style="height: 440px; width: 100%;"></div>
                    </div>
                    <!-- /Expense Line Chart -->

                    <div class="sub-expense-type-wrapper-{{ $expenseType->id }}">
                        @include('layouts.sub-expense-types.sub-expense-types-accordion')
                    </div>

                </div>
            </div>
        </div>

    </div>
@endforeach



<script>
    $(document).ready(function() {

        // Calling year line chart
        $('.line-chart-btn').off('click').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var expenseTypeId = $(this).data('expense-type-id');
            var title = $(this).data('title');
            var chartElement = $('#line_basic_' + expenseTypeId);
            chartElement.toggleClass('d-none');
            chartElement.attr('title', title);

             $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    prepareYearlyLineChart(chartElement.attr('id'), data);
                },
                error: function(jqXHR, status, errorThrown) {
                    showMessage(status, "Something went wrong .... ");
                }
            });
        });

        function prepareYearlyLineChart(chartId, data) {
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
            var chartElement  = document.getElementById(chartId);

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