@foreach ($thDetails as $key => $val)
    <div class="card">

        <div class="card-header">
            <div class="col-md-10 float-start">
                <h5 class="mb-0">{{ $key }}</h5>
            </div>
            <div class="col-md-2 float-end text-end">
                <span style="color: green; font-weight: bold">{{ $val['income'] }}</span>
                <span style="color: rgb(9, 31, 238); font-weight: bold">/</span>
                <span style="color: red; font-weight: bold">{{ $val['expense'] }}</span>
            </div>
        </div>

        <div class="accordion accordion-flush" id="accordion_flush">
            @foreach ($val['data'] as $trn)
                <div class="accordion-item">

                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $trn->id }}">
                            @if ($trn->transaction_type == 'INCOME')
                                <span class="text-success"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.income.from') }} <b style="text-transform: uppercase;">{{ $trn->incomeSource->name }}</b></span>
                            @elseif ($trn->transaction_type == 'EXPENSE')
                                <span class="text-danger"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.expense.for') }} <b style="text-transform: uppercase;">{{ $trn->expenseType->name }}</b></span>
                            @else
                                <span class="text-primary"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.transfer.from') }} <b style="text-transform: uppercase;">{{ $trn->fromWallet->name }}</b> to <b style="text-transform: uppercase;">{{ $trn->toWallet->name }}</b></span>
                            @endif
                        </button>
                    </h2>

                    <div id="flush_item{{ $trn->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
                        <div class="accordion-body">

                            @if ($trn->note != '')
                                <div class="col-md-12 text-center mb-2">
                                    <span class="fw-semibold">{{ $trn->note }}</span>
                                </div>
                            @endif

                            <div class="col-md-12 text-center">
                                <span class="badge border border-teal text-teal rounded-pill m-auto">
                                    <a href="{{ route('tracking.edit', $trn->id) }}" class="m-2 text-primary transaction-btn" title="Edit" data-title="{{ __('transaction.btn.edit-transaction') }}" title="{{ __('transaction.btn.edit-transaction') }}">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <form id="form-id{{ $trn->id }}"
                                          action="{{ route('tracking.destroy', $trn->id) }}"
                                          method="POST" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <a href="#" class="delete-btn text-danger m-2"
                                           onclick="deleteData(this)"
                                           data-form-id="{{ 'form-id' . $trn->id }}"
                                           title="{{ __('transaction.btn.delete-transaction') }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </form>
                                </span>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@endforeach
