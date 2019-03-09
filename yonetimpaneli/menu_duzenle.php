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
    $row = $db->get_row("SELECT * from yetki_sayfalar WHERE id = {$gelenid} ");
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
                <span class="caption-subject font-green-sharp bold uppercase">Menü Yönetimi </span>
                <span class="caption-helper">Menü Düzenleme</span>
            </div>

            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" ><i class="fa fa-angle-left"></i> Geri</button>
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('menuController','Duzenle','<?=$gelenid?>','menuler.php');  return false"><i class="fa fa-check"></i> Kaydet</button>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">

              <div class="form-group">
                  <label class="col-md-2 control-label">Üst Menü</label>
                  <div class="col-md-10">
                      <select class="form-control kategoriler" name="ust_id">
                        <option value="0" <?php if ($row->ust_id == 0) { echo "selected";}?>>Üst Menü</option>
                        <?php foreach ($db->get_results("SELECT * from yetki_sayfalar WHERE ust_id = 0 ORDER BY menuadi ASC ") as $value) {?>
                          <option value="<?=$value->id?>" <?php if ($row->ust_id == $value->id) { echo "selected";}?>><?=$value->menuadi?></option>
                        <?php }?>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">İkon</label>
                  <div class="col-md-10">
                      <select class="form-control bs-select" name="icon" data-show-subtext="true">
                        <?php foreach ($db->get_results("SELECT * from yetki_sayfa_icon ORDER BY icon ASC ") as $value) {?>
                          <option value="<?=$value->icon?>" <?php if ($row->icon == $value->icon) { echo "selected";}?> data-icon="<?=$value->icon?>"><?=$value->icon?></option>
                        <?php }?>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">Menü Adı: <span class="required">* </span></label>
                  <div class="col-md-10">
                      <input type="text" class="form-control" maxlength="99" id="menuadi" name="menuadi" placeholder="Menü Adı" value="<?=$row->menuadi?>">
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

              <div class="form-group">
                  <label class="col-md-2 control-label">Sayfa Türü: </label>
                  <div class="col-md-10">
                      <select class="form-control kategoriler" name="type">
                          <option value="ekle" <?php if($row->type == "ekle"){echo "selected";}?>>Ekle</option>
                          <option value="duzenle" <?php if($row->type == "duzenle"){echo "selected";}?>>Düzenle</option>
                          <option value="listele" <?php if($row->type == "listele"){echo "selected";}?>>Listele</option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-2">Sıra</label>
                  <div class="col-md-10">
                    <div id="order">
                      <div class="input-group" style="width:150px;">
                        <input type="text" class="spinner-input form-control" name="sira" value="<?=$row->sira?>" maxlength="3" readonly>
                        <div class="spinner-buttons input-group-btn">
                          <button type="button" class="btn spinner-up default">
                          <i class="fa fa-angle-up"></i>
                          </button>
                          <button type="button" class="btn spinner-down default">
                          <i class="fa fa-angle-down"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              <div class="form-group">
                  <label class="control-label col-md-2">Durum</label>
                  <div class="col-md-10">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                       <label class="btn btn-default <?php if ($row->goster == 1) { echo "btn-primary active";}?>">
                         <input type="radio" name="goster" value="1" <?php if ($row->goster == 1) { echo "checked";}?>> Göster
                       </label>
                       <label class="btn btn-default <?php if ($row->status == 2) { echo "btn-primary active";}?>">
                         <input type="radio" name="goster" value="2" <?php if ($row->goster == 2) { echo "checked";}?>> Gösterme
                       </label>
                     </div>
                  </div>
              </div>

            </div>
            <div class="form-actions right">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" >
                    <i class="fa fa-angle-left"></i> Geri
                </button>
                <button class="btn green-haze btn-circle" onclick="islemDuzenle('menuController','Duzenle','<?=$gelenid?>','menuler.php');  return false"><i class="fa fa-check" ></i> Kaydet</button>
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
