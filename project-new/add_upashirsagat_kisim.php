<?php
include("includes/initialize.php");
$res=[];
$topic_id_add= $_POST['topic_id_add'];
$topic_area_type_id_add= $_POST['topic_area_type_id_add'];
$topic_area_type_sub = $_POST['topic_area_type_sub'];
$data = new Topicareatypesub();
$data->topic_area_type_id = $topic_area_type_id_add;
$data->topic_area_type_sub =$topic_area_type_sub;
$data->save();
$topic_new_result =Topicareatypesub::find_by_topic_area_type_id($topic_area_type_id_add);
$html ="";
$html.='<div class="titleInput"> उपशिर्षकगत किसिम:</div><div class="newInput"><select name="topic_area_type_sub_id">';
foreach($topic_new_result as $topic):  
$html.="<option value=".$topic->id.">".$topic->topic_area_type_sub."</option>";
endforeach; 
$html.='</select></div><button type="button" class=" cl_bg" data-toggle="modal" data-target="#myModal2" id="length-1-c" > + </button>';
$res['html'] = $html;
echo json_encode($res);exit;