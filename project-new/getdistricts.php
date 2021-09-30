<?php require_once("includes/initialize.php"); 
		require_once("zonelist.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}

$res = array();
$zone = $_POST['zone']; 
$html = '';
if(!empty($zone))
{
	$districts = $zones[$zone]; 
	
	$html .=  '<select name="district" required><option>--select one--</option>';
	foreach($districts as $district)
	{
		$html.='<option value="'.$district.'">'.$district.'</option>';
	}
	$html .='</select>';
	$res['html'] = $html;
	echo json_encode($res); exit;	
}
else
{
	$html .= '<select name="district" required></select>';
	$res['html'] = $html;
	echo json_encode($res); exit;
}
