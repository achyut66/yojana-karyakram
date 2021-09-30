<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res = array();
$counter = $_POST['counter'];
$break_row_length = $_POST['break_row_length'];
$sn=$_POST['sn']+1;
$new_break_row_length = $break_row_length+1;
$break_numbering = $counter.".".$sn;
$break_id = $counter."_".$new_break_row_length;
$new_counter = $counter+ 1;
$html = '';
$total_output_row ='';
$html .='<tr id="break_row-'.$break_id.'" class="break_row-'.$counter.'">
                                <td></td>';
//                                <td></td>
                                $html .='<td>'.$break_numbering.'</td>
                                <td> घटाउने भाग <input class="deduct_part" id="deduct-'.$break_id.'" type="checkbox" name="deduct-'.$break_id.'" value="1" /></td>
                                <td colspan="2"><textarea rows="3" name="break_work_name-'.$counter.'[]"></textarea></td>
                                <td><input type="text" id="task_count-'.$break_id.'" name="task_count-'.$counter.'[]" class="myWidth100"></td>
                                <td><input type="text" id="length-'.$break_id.'" name="length-'.$counter.'[]" class="myWidth100"><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="length-'.$break_id.'-c" > &nbsp; </button></td>
                                <td><input type="text" id="breadth-'.$break_id.'" name="breadth-'.$counter.'[]" class="myWidth100"><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="breadth-'.$break_id.'-c" > &nbsp; </button></td>
                                <td><input type="text" id="height-'.$break_id.'" name="height-'.$counter.'[]" class="myWidth100"><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="height-'.$break_id.'-c" > &nbsp; </button></td>
                               <td><input type="text" id="total_evaluation-'.$break_id.'" name="total_evaluation-'.$counter.'[]" class="myWidth100"></td>
                                <td id="unit-1"></td> 
                                <td></td>
                                <td></td>
                                <td><img src="images/cross.png" class="remove_break" id="cross-'.$break_id.'" name="cross" width="20px" height="20px" /></td>
            </tr>';
$res['html'] = $html;
if($break_row_length==0)
{
    $total_output_row .='<tr id="total_output_row-'.$counter.'">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:right">जम्मा</td>
                                <td><input type="text" id="total_evaluation-'.$counter.'" name="total_evaluation[]" class="myWidth100"></td>
                                <td id="unit-1"></td> 
                                <td><input type="text" id="task_rate-'.$counter.'" name="task_rate[]" class="myWidth100"></td>
                                <td><input type="text" id="total_rate-'.$counter.'" name="total_rate[]" class="myWidth100"></td>
                                <td></td>
            </tr>';
}
$res['total_output_row'] = $total_output_row;
echo json_encode($res);exit;
?>
