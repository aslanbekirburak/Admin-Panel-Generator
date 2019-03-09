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
      $rows = $db->get_results("SELECT * FROM webservis_controller WHERE webservis_id='{$gelenid}'  ORDER BY id ASC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM webservis_controller WHERE webservis_id='{$gelenid}' ");
  } else{
      $rows = $db->get_results("SELECT * FROM webservis_controller WHERE webservis_id='{$gelenid}' AND methodadi LIKE '%".$qpost."%' ORDER BY id ASC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM webservis_controller WHERE webservis_id='{$gelenid}' AND methodadi LIKE '%".$qpost."%' ORDER BY id ASC");
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
      if($row->type!="post"){
        $duzenle_button='<a href="method_oge_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> ';
      }
      else{
        $duzenle_button="";
      }
        $records["data"][] = array(
            "DT_RowId" =>  $id,
            $row->type,
            $row->colname,
            $duzenle_button.'<a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>',
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

            $_POST["colshow"] = json_encode($_POST["colshow"]);

            if($_POST["jointable"] !=""){
              foreach ($_POST["jointable"] as $jk => $jv) {
                $jointable[$jk]["jointable"] = $jv;
                $jointable[$jk]["jointablecol"] = $_POST["jointablecol"][$jk];
                $jointable[$jk]["joincolname"] = $_POST["joincolname"][$jk];

                if($_POST["jointable"][$jk]==""  || $_POST["jointablecol"][$jk]=="" || $_POST["joincolname"][$jk]=="")
                {
                    $array["hata"] = "Tüm alanları doldurunuz ";
                    echo json_encode($array);
                    exit();
                }

              }
              unset($_POST["jointable"]);unset($_POST["jointablecol"]);unset($_POST["joincolname"]);
              $_POST["jointable"] = json_encode($jointable);
            }else{
              $_POST["jointable"] = "";
            }

            $logparam["note"]=$_SESSION['adsoyad']." method güncelledi.";
            $crud->update('webservis_controller',$_POST,"id='{$gelenid}'",$logparam);
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
           $Is_var= false;
            $_POST["colshow"] = json_encode($_POST["colshow"]);
            $type_row=$db->get_var("SELECT COUNT(id) AS sayi FROM webservis_controller WHERE webservis_id='{$gelenid}' AND type='{$_POST["type"]}'");

            if($type_row<1){
            if($_POST["jointable"] !=""){
              foreach ($_POST["jointable"] as $jk => $jv) {
                $jointable[$jk]["jointable"] = $jv;
                $jointable[$jk]["jointablecol"] = $_POST["jointablecol"][$jk];
                $jointable[$jk]["joincolname"] = $_POST["joincolname"][$jk];

                if($_POST["jointable"][$jk]==""  || $_POST["jointablecol"][$jk]=="" || $_POST["joincolname"][$jk]=="")
                {
                    $array["hata"] = "Tüm alanları doldurunuz ";
                    echo json_encode($array);
                    exit();
                }

              }
              unset($_POST["jointable"]);unset($_POST["jointablecol"]);unset($_POST["joincolname"]);
              $_POST["jointable"] = json_encode($jointable);
            }

            $logparam["note"]=$_SESSION['adsoyad']." method işlemi ekledi.";
            $crud->insert('webservis_controller',$_POST,$logparam);
            $insert_id = $crud->getResult();
            if($insert_id){
              $array["tamam"] = 'Ekleme işlemi başarılı bir şekilde tamamlanmıştır, Yönlendiriliyorsunuz lütfen  bekleyin...';
            }else{
                $array["hata"] = 'hata'.$db->debug();
            }
          }
          else
          {
            $array["hata"] = "Bu methoda bu tür daha önce eklendi.";
          }

    }else{
      $array["hata"] = "POST GELMEDİ";
    }
      echo json_encode($array);
}


