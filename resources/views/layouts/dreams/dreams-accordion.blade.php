@foreach ($dreams as $dream)
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $dream->id }}">
                <div class="d-flex align-items-center">

                    <div class="me-2">
                        <img class="img-fluid" src="{{ $dream->image }}" width="80" height="80" alt="">
                    </div>

                    <div>
                        <div style="text-transform: uppercase; font-weight: bold;">{{ $dream->name }}</div>
                        <div class="text-muted fs-sm">
                            <p class="m-0">{{ __('dream.text.value') }} : {{ $dream->amount_needed }} {{ auth()->user()->currency }}</p>
                            @if ($dream->amount_needed > 0 && $dream->wallet != null)
                                <p class="m-0">{{ __('dream.text.achieved') }} : {{ $dream->amount_needed <= $dream->wallet->currentBalance ? '' : $dream->wallet->currentBalance . auth()->user()->currency }} ({{ $dream->amount_needed <= $dream->wallet->currentBalance ? '100%' : round((100 * $dream->wallet->currentBalance) / $dream->amount_needed, 2) . '%' }})</p>
                            @endif
                            <p class="m-0">{{ __('dream.text.target') }} : {{ $dream->target_year }}</p>
                        </div>
                    </div>

                </div>
            </button>
        </h2>

        <div id="flush_item{{ $dream->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion_flush">
            <div class="accordion-body">
                <div class="col-md-12 text-center">

                    @if ($dream->note != '')
                        <div class="col-md-12 text-center mb-2">
                            <span class="fw-semibold">{{ $dream->note }}</span>
                        </div>
                    @endif

                    <span class="badge border border-teal text-teal rounded-pill m-auto">
                        <input type="file" name="image" class="form-control avatar-image" id="{{ $dream->id }}" accept="image/*">

                        <a href="{{ route('dream.image', $dream->id) }}" class="m-2 text-primary avatar-upload" title="{{ __('dream.btn.edit-image') }}">
                            <i class="fas fa-images"></i>
                        </a>

                        <a href="{{ route('dream.edit', $dream->id) }}" class="m-2 text-primary transaction-btn" data-title="{{ __('dream.btn.edit-dream') }}" title="{{ __('dream.btn.edit-dream') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form id="form-id{{ $dream->id }}"
                              action="{{ route('dream.destroy', $dream->id) }}"
                              method="POST" style="display: inline-block;">
                            @method('DELETE')
                            @csrf
                            <a href="#" class="delete-btn text-danger m-2"
                               onclick="deleteData(this)"
                               data-form-id="{{ 'form-id' . $dream->id }}"
                               title="{{ __('dream.btn.delete-dream') }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </span>

                </div>
            </div>
        </div>

    </div>
@endforeach
