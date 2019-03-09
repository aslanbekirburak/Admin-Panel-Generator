
    function imageCropSetting(imgSecici,inptSecici) {
        var $image = $(imgSecici);
        

        var $inputImage = $(inptSecici);

        if (window.FileReader) {
            $inputImage.change(function () {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }

                file = files[0];

                $("#ImageDataName").val(file.name);

                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $image.cropper("reset", true).cropper("replace", this.result);
                        $inputImage.val("");
                    };
                } else {
                    showMessage("Please choose an image file.");
                }
            });
        } else {
            $inputImage.parent().remove();
        }

        var $zoomWith = $("#zoomWith");


        $("#zoom").click(function () {
            $image.cropper("zoom", $zoomWith.val());
        });


        var $rotateWith = $("#rotateWith");

        $("#rotate").click(function () {
            $image.cropper("rotate", $rotateWith.val());
        });
    }