if($q == 'Sil'){
    $ID = "id=".$_POST["id"];
    $logparam["note"]=$_SESSION['adsoyad']." method sildi.";
    $Update = $crud->delete('webservis_controller',$ID,$logparam);
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
        $sonuc = $crud->update('webservis_controller',$sirala,"id='{$item}'");
  }
}

if($q == 'Turgetir'){

$turid = $_POST["tur_id"];
$menuid = $_POST["menuid"];
$tablename=$db->get_var("SELECT databaseadi FROM webservis WHERE id='{$menuid}'");
$colums = $db->get_results("SHOW COLUMNS FROM  {$tablename} ");
if($turid == "delete"){
  ?>
  <div class="form-group">
    <label class="col-md-2 control-label">Where Sutun Adı:<span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control bs-select" name="colname" data-show-subtext="true">
            <option value="">Sütun Seçiniz</option>
            <?php foreach ($colums as $value) { ?>
              <option value="<?=$value->Field?>" ><?=$value->Field?></option>
            <?php } ?>
          </select>
      </div>
  </div>
<?php
}
elseif($turid=="put"){
  ?>
  <div class="form-group">
    <label class="col-md-2 control-label">Where Sutun Adı:<span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control bs-select" name="colname" data-show-subtext="true">
            <option value="">Sütun Seçiniz</option>
            <?php foreach ($colums as $value) { ?>
              <option value="<?=$value->Field?>" ><?=$value->Field?></option>
            <?php } ?>
          </select>
      </div>
  </div>
  <?php
}
elseif($turid=="post"){

}
elseif($turid=="get"){ ?>

  <div class="form-group">
    <label class="col-md-2 control-label">Where Sutun Adı:<span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control sutunlar" name="colname" data-show-subtext="true">
            <?php foreach ($colums as $value) { ?>
              <option value="<?=$value->Field?>" ><?=$value->Field?></option>
            <?php } ?>
          </select>
      </div>
  </div>



  <div id="dahafazlaekle"></div>

  <div class="form-group pull-right">
    <div class="col-md-12 ">
        <div class="btn blue" id="dahafazla"><i class="fa fa-plus" ></i> TABLO EKLE</div>
    </div>
  </div>
  <div style="clear:both"></div>
 <?php
}
elseif($turid=="getall"){ ?>

  <div class="form-group">
    <label class="col-md-2 control-label">Sıralama Sütünü:<span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control sutunlar" name="colordername" data-show-subtext="true">
            <?php foreach ($colums as $value) { ?>
              <option value="<?=$value->Field?>" ><?=$value->Field?></option>
            <?php } ?>
          </select>
      </div>
  </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Sıralama Yöntemi</label>
        <div class="col-md-10">
            <select class="form-control sutunlar" id="turgetir" name="colorder">
              <option value="asc">Artan</option>
              <option value="desc">Azalan</option>
            </select>
        </div>
    </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Sayfa Satır Sayısı: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control required" name="pagerowcount" placeholder="Page Row Count Sayısı" value="">
      </div>
  </div>


  <div id="dahafazlaekle"></div>

  <div class="form-group pull-right">
    <div class="col-md-12 ">
        <div class="btn blue" id="dahafazla"><i class="fa fa-plus" ></i> TABLO EKLE</div>
    </div>
  </div>

  <div style="clear:both"></div>

<?php
}

}
if($q == 'Sutungetir'){

$tbname = $_POST["tbname"];
?>

  <?php
  $colums = $db->get_results("SHOW COLUMNS FROM {$tbname} ");
      ?>
    <div class="col-md-2">
        <select class="form-control getsutunlar" name="jointablecol[]" data-show-subtext="true">
          <option value="">Sütun Seçiniz</option>
          <?php foreach ($colums as $value) {?>
            <option value="<?=$value->Field?>" ><?=$value->Field?></option>
          <?php }?>
        </select>
    </div>

<?php
}

ob_end_flush();
