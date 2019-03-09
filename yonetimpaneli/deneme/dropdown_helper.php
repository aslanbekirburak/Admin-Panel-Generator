<?php
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);

$form_name=$_POST["name"];
$label_name=$_POST["label_name"];
$id=$_POST["id"];
$table_var=$_POST["table_variable"];
$data_name=$_POST["datatable"];
$form_type="dropdown";

session_start();
//$adress_input=$_SESSION["adress_input"];
$address = $_SESSION["address"];

        if ($conn->connect_error){
          die("Connection Failed!");
        }

        $sql = "SELECT id FROM yetki_sayfalar WHERE sayfalar='".$address."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
          $row = $result->fetch_assoc();
          $did = $row['id'];
        }
        $sql1 = "INSERT INTO file_controllers (file_id,form_type,label_name,form_name,form_selector_id,Database_name,Database_var_name) VALUES ('".$did."','".$form_type."','".$label_name."','".$form_name."','".$id."','".$data_name."','".$table_var."')";

        if ($conn->query($sql1) === TRUE) {


  $file = fopen("dropdown.txt", "r");
  $myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($file);
  fwrite($myfile,$line);
  echo $line;
  while (!feof($file) ) {
  $line = fgets($file);

  fwrite($myfile,check_for_replace($line,$table_var,$label_name,$data_name,$id,$form_name));

  if(feof($file))
  {
    header("Location: http://yonetim.kuark.digital/deneme/function.php");
  }
}
}
function check_for_replace($line,$table_var,$label_name,$data_name,$id,$form_name)
{
   $line=str_replace('{table_variable}',$table_var,$line);
   $line=str_replace('{label_name}',$label_name,$line);
   $line=str_replace('{table_name}',$data_name,$line);
   $line=str_replace('{id}', $id, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   return $line;
}
//close the file
fclose($file);
fclose($myfile);
?>
