<?php
error_reporting(-1);
require_once("includes/initialize.php");
$c = $_POST['c'];

$group_details = Costumerassociationdetails::find_by_cit_no($c);
print_r($group_details);
exit;
if(!empty($group_details)) {
    //echo '
    $response = array(
              'status'      => 'fail',
              'data'         => "नागरिकता नं दाखिला गरिसकिएको छ",
              'data1'       => $group_details,
             );
              
          header("Content-type: application/json");
          echo json_encode($response);
          exit;
} else {
    $response = array(
              'status'      => 'success',
              'data'         => "",
             
          );
          header("Content-type: application/json");
          echo json_encode($response);
          exit;
}
?>