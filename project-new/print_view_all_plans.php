<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$type=$_GET['type'];
$user = getUser();
//print_r($user);
    $topic_area_investment_id=$_GET['topic_area_investment_id'];
    $search_text=$_GET['search_text'];
    $search_ward =$_GET['ward'];
    print_r($search_ward);
    if(isset($type) || isset($topic_area_investment_id) || isset($search_text) || isset($search_ward))
    {
        $sql = "select * from plan_details1 ";
         if(($type!="") && empty($topic_area_investment_id))
        {
            $sql .=" where type='".$type."' ";
            
        }
        if(!empty($topic_area_investment_id) && $type=="")
        {
            $sql .=" where topic_area_investment_id='".$topic_area_investment_id."'";
            
        }
        if(!empty($topic_area_investment_id) && $type!="" && empty($search_ward))
        {
            $sql .=" where type='".$type."' and topic_area_investment_id='".$topic_area_investment_id."'";
            
        }
        if(!empty($topic_area_investment_id) && $type!="" && !empty($search_ward))
        {
            $sql .=" where type='".$type."' and topic_area_investment_id='".$topic_area_investment_id."' and ward_no=".$search_ward;
        }
        if(!empty($search_text))
        {
            $sql ="select * from plan_details1 where id =".$search_text;
            
        }
         if(!empty($search_ward) && empty($topic_area_investment_id) && $type=="" && $search_text=="")
        {
            $sql ="select * from plan_details1 where  ward_no='".$search_ward."'";
          
            
        }
        if(!empty($_GET['topic_area_id']) && !empty($_GET['topic_area_type_id']))
        {
             $sql ="select * from plan_details1 where  topic_area_id=".$_GET['topic_area_id']." and topic_area_type_id=".$_GET['topic_area_type_id']; 
    
        }
        if(!empty($user->mode==user))
        {
            $sql ="select * from plan_details1 where  ward_no=".$user->ward;

        }
           if(!empty($_GET['topic_area_id']) && !empty($_GET['topic_area_type_id']) && empty($search_ward))
        {
             $sql ="select * from plan_details1 where type=$type and  topic_area_id=".$_GET['topic_area_id']." and topic_area_type_id=".$_GET['topic_area_type_id']; 
    
        }
        if(!empty($_GET['topic_area_id']) && !empty($_GET['topic_area_type_id']) && !empty($search_ward))
        {
             $sql ="select * from plan_details1 where type=$type and ward_no=$search_ward and topic_area_id=".$_GET['topic_area_id']." and topic_area_type_id=".$_GET['topic_area_type_id']; 
    
        }
        if(!empty($_GET['topic_area_id']) && empty($_GET['topic_area_type_id']) && empty($search_ward))
        {
             $sql ="select * from plan_details1 where type=$type and  topic_area_id=".$_GET['topic_area_id']; 
    
        }
       if(!empty($_GET['topic_area_id']) && empty($_GET['topic_area_type_id']) && !empty($search_ward))
        {
             $sql ="select * from plan_details1 where type=$type and ward_no=$search_ward and  topic_area_id=".$_GET['topic_area_id']; 
    
        }
    }
    else
    {
     
         $sql = "select * from plan_details1 ";
   
    }
    // echo $sql;exit;
$datas = Plandetails1::find_by_sql($sql);
    ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>योजना विवरण हेर्नुहोस  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php
                       if(empty($user->mode==user)){
                           echo SITE_ADDRESS;
                       } else{
                           echo $user->ward_add;
                       }?>
                    </h5>
                      <div class="myspacer"></div>
                    <div class="subject"><b><u>योजना विवरण हेर्नुहोस</b></u> </div>	
                                <div class="myspacer"></div>
                                <table class="table table-bordered myWidth100">
                           <tr>
                                    <th>सि नं </th>     
                                    <th>दर्ता नं</th>
                                    <th>योजना / कार्यक्रमको नाम</th>
                                    <th>बिषयगत क्षेत्रको किसिम</th>
                                    <th>अनुदानको किसिम</th>
                                    <th>विनियोजन किसिम</th>
                                    <th>वार्ड नं</th>
                                    <th>अनुदान रकम (रु.)</th>
                                    <th>खर्च रकम</th>
                                    <th>बाँकि रकम</th>
                                 </tr>
                                <?php 
                                 $total_net_payable=0;
                                 $total_remaining=0;
                                 $i=1;
                                 foreach($datas as $data):
                                     
                                                            
                                                         if($data->type==0)
                                                         {  
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else{ 
                                                                             $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                                             if(empty($contract_result))
                                                                                  {
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
                                                                        $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                                                        $advance_total = Programpayment::get_total_payment_amount($data->id);
                                                                        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                                                        $net_payable_amount = $advance_total + $net_total_amount_total;
                                                                        if(empty($net_payable_amount))
                                                                        {
                                                                            $remaining_amount=$data->investment_amount;
                                                                        }
                                                                        else
                                                                        {
                                                                            $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                                                        }
                                                                    }
                                                                
                                                         }
                               $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                $contract_plan_total= Contractinfo::find_by_plan_id($data->id);
                              if($data->type==1)
                                {
                                    $link = "program_total_view.php?id=".$data->id;
                                }
                                elseif($data->type==0 && !empty($samiti_plan_total))
                                {
                                    $link="view_samiti_plan_form.php?id=".$data->id; 
                                }
                                 elseif($data->type==0 && !empty($contract_plan_total))
                                {
                                    $link="view_all_contract.php?id=".$data->id; 
                                }
                                else
                                {
                                 $link="view_plan_form.php?id=".$data->id;   
                                }
                                ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td style="width:10%"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
                                  </tr>
                         <?php $i++;
                         $total_net_payable +=$net_payable_amount;
                         $total_remaining +=$remaining_amount;
                         endforeach;?>
                                 <?php    
                         $total=0;
                        foreach($datas as $data): 
                         $total+=$data->investment_amount;  
                         
                        endforeach;?>
                                <tr>
                                    <td colspan="7" class="text-center">जम्मा रकम </td>     
                             
                             <td>रु.<?php echo convertedcit(placeholder($total));?></td>
                             <td>रु.<?php echo convertedcit(placeholder($total_net_payable));?></td>
                             <td>रु.<?php echo convertedcit(placeholder($total_remaining));?></td>
                             
                         </tr>
                     </table>
									
                    
										<div class="myspacer20"></div>
<div class="oursignature">&nbsp</div><div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->