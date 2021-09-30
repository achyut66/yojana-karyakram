<?php
require_once("includes/initialize.php");
$res = array();
$enlist_type = $_POST['enlist_type'];
$enlist_id = $_POST['enlist_id'];

$enlist_type_replaced = $_POST['enlist_type_replaced'];
$enlist_id_replaced = $_POST['enlist_id_replaced'];
$full_html = $_POST['html'];

if ($enlist_type_replaced == 10) {
    $enlist_replaced = Contractordetails::find_by_id($enlist_id_replaced);
    $name_replaced = $enlist_replaced->contractor_name;
    $address_replaced = $enlist_replaced->contractor_address;
} else {
    $enlist_replaced = Enlist::find_by_id($enlist_id_replaced);
    $etn_replaced = 'name' . $enlist_type_replaced;
    $eta_replaced = 'address' . $enlist_type_replaced;
    $name_replaced = $enlist_replaced->$etn_replaced;
    $address_replaced = $enlist_replaced->$eta_replaced;
}

if ($enlist_type == 10) {
    $enlist = Contractordetails::find_by_id($enlist_id);
    $name = $enlist->contractor_name;
    $address = $enlist->contractor_address;
} else {
    $enlist = Enlist::find_by_id($enlist_id);
    $etn = 'name' . $enlist_type;
    $eta = 'address' . $enlist_type;
    $name = $enlist->$etn;
    $address = $enlist->$eta;
}


$res['name'] = $name;
$res['address'] = $address;
if (!empty($name_replaced)) {
    $new_html = str_replace($name_replaced, $name, $full_html);
} else {
    $new_html = str_replace('[[form_company_name]]', $name, $full_html);
}

if (!empty($address_replaced)) {
    $new_html = str_replace($address_replaced, $address, $new_html);
} else {
    $new_html = str_replace('[[form_company_address]]', $address, $new_html);
}


$res['new_html'] = $new_html;
echo json_encode($res);
exit;
