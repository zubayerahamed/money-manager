$(document).ready(function(){
    $('body').on('click', '.avatar-upload', function(e) {
        e.preventDefault();
        $(this).siblings(".avatar-image:hidden").trigger('click');
        submitUrl = $(this).attr('href');
    });
    
    var $modal = $('#avatar-modal');
    var image = document.getElementById('image');
    var cropper;
    var submitUrl;
    
    $("body").on("change", ".avatar-image", function(e) {
    
        var files = e.target.files;
        var done = function(url) {
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
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    
    // Init cropper js when modal show and destroy cropper js when modal hide
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    
    
    $('.crop-cancel').off('click').on('click', function() {
        $modal.modal('hide');
    });
    
    $("#crop").click(function() {
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
                loadingMask2.show();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: submitUrl,
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data
                    },
                    success: function(data) {
                        loadingMask2.hide();
                        showMessage(data.status, data.message, data.reload);
                        if (data.status == 'success') {
                            $modal.modal('hide');
                        }
                        if (data.reload == true) {
                            if (data.sections.length > 0) {
                                $.each(data.sections, function(ind, section) {
                                    sectionReloadAjaxReq(section);
                                });
                            } else {
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        }
                    },
                    error: function(jqXHR, status, errorThrown) {
                        loadingMask2.hide();
                        showMessage("error", jqXHR.responseJSON.message);
                    }
                });
            }
        });
    });
})