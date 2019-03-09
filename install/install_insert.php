<?php
$adsoyad=$_POST["adsoyad"];
$email=$_POST["email"];
$sifre1=$_POST["sifre1"];

include("../vt/baglanti.php");
if($sifre1)
{
  $sifre1 = md5($sifre1);
  $sql1 =$db->query("INSERT INTO kullanici (adsoyad,yetki,email,durum,sifre) VALUES ('$adsoyad','16','$email','1','$sifre1')");

  if ($sql1 == TRUE) {
    header('Location: ../yonetimpaneli/index.php?silinecek=1');
    }
  }
?>
