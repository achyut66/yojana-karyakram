<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res = array();
$output='<div class="remove_pics_detail">
       <input type="file" name="pic[]"/>            
        </div>';
       $res['html'] = $output;
       echo json_encode($res);
?>