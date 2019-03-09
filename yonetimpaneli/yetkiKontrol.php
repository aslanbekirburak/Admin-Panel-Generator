<script>
    function yetkiOnay(Url) {
        alert("Bu sayfaya erişim yetkiniz yok.");
        document.location = Url;
    }
</script>
<?php
require_once 'guvenlik.php';
if($_SESSION['yetki'] == ""){
  header("location:index.php");
}
$yetkilisayfalar = json_decode($db->get_var("SELECT erisilensayfalar FROM yetkiler WHERE yetki = '".$_SESSION['yetki']."'"));

foreach((array)$yetkilisayfalar as $yetkilisayfa){
    $phpsayfaadi[] = $db->get_var("SELECT sayfalar FROM yetki_sayfalar WHERE id = '".$yetkilisayfa."'");
}
if (@in_array($url, $phpsayfaadi)) {}else{echo "<script>yetkiOnay('index.php');</script>";exit();
}
