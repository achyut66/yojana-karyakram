<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');
require_once('database_object.php');
class Programpayment
{
	protected static $table_name = "program_payment";
	protected static $db_fields = array('id','sn','payment_holder_name','payment_holder_father_name','payment_holder_grandfather_name','payment_amount','paid_date','paid_date_english','payment_flow_date','payment_flow_date_english','payment_reason','program_id','enlist_id');
	public $id;
        public $sn;
        public $payment_holder_name;
	public $payment_holder_father_name;
        public $payment_holder_grandfather_name;
        public $payment_amount;
        public $paid_date;
        public $paid_date_english;
        public $payment_flow_date;
        public $payment_flow_date_english;
        public $payment_reason;
        public $program_id;
        public $enlist_id;
        // Common database method
         public function getMaxIds($program_id)
        {
            global $database;
           $rowSQL = $database->query( "select max( sn ) AS max from ".self::$table_name." where program_id={$program_id} limit 1" );
           $row = $database->fetch_array($rowSQL);
           $largestNumber = $row['max'];
           return $largestNumber;
        }
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
                 public function countsn($program_id)
        {
            global $database;
           $rowSQL = $database->query( "select count( sn ) AS max from ".self::$table_name." where program_id={$program_id} " );
           $row = $database->fetch_array($rowSQL);
           $count = $row['max'];
           return $count;
        }

	public static function find_by_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	  public static function find_by_program_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
	   public static function find_by_program_id2($program_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id} ");
		return $result_array;
	}
	
	  public static function find_by_program_id1($id=0)
	{
		global $database;
		$sql = "select * from ".self::$table_name. " where program_id={$id} ";
		
		$result_array=self::find_by_sql($sql);
		return $result_array;
	}
         public static function find_by_program_ids_and_sn($program_id=0,$sn=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id} and sn={$sn} limit 1");
		return $result_array;
	}
          public static function find_by_program_id_and_sn($program_id=0,$sn=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$program_id} and sn={$sn} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
           public function getMaxId($program_id)
        {
           global $database;
        $sql = "select max(id) from ".self::$table_name." where program_id={$program_id} ";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$max_id =  array_shift($row);
               
	  	if(empty($max_id))
	  	{
	  		return 0;
	  		echo "here";exit;
	  	}
	  	else
	  	{
	          return $max_id;  	
	  	}
	  	
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
	
           public static function check_sn($sn=0,$program_id)
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
        public static function get_total_payment_amount($program_id=0)
	{
		global $database;
		$sql = "select sum(payment_amount) from ".self::$table_name." where program_id=".$program_id;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$total =  array_shift($row);
                if(empty($total))
                {
                    $total = 0;
                }
                return $total;
	}
         public static function get_total_payment_amount_for_all_programs()
	{
		global $database;
		$sql = "select sum(payment_amount) from ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$total =  array_shift($row);
                if(empty($total))
                {
                    $total = 0;
                }
                return $total;
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