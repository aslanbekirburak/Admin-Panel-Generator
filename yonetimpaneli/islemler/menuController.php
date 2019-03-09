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
      $rows = $db->get_results("SELECT * FROM yetki_sayfalar ORDER BY ust_id,sira ASC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM yetki_sayfalar");
  } else{
      $rows = $db->get_results("SELECT * FROM yetki_sayfalar WHERE menuadi LIKE '%".$qpost."%' ORDER BY ust_id,sira ASC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM yetki_sayfalar WHERE menuadi LIKE '%".$qpost."%' ORDER BY ust_id,sira ASC");
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
      if($row->ust_id==0){$menutipi="Üst Menü";}else{$menutipi="Alt Menü";}
      $id = $row->id;
      $status = $status_list[$row->goster];
      if($row->goster == 1){$statusvalue = 2;}else{$statusvalue = 1;}
      if($row->type != "listele"){
        $buildpage = '<a href="sayfa_ogeleri.php?id='.$id.'" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Form Öğeleri</a>';
      }else{
        $buildpage = '<a href="liste_ogeleri.php?id='.$id.'" class="btn btn-xs blue btn-editable"><i class="fa fa-pencil"></i> Liste Öğeleri</a>';
      }
      if($id>23){
        $yonetimfonk = '<a href="menu_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>'.$buildpage;
        $durumfonk = '<a data-id="'.$id.'" data-tur="goster" data-value="'.$statusvalue.'" class="durumdegistir btn btn-xs btn-editable label label-sm label-'.(key($status)).'" >'.(current($status)).'</a>';

        $records["data"][] = array(
            "DT_RowId" =>  $id,
            $row->sira,
            $menutipi,
            $row->menuadi,
            $durumfonk,
            $yonetimfonk,
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

          $name = $_POST["menuadi"];

        if(!$name){
            $array["hata"] = 'Lütfen tüm alanları doldurunuz';
        }else{
            $_POST["sayfalar"] = $_POST["databaseadi"]."_".$_POST["type"].".php";
            $logparam["note"]=$_SESSION['adsoyad']." menü güncelledi.";
            $crud->update('yetki_sayfalar',$_POST,"id='{$gelenid}'",$logparam);
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

          $name = $_POST["menuadi"];

        if(!$name){
            $array["bilgi"] = 'Lütfen tüm alanları doldurunuz';
        }else{
            $_POST["sayfalar"] = $_POST["databaseadi"]."_".$_POST["type"].".php";
            $logparam["note"]=$_SESSION['adsoyad']." menü ekledi.";
            $crud->insert('yetki_sayfalar',$_POST,$logparam);
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
    $logparam["note"]=$_SESSION['adsoyad']." menü sildi.";
    $silsayfa = $db->get_row("SELECT databaseadi, type FROM yetki_sayfalar WHERE $ID");
    $Update = $crud->delete('yetki_sayfalar',$ID,$logparam);
    if($Update){
        unlink("../".$silsayfa->databaseadi."_".$silsayfa->type.".php");
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
        $sonuc = $crud->update('yetki_sayfalar',$sirala,"id='{$item}'");
  }
}

if($q == 'DurumDegistir'){
    $ID = $_POST["id"];
    unset($_POST["id"]);
    $durumdegistirpost[$_POST["tur"]] = $_POST["value"];
    $tur = $_POST["tur"];
    if($_POST["value"] == 1){ $durum = "Aktif";}else{$durum = "Pasif";}

    $logparam["note"]=$_SESSION['adsoyad']." ".$ID." nolu menü ". $tur ." ".$durum." olarak güncelledi.";
    $Update = $crud->update('yetki_sayfalar',$durumdegistirpost,"id='{$ID}'",$logparam);
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
            $crud->update('yetki_sayfalar',$crud_post,"id='{$gelenid}'",$logparam);
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
