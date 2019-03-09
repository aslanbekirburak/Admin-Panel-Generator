<?php ob_start();
require_once("top.php"); require_once("yetkiKontrol.php");
include "vt/baglanti.php";

$adress_id = $_GET["id"];//gelen_id

session_start();
//$adress_id=$_POST["page_id"];
$adressname= $db->get_var("SELECT sayfalar FROM yetki_sayfalar WHERE id = '$adress_id'");
$row_result=$db->get_row("SELECT * FROM yetki_sayfalar WHERE id='$adress_id'");
$database_name=$db->get_var("SELECT databaseadi FROM yetki_sayfalar WHERE id='$adress_id'");
$type=$db->get_var("SELECT type FROM yetki_sayfalar WHERE id='$adress_id'");


  $file = fopen($adressname,"w");
//default başlangıç yazma kısmı
if($type=="listele"){

        function listele_replace($line,$menuadi,$icon,$databaseadi,$sayfalar,$value_name)
        {
           $line=str_replace('{menu_name}', $menuadi, $line);
           $line=str_replace('{icon}', $icon, $line);
           $line=str_replace('{database_name}',$databaseadi,$line);
           $line=str_replace('{yonlendir}', $sayfalar, $line);
           $line=str_replace('{table_sutun}', $value_name, $line);
           return $line;
        }

        $read_file = fopen("kuark_proje_templates/listele.txt", "r");
        $ekle_php=$db->get_var("SELECT sayfalar FROM yetki_sayfalar WHERE databaseadi='$database_name' AND type='ekle'");
        $basliklar=$db->get_var("SELECT liste_oge FROM yetki_sayfalar WHERE id='$adress_id'");
        $basliklar=json_decode($basliklar);
        foreach($basliklar->columnshow as $value)
        {
          $value_name.="<th>".$value."</th>";
        }
        $line = fgets($read_file);
        fwrite($file,$line);

        while (!feof($read_file) ) {

        $line = fgets($read_file);
        fwrite($file,listele_replace($line,$row_result->menuadi,$row_result->icon,$database_name,$ekle_php,$value_name));

        }
        fclose($read_file);
        fclose($file);
        header("Location: menuler.php");

}
else {
if($type=="ekle"){
          $read_file = fopen("kuark_proje_templates/default.txt", "r");
}
elseif($type=="duzenle"){
          $read_file = fopen("kuark_proje_templates/default_duzenle.txt", "r");
}

function default_replace($line,$menuadi,$icon,$databaseadi,$sayfalar)
{
   $line=str_replace('{menu_name}', $menuadi, $line);
   $line=str_replace('{icon}', $icon, $line);
   $line=str_replace('{database_name}',$databaseadi,$line);
   $line=str_replace('{yonlendir}', $sayfalar, $line);
   $line=str_replace('{zorunluluk}', $zorunluluk, $line);
   return $line;
}

function gorsel_writer($adressname,$type,$label_name,$form_name,$height,$width,$zorunluluk,$databasename)
{
  $gorsel_file = fopen("kuark_proje_templates/gorsel.txt", "r");
  $file = fopen($adressname,"a");
  //$myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($gorsel_file);
  fwrite($file,$line);
  while (!feof($gorsel_file) ) {
  $line = fgets($gorsel_file);
  fwrite($file,check_for_replace_gorsel($line,$type,$label_name,$form_name,$height,$width,$zorunluluk,$databasename));
  }
  fclose($gorsel_file);
  fclose($file);
}
function check_for_replace_gorsel($line,$type,$label_name,$form_name,$height,$width,$zorunluluk,$databasename)
{
  if($type=="duzenle"){
    $value_str=GORSELUPLOADPATH.'/'.$databasename.'/'.$form_name.'_<?=$row->id?>.jpg';
    $line=str_replace('{value}',$value_str,$line);
  }
  else{
    $gorsel='https://placeholdit.imgix.net/~text?txtsize=25&txt='.$width.'%C3%97'.$height.'&w='.$width."&h=".$height;
    $line=str_replace('{value}',$gorsel,$line);

  }
   $line=str_replace('{height}', $height, $line);
   $line=str_replace('{width}', $width, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{label_name}', $label_name, $line);
   $line=str_replace('{zorunluluk}', $zorunluluk, $line);
   return $line;
}

function radio_writer($adressname,$type,$label_name,$form_name,$label1,$label2,$value1,$value2,$zorunluluk)
{
 $radio_file = fopen("kuark_proje_templates/radio.txt", "r");
 $file = fopen($adressname,"a");
 echo "inside radio writer".$adressname;
 //$myfile = fopen($address, "a") or die("Unable to open file!");

 $line = fgets($radio_file);
 fwrite($file,$line);
 while (!feof($radio_file) ) {
 $line = fgets($radio_file);
 fwrite($file,check_for_replace_radio($line,$type,$label_name,$value1,$form_name,$value2,$label1,$label2,$zorunluluk));
 }
 fclose($radio_file);
 fclose($file);
}
function check_for_replace_radio($line,$type,$label_name,$value1,$form_name,$value2,$label1,$label2,$zorunluluk)
{
 if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
 }
  $line=str_replace('{value1}', $value1, $line);
  $line=str_replace('{value2}', $value2, $line);
  $line=str_replace('{label1}', $label1, $line);
  $line=str_replace('{label2}', $label2, $line);
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{label_name}', $label_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  return $line;
}


function textarea_writer($adressname,$type,$label_name,$form_name,$zorunluluk)
{
 $textarea_file = fopen("kuark_proje_templates/textarea.txt", "r");
 $file = fopen($adressname,"a");

 $line = fgets($textarea_file);
 fwrite($file,$line);
 while (!feof($textarea_file) ) {
 $line = fgets($textarea_file);
 fwrite($file,check_for_replace_textarea($line,$type,$label_name,$form_name,$zorunluluk));
 }
 fclose($textarea_file);
 fclose($file);
}
function check_for_replace_textarea($line,$type,$label_name,$form_name,$zorunluluk)
{
 if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
 }
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{label_name}', $label_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  return $line;
}


