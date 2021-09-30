<?php require_once("includes/initialize.php"); 
$res = array();
$task_name=$_POST['task_name'];
$output = '';
$counter=$_POST['counter'];
$result=  Estimateadd::find_by_id($task_name);
$output.= Units::getName($result->unit_id);
$res['output'] = $output;
echo json_encode($res); exit;
?>