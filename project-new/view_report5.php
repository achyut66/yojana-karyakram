<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
error_reporting(1);
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$analysis_based_plan_array=$counted_result['analysis_count_array'];
if(!empty($analysis_based_plan_array))
{
    $total_investment10 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $analysis_based_plan_array));
    $result=  Plandetails1::find_by_plan_id(implode(",", $analysis_based_plan_array));
}
else
{
    $total_investment10=0;
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

        <div class="maincontent">
            <h2 class="headinguserprofile">मुल्यांकनको आधारमा भुक्तानी लागेको योजनाको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस</a> | <a href="view_report5_excel.php?ward_no=<?=$_GET['ward_no']?>" class="btn">Excel Export</a> | <a target="_blank" href="view_report5_print.php?ward_no=<?=$_GET['ward_no']?>" class="btn">Print</a></h2>
           	
            <div class="myMessage">   <?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                     <table class="table table-bordered table-hover">
                           <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं</strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"> <strong>कुल बाँकी रकम</strong></td>
                                    <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                                </tr>
                                <?php $i=1; 
                                $total_net_payable_amount="";
                                $total_remaining_amount="";
                                foreach($result as $data):
                                    $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                   $contract_plan_total=  Contract_total_investment::find_by_plan_id($data->id);
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                    $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                    if(empty($contract_result))
                                    {
                                        $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount;
                                    }
                                    else
                                    {
                                        $net_payable_amount= Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount;
                                    }
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
                                 elseif($data->type==0 && !empty($amanat_lagat))
                                {
                                    $link= "view_all_amanat.php?id=".$data->id;
                                }
                                else
                                {
                                 $link="view_plan_form.php?id=".$data->id;   
                                }
                                    ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($net_payable_amount);?></td>
                                      <td class="myCenter"><?php echo convertedcit($remaining_amount);?></td>
                                    <td class="myCenter"><a href="<?=$link?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php $i++;
                           $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td><?php echo convertedcit(placeholder($total_investment10)); ?></td>
                               <td><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td colspan="2"><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>