function hashtag_writer($adressname,$type,$label_name,$form_name,$zorunluluk)
{
 $hashtag_file = fopen("kuark_proje_templates/hashtag_input.txt", "r");
 $file = fopen($adressname,"a");

 $line = fgets($hashtag_file);
 fwrite($file,$line);
 while (!feof($hashtag_file) ) {
 $line = fgets($hashtag_file);
 fwrite($file,check_for_replace_hashtag($line,$type,$label_name,$form_name,$zorunluluk));
 }
 fclose($hashtag_file);
 fclose($file);
}
function check_for_replace_hashtag($line,$type,$label_name,$form_name,$zorunluluk)
{
 if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
 }
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{label_name}', $label_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  return $line;
}


function spinner_writer($adressname,$type,$label_name,$form_name,$zorunluluk)
{
 $datetime_file = fopen("kuark_proje_templates/spinner_input.txt", "r");
 $file = fopen($adressname,"a");

 $line = fgets($datetime_file);
 fwrite($file,$line);
 while (!feof($datetime_file) ) {
 $line = fgets($datetime_file);
 fwrite($file,check_for_replace_spinner($line,$type,$label_name,$form_name,$zorunluluk));
 }
 fclose($datetime_file);
 fclose($file);
}
function check_for_replace_spinner($line,$type,$label_name,$form_name,$zorunluluk)
{  if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
 }
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{label_name}', $label_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  return $line;
}


function datetime_writer($adressname,$label_name,$form_name,$placeholder,$zorunluluk)
{
 $datetime_file = fopen("kuark_proje_templates/datetime_input.txt", "r");
 $file = fopen($adressname,"a");

 $line = fgets($datetime_file);
 fwrite($file,$line);
 while (!feof($datetime_file) ) {
 $line = fgets($datetime_file);
 fwrite($file,check_for_replace_datetime($line,$type,$label_name,$form_name,$placeholder,$zorunluluk));
 }
 fclose($textarea_file);
 fclose($file);
}
function check_for_replace_datetime($line,$type,$label_name,$form_name,$placeholder,$zorunluluk)
{
 if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
 }
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{label_name}', $label_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  $line=str_replace('{placeholder}', $placeholder, $line);
  return $line;
}

function dropdown_writer($adressname,$type,$label_name,$form_name,$form_selector_id,$Database_name,$Database_var_name,$zorunluluk)
{
 $drop_file = fopen("kuark_proje_templates/dropdown.txt", "r");
 $file = fopen($adressname,"a");
 echo "inside dropdown writer";

 $line = fgets($drop_file);
 fwrite($file,$line);
 while (!feof($drop_file) ) {
 $line = fgets($drop_file);

 fwrite($file,check_for_replace_dropdown($line,$type,$Database_var_name,$label_name,$Database_name,$form_selector_id,$form_name,$zorunluluk));
}
fclose($drop_file);
fclose($file);
}
function check_for_replace_dropdown($line,$type,$Database_var_name,$label_name,$Database_name,$form_selector_id,$form_name,$zorunluluk)
{
 if($type=="duzenle"){
   $value_str="<?=$row->".$form_name."?>";
   $line=str_replace('{value}',$value_str,$line);

   $value_str2='<?php if ($row->'.$form_name.' == $value->id) { echo "selected";}?>';
   $line=str_replace('{selected}',$value_str2,$line);
 }
 else{
   $line=str_replace('{value}'," ",$line);
   $value_str="";
   $line=str_replace('{selected}',$value_str,$line);
 }
  $line=str_replace('{table_variable}',$Database_var_name,$line);
  $line=str_replace('{label_name}',$label_name,$line);
  $line=str_replace('{table_name}',$Database_name,$line);
  $line=str_replace('{id}', $form_selector_id, $line);
  $line=str_replace('{form_name}', $form_name, $line);
  $line=str_replace('{zorunluluk}', $zorunluluk, $line);
  return $line;
}

