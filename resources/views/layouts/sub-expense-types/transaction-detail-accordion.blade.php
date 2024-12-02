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
                <span style="color: red; font-weight: bold">{{ $val['expense'] }}</span>
            </div>
        </div>

        <div class="accordion accordion-flush" id="accordion_flush_detail">
            @foreach ($val['data'] as $trn)
                <div class="accordion-item">

                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item_detail_{{ $trn->id }}">
                            <div class="row">
                                <div class="d-flex">

                                    <span class="text-danger"><b>{{ $trn->amount }} {{ auth()->user()->currency }}</b> {{ __('transaction.details.expense.for') }} <b style="text-transform: uppercase;">{{ $trn->subExpenseType->name }}</b></span>
                                    @if ($val['income'] == '')
                                        <span>{!! '&nbsp; (' . $trn->transaction_date . ')' !!}</span>
                                    @endif

                                </div>
                            </div>
                        </button>
                    </h2>


                    <div id="flush_item_detail_{{ $trn->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush_detail">
                        <div class="accordion-body">

                            <div class="col-md-12 text-center">
                                <span class="badge border border-teal text-teal rounded-pill m-auto">
                                    <a href="{{ route('tracking.edit', $trn->tracking_history_id) }}" class="m-2 text-primary transaction-btn" title="Edit" data-title="{{ __('transaction.btn.edit-transaction') }}" title="{{ __('transaction.btn.edit-transaction') }}">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <form id="form-id{{ $trn->id }}"
                                          action="{{ route('tracking.destroy', $trn->tracking_history_id) }}"
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
