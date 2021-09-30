<?php
include_once('includes/initialize.php');
$settingbhautikPariman = SettingbhautikPariman::find_all_parents();
$units = Units::find_all();
$res=[];
$counter = $_POST['counter'];
$output ="";
$output .='<tr class="remove_plan_form_details">   
    <td class="sn" name="sn" id="sn_'.$counter.'" value="'.$counter.'">'.$counter.'</td>
    <td>
     <select class="parent_details_id" name="parent_details_id[]" style="min-width: 100%;">
    <option value="">--------</option>';
foreach($settingbhautikPariman as $data):
    $output .='<option value="'.$data->id.'">'.$data->name.'</option>';
endforeach;
$output .='</select>
    </td>
    <td>
     <select class="details_id" required name="details_id[]" style="min-width: 100%;">
    <option value="">--------</option>
    </select>
    </td>
    <td><input type="text" name="qty[]"/></td>
    <td>
        <select name="unit_id[]">
            <option value="">--छान्नुहोस् --</option>';
foreach($units as $unit):
    $output .='<option value="'.$unit->id.'" >'.$unit->name.'</option>';
endforeach;
$output .='</select>
    </td>
     <td style="width:5%;">
        <button class="remove_btn" id="remove_btn_'.$counter.'">
            <img src="images/cross.png" style="height: 20px; width: 20px;">
        </button>
    </td>
</tr>';
$res['html'] = $output;

$output ="";
$output .='<select name="new_parent_id" id="new_parent_id" class="form-control">
        <option value="-1">छानुहोस</option>';
foreach($settingbhautikPariman as $data):
    $output .='<option value="'.$data->id.'">'.$data->name.'</option>';
endforeach;
$output .= '</select>';
$res['new_data'] = $output;


echo json_encode($res);exit;
?>