<?php
require_once("includes/initialize.php");
$res=array();
$sql = 'select letter_index  , letter_index_nepali  from letter_indices';
$result = $database->query($sql);
$arr = array();
while ($data = mysqli_fetch_assoc($result))
{
      $myarr['id'] = '[['.$data['letter_index'].']]';
      $myarr['name'] = $data['letter_index_nepali'];
      array_push($arr,$myarr);
}
$myarr['id'] = '[[form_company_name]]';
$myarr['name'] = 'फर्म/कम्पनी/निर्माण व्यवसायीको नाम';
array_push($arr,$myarr);

$myarr['id'] = '[[form_company_address]]';
$myarr['name'] = 'फर्म/कम्पनी/निर्माण व्यवसायीको ठेगाना';
array_push($arr,$myarr);


$data =  LetterIndices::find_by_sql($sql);
$res['data']= $arr;
echo json_encode($res);exit;
