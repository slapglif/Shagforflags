// set variables
var $modal = $("#crop-modal"),
    originalData = {},
    isMediaUploaded = false;

if(dropclick == false) {
    // DropZone Settings
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file",
        maxFilesize: 5,
        maxFiles: 1,
        previewsContainer: '',
        clickable: '.profile-img-btn-photo',
        acceptedFiles: ".jpg, .jpeg, .png",
        dictInvalidFileType: "Invalid file type. Please upload images only.",
        dictFileTooBig: "The file should not exceed 5MB.",
        dictMaxFilesExceeded: "Only 1 image can be added.",
        dictResponseError: "Something went wrong. Please contact our team!",

        accept: function (file, done) {
            $("html, body").animate({
                scrollTop: 0
            }, "fast", function(){
                $('#loading_spinner').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });

            done();
        },

        success: function (file, response) {
            if(file.status == "success" && response != "") {
                $('#loading_spinner').modal('hide');

                $("#cropper_done").attr('disabled', false);

                // Import src to img
                $(".bootstrap-modal-cropper").html('<img src="/build/files/upload/user/' + response + '">');

                // show the modal
                $("#crop-modal").modal("show");
            }else {
                alert("Something went wrong. Please contact our team!");
            }
        },

        error: function (file, response) {
            $("#dz-warning").css("display", "block");
            $("#dz-warning #dz-warning-message").html(response);
        }
    };
}

// after modal shown
$modal.on("show.bs.modal", function () {
    $modal.find(".bootstrap-modal-cropper img").cropper({
        aspectRatio: 1,
        multiple: true,
        resizable: true,
        minWidth: 265,
        minHeight: 265,
        data: originalData,
        autoCrop: true,
        checkOrientation: true,
        rotatable: true,
        scalable: true,
        zoomable: false,
        done: function (data) {
            $(".cropper-modal").css({opacity: 0.9});
            $("#crop_x").html(data.x);
            $("#crop_y").html(data.y);
            $("#crop_size").html(data.width);
        }
    });
}).on("hidden.bs.modal", function () {
    if (!isMediaUploaded) {
        var file_name = $modal.find(".bootstrap-modal-cropper img").attr("src");
        jQuery.post("/media/unlink", {file_name: file_name}, function (data) {
            if(data == 1) {
                location.reload();
            }else {
                location.reload();
            }
        });
    }
});

jQuery("#cropper_done").click(function () {
    // set button as loading
    $("#cropper_done").attr('disabled', 'disabled').html("Loading...");

    var x = jQuery("#crop_x").html();
    var y = jQuery("#crop_y").html();
    var size = jQuery("#crop_size").html();
    var file_name = $modal.find(".bootstrap-modal-cropper img").attr("src");

    var thumbs = [];
    thumbs.push('265');

    var params = {
        ratio: 1,
        file_name: file_name,
        x: x,
        y: y,
        size: size,
        upload_type: 'logo',
        status: 'active',
        thumbs: thumbs
    }

    jQuery.post("/media/crop-photo", params, function (data) {
        location.reload();
    });
});

jQuery(function () {
    jQuery(".profile-img-btn-delete").click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, "slow", function(){
            alertify.confirm(
                'Delete your profile photo',
                'Are you sure you want to delete your profile photo?',
                function () {
                    jQuery.post('/media/unlink', {file_name: user_photo}, function (res) {
                        if (res == "1") {
                            location.reload();
                        }
                    });
                }, function () {}
            ).set({
                'labels': {ok:'Delete', cancel:'Cancel'}
            });

            $('.alertify').appendTo(".site-wrap");
        });

        return false;
    });
});