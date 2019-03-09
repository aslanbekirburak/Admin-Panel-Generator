<?php
session_start();
ob_start();
include '../../vt/baglanti.php';
include '../../vt/func.php';
include('../../vt/mysql_crud.php');$crud = new Database();
$q = g('q');
$gelenid = g('id');
$logparam["userid"]= $_SESSION['kul_id'];
//echo $_FILES["gorsel"]["tmp_name"];
/* ################ MEKANLAR ################# */
if ($q == 'Listele') {
  $qpost = $_POST["q"];
  $uzunluk = intval($_REQUEST['length']);
  $basla = intval($_REQUEST['start']);

  if($qpost == "") {
      $rows = $db->get_results("SELECT * FROM kullanici ORDER BY id DESC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM kullanici");
  } else{
      $rows = $db->get_results("SELECT * FROM kullanici WHERE adsoyad LIKE '%".$qpost."%' ORDER BY id DESC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM kullanici WHERE adsoyad LIKE '%".$qpost."%' ORDER BY id DESC");
  }

  $iTotalRecords = count($toplamicin);
  $iDisplayLength = intval($_REQUEST['length']);
  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
  $iDisplayStart = intval($_REQUEST['start']);
  $sEcho = intval($_REQUEST['draw']);

    $records = array();
    $records["data"] = array();

    $end = $iDisplayStart + $iDisplayLength;
    $end = $end > $iTotalRecords ? $iTotalRecords : $end;

    $status_list = array(
      array("danger" => "Pasif"),
      array("success" => "Aktif"),
      array("danger" => "Pasif")
    );
    $statusClass = "info";
    $statusValue = "Aktif";

    foreach((array)$rows as $row) {
      $status = $status_list[$row->durum];
      if($row->durum == 1){
        $statusClass = "success";
        $statusValue = "Aktif";
      }else if($row->durum == 2){
        $statusClass = "success";
        $statusValue = "Aktif";
      }else if($row->durum == 3){
        $statusClass = "danger";
        $statusValue = "Pasif";
      }

      if (condition) {
        # code...
      }

      $id = $row->id;
      $grup = $db->get_var("SELECT adi FROM yetkiler WHERE yetki = '{$row->yetki}'");

      if($id != 1){
        $records["data"][] = array(
            "DT_RowId" =>  $id,
            $row->adsoyad,
            $row->email,
            $grup,
            '<a data-id="'.$id.'" data-tur="durum" data-value="'.$row->durum.'" class="durumdegistir btn btn-xs btn-editable label label-sm label-'.$statusClass.'" >'.$statusValue.'</a>',
            '<a href="yonetici_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>',
        );
      }
    }


    $records["draw"] = $sEcho;
    $records["recordsTotal"] = $iTotalRecords;
    $records["recordsFiltered"] = $iTotalRecords;

    echo json_encode($records);
}
/* ################ MEKANLAR END ################# */

if($q == 'Duzenle'){

    if($_POST){

          $name = $_POST["email"];
          if($_POST["sifre"] == ""){
            unset($_POST["sifre"]);
          }else{
            $_POST["sifre"] = md5($_POST["sifre"]);
          }

        if(!$name){
            $array["hata"] = 'Lütfen tüm alanları doldurunuz';
        }else{

            $logparam["note"]=$_SESSION['adsoyad']." kullanıcı güncelledi.";
            $crud->update('kullanici',$_POST,"id='{$gelenid}'",$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
                $array["tamam"] = 'Düzenleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }

        }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}

if($q == 'Ekle'){

    if($_POST){

          $name = $_POST["email"];
          $sifre = md5($_POST["sifre"]);
        if($name == "" OR $sifre == ""){
            $array["bilgi"] = 'Lütfen tüm alanları doldurunuz';
        }else{
            $_POST["sifre"] = $sifre;
            $logparam["note"]=$_SESSION['adsoyad']." kullanıcı ekledi.";
            $crud->insert('kullanici',$_POST,$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
              $array["tamam"] = 'Ekleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }

        }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}

if($q == 'Sil'){
    $ID = "id=".$_POST["id"];
    $logparam["note"]=$_SESSION['adsoyad']." kullanıcı sildi.";
    $Update = $crud->delete('kullanici',$ID,$logparam);
    if($Update){
        $array["tamam"] = 'Başarılı bir şekilde silinmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}

if($q == 'DurumDegistir'){
    $ID = $_POST["id"];
    unset($_POST["id"]);
    $durumdegistirpost[$_POST["tur"]] = $_POST["value"];
    $tur = $_POST["tur"];
    if($_POST["value"] == 1){ $durum = "Aktif";}else{$durum = "Pasif";}

    $logparam["note"]=$_SESSION['adsoyad']." ".$ID." nolu kullanıcı ". $tur ." ".$durum." olarak güncelledi.";
    $Update = $crud->update('kullanici',$durumdegistirpost,"id='{$ID}'",$logparam);
    if($Update){
        $array["tamam"] = 'Başarılı bir şekilde güncellenmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}

ob_end_flush();
