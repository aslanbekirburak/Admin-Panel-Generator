<?php
session_start();
ob_start();
include '../../vt/baglanti.php';
include '../../vt/func.php';
include('../../vt/mysql_crud.php');$crud = new Database();
$q = g('q');
$gelenid = g('id');
$logparam["userid"]= $_SESSION['kul_id'];

$tablename = g('t');

if($q == 'Ekle'){

    if($_POST){

            unset($_POST["_wysihtml5_mode"]);

            $gorseller = $db->get_results("SELECT f.form_name,f.width,f.height FROM yetki_sayfalar AS ys INNER JOIN file_controllers AS f ON ys.id = f.file_id WHERE ys.databaseadi = '{$tablename}' AND f.form_type = 'gorsel_input' AND ys.type = 'ekle' ");
            foreach ((array)$gorseller as $k => $v) {
              $gorselname[$v->form_name]["w"] = $v->width;
              $gorselname[$v->form_name]["h"] = $v->height;
              $gorselname[$v->form_name]["data"] = $_POST[$v->form_name];
              unset($_POST[$v->form_name]);
            }

            $logparam["note"]=$_SESSION['adsoyad']." ".$tablename." ekledi.";
            $crud->insert($tablename,$_POST,$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
              if (!file_exists(GORSELUPLOADPATH)) {
                  mkdir(GORSELUPLOADPATH, 0777);
              }
              $dir = GORSELUPLOADPATH."/".$tablename;
              if (!file_exists($dir)) {
                  mkdir($dir, 0777);
              }
              foreach ((array)$gorselname as $nk => $nv) {
                  $gorsel_dosya = GORSELUPLOADPATH."/".$tablename."/".$nk."_" . $insert_id[0].".jpg";
                  move_imagedata_file($nv["data"], $gorsel_dosya,$nv["w"],$nv["h"]);
              }

              $array["tamam"] = 'Ekleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}

ob_end_flush();
