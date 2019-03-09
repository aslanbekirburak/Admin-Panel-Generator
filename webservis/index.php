<?php header("Content-Type:application/json");
require_once '../vt/baglanti.php';
require_once '../vt/mysql_crud.php';
require_once 'api.php';

$api = new api();
$crud = new Database();
$method = $_GET["method"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  parse_str(file_get_contents("php://input"),$post);
  $api->insert($method,$post);
}else
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  parse_str(file_get_contents("php://input"),$put);
  $id = $put["id"];
  unset($put["id"]);
  $api->update($method,$id,$put); // tablo adı, where sütun adı, değer, güncellenecek sütunlar
}else
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  parse_str(file_get_contents("php://input"),$delete);
  $id = $delete["id"];
  $api->delete($method,$id); // tablo adı, where sütun adı, değer
}else
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $id = $_GET["id"];
  $api->find($method,$id); //tek satır

}else
if ($_SERVER['REQUEST_METHOD'] === 'VIEW') {
  $sayfa = $_GET["id"];
  $api->findAll($method,$sayfa);//tablo adı, sayfalamalimit, sayfa no

}






// $api->response(400,"Invalid Request",NULL); //hatalı request

?>
