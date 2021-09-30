<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');

class Contractamountwithdrawdetails
{
	protected static $table_name = "contract_amount_withdraw_details";
	protected static $db_fields = array('id','plan_end_date','plan_end_date_english','yojana_sakine_date','yojana_sakine_date_english','upabhokta_aproved_date',
           'plan_evaluated_date','plan_evaluated_date_english',
            'plan_evaluated_amount','final_payable_amount','payment_till_now','advance_payment','remaining_payment_amount',
           'final_renovate_amount','created_date','final_due_amount','final_disaster_management_amount','final_total_amount_deducted',
            'final_total_paid_amount','anudan_remaining_amount', 'costumer_agreement',
            'plan_id','vat_per','vat_amt','bipat_per','bipat','dharauti_per','dharauti','cont_per','contingency','marmat_per','marmat','agrim_kar_per','bahal_per','paris_per','samajik_per','agrim_kar_amt','bahal_amt','paris_amt','samajik_amt');
            
            public $id;
            public $plan_end_date;
            public $plan_end_date_english;
            public $plan_evaluated_date;
            public $plan_evaluated_date_english;
            public $plan_evaluated_amount;
            public $final_payable_amount;
            public $payment_till_now;
            public $advance_payment;
            public $anudan_remaining_amount;
            public $costumer_agreement;
            public $remaining_payment_amount;
            public $final_renovate_amount;
            public $final_due_amount;
            public $final_disaster_management_amount;
            public $final_total_amount_deducted;
            public $final_total_paid_amount;
             public $plan_id;
             public $yojana_sakine_date;
             public $yojana_sakine_date_english ;
             public $vat_per ;
             public $vat_amt ;
             public $bipat_per ;
             public $bipat ;
             public $dharauti_per ;
             public $dharauti ;
             public $cont_per ;
             public $contingency ;
             public $marmat_per ;
             public $marmat ;
             public $agrim_kar_per ;
             public $bahal_per ;
             public $paris_per ;
             public $samajik_per ;
             public $agrim_kar_amt ;
             public $bahal_amt ;
             public $paris_amt ;
             public $samajik_amt ;
             public $created_date;
            
        // Common database method   
          public function find_by_plan_array($plan_id_string)
            {
                global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name." where plan_id in(".$plan_id_string.") order by created_date_english ASC");
		return $result_array;
            }
         public static function get_payement_till_now($plan_id)
         {
             global $contract_analysis;
             global $contract_starting_fund;
             global $contingency;
              $data5 = Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($plan_id);
                        $total_amount1=0;
                        for($i=1;$i<=$data5;$i++)
                           {
                              $data5_0= Contractanalysisbasedwithdraw::find_by_max($i, $plan_id);

                               $total_amount1 += $data5_0->payable_amount;
                           }
                       $amount= $total_amount1;
                       if($amount==0)
                       {
                           $result=$contract_starting_fund->find_by_plan_id($plan_id);
                           if(empty($result))
                           {
                               $net_payable_amount=0;
                           }
                           else
                           {
//                                                        
                               $net_payable_amount=$result->advance;
                           }
                       }

                       else
                       {
                           $net_payable_amount = $amount;
                       }
           
         $contingency_expenditure=$contingency->getTotalPayableAmount($plan_id);
         $total_net_payable=$contingency_expenditure + $net_payable_amount;
         return $total_net_payable;
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
	
	public static function find_by_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
        public static function find_by_plan_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
        public static function find_by_user_id($user_id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where user_id={$user_id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}

        public function getLink($pagination){
            $link=$page_no='';
            $html=$per_page='';
            $total_pages=$pagination->total_pages();
             if($pagination->total_count>$per_page){
                if($pagination->has_previous_page()){//check if it has previous page function used from class
                    $prev_link='<a href="'.$link.'?page_no='.$pagination->previous_page().'">prev</a>';
                 }
                    else{
                        $prev_link="";
                    }
                    //check if it has next page function used from class
                        if($pagination->has_next_page()){
                        $next_link='<a href="'.$link.'?page_no='.$pagination->next_page().'">next</a>';
                        }
                    else{
                        $next_link="";
                    }
                    $html .= $prev_link;
                for($i=1;$i<=$total_pages;$i++){
                    if($i==$pagination->current_page){
                        $html.="<span style='color:red; background:black; padding-top:1px; padding-right:5px; padding-buttom:1px; padding-left:5px;'>".$pagination->current_page."</span>";
                    }
                    else{
                        $html.='<span> <a href="'.$link.'?page_no='.$i.'">'.$i.'</span>';


                    }
            }
        $html.=$next_link;
            }            
      return $html;      
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
         public function set_page_query($page_no,$per_page,$link){
            global $pagination;
            $html='';
            $total_count=self::count_all();
            $pagination->set_pagination($page_no, $per_page, $total_count);
            $sql = "select * from ".self::$table_name." limit ".$pagination->per_page. " offset ".$pagination->offset();
             $result = self::find_by_sql($sql);
             $html=self::getLink($pagination);  
             $output=array();
             array_push($output, $html);
             array_push($output, $result);
            return $output;
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