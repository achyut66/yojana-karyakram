<?php
include_once('includes/initialize.php');
print_r($_POST['params']);
$settingbhautikPariman = SettingbhautikPariman::find_child_by_parent($_POST['id']);
$res=[];
$output ="";
if($_POST['subdata'] != true) {
    $output .='<select class="details_id" required name="details_id[]" style="min-width: 100%;">
            <option value="">--------</option>';
    foreach($settingbhautikPariman as $data):
        $output .='<option value="'.$data->id.'">'.$data->name.'</option>';
    endforeach;
    $output .= '</select>';
    $res['html'] = $output;
    echo json_encode($res);exit;
} else {
    $output = '<table class="table table-bordered table-hover">
    <tr>
        <td class="myCenter"><strong>सि.नं.</strong></td>
        <td class="myCenter"><strong>भौतिक लक्ष्यको शिर्षक </strong></td>
        <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
    </tr>';
    $i=1;
    foreach($settingbhautikPariman as $result):
        $output .='<tr>
        <td class="myCenter">'.convertedcit($i).'</td>
        <td class="myCenter">'.convertedcit($result->name).'</td>
        <td class="myCenter"><a href="settings_bhautik_lakshya.php?id='.$result->id.'" class="btn">सच्याउनुहोस</a></td>
    </tr>';
        $i++;
    endforeach;
    $output .='</table>';
    $res['html'] = $output;
    $res['html1'] = $settingbhautikPariman;
    echo json_encode($res);exit;
}
?>
