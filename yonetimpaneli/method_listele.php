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
								<i class="icon-list font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Method Listesi</span>
								<span class="caption-helper">Methodları yönetin...</span>
							</div>
							<div class="actions">
								<a href="method_ekle.php" class="btn btn-default btn-circle">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Yeni Ekle </span>
								</a>
							</div>
						</div>
            <div class="portlet-body">
                <div class="table-container">
                    <?php echo $msg;?>
                    <div class="table-actions-wrapper">
      <span>
      </span>
                        <input type="text" class="form-control form-filter input-sm" name="q" placeholder="Ara...">
                    </div>

                    <table class="table table-striped table-bordered table-hover" id="datatable">
                        <thead>
                        <tr role="row" class="heading">

                          <th>
                             Database Adı
                          </th>
                            <th >
                                Method Adı
                            </th>
                            <th width="30%">
                                Yönetim
                            </th>
                        </tr>
                        </thead >
                        <tbody id="sortable">
                        </tbody>
                    </table>
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

<?php require_once("bottom.php");?>

<script>
    jQuery(document).ready(function() {
        islemListesi("webservice");

    });
</script>
</body>
<!-- END BODY -->
</html>
