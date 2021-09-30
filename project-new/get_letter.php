<?php
require_once("includes/initialize.php");
$res = array();
$plan_type = $_POST['plan_type'];
$letter_type = $_POST['letter_type'];
$plan_id = $_POST['plan_id'];
$result = LetterFormat::find_by_plan_type_and_letter_type($plan_type, $letter_type);

$html = '';
$letter_history = PrintHistory::find_by_url_plan_id_and_letter_type($plan_type, $plan_id, $letter_type);

if(!empty($letter_history))
{
//$res['msg'] = $letter_history->worker1;
//echo json_encode($res);exit;
    $res['type_name1'] = $letter_history->type_name1;
    $res['type_name2'] = $letter_history->type_name2;
    $res['type_name3'] = $letter_history->type_name3;
    $res['type_name4'] = $letter_history->type_name4;
    $res['date'] = $letter_history->nepali_date;

    $res['worker_1'] = $letter_history->worker1;
    $res['worker_2'] = $letter_history->worker2;
    $res['worker_3'] = $letter_history->worker3;
    $res['worker_4'] = $letter_history->worker4;

    if(!empty($letter_history->worker1))
    {
        $worker1 = Workerdetails::find_by_id($letter_history->worker1);
        $res['post_1'] = $worker1->post_name;

    }
    if(!empty($letter_history->worker2))
    {
        $worker2 = Workerdetails::find_by_id($letter_history->worker2);
        $res['post_2'] = $worker2->post_name;
    }
    if(!empty($letter_history->worker3))
    {
        $worker3 = Workerdetails::find_by_id($letter_history->worker3);
        $res['post_3'] = $worker3->post_name;
    }
    if(!empty($letter_history->worker4))
    {
        $worker4 = Workerdetails::find_by_id($letter_history->worker4);
        $res['post_4'] = $worker4->post_name;
    }

}
else
{
    $res['type_name1'] ='';
    $res['type_name2'] = '';
    $res['type_name3'] = '';
    $res['type_name4'] = '';

    $res['worker_1'] ='';
    $res['worker_2'] = '';
    $res['worker_3'] = '';
    $res['worker_4'] = '';
    $res['post_1'] = '';
    $res['post_2'] = '';
    $res['post_3'] = '';
    $res['post_4'] = '';

}

if (!empty($result)) {
    $html = $result->letter_text;

    //  $str = 'Lorem [[ipsum]] dolor sit amet, [[consetetur]] sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. ...';
    $new_str = explode(" ", $html);
    $start = '[[';
    $end = ']]';
    $pattern = sprintf(
        '/%s(.+?)%s/ims',
        preg_quote($start, '/'), preg_quote($end, '/')
    );
    $result_html = array();
    foreach ($new_str as $new_string) {
        if (preg_match($pattern, $new_string, $matches)) {
            list(, $match) = $matches;
            array_push($result_html, $match);
        }
    }
    $value_array = array();
    foreach ($result_html as $data):
        $result_this = LetterIndices::find_by_index($data);

        if (!empty($result_this)) {
            if ($result_this->letter_table == 'plan_details1') {
                $sql = 'select * from ' . $result_this->letter_table . ' where id = ' . $plan_id;
            } else {
                $sql = 'select * from ' . $result_this->letter_table . ' where plan_id = ' . $plan_id;
            }

            $result_value = $database->query($sql);
            $value = mysqli_fetch_assoc($result_value);
            $value_array[$data] = $value[$result_this->table_property];

        }
    endforeach;

    foreach ($value_array as $key => $value) {
        $key = '[[' . $key . ']]';
        if (is_numeric($value)) {
            $value = convertedcit(placeholder($value));
        }
        $html = str_replace($key, $value, $html);

    }

}
$res['html'] = $html;
echo json_encode($res);
exit;
