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
                                Spent : <span class="text-danger">{{ $expenseType->spent }} TK</span>
                            @else
                                Spent : <span class="text-danger">{{ $expenseType->spent }} TK</span>
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
                                Limit : <span class="text-success">{{ $expenseType->budget }} TK</span>
                            </div>
                            <div>Spent : <span class="text-danger">{{ $expenseType->spent }} TK</div>
                            <div>
                                Remaining :
                                @if ($expenseType->remaining > 0)
                                    <b class="text-success">{{ $expenseType->remaining }} TK</b>
                                    <div class="progress" style="margin-top: 10px;">
                                        <div class="progress-bar bg-teal" style="width: {{ $expenseType->percent }}%" aria-valuenow="{{ $expenseType->percent }}" aria-valuemin="0" aria-valuemax="100">{{ $expenseType->percent }}% complete</div>
                                    </div>
                                @else
                                    <b class="text-danger">0 TK</b>
                                    <div class="progress" style="margin-top: 10px;">
                                        <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            Limit exceeded {{ $expenseType->exced_amount }} TK
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
