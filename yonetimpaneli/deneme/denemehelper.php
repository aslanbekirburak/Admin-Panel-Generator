<?php
session_start();
$festname=$_POST["festival"];
$durum=$_POST["durum"];
$adress=$_POST["adress"];
$sira=$_POST["sira"];
$durum=$_POST["durum"];
$icon=$_POST["icon"];
$menuadi=$_POST["menu"];
$did=126;
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);

    if ($conn->connect_error){
      die("Connection Failed!");
    }

    $sql = "INSERT INTO yetki_sayfalar (menuadi, ust_id,icon,sira,sayfalar,goster) VALUES ('".$menuadi."','".$did."','".$icon."','".$sira."','".$adress."','".$durum."')";

  if ($conn->query($sql) === TRUE) {
    $file = fopen("default.txt", "r");
    $myfile = fopen($adress, "a") or die("Unable to open file!");

    $line = fgets($file);
      fwrite($myfile,$line);

    while (!feof($file) ) {
    $line = fgets($file);
    fwrite($myfile,$line);
  }
  //close the file
  fclose($file);
  fclose($myfile);

    $_SESSION["address"] = $adress;
    header("Location: http://yonetim.kuark.digital/deneme/function.php");
}
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>
