<?php
include_once('includes/initialize.php');
$enlist_result = Enlist::find_all();
$contractor_result = Contractordetails::find_all();

$merge_enlist_result = array_merge($enlist_result, $contractor_result);
$units = Units::find_all();
$res=[];
$counter = $_POST['counter'];
$output ="";
$output .='<tr class="remove_kabol_form">   
    <td class="sn" name="sn" id="sn_'.$counter.'" value="'.$counter.'">'.convertedcit($counter).'</td>
    <td>
     <select name="enlist_id[]" class="select22">
                                                <option value=""></option>';
foreach ($merge_enlist_result as $en):
                                                    if (!empty($en->contractor_name)) {
                                                        $name = $en->contractor_name;
                                                        $type = 'निर्माण ब्यवोसायी';
                                                        $save_type = '10';
                                                    } else {
                                                        $name_string = 'name' . $en->type;
                                                        $name = $en->$name_string;
                                                        $save_type = $en->type;

                                                        switch ($en->type) {
                                                            case 0:
                                                                $type = 'फर्म/कम्पनी';
                                                                break;
                                                            case 1:
                                                                $type = 'कर्मचारी';
                                                                break;
                                                            case 2:
                                                                $type = 'संस्था';
                                                                break;
                                                            case 3:
                                                                $type = 'पदाधिकारी';
                                                                break;
                                                            case 4:
                                                                $type = 'अन्य समूह ';
                                                                break;
                                                            case 5:
                                                                $type = 'उपभोक्ता समिति';
                                                                break;
                                                            default:
                                                                $type =  "";
                                                        }


                                                    }

                                  $output.='<option value="'.$en->id.'-'.$save_type.'">'.$name.' ('.$type.')</option>';
                                           endforeach;
                                 $output.='</select>
     
     
  </td>
    <td><input type="text" name="amount[]"/></td>
    <td>
        <input type="text" name="extra_amount[]"/>
    </td>
        <td>हो : <input type="radio" name="is_vat['.($counter-1).']" value="1"/> होईन : <input type="radio" name="is_vat['.($counter-1).']" value="2"/> </td>
    <td><input type="text" name="remarks[]"/></td>
    ';
$res['html'] = $output;
echo json_encode($res);exit;
?>
