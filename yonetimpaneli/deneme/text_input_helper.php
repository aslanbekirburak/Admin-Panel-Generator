<?php
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);

$id=$_POST["id"];
$form_name=$_POST["name"];
$place=$_POST["placeholder"];
$label_name=$_POST["form_name"];
$form_type="text_input";

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
    $sql1 = "INSERT INTO file_controllers (file_id,form_type,label_name,placeholder,form_name,form_selector_id) VALUES ('".$did."','".$form_type."','".$label_name."','".$place."','".$form_name."','".$id."')";

  if ($conn->query($sql1) === TRUE) {

  $file = fopen("text_input.txt", "r");
  $myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($file);
  fwrite($myfile,$line);

  while (!feof($file) ) {
  $line = fgets($file);

  fwrite($myfile,check_for_replace($line,$label_name,$id,$form_name,$place));
  if(feof($file))
  {
    header("Location: http://yonetim.kuark.digital/deneme/function.php");
  }
}
}
function check_for_replace($line,$label_name,$id,$form_name,$place)
{
   $line=str_replace('{label_name}',$label_name,$line);
   $line=str_replace('{id}', $id, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{placeholder}', $place, $line);
   return $line;
}
//close the file
fclose($file);
fclose($myfile);
?>
