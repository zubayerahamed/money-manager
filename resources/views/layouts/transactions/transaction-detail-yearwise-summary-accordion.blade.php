@foreach ($thDetails as $key => $val)
    <div class="card">

        <div class="card-header">
            <div class="col-md-10 float-start">
                <h5 class="mb-0">{{ $key }}</h5>
            </div>
            <div class="col-md-2 float-end text-end">
                <span style="color: green; font-weight: bold">{{ $val['income'] }}</span>
                @if ($val['income'] != '' && $val['expense'] != '')
                    <span style="color: rgb(9, 31, 238); font-weight: bold">/</span>
                @endif
                <span style="color: red; font-weight: bold">{{ $val['expense'] }}</span>
            </div>
        </div>

        <div class="accordion accordion-flush" id="accordion_flush">
            @foreach ($val['data'] as $mkey => $mval)
                <div class="accordion-item">

                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_item{{ $key . '-' . $mkey }}">
                            <span>{!! $mkey . '&nbsp; ' !!}</span>
                            <span class="text-success"><b>{!! $mval['income'] . '&nbsp;' !!}</span>
                            <span><b>/</span>
                            <span class="text-danger"><b>{{ $mval['expense'] }}</span>
                        </button>
                    </h2>

                </div>
            @endforeach
        </div>

    </div>
@endforeach
