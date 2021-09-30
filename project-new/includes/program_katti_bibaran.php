<?php
// if it's going to need the database, then it's
// probably smart to require it before we start
require_once('database.php');
require_once('database_object.php');
class ProgramKatti
{
    protected static $table_name = "program_katti_bibaran";
    protected static $db_fields = array('id','program_id','topic_name','percent','kar_katti_amount','katti_kar');
    public $id;
    public $program_id;
    public $topic_name;
    public $percent;
    public $kar_katti_amount;
    public $katti_kar;

    public function find_by_plan_id($id = 0) {
        // $result_array = self::find_by_sql("select * from ".self::$table_name." where darta_id = {$id}");
        // return $result_array;

        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where program_id={$id} ");
        return $result_array;

    }
    // Common database method
    public static function find_by_plan_id_and_date($id=0,$date_from,$date_to)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$id} and created_date_english > '".$date_from."' and created_date_english< '".$date_to."'");
        return $result_array;
    }
    public static function sum_katti_amount_by_plan_id_katti_id_type($id=0,$detail_id,$type)
    {
        global $database;
        $sql = "select sum(katti_amount) from ".self::$table_name." where plan_id={$id} and katti_id={$detail_id} and type={$type}";
//                echo $sql."<br>";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);

    }
    public static function find_by_plan_id_katti_id_id_type($id=0,$detail_id,$type)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$id} and katti_id={$detail_id} and type={$type}");
        return !empty($result_array)? array_shift($result_array) : false;
    }
    public static function find_by_plan_id_and_type_payment_count($id=0,$type,$payment_count)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$id} and type=1 and payment_count=".$payment_count);
        return $result_array;
    }
    public static function find_by_plan_id_and_type($id=0,$type)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where plan_id={$id} and type=1");
        return $result_array;
    }
    public static function find_all()
    {
        global $database;
        return self::find_by_sql("select * from ".self::$table_name);

    }
    public static function find_plan_ids_by_parent_plan_id($plan_id)
    {
        global $database;
        return self::find_by_sql("select * from ".self::$table_name." where parent_plan_id='".$plan_id."'");

    }


    public static function setEmptyObjects()
    {
        return new self;
    }
    public function getName($string_id="")
    {
        $topic_selected = self::find_by_id($string_id);
        return $topic_names = $topic_selected->name;
    }
    public static function find_by_filename($filename)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where link_name='".$filename."' limit 1");
        return !empty($result_array)? array_shift($result_array) : false;
    }
    public static function find_by_id($id=0)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where id={$id} limit 1");
        return !empty($result_array)? array_shift($result_array) : false;
    }
    public static function find_by_topic_id($id=0)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where topic_name={$id} limit 1");
        return !empty($result_array)? array_shift($result_array) : false;
    }
    public static function find_by_pan_no($pan_no=0)
    {
        global $database;
        $result_array=self::find_by_sql("select * from ".self::$table_name. " where pan_no={$pan_no} limit 1");
        return !empty($result_array)? array_shift($result_array) : false;
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
    public static function count_by_detail_id($id)
    {
        global $database;
        $sql = "select count(*) from ".self::$table_name." where detail_id=".$id;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
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

    public static function delete_data($plan_id) {

        global $database;
        // delete from table where condition limit 1
        $sql = "delete from " .self::$table_name ;
        $sql .= " where darta_id=".$database->escape_value($plan_id);
        $database->query($sql);

        //return ($database->affected_rows() == 1) ? true : false;

        //echo $this->plan_id;
        //return $plan_id;
        //global $database;
        // $sql = 'DELETE * FROM ' .self::$table_name. " where darta_id = {$plan_id}";
        // $database->query($sql);
        // return ($database->affected_rows() == 1) ? true : false;

    }
}
?>