<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res=array();
$output="";
  $type_id=$_POST['type_id'];
  $sql="select * from enlist where type='".$type_id."'";
  $enlist=Enlist::find_by_sql($sql);
  $output.="<td>&nbsp;</td>";
   $output.="<td>
           <select required name='enlist_id'>
           <option value=''>--छान्नुहोस् --</option>";
   if(!empty($enlist))
            {
                   foreach($enlist as $data):
                     if($data->type==0)
                     {
                         $output.="<option value=".$data->id.">".$data->name0."</option>";
                     }
                     elseif($data->type==1)
                     {
                         $output.="<option value=".$data->id.">".$data->name1."</option>";
                     }
                     elseif($data->type==2)
                     {
                         $output.="<option value=".$data->id.">".$data->name2."</option>";
                     }
                     elseif($data->type==3)
                     {
                         $output.="<option value=".$data->id.">".$data->name3."</option>";
                     }
                     elseif($data->type==4)
                     {
                         $output.="<option value=".$data->id.">".$data->name4."</option>";
                     }
                     endforeach;
           }
    else   
           {
                   $result = Upabhoktasamitiprofile::find_all();
                 foreach($result as $data1):
                      $output.= "<option value=".$data1->id.">".$data1->program_organizer_group_name.', वडा न : '.convertedcit($data1->program_organizer_group_address)."</option>";
                 endforeach;   
        
           }        
   
     $output.="</select></td>";

                                        
$res['html']=$output; 
echo json_encode($res);exit;
?>
