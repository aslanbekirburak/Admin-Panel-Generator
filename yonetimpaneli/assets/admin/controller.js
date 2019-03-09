$(document).ready(function(e) {

  $('#da-ex-elfinder').elfinder({
    url : 'assets/global/plugins/elfinder/php/connector.minimal.php',
    lang: 'tr'
  });

});

function islemControllerDuzenle(tablename,islem,gelenid,yonlendir) {

    //var deger = $("form#islemDuzenle").serialize();
    var deger = new FormData($('#islemDuzenle')[0]);

    $.ajax({
        url: "islemler/duzenleController.php?t="+tablename+"&q="+islem+"&id="+gelenid,
        type: "POST",
        data: deger,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function() {
             // setting a timeout
             swal({
               title: "Yükleniyor",
               text: "İşlem devam ediyor lütfen bekleyiniz",
               imageUrl: "assets/global/img/ring-alt.gif",
               showCancelButton: false,
               showConfirmButton: false,
               closeOnConfirm: false,
             });
         },
        success: function (cevap) {
            if (cevap.hata) {
                //alert(cevap.hata);
                swal({
                    title: "Hata!",
                    text: cevap.hata,
                    type: "error",
                    confirmButtonText: "Tamam"
                });
            } else if (cevap.bilgi) {
                //alert(cevap.bilgi);
                swal({
                    title: "Bilgilendirme",
                    text: cevap.bilgi,
                    type: "warning",
                    confirmButtonText: "Tamam"
                });
              } else if(cevap.tamam) {

                  //alert(cevap.ok);
                  swal({
                      title: "Başarılı!",
                      text: cevap.tamam,
                      type: "success",
                      showConfirmButton: false
                  });
                  setInterval(function () {
                      window.location.href = yonlendir;
                  }, 2000);
              }else{
                alert(cevap);
                swal({
                    title: "Hata",
                    text: cevap,
                    type: "error",
                    showConfirmButton: true
                });
              }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("SQL Hatası:"+xhr.responseText);
        }
    });
}

function islemControllerEkle(tablename,islem,gelenid,yonlendir) {
    //var deger = $("form#islemEkle").serialize();
    var deger = new FormData($('#islemEkle')[0]);

    var form1 = $('#islemEkle');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      ignore: "",  // validate all fields including form hidden input
      lang: 'tr',
      invalidHandler: function (event, validator) { //display error alert on form submit
        success1.hide();
        error1.show();
        swal({
            title: "Hata!",
            text: "Lütfen tüm zorunlu alanları doldurunuz.",
            type: "error",
            confirmButtonText: "Tamam"
        });
      },
      errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },
      highlight: function (element) { // hightlight error inputs
          $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
      },
      unhighlight: function (element) { // revert the change done by hightlight
          $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
      },
      success: function (label) {
        label.closest('.form-group').removeClass('has-error'); // set success class to the control group
      },
      submitHandler: function (form) {
          success1.show();
          error1.hide();


    $.ajax({
        url: "islemler/ekleController.php?t="+tablename+"&q="+islem+"&id="+gelenid,
        type: "POST",
        data: deger,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function() {
             // setting a timeout
             swal({
               title: "Yükleniyor",
               text: "İşlem devam ediyor lütfen bekleyiniz",
               imageUrl: "assets/global/img/ring-alt.gif",
               showCancelButton: false,
               showConfirmButton: false,
               closeOnConfirm: false,
             });
         },
        success: function (cevap) {
          //console.log(cevap);
            if (cevap.hata) {
                //alert(cevap.hata);
                swal({
                    title: "Hata!",
                    text: cevap.hata,
                    type: "error",
                    confirmButtonText: "Tamam"
                });
            } else if (cevap.bilgi) {
                //alert(cevap.bilgi);
                swal({
                    title: "Bilgilendirme",
                    text: cevap.bilgi,
                    type: "warning",
                    confirmButtonText: "Tamam"
                });
            } else if(cevap.tamam) {

                //alert(cevap.ok);
                swal({
                    title: "Başarılı!",
                    text: cevap.tamam,
                    type: "success",
                    showConfirmButton: false
                });
                setInterval(function () {
                    window.location.href = yonlendir;
                }, 2000);
            }else{
              swal({
                  title: "Hata",
                  text: cevap,
                  type: "error",
                  showConfirmButton: true
              });
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("SQL Hatası:"+xhr.responseText);
        }
    });

  }
});

}

