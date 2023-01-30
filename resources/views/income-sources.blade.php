<x-layout>

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Total Income</h5>

                        <div class="d-inline-flex ms-auto">
                            <a href="#" class="btn btn-success" style="margin-left: 10px;">{{ $totalIncome }} TK</a>
                            <a href="{{ url('/income-source') }}" class="btn btn-success" style="margin-left: 10px;">Create Income Source</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="pie_rose_labels"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Income Type</th>
                                    <th class="text-center">Income (TK)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incomeSources as $incomeSource)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                
                                                <div style="width: 60px; text-align: left;">
                                                    <i class="{{ $incomeSource->icon }} fa-2x me-3"></i>
                                                </div>
                                                
                                                <div>
                                                    <div style="text-transform: uppercase; font-weight: bold;">{{ $incomeSource->name }}</div>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $incomeSource->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-center">{{ $incomeSource->totalIncome }}</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ url('/income-source').'/'.$incomeSource->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm" title="Edit">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="{{ url('/income-source').'/'.$incomeSource->id }}/delete" style="display: inline-block" method="POST">
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

    <script>
        $(document).ready(function(){

            $.ajax({
                url : $('.basePath').attr('href') + "/income-source/status",
                type : 'GET',
                success : function(data) {
                    preparePieChart(data);
                }, 
                error : function(jqXHR, status, errorThrown){
                    showMessage(status, "Something went wrong .... ");
                    loadingMask2.hide();
                }
            });


            function preparePieChart(data){

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
                    for(var i = 0; i < data.length; i++){
                        labels.push(data[i].name);
                    }


                    // Initialize chart
                    var pie_rose_labels = echarts.init(pie_rose_labels_element, null, { renderer: 'svg' });
                    //
                    // Chart config
                    //

                    // Options
                    pie_rose_labels.setOption({

                        // Colors
                        color: [
                            '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                            '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
                            '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                            '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
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
                            text: 'Income Status',
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
                            name: 'Income Source',
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
