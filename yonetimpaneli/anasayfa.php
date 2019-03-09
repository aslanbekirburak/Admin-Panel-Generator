<?php ob_start();
require_once("top.php"); require_once("yetkiKontrol.php");

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
    <?php require_once("sidebar.php");?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Özet</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->

			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
        <div class="col-md-12">
        <?=FIRMAADI?> Yönetim Paneline Hoşgeldiniz. Soldaki Menüden İşlemlerinizi Yapabilirsiniz.
        </div>
      </div>
      <!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php require_once("bottom.php");?>

</body>
<!-- END BODY -->
</html>
