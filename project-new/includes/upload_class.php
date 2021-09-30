<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');
class Upload
{
	protected static $table_name = "upload";
	protected static $db_fields = array('id','type_id','pic','plan_id');
	public $id;
	public $type_id;
	public $pic;
        public $plan_id;
                
	// Common database method
	public static function find_all()
	{         
	    $database= new MySQlDatabase('localhost','root','','sample');	
           //global $database;
		return self::find_by_sql("select * from ".self::$table_name);
		 	
	}
	public static function find_by_user_id($user_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where user_id={$user_id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	public static function find_photos_by_planid_and_type_id($plan_id=0,$type_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$plan_id} and type_id={$type_id}");
		return $result_array;
	}
	public static function find_by_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	 public function getName($string_id=""){
            
            $staff_ids=explode("-",$string_id);
            $staff_names = '';
            
            foreach($staff_ids as $staff_id){
                     $staff_selected = self::find_by_id($staff_id);
                     $staff_names .= $staff_selected->name ." | ";
            }
            return $staff_names;
        }
        
         public static function getStaffNamesById($idstring='')
	{
		$ids = explode("-", $idstring);
                $staff_names = array();
                foreach($ids as $id)
                {
                    $staff_selected = self::find_by_id($id);
                    array_push($staff_names, $staff_selected->name);
                }
                $names = implode(" | ", $staff_names);
                return $names;
		
	}
        
	public  function savePostData($post, $clause)
	{
		foreach(self::$db_fields as $db_field)
		{
			if($clause=="create" && $db_field=="id")
			{
				continue;
			}
			if(property_exists($this, $db_field))
			{
				$this->$db_field= $post[$db_field];
			}
		}

		return $this->save();
	}
	public static function find_by_sql($sql="")
	{
               
		global $database;
		$result_set=$database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set))
		{
			$object_array[]= self::instantiate($row);
		}
		return $object_array;
	}
         public function set_page_query($page_no,$per_page){
             $html='';
            global $pagination;
            $total_count=self::count_all();
            $pagination->set_pagination($page_no, $per_page,$total_count);
            $sql = "select * from ".self::$table_name." limit ".$pagination->per_page. " offset ".$pagination->offset();
            $result = self::find_by_sql($sql);
            $html = self::getPageLink($pagination);
            $output=array();
            array_push($output,$html);
            array_push($output,$result);
            return $output;
        }
        
        public function getPageLink($pagination){
            //global $pagination;
            $html = '';
            $per_page='';
            $link='';
            $total_pages=$pagination->total_pages();
            
          if($pagination->total_count>$per_page){
                if($pagination->has_previous_page()){
                    $prev_link='<a href="'.$link.'?page_no='.$pagination->previous_page().'">prev</a>';
                    }
                    else{
                        $prev_link="";
                    }
                    if($pagination->has_next_page()){
                    $next_link='<a href="'.$link.'?page_no='.$pagination->next_page().'">next</a>';
                    }
                    else{
                        $next_link="";
                    }
                    $html .= $prev_link;
                for($i=1;$i<=$total_pages;$i++){
                    if($i==$pagination->current_page){
                        $html.= '<span class="active">'.$pagination->current_page.'</span>';
                    }
                    else{
                        $html.='<span> <a href="'.$link.'?page_no='.$i.'">'.$i.'</span>';


                }
            }
        $html.=$next_link;
            }            
//            echo $html;exit;
           return $html; 
        }


        public static function count_all()
	{
		global $database;
		$sql = "select count(*) from ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	private static function instantiate($record)
	{
		 // could check that $record exists and is an array
		 // simple, long form approach
		 $object= new self;
		/* $object->id			= $record['id'];
		 $object->username		= $record['username'];
		 $object->password 		= $record['password'];
		 $object->first_name 	= $record['first_name'];
		 $object->last_name 	= $record['last_name'];*/
		 
		 
		 // more dynamic, short-form approach:
		foreach($record as $attribute=>$value)
		{
			if ($object->has_attribute($attribute))
			{
				$object->$attribute=$value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute)
	{
		// get_object_vars returns an associative array with all attributes
		// (incl. private ones!) as the keys and their current values as the value
		$object_vars = get_object_vars($this);
		// we don't care about the value, we just want to know if the key exists
		// will return true or false
		return array_key_exists($attribute, $object_vars);
	}
	protected function attributes()
	{
		// return an array of attribute keys and their values
		$attributes = array();
		foreach(self::$db_fields as $field)
		{
			if(property_exists($this, $field))
			{
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	protected function sanitized_attributes()
	{
		global $database;
		$clean_attributes = array();
		// sanitize the values before submitting
		// note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value)
		{
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}
	public function save()
	{
		// a new record won't have an id yet
		return isset($this->id) ? $this->update() : $this->create();
	}
	public function create()
	{
		global $database;
		// dont forget sql syntax and good habits
		// insert into table ('key', 'key') values ('value', 'value')
		// single quotes around all values
		// escape all values to prevent sql injection
		$attributes = $this->sanitized_attributes();
		$sql = "insert into ". self::$table_name ."(";
		$sql .= join(",", array_keys($attributes));
		$sql .=") values ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if ($database->query($sql))
		{
			$this->id = $database->insert_id();
			return $this->id;
		}
		else 
		{
			return false;
		}
	}
//	public function backup()
//	{
//		global $database;
//		// dont forget sql syntax and good habits
//		// insert into table ('key', 'key') values ('value', 'value')
//		// single quotes around all values
//		// escape all values to prevent sql injection
//                
//		//$attributes = "select * from staff";
//               // $attributes=self::find_all();
//                $sql = "select * from staff";
//               $result = $database->query($sql);
//              $attributes =  mysqli_fetch_assoc($result);
//          
//               $datas=self::find_all();
//                 $count=count($datas);
//                $i=1;
//              
//                $keyarray = (array) $datas;
//                $sql = "INSERT INTO `". self::$table_name ."` (`";
//		$sql .= join("`, `", array_keys($keyarray));
//		$sql .="`) VALUES ";
//                
//          
//           // echo $count;exit;
//                   foreach($datas as $data)
//            {   
//                
//                 $myarray = (array) $data;
//                // print_r($myarray);exit;
//                $sql.=" ('";    
//		$sql .= join("', '", array_values($myarray));
//		
//                if($i==$count){
//                $sql .= "');";
//                }
//         else {
//                    $sql .= "') , ";  
//                  }
//		$i++;
//                
//             
//           }
//          
//           
//         
//         return $sql;
//        
//         
//         }
//	
         
         public function backup()
	{
		
                 global $database;
            $sql = "select * from  ". self::$table_name ."";
            $result = $database->query($sql);
            $sql = '';
            $sql .= "insert into `". self::$table_name ."`(`";
//            $i=0;
           $datas=self::find_all();
//           print_r($datas);exit;    
            $myobjarray = (array) $datas[0];
//            print_r($myobjarray);exit;
           $sql.=join("`,`",array_keys($myobjarray));
//           echo $backup_query;exit;
                $count=count($datas);
//                echo $count;exit;
              $sql.="`) values ";

	    $i=1;
              
     // echo $count;exit;
                   foreach($datas as $data)
            {   
                
                 $myarray = (array) $data;
                // print_r($myarray);exit;
                $sql.=" ('";    
		$sql .= join("', '", array_values($myarray));
		
                if($i==$count){
                $sql .= "');";
                }
         else {
                    $sql .= "') , ";  
                  }
		$i++;
                
             
           }
          
           
         
         return $sql;
        
         
         }
         
         
	public function update()
	{
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value)
		{
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "update ".self::$table_name." set ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= "where id=".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() ==1)? true : false;
	}
	
	public function delete()
	{
		global $database;
		// delete from table where condition limit 1
		$sql = "delete from " .self::$table_name ;
		$sql .= " where id=".$database->escape_value($this->id);
		$sql .= " limit 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}	
       
}


?>