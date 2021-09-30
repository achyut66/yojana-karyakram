<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}

$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
$ward= $_GET['ward'];
$total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
$final_array= array();
$total_amount_array=array();
$total_investment_amount_array=array();
$total_remaining_amount_array=array();

    $fiscal_id=$_GET['fiscal_id'];
    $topic_area_id=$_GET['topic_area_id'];
    $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,1,$ward);


?>
<?php
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
                 $output.='<div style="text-align:center;">
                                                        <span style="text-align:center;">'.SITE_LOCATION.'</span><br>
                                                 <span  style="text-align:center;">'.SITE_ADDRESS.'</span><br>
                                            
                                               
                 </div><br><br>';  
             $output.='<table border:2px;> 
            <strong> <span  style="text-align:left;">';if(!empty($_GET['ward_no'])){ $output.= "वार्ड नं ".convertedcit($_GET['ward_no'])." को ". Topicarea::getName($_GET['topic_area_id']);}else{ $output.=  Topicarea::getName($_GET['topic_area_id']) ;} $output.='का कार्यक्रमहरु हेर्नुहोस </span></strong><br>
                  <tr>
                                                <th>सिनं</th>
                                                <th>कार्यक्रमको नाम</th>
                                                <th>वडा नं</th>
                                                <th>अनुदानको किसिम</th>
                                                <th>कार्यक्रमको विनियोजित बजेट</th>
                                                <th>कार्यक्रमको खर्च भएको रकम</th>
                                                <th>कार्यक्रमको बाकी  रकम</th>
                                                                    
                                              </tr>';
    
           foreach($topic_area_type_ids as $topic_area_selected)
                         { 
                                  
                          
                            
                          
                          
                           $output.='<tr>            
                               <td colspan="7"><div style="text-align:center;">
                                               <strong> <span  style="text-align:center;">'.Topicareatype::getName($topic_area_selected).'</span></strong><br>
                                   </div></td>
                           </tr>';
                           $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,1,$ward);  
                                         foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                      
                    
                                                         if(empty($_GET['ward_no']))
                                                    {
                                                    
                                                        $sql = "select * from plan_details1 where type=1 and topic_area_id=".$topic_area_id." 
                                                            and topic_area_type_id=".$topic_area_selected
                                                 .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                                 .          " and fiscal_id=".$fiscal_id;    
                                                    }
                                                    else
                                                    {
                                                           $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=1 and topic_area_id=".$topic_area_id." 
                                                            and topic_area_type_id=".$topic_area_selected
                                                 .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                                 .          " and fiscal_id=".$fiscal_id;    
                                                    }  
                                                        $result =  Plandetails1::find_by_sql($sql);
                                                  
                                                         
                                                       
                                                        
                                                        $total_amount=0;
                                                        $total_remaining_amount=0;
                                                        $total_investment_amount=0;
      if(!empty($result)):                                 
                       
                                            $output.='<tr> <td colspan="7"> <b>'.Topicareatypesub::getName($topic_area_type_sub_id).'</b></td></tr>';
                                       $j=1; 
                                            foreach($result as $data)
                                            { 
                                            
                                                     $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                                        $amount= Programmoredetails::getSum($data->id);
                                                            if(empty($amount))
                                                            {
                                                                $remaining_amount=$data->investment_amount;
                                                            }
                                                            else
                                                            {
                                                                $remaining_amount=($data->investment_amount)-($amount);
                                                              $total_investment_amount+=$amount;
                                                            }
                                      $total_amount+=$data->investment_amount;
                                      $total_remaining_amount+=$remaining_amount;
                                      
                                     
                                     $output.=' <tr>
                                                          
                                                        <td>'.convertedcit($j).'</td>
                                                        <td>'.$data->program_name.'</td>
                                                        <td>'.convertedcit($data->ward_no).'</td>
                                                        <td>'.Topicareaagreement::getName($data->topic_area_agreement_id).'</td>
                                                        <td>'.convertedcit(placeholder($data->investment_amount)).'</td>
                                                        <td>'.convertedcit(placeholder($amount)).'</td>
                                                        <td>'.convertedcit(placeholder($remaining_amount)).'</td>
                                                     
                                                      </tr>';
                                                       
                                                      $j++ ; 
                                            }
                                  endif;
                                  
                                              
                                             
                                            $output.='<tr>
                                                         <td colspan="4">जम्मा</td>
                                                         <td>'.convertedcit(placeholder($total_amount)).'</td>
                                                         <td>'.convertedcit(placeholder($total_investment_amount)).'</td>
                                                         <td>'.convertedcit(placeholder($total_remaining_amount)).'</td>
                                                      </tr>';                 
                                          array_push($total_amount_array,$total_amount);
                                              array_push($total_investment_amount_array,$total_investment_amount);
                                              array_push($total_remaining_amount_array,$total_remaining_amount);
                              
                     
                      endforeach;
                             $add1=array_sum($total_amount_array);
                             $add2=array_sum($total_investment_amount_array);
                             $add3=array_sum($total_remaining_amount_array);
                }
                
                            $output.='<tr>
                                 <td colspan="4"><strong>कुल जम्मा</strong></td>
                                 <td>'.convertedcit(placeholder($add1)).'</td>
                                 <td>'.convertedcit(placeholder($add2)).'</td>
                                 <td>'.convertedcit(placeholder($add3)).'</td>
                               </tr> 
                                                      </table></body></html>';
        
      
 header("Content-Type: application/xls");
header("Content-Disposition: application; filename=mainreport2.xls");
echo $output;
	?>	                 
         