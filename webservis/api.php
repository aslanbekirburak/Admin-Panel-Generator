<?php
class api
{

	function __construct()
	{

	}

	function __destruct()
	{

	}

	function find($tablename,$id)
 	{
		global $db;
		$getmethod = $db->get_var("SELECT COUNT(id) AS varmi FROM webservis WHERE databaseadi = '{$tablename}'");
		if($getmethod>0){
			$colrow = $db->get_row("SELECT wc.colname,wc.colshow,wc.jointable FROM webservis_controller AS wc INNER JOIN webservis AS w ON w.id=wc.webservis_id WHERE w.databaseadi = '{$tablename}' AND wc.type = 'get'");
			if($colrow->colname !=""){
				if($colrow->colshow == "null"){
					$col = "*";
				}else{
					$col = implode(",",json_decode($colrow->colshow));
				}
				if($colrow->jointable==""){
					$data = $db->get_row("SELECT $col FROM $tablename WHERE $tablename.$colrow->colname = '$id'");
				}else{
					$join = json_decode($colrow->jointable);
					foreach ($join as $t) {
						$inner .= " INNER JOIN {$t->jointable} ON ".$t->jointable.".".$t->jointablecol." = ".$tablename.".".$t->joincolname." ";
					}
					$data = $db->get_row("SELECT $col FROM $tablename $inner WHERE $tablename.$colrow->colname = '$id'");
				}
				$this->response($data);
			}else{
				customResponse(450,"Bu Method için Get İşlemi Yetkilendirilmemiş.");
			}
		}else{
			customResponse(450,"Method Bulunamadı.");
		}

 	}

	function findAll($tablename,$page=1)
 	{

		global $db;
		$getmethod = $db->get_var("SELECT COUNT(id) AS varmi FROM webservis WHERE databaseadi = '{$tablename}'");
		if($getmethod>0){
			$colname = $db->get_row("SELECT wc.colordername,wc.colorder,wc.pagerowcount,wc.colshow,wc.jointable FROM webservis_controller AS wc INNER JOIN webservis AS w ON w.id=wc.webservis_id WHERE w.databaseadi = '{$tablename}' AND wc.type = 'getall'");

			if($colname->colshow == "null"){
				$col = "*";
			}else{
				$col = implode(",",json_decode($colname->colshow));
			}
			if($colname->jointable!=""){
				$join = json_decode($colname->jointable);
				foreach ($join as $t) {
					$inner .= " INNER JOIN {$t->jointable} ON ".$t->jointable.".".$t->jointablecol." = ".$tablename.".".$t->joincolname." ";
				}
			}

			if($colname !=""){
				if($colname->pagerowcount==0){
					$data = $db->get_results("SELECT $col FROM $tablename $inner");
				}else{
					$limit = $colname->pagerowcount;
					$basla = ($page-1)*$limit;
					$data = $db->get_results("SELECT $col FROM $tablename $inner ORDER BY $tablename.$colname->colordername $colname->colorder LIMIT $basla , $limit ");
				}
				$this->response($data);
			}else{
				customResponse(450,"Bu Method için Get All İşlemi Yetkilendirilmemiş.");
			}
		}else{
			customResponse(450,"Method Bulunamadı.");
		}

 	}

	function delete($tablename,$id)
 	{
		global $db;
		global $crud;
		$getmethod = $db->get_var("SELECT COUNT(id) AS varmi FROM webservis WHERE databaseadi = '{$tablename}'");
		if($getmethod>0){
			$colname = $db->get_var("SELECT wc.colname FROM webservis_controller AS wc INNER JOIN webservis AS w ON w.id=wc.webservis_id WHERE w.databaseadi = '{$tablename}' AND wc.type = 'delete'");
			if($colname !=""){
				$ID = "$colname = $id";
				$data = $crud->delete($tablename,$ID);
				$this->response($data);
			}else{
				customResponse(450,"Bu Method için Delete İşlemi Yetkilendirilmemiş.");
			}
		}else{
			customResponse(450,"Method Bulunamadı.");
		}
 	}

	function update($tablename,$id,$crudpost)
 	{
		global $db;
		global $crud;
		$getmethod = $db->get_var("SELECT COUNT(id) AS varmi FROM webservis WHERE databaseadi = '{$tablename}'");
		if($getmethod>0){
			$colname = $db->get_var("SELECT wc.colname FROM webservis_controller AS wc INNER JOIN webservis AS w ON w.id=wc.webservis_id WHERE w.databaseadi = '{$tablename}' AND wc.type = 'put'");
			if($colname !=""){
				$data = $crud->update($tablename,$crudpost,"$colname='{$id}'");
				$this->response($data);
			}else{
				customResponse(450,"Bu Method için Update İşlemi Yetkilendirilmemiş.");
			}
		}else{
			customResponse(450,"Method Bulunamadı.");
		}

 	}

	function insert($tablename,$crudpost)
 	{
		global $db;
		global $crud;
		$getmethod = $db->get_var("SELECT COUNT(id) AS varmi FROM webservis WHERE databaseadi = '{$tablename}'");
		if($getmethod>0){
			$colname = $db->get_var("SELECT wc.id FROM webservis_controller AS wc INNER JOIN webservis AS w ON w.id=wc.webservis_id WHERE w.databaseadi = '{$tablename}' AND wc.type = 'post'");
			if($colname !=""){
				$data = $crud->insert($tablename,$crudpost);
				$insert_id = $crud->getResult();
				$this->response($data);
			}else{
				customResponse(450,"Bu Method için Post İşlemi Yetkilendirilmemiş.");
			}
		}else{
			customResponse(450,"Method Bulunamadı.");
		}

 	}

	function response($data)
 	{
		global $db;
		if($data){
			$status=200;
			$status_message="Başarılı";
		}else{
			if($db->last_error==null){
				$status=300;
				$status_message="Sonuç Yok";
			}else{
				$status=400;
				$status_message=$db->last_error;
			}
			$data=array();
		}

		header("HTTP/1.1 ".$status);

		$response['data']=$data;
		$response['status_message']=$status_message;
		$response['status']=$status;


 		$json_response = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHED);
 		echo $json_response;
 	}
}

function customResponse($status,$status_message)
{
	header("HTTP/1.1 ".$status);

	$response['data']="";
	$response['status_message']=$status_message;
	$response['status']=$status;


	$json_response = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHED);
	echo $json_response;
}
?>
