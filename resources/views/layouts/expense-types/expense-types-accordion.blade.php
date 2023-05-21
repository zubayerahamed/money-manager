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
                            <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> <span>{{ $expenseType->totalExpense == null ? 0 : $expenseType->totalExpense }} {{ auth()->user()->currency }}</span>
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

                </div>
            </div>
        </div>

    </div>
@endforeach
