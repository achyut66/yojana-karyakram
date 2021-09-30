<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res = array();
$counter=$_POST['counter'];
$work_details=Worktopic::find_all();
$units = Units::find_all();
 $output="";
    $output.='<tr class="remove_estimate_detail" id="remove_estimate_detail-'.$counter.'">
    <td>'.$counter.'</td>';
    $output .= '<td><img id="break-'.$counter.'" class="break" src="images/break.png" width="20px" height="20px"/></td>';
//    $output .= '<td></td>';
//    $output.='<td>
//         <select name="task_id[]" id="task_id-'.$counter.'">
//                        <option value="">---छान्नुहोस्---</option>';
//                    foreach($work_details as $data):
//                        $output.='<option value='.$data->id.'>'.$data->work_name.'</option>';
//                    endforeach; 
//    $output.='</select>';
//    $output.='</td>
//   $output .='<td id="task_name_column-'.$counter.'">  </td>
   $output .=' <td colspan="3" id="estimate_sub-'.$counter.'"><textarea  cols="30"  rows="3" name="main_work_name[]"></textarea></td>
    <td><input type="text" id="task_count-'.$counter.'" name="task_count[]" class="myWidth100" /></td>
   <td><input type="text"  id="length-'.$counter.'" name="length[]" class="myWidth100"/><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="length-'.$counter.'-c" > &nbsp; </button></td>
    <td><input type="text" id="breadth-'.$counter.'" name="breadth[]" class="myWidth100" /><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="length-'.$counter.'-c" > &nbsp; </button></td>
    <td><input type="text" id="height-'.$counter.'" name="height[]" class="myWidth100"/><button type="button" class="calculator cl_bg" data-toggle="modal" data-target="#myModal" id="length-'.$counter.'-c" > &nbsp; </button></td>
   <td><input type="text" id="total_evaluation-'.$counter.'" name="total_evaluation[]" class="myWidth100"/></td>
    <td id="unit-'.$counter.'"><select name="unit_id[]"><option value="">----</option>';
    foreach($units as $unit):
        $output .= '<option value="'.$unit->id.'">'.$unit->name.'</option>';
    endforeach;
    $output .='</select></td>
    <td><input type="text" id="task_rate-'.$counter.'" name="task_rate[]" class="myWidth100"/></td>
    <td><input type="text" id="total_rate-'.$counter.'" name="total_rate[]" class="myWidth100"/></td>
</tr>';
$res['output'] = $output;
echo json_encode($res); exit;