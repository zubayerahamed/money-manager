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
                            <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> <span>{{ $wallet->currentBalance }} TK</span>
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
                        <a href="{{ url('/wallet') . '/' . $wallet->id }}/saving }}" class="btn-saving m-2 text-success" data-wallet-id="{{ $wallet->id }}" data-wallet-name="{{ $wallet->name }}" data-wallet-amount="{{ $wallet->currentBalance }}" title="Do Saving">
                            <i class="far fa-save"></i>
                        </a>
                        <a href="{{ url('/wallet') . '/' . $wallet->id }}/edit" class="m-2 text-primary wallet-edit-btn" data-title="Edit wallet">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ url('/wallet') . '/' . $wallet->id }}/delete" style="display: inline-block" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="" class="m-2 text-danger"><i class="fas fa-trash"></i></a>
                        </form>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endforeach