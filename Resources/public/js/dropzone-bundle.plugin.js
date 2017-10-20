(function ($) {


    $.fn.dropzoneBundle = function (options) {


        var that = $(this);


        $('.dropzonez', this).dropzone({
            url: options['url'],
            autoDiscover: false,
            acceptedFiles: options['acceptedFiles'],
            maxFiles: 1,
            addRemoveLinks: true,
            maxFilesize: options['maxFilesize'],
            dictDefaultMessage: options['dictDefaultMessage'],
            dictFallbackMessage: options['dictFallbackMessage'],
            dictInvalidFileType: options['dictInvalidFileType'],
            dictFileTooBig: options['dictFileTooBig'],
            dictResponseError: options['dictResponseError'],
            dictCancelUpload: options['dictCancelUpload'],
            dictCancelUploadConfirmation: options['dictCancelUploadConfirmation'],
            dictRemoveFile: options['dictRemoveFile'],
            dictMaxFilesExceeded: options['dictMaxFilesExceeded'],

            init: function () {

                if ($(".dropzoneBundle-area-field", that).val() != "") {
                    $('.dropzone-container', that).hide();
                }


                this.on("success", function (file) {
                    $('.dropzone-container', that).hide();
                    console.log('success' + file);
                    $(".errors", that).html('');
                    $(".current-file", that).html(file.previewElement);
                });

                this.on("error", function (file, error) {
                    // $(".dropzoneBundle-area-field", this).val('');
                    $(".current-file", that).html('<div  class="alert alert-dismissable alert-danger m-xs ml-n  mr-n">' + error + '</div>');
                    // this.removeFile(file);
                    $(this).show();
                });

                this.on("sending", function (file, xhr, formData) {

                    $(".errors", that).html('');

                    var directory = options['directory'];

                    var name = directory + new Date().getTime() + "_" + file.name.toLowerCase().replace(/ +/g, '-');

                    formData.append("AWSAccessKeyId", options['accessKey']);

                    formData.append("acl", options['acl']);
                    formData.append("success_action_status", options['successStatus']);
                    formData.append("policy", options['policy']);
                    formData.append("signature", options['signature']);
                    formData.append("key", name);
                    console.log('name' + name);
                    console.log($(".dropzoneBundle-area-field", that));

                    $(".dropzoneBundle-area-field", that).val(options['url'] + '/' + name);
                });

                this.on("removedfile", function (file) {
                    $(".dropzoneBundle-area-field", that).val('');
                    $('.dropzone-container', that).show();
                    $(".current-file", that).html('');
                });


                console.log();


                if ($(".dz-preset-field-remove", that).length != 0) {
                    $(".dz-preset-field-remove", that).click(function (e) {
                        $(".dropzoneBundle-area-field", that).val('');
                        $('.dropzone-container', that).show();
                        $(".current-file", that).html('');
                    })
                }

                //

            }
        });

        // function removeFile(){
        //     console.log($(this),'pippo');
        //     $(".current-file", this).html('');
        //     $(".dropzoneBundle-area-field", this).val('');
        //     $('.dropzone-container', this).show();
        // }


    };

}(jQuery));