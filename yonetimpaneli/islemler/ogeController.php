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

      $rows = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '{$gelenid}' ORDER BY sira ASC LIMIT {$basla},{$uzunluk}");

      $toplamicin = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '{$gelenid}'");
  } else{
      $rows = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '{$gelenid}' AND label_name LIKE '%".$qpost."%' ORDER BY sira ASC LIMIT $basla,$uzunluk");

      $toplamicin = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '{$gelenid}' AND label_name LIKE '%".$qpost."%' ORDER BY sira ASC");
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

      $records["data"][] = array(
          "DT_RowId" =>  $id,
          $row->sira,
          $row->label_name,
          $row->form_type,
          '<a href="oge_duzenle.php?id='.$id.'" class="btn btn-xs green btn-editable"><i class="fa fa-pencil"></i> Düzenle</a> <a data-id="'.$id.'" class="sil btn btn-xs red btn-editable"><i class="fa fa-times"></i> Sil</a>',
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


            $logparam["note"]=$_SESSION['adsoyad']." öğe güncelledi.";
            $crud->update('file_controllers',$_POST,"id='{$gelenid}'",$logparam);
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


            $logparam["note"]=$_SESSION['adsoyad']." öğe ekledi.";
            $_POST["Php_adress"] = $db->get_var("SELECT sayfalar FROM yetki_sayfalar WHERE id = '".$_POST["file_id"]."'");
            $crud->insert('file_controllers',$_POST,$logparam);
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
    $logparam["note"]=$_SESSION['adsoyad']." menü sildi.";
    $Update = $crud->delete('file_controllers',$ID,$logparam);
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
        $sonuc = $crud->update('file_controllers',$sirala,"id='{$item}'");
  }
}

