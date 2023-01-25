<x-layout>

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Total Balance</h5>

                        <div class="d-inline-flex ms-auto">
                            <a href="#" class="btn btn-indigo">{{ $totalBalance }} TK</a>
                            <a href="/wallet" class="btn btn-success" style="margin-left: 10px;">Create Wallet</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="pie_donut"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <tbody>

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
                                            <h6 class="mb-0">Balance <br /> {{ $wallet->currentBalance }} TK</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="/wallet/{{ $wallet->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="/wallet/{{ $wallet->id }}/delete" style="display: inline-block" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-labeled btn-labeled-start btn-sm">
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

            console.log("here");

            $.ajax({
                url : "http://127.0.0.1:8000/wallet/status",
                type : 'GET',
                success : function(data) {
                    console.log({data});
                }, 
                error : function(jqXHR, status, errorThrown){
                    showMessage(status, "Something went wrong .... ");
                    loadingMask2.hide();
                }
            });


            function preparePieChart(){
                
            }

        })
    </script>

</x-layout>
