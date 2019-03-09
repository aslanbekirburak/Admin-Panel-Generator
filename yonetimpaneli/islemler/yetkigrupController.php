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
      $rows = $db->get_results("SELECT * FROM yetkiler ORDER BY id DESC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM yetkiler");
  } else{
      $rows = $db->get_results("SELECT * FROM yetkiler WHERE adi LIKE '%".$qpost."%' ORDER BY id DESC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM yetkiler WHERE adi LIKE '%".$qpost."%' ORDER BY id DESC");
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



    foreach((array)$rows as $row) {

      $id = $row->id;

      if($id != 1){
        $records["data"][] = array(
            "DT_RowId" =>  $id,
            $row->adi,
            $row->yetki,
            '<a href="yetki_grup_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>',
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

          $name = $_POST["adi"];
          $_POST["erisilensayfalar"] = json_encode($_POST["erisilensayfalar"]);

        if(!$name){
            $array["hata"] = 'Lütfen tüm alanları doldurunuz';
        }else{

            $logparam["note"]=$_SESSION['adsoyad']." yetki grubunu güncelledi.";
            $crud->update('yetkiler',$_POST,"id='{$gelenid}'",$logparam);
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

          $name = $_POST["adi"];
          $_POST["erisilensayfalar"] = json_encode($_POST["erisilensayfalar"]);

        if(!$name){
            $array["bilgi"] = 'Lütfen tüm alanları doldurunuz';
        }else{

            $logparam["note"]=$_SESSION['adsoyad']." yetki grubunu ekledi.";
            $crud->insert('yetkiler',$_POST,$logparam);
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
    $logparam["note"]=$_SESSION['adsoyad']." yetki grubunu sildi.";
    $Update = $crud->delete('yetkiler',$ID,$logparam);
    if($Update){
        $array["tamam"] = 'Başarılı bir şekilde silinmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}


ob_end_flush();
