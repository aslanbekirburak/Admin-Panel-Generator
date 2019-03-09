<?php
session_start();
ob_start();
include '../../vt/baglanti.php';
include '../../vt/func.php';
include('../../vt/mysql_crud.php');$crud = new Database();
$q = g('q');
$gelenid = g('id');
$logparam["userid"]= $_SESSION['kul_id'];
/* ################ MEKANLAR ################# */
if ($q == 'Listele') {
  $qpost = $_POST["q"];
  $uzunluk = intval($_REQUEST['length']);
  $basla = intval($_REQUEST['start']);

  if($qpost == "") {
      $rows = $db->get_results("SELECT * FROM webservis ORDER BY id ASC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM webservis");
  } else{
      $rows = $db->get_results("SELECT * FROM webservis WHERE methodadi LIKE '%".$qpost."%' ORDER BY id ASC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM webservis WHERE methodadi LIKE '%".$qpost."%' ORDER BY id ASC");
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
    foreach((array)$rows as $row) {
      $id = $row->id;

        $buildpage = '<a href="method_ogeleri.php?id='.$id.'" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i>İşlemler</a>';
        $yonetimfonk = '<a href="method_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>'.$buildpage;

        $records["data"][] = array(
            "DT_RowId" =>  $id,
            $row->databaseadi,
            $row->methodadi,
            $yonetimfonk
          );
    }


    $records["draw"] = $sEcho;
    $records["recordsTotal"] = $iTotalRecords;
    $records["recordsFiltered"] = $iTotalRecords;

    echo json_encode($records);
}
/* ################ MEKANLAR END ################# */

if($q == 'Duzenle'){

    if($_POST){

          $name = $_POST["menuadi"];

            $logparam["note"]=$_SESSION['adsoyad']." method güncelledi.";
            $crud->update('webservis',$_POST,"id='{$gelenid}'",$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
                $array["tamam"] = 'Düzenleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}

if($q == 'Ekle'){

    if($_POST){

            $logparam["note"]=$_SESSION['adsoyad']." menü ekledi.";
            $crud->insert('webservis',$_POST,$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
              $array["tamam"] = 'Ekleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}


if($q == 'Sil'){
    $ID = "id=".$_POST["id"];
    $logparam["note"]=$_SESSION['adsoyad']." method sildi.";
    $Update = $crud->delete('webservis',$ID,$logparam);
    if($Update){
        $array["tamam"] = 'Başarılı bir şekilde silinmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}

if($q == 'Siralama'){
  foreach ($_POST['yenisira'] as $position => $item)
  {
        $sirala["sira"] = $position+1;
        $sonuc = $crud->update('webservis',$sirala,"id='{$item}'");
  }
}

if($q == 'DurumDegistir'){
    $ID = $_POST["id"];
    unset($_POST["id"]);
    $durumdegistirpost[$_POST["tur"]] = $_POST["value"];
    $tur = $_POST["tur"];
    if($_POST["value"] == 1){ $durum = "Aktif";}else{$durum = "Pasif";}

    $logparam["note"]=$_SESSION['adsoyad']." ".$ID." nolu menü ". $tur ." ".$durum." olarak güncelledi.";
    $Update = $crud->update('webservis',$durumdegistirpost,"id='{$ID}'",$logparam);
    if($Update){
        $array["tamam"] = 'Başarılı bir şekilde güncellenmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}

if($q == 'listeDuzenle'){

    if($_POST){

            $ckey = $_POST["columnshowkey"];
            unset($_POST["columnshowkey"]);
            $cvalue = $_POST["columnshowvalue"];
            unset($_POST["columnshowvalue"]);

            foreach ($ckey as $key => $value) {
              $columnshow[$value] = $cvalue[$key];
            }
            $_POST["columnshow"] = $columnshow;
            $crud_post["liste_oge"] = json_encode($_POST);

            $logparam["note"]=$_SESSION['adsoyad']." menü listesini güncelledi.";
            $crud->update('webservis',$crud_post,"id='{$gelenid}'",$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
                $array["tamam"] = 'Düzenleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }


    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}
ob_end_flush();
