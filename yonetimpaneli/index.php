<?php ob_start();
require_once("top.php");

function klasorsil($klasor) {
   if($objs = glob($klasor."/*")){
       foreach($objs as $obj) {
           is_dir($obj)? klasorsil($obj) : unlink($obj);
       }
   }
   rmdir($klasor);
}

if($_GET["silinecek"]==1)
{
	klasorsil("../install");
	header('Location: index.php');
}
$msg='';
?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/global/plugins/sweetalert/sweetalert.min.js"></script>
<script src="assets/admin/kuarkdijital.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN GOOGLE RECAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js?hl=tr" async defer></script>
<script>
function onSubmit(token) {
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
                    window.location.href = "anasayfa.php";

              }, 3000);
          }
      }
  });
}
jQuery(document).ready(function() {
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layout

       // init background slide images
       $.backstretch([
        "assets/admin/pages/media/bg/1.jpg",
        "assets/admin/pages/media/bg/2.jpg",
        "assets/admin/pages/media/bg/3.jpg",
        "assets/admin/pages/media/bg/4.jpg"
        ], {
          fade: 1000,
          duration: 8000
    }
    );
});
</script>

<!-- END GOOGLE RECAPTCHA -->
<!-- END JAVASCRIPTS -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->

<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<div class="logo">
		<?=FIRMAADI?>
	</div>
	<!-- BEGIN LOGIN FORM -->
	<form onsubmit="return false" class="login-form" id="userLogin" action="islemler/kullaniciController.php?q=userLogin" method="POST" >
		<h3 class="form-title">Kullanıcı Adı Şifrenizi Giriniz</h3>
        <div class="basarisiz">
            <?=$msg?>
        </div>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>Kullanıcı Adı, Şifrenizi Girmelisiniz. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">E-Posta</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="E-Posta" name="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Şifre</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Şifre" name="password"/>
			</div>
		</div>

		<div class="form-actions">
      <button
              class="g-recaptcha btn blue pull-right"
              data-sitekey="<?=GOOGLEAPI?>"
              data-callback="onSubmit">
          Giriş
      </button>
		</div>

		<div class="create-account">
			<p>
				 Kullanıcı Adı ve Şifrenizi Bilmiyorsanız Lütfen Yöneticiye Başvurunuz.
			</p>
		</div>
	</form>
	<!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 2015 &copy; Yönetim Paneli.
</div>
<!-- END COPYRIGHT -->

</body>
<!-- END BODY -->
</html>
<?php ob_end_flush();
