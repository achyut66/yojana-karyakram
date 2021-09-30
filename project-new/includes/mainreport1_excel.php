<?php require_once("includes/initialize_excel.php");
$data_array= Planamountwithdrawdetails::find_all();
$final_array=array();
foreach($data_array as $data)
{
    array_push($final_array, $data->plan_id);
}?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$output ="";
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
    $plan_type=$_GET['plan_type'];
    $fiscal_id=$_GET['fiscal_id'];
    $type=$_GET['type'];
    $topic_area_id=$_GET['topic_area_id'];
    $topic_area_type_ids =  Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
   $output.='<body><div style="text-align:center;">
                                      <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                          <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>
                           <span  style="text-align:center;">योजनाको प्रगती विवरण</span><br>
                       
                                  </div>';
                                $plan_type_name=get_plan_type($plan_type);
                                 $result_array=get_function_by_plan_type($plan_type);
                              $output.='<h3>'.$plan_type_name.'</h3><br>
                                  <h3 style="text-align: left;"><strong>'.Topicarea::getName($topic_area_id).'</strong></h3>
                                   <table class="table-bordered table-responsive mytable">';
                   $output.='<tr>
                          <th >&nbsp;</th>
                          <th >&nbsp;</th>
                          <th >&nbsp;</th>
                          <th >&nbsp;</th>
                          <th >&nbsp;</th>
                          <th>योजना संचालन प्रकिया</th>
                          <th colspan="5">योजना</th>
                          <th colspan="2">भुक्तानीको अबस्था</th>
                          <th colspan="2">लाभान्भित जनसंख्या </th>
                        </tr>
                        <tr>
                          <th>सिनं</th>
                          <th>योजनाको नाम</th>
                          <th>वडा नं</th>
                          <th>अनुदानको किसिम</th>
                          <th>योजनाको कुल अनुदान </th>
                          <th>संचालन प्रकिया</th>
                          <th>संझौता मिति</th>
                          <th>संम्पन्न हुने मिति</th>
                          <th>संम्पन्न मिति</th>
                          <th>योजनाको भौतिक लक्ष्य</th>
                          <th>योजनाको भौतिक प्रगति</th>
                          <th>हाल सम्मको भुक्तानी</th>
                          <th>भुक्तानी दिन बाँकी रकम</th>
                          <th>पुरुष</th>
                          <th>महिला</th>
                        </tr>';
                     if($type==0): foreach($topic_area_type_ids as $topic_area_selected){ 
                                 $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($_GET['topic_area_id'],$topic_area_selected,0);
 $output.=' <tr>
                              <td colspan="15"><div style="text-align:center;">
                            
                            <strong> <span>'.Topicareatype::getName($topic_area_selected).'</span></strong><br>
                            </td>
                        </tr>';
                        
                           foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                       $sql = "select * from plan_details1 where type=0 and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;    
                                                $result =  Plandetails1::find_by_sql($sql);
            
                          $output.='<tr> <td colspan="15"> <b>'.Topicareatypesub::getName($topic_area_type_sub_id).'</b></td></tr>'; 
                        $total_male=0;
                        $total_female=0;
                        $total=0;
                        $total1=0;
                        $total2=0;
                         $j = 1;
                        foreach($result as $data){
                            if(in_array($data->id,$result_array))
                            {
                                  $data1=  Plantotalinvestment::find_by_plan_id($data->id);
                                    $data2= Moreplandetails::find_by_plan_id($data->id);
                                    $data3= Profitablefamilydetails::find_by_plan_id($data->id);
                                    $data4=Planamountwithdrawdetails::find_by_plan_id($data->id);
                                    $data6=Plantotalinvestment::find_by_plan_id($data->id);
                                       if(empty($data2))
                                            {
                                                $name="";
                                            }
                                            else
                                            {
                                                $name="उपभोक्ता समति";
                                            }
                                    if(empty($data1->unit_id)&& empty($data1->unit_total))
                                            {
                                                $unit=0;
                                            }
                                            else
                                            {
                                                $unit=convertedcit($data1->unit_total)." ".Units::getName($data1->unit_id);
                                            }
                                    if(in_array($data->id, $final_array))
                                    {
                                        $net_payable_amount=$data->investment_amount;
                                         $remaining_amount=0; 
                                    }
                                    else
                                    {
                                         $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                    }

                              
                               $output.='<tr>
                                  <td>'.convertedcit($j).'</td>
                                  <td>'.$data->program_name.'</td>
                                  <td>'.convertedcit($data->ward_no).'</td>
                                  <td>'.Topicareaagreement::getName($data->topic_area_agreement_id).'</td>
                                  <td>'.convertedcit($data->investment_amount).'</td>
                                  <td>'.$name.'</td>
                                 <td>'.convertedcit($data2->miti).'</td>
                                  <td>'.convertedcit($data2->yojana_sakine_date).'</td>
                                  <td>'.convertedcit($data4->plan_end_date).'</td>
                                  <td>'.$unit.'</td>
                                  <td>'.$unit.'</td>
                                  <td>'.convertedcit($net_payable_amount).'</td>
                                  <td>'.convertedcit($remaining_amount).'</td>
                                  <td>'.convertedcit($data3->male).'</td>
                                  <td>'.convertedcit($data3->female).'</td>
                                </tr>';
                                 $j++ ;
                                $total += $data->investment_amount;
                                $total1 +=$net_payable_amount;
                                $total2 +=$remaining_amount;
                                $total_male +=$data3->male;
                                $total_female +=$data3->female;
                        }
                        }
                   
                    $output.='<tr>
                          <td>&nbsp;</td>
                          <td>जम्मा</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total).'</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total1).'</td>
                          <td>'.convertedcit($total2).'</td>
                          <td>'.convertedcit($total_male).'</td>
                          <td>'.convertedcit($total_female).'</td>
                        </tr>';
                   endforeach;}  
                     $output.='</table></body>';
                endif;
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=mainreport1.xls");
echo $output; ?>