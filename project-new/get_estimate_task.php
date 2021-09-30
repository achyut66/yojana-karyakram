<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res = array();
$task_id=$_POST['task_id'];
$html = '';
$output='';
$counter=$_POST['counter'];
$sql="select * from estimate_add where task_id=".$task_id;
$result=  Estimateadd::find_by_sql($sql);
//$res['html'] = $sql;
//echo json_encode($res); exit;
$html.='<select  name="task_name[]" id="task_name-'.$counter.'" class="mySelect15">'
        . '<option value="">--छान्नुहोस् --</option>';
   foreach($result as $data):
$html.="<option value=".$data->id.">".$data->task_name."</option>";
    endforeach; 
$html.="</select>";
       
$res['html'] = $html;

echo json_encode($res); exit;
