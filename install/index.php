<?php session_start();?><!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Kuark Dijital Panel Install</title>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>

	<body>
		<div class="container">
	       <div class="py-5 text-center">
	         <img class="d-block mx-auto mb-4" src="logo.png">
	       </div>
		<?php
		if($_GET["connectionerror"]==1)
		{ ?>
			<div class="alert alert-danger">
			<strong>Bağlantı Hatası!</strong> Database bilgilerinizi kontrol ediniz.
			</div>
<?php	} ?>
	<form class="form-signin" name="form" action="install_helper.php" method="post">
	<div class="container mb-4">
	<div class="form-label-group">
    <label >Hostname:</label>
	<input type="text" name="HOSTNAME" class="form-control" value="<?=$_SESSION["HOSTNAME"]?>" required autofocus>

	</div>

	<div class="form-label-group">
    <label >Database User:</label>
	<input type="text" name="HOSTUSER" class="form-control" value="<?=$_SESSION["HOSTUSER"]?>" required>

	</div>

  <div class="form-label-group">
      <label >Database Password:</label>
  <input type="text" name="HOSTPASS" class="form-control" value="<?=$_SESSION["HOSTPASS"]?>" required>

  </div>

  <div class="form-label-group">
      <label >Database Name:</label>
  <input type="text" name="DBNAME" class="form-control" value="<?=$_SESSION["DBNAME"]?>" required>

  </div>

  <div class="form-label-group">
      <label >Görsel Upload Klasörü:</label>
  <input type="text" name="GORSELUPLOADPATH" class="form-control" value="<?=$_SESSION["GORSELUPLOADPATH"]?>" placeholder="Örneğin: (images)" required>

  </div>

  <div class="form-label-group">
      <label >Site Yayın URL:</label>
  <input type="text" name="SITEURL" class="form-control" value="<?=$_SESSION["SITEURL"]?>" required>

  </div>

  <div class="form-label-group">
      <label >Firma Adı:</label>
  <input type="text" name="FIRMAADI" class="form-control" value="<?=$_SESSION["FIRMAADI"]?>" required>

  </div>

  <div class="form-label-group">
      <label >Google Api:(<a href="https://www.google.com/recaptcha" target="_blank">Yeni Al</a>)</label>
  <input type="text" name="GOOGLEAPI" class="form-control" value="<?=$_SESSION["GOOGLEAPI"]?>" required>

  </div>

  <div class="form-label-group">
    <label >Google Secret:</label>
  <input type="text" name="GOOGLESECRET" class="form-control" value="<?=$_SESSION["GOOGLESECRET"]?>" required>

  </div><br/>

  <input class="btn btn-info pull-right" type="submit" value="KAYDET ve DEVAM ET"><br/>
</div>
</form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php session_destroy(); ?>
	</body>
	</html>
