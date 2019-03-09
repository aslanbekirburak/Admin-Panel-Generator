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
    $row = $db->get_row("SELECT liste_oge,databaseadi from yetki_sayfalar WHERE id = {$gelenid} ");
    $colums = $db->get_results("SHOW COLUMNS FROM {$row->databaseadi}");

    if($row->liste_oge != ""){
      $row = json_decode($row->liste_oge);
    }
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
                <span class="caption-subject font-green-sharp bold uppercase">Liste Yönetimi </span>
                <span class="caption-helper">Liste Öğe Düzenleme</span>
            </div>

            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" ><i class="fa fa-angle-left"></i> Geri</button>
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('menuController','listeDuzenle','<?=$gelenid?>','build.php?id=<?=$gelenid?>');  return false"><i class="fa fa-check"></i> Kaydet</button>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-2 control-label">Aranacak Sütun <span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control kategoriler" name="wherename" >
                          <?php foreach ($colums as $value) {?>
                            <option value="<?=$value->Field?>" <?php if ($value->Field == $row->wherename) { echo "selected";}?>><?=$value->Field?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Sıralama Sütunu <span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control kategoriler" name="ordername" >
                          <?php foreach ($colums as $value) {?>
                            <option value="<?=$value->Field?>" <?php if ($value->Field == $row->ordername) { echo "selected";}?>><?=$value->Field?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Durum Sütunu <span class="required">* </span></label>
                    <div class="col-md-10">
                        <select class="form-control kategoriler" name="statusname" >
                          <?php foreach ($colums as $value) {?>
                            <option value="<?=$value->Field?>" <?php if ($value->Field == $row->statusname) { echo "selected";}?>><?=$value->Field?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>

                <?php foreach ((array)$row->columnshow as $key => $cs) { ?>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Gösterilecek Sütun <span class="required">* </span></label>
                      <div class="col-md-4">
                          <select class="form-control kategoriler" name="columnshowkey[]" >
                            <?php foreach ($colums as $value) {?>
                              <option value="<?=$value->Field?>" <?php if ($value->Field == $key) { echo "selected";}?>><?=$value->Field?></option>
                            <?php }?>
                          </select>
                      </div>
                      <label class="col-md-1 control-label">Başlık</label>
                      <div class="col-md-4">
                          <input type="text" class="form-control"name="columnshowvalue[]" placeholder="" value="<?=$cs?>">
                      </div>
                      <div class="col-md-1">
                          <div class="btn red dahafazlasil" ><i class="fa fa-minus" ></i></div>
                      </div>
                  </div>
                <?php }?>

                <div id="dahafazlaekle"></div>

                <div class="form-group pull-right">
                  <div class="col-md-12 ">
                      <div class="btn blue" id="dahafazla"><i class="fa fa-plus" ></i> SÜTUN EKLE</div>
                  </div>
                </div>
                <div style="clear:both"></div>

            <div class="form-actions right">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" >
                    <i class="fa fa-angle-left"></i> Geri
                </button>
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('menuController','listeDuzenle','<?=$gelenid?>','build.php?id=<?=$gelenid?>');  return false"><i class="fa fa-check" ></i> Kaydet</button>
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
          $("#dahafazlaekle").append('<div class="form-group">'+
              '<label class="col-md-2 control-label">Gösterilecek Sütun <span class="required">* </span></label>'+
              '<div class="col-md-4">'+
                  '<select class="form-control kategoriler" name="columnshowkey[]" >'+
                    '<?php foreach ($colums as $value) {?>'+
                    '  <option value="<?=$value->Field?>" ><?=$value->Field?></option>'+
                    '<?php }?>'+
                '  </select>'+
              '</div>'+
              '<label class="col-md-1 control-label">Başlık</label>'+
              '<div class="col-md-4">'+
              '    <input type="text" class="form-control"name="columnshowvalue[]" placeholder="" value="">'+
              '</div>'+
              '<div class="col-md-1">'+
                '  <div class="btn red dahafazlasil"><i class="fa fa-minus" ></i></div>'+
              '</div>'+
        '  </div>');
        sil();

        $('.kategoriler').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });
        })

        function sil(){
          $(".dahafazlasil").click(function(){
            $(this).closest(".form-group").remove();
          });
        }

        sil();

        //kategoriler için
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



            $( document ).ajaxStart(function() {
              $( "#loading" ).show();
            });

    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
