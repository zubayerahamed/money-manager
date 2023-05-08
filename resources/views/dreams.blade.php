<x-layout pageTitle="Dreams">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header">
                        <div class="col-md-6 float-start text-start">
                            <h5 class="mb-0">Dreams</h5>
                        </div>

                        <div class="col-md-6 float-end text-end">
                            <a href="{{ route('dream.create') }}" class="btn btn-success btn-sm transaction-btn" data-title="Create Dream">
                                <i class="fas fa-plus"></i>
                                <div class="d-none d-md-block ms-1">Create dream</div>
                            </a>
                        </div>
                    </div>

                    <div class="accordion accordion-flush dreams-accordion" id="accordion_flush">
                        @include('layouts.dreams.dreams-accordion')
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
</x-layout>
