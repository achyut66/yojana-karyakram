<?php require_once("includes/initialize.php");
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$topic_area=  Topicarea::find_all();?>
<?php
$output='';
 $fiscal_id= Fiscalyear::find_current_id();
 $format=$_GET['format'];
    $type=$_GET['type'];
    $ward_no= $_GET['ward_no'];
    $topic_area_id=$_GET['topic_area_id'];
    $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic_area_id);
    if(!empty($topic_area_type_id)){
    $sql="select * from plan_details1 where type=".$type." and topic_area_type_id=".$topic_area_type_id;
    $result=  Plandetails1::find_by_sql($sql);
    }
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
    $format=$_GET['format'];
             if($format==1)
             {
             ?>
<?php if($type==0 && empty($result)):
                                 $output.=' <table>
                                       <tr>
                                                        <td colspan="7" style="text-align: center;"><b>योजना अन्तर्गत ';
                                                        if(!empty($_GET['ward_no'])){ $output .= "वडा नं ". convertedcit($ward_no). " को  ".Topicarea::getName($_GET['topic_area_id']);}
                                                        else{ $output .=  Topicarea::getName($_GET['topic_area_id']);} 
                                                        $output.='को रिपोर्ट हेर्नुहोस </b></td>
                                                    </tr>
                                           <tr>    
                                               <th>सि.न </th>
                                               <th>योजनाको बिषयगत क्षेत्रको किसिम</th>
                                               <th>योजनाको शिर्षकगत किसिम:</th>
                                               <th>कुल संख्या:</th>
                                               <th>कुल अनुदान रु :</th>
                                                <th>खर्च भएको रकम </th>
                                               <th>बाकी रकम </th>
                                           </tr>';


                                $i=1;
                                              $total_count=0;
                                              $total_investment=0;
                                              $total_payable=0;
                                              $remaining_payable=0;
//                                              echo count($topic_area_type_ids); exit;
                                              foreach($topic_area_type_ids as $topic_selected):
                                                  
                                                $total_net_payable_amount = get_remaining_amount_mainreport($topic_area_id,$topic_selected->id,$type,$_GET['ward_no']);
                                                $total_net_investment = Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);

                                                 $remaining_net_investment=$total_net_investment - $total_net_payable_amount;
                                                 
                                                         if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])==0)
                                                         {
                                                             continue;
                                                         }   
                                $output.='<tr>
                                                <td>'.convertedcit($i).'</td>
                                               <td>'.Topicarea::getName($topic_area_id).'</td>
                                               <td>'.$topic_selected->topic_area_type.'</td>
                                               <td>'.convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$ward_no)).'</td>
                                               <td>'.convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$ward_no))).'</td>
                                               <td>'.convertedcit(placeholder($total_net_payable_amount)).'</td>
                                                 <td>'.convertedcit(placeholder($remaining_net_investment)).'</td>
                                           </tr>';
                                    $i++; 
                                    $total_payable +=$total_net_payable_amount;
                                    $remaining_payable +=$remaining_net_investment;
                                    $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$ward_no);  
                                    $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$ward_no);
                                    endforeach;
                              $output.='<tr>
                                                   <td colspan="2">&nbsp; </td>     
                                            <td>जम्मा </td>
                                            <td >'.convertedcit(placeholder($total_count)).'</td>
                                            <td >'.convertedcit(placeholder($total_investment)).'</td>
                                            <td >'.convertedcit(placeholder($total_payable)).'</td>
                                            <td >'.convertedcit(placeholder($remaining_payable)).'</td>

                                            </tr> 
                            </table>';
                                  endif;?>
