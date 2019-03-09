<?php

$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);

$form_name=$_POST["name"];
$value1=$_POST["value1"];
$value2=$_POST["value2"];
$label1=$_POST["label1"];
$label2=$_POST["label2"];
$label_name=$_POST["form_name"];
$form_type="radio";

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
      $sql1 = "INSERT INTO file_controllers (file_id,form_type,label_name,form_name,label1,label2,value1,value2) VALUES ('".$did."','".$form_type."','".$label_name."','".$form_name."','".$label1."','".$label2."','".$value1."','".$value2."')";

      if ($conn->query($sql1) === TRUE) {

  $file = fopen("radio.txt", "r");
  $myfile = fopen($address, "a") or die("Unable to open file!");

  $line = fgets($file);
  fwrite($myfile,$line);

  while (!feof($file) ) {
  $line = fgets($file);

  fwrite($myfile,check_for_replace($line,$label_name,$value1,$form_name,$value2,$label1,$label2));
  if(feof($file))
  {
    header("Location: http://yonetim.kuark.digital/deneme/function.php");
  }
}
}
function check_for_replace($line,$label_name,$value1,$form_name,$value2,$label1,$label2)
{
   $line=str_replace('{value1}', $value1, $line);
   $line=str_replace('{value2}', $value2, $line);
   $line=str_replace('{label1}', $label1, $line);
   $line=str_replace('{label2}', $label2, $line);
   $line=str_replace('{form_name}', $form_name, $line);
   $line=str_replace('{label_name}', $label_name, $line);
   return $line;
}
//close the file
fclose($file);
fclose($myfile);
?>
