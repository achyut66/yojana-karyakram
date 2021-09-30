<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php include("menuincludes/header.php"); ?>
 <?php
 $type=$_GET['type'];
 $topic_area_id=$_GET['topic_area_id'];
 $topic_area_type_id=$_GET['topic_area_type_id'];
 $fiscal_id= Fiscalyear::find_current_id();
 $ward_no= $_GET['ward'];
 if(empty($ward_no))
 {
     $sql="select * from plan_details1 where type=".$_GET['type']." and topic_area_id={$topic_area_id} and topic_area_type_id=".$_GET['topic_area_type_id'];
 
 }
 else
 {
    $sql="select * from plan_details1 where ward_no=".$ward_no." and type=".$_GET['type']." and topic_area_id={$topic_area_id} and topic_area_type_id=".$_GET['topic_area_type_id'];
     
 }
 $result=  Plandetails1::find_by_sql($sql);
 
 ?>
<?php
if(empty($ward_no))
{
    $data1= Planamountwithdrawdetails::find_all();

}
 else 
 {
     $data1= get_wardwise_result_sql($ward_no,"plan_amount_withdraw_details");

 }
$final_array=array();
foreach($data1 as $data)
{
    array_push($final_array, $data->plan_id);
}
?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"><?php if(!empty($ward_no)){ echo "वडा नं ". convertedcit($ward_no). " को  ".Topicareatype::getName($_GET['topic_area_type_id']);}else{ echo Topicareatype::getName($_GET['topic_area_type_id']);};?>को रिपोर्ट हेर्नुहोस | <a href="mainreport.php" class="btn">पछि जानुहोस </a> </h2>
           
            <div class="myMessage">    <?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    
                   <div class="myPrint"><a target="_blank" href="mainreport_print1.php?topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?= $type ?>&topic_area_type_id=<?= $topic_area_type_id ?>&ward=<?=$ward_no?>">प्रिन्ट गर्नुहोस</a></div><br>
                    
                    <table class="table table-bordered table-hover">
                           <tr class="title_wrap">   
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
                                $total_investment0=0;
                                $total_net_payable_amount=0;
                                $total_remaining_amount=0;
                                foreach($result as $data):
                                     $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                   if(empty($contract_result))
                                    {
                                            if(in_array($data->id, $final_array))
                                                {
                                                     $net_payable_amount=$data->investment_amount;
                                                     $remaining_amount=0; 
                                                }
                                                else
                                                {

                                                     $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
        //                                             echo $net_payable_amount;exit;
                                                    $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                } 
                                    }
                                    else
                                    {
                                       if(in_array($data->id, $final_array))
                                                {
        //                                            echo $data->id;
                                                    $net_payable_amount=$data->investment_amount;
                                                     $remaining_amount=0; 
                                                }
                                                else
                                                {

                                                     $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
        //                                             echo $net_payable_amount;exit;
                                                    $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                }  
                                    }
                                  $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                $contract_plan_total=  Contract_total_investment::find_by_plan_id($data->id);
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
                                    <td class="myCenter"><a href="<?php echo $link; ?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php $i++; 
                         $total_investment0 +=$data->investment_amount;
                          $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment0)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
         
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>