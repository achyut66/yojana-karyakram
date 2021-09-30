<?php
 require_once("includes/initialize.php"); 
$res= array();
$topic_area_agreement= Topicareaagreement::find_all();
$html="";
$counter = $_POST['counter'];
$html .='<tr class="remove_anudan_details_topic">';
 $html .='<td>'.  convertedcit($counter).'</td>';
$html .='<td>
<select name="topic_area_agreement_id[]">
    <option value="">--------</option>';
    foreach($topic_area_agreement as $result):
$html .='<option value='.$result->id.'>'.$result->name.'</option>';
    endforeach;
$html .=' </select>
</td>
 ';
$res['html'] = $html;
echo json_encode($res);exit;
