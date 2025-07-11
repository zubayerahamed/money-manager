@foreach ($incomeSources as $incomeSource)
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $incomeSource->id }}">
                <div class="d-flex align-items-center">

                    <div style="width: 70px; text-align: center;">
                        <i class="{{ $incomeSource->icon }} fa-2x me-3"></i>
                    </div>

                    <div>
                        <div style="text-transform: uppercase; font-weight: bold;">{{ $incomeSource->name }}</div>
                        <div class="text-muted fs-sm">
                            <span class="d-inline-block bg-success rounded-pill p-1 me-1"></span> <span>{{ $incomeSource->totalIncome == null ? 0 : $incomeSource->totalIncome }} {{ auth()->user()->currency }}</span>
                            &nbsp; | &nbsp;
                            <span class="d-inline-block bg-warning rounded-pill p-1 me-1"></span> <span>{{ $incomeSource->totalLoan == null ? 0 : $incomeSource->totalLoan }} {{ auth()->user()->currency }}</span>
                        </div>
                    </div>

                </div>
            </button>
        </h2>

        <div id="flush_item{{ $incomeSource->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
            <div class="accordion-body">
                <div class="col-md-12 text-center">

                    @if ($incomeSource->note != '')
                        <div class="col-md-12 text-center mb-2">
                            <span class="fw-semibold">{{ $incomeSource->note }}</span>
                        </div>
                    @endif

                    <span class="badge border border-teal text-teal rounded-pill m-auto">
                        <a href="{{ route('tracking.monthlygrouped', [$incomeSource->id, 'INCOME']) }}" class="m-2 text-success transaction-btn" title="View Income Details" data-title="Income Details of {{ $incomeSource->name }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('tracking.monthlygrouped', [$incomeSource->id, 'LOAN']) }}" class="m-2 text-warning transaction-btn" title="View Loan Details" data-title="Loan Details of {{ $incomeSource->name }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('income-source.edit', $incomeSource->id) }}" class="m-2 text-primary transaction-btn" title="{{ __('income-source.btn.edit-income-source') }}" data-title="{{ __('income-source.btn.edit-income-source') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="form-id{{ $incomeSource->id }}"
                              action="{{ route('income-source.destroy', $incomeSource->id) }}"
                              method="POST" style="display: inline-block;">
                            @method('DELETE')
                            @csrf
                            <a href="#" class="delete-btn text-danger m-2"
                               onclick="deleteData(this)"
                               data-form-id="{{ 'form-id' . $incomeSource->id }}"
                               title="{{ __('income-source.btn.delete-income-source') }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </span>

                </div>
            </div>
        </div>

    </div>
@endforeach
