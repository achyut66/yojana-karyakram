<?php require_once("includes/initialize.php"); 
		require_once("zonelist.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}

$res = array();
$topic_id = $_POST['topic_id'];
$counter = $_POST['counter'];
$topic_area_types = Topicareatypesub::find_by_topic_area_type_id($topic_id);
$html = '';
$html .= '<select name="topic_area_type_sub_id[]" id="topic_area_type_sub_id_'.$counter.'">';
$html .= '<option value="">-छान्नुहोस्-</option>';
foreach ($topic_area_types as $data) {
	$html .= '<option value="'.$data->id.'">'.$data->topic_area_type_sub.'</option>';
}
$html .= '</select>';
$res['html']= $html;
echo json_encode($res); exit;
