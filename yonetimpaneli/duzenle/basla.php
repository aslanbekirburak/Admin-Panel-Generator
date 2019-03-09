<?php
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);
session_start();
$not_open="javascript:;";

$sql = "SELECT sayfalar FROM yetki_sayfalar WHERE sayfalar!='".$not_open."'";
$result=$conn->query($sql);
?>
<form name="form" action="basla.php" method="post">
 hangi sayfa duzenlenecek:<br/>
<select name="page"><?php
if($result->num_rows > 0){
 while($row = $result->fetch_assoc()){
     echo "<option>".$row['sayfalar']."</option>";
 }
}?>
<input type="submit" value="ekle">
</form>

<?php
$which_page=$_POST["page"];
$_SESSION["EkleSilPage"] = $which_page;
if($which_page!=NULL)
{
   header("Location: http://yonetim.kuark.digital/$which_page");
}
?></select>
