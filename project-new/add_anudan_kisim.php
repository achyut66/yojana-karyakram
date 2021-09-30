<?php
include("includes/initialize.php");
$res=[];
$anudan_name = $_POST['anudan_name'];
$data = new Topicareaagreement();
$data->name = $anudan_name;
$data->save();
$topic_new_result = Topicareaagreement::find_all();
$html ="";
$html.='<select name="topic_area_agreement_id">';
foreach($topic_new_result as $topic):  
$html.="<option value=".$topic->id.">".$topic->name."</option>";
endforeach; 
$html.='</select>';
$res['html'] = $html;
echo json_encode($res);exit;