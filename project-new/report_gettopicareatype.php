<?php require_once("includes/initialize.php"); 
		require_once("zonelist.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}

$res = array();
$topic_id = $_POST['topic_id']; 
$topic_area_types = Topicareatype::find_by_topic_area_id($topic_id);
$html = '';
$html .= '<td> शिर्षकगत किसिम:</td>';
$html .= '<td><select name="topic_area_type_id" id="topic_area_type_id">';
$html .= '<option value="">-छान्नुहोस्-</option>';
foreach ($topic_area_types as $data) {
	$html .= '<option value="'.$data->id.'">'.$data->topic_area_type.'</option>';
}
$html .= '</select></td>';
$res['html']= $html;
echo json_encode($res); exit;
?>