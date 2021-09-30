<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');
require_once('database_object.php');
class Programmoredetails
{
	protected static $table_name = "program_more_details";
	protected static $db_fields = array('id','con_per','marmat_per','bipat_per','contingency','bipat','marmat','aim','sn','budget','remaining_budget','work_order_date','work_order_budget','start_date','start_date_english','completion_date','completion_date_english','venue','enlist_id','type_id','total_family_members','male','female','total_members','worker_id','samjhauta_miti','program_id');
	public $id;
        public $sn;
        public $budget;
	public $remaining_budget;
        public $work_order_date;
        public $work_order_budget;
        public $start_date;
        public $start_date_english;
        public $completion_date;
        public $completion_date_english;
        public $venue;
        public $enlist_id;
        public $type_id;
        public $total_family_members;
        public $male;
        public $female;
        public $total_members; 
        public $worker_id;
        public $samjhauta_miti;
        public $program_id;
        public $con_per;
        public $marmat_per;
        public $bipat_per;
        public $contingency;
        public $bipat;
        public $marmat;
        public $aim;
        
// Common database method
	public static function find_all()
	{
		global $database;
		return self::find_by_sql("select * from ".self::$table_name);
		 	
	}
	    public function getName($string_id="")
            {
            
                     $topic_selected = self::find_by_id($string_id);
                     return $topic_names = $topic_selected->name;   
            }
        public function getAllId()
        {
            global $database;
            $id_array=array();
            $result_array=self::find_by_sql("select * from ".self::$table_name);
            foreach($result_array as $result)
            {
                array_push($id_array, $result->id);
            }    
            return $id_array;
        }
            public static function find_by_program_id_and_sn($program_id=0,$sn=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id} and sn={$sn} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	  public function getSum($program_id)
        {
            global $database;
           $rowSQL = $database->query( "select sum( work_order_budget ) AS max from ".self::$table_name." where program_id={$program_id} " );
           $row = $database->fetch_array($rowSQL);
           $sum = $row['max'];
           return $sum;
        }
        public static function getMaxInsallmentByPlanId($plan_id=0)
	{
		global $database;
		$sql = "select max(sn) from ".self::$table_name." where program_id={$plan_id}";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
             public function countsn($program_id)
        {
            global $database;
           $rowSQL = $database->query( "select count( sn ) AS max from ".self::$table_name." where program_id={$program_id} " );
           $row = $database->fetch_array($rowSQL);
           $count = $row['max'];
           return $count;
        }

        public function getMaxId($program_id)
        {
            global $database;
           $rowSQL = $database->query( "select max( ID ) AS max from ".self::$table_name." where program_id={$program_id} limit 1" );
           $row = $database->fetch_array($rowSQL);
           $largestNumber = $row['max'];
           return $largestNumber;
        }
         public function get_max_sn_remaining_amount($program_id)
        {
            global $database;
		$sql = "select max(sn) from ".self::$table_name." where program_id={$program_id} ";
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$max_sn1 =  array_shift($row);
               	$max_sn= $row['sn'];
	  	if(empty($max_sn))
	  	{
	  		return 1;
	  	}
	  	else
	  	{
	          $result = self::find_by_sn($max_sn,$program_id);
	           $remaining_amount= $result->remaining_budget;
	           
	           return $remaining_amount;
	       }
        }
        public function getmax_remaining_amount($program_id)
        {
            global $database;
		$sql = "select max(id) from ".self::$table_name." where program_id={$program_id} ";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$max_id =  array_shift($row);
	  	if(empty($max_id))
	  	{
	  		return 0;
	  	}
	          $result = self::find_by_id($max_id);
	           $remaining_amount= $result->remaining_budget;
	           
	           return $remaining_amount;
           
        }
        
          public static function check_sn($sn=0,$program_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where sn={$sn} and program_id={$program_id} limit 1");
		$result = array_shift($result_array);
		if(!empty($result))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	

	}
        public function get_payment_amount($program_id=0,$sn=0)
        {
            global $database;
           $result_array = self::find_by_sql( "select * from ".self::$table_name." where program_id={$program_id} and sn={$sn} limit 1" );
           return $result_array;
           
        }
               
	public static function find_by_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
        public static function find_by_sn($id=0,$program_id)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where sn={$id} and program_id={$program_id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
        public static function find_enlist_ids_by_program_id($program_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id}");
		$enlist_id =array();
                foreach ($result_array as $result)
                {
                    array_push($enlist_id,$result->enlist_id);
                }
                return $enlist_id;
	}
        public static function find_by_enlistid_typeid_and_programid($enlist_id=0,$type_id=0,$program_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id} and type_id={$type_id} and enlist_id={$enlist_id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	
	public static function find_parent_by_topic_no($topic_no=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where topic_no='".$topic_no."' and parent_id=0 limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	public static function setEmptyObjects()
         {
             $self = new self;
             return $self;
         }
	public static function find_by_sub_topic($parent_id,$sub_topic_no)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where topic_no='".$sub_topic_no."' and parent_id={$parent_id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	
		public static function find_parent_topic()
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where parent_id=0 ");
		return $result_array;
	}
		public static function find_sub_topic($parent_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where parent_id={$parent_id}");
		return $result_array;
	}
	
		public static function find_by_parent_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where parent_id={$id}");
		return $result_array;
	}
              public static function find_by_program_id($id=0)
	{
		global $database;
		$sql = "select * from ".self::$table_name. " where program_id={$id} ";
		
		$result_array=self::find_by_sql($sql);
		return $result_array;
	}
          public static function find_single_by_program_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$id} ");
		return !empty($result_array)? array_shift($result_array) : false;
	}

	public static function find_current_id()
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where is_current=1 limit 1");
		if(!empty($result_array))
		{
			$id = $result_array[0]->id;
		}
		else
		{
			$id = false;
		}
		return $id;

	}
	public function updateIsCurrent()
	{
		$fiscals = Self::find_all();
		foreach($fiscals as $fiscal)
		{
			$fiscal->is_current = 0;
			$fiscal->save();
		}
	}
	public  function savePostData($post)
	{
		foreach(self::$db_fields as $db_field)
		{
			if($db_field=="id")
			{
				continue;
			}
			if(property_exists($this, $db_field))
			{
				if(!isset($post[$db_field]))
				{
					$this->$db_field='';
				}
				else
				{
					$this->$db_field= $post[$db_field];
				}
				
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
        
	public static function count_all()
	{
		global $database;
		$sql = "select count(*) from ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function countSnByProgramId($program_id)
	{
		global $database;
		$sql = "select max(sn) from ".self::$table_name." where program_id=".$program_id;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	public static function count_by_detail_id($id)
	{
		global $database;
		$sql = "select count(*) from ".self::$table_name." where detail_id=".$id;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public static function find_max_reg()
	{
		global $database;
		$sql = "select max(reg_no) from ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	public static function find_max_letter_no()
	{
		global $database;
		$sql = "select max(letter_no) from ".self::$table_name;
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
			return true;
		}
		else 
		{
			return false;
		}
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