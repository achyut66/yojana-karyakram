<?php
include("includes/initialize.php");
$res=[];
$budget_add= $_POST['budget_add'];
$topic_name_add= $_POST['topic_name_add'];
$topic_id = $_POST['topic_id'];
$topic = new Topicareatype();
$topic->topic_area_id=$topic_id;
$topic->topic_area_type=$topic_name_add;
$topic->budget = $budget_add;
$topic->save();
$topic_new_result = Topicareatype::find_by_topic_area_id($topic_id);
$html ="";
$html.='<div class="titleInput"> शिर्षकगत किसिम :  </div><div class="newInput"><select name="topic_area_type_id" id="topic_area_type_id">';
foreach($topic_new_result as $topic):  
$html.="<option value=".$topic->id.">".$topic->topic_area_type."</option>";
endforeach; 
$html.='</select></div><div><button type="button" class=" cl_bg" data-toggle="modal" data-target="#myModal1" id="length-1-c" > + </button></div>';
$res['html'] = $html;
echo json_encode($res);exit;