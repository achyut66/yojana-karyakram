<?php
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_POST['id'];
$delete_anugaman = Enlist::find_by_type_and_id(0,$id);
//print_r($delete_anugaman);
//exit;
if($delete_anugaman->delete()){
    echo alertBox("हटाउन सफल हुनु भयो","settings_enlist_view.php");
}
