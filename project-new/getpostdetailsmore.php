<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 $counter=$_POST['counter'];
$post="select * from postname where type=1";
$postnames=  Postname::find_by_sql($post);
$res = array();
 $html = '';
 $html .='<tr class="remove_post_detail_more">
                                    <td class="tdWidth10">'.$counter.'</td>
                                     <td class="tdWidth10">
                                         <select class="post" name="post_id_1[]">
                                             <option value="">छान्नुस</option>';
                                             foreach($postnames as $name):
                                             $html .='<option value="'.$name->id.'">'.$name->name.'</option>';
                                              endforeach;
                     $html .='</select>
                                     </td>
                                    <td class="tdWidth20"><input type="text" name="name_1[]" class="input100percent"/></td>
                                    <td class="tdWidth20"><input type="text" name="address_1[]" class="input100percent"/></td>
                                     <td class="tdWidth10"> 
                                         <select class="gender1" name="gender_1[]">
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                </tr>';
       $res['html'] = $html;
       echo json_encode($res); exit;
