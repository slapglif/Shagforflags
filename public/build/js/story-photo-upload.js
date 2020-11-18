var fileList = {};
var z = 0;
Dropzone.options.myAwesomeDropzone = {
    paramName: "file",
    maxFilesize: 5,
    uploadMultiple: false,
    autoProcessQueue: true,
    parallelUploads: 1,
    acceptedFiles: ".jpg, .jpeg, .png",
    addRemoveLinks: true,
    autoDiscover: false,
    dictDefaultMessage: "Drop images here to upload",
    dictInvalidFileType: "Invalid file type. Please upload images only.",
    dictFileTooBig: "The file should not exceed 5MB.",
    dictMaxFilesExceeded: "Only 1 image can be added.",
    dictResponseError: "Something went wrong. Please contact our team!",

    init: function() {
        this.on("removedfile", function(file) {
            var rmvFile = "";

            if (file.myCustomName && file.myCustomName == "withoutupload") {
                //console.log("do not unlink");
            }else {
                $.each(fileList, function(key,valueObj){
                    if(valueObj.fileName == file.name) {
                        rmvFile = rmvFile + valueObj.serverFileName;
                        delete fileList[key];
                    }
                });

                if (rmvFile){
                    jQuery.post('/media/unlink-story', {file_name: rmvFile}, function (res) {
                        if (res == "1") {}
                    });
                }
            }
        });

        this.on("addedfile", function(file) {
            if (this.files.length) {
                var _i, _len;
                for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
                {
                    if(this.files[_i].name === file.name && this.files[_i].size === file.size)
                    {
                        file.myCustomName = "withoutupload";
                        this.removeFile(file);
                        this.remove
                    }
                }
            }
        });

        this.on("success", function(file, serverFileName) {
            fileList[z] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": z};
            z++;
        });
    },

    accept: function (file, done) {
        done();
    },
    error: function (file, response) {
        alert("Something went wrong. Please contact our team!");
    }
};