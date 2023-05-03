<form id="transaction-form" action="{{ $wallet->id == null ? url('/wallet') : url('/wallet') . '/' . $wallet->id }}" method="POST">
    @csrf
    @if ($wallet->id != null)
        @method("PUT")
    @endif

    <i class="{{ $wallet->id == null || $wallet->icon == null ? 'fab fa-korvue' : $wallet->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>

    <div class="row mb-3">
        <label class="form-label">Icon:</label>
        <div class="input-group">
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $wallet->id == null || $wallet->icon == null ? 'fab fa-korvue' : $wallet->icon }}" readonly>
            <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Choose</button>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Wallet name:</label>
        <div class="form-group">
            <input type="text" name="name" class="form-control" value="{{ $wallet->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Current Balance:</label>
        <div class="form-group">
            <input type="number" name="current_balance" class="form-control" value="{{ $wallet->currentBalance }}" min="0" step="any" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Note:</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note">{{ $wallet->note }}</textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
