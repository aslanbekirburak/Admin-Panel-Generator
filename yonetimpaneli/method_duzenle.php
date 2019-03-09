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
    $row = $db->get_row("SELECT * from webservis WHERE id = {$gelenid} ");
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
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('webserviceController','Duzenle','<?=$gelenid?>','method_listele.php');  return false"><i class="fa fa-check"></i> Kaydet</button>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">

              <div class="form-group">
                  <label class="col-md-2 control-label">Method Adı: <span class="required">* </span></label>
                  <div class="col-md-10">
                      <input type="text" class="form-control" maxlength="99" name="methodadi" placeholder="Menü Adı" value="<?=$row->methodadi?>">
                  </div>
              </div>

              <div class="form-group">
                <?php $sql=$db->get_col("SHOW TABLES",0);
                      ?>
                  <label class="col-md-2 control-label">DB Tablo Adı:<span class="required">* </span></label>
                  <div class="col-md-10">
                      <select class="form-control kategoriler"  name="databaseadi" data-show-subtext="true">
                        <?php foreach ($sql as $key => $tables): ?>
                          <option value=<?=$tables?> <?php if($tables == $row->databaseadi){echo "selected";}?>><?=$tables?></option>
                         <?php endforeach; ?>
                      </select>
                  </div>
              </div>

            </div>
            <div class="form-actions right">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" >
                    <i class="fa fa-angle-left"></i> Geri
                </button>
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('webserviceController','Duzenle','<?=$gelenid?>','method_listele.php');  return false"><i class="fa fa-check" ></i> Kaydet</button>
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
