<?php
require_once("includes/initialize.php");
$res = [];
$topic_area=  Topicarea::find_all();
$budget_results= Topicbudget::find_all();
$counter = $_POST['counter'];
$html ="";
$html .='<tr class="remove_nirman_details">
            <td class="sn" name="sn" id="sn_'.$counter.'" value="'.$counter.'">'.$counter.'</td>
            <td><textarea name="program_name[]"></textarea></td>
            <td><textarea name="address[]"></textarea></td>
            <td><input type="text" name="ward_no[]" /></td>
            <td>
                <select name="topic_id[]" id="topic_area_id_'.$counter.'" >
                   <option value="">--छान्नुहोस्--</option>';
                            foreach($topic_area as $topic): 
                   $html .='<option value="'.$topic->id.'">'.$topic->name.'</option>';
                        endforeach; 
                $html .='</select>
            </td>
            <td id="topic_area_type_'.$counter.'"></td>
            <td id="topic_area_type_sub_'.$counter.'"></td>
            <td>
                <select name="budget_id[]" id="budget_id" >
                   <option value="">--छान्नुहोस्--</option>';
                            foreach($budget_results as $topic): 
                   $html .='<option value="'.$topic->id.'">'.$topic->name.'</option>';
                        endforeach; 
                $html .='</select>
            </td>
            <td><input type="text" name="amount[]" /></td>
               <td><button class="remove_btn" id="remove_btn_<?=$i?>"><img src="images/cross.png" style="height: 20px; width: 20px;"></button></td>
        </tr>';
                
$res['html'] = $html;
echo json_encode($res);die();