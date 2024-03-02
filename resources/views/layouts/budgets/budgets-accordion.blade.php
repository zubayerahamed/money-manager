<div class="card-body">

    <div class="row text-md-start text-center">
        <p>{{ __('budget.text.total-budget') }} : <span class="text-success">{{ $totalBudget }} {{ auth()->user()->currency }}</span></p>
        <p>{{ __('budget.text.total-spent') }} : <span class="text-danger">{{ $totalSpent }} {{ auth()->user()->currency }}</span></p>
        <p>{{ __('budget.text.total-remaining') }} : <span class="text-primary">{{ $totalBudget - $totalSpent > 0 ? $totalBudget - $totalSpent : 0 }} {{ auth()->user()->currency }}</span></p>
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
                    <div class="d-flex align-items-center col-sm-12">

                        <div style="width: 70px; text-align: center;">
                            <i class="{{ $expenseType->icon }} fa-2x me-3"></i>
                        </div>

                        <div style="flex-grow: 1">
                            <div style="text-transform: uppercase; font-weight: bold;">{{ $expenseType->name }}</div>
                            <div class="text-muted fs-sm">
                                @if ($expenseType->budget)
                                    {{ __('budget.text.limit') }} : <span class="text-success">{{ $expenseType->budget }} {{ auth()->user()->currency }}</span>
                                    <br/>
                                    {{ __('budget.text.spent') }} : <span class="text-danger">{{ $expenseType->spent == null ? 0 : $expenseType->spent }} {{ auth()->user()->currency }}</span>
                                    
                                    <br/>
                                    @if ($expenseType->remaining > 0)
                                        {{ __('budget.text.remaining') }} :
                                        <b class="text-success">{{ $expenseType->remaining }} {{ auth()->user()->currency }}</b>
                                        <div class="progress" style="margin-top: 10px;">
                                            <div class="progress-bar bg-teal" style="width: {{ $expenseType->percent }}%" aria-valuenow="{{ $expenseType->percent }}" aria-valuemin="0" aria-valuemax="100">{{ $expenseType->percent }}% complete</div>
                                        </div>
                                    @elseif ($expenseType->remaining == 0 && $expenseType->exced_amount == 0)
                                        <div class="progress" style="margin-top: 10px;">
                                            <div class="progress-bar bg-teal" style="width: {{ $expenseType->percent }}%" aria-valuenow="{{ $expenseType->percent }}" aria-valuemin="0" aria-valuemax="100">{{ $expenseType->percent }}% complete</div>
                                        </div>
                                    @else
                                        {{ __('budget.text.remaining') }} :
                                        <b class="text-primary">0 {{ auth()->user()->currency }}</b>
                                        <div class="progress" style="margin-top: 10px;">
                                            <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                Limit exceeded {{ $expenseType->exced_amount }} {{ auth()->user()->currency }}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    {{ __('budget.text.spent') }} : <span class="text-danger">{{ $expenseType->spent == null ? 0 : $expenseType->spent }} {{ auth()->user()->currency }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </button>
            </h2>

            <div id="flush_item{{ $expenseType->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
                <div class="accordion-body">
                    <div class="col-md-12 text-center">

                        <span class="badge border border-teal text-teal rounded-pill m-auto">
                            @if ($expenseType->budget)
                                <a href="{{ route('budget.edit', $expenseType->budget_id) }}" class="m-2 text-primary transaction-btn" data-title="{{ __('budget.btn.edit-budget') }}" title="{{ __('budget.btn.edit-budget') }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="form-id{{ $expenseType->budget_id }}"
                                    action="{{ route('budget.destroy', $expenseType->budget_id) }}"
                                    method="POST" style="display: inline-block;">
                                  @method('DELETE')
                                  @csrf
                                  <a href="#" class="delete-btn text-danger m-2"
                                     onclick="deleteData(this)"
                                     data-form-id="{{ 'form-id' . $expenseType->budget_id }}"
                                     title="{{ __('budget.btn.delete-budget') }}">
                                      <i class="fas fa-trash"></i>
                                  </a>
                              </form>
                            @else
                                <a href="{{ route('budget.create', [$expenseType->id, $month, $year]) }}" class="m-2 text-success transaction-btn" data-title="{{ __('budget.btn.create-budget') }}" title="{{ __('budget.btn.create-budget') }}">
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
