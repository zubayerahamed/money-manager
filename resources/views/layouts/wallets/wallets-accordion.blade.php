@foreach ($wallets as $wallet)
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $wallet->id }}">
                <div class="d-flex align-items-center">

                    <div style="width: 70px; text-align: center;">
                        <i class="{{ $wallet->icon }} fa-2x me-3"></i>
                    </div>

                    <div>
                        <div style="text-transform: uppercase; font-weight: bold;">{{ $wallet->name }}</div>
                        <div class="text-muted fs-sm">
                            <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> <span>{{ $wallet->currentBalance == null ? 0 : $wallet->currentBalance }} {{ auth()->user()->currency }}</span>
                        </div>
                    </div>

                </div>
            </button>
        </h2>

        <div id="flush_item{{ $wallet->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
            <div class="accordion-body">
                <div class="col-md-12 text-center">

                    @if ($wallet->note != '')
                        <div class="col-md-12 text-center mb-2">
                            <span class="fw-semibold">{{ $wallet->note }}</span>
                        </div>
                    @endif

                    <span class="badge border border-teal text-teal rounded-pill m-auto">
                        <a href="{{ route('wallet.edit', $wallet->id) }}" class="m-2 text-primary transaction-btn" data-title="{{ __('wallet.btn.edit-wallet') }}" title="{{ __('wallet.btn.edit-wallet') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="form-id{{ $wallet->id }}"
                              action="{{ route('wallet.destroy', $wallet->id) }}"
                              method="POST" style="display: inline-block;">
                            @method('DELETE')
                            @csrf
                            <a href="#" class="delete-btn text-danger m-2"
                               onclick="deleteData(this)"
                               data-form-id="{{ 'form-id' . $wallet->id }}"
                               title="{{ __('wallet.btn.delete-wallet') }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </span>

                </div>
            </div>
        </div>

    </div>
@endforeach
