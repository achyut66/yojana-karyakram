<?php
require_once("includes/initialize.php");
$res = array();
$plan_id = $_POST['plan_id'];
$plan_type = $_POST['plan_type'];
$letter_type = $_POST['letter_type'];
$english_date = $_POST['english_date'];
$type_name1 = $_POST['type_name1'];
$type_name2 = $_POST['type_name2'];
$type_name3 = $_POST['type_name3'];
$type_name4 = $_POST['type_name4'];
$worker1 = $_POST['worker1'];
$worker2 = $_POST['worker2'];
$worker3 = $_POST['worker3'];
$worker4 = $_POST['worker4'];
$worker1_result = Workerdetails::find_by_id($worker1);
$worker2_result = Workerdetails::find_by_id($worker2);
$worker3_result = Workerdetails::find_by_id($worker3);
$worker4_result = Workerdetails::find_by_id($worker4);
$letter_history = PrintHistory::find_by_url_plan_id_and_letter_type($plan_type, $plan_id, $letter_type);
if (!empty($letter_history)) {
    $print_history = $letter_history;
} else {
    $print_history = new PrintHistory();
}
$print_history->plan_id = $plan_id;
$print_history->type_name1 = $type_name1;
$print_history->type_name2 = $type_name2;
$print_history->type_name3 = $type_name3;
$print_history->type_name4 = $type_name4;
$print_history->worker1 = $worker1;
$print_history->worker2 = $worker2;
$print_history->worker3 = $worker3;
$print_history->worker4 = $worker4;
$print_history->nepali_date = $english_date;
$print_history->english_date = DateNepToEng($english_date);
$print_history->url = $plan_type;
$print_history->letter_type = $letter_type;
$print_history->save();
$res['date'] = 'मिती :' . convertedcit($english_date);
$res['type_name1'] = $type_name1;
$res['type_name2'] = $type_name2;
$res['type_name3'] = $type_name3;
$res['type_name4'] = $type_name4;
$res['worker1'] = $worker1;
$res['worker2'] = $worker2;
$res['worker3'] = $worker3;
$res['worker4'] = $worker4;

$res['w1'] = $type_name1 . '<br>' . $worker1_result->authority_name . '<br>' . $worker1_result->post_name;
$res['w2'] = $type_name2 . '<br>' . $worker2_result->authority_name . '<br>' . $worker2_result->post_name;;
$res['w3'] = $type_name3 . '<br>' . $worker3_result->authority_name . '<br>' . $worker3_result->post_name;;
$res['w4'] = $type_name4 . '<br>' . $worker4_result->authority_name . '<br>' . $worker4_result->post_name;;
echo json_encode($res);
exit;
