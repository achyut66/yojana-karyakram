<?php
include("includes/initialize.php");
$res=[];
$budget_add= $_POST['budget_add'];
$topic_name_add= $_POST['topic_name_add'];
$data=new Topicarea(); 
$data->name= $topic_name_add;
$data->budget= $topic_name_add;
$topic_id=$data->save();

$topic_new_result = Topicarea::find_all();
$html ="";
$html.='<select name="topic_area_id" id="topic_area_id" >';
foreach($topic_new_result as $topic):  
$html.="<option value=".$topic->id.">".$topic->name." </option>";
endforeach; 
$html.="</select>";
$res['html'] = $html;
echo json_encode($res);exit;