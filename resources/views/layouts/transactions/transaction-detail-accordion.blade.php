@if (count($thDetails) == 0)
    <h2 class="text-center m-0">Transactions are not available</h2>
@endif
@foreach ($thDetails as $key => $val)
    <div class="card">

        <div class="card-header">
            <div class="col-md-10 float-start">
                <h5 class="mb-0">{{ $key }}</h5>
            </div>
            <div class="col-md-2 float-end text-end">
                <span style="color: green; font-weight: bold">{{ $val['income'] }}</span>
                @if ($val['income'] != '' && $val['expense'] != '')
                    <span style="color: rgb(9, 31, 238); font-weight: bold">/</span>
                @endif
                <span style="color: red; font-weight: bold">{{ $val['expense'] }}</span>
            </div>
        </div>

        <div class="accordion accordion-flush" id="accordion_flush_detail">
            @foreach ($val['data'] as $trn)
                <div class="accordion-item">

                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $trn->id }}">
                            <div class="row">
                                <div class="d-flex flex-column">
                                    @if ($trn->transaction_type == 'OPENING')
                                        <span class="text-muted">Create Wallet <b>{{ $trn->toWallet->name }}</b> with opening balance <b>{{ $trn->amount }} {{ auth()->user()->currency }}</b></span>
                                        @if ($val['expense'] == '')
                                            <span>{!! '(' . $trn->transaction_date . ')' !!}</span>
                                        @endif
                                    @elseif ($trn->transaction_type == 'INCOME')
                                        <span class="text-success"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.income.from') }} <b style="text-transform: uppercase;">{{ $trn->incomeSource->name }}</b></span>
                                        <i style="color: #2b2b2b; font-size: 11px;">Added to wallet <b style="text-transform: uppercase;">{{ $trn->toWallet->name }}</b></i>
                                        @if ($val['expense'] == '')
                                            <span>{!! '(' . $trn->transaction_date . ')' !!}</span>
                                        @endif
                                    @elseif ($trn->transaction_type == 'LOAN')
                                        <span class="text-warning"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.loan.from') }} <b style="text-transform: uppercase;">{{ $trn->incomeSource->name }}</b></span>
                                        @if ($val['expense'] == '')
                                            <span>{!! '(' . $trn->transaction_date . ')' !!}</span>
                                        @endif
                                    @elseif ($trn->transaction_type == 'EXPENSE')
                                        <span class="text-danger"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.expense.for') }} <b style="text-transform: uppercase;">{{ $trn->expenseType->name }}</b></span>
                                        <i style="color: #2b2b2b; font-size: 11px;">From wallet <b style="text-transform: uppercase;">{{ $trn->fromWallet->name }}</b></i>
                                        @if ($val['income'] == '')
                                            <span>{!! '(' . $trn->transaction_date . ')' !!}</span>
                                        @endif
                                    @else
                                        <span class="text-primary"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> transfer from wallet <b style="text-transform: uppercase;">{{ $trn->fromWallet->name }}</b> to <b style="text-transform: uppercase;">{{ $trn->toWallet->name }}</b></span>
                                    @endif
                                </div>

                                @if ($trn->note != '')
                                    <div class="row mt-2">
                                        <span class="fw-semibold">{{ $trn->note }}</span>
                                    </div>
                                @endif
                            </div>
                        </button>
                    </h2>

                    @if ($trn->transaction_type != 'OPENING')
                    <div id="flush_item{{ $trn->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush_detail">
                        <div class="accordion-body" style="background-color: #f5f3f3">

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

                            @if (count($trn->details) > 0)
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <ul style="list-style-type: none; padding-left: 0;">
                                            @foreach ($trn->details as $detail)
                                                <li>{{ $detail->subExpenseType->name . ' - '}} <b>{{ $detail->amount . ' ' . auth()->user()->currency }}</b></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
@endforeach
