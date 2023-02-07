<x-layout pageTitle="Expense Types Status">

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <div class="text-center col-md-12">
                            <h2 class="mb-0">
                                Total Budget : <span class="text-success">{{ $totalBudget }}/-</span>, Total Spent : <span class="text-danger">{{ $totalSpent }}/-</span>
                            </h2>
                            <h4 class="mb-0"><a href="{{ url('/budget/'.$month.'/'.$year-1 .'/list') }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $year }} <a href="{{ url('/budget/'.$month.'/'.$year+1 . '/list') }}"><i class="fas fa-arrow-alt-circle-right"></i></a></h4>
                            <h4 class="mb-0"><a href="{{ url('/budget/'. ($month == 1 ? $month : $month-1) .'/'.$year . '/list') }}"><i class="fas fa-arrow-alt-circle-left"></i></a> {{ $monthText }} <a href="{{ url('/budget/'. ($month == 12 ? $month : $month+1) .'/'.$year . '/list') }}"><i class="fas fa-arrow-alt-circle-right"></i></a></h4>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Expense Type</th>
                                    <th>Budget Details - {{ $monthText }}, {{ $year }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($expenseTypes as $expenseType)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div style="width: 60px;">
                                                    <i class="{{ $expenseType->icon }} fa-2x me-3"></i>
                                                </div>
                                                <div>
                                                    <div style="text-transform: uppercase; font-weight: bold;">{{ $expenseType->name }}</div>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $expenseType->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($expenseType->budget)
                                                <div>
                                                    Limit : <span class="text-success">{{ $expenseType->budget }}/-</span> 
                                                    <a href="{{ url('/budget') . '/' . $expenseType->budget_id . '/update' }}" style="margin-left: 10px; line-height: 25px;" title="Update Limit">Update Limit</a>
                                                </div>    
                                                <div>Spent : <span class="text-danger">{{ $expenseType->spent }}/-</div>    
                                                <div>
                                                    Remaining : 
                                                    @if ($expenseType->remaining > 0)
                                                        <b class="text-success">{{ $expenseType->remaining }}/-</b>
                                                        <div class="progress" style="margin-top: 10px;">
                                                            <div class="progress-bar bg-teal" style="width: {{ $expenseType->percent }}%" aria-valuenow="{{ $expenseType->percent }}" aria-valuemin="0" aria-valuemax="100">{{ $expenseType->percent }}% complete</div>
                                                        </div>
                                                    @else
                                                        <b class="text-danger">0/-</b>
                                                        <div class="progress" style="margin-top: 10px;">
                                                            <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                Limit exceeded {{ $expenseType->exced_amount }}/-
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>    
                                            @else
                                                <div class="mb-2">Spent : <span class="text-danger">{{ $expenseType->spent }}/-</span></div>  
                                                <a href="{{ url('/budget') . '/' . $expenseType->id . '/'.$month.'/'.$year }}" class="btn btn-success btn-labeled btn-labeled-start btn-sm" title="Add budget">
                                                    <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="fas fa-calculator"></i> </span> Add Budget
                                                </a>
                                            @endif
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

</x-layout>
