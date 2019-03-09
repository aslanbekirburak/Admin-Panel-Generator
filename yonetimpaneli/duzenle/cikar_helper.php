<?php
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);

include "../vt/baglanti.php";
session_start();

$labelname=$_POST["label_name"];
$adressname=$_POST["adress_name"];

        $file = fopen($adressname,"w");
//default başlangıç yazma kısmı
          $read_file = fopen("../deneme/default.txt", "r");

          $line = fgets($read_file);
          fwrite($file,$line);

          while (!feof($read_file) ) {

          $line = fgets($read_file);
          fwrite($file,$line);

          }
    fclose($read_file);
    fclose($file);
   $adress_id = $db->get_var("SELECT id FROM yetki_sayfalar WHERE sayfalar = '$adressname'");
  //$_SESSION["address_id"] = $adress_id;
$sql1 = "DELETE FROM file_controllers WHERE file_id='".$adress_id."' AND label_name='".$labelname."'";
if ($conn->query($sql1) === TRUE) {

//default başlangıç yazma sonu
  $adress_id = $db->get_var("SELECT id FROM yetki_sayfalar WHERE sayfalar = '$adressname'");

  $result_form = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '$adress_id'");

  foreach ($result_form as $key => $value) {

    if($value->form_type=="text_input")
      {    echo "foreach if input";

        text_input_writer($value->label_name,$value->form_name,$value->form_selector_id,$value->placeholder);}

    if($value->form_type=="radio")
      {    echo "foreach if radio";

        radio_writer($value->label_name,$value->form_name,$value->label1,$value->label2,$value->value1,$value->value2);}

    if($value->form_type=="dropdown")
      {    echo "foreach if dropdown";

        dropdown_writer($value->label_name,$value->form_name,$value->form_selector_id,$value->Database_name,$value->Database_var_name);}

    // print_r($value->form_name ." ");
    // print_r(" - ".$value->label_name ." ");
  }
}
function radio_writer($label_name,$form_name,$label1,$label2,$value1,$value2)
{
  $adressname=$_POST["adress_name"];
  $radio_file = fopen("../deneme/radio.txt", "r");
  $file = fopen($adressname,"a");
  echo "inside radio writer".$adressname;
  //$myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($radio_file);
  fwrite($file,$line);
  while (!feof($radio_file) ) {
  $line = fgets($radio_file);
  fwrite($file,check_for_replace_radio($line,$label_name,$value1,$form_name,$value2,$label1,$label2));
  }
  fclose($radio_file);
  fclose($file);
}
function check_for_replace_radio($line,$label_name,$value1,$form_name,$value2,$label1,$label2)
{
  echo "BASLANGIC".$label_name."///////".$value1."///////".$form_name."///////".$value2."///////".$label1."///////".$label2."BİTİS";
   $line=str_replace('{value1}', $value1, $line);
   $line=str_replace('{value2}', $value2, $line);
   $line=str_replace('{label1}', $label1, $line);
   $line=str_replace('{label2}', $label2, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{label_name}', $label_name, $line);
   return $line;
}
function dropdown_writer($label_name,$form_name,$form_selector_id,$Database_name,$Database_var_name)
{
  $drop_file = fopen("../deneme/dropdown.txt", "r");
  $file = fopen($adressname,"a");
  echo "inside dropdown writer";
  //$myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($drop_file);
  fwrite($file,$line);
  while (!feof($drop_file) ) {
  $line = fgets($drop_file);

  fwrite($file,check_for_replace_dropdown($line,$Database_var_name,$label_name,$Database_name,$form_selector_id,$form_name));
}
fclose($drop_file);
fclose($file);
}
function check_for_replace_dropdown($line,$Database_var_name,$label_name,$Database_name,$form_selector_id,$form_name)
{
   $line=str_replace('{table_variable}',$Database_var_name,$line);
   $line=str_replace('{label_name}',$label_name,$line);
   $line=str_replace('{table_name}',$Database_name,$line);
   $line=str_replace('{id}', $form_selector_id, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   return $line;
}
function text_input_writer($label_name,$form_name,$form_selector_id,$placeholder)
{
  $adressname=$_POST["adress_name"];
  $input_file = fopen("../deneme/text_input.txt", "r");
  $file = fopen($adressname,"a");
  echo "inside input writer---".$adressname;
  //$myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($input_file);
  fwrite($file,$line);
  while (!feof($input_file) ) {
  $line = fgets($input_file);

  fwrite($file,check_for_replace_input($line,$label_name,$form_selector_id,$form_name,$placeholder));
}
fclose($input_file);
fclose($file);
}
function check_for_replace_input($line,$label_name,$form_selector_id,$form_name,$placeholder)
{
   $line=str_replace('{label_name}',$label_name,$line);
   $line=str_replace('{id}', $form_selector_id, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{placeholder}', $placeholder, $line);
   return $line;
}
$bitir_file = fopen("../deneme/bitir.txt", "r");
$file = fopen($adressname,"a");
$line = fgets($bitir_file);
fwrite($file,$line);

while (!feof($bitir_file) ) {

$line = fgets($bitir_file);
fwrite($file,$line);
}
fclose($file);
fclose($bitir_file);
?>
