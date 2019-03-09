<?php ob_start();
require_once("top.php"); require_once("yetkiKontrol.php");?>

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
    $gelenid = $_GET["id"];
    $row = $db->get_row("SELECT * from webservis_controller WHERE id = {$gelenid} ");
    $file_id=$row->webservis_id;

    $row2 = $db->get_row("SELECT databaseadi,methodadi from webservis WHERE id = {$file_id} ");
    $colums = $db->get_results("SHOW COLUMNS FROM {$row2->databaseadi}");

    ?>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="tabbable">
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
        <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" id="islemDuzenle" action="" method="post" enctype="multipart/form-data">
        <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-list font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Method Yönetimi </span>
                <span class="caption-helper">Method Düzenleme</span>
            </div>

            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" ><i class="fa fa-angle-left"></i> Geri</button>
                <button class="btn green-haze btn-circle"><i class="fa fa-check"></i> Kaydet</button>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">
              <?php
              if($row->type=="put")
              { ?>

                <div id="sutunresponse">
                  <div class="form-group">
                      <label class="col-md-2 control-label">Where Sutun Adı:<span class="required">* </span></label>
                      <div class="col-md-10">
                          <select class="form-control bs-select" name="colname" data-show-subtext="true">
                            <?php foreach ($colums as $value) {?>
                              <option value="<?=$value->Field?>" <?php if($value->Field == $row->colname){ echo "selected"; }?>><?=$value->Field?></option>
                            <?php }?>
                          </select>
                      </div>
                  </div>
                </div>
            <?php  }

            elseif($row->type=="delete")
            { ?>

              <div id="sutunresponse">
                <div class="form-group">
                  <?php
                  $webid=$db->get_var("SELECT webservis_id FROM webservis_controller WHERE id='{$gelenid}'");
                  $row=$db->get_row("SELECT databaseadi FROM webservis WHERE id='{$webid}'");
                  //$row = $db->get_row("SELECT databaseadi from yetki_sayfalar WHERE id = {$gelenid} ");
                  $colums = $db->get_results("SHOW COLUMNS FROM {$row->databaseadi} ");
                        ?>
                    <label class="col-md-2 control-label">Where Sutun Adı :<span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control bs-select" name="colname" data-show-subtext="true">
                          <?php foreach ($colums as $value) {?>
                            <option value="<?=$value->Field?>" <?php if($value->Field == $row->colname){ echo "selected"; }?>><?=$value->Field?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>
              </div>




            <?php }

            elseif($row->type=="post")
            {?>

              <div class="form-group">
                <?php $sql=$db->get_row("SHOW TABLES",0);
                      ?>
                  <label class="col-md-2 control-label">DataBase Name:<span class="required">* </span></label>
                  <div class="col-md-10">
                      <select class="form-control bs-select" id="vargetir" name="tablename" data-show-subtext="true">
                        <?php foreach ($sql as $key => $tables): ?>
                          <option value=<?=$tables?> <?php if($tables == $row->databaseadi){echo "selected";}?>><?=$tables?></option>
                         <?php endforeach; ?>
                      </select>
                  </div>
              </div>

            <?php }
            elseif($row->type=="get")
            { ?>

                <div class="form-group">
                  <label class="col-md-2 control-label">Where Sutun Adı:<span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control bs-select" name="colname" data-show-subtext="true">
                          <?php foreach ($colums as $value) {?>
                            <option value="<?=$value->Field?>" <?php if($value->Field == $row->colname){ echo "selected"; }?>><?=$value->Field?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label">Gösterilecek Sütünlar:<span class="required">* </span></label>
                  <div class="col-md-10">
                    <select class="form-control getsutunlar" name="colshow[]" data-show-subtext="true" multiple>
                      <?php if($row->colshow == "null"){
                        $colshows = array();
                        $selectedtumu = "selected";
                      }else {
                        $colshows = json_decode($row->colshow);
                        $selectedtumu = "";
                      } ?>
                      <option value="*" <?=$selectedtumu?>>Tümü</option>
                      <?php
                        foreach ((array)$colums as $cs) {
                          $colshowname = $row2->databaseadi.".".$cs->Field;
                          $colshowval = $row2->databaseadi.".".$cs->Field." AS ".$row2->databaseadi."_".$cs->Field;
                           ?>
                          <option value="<?=$colshowval?>" <?php if (in_array($colshowval,$colshows)) { echo "selected";}?>><?=$colshowname?></option>
                        <?php }

                      if($row->jointable != ""){
                        foreach ((array)json_decode($row->jointable) as $y) {
                          $joincolums = $db->get_results("SHOW COLUMNS FROM {$y->jointable}");
                          foreach ((array)$joincolums as $jv) {
                            $colshowname = $y->jointable.".".$jv->Field;
                            $colshowval = $y->jointable.".".$jv->Field." AS ".$y->jointable."_".$jv->Field;
                            ?>
                            <option value="<?=$colshowval?>" <?php if (in_array($colshowval,$colshows)) { echo "selected";}?>><?=$colshowname?></option>
                          <?php }
                        }
                      }?>
                    </select>
                  </div>
                </div>

                <?php foreach ((array)json_decode($row->jointable) as $y) {
                  ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Tablo Bağla: </label>
                    <div class="col-md-4">
                        <select class="form-control mevcutsutunlar vargetir "  name="jointable[]" >
                          <?php $sql=$db->get_col("SHOW TABLES",0);?>
                          <?php foreach ($sql as $key => $tables): ?>
                            <option value="<?=$tables?>" <?php if($tables == $y->jointable){echo "selected";}?>><?=$tables?></option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="sutunresponse">
                      <div class="col-md-2">
                        <select class="form-control getsutunlar" name="jointablecol[]" data-show-subtext="true">
                          <?php
                          $joincolums = $db->get_results("SHOW COLUMNS FROM {$y->jointable}");
                          foreach ((array)$joincolums as $jv) { ?>
                            <option value="<?=$jv->Field?>" <?php if ($jv->Field == $y->jointablecol ) { echo "selected";}?>><?=$jv->Field?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <label class="col-md-1 control-label"> = <?=$tablename?></label>
                    <div class="col-md-2">
                      <select class="form-control mevcutsutunlar" name="joincolname[]" data-show-subtext="true">
                        <?php foreach ((array)$colums as $value) { ?>
                          <option value="<?=$value->Field?>" <?php if ($value->Field == $y->joincolname ) { echo "selected";}?>><?=$value->Field?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-1">'
                        <div class="btn red dahafazlasil" ><i class="fa fa-minus" ></i></div>
                    </div>
                </div>
                <?php }?>

                <div id="dahafazlaekle"></div>

                <div class="form-group pull-right">
                  <div class="col-md-12 ">
                      <div class="btn blue" id="dahafazla"><i class="fa fa-plus" ></i> TABLO EKLE</div>
                  </div>
                </div>
                <div style="clear:both"></div>


            <?php }
            elseif($row->type=="getall")
            { ?>

              <div id="sutunresponse">
                <div class="form-group">
                  <label class="col-md-2 control-label">Sıralama Sütünü:<span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control bs-select required" name="colordername" data-show-subtext="true">
                          <?php foreach ($colums as $value) { ?>
                            <option value="<?=$value->Field?>" <?php if($value->Field == $row->colordername){ echo "selected"; }?>><?=$value->Field?></option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">Sıralama Yöntemi</label>
                  <div class="col-md-10">
                      <select class="form-control selectoge required" id="turgetir" name="colorder">
                           <option value="asc" <?php if("asc" == $row->colorder){ echo "selected"; }?>>Artan</option>
                            <option value="desc" <?php if("desc" == $row->colorder){ echo "selected"; }?>>Azalan</option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label">Gösterilecek Sütünlar:<span class="required">* </span></label>
                <div class="col-md-10">
                  <select class="form-control getsutunlar" name="colshow[]" data-show-subtext="true" multiple>
                    <?php if($row->colshow == "null"){
                      $colshows = array();
                      $selectedtumu = "selected";
                    }else {
                      $colshows = json_decode($row->colshow);
                      $selectedtumu = "";
                    } ?>
                    <option value="*" <?=$selectedtumu?>>Tümü</option>
                    <?php
                      foreach ((array)$colums as $cs) {
                        $colshowname = $row2->databaseadi.".".$cs->Field;
                        $colshowval = $row2->databaseadi.".".$cs->Field." AS ".$row2->databaseadi."_".$cs->Field;
                         ?>
                        <option value="<?=$colshowval?>" <?php if (in_array($colshowval,$colshows)) { echo "selected";}?>><?=$colshowname?></option>
                      <?php }

                    if($row->jointable != ""){
                      foreach ((array)json_decode($row->jointable) as $y) {
                        $joincolums = $db->get_results("SHOW COLUMNS FROM {$y->jointable}");
                        foreach ((array)$joincolums as $jv) {
                          $colshowname = $y->jointable.".".$jv->Field;
                          $colshowval = $y->jointable.".".$jv->Field." AS ".$y->jointable."_".$jv->Field;
                          ?>
                          <option value="<?=$colshowval?>" <?php if (in_array($colshowval,$colshows)) { echo "selected";}?>><?=$colshowname?></option>
                        <?php }
                      }
                    }?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label required">Syafa Satır Sayısı: <span class="required">* </span></label>
                  <div class="col-md-10">
                      <input type="text" class="form-control required" required name="pagerowcount" placeholder="Page Row Count Sayısı" value="<?=$row->pagerowcount?>">
                  </div>
              </div>


              <?php foreach ((array)json_decode($row->jointable) as $y) {
                ?>
              <div class="form-group">
                  <label class="col-md-2 control-label">Tablo Bağla: </label>
                  <div class="col-md-4">
                      <select class="form-control mevcutsutunlar vargetir "  name="jointable[]" >
                        <?php $sql=$db->get_col("SHOW TABLES",0);?>
                        <?php foreach ($sql as $key => $tables): ?>
                          <option value="<?=$tables?>" <?php if($tables == $y->jointable){echo "selected";}?>><?=$tables?></option>
                         <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="sutunresponse">
                    <div class="col-md-2">
                      <select class="form-control getsutunlar" name="jointablecol[]" data-show-subtext="true">
                        <?php
                        $joincolums = $db->get_results("SHOW COLUMNS FROM {$y->jointable}");
                        foreach ((array)$joincolums as $jv) { ?>
                          <option value="<?=$jv->Field?>" <?php if ($jv->Field == $y->jointablecol ) { echo "selected";}?>><?=$jv->Field?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <label class="col-md-1 control-label"> = <?=$tablename?></label>
                  <div class="col-md-2">
                    <select class="form-control mevcutsutunlar" name="joincolname[]" data-show-subtext="true">
                      <?php foreach ((array)$colums as $value) { ?>
                        <option value="<?=$value->Field?>" <?php if ($value->Field == $y->joincolname ) { echo "selected";}?>><?=$value->Field?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-1">'
                      <div class="btn red dahafazlasil" ><i class="fa fa-minus" ></i></div>
                  </div>
              </div>
              <?php }?>

              <div id="dahafazlaekle"></div>

              <div class="form-group pull-right">
                <div class="col-md-12 ">
                    <div class="btn blue" id="dahafazla"><i class="fa fa-plus" ></i> TABLO EKLE</div>
                </div>
              </div>
              <div style="clear:both"></div>

            <?php } ?>

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

        $("#dahafazla").click(function(){
          $("#dahafazlaekle").append('<?php $id_web=$db->get_var("SELECT webservis_id FROM webservis_controller WHERE id='{$gelenid}'") ?> '+
          '<?php $tablename=$db->get_var("SELECT databaseadi FROM webservis WHERE id='{$id_web}'");?>'+
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
        $('.kategoriler').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });

        $('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });

        $('.videolar').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });

        $('.galeriler').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });

        $('.kaynak').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });



      $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size()>0) {
        	$(this).find('.btn').toggleClass('btn-primary');
        }
      });

      $(".form_meridian_datetime").datetimepicker({
            isRTL: Metronic.isRTL(),
            format: "yyyy-mm-dd hh:ii",
            autoclose: true,
            pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
            todayBtn: true,
            language: 'tr'
        });

        $('#alt_body').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: Metronic.isRTL() ? 'top-right' : 'top-left'
        });

        $('#title').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: Metronic.isRTL() ? 'top-right' : 'top-left'
        });

        $('#hashtag').tagsInput({
            width: 'auto',
            'defaultText':'Etiket Ekle',
            'placeholderColor' : '#666666'
        });

        function sutunGetir(tablename){
          $.post( "islemler/webservice_oge_Controller.php?q=Sutungetir", { tbname: tablename })
            .done(function( data ) {
              $("#sutunresponse").html(data);
              $('.kategoriler').select2({
                  placeholder: "Bir Seçim Yapınız.",
                  allowClear: true
              });
          });
        }

        function sil(){
          $(".dahafazlasil").click(function(){
            $(this).closest(".form-group").remove();
          });
        }

        sil();

            $( document ).ajaxStart(function() {
              $( "#loading" ).show();
            });

            var form1 = $('#islemDuzenle');
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
                  islemDuzenle('webservice_oge_Controller','Duzenle','<?=$gelenid?>','method_ogeleri.php?id=<?=$file_id?>');
                }
          });

    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
