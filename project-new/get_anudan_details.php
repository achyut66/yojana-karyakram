<?php
 require_once("includes/initialize.php"); 
$res= array();
$topic_area_agreement= Topicbudget::find_all();
$html="";
$counter = $_POST['counter'];
$html .='<tr class="remove_anudan_details">';
 $html .='<td>'.  convertedcit($counter).'</td>';
$html .='<td>
<select name="budget_id[]">
    <option value="">--------</option>';
    foreach($topic_area_agreement as $result):
$html .='<option value='.$result->id.'>'.$result->name.'</option>';
    endforeach;
$html .='</select>
</td>
                                        <td colspan="2">
                                            <input type="text" name="amount[]" placeholder="रकम">
                                        </td>
                                        <td>&nbsp;</td>';
$res['html'] = $html;
echo json_encode($res);exit;
