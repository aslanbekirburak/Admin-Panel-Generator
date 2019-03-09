<?php
include "../vt/baglanti.php";
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);
//$selected_table = $_POST["selected_table"];
?>

<form name="form" action="dropdown_helper.php" method="post">

<b>Label name:</b><br />
<input type="text" name="label_name" size="24"><br /><br />

<b>DataBase Name:</b><br />
<?php $sql=$db->get_col("SHOW TABLES",0);
      ?>
      <br/><select name="datatable">
        <?php foreach ($sql as $key => $tables): ?>
          <option value=<?=$tables?>><?=$tables?></option>
         <?php endforeach; ?>
      </select>
      <!--<br>
      <select class="" name="selected_table_column">
        <option value="0">Seçiniz</option>
        <?php
           $query = $db->get_results("SELECT `COLUMN_NAME`
             FROM `INFORMATION_SCHEMA`.`COLUMNS`
             WHERE `TABLE_SCHEMA`='admin_yonetim'
             AND `TABLE_NAME`='$selected_table'");
             foreach ($query as $column_name) {
             echo "<option value='$column_name->COLUMN_NAME' > $column_name->COLUMN_NAME</option>";
           }?> -->
      </select>

<br/><b>listenecek variable:</b><br/>
<input type="text" name="table_variable" size="24"><br /><br />

<b>name:</b><br />
<input type="text" name="name" size="24"><br /><br />

<b>id:</b><br />
<input type="text" name="id" size="24"><br /><br />

 <input type="submit" value="ekle"><br/>

</form>
