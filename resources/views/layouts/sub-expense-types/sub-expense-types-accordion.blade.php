@if (!$expenseType->subExpenseTypes->isEmpty())
    <div class="col-md-12 mt-2 mb-2">
        <div class="table-responsive">
            <table class="table table-stripped no-wrap" style="text-wrap-mode: nowrap;">
                <tbody>
                    @foreach ($expenseType->subExpenseTypes as $subExpenseType)
                        <tr>
                            <td style="width: 15px; text-align: left;">
                                <form id="form-id-sub{{ $subExpenseType->id }}"
                                      action="{{ route('sub-expense-type.destroy', ['expense_type_id' => $expenseType->id, 'id' => $subExpenseType->id]) }}"
                                      method="POST" style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <a href="#" class="delete-btn text-danger m-2 text-sm"
                                       onclick="deleteData(this)"
                                       data-form-id="{{ 'form-id-sub' . $subExpenseType->id }}"
                                       title="Delete sub expense type">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                </form>
                            </td>
                            <td style="text-align: left; font-weight: bold">
                                <a href="{{ route('sub-expense-type.edit', ['expense_type_id' => $subExpenseType->expense_type_id, 'id' => $subExpenseType->id]) }}"
                                   class="transaction-btn {{ $subExpenseType->active ? 'text-success' : 'text-danger' }}"
                                   title="Edit Sub Expense Type"
                                   data-title="Edit Sub Expense Type">
                                    <span>
                                        {{ $subExpenseType->name }}
                                    </span>
                                    <div class="text-muted fs-sm">
                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> <span>{{ $subExpenseType->totalExpense == null ? 0 : $subExpenseType->totalExpense }} {{ auth()->user()->currency }}</span>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
