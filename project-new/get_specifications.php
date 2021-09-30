<?php require_once("includes/initialize.php"); 
$res = array();
$task_id = $_POST['task_id'];
$output         = '';
$estimate_html  = '';
$counter        = $_POST['counter'];
//$result         =  Estimateadd::find_by_id($task_name);
//$output        .= Units::getName($result->unit_id);
$res['output']  = $output;
$estimates      = SettingSpecs::find_by_task_id($task_id);
// getting all the estimate_sub_id s
//    $estimate_html   .='<select  name="estimate_sub_id[]" class="estimate_sub_id-'.$counter.'">'
//            . '<option value="">--छान्नुहोस् --</option>';
$estimate_html .= '<form method="post" name="spec_form"><table><tr><th>Name</th><th>Action</th></tr>';
foreach($estimates as $estimate):
    ($estimate->default_spec==1)? $checked='checked="checked"': $checked='';
    $estimate_html .= '<tr><td>'.$estimate->name.'</td><td><input '.$checked.' type="checkbox" name="spec_pop" value="'.$estimate->id.'" /></td></tr>';
  
endforeach;
    $estimate_html .= '</table><input type="hidden" name="counter" value="'.$counter.'" /></form>';
 $res['estimate_html'] = $estimate_html;
echo json_encode($res); exit;
?>