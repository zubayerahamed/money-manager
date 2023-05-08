<form id="transaction-form" action="{{ $dream->id == null ? route('dream.store') : route('dream.update', $dream->id) }}" method="POST">
    @csrf
    @if ($dream->id != null)
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label class="form-label">Title:</label>
        <div class="form-group">
            <input type="text" name="name" class="form-control" value="{{ $dream->name }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Amount Needed:</label>
        <div class="form-group">
            <input type="number" name="amount_needed" class="form-control" value="{{ $dream->amount_needed }}" min="0" step="any" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Target Year:</label>
        <div class="form-group">
            <input type="number" name="target_year" class="form-control" min="1900" max="2099" step="1" value="{{ $dream->target_year == null ? date('Y') : $dream->target_year }}" required />
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Account Wallet:</label>
        <div class="input-group">
            <select class="form-control" name="wallet_id">
                <option value="">-- Select Wallet --</option>
                @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ $dream->wallet_id == $wallet->id ? 'selected' : '' }}>{{ $wallet->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('wallet.create') }}" class="btn btn-light transaction-btn" data-title="Add wallet" type="button"><i class="fas fa-plus"></i></a>
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Note:</label>
        <div class="form-group">
            <textarea rows="3" cols="3" class="form-control" name="note">{{ $dream->note }}</textarea>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary transaction-submit-btn">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
    </div>
</form>
