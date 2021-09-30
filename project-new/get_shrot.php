<?php
 require_once("includes/initialize.php"); 
$res= array();
$shrot_result= ShrotDetails::find_all();
$html="";
$counter = $_POST['counter'];
$html .='<tr class="remove_shrot_details">';
 $html .='<td>'.  convertedcit($counter).'</td>';
$html .='<td>
<select name="shrot_id[]">
    <option value="">--------</option>';
    foreach($shrot_result as $result):
$html .='<option value='.$result->id.'>'.$result->name.'</option>';
    endforeach;
$html .=' </select>
</td>
<td><input type="text" name="budgets[]"/> </td>';
$res['html'] = $html;
echo json_encode($res);exit;