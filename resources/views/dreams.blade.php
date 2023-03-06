<x-layout pageTitle="Wallets Status">

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Dreams</h5>

                        <div class="d-inline-flex ms-auto">
                            <a href="{{ url('/dream')  }}" class="btn btn-success" style="margin-left: 10px;">Create Dream</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Dream</th>
                                    <th class="text-center">Target Year</th>
                                    <th class="text-center">Amount Needed</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($dreams as $dream)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="card-img-actions d-inline-block mb-3" style="margin-right: 10px;">
                                                    <img class="img-fluid" src="{{ $dream->image }}" width="150" height="150" alt="">
                                                    <div class="card-img-actions-overlay card-img">
                                                        <input type="file" name="image" class="form-control dream-image" id="{{ $dream->id }}" accept="image/*">
                                                        <a href="#" class="btn btn-outline-white btn-icon rounded-pill avatar-upload">
                                                            <i class="ph-pencil"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div style="text-transform: uppercase; font-weight: bold;">{{ $dream->name }}</div>
                                                    <div class="text-muted fs-sm">
                                                        <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span> Created on : {{ $dream->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                    @if ($totalSavingAmount > 0)
                                                        <div class="progress" style="margin-top: 10px;">
                                                            @if ($totalSavingAmount > $dream->amount_needed)
                                                                <div class="progress-bar bg-teal" style="width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100% complete</div>
                                                            @else 
                                                                <div class="progress-bar bg-teal" style="width: {{ round((100 * $totalSavingAmount) / $dream->amount_needed, 2) }}%" aria-valuenow="{{ round((100 * $totalSavingAmount) / $dream->amount_needed, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round((100 * $totalSavingAmount) / $dream->amount_needed, 2) }}% complete</div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-center">{{ $dream->target_year }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-center">{{ $dream->amount_needed }}</h6>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ url('/dream').'/'.$dream->id }}/edit" class="btn btn-primary btn-labeled btn-labeled-start btn-sm" title="Edit">
                                                <span class="btn-labeled-icon bg-black bg-opacity-20"> <i class="ph-pencil ph-sm"></i> </span> Edit
                                            </a>
                                            <form action="{{ url('/dream').'/'.$dream->id }}/delete" style="display: inline-block" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-labeled btn-labeled-start btn-sm" title="Delete">
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
    

    <div id="modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Crop & Resize your avatar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body">
					<div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="{{ auth()->user()->avatar }}">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger crop-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
				</div>
			</div>
		</div>
    </div>

    <script>

        $('.avatar-upload').off('click').on('click', function(e){
            e.preventDefault();
            $(this).siblings(".dream-image:hidden").trigger('click');
        });

        var dreamId;
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", ".dream-image", function(e){

            dreamId = e.target.id;
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        // Init cropper js when modal show and destroy cropper js when modal hide
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });


        $('.crop-cancel').off('click').on('click', function(){
            $modal.modal('hide');
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result; 
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: $('.basePath').attr('href') + "/dream/image/" + dreamId,
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                        success: function(data){
                            $modal.modal('hide');
                            location.reload();
                        }
                    });
                }
            });
        });

    </script>

</x-layout>
