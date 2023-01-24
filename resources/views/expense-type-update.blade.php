<x-layout>




    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Expense Type</h5>
        
                                <div class="d-inline-flex ms-auto">
                                    <a href="/expense-type/all" class="btn btn-primary" style="margin-left: 10px;">
                                        Back To Expense Types List
                                    </a>
                                    <a href="/expense-type" class="btn btn-success" style="margin-left: 10px;">Create Expense Type</a>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <form action="/expense-type/{{ $expenseType->id }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    @if ($expenseType->icon)
                                        <i class="{{ $expenseType->icon }} fa-2x" id="replacable-icon" style="padding: 10px; border: 1px solid #000; border-radius: 5px; margin-bottom: 10px;"></i>
                                    @endif

                                    <div class="row mb-3">
                                        <label class="form-label">Icon:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="icon" id="icon" value="{{ old('icon', $expenseType->icon) }}" readonly>
                                            <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Choose</button>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="form-label">Expense Type Name:</label>
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $expenseType->name ) }}">
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>    
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <div class="input-group">
                                            <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note', $expenseType->note) }}</textarea>
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
