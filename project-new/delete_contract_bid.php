<?php
include_once 'includes/initialize.php';
$id=$_GET['id'];
$contract=  Contract_bid::find_by_id($id);
$contract->delete();
echo alertBox("हटाउन सफल","contract_bid_form_view.php");
    ?>
    