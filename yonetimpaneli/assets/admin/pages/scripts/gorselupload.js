var GorselUpload = function (urunid) {

    var handleImages = function(urunid) {

        // see http://www.plupload.com/
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',

            browse_button : document.getElementById('tab_images_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('tab_images_uploader_container'), // ... or DOM Element itself

            url : "islemler/galerifotoController.php?q=gorsel_ekle&galeriID="+urunid,

            filters : {
                max_file_size : '2mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },
            resize : {width : 500, height : 665, quality : 90, crop: false},

            // Flash settings
            flash_swf_url : 'assets/global/plugins/plupload/js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : 'assets/global/plugins/plupload/js/Moxie.xap',

            init: {
                PostInit: function() {
                    $('#tab_images_uploader_filelist').html("");

                    $('#tab_images_uploader_uploadfiles').click(function() {
                        uploader.start();
                        return false;
                    });

                    $('#tab_images_uploader_filelist').on('click', '.added-files .remove', function(){
                        uploader.removeFile($(this).parent('.added-files').attr("id"));
                        $(this).parent('.added-files').remove();
                    });
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#tab_images_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> Sil</a></div>');
                    });
                },

                UploadProgress: function(up, file) {
                    $('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
                },

                FileUploaded: function(up, file, response) {

                    var response = $.parseJSON(response.response);

                    if (response.result && response.result == 'OK') {

                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> Yüklendi'); // set successfull upload
                        $('#uploaded_file_' + file.id).remove();
                        var oTable = $('#datatable').DataTable( );
                        oTable.ajax.reload();
                    } else {

                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Hata Oluştu'); // set failed upload
                        Metronic.alert({type: 'danger', message: 'Yüklenirken bir hata oluştu. Tekrar deneyiniz', closeInSeconds: 10, icon: 'warning'});
                    }
                },

                Error: function(up, err) {
                    Metronic.alert({container: '#alert-box',type: 'danger', message: err.message, closeInSeconds: 5, icon: 'warning'});
                }
            }
        });

        uploader.init();

    }

    return {

        //main function to initiate the module
        init: function (urunid) {
            handleImages(urunid);
        }

    };

}();