if($q == 'Turgetir'){

$turid = $_POST["tur_id"];
$menuid = $_POST["menuid"];
$row = $db->get_row("SELECT liste_oge,databaseadi from yetki_sayfalar WHERE id = {$menuid} ");
$colums = $db->get_results("SHOW COLUMNS FROM {$row->databaseadi}");

if($turid == "text_input"){
  echo '
  <div class="form-group">
      <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control kategoriler" name="form_name" >
          <option value="">Seçim Yapınız</option>
          ';
           foreach ($colums as $value) {
              echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
             }
          echo '</select>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label_name" placeholder="Öğe Başlık Adı" value="">
      </div>
  </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Placeholder Adı: <span class="required">* </span></label>
        <div class="col-md-10">
            <input type="text" class="form-control"name="Placeholder" placeholder="Placeholder Adı" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Zorunluluk:</label>
        <div class="col-md-10">
            <div class="btn-group btn-toggle" data-toggle="buttons">
             <label class="btn btn-default btn-primary active">
               <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
             </label>
             <label class="btn btn-default">
               <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
             </label>
           </div>
        </div>
    </div>
';
}
elseif($turid=="gorsel_input"){
echo'
    <div class="form-group">
        <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
        <div class="col-md-10">
            <input type="text" class="form-control"name="form_name" placeholder="Input name" value="">
            <span class="formNote">Eğer ikinci görsel ekliyorsanız daha önceki name adından başka bir ad kullanınız.</span>
        </div>
    </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label_name" placeholder="Öğe Başlık Adı" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Width Giriniz: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="width" placeholder="width Adı" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Height Giriniz: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control" name="height" placeholder="height Adı" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="control-label col-md-2">Zorunluluk:</label>
      <div class="col-md-10">
          <div class="btn-group btn-toggle" data-toggle="buttons">
           <label class="btn btn-default btn-primary active">
             <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
           </label>
           <label class="btn btn-default">
             <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
           </label>
         </div>
      </div>
  </div>
';
}
elseif($turid=="textarea"){
echo'
<div class="form-group">
    <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control kategoriler" name="form_name" >
        <option value="">Seçim Yapınız</option>
        ';
         foreach ($colums as $value) {
            echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
           }
        echo '</select>
    </div>
</div>

  <div class="form-group">
      <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label_name" placeholder="Öğe Label Adı" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="control-label col-md-2">Zorunluluk:</label>
      <div class="col-md-10">
          <div class="btn-group btn-toggle" data-toggle="buttons">
           <label class="btn btn-default btn-primary active">
             <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
           </label>
           <label class="btn btn-default">
             <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
           </label>
         </div>
      </div>
  </div>
';
}
elseif($turid=="datetime_input"){
echo'

<div class="form-group">
    <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control kategoriler" name="form_name" >
        <option value="">Seçim Yapınız</option>
        ';
         foreach ($colums as $value) {
            echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
           }
        echo '</select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
    <div class="col-md-10">
        <input type="text" class="form-control"name="label_name" placeholder="Öğe Label Adı" value="">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Placeholder Adı: <span class="required">* </span></label>
    <div class="col-md-10">
        <input type="text" class="form-control"name="Placeholder" placeholder="Placeholder Adı" value="">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Zorunluluk:</label>
    <div class="col-md-10">
        <div class="btn-group btn-toggle" data-toggle="buttons">
         <label class="btn btn-default btn-primary active">
           <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
         </label>
         <label class="btn btn-default">
           <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
         </label>
       </div>
    </div>
</div>
';
}
elseif($turid=="spinner_input"){
echo'

<div class="form-group">
    <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control kategoriler" name="form_name" >
        <option value="">Seçim Yapınız</option>
        ';
         foreach ($colums as $value) {
            echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
           }
        echo '</select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
    <div class="col-md-10">
        <input type="text" class="form-control"name="label_name" placeholder="Öğe Label Adı" value="">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Zorunluluk:</label>
    <div class="col-md-10">
        <div class="btn-group btn-toggle" data-toggle="buttons">
         <label class="btn btn-default btn-primary active">
           <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
         </label>
         <label class="btn btn-default">
           <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
         </label>
       </div>
    </div>
</div>
';
}
elseif($turid=="hashtag_input"){
echo'

<div class="form-group">
    <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control kategoriler" name="form_name" >
        <option value="">Seçim Yapınız</option>
        ';
         foreach ($colums as $value) {
            echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
           }
        echo '</select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Başlık Giriniz: <span class="required">* </span></label>
    <div class="col-md-10">
        <input type="text" class="form-control"name="label_name" placeholder="Öğe Label Adı" value="">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Zorunluluk:</label>
    <div class="col-md-10">
        <div class="btn-group btn-toggle" data-toggle="buttons">
         <label class="btn btn-default btn-primary active">
           <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
         </label>
         <label class="btn btn-default">
           <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
         </label>
       </div>
    </div>
</div>
';
}
elseif($turid=="radio"){
echo'

<div class="form-group">
    <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control kategoriler" name="form_name" >
        <option value="">Seçim Yapınız</option>
        ';
         foreach ($colums as $value) {
            echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
           }
        echo '</select>
    </div>
</div>

  <div class="form-group">
      <label class="col-md-2 control-label">Başlık nedir:<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label_name" placeholder="label  Adı" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Radio Başlık 1 :<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control" name="label1" placeholder=" Radio Başlık 1 " value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Radio Value 1:<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control" name="value1" placeholder="Radio Value 1" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Radio Başlık 2:<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label2" placeholder="Radio Başlık 2" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Radio Value 2:<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="value2" placeholder="Radio Value 2" value="">
      </div>
  </div>

  <div class="form-group">
      <label class="control-label col-md-2">Zorunluluk:</label>
      <div class="col-md-10">
          <div class="btn-group btn-toggle" data-toggle="buttons">
           <label class="btn btn-default btn-primary active">
             <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
           </label>
           <label class="btn btn-default">
             <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
           </label>
         </div>
      </div>
  </div>
';
}
elseif($turid == "dropdown"){?>

  <div class="form-group">
      <label class="col-md-2 control-label">Input Name: <span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control kategoriler" name="form_name" >
          <option value="">Seçim Yapınız</option>
          <?php
           foreach ($colums as $value) {
              echo '<option value="'.$value->Field.'">'.$value->Field.'</option>';
            } ?>
          </select>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2 control-label">Başlık:<span class="required">* </span></label>
      <div class="col-md-10">
          <input type="text" class="form-control"name="label_name" placeholder="label  Adı" value="">
      </div>
  </div>

  <div class="form-group">
    <?php $sql=$db->get_col("SHOW TABLES",0);
          ?>
      <label class="col-md-2 control-label">DataBase Table:<span class="required">* </span></label>
      <div class="col-md-10">
          <select class="form-control selectoge" id="vargetir" name="Database_name" data-show-subtext="true">
            <option value="">Table Seçiniz</option>
            <?php foreach ($sql as $key => $tables): ?>
              <option value=<?=$tables?>><?=$tables?></option>
             <?php endforeach; ?>
          </select>
      </div>
  </div>

  <div id="sutunresponse"></div>

  <div class="form-group">
      <label class="control-label col-md-2">Zorunluluk:</label>
      <div class="col-md-10">
          <div class="btn-group btn-toggle" data-toggle="buttons">
           <label class="btn btn-default btn-primary active">
             <input type="radio" name="zorunluluk" value="required" checked> Zorunlu
           </label>
           <label class="btn btn-default">
             <input type="radio" name="zorunluluk" value=""> Zorunlu Değil
           </label>
         </div>
      </div>
  </div>

<?php
}

}

if($q == 'Sutungetir'){

$tbname = $_POST["tbname"];
?>
<div class="form-group">
  <?php
  //$row = $db->get_row("SELECT databaseadi from yetki_sayfalar WHERE id = {$gelenid} ");
  $colums = $db->get_results("SHOW COLUMNS FROM {$tbname} ");
        ?>
    <label class="col-md-2 control-label">Option Name:<span class="required">* </span></label>
    <div class="col-md-10">
        <select class="form-control bs-select" name="Database_var_name" data-show-subtext="true">
          <option value="">Sütun Seçiniz</option>
          <?php foreach ($colums as $value) {?>
            <option value="<?=$value->Field?>" ><?=$value->Field?></option>
          <?php }?>
        </select>
    </div>
</div>
<?php
}
ob_end_flush();
