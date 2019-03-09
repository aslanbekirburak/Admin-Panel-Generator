<?php
include_once "ez_sql_core.php";
include_once "ez_sql_mysqli.php";

date_default_timezone_set('Europe/Istanbul');

define('HOSTNAME', 'localhost');
define('HOSTUSER', 'admin_yonetim');
define('HOSTPASS', 'Asdasd123');
define('DBNAME', 'admin_yonetim');
define('GORSELUPLOADPATH', '../../images');
define('SITEURL', 'http://yonetim.kuark.digital');
define('FIRMAADI', 'Kuark Dijital');
define('GOOGLEAPI', '6Lc53y0UAAAAAMDZ1N618DxGA3zJq5cd7GkwjBSm');
define('GOOGLESECRET', '6Lc53y0UAAAAACiaXpmwD3j19ksALfoD06-4eMZw');
$db = new ezSQL_mysqli(HOSTUSER,HOSTPASS,DBNAME,HOSTNAME);
define('DILADI', 'utf8');

 define('DILKARSILASTIRMASI','utf8_turkish_ci');
 $db->query("SET NAMES '". DILADI. "'");
 $db->query("SET CHARACTER SET " . DILADI);
 $db->query("SET COLLATION_CONNECTION = '". DILKARSILASTIRMASI ."'");
 $siteurl = SITEURL;
 ?>
