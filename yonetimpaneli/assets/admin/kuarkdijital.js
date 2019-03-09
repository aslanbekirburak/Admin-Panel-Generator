
/* ################ USER LOGIN ################# */
function userLogin() {

    var deger = $("form#userLogin").serialize();
    $.ajax({
        url: "islemler/kullaniciController.php?q=userLogin",
        type: "post",
        data: deger,
        dataType: "json",
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
            } else {

                //alert(cevap.ok);
                swal({
                    title: "Başarılı!",
                    text: cevap.ok,
                    type: "success",
                    showConfirmButton: false
                });
                setInterval(function () {
                  if(cevap.yetki == 16 || cevap.yetki == 99){
                    window.location.href = "anasayfa.php";
                  }else{
                      window.location.href = "anasayfa.php";
                  }

                }, 3000);
            }
        }
    });

}
/* ################ USER LOGIN END ################# */

function islemDuzenle(controller,islem,gelenid,yonlendir) {

    //var deger = $("form#islemDuzenle").serialize();
    var deger = new FormData($('#islemDuzenle')[0]);

    $.ajax({
        url: "islemler/"+controller+".php?q="+islem+"&id="+gelenid,
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

function islemEkle(controller,islem,gelenid,yonlendir) {
    //var deger = $("form#islemEkle").serialize();
    var deger = new FormData($('#islemEkle')[0]);

    $.ajax({
        url: "islemler/"+controller+".php?q="+islem+"&id="+gelenid,
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

function islemListesi(controllerName,gelenid) {

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
              "url": "islemler/"+controllerName+"Controller.php?q=Listele&id="+gelenid // ajax source

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
                url: "islemler/"+controllerName+"Controller.php?q=Siralama",
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
                          url: "islemler/"+controllerName+"Controller.php?q=Sil",
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

  //işlem iptali
  grid.getTableWrapper().on('click', '.islem_iptal', function () {
      var gelenid = $(this).attr("data-id");
      bootbox.dialog({
          message: "İşlemi iptal etmek istediğinizden eminisiniz? Bu işlemin geri dönüşü yoktur.",
          title: "İptal İşlemi Onayı",
          buttons: {
              danger: {
                  label: "İptal",
                  className: "red",
                  callback: function() {
                      //console.log(gelenid);
                      var request = $.ajax({
                          url: "islemler/"+controllerName+"Controller.php?q=Iptal",
                          method: "POST",
                          data: { id : gelenid },
                          dataType: "html"
                      });

                      request.done(function( msg ) {
                          grid.getDataTable().ajax.reload();
                      });

                      request.fail(function( jqXHR, textStatus ) {
                          alert( "İşlem İptali Başarısız Oldu: " + textStatus );
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

  //inline text düzenleme işlemi
  grid.getTableWrapper().on('focusout', '.metinduzenle', function () {
      var gelenid = $(this).attr("data-id");
      var metin = $(this).val();
      //console.log(gelenid + metin);
      var request = $.ajax({
          url: "islemler/"+controllerName+"Controller.php?q=Duzenle",
          method: "POST",
          data: { id : gelenid, gelenmetin : metin },
          dataType: "html"
      });

      request.done(function( msg ) {
          grid.getDataTable().ajax.reload();
      });

      request.fail(function( jqXHR, textStatus ) {
          alert( "Düzenleme İşlemi Başarısız Oldu: " + textStatus );
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
                          url: "islemler/"+controllerName+"Controller.php?q=DurumDegistir",
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
