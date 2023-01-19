<x-layout>

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Total Income</h5>

                        <div class="d-inline-flex ms-auto">
                            <a href="#" class="btn btn-indigo">20,000 TK</a>
                            <a href="/income-source" class="btn btn-success" style="margin-left: 10px;">Create Income Source</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="pie_donut"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <tbody>

                                @foreach ($incomeSources as $incomeSource)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="d-block me-3">
                                                    <i class="{{ $incomeSource->icon }} fa-2x"></i>
                                                </a>
                                                <div>
                                                    <a href="#" class="text-body fw-semibold">{{ $incomeSource->name }}</a>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $incomeSource->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">Total Income <br /> 5000 TK</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="/income-source/{{ $incomeSource->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="/income-source/{{ $incomeSource->id }}/delete" style="display: inline-block" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-labeled btn-labeled-start btn-sm">
                                                    <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-trash ph-sm"></i> </span> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->
</x-layout>
