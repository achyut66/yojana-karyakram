<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');
require 'pagination.php';
class Plandetails1
{
	protected static $table_name = "plan_details1";
	protected static $db_fields = array('id','budget_id','rajpatra_no','fiscal_id','topic_no','qty','parishad_sno','expenditure_type','topic_area_id','topic_area_type_id','topic_area_type_sub_id','topic_area_agreement_id','topic_area_investment_id','program_name','ward_no','investment_amount','type','first','second','third','status','prev_id');
	public $id;
        public $budget_id;
	    public $fiscal_id;
	    public $parishad_sno;
	    public $topic_area_id ;
        public $topic_area_type_id;
        public $topic_area_type_sub_id;
        public $topic_area_agreement_id ;
        public $topic_area_investment_id ;
        public $program_name;
        public $ward_no;
        public $investment_amount;
        public $type;
        public $expenditure_type;
        public $first;
        public $second;
        public $third;
        public $status;
        public $prev_id;
        public $rajpatra_no;
        public $topic_no;
        public $qty;
        // Common database method
        public static function get_total_investment_by_clause($clause,$value,$ward,$type)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where type={$type} and ".$clause."=".$value;
		
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and '".$clause."'=".$value;
		
                }
//                echo $sql;exit;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
//                echo array_shift($row);exit;
		return array_shift($row);
	}
        public static function find_max_ward_no()
	{
		global $database;
		$sql = "select max(ward_no) from ".self::$table_name."";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public function resetAutoIncrement()
	{
		global $database;
		$max_count = self::count_all();
		$new_auto_val = $max_count++;
		$sql = 'ALTER TABLE '.self::$table_name.' AUTO_INCREMENT ='.$new_auto_val;
		$result = $database->query($sql);
	}
         public static function get_total_investment_by_budget_id_expenditure_type($budget_id,$fiscal_id,$expenditure_type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where budget_id=".$budget_id." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		}
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and budget_id=".$budget_id." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public static function get_total_investment_by_topic_area_id_expenditure_type($topic_area_id,$fiscal_id,$expenditure_type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		}
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public static function count_by_budget_id_expenditure_type($budget_id,$fiscal_id,$expenditure_type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where budget_id=".$budget_id. " and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where ward_no=".$ward." and budget_id=".$budget_id. " and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
         public static function count_by_topic_area_id_expenditure_type($topic_area_id,$fiscal_id,$expenditure_type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where topic_area_id=".$topic_area_id. " and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id. " and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
         public static function get_total_expenditureByBudget($budget_id,$fiscal_id,$string,$data,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where budget_id=".$budget_id." and fiscal_id=".$fiscal_id." and $string=".$data;
		
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and budget_id=".$budget_id." and fiscal_id=".$fiscal_id." and $string=".$data;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public static function get_total_expenditure($topic_area_id,$fiscal_id,$string,$data,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id." and $string=".$data;
		
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id." and $string=".$data;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public static function get_total_investment_by_only_budget_id($budget_id,$fiscal_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where budget_id=".$budget_id. " and fiscal_id=".$fiscal_id;
		
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and budget_id=".$budget_id. " and fiscal_id=".$fiscal_id;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
         public static function get_total_investment_by_topic_area_id($topic_area_id,$fiscal_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                   $sql = "select sum(investment_amount) from ".self::$table_name." where topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id;
		 
                }
                else
                {
                    
                   $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id." and fiscal_id=".$fiscal_id;
		 
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function count_by_budget_id($budget_id,$fiscal_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                  $sql = "select count(*) from ".self::$table_name." where budget_id=".$budget_id. " and fiscal_id=".$fiscal_id;;
		  
                }
                else
                {
                   $sql = "select count(*) from ".self::$table_name." where ward_no=".$ward." and budget_id=".$budget_id. " and fiscal_id=".$fiscal_id;;
		 
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
        public static function count_by_topic_area_id($topic_area_id,$fiscal_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where topic_area_id=".$topic_area_id. " and fiscal_id=".$fiscal_id;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id. " and fiscal_id=".$fiscal_id;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
	
	 public static function count_by_topic_area($topic_area_id)
	{
		global $database;
                $sql = "select count(*) from ".self::$table_name." where topic_area_id=".$topic_area_id;
		
       $result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
        public static function get_total_investment_of_chaumasik_topic_area_type_id($chaumasik,$topic_area_type_id,$type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum($chaumasik) from ".self::$table_name." where topic_area_type_id=".$topic_area_type_id." and type=".$type;
                
                   
                }
                else
                {
                    $sql= "select sum($chaumasik) from ".self::$table_name." where ward_no=".$ward." and topic_area_type_id=".$topic_area_type_id." and type=".$type;
                }
                $result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
           public static function get_total_investment_by_budget_id($fiscal_id,$budget_id)
	{
		global $database;
		$sql = "select sum(investment_amount) from ".self::$table_name." where fiscal_id='".$fiscal_id."' and budget_id=".$budget_id;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$amount = array_shift($row);
                if(is_null($amount) || empty($amount))
                {
                    $amount = 0;
                }
                return $amount;
	}
	public static function find_all()
	{
		global $database;
		return self::find_by_sql("select * from ".self::$table_name);
		 	
	}
       public static function find_by_topic_area_type_id($plan_id_string)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name." where topic_area_type_id=".$plan_id_string);
		return $result_array;
	}
        public function getName($string_id="")
            {
            
                     $topic_selected = self::find_by_id($string_id);
                     return $topic_names = $topic_selected->name;   
            }
	public static function find_by_searched_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} AND type=1 limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}

        public static function find_by_plan_id($plan_id_string)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name." where id in(".$plan_id_string.")");
		return $result_array;
	}
// 	    public static function topic_area_agreement_id($topic_area_agreement_id)
// 	{
// 		global $database;
// 		$result_array=self::find_by_sql("select * from ".self::$table_name." where topic_area_agreement_id in(".$topic_area_agreement_id.")");
// 		return $result_array;
// 	}
	
	         public static function find_distinct_topic_area_type_id($topic_area_id,$type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $result_array=self::find_by_sql("select distinct topic_area_type_id from ".self::$table_name." where type={$type} and topic_area_id={$topic_area_id} order by topic_area_type_id asc");
		
                }
                else
                {
                   $result_array=self::find_by_sql("select distinct topic_area_type_id from ".self::$table_name." where ward_no=".$ward." and type={$type} and topic_area_id={$topic_area_id} order by topic_area_type_id asc");
		 
                }
		
		$topic_area_type_id= array();
                foreach ($result_array as $result):
                   array_push($topic_area_type_id, $result->topic_area_type_id);   
                endforeach;
              
                return $topic_area_type_id;
	}
	         public static function find_distinct_topic_area_sub_id($topic_area_id,$topic_area_type_id,$type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $result_array=self::find_by_sql("select distinct topic_area_type_sub_id from ".self::$table_name." where type={$type} and topic_area_id={$topic_area_id} and topic_area_type_id={$topic_area_type_id} order by topic_area_type_sub_id asc");

                }
                else
                {
                    $result_array=self::find_by_sql("select distinct topic_area_type_sub_id from ".self::$table_name." where ward_no=".$ward." and type={$type} and topic_area_id={$topic_area_id} and topic_area_type_id={$topic_area_type_id} order by topic_area_type_sub_id asc");

                }
		$topic_area_sub_id= array();
                foreach ($result_array as $result):
                array_push($topic_area_sub_id, $result->topic_area_type_sub_id);   
                endforeach;
                return $topic_area_sub_id;
	}
	public static function find_by_id($id=0)
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
		return !empty($result_array)? array_shift($result_array) : false;
	}
        public static function find_by_sn($sn="")
	{
		global $database;
		$result_array=self::find_by_sql("select * from ".self::$table_name. " where sn='".$sn."'  limit 1");
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
            $html.='<ul class="pagination">';
            $total_pages=$pagination->total_pages();
             if($pagination->total_count>$per_page){
                if($pagination->has_previous_page()){//check if it has previous page function used from class
                    $prev_link='<li class="previous"><a href="'.$link.'?page_no='.$pagination->previous_page().'">आघिल्लो</a></li>';
                 }
                    else{
                        $prev_link=" ";
                    }
                    //check if it has next page function used from class
                        if($pagination->has_next_page()){
                        $next_link='<li class="next"><a href="'.$link.'?page_no='.$pagination->next_page().'">पछिल्लो</a></li>';
                        }
                    else{
                        $next_link=" ";
                    }
                    $html .="<li>".$prev_link."</li>";
                for($i=1;$i<=$total_pages;$i++){
                    if($i==$pagination->current_page){
                        $html.='<li class="active"><a href="'.$link.'?page_no='.$pagination->current_page.'">'.convertedcit($pagination->current_page).'</a></li>';
                    }
                    else{
                        $html.='<li> <a href="'.$link.'?page_no='.$i.'">'.convertedcit($i).'</a></li>';


                    }
            }
        $html.="<li>".$next_link."</li>";
        $html.="</ul>";
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
        public function set_page_query1($page_no,$per_page,$link,$sql){
            global $pagination;
            $html='';
            $total_count=self::count_all();
            $pagination->set_pagination($page_no, $per_page, $total_count);
            $sql = "$sql limit ".$pagination->per_page. " offset ".$pagination->offset();
//           echo $sql;exit;
             $result = self::find_by_sql($sql);
             $html=self::getLink($pagination);  
             $output=array();
             array_push($output, $html);
             array_push($output, $result);
//             print_r($output[1]);exit;
            return $output;
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
        public static function count_all_first_chaumasik_plan($topic_area_id,$topic_area_agreement_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where first!=0 and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		
                }
                else
                {
                  $sql = "select count(*) from ".self::$table_name." where first!=0 and ward_no=".$ward." and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		  
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
          public static function count_all_second_chaumasik_plan($topic_area_id,$topic_area_agreement_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where second!=0 and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where second!=0 and ward_no=".$ward." and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
          public static function count_all_third_chaumasik_plan($topic_area_id,$topic_area_agreement_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where third!=0 and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where third!=0 and ward_no=".$ward." and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	public static function count_all()
	{
		global $database;
		$sql = "select count(*) from ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function count_by_topic_area_type_id($topic_area_type_id=0,$type=0,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select count(*) from ".self::$table_name." where topic_area_type_id=".$topic_area_type_id." and type=".$type;
		
                }
                else
                {
                    $sql = "select count(*) from ".self::$table_name." where ward_no=".$ward." and topic_area_type_id=".$topic_area_type_id." and type=".$type;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		$count =  array_shift($row);
                empty($count)? $count = 0 : $count=$count;
                return $count;
	}
        public static function get_total_investment_by_topic_area_type_id($topic_area_type_id=0,$type,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where id not in ( select plan_id from plan_total_investment) and id not in (select plan_id from samiti_plan_total_investment) and id not in(select plan_id from amanat_lagat) and topic_area_type_id=".$topic_area_type_id." and type=".$type;
                    $sql1 = "select sum(agreement_gauplaika + agreement_other + other_agreement) from plan_total_investment as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                    $sql2 = "select sum(investment_amount) from samiti_plan_total_investment as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                    $sql3 = "select sum(investment_amount) from amanat_lagat as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                    
                    
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where id not in ( select plan_id from plan_total_investment) and id not in (select plan_id from samiti_plan_total_investment) and  id not in(select plan_id from amanat_lagat) and ward_no=".$ward." topic_area_type_id=".$topic_area_type_id." and type=".$type;
                    $sql1 = "select sum(agreement_gauplaika + agreement_other + other_agreement) from plan_total_investment as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.ward_no=".$ward." and b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                    $sql2 = "select sum(investment_amount) from samiti_plan_total_investment as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.ward_no=".$ward." and b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                    $sql3 = "select sum(investment_amount) from amanat_lagat as a inner join ".self::$table_name." as b on a.plan_id = b.id where b.ward_no=".$ward." and b.topic_area_type_id=".$topic_area_type_id." and b.type=".$type;
                      
                }
                $result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
                $result_set2 = $database->query($sql1);
		$row2 = $database->fetch_array($result_set2);
                $result_set3 = $database->query($sql2);
		$row3 = $database->fetch_array($result_set3);
                $result_se4t = $database->query($sql3);
		$row4 = $database->fetch_array($result_set4);
                $result1= array_shift($row);
                $result2= array_shift($row2);
                $result3= array_shift($row3);
                $result4= array_shift($row4);
		return $result1+$result2+$result3+$result4;
	}
         public static function get_total_investment_by_chaumasik($chaumasik,$topic_area_id,$topic_area_agreement_id)
	{
		global $database;
		$sql = "select sum($chaumasik) from ".self::$table_name." where topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function get_total_investment_by_topic_area_id_and_agreement($topic_area_id,$topic_area_agreement_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		}
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and topic_area_id=".$topic_area_id." and topic_area_agreement_id=".$topic_area_agreement_id;
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function get_total_investment_by_topic_area_agreement_id($topic_area_agreement_id,$ward)
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where topic_area_agreement_id=".$topic_area_agreement_id;
		}
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward." and topic_area_agreement_id=".$topic_area_agreement_id;
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set); 
		return array_shift($row);
	}
	public static function get_total_investment($ward="")
	{
		global $database;
                if(empty($ward))
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name;
		
                }
                else
                {
                    $sql = "select sum(investment_amount) from ".self::$table_name." where ward_no=".$ward;
		
                }
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
        public static function get_total_investment_by_plan_ids($plan_id_string)
	{
		global $database;
		$sql = "select sum(investment_amount) from ".self::$table_name." where id in(".$plan_id_string.")";
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