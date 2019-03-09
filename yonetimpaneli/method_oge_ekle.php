<?php ob_start();
require_once("top.php"); require_once("yetkiKontrol.php");
$gelenid = $_GET["id"];
?>

<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<?php require_once("header.php");?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once("sidebar.php");
    ?>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="tabbable">
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
        <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" id="islemEkle" onsubmit="return false;" action=""  method="post" enctype="multipart/form-data">
        <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-list font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Method Yönetimi </span>
                <span class="caption-helper">İşlem Ekleme</span>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">
              <input type="hidden" name="webservis_id" value="<?=$gelenid?>">
                  <div class="form-group">
                      <label class="col-md-2 control-label">Tür</label>
                      <div class="col-md-10">
                        <?php $check=$db->get_col("SELECT type FROM webservis_controller WHERE webservis_id='{$gelenid}'",0);
                        ?>
                          <select class="form-control selectoge" id="turgetir" name="type">
                            <option value="0">Seçim Yapınız</option>
                            <?php if(!in_array("post",$check)){ ?><option value="post">Ekleme</option><?php } ?>
                            <?php if(!in_array("put",$check)){ ?><option value="put">Düzenleme</option><?php } ?>
                            <?php if(!in_array("delete",$check)){ ?><option value="delete">Silme</option><?php } ?>
                            <?php if(!in_array("get",$check)){ ?><option value="get">Tek Satır Listeme</option><?php } ?>
                            <?php if(!in_array("getall",$check)){ ?><option value="getall">Tüm Satırları listele</option><?php } ?>
                          </select>
                      </div>
                  </div>

                  <div id="response"></div>

          </div>
          <div class="form-actions right">
              <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" >
                  <i class="fa fa-angle-left"></i> Geri
              </button>
              <button class="btn green-haze btn-circle" ><i class="fa fa-check" ></i> Kaydet</button>
          </div>
        </div>
        </div>
        </form>
        </div>
        </div>
        <!-- END PAGE CONTENT-->
                </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
</div>
<div id="dosya_yoneticisi"></div>

<?php require_once("bottom.php");?>
<!-- BEGIN PAGE LEVEL PLUGINS -->

<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-summernote/summernote.css">
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>

<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>

<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/global/plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.tr.js"></script>
<!-- image Crop -->
<link  href="assets/global/plugins/imagecrop/cropper.css" rel="stylesheet">
<script src="assets/global/plugins/imagecrop/cropper.js" type="text/javascript"></script>
<link  href="assets/global/plugins/imagecrop/ayar.css" rel="stylesheet">
<script src="assets/global/plugins/imagecrop/ayar.js" type="text/javascript"></script>
<!-- image Crop -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js"></script>

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components

        $('#order').spinner({value:0, min: 0, max: 100});
        $('#title').friendurl({id: 'seo', divider: '-', transliterate: true});
        //kategoriler için
        $('.selectoge').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });
        $('.kategoriler').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });


      $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size()>0) {
        	$(this).find('.btn').toggleClass('btn-primary');
        }
      });

      function katGetir(postid,menupostid){
        $.post( "islemler/webservice_oge_Controller.php?q=Turgetir", { tur_id: postid, menuid: menupostid })
          .done(function( data ) {
            $("#response").html(data);
            $('.sutunlar').select2({
                placeholder: "Bir Seçim Yapınız.",
                allowClear: true
            });
            $('.btn-toggle').click(function() {
              $(this).find('.btn').toggleClass('active');
              if ($(this).find('.btn-primary').size()>0) {
                $(this).find('.btn').toggleClass('btn-primary');
              }
            });



            $("#dahafazla").click(function(){
              $("#dahafazlaekle").append('<?php $tablename=$db->get_var("SELECT databaseadi FROM webservis WHERE id='{$gelenid}'");?>'+
              '<?php $colums = $db->get_results("SHOW COLUMNS FROM  {$tablename} ");?>'+
              '<div class="form-group">'+
                  '<label class="col-md-2 control-label">Tablo Bağla: </label>'+
                  '<div class="col-md-4">'+
                      '<select class="form-control mevcutsutunlar vargetir "  name="jointable[]" >'+
                        '<option value="" >Bağlanacak Tablo Seçiniz</option>'+
                        '<?php $tables = $db->get_col("SHOW TABLES",0); ?>'+
                        '<?php foreach ($tables as $value) { ?>'+
                          '<option value="<?=$value?>" ><?=$value?></option>'+
                        '<?php } ?>'+
                      '</select>'+
                  '</div>'+
                  '<div class="sutunresponse">'+
                    '<div class="col-md-2">'+
                      '<select class="form-control getsutunlar" name="jointablecol[]" data-show-subtext="true">'+
                        '<option value="">Sütun Seçiniz</option>'+
                      '</select>'+
                    '</div>'+
                  '</div>'+
                  '<label class="col-md-1 control-label"> = <?=$tablename?></label>'+
                  '<div class="col-md-2">'+
                    '<select class="form-control mevcutsutunlar" name="joincolname[]" data-show-subtext="true">'+
                      '<option value="">Sütun Seçiniz</option>'+
                      '<?php foreach ((array)$colums as $value) { ?>'+
                        '<option value="<?=$value->Field?>" ><?=$value->Field?></option>'+
                      '<?php } ?>'+
                    '</select>'+
                  '</div>'+
                  '<div class="col-md-1">'+
                      '<div class="btn red dahafazlasil" ><i class="fa fa-minus" ></i></div>'+
                  '</div>'+
              '</div>');
            sil();

            $('.getsutunlar').select2("destroy");
            $('.getsutunlar').select2({
                placeholder: "Bir Seçim Yapınız.",
                allowClear: true
            });
            $('.mevcutsutunlar').select2("destroy");
            $('.mevcutsutunlar').select2({
                placeholder: "Bir Seçim Yapınız.",
                allowClear: true
            });

            $(".vargetir").change(function() { //tür dropdown değiştiğinde tetiklenir.
              var tablename = $( this ).val();
               var putdata = $( this ).parent().next(".sutunresponse");
              $.post( "islemler/webservice_oge_Controller.php?q=Sutungetir", { tbname: tablename })
                .done(function( data ) {

                  putdata.html(data);
                  $('.getsutunlar').select2("destroy");
                  $('.getsutunlar').select2({
                      placeholder: "Bir Seçim Yapınız.",
                      allowClear: true
                  });
                  $('.mevcutsutunlar').select2("destroy");
                  $('.mevcutsutunlar').select2({
                      placeholder: "Bir Seçim Yapınız.",
                      allowClear: true
                  });
              });

            });
          });

            function sil(){
              $(".dahafazlasil").click(function(){
                $(this).closest(".form-group").remove();
              });
            }

            sil();

        });
      }

      var getkatid = $( "#turgetir" ).val(); //türün id değerini alır
      var menuid = <?=$gelenid?>; //türün id değerini alır
      katGetir(getkatid,menuid); //ilk açılışta çalışması için

      $("#turgetir").change(function() { //tür dropdown değiştiğinde tetiklenir.
        var katid = $( this ).val();
        var menuid = <?=$gelenid?>;
        katGetir(katid,menuid);

      });

            $( document ).ajaxStart(function() {
              $( "#loading" ).show();
            });

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
                  islemEkle('webservice_oge_Controller','Ekle','<?=$gelenid?>','method_ogeleri.php?id=<?=$gelenid?>');
                }
          });
    });

</script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
