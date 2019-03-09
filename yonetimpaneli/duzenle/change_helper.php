<?php
include "../vt/baglanti.php";
session_start();
//$which_form=$_POST["which_one"];
$label1=$_POST["label1"];
$label2=$_POST["label2"];
$change_label=$_POST["change_label"];
$page_change=$_POST["page_php"];
//$page_id = $_SESSION["address_id"];
$page_id = $db->get_var("SELECT id FROM yetki_sayfalar WHERE sayfalar = '$page_change'");

$order_change_label = $db->get_var("SELECT id FROM file_controllers WHERE label_name = '$change_label' AND file_id='$page_id'");//değişecek form order
echo $order_change_label."-order0-";
$result_form = $db->get_row("SELECT * FROM file_controllers WHERE file_id = '$page_id' AND label_name = '$change_label'");//değiştirelen satırın bilgileri
echo $result_form->label_name;

  //echo $result_form->form_name."1111111111111";
$order_change_label1 = $db->get_var("SELECT id FROM file_controllers WHERE label_name = '$label1' AND file_id='$page_id'");//değişecek form order
echo $order_change_label1."-order1-";
$order_change_label2 = $db->get_var("SELECT id FROM file_controllers WHERE label_name = '$label2' AND file_id='$page_id'");//değişecek form order
echo $order_change_label2."-order2-";
for ($i=$order_change_label-1; $i>$order_change_label1 ; $i--) {

  $bubble=$db->get_row("SELECT * FROM file_controllers WHERE id = '$i'");
  echo $bubble->label_name;
  $i=$i+1;
  $insert=$db->query("UPDATE file_controllers SET file_id = '$bubble->file_id', Php_adress='$bubble->Php_adress',form_type='$bubble->form_type',label_name='$bubble->label_name',
    form_name='$bubble->form_name',form_selector_id='$bubble->form_selector_id',Placeholder='$bubble->Placeholder',label1='$bubble->label1',label2='$bubble->label2',
    value1='$bubble->value1',value2='$bubble->value2',Database_name='$bubble->Database_name',Database_var_name='$bubble->Database_var_name',ordering='$bubble->ordering'
    WHERE id='$i'");

}
  //echo $result_form->label_name;

    //echo $result_form->form_name."22222222222";
  $order_change_label1=$order_change_label1+1;
  $insert1=$db->query("UPDATE file_controllers SET file_id='$result_form->file_id',Php_adress='$result_form->Php_adress',form_type='$result_form->form_type',label_name='$result_form->label_name',
    form_name='$result_form->form_name',form_selector_id='$result_form->form_selector_id',Placeholder='$result_form->Placeholder',label1='$result_form->label1',label2='$result_form->label2',
    value1='$result_form->value1',value2='$result_form->value2',Database_name='$result_form->Database_name',Database_var_name='$result_form->Database_var_name',ordering='$result_form->ordering'
    WHERE id='$order_change_label1'");
?>
