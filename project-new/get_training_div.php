<?php
    require_once 'includes/initialize.php';
    $units = Units::find_all();
    $sn = $_POST['count'];
    $html = '<tr class="training_row" id="row_'.$sn.'">
                <td class="max_sn">'.convertedcit($sn).'</td>
                <td><input type="text" name="description[]" class="form-control" required></td>
                <td>
                    <select name="unit[]" id="unit_'.$sn.'">
                        <option value="छान्नुहोस"></option>';
                        foreach($units as $unit){
    $html .='               <option value="'.$unit->id.'">'.$unit->name.'</option>';
                     }
    $html .='       </select>
                </td>
                <td><input type="text" name="rate[]" id="rate_'.$sn.'" required></td>
                <td><input type="text" name="quantity[]" id="quantity_'.$sn.'" required></td>
                <td><input type="text" name="total[]" id="total_'.$sn.'" readonly="true" required></td>
                <td><textarea name="remarks[]"></textarea></td>
            </tr>';
    $res = [];
    $res['html'] =  $html;
    echo json_encode($res);exit;
?>

