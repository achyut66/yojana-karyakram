<?php
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_POST['id'];
$delete_anugaman = AnugamanSamitiBibaran::find_by_id($id);
//print_r($delete_anugaman);

if($delete_anugaman->delete()){
//    redirect_to("anugaman_samiti_bibaran.php");
    echo alertBox("हटाउन सफल हुनु भयो","anugaman_samiti_bibaran.php");
}
