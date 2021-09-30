<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//alert("here");
$res = array();
 $html = '';
 $html .='<tr class="remove_picture_detail">
        <td><input type="file" name="program_picture[]"/></td>             

        </tr>';
       $res['html'] = $html;
       echo json_encode($res); exit;
