<?php session_start();

$_SESSION["HOSTNAME"]=$_POST["HOSTNAME"];
$_SESSION["HOSTUSER"]=$_POST["HOSTUSER"];
$_SESSION["HOSTPASS"]=$_POST["HOSTPASS"];
$_SESSION["DBNAME"]=$_POST["DBNAME"];
$_SESSION["GORSELUPLOADPATH"]=$_POST["GORSELUPLOADPATH"];
$_SESSION["SITEURL"]=$_POST["SITEURL"];
$_SESSION["FIRMAADI"]=$_POST["FIRMAADI"];
$_SESSION["GOOGLEAPI"]=$_POST["GOOGLEAPI"];
$_SESSION["GOOGLESECRET"]=$_POST["GOOGLESECRET"];

$HOSTNAME=$_POST["HOSTNAME"];
$HOSTUSER=$_POST["HOSTUSER"];
$HOSTPASS=$_POST["HOSTPASS"];
$DBNAME=$_POST["DBNAME"];
$GORSELUPLOADPATH=$_POST["GORSELUPLOADPATH"];
$SITEURL=$_POST["SITEURL"];
$FIRMAADI=$_POST["FIRMAADI"];
$GOOGLEAPI=$_POST["GOOGLEAPI"];
$GOOGLESECRET=$_POST["GOOGLESECRET"];

$dbc = new mysqli($HOSTNAME,$HOSTUSER,$HOSTPASS,$DBNAME);

if($dbc->connect_errno){
header('Location: index.php?connectionerror=1');
exit();
}
$file = fopen("../vt/baglanti.php", "w");
fwrite($file,"<?php \ninclude_once \"ez_sql_core.php\";
include_once \"ez_sql_mysqli.php\";

date_default_timezone_set('Europe/Istanbul');

define('HOSTNAME', '$HOSTNAME');
define('HOSTUSER', '$HOSTUSER');
define('HOSTPASS', '$HOSTPASS');
define('DBNAME', '$DBNAME');
define('GORSELUPLOADPATH', '../../$GORSELUPLOADPATH');
define('SITEURL', '$SITEURL');
define('FIRMAADI', '$FIRMAADI');
define('GOOGLEAPI', '$GOOGLEAPI');
define('GOOGLESECRET', '$GOOGLESECRET');
\$db = new ezSQL_mysqli(HOSTUSER,HOSTPASS,DBNAME,HOSTNAME);
define('DILADI', 'utf8');

 define('DILKARSILASTIRMASI','utf8_turkish_ci');
 \$db->query(\"SET NAMES '\". DILADI. \"'\");
 \$db->query(\"SET CHARACTER SET \" . DILADI);
 \$db->query(\"SET COLLATION_CONNECTION = '\". DILKARSILASTIRMASI .\"'\");
 \$siteurl = SITEURL; \n ?>");

 fclose($file);

$tables=file_get_contents("db.txt");
$connection=$dbc->multi_query("$tables");
if($connection===TRUE){
  ?>
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
             <p>Lütfen Admin bilgilerini dikkatli ve doğru giriniz. Sonraki adımda bu bilgiler ile giriş yapacaksınız.</p>
  	       </div>
  	<form class="form-signin" name="form" action="install_insert.php" method="post">
      <div class="container mb-4">
    <div class="form-label-group">
      <label >Admin Ad Soyad:</label>
  	<input type="text" name="adsoyad" class="form-control" required autofocus>

  	</div>

  	<div class="form-label-group">
      <label>E-Posta:</label>
  	<input type="email" name="email" class="form-control" required>

  	</div>

    <div class="form-label-group">
        <label>Şifre:</label>
    <input type="password" name="sifre1" class="form-control" required>

    </div>

    <hr class="mb-4">
      <input class="btn btn-info btn-lg btn-block" type="submit" value="KAYDET ve BİTİR"><br/>

  </div>
  </form>
</div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  	</body>
  	</html>


<?php }
else{
print_r($dbc->error);
}
?>
