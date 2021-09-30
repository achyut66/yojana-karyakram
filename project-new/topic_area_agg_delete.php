<?php
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_POST['id'];
$delete_anugaman = Topicareaagreement::find_by_id($id);
//print_r($delete_anugaman);
//exit;
if($delete_anugaman->delete()){
    echo alertBox("हटाउन सफल हुनु भयो","view_topic_area_agreement.php");
}
