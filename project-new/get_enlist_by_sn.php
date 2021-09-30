<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res=array();
$output="";
 $sn=$_POST['sn'];
 $program_id=$_POST['program_id'];
  $sql="select * from program_more_details where sn={$sn} and program_id={$program_id}";
  $enlist_result= Programmoredetails::find_by_sql($sql);
  foreach ($enlist_result as $enlist ):
      $enlist_id=$enlist->enlist_id;
   $type = $enlist->type_id;
  endforeach;
  
  $output.="<td>कार्यक्रमको संचालन गर्ने</td>";
   $output.="<td>";
     if($type == 5)
     {
         $u_samiti = Upabhoktasamitiprofile::find_by_id($enlist_id);
         $output .= $u_samiti->program_organizer_group_name;
     }
     else
     {
           $output.=Enlist::getName1($enlist_id);   
     }     
     $output.="</td>";
$output.="<input type='hidden' name='enlist_id' value='".$enlist_id."'>";
$res['html']=$output; 
echo json_encode($res);exit;
?>
