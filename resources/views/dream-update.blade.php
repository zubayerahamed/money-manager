<x-layout pageTitle="Create Wallet">


    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Edit Dream</h5>
        
                                <div class="d-inline-flex ms-auto">
                                    <a href="{{ url('/dream/all') }}" class="btn btn-success" style="margin-left: 10px;">
                                        Back To Dreams List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/dream/'.$dream->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    <div class="row mb-3">
                                        <label class="form-label">Dream Name:</label>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $dream->name) }}" required>
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>    
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Amount Needed:</label>
                                        <div class="form-group">
                                            <input type="number" name="amount_needed" class="form-control" value="{{ old('amount_needed', $dream->amount_needed) }}" min="0" step="any" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Target Year:</label>
                                        <div class="form-group">
                                            <input type="number" name="target_year" class="form-control" min="1900" max="2099" step="1" value="{{ old('target_year', $dream->target_year) }}" required/>
                                            @error('target_year')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <div class="form-group">
                                            <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note', $dream->note) }}</textarea>
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

</x-layout>
