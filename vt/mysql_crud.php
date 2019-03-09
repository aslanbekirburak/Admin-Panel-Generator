<?php
/*
 * @Author Neset Demir <nesetdemir@gmail.com>
 * @Version 1.0
 * @Package Database
 */
include "baglanti.php";
class Database{
	/*
	 * Extra variables that are required by other function such as boolean con variable
	 */
		private $result = array(); // Any results from a query will be stored here
    private $myQuery = "";// used for debugging process with SQL return
    private $numResults = "";// used for returning the number of rows

	// Function to insert into the database
    public function insert($table,$params=array(),$logparam=array()){
			global $db;
    	// Check to see if the table exists
			 $params["created_at"] = date("Y-m-d H:i:s");
			 $args=array();
			 foreach($params as $field=>$value){
				 // Seperate each column out with it's corresponding value
				 $value = $db->escape($value);
				 $args[$field]=$value;
			 }
    	 if($this->tableExists($table)){

    	 	$sql='INSERT INTO `'.$table.'` (`'.implode( '`, `',array_keys($args)).'`) VALUES (\'' . implode('\', \'', $args) . '\')';
            $this->myQuery = $sql; // Pass back the SQL
            // Make the query to insert to the database
            if($ins = @$db->query($sql)){
            	array_push($this->result,$db->insert_id);
							//log write

							if(count($logparam)>0){
								$this->logInsert($logparam["note"],"insert",$table,$logparam["userid"]);
							}

              return true; // The data has been inserted
            }else{
            	// array_push($this->result,$db->debug()); //show error
                return false; // The data has not been inserted
            }
        }else{
        	return false; // Table does not exist
        }
    }

	//Function to delete table or row(s) from database
    public function delete($table,$where = null,$logparam=array()){
			global $db;
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	if($where == null){
								return false; // The query did not execute correctly
                //$delete = 'DROP TABLE '.$table; // Create query to delete table
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
            }
            // Submit query to database
            if($del = @$db->query($delete)){
            	array_push($this->result,$del);
                $this->myQuery = $delete; // Pass back the SQL
								if(count($logparam)>0){
									$this->logInsert($logparam["note"],"delete",$table,$logparam["userid"]);
								}
                return true; // The query exectued correctly
            }else{
            	// array_push($this->result,$db->debug()); //show error
               	return false; // The query did not execute correctly
            }
        }else{
            return false; // The table does not exist
        }
    }

	// Function to update row in database
    public function update($table,$params=array(),$where,$logparam=array()){
			global $db;
    	// Check to see if table exists
			$params["updated_at"] = date("Y-m-d H:i:s");
    	if($this->tableExists($table)){
    		// Create Array to hold all the columns to update
            $args=array();
			foreach($params as $field=>$value){
				// Seperate each column out with it's corresponding value
				$value = $db->escape($value);
				$args[]=$field.'=\''.$value.'\'';
			}
			// Create the query
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			// Make query to database
            $this->myQuery = $sql; // Pass back the SQL
            if($query = @$db->query($sql)){
            	array_push($this->result,$query);
							if(count($logparam)>0){
								$this->logInsert($logparam["note"],"update",$table,$logparam["userid"]);
							}
            	return true; // Update has been successful
            }else{
            	// array_push($this->result,$db->debug());//show error
                return false; // Update has not been successful
            }
        }else{
            return false; // The table does not exist
        }
    }

		private function logInsert($note,$task,$module,$userid){
			global $db;

			$ip = $_SERVER['REMOTE_ADDR'];
			$logdate = date("Y-m-d H:i:s");
			//log write
			$log="INSERT INTO logs SET ipaddress='$ip',user_id='$userid',module='$module',task='$task',note='$note',logdate='$logdate'";
			@$db->query($log);

		}

	// Private function to check if table exists for use with queries
	private function tableExists($table){
		global $db;
		$tablesInDb = @$db->query('SHOW TABLES FROM '.DBNAME.' LIKE "'.$table.'"');
        if($tablesInDb){
        	if($db->num_rows==1){
                return true; // The table exists
            }else{
            	array_push($this->result,$table." veritabanında böyle bir tablo bulunmamaktadır.");
                return false; // The table does not exist
            }
        }
    }

	// Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data){
				global $db;
        return $db->escape($data);
    }

}
