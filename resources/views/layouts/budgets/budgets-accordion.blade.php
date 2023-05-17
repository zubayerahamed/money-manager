<div class="card-body">
    <div class="row text-md-start text-center">
        <p>Total Budget : <span class="text-success">{{ $totalBudget }} {{ auth()->user()->currency }}</span></p>
        <p>Total Spent : <span class="text-danger">{{ $totalSpent }} {{ auth()->user()->currency }}</span></p>
        <p>Remaining : <span class="text-success">{{ $totalBudget - $totalSpent > 0 ? $totalBudget - $totalSpent : 0 }} {{ auth()->user()->currency }}</span></p>
    </div>
    @if ($totalBudget != 0 or $totalSpent != 0)
        @if ($totalBudget - $totalSpent > 0)
            <div class="progress" style="margin-top: 10px;">
                <div class="progress-bar bg-teal" style="width: {{ round((100 * $totalSpent) / $totalBudget, 2) }}%" aria-valuenow="{{ round((100 * $totalSpent) / $totalBudget, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round((100 * $totalSpent) / $totalBudget, 2) }}% complete</div>
            </div>
        @else
            <div class="progress" style="margin-top: 10px;">
                <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    Limit exceeded {{ $totalSpent - $totalBudget }} {{ auth()->user()->currency }}
                </div>
            </div>
        @endif
    @endif
</div>

<div class="accordion accordion-flush" id="accordion_flush">
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
                                @if ($expenseType->budget)
                                    Spent : <span class="text-danger">{{ $expenseType->spent }} {{ auth()->user()->currency }}</span>
                                @else
                                    Spent : <span class="text-danger">{{ $expenseType->spent }} {{ auth()->user()->currency }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="flush_item{{ $expenseType->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
                <div class="accordion-body">
                    <div class="col-md-12 text-center">
                        @if ($expenseType->budget)
                            <div class="col-md-12 text-center mb-2">
                                <div>
                                    Limit : <span class="text-success">{{ $expenseType->budget }} {{ auth()->user()->currency }}</span>
                                </div>
                                <div>Spent : <span class="text-danger">{{ $expenseType->spent }} {{ auth()->user()->currency }}</div>
                                <div>
                                    Remaining :
                                    @if ($expenseType->remaining > 0)
                                        <b class="text-success">{{ $expenseType->remaining }} {{ auth()->user()->currency }}</b>
                                        <div class="progress" style="margin-top: 10px;">
                                            <div class="progress-bar bg-teal" style="width: {{ $expenseType->percent }}%" aria-valuenow="{{ $expenseType->percent }}" aria-valuemin="0" aria-valuemax="100">{{ $expenseType->percent }}% complete</div>
                                        </div>
                                    @else
                                        <b class="text-danger">0 {{ auth()->user()->currency }}</b>
                                        <div class="progress" style="margin-top: 10px;">
                                            <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                Limit exceeded {{ $expenseType->exced_amount }} {{ auth()->user()->currency }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <span class="badge border border-teal text-teal rounded-pill m-auto">
                            @if ($expenseType->budget)
                                <a href="{{ route('budget.edit', $expenseType->budget_id) }}" class="m-2 text-primary transaction-btn" data-title="Update Limit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('budget.create', [$expenseType->id, $month, $year]) }}" class="m-2 text-success transaction-btn" data-title="Add budget">
                                    <i class="fas fa-calculator"></i>
                                </a>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