function islemControllerListesi(tablename,gelenid) {

  var grid = new Datatable();
  grid.init({
      src: $("#datatable"),
      onSuccess: function (grid) {
          // execute some code after table records loaded
      },
      onError: function (grid) {
          // execute some code on network or other general error
      },
      loadingMessage: 'Yükleniyor...',
      dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

          // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
          // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
          // So when dropdowns used the scrollable div should be removed.
          //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
          "bServerSide": true,
          "lengthMenu": [
              [10, 20, 50, 100, 150],
              [10, 20, 50, 100, 150] // change per page values here
          ],
          "pageLength": 50, // default record count per page
          "ajax": {
              "url": "islemler/listeController.php?t="+tablename+"&q=Listele&id="+gelenid // ajax source

          },
          "cache": true,
          "order": [
              [0, "desc"]
          ] // set first column as a default sort by asc
      }
  });
   // arama bölümü için
  grid.getTableWrapper().on('keyup', '.form-filter', function () {
      //console.log($(this).attr("name") + " - " + $(this).val());
      grid.setAjaxParam($(this).attr("name"), $(this).val());
      grid.getDataTable().ajax.reload();
      grid.clearAjaxParams();
  });

  $("#sortable").sortable({
        opacity: 0.7,
        scroll: false,
        update: function () {
            var data = $('#sortable').sortable('toArray');
            var request = $.ajax({
                url: "islemler/listeController.php?t="+tablename+"&q=Siralama",
                method: "POST",
                data: { 'yenisira': data },
                dataType: "html"
            });

            request.done(function( msg ) {
                grid.getDataTable().ajax.reload();
            });
        }
    }).disableSelection();

  // silme işlemi
  grid.getTableWrapper().on('click', '.sil', function () {
      var gelenid = $(this).attr("data-id");
      bootbox.dialog({
          message: "Silmek istediğinizden eminisiniz? Bu işlemin geri dönüşü yoktur.",
          title: "Silme İşlemi Onayı",
          buttons: {
              danger: {
                  label: "Sil",
                  className: "red",
                  callback: function() {
                      //console.log(gelenid);
                      var request = $.ajax({
                          url: "islemler/listeController.php?t="+tablename+"&q=Sil",
                          method: "POST",
                          data: { id : gelenid },
                          dataType: "html"
                      });

                      request.done(function( msg ) {
                          grid.getDataTable().ajax.reload();
                      });

                      request.fail(function( jqXHR, textStatus ) {
                          alert( "Silme İşlemi Başarısız Oldu: " + textStatus );
                      });
                  }
              },
              main: {
                  label: "Geri",
                  className: "blue",
                  callback: function() {
                  }
              }
          }
      });
  });


  grid.getTableWrapper().on('click', '.durumdegistir', function () {
      var gelenid = $(this).attr("data-id");
      var gelentur = $(this).attr("data-tur");
      var gelenvalue = $(this).attr("data-value");
      bootbox.dialog({
          message: "Durumu değiştirmek istediğinizden eminisiniz?",
          title: "Durum Değiştirme İşlemi Onayı",
          buttons: {
              danger: {
                  label: "Değiştir",
                  className: "red",
                  callback: function() {
                      //console.log(gelenid);
                      var request = $.ajax({
                          url: "islemler/listeController.php?t="+tablename+"&q=DurumDegistir",
                          method: "POST",
                          data: { id : gelenid, tur : gelentur, value : gelenvalue },
                          dataType: "html"
                      });

                      request.done(function( msg ) {
                          grid.getDataTable().ajax.reload();
                      });

                      request.fail(function( jqXHR, textStatus ) {
                          alert( "Durum Değiştirme İşlemi Başarısız Oldu: " + textStatus );
                      });
                  }
              },
              main: {
                  label: "Geri",
                  className: "blue",
                  callback: function() {
                  }
              }
          }
      });
  });

}

function gorselSecici(seciciname,w,h){
  var $image = $("."+seciciname+"_detay .fixed-dragger-cropperq > img");
  var $input = $("#"+seciciname+"_inputImage");
  imageCropSetting($image,$input);
  $image.cropper({
      aspectRatio: w / h,
      autoCropArea: 1, // Center 60%
      multiple: false,
      dragCrop: false,
      dashed: false,
      movable: true,
      resizable: false,
      done: function() {

          var imagedata = $image.cropper("getDataURL", "image/jpeg");
          $("#"+seciciname+"_ImageData").val(imagedata);
      }

  });

  $("."+seciciname+"_detay").on("click", "[data-method]", function () {
      var data = $(this).data();
      if (data.method) {
          $image.cropper(data.method, data.option);
      }
  });
}
