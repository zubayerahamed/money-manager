<x-layout pageTitle="Profile">
    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="sidebar-section-body text-center" style="padding: 20px;">
                                <div class="card-img-actions d-inline-block mb-3">
                                    <img class="img-fluid rounded-circle" src="{{ auth()->user()->avatar }}" width="150" height="150" alt="">
                                    <div class="card-img-actions-overlay card-img rounded-circle">
                                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                                        <a href="#" class="btn btn-outline-white btn-icon rounded-pill" id="avatar-upload">
                                            <i class="ph-pencil"></i>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="mb-0">{{ $user->name }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Profile</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/profile') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <label class="form-label">Name:</label>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Password</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/profile/password') }}" method="POST">
                                    @csrf
                                    
                                    <div class="row mb-3">
                                        <label class="form-label">Password:</label>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" required>
                                            @error('password')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Confirm Password:</label>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                            @error('password_confirmation')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
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

        $('#avatar-upload').off('click').on('click', function(e){
            e.preventDefault();
            $("#avatar:hidden").trigger('click');
        });

        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", "#avatar", function(e){
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
                        url: $('.basePath').attr('href') + "/profile/avatar",
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