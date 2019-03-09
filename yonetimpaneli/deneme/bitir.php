<?php
session_start();
//$adress_input=$_SESSION["adress_input"];
$address = $_SESSION["address"];

$file = fopen("bitir.txt", "r");
$myfile = fopen($address, "a") or die("Unable to open file!");

$line = fgets($file);
  fwrite($myfile,$line);

while (!feof($file) ) {
$line = fgets($file);
fwrite($myfile,$line);
}
//close the file
  if(feof($file))
  {
    header("Location: http://yonetim.kuark.digital/deneme/deneme.php");
  }
  fclose($file);
  fclose($myfile);
?>
