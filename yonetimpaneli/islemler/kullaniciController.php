<?php
session_start();
ob_start();
include '../../vt/baglanti.php';
include '../../vt/func.php';
$q = g('q');
$q2 = g('q2');

/* ################ USER LOGIN ################# */
if ($q == 'userLogin') {
    if($_POST){
      $recaptcha=$_POST['g-recaptcha-response'];
      if(!empty($recaptcha)) {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".GOOGLESECRET."&response=" . $recaptcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . success == false) {
          $array["hata"] = 'Doğrulama Kodunu Yanlış Girdiniz.';
        } else {

          $username = p('username');
          $user_password = md5(p('password'));

          if(!$username || !$user_password ) {
              $array["hata"] = 'Lütfen bilgilerinizi giriniz.';
          }else{

              $sorgu = "SELECT count(id) FROM kullanici WHERE email='$username' AND durum = 1";
              if ($db->get_var($sorgu) > 0) {

                  $sorgu2 = "SELECT * FROM kullanici WHERE email='$username' AND sifre='$user_password' AND durum = 1 ";

                  if ($sonuc2 = $db->get_row($sorgu2)) {

                      $uye = $db->get_row("SELECT * FROM kullanici WHERE email='$username'");

                      $userUpdate = $db->query("UPDATE kullanici SET
                        lastlogin_date = '$simdikiZaman',
                        lastlogin_ip = '$ipAdresi'
                        WHERE email='$username'");

                        $_SESSION['yetki'] = $uye->yetki;
                        $_SESSION['kul_id'] = $uye->id;
                        $_SESSION['adsoyad'] = $uye->adsoyad;

                      $array["ok"] = 'Başarılı bir şekilde giriş yapıldı, yönlendiriliyorsunuz.';
                      $array["yetki"] = $uye->yetki;
                  } else {
                      $array["hata"] = 'Lütfen kullanıcı adı veya şifrenizi kontrol ediniz.';
                  }
              } else {
                  $array["bilgi"] = 'Böyle bir yönetici bulunmuyor.';
              }
          }
        }
      }else{
        $array["bilgi"] = 'Doğrulama Kodunu Boş Bıraktınız.';
      }

        echo json_encode($array);
    }
}
/* ################ USER LOGIN END ################# */

ob_end_flush();
