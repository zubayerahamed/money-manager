<x-layout pageTitle="Update Wallet">




    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Wallet</h5>

                                <div class="d-inline-flex ms-auto">
                                    <a href="{{ url('/wallet/all') }}" class="btn btn-primary" style="margin-left: 10px;">
                                        Back To Wallet Lists
                                    </a>
                                    <a href="{{ url('/wallet') }}" class="btn btn-success" style="margin-left: 10px;">Create Wallet</a>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/wallet') . '/' . $wallet->id }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    @if ($wallet->icon)
                                        <i class="{{ $wallet->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>
                                    @endif

                                    <div class="row mb-3">
                                        <label class="form-label">Icon:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="icon" id="icon" value="{{ old('icon', $wallet->icon) }}" readonly>
                                            <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Choose</button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Wallet name:</label>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $wallet->name) }}">
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Current Balance:</label>
                                        <div class="form-group">
                                            <input type="text" name="current_balance" class="form-control" value="{{ old('current_balance', $wallet->currentBalance) }}" readonly disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <div class="form-group">
                                            <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note', $wallet->note) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /centered card -->

                <!-- /marketing campaigns -->

            </div>
        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->



    @include('icon-modal');

</x-layout>
