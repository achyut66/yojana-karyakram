<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res = array();
$counter=$_POST['counter'];
    $res['html_5'] = '<input type="text" id="task_count-'.$counter.'" name="task_count[]" class="myWidth100" />';
    $res['html_6'] = '<input type="text"  id="length-'.$counter.'" name="length[]" class="myWidth100"/><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="length-'.$counter.'-c" > &nbsp; </button>';
    $res['html_7'] = '<input type="text" id="breadth-'.$counter.'" name="breadth[]" class="myWidth100" /><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="breadth-'.$counter.'-c" > &nbsp; </button>';
    $res['html_8'] = '<input type="text" id="height-'.$counter.'" name="height[]" class="myWidth100"/><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="height-'.$counter.'-c" > &nbsp; </button>';
    $res['html_9'] = '<input type="text" id="total_evaluation-'.$counter.'" name="total_evaluation[]" class="myWidth100"/>';
    $res['html_11'] = '<input type="text" id="task_rate-'.$counter.'" name="task_rate[]" class="myWidth100"/>';
    $res['html_12'] = '<input type="text" id="total_rate-'.$counter.'" name="total_rate[]" class="myWidth100"/>';
    echo json_encode($res); exit;
