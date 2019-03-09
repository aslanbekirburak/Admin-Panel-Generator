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
$cs = $db->get_row("SELECT liste_oge,sayfalar FROM yetki_sayfalar WHERE type = 'listele' AND databaseadi = '{$tablename}'");
if ($q == 'Listele') {
  $qpost = $_POST["q"];
  $uzunluk = intval($_REQUEST['length']);
  $basla = intval($_REQUEST['start']);

  $cs2 = $db->get_row("SELECT sayfalar FROM yetki_sayfalar WHERE type = 'duzenle' AND databaseadi = '{$tablename}'");
  $duzenlesayfa = $cs2->sayfalar;
  $cs = json_decode($cs->liste_oge);
  $wherename = $cs->wherename;
  $ordercolumn = $cs->ordername;
  $statuscolumn = $cs->statusname;
  $columnshow = $cs->columnshow;

  if($qpost == "") {
      $rows = $db->get_results("SELECT * FROM ".$tablename." ORDER BY ".$ordercolumn." ASC LIMIT {$basla},{$uzunluk}");
      $toplamicin = $db->get_results("SELECT * FROM ".$tablename." ");
  } else{
      $rows = $db->get_results("SELECT * FROM ".$tablename." WHERE ".$wherename." LIKE '%".$qpost."%' ORDER BY ".$ordercolumn." ASC LIMIT $basla,$uzunluk");
      $toplamicin = $db->get_results("SELECT * FROM ".$tablename." WHERE ".$wherename." LIKE '%".$qpost."%' ");
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

    // TODO: kategori sütünu olunca inner join yapmak gerekli. 23 Ocak 2018
    foreach((array)$rows as $row) {

      $id = $row->id;
      $columnshowdata["DT_RowId"] = $id;
      foreach ($columnshow as $keys => $values) {
        $columnshowdata[] = $row->{$keys};
      }
      $columnshowdata[] = '<a href="'.$duzenlesayfa.'?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>';
      $records["data"][] = $columnshowdata;
      unset($columnshowdata);
    }


    $records["draw"] = $sEcho;
    $records["recordsTotal"] = $iTotalRecords;
    $records["recordsFiltered"] = $iTotalRecords;

    echo json_encode($records);
}

if($q == 'Sil'){
    $tablename = g('t');
    $silid = $_POST["id"];
    $ID = "id=".$_POST["id"];
    $logparam["note"]=$_SESSION['adsoyad']." $tablename sildi.";
    $Update = $crud->delete($tablename,$ID,$logparam);
    if($Update){
      $gorseller = $db->get_results("SELECT f.form_name FROM yetki_sayfalar AS ys INNER JOIN file_controllers AS f ON ys.id = f.file_id WHERE ys.databaseadi = '{$tablename}' AND f.form_type = 'gorsel_input' AND ys.type = 'ekle' ");
      foreach ((array)$gorseller as $k => $v) {
        if(file_exists(GORSELUPLOADPATH."/".$tablename."/".$v->form_name."_".$silid.".jpg")){
          unlink(GORSELUPLOADPATH."/".$tablename."/".$v->form_name."_".$silid.".jpg");
        }
      }

        $array["tamam"] = 'Başarılı bir şekilde silinmiştir.';
    }else{
        $array["hata"] = 'hata'.$db->debug();
    }

    echo json_encode($array);
}

if($q == 'Siralama'){
  $tablename = g('t');
  $data = json_decode($cs->liste_oge);
  foreach ($_POST['yenisira'] as $position => $item)
  {
        $sirala[$data->ordername] = $position+1;
        $sonuc = $crud->update($tablename,$sirala,"id='{$item}'");
  }
}

ob_end_flush();
