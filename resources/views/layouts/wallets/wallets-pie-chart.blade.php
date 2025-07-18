<div class="chart-container">
    <div class="chart has-fixed-height" id="pie_rose_labels"></div>
</div>
<a class="wallet-status-link" href="{{ route('wallet.data.status') }}"></a>

<script>
    $(document).ready(function() {

        $.ajax({
            url: $('.wallet-status-link').attr('href'),
            type: 'GET',
            success: function(data) {
                preparePieChart(data);
            },
            error: function(jqXHR, status, errorThrown) {
                showMessage(status, "Something went wrong .... ");
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
                        text: "{{ __('wallet.piechart.title') }}",
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
                        formatter: '{a} <br/>{b}: {c} {{ auth()->user()->currency }} ({d}%)'
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
