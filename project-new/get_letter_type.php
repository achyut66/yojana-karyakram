<?php
require_once("includes/initialize.php");
$res = array();
$plan_type = $_POST['plan_type'];
$result = LetterFormat::find_by_plan_type($plan_type);
$html = '<option value=""></option>';

if (!empty($result)) {
    foreach ($result as $data):
$html.='<option value="'.$data->letter_type.'">'.$data->letter_type.'</option>';
    endforeach;
}
$res['html'] = $html;
echo json_encode($res);
exit;
