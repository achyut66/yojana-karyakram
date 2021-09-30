<?php
require_once("includes/initialize.php");
 if(!$session->is_logged_in()){ redirect_to("logout.php");}
$postnames = Postname::find_all();
$res = array();
$counter=$_POST['counter'];
$ward=$_POST['ward'];
empty($ward)? $ward=0 : $ward=$ward;
 $html = '';
 $html .='<tr class="remove_post_detail">
                                    <td class="tdWidth5">'.$counter.'</td>
                                     <td class="tdWidth17">
                                         <select class="post" name="post_id_0[]" required>
                                             <option value=""></option>';
                                             foreach($postnames as $name):
                                                 if($name->id!=1){
                                             $html .='<option value="'.$name->id.'">'.$name->name.'</option>';
                                                 }
                                              endforeach;
                     $html .='</select>
                                     </td>
                                    <td class="tdWidth17"><input type="text" name="name[]" class="input100percent"  required /></td>
                                    <td class="tdWidth5"> <select  class="ward" name="address[]" class="input100percent" required>
                                             <option value="">छान्नुस</option>
                                             ';
                     for($i=1;$i<14;$i++):
                      if($ward==$i){
                          $selected = 'selected="selected"';                       
                      }
                    else {
                         $selected = '';
                    }
                     $html.='<option value="'. $i.'" '.$selected.'>'. $i.'</option>';
                      endfor; 
                     $html.=       '</select>
                                    </td> 
                                    <td class="tdWidth5"> 
                                         <select class="gender" name="gender[]"  required>
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td class="tdWidth17"><input type="text" name="cit_no[]" class="input100percent" required /></td>
                                    <td class="tdWidth17"><input type="text" name="issued_district[]" class="input100percent" required value="'.SITE_ZONE.'" /></td>
                                    <td class="tdWidth17"><input type="text" name="mobile_no[]" class="input100percent" required /></td>
                                    
                                    
                                </tr>';
       $res['html'] = $html;
       echo json_encode($res); exit;