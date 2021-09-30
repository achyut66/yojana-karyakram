<?php
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['id'];

$image = Upload::find_by_id($id);
$path = "yojana_picture/".$image->type_id."/".$image->plan_id."/".$image->pic;
//echo $path;exit;
if($image->delete())
{
    $session->message("deleted sucessfully",1);
    unlink($path);
    redirect_to("photos_upload.php");
}

?>