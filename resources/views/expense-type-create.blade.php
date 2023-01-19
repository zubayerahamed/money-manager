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
                                <h5 class="mb-0">Create Expense Type</h5>
        
                                <div class="d-inline-flex ms-auto">
                                    <a href="/expense-type/all" class="btn btn-success" style="margin-left: 10px;">
                                        Back To Expense Types List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <form action="/expense-type" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <label class="form-label">Expense Type Name:</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>    
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Note:</label>
                                        <textarea rows="3" cols="3" class="form-control" name="note">{{ old('note') }}</textarea>
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



    <!-- /main content -->

</x-layout>
