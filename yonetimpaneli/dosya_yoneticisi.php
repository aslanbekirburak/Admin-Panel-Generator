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
    <?php require_once("sidebar.php");?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE CONTENT-->

					<!-- Begin: life time stats -->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-briefcase font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Dosya Yöneticisi</span>
								<span class="caption-helper">Dosyalarınızı yönetin...</span>
							</div>

						</div>
            <div class="portlet-body">
                <div class="table-container">

                    <div id="da-ex-elfinder"></div>

                </div>
            </div>
					</div>
					<!-- End: life time stats -->

			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- elFinder Plugin -->

<?php require_once("bottom.php");?>




</body>
<!-- END BODY -->
</html>
