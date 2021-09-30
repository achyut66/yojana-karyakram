<?php require_once("includes/initialize.php"); 
		require_once("zonelist.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}

$res = array();
$topic_id = $_POST['topic_id']; 
$topic_area_types = Topicareatypesub::find_by_topic_area_type_id($topic_id);
$html = '';
$html .= '<div class="titleInput">उपशिर्षकगत किसिम:</div>';
$html .= '<div class="newInput"><select name="topic_area_type_sub_id">';
$html .= '<option value="">-छान्नुहोस्-</option>';
foreach ($topic_area_types as $data) {
	$html .= '<option value="'.$data->id.'">'.$data->topic_area_type_sub.'</option>';
}
$html .= '</select></div><button type="button" class=" cl_bg" data-toggle="modal" data-target="#myModal2" id="length-1-c" > + </button>';
$res['html']= $html;
echo json_encode($res); exit;
