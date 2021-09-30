<?php
require_once("includes/initialize.php");
$res = array();
$plan_type = $_POST['plan_type'];
$letter_type = $_POST['letter_type'];
$result = LetterFormat::find_by_plan_type_and_letter_type($plan_type, $letter_type);

$html = '';


if (!empty($result)) {
    $html = $result->letter_text;
}
$res['html'] = $html;
$res['update_id'] = $result->id;
echo json_encode($res);
exit;
