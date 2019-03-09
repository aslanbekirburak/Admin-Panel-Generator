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
                <i class="icon-basket font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Yöneticiler </span>
                <span class="caption-helper">Yönetici Ekle</span>
            </div>

            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" ><i class="fa fa-angle-left"></i> Geri</button>
                <button class="btn green-haze btn-circle" onclick="islemEkle('yoneticiController','Ekle','0','yoneticiler.php');  return false"><i class="fa fa-check"></i> Kaydet</button>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo $msg;?>
            <div class="form-body">

              <div class="form-group">
                  <label class="col-md-2 control-label">Yetki Grubu</label>
                  <div class="col-md-10">
                      <select class="form-control kategoriler" name="yetki">
                        <?php foreach ($db->get_results("SELECT * from yetkiler WHERE yetki != 16 ORDER BY adi ASC ") as $value) {?>
                          <option value="<?=$value->yetki?>"><?=$value->adi?></option>
                        <?php }?>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">Ad Soyad: <span class="required">* </span></label>
                  <div class="col-md-10">
                      <input type="text" class="form-control" id="adsoyad" name="adsoyad" placeholder="Ad Soyad" value="">
                  </div>

              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">E-posta: <span class="required">* </span></label>
                  <div class="col-md-10">
                      <input type="text" class="form-control" id="email" name="email" placeholder="E-posta" value="">
                  </div>

              </div>

              <div class="form-group">
                  <label class="control-label col-md-2">Durum</label>
                  <div class="col-md-10">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                       <label class="btn btn-default btn-primary active">
                         <input type="radio" name="durum" value="1"  checked> Göster
                       </label>
                       <label class="btn btn-default">
                         <input type="radio" name="durum" value="2"> Gösterme
                       </label>
                     </div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">Şifre Değiştir: </label>
                  <div class="col-md-10">
                      <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre" value="">
                  </div>

              </div>


            </div>
            <div class="form-actions right">
                <button type="button" name="back" class="btn btn-default btn-circle" onclick="javascript:history.back();" >
                    <i class="fa fa-angle-left"></i> Geri
                </button>
                <button class="btn green-haze btn-circle" onclick="islemEkle('yoneticiController','Ekle','0','yoneticiler.php');  return false"><i class="fa fa-check" ></i> Kaydet</button>
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
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<script type="text/javascript" src="assets/global/plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript" src="assets/admin/pages/scripts/kuark.maps.js" ></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js"></script>

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        $('.kategoriler').select2({
            placeholder: "Bir Seçim Yapınız.",
            allowClear: true
        });
        $('#order').spinner({value:0, min: 0, max: 100});
        $('#baslik').friendurl({id: 'seo', divider: '-', transliterate: true});

        $('.btn-toggle').click(function() {
          $(this).find('.btn').toggleClass('active');
          if ($(this).find('.btn-primary').size()>0) {
          	$(this).find('.btn').toggleClass('btn-primary');
          }
        });

    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