function text_input_writer($adressname,$type,$label_name,$form_name,$form_selector_id,$placeholder,$zorunluluk)
{
  $input_file = fopen("kuark_proje_templates/text_input.txt", "r");
  $file = fopen($adressname,"a");

  $line = fgets($input_file);
  fwrite($file,$line);
  while (!feof($input_file) ) {
  $line = fgets($input_file);

  fwrite($file,check_for_replace_input($line,$type,$label_name,$form_selector_id,$form_name,$placeholder,$zorunluluk));
}
fclose($input_file);
fclose($file);
}
function check_for_replace_input($line,$type,$label_name,$form_selector_id,$form_name,$placeholder,$zorunluluk)
{
  if($type=="duzenle"){
    $value_str='<?=$row->'.$form_name.'?>';
    $line=str_replace('{value}',$value_str,$line);
  }
  else{
    $line=str_replace('{value}'," ",$line);
  }
   $line=str_replace('{label_name}',$label_name,$line);
   $line=str_replace('{id}', $form_selector_id, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{placeholder}', $placeholder, $line);
   $line=str_replace('{zorunluluk}', $zorunluluk,$line);
   return $line;
}
          $line = fgets($read_file);
          fwrite($file,$line);

          while (!feof($read_file) ) {

          $line = fgets($read_file);
          fwrite($file,default_replace($line,$row_result->menuadi,$row_result->icon,$database_name,$row_result->sayfalar));

          }
    fclose($read_file);
    fclose($file);

  //default başlangıç yazma sonu

  $result_form = $db->get_results("SELECT * FROM file_controllers WHERE file_id = '$adress_id' ORDER BY sira ASC");

  foreach ($result_form as $key => $value) {

    if($value->form_type=="text_input")
      {
        text_input_writer($adressname,$type,$value->label_name,$value->form_name,$value->form_selector_id,$value->Placeholder,$value->zorunluluk);}

    if($value->form_type=="radio")
      {
        radio_writer($adressname,$type,$value->label_name,$value->form_name,$value->label1,$value->label2,$value->value1,$value->value2,$value->zorunluluk);}

    if($value->form_type=="dropdown")
      {
        dropdown_writer($adressname,$type,$value->label_name,$value->form_name,$value->form_selector_id,$value->Database_name,$value->Database_var_name,$value->zorunluluk);}
    if($value->form_type=="textarea")
      {
        textarea_writer($adressname,$type,$value->label_name,$value->form_name,$value->zorunluluk);}
    if($value->form_type=="datetime_input")
      {
        datetime_writer($adressname,$type,$value->label_name,$value->form_name,$value->Placeholder,$value->zorunluluk);}
    if($value->form_type=="spinner_input")
      {
        spinner_writer($adressname,$type,$value->label_name,$value->form_name,$value->zorunluluk);}
    if($value->form_type=="hashtag_input")
      {
        hashtag_writer($adressname,$type,$value->label_name,$value->form_name,$value->zorunluluk);}
    if($value->form_type=="gorsel_input")
      {
        gorsel_writer($adressname,$type,$value->label_name,$value->form_name,$value->height,$value->width,$value->zorunluluk,$database_name);}
  }
 header("Location: menuler.php");
 function end_replace($line,$menuadi,$databaseadi,$sayfalar)
 {
    $line=str_replace('{controller}',$menuadi,$line);
    $line=str_replace('{yonlendir}', $sayfalar, $line);
    $line=str_replace('{database_name}',$databaseadi,$line);
    return $line;
 }

if($type=="ekle"){
          $bitir_file = fopen("kuark_proje_templates/bitir.txt", "r");
}
elseif($type=="duzenle"){
          $bitir_file = fopen("kuark_proje_templates/bitir_duzenle.txt", "r");
}
$file = fopen($adressname,"a");
$line = fgets($bitir_file);
fwrite($file,$line);

while (!feof($bitir_file) ) {

$line = fgets($bitir_file);
fwrite($file,end_replace($line,$row_result->menuadi,$database_name,$row_result->sayfalar));
}
fclose($file);
fclose($bitir_file);


}
?>