<?php if($type==1):
                            $output.=  '<table>
                                <tr>
                                                        <td colspan="7" style="text-align: center;"><b>कार्यक्रम अन्तर्गत'; if(!empty($_GET['ward_no'])){ $output.= "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ $output.=  Topicarea::getName($_GET['topic_area_id']);}$output.='को रिपोर्ट हेर्नुहोस </b></td>
                                                    </tr>
                                           <tr>    
                                               <th>सि.न </th>
                                               <th>कार्यक्रमको बिषयगत क्षेत्रको किसिम</th>
                                               <th>कार्यक्रमको शिर्षकगत किसिम:</th>
                                               <th>कुल संख्या  :</th>
                                               <th>कुल अनुदान रु :</th>
                                               <th>खर्च भएको रकम </th>
                                               <th>बाकी रकम </th>
                                           </tr>';

                               $i=1;
                                              $total_investment=0;
                                              $total_count=0;
                                             $total_net_amount=0;
                                             $remaining_amount=0;
                                              foreach($topic_area_type_ids as $topic_selected) :
                                                   $data_array=get_remaining_amount_mainreport1($topic_area_id,$topic_selected->id,$type,$_GET['ward_no']);
                                              if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])==0)
                                              {
                                                  continue;
                                              }

                                           $output.='<tr>
                                                <td>'.convertedcit($i).'</td>
                                               <td>'.Topicarea::getName($topic_area_id).'</td>
                                               <td>'.$topic_selected->topic_area_type.'</td>
                                               <td>'.convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$ward_no)).'</td>
                                               <td>'.convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$ward_no))).'</td>
                                                <td>'.convertedcit(placeholder($data_array['total_expenditure_till_now'])).'</td>
                                                 <td>'.convertedcit(placeholder($data_array['total_remaining_program_budget'])).'</td>
                                           </tr>';
                                 $i++;
                                    $total_net_amount +=$data_array['total_expenditure_till_now'];
                                    $remaining_amount +=$data_array['total_remaining_program_budget'];
                                    $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$ward_no);
                                     $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$ward_no);
                                    endforeach;
                          $output.='<tr>
                                                   <td colspan="2">&nbsp; </td>     
                                            <td>जम्मा </td>
                                            <td>'.convertedcit(placeholder($total_count)).'</td>
                                            <td>'.convertedcit(placeholder($total_investment)).'</td>
                                            <td>'.convertedcit(placeholder($total_net_amount)).'</td>
                                            <td>'.convertedcit(placeholder($remaining_amount)).'</td>
                                            </tr>
                            </table>';
                                  endif;
                                 
 } 
        else 
           {  
                if($_GET['type']==1)
                        {
                            $name="कार्यक्रम अन्तर्गत ";
                        }
                        else
                        {
                            $name="योजना अन्तर्गत ";
                        }
                    $fiscal_id= Fiscalyear::find_current_id();
                    $topic_area_id=$_GET['topic_area_id'];
                    $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$ward_no);
                   // $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
           
           $output.='<div style="text-align:center;">
                  <span style="text-align:center;">'.SITE_LOCATION.'</span><br>
                  <span  style="text-align:center;">'.SITE_ADDRESS.'</span><br>
                  </div><br><br>  
                   <table class="table table-bordered table-responsive mytable"> 
                      <tr>
                           <td colspan="8" style="text-align: center;"> <b>'; echo $name; if(!empty($_GET['ward_no'])){ $output.=  "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ $output.=  Topicarea::getName($_GET['topic_area_id']);}$output.='को रिपोर्ट हेर्नुहोस </td>
                       </tr>  <tr>
                                    <th>सिनं</th>
                                    <th>योजनाको नाम</th>
                                    <th>वडा नं</th>
                                    <th>अनुदानको किसिम</th>
                                    <th>योजनाको अनुदान रु</th>
                                    <th>योजनाको हाल सम्म लागेको भुक्तानी</th>
                                    <th>योजनाको कुल बाँकी रकम</th>

                              </tr>';

                       
                        $total_investment_array=array();
                         $total_net_payable_array=array();
                         $total_remaining_amount_array=array();
                       foreach($topic_area_type_ids as $topic_area_selected)
                                     { 
                          $output.='<tr>            
                                    <td colspan="7"><div style="text-align:center;">
                                    <strong> <span  style="text-align:center;">'.Topicareatype::getName($topic_area_selected).'</span></strong><br>
                                    </div>
                                    </td>
                              </tr>';
                                        $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$ward_no);  
                         
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                      if(empty($_GET['ward_no']))
                                   {
                                       $sql = "select * from plan_details1 where type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                   else
                                   {
                                       $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }   
                                                $result =  Plandetails1::find_by_sql($sql);
 
                                                $total_amount=0;
                                                $total_remaining_amount=0;
                                                $total_investment_amount=0;
                                                ?>

                                <?php if(!empty($result)):  
                                             $final_array=$counted_result['final_count_array'];

                                     $output.='<tr> <td colspan="7"> <b>'.Topicareatypesub::getName($topic_area_type_sub_id).'</b></td></tr>'; 
                                                      
                                                        $j=1;  
                                                        $total_investment=0;
                                                        $total_net_payable_amount=0;
                                                         $total_remaining_amount=0;
                                                         $net_total_investment=0;
                                                         $net_total_payable_amount=0;
                                                         $net_total_remaining_amount=0;
                                                         foreach($result as $data)
                                                        { 
                                                            $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                            
                                                         if($data->type==0)
                                                         {  
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else{ 
                                                                             if(empty($contract_result))
                                                                                  {
                                                                                          $data->investment_amount = get_investment_amount($data->id);
                                                                                          if(in_array($data->id, $final_array))
                                                                                              {
                                                                                                   $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                                                   $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                              }
                                                                                              else
                                                                                              {

                                                                                                   $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                      //                                             echo $net_payable_amount;exit;
                                                                                                  $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                                              } 
                                                                                  }
                                                                                  else
                                                                                  {
                                                                                     if(in_array($data->id, $final_array))
                                                                                          {
                                                                                              $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                                               $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                          }
                                                                                          else
                                                                                          {

                                                                                               $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                                               $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                          }  

                                                                                  }
                                                                           }
                                                         }
                                                         else
                                                         {
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else
                                                                    {
                                                                        $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                                                        $net_payable_amount= Programmoredetails::getSum($data->id);
                                                                        if(empty($amount))
                                                                        {
                                                                            $remaining_amount=$data->investment_amount;
                                                                        }
                                                                        else
                                                                        {
                                                                            $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                                                        }
                                                                    }
                                                                
                                                         }
                                                                     $total_investment+=$data->investment_amount;
                                                                        $total_net_payable_amount +=$net_payable_amount;
                                                                        $total_remaining_amount +=$remaining_amount;
                                                            

                                                                  $output.='<tr>

                                                                              <td>'.convertedcit($j).'</td>
                                                                              <td>'.$data->program_name.'</td>
                                                                              <td>'.convertedcit($data->ward_no).'</td>
                                                                              <td>'.Topicareaagreement::getName($data->topic_area_agreement_id).'</td>
                                                                              <td>'.convertedcit(placeholder($data->investment_amount)).'</td>
                                                                              <td>'.convertedcit(placeholder($net_payable_amount)).'</td>
                                                                              <td>'.convertedcit(placeholder($remaining_amount)).'</td>

                                                                            </tr>';

                                                                            
                                                                        $j++ ; 
                                                                        
                                                        }
                                                                          
                                      endif;
                                                                      
                                                        

                                                         $output.='<tr>
                                                                     <td colspan="4">जम्मा</td>
                                                                     <td>'.convertedcit(placeholder($total_investment)).'</td>
                                                                     <td>'.convertedcit(placeholder($total_net_payable_amount )).'</td>
                                                                     <td>'.convertedcit(placeholder($total_remaining_amount)).'</td>
                                                                  </tr>';                 
                               
                                              array_push($total_investment_array,$total_investment);
                                              array_push($total_net_payable_array,$total_net_payable_amount);
                                              array_push($total_remaining_amount_array,$total_remaining_amount);
                              
                              endforeach;
                             
                              }
                              $add1=array_sum($total_investment_array);
                             $add2=array_sum($total_net_payable_array);
                             $add3=array_sum($total_remaining_amount_array);
                    
                                                              
                    $output.='<tr>
                                 <td colspan="4"><strong>कुल जम्मा</stong></td>
                                 <td>'.convertedcit(placeholder($add1)).'</td>
                                 <td>'.convertedcit(placeholder($add2)).'</td>
                                 <td>'.convertedcit(placeholder($add3)).'</td>
                              </tr> 
                  </table>';

$output.='</body></html>';
                        
        } ?>
<?php
 header("Content-Type: application/xls");
header("Content-Disposition: application; filename=mainreport.xls");
echo $output;
	?>	