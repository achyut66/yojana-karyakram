<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
error_reporting(1);
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);

if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$final_plan_array = $counted_result['final_count_array'];

if(!empty($final_plan_array))
{
    $total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",",$final_plan_array));
   $result =  Plandetails1::find_by_plan_id(implode(",",$final_plan_array));
}
else
{
    $total_investment=0;
    $result='';
}


?>
<?php include("menuincludes/header.php"); ?>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">सकिएको योजनाको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस </a> | <a href="view_report_excel.php?ward_no=<?=$_GET['ward_no']?>" class="btn">Excel Export</a> | <a target="_blank" href="view_report_print.php?ward_no=<?=$_GET['ward_no']?>" class="btn">Print</a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    
                     <table class="table table-bordered table-hover">
                         <tr>       <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong>कुल बाँकी रकम</strong></td>
                                    <td class="myCenter"><strong>भुक्तानी भएको मिति </strong></td>
                                     <th class="myCenter"><strong>संचालन प्रकिया </strong></th>
                                    <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                                </tr>
                                <?php $i=1;
                                $total_net_payable=0;
                                $total_remaining=0;
                                foreach($result as $data):
                                  $samiti_plan_total=  Samitiplantotalinvestment::find_by_plan_id($data->id);
                                  $contract_plan_total=  Contractinfo::find_by_plan_id($data->id);
                                  $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                  $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                   $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                  if(!empty($contract_plan_total))
                                  {
                                      $final_date=  Contractamountwithdrawdetails::find_by_plan_id($data->id);
                                      $date=$final_date->created_date;
                                  }
                                  else
                                  {
                                      $final_date= Planamountwithdrawdetails::find_by_plan_id($data->id);
                                      $date=$final_date->created_date;
                                  }
                                  
                                  if(!empty($budget))
                                   {
                                       $net_payable_amount =$budget->total_expenditure;
                                       $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                   }
                                   else
                                       {
                                            if(empty($contract_result))
                                                 {
                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                    $remaining_amount=$data->investment_amount - $net_payable_amount;
                                                  }
                                                  else
                                                  {
                                                      $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                      $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                  }
                                       }
                                  
                                  if($data->type==1)
                                {
                                    $link = "program_total_view.php?id=".$data->id;
                                    $sanchalan_prakiya = "कार्यक्रम मार्फत ";
                                }
                                elseif($data->type==0 && !empty($samiti_plan_total))
                                {
                                    $link="view_samiti_plan_form.php?id=".$data->id; 
                                    $sanchalan_prakiya = "संस्था / समिति मार्फत ";
                                }
                                 elseif($data->type==0 && !empty($contract_plan_total))
                                {
                                    $link="view_all_contract.php?id=".$data->id; 
                                    $sanchalan_prakiya = "ठेक्का मार्फत ";
                                }
                                elseif($data->type==0 && !empty($amanat_lagat))
                                {
                                    $link= "view_all_amanat.php?id=".$data->id;
                                    $sanchalan_prakiya = "अमानत मार्फत ";
                                }
                                else
                                {
                                 $link="view_plan_form.php?id=".$data->id;   
                                 $sanchalan_prakiya = "उपभोक्ता मार्फत ";
                                }
                                    ?>
                                <tr>
                                     <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($net_payable_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($remaining_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($date);?></td>
                                    <td class="myCenter"><b><?php echo $sanchalan_prakiya;?></b></td>
                                    <td class="myCenter"><a href="<?=$link?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php $i++; 
                         $total_net_payable+=$net_payable_amount;
                                $total_remaining+=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="5">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_net_payable)); ?></td>
                             <td colspan="4"><?php echo convertedcit(placeholder($total_remaining)); ?></td>
                                </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>