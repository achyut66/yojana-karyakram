<?php require_once("includes/initialize.php"); 
 error_reporting(1);
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
        $mode= getUserMode();
	$plan_selected      = Plandetails1::find_by_id($_SESSION['set_plan_id']);
        $check_customer     = Costumerassociationdetails0::find_by_plan_id($_SESSION['set_plan_id']);
        // getting the bill name
        (!empty($check_customer))? $bill_text = 'रनिङ्ग  बिल' : $bill_text='ठेक्का को बिल';
        $profile        = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']);
        $napi_details   = NapiLagatAnuman::find_by_plan_id_period($_GET['id'],$_GET['period']);
//        print_r($napi_details); exit;
//        $estimate       = Estimatelagatanuman::find_by_plan
        if($_GET['period']>1)
        {
            $profile_old        = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']-1);
            
        }
if($profile->antim==1)
{
    $period_text = "अन्तिम";
}
else
{
    $period_text = getPeriodArray()[$_GET['period']];
}

$eng_date = Engdate::get_bill_date($_GET['id'],$_GET['period']);
$estimate_profile = EstimateLagatProfile::find_by_plan_id($_GET['id']);

$estimate_type   = $estimate_profile->type;
//print_r($estimate_profile);
$invest_details = Plantotalinvestment::find_by_plan_id($_GET['id']);
//print_r()
//$bhuktani_till_date = BillPayment::find_total_bhuktani_amount($_GET['id']);
$prev_bhuktani = BillPayment::find_prev_bhuktani_amount($_GET['id'],$_GET['period']);
$payment_details = BillPayment::find_by_plan_id_period($_GET['id'],$_GET['period']);
//print_r($payment_details); 
//print_r($invest_details); exit;
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$plan_selected->program_name?> </title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="bill_dashboard.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <h4 class="subjectbold1 myCenter letter_subject"><?=$period_text?> रनिङ विल</h4>
                      <div class="myPrint">
                          <form action="print_estimate_bill_final.php" target="_blank">
                              <input type="text" name="bill_date" id="nepaliDate16" value="<?=$eng_date->date_nepali?>" placeholder="मिति" />
                              <input type="hidden" name="id" value="<?=$_GET['id']?>" />
                              <input type="hidden" name="period" value="<?=$_GET['period']?>" />
                              <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" class="btn" />
                          
                              
                          
                      </div> 
                      <div class="myspacer"></div> 
                      <table class="table-bordered myWidth100 ">
                          <tr>
                              <td class="myCenter">सि.नं.</td>
                              <td class="myCenter myWidth30">कामको विवरण</td>
                              <td class="myCenter">इकाई</td>
                              <td  class="myCenter" colspan="3" >इष्टिमेट बमोजीमको </td>
                              <td  class="myCenter" colspan="2" >अघिल्लो बिलमा चढेको</td>
                              <td  class="myCenter" colspan="2" >खुद भएको काम</td>
                              <td  class="myCenter" colspan="2" >हाल भएको काम</td>
                              <td class="myCenter" >कैफियत</td>
                          </tr>
                          <tr>
                              <td></td>
                              <td></td>
                              <td ></td>
                              <!--<td>संख्या</td>-->
                              <td class="myCenter" >परिणाम</td>
                              <td class="myCenter" >दर </td>
                              <td class="myCenter" >जम्मा मूल्य</td>
                              <!--<td>संख्या</td>-->
                              <td class="myCenter" >परिणाम</td>
                              <td class="myCenter" >जम्मा  मूल्य</td>
                              <!--<td>संख्या</td>-->
                              <td  class="myCenter" >परिणाम</td>
                              <td class="myCenter" >जम्मा मूल्य</td>
                              <td class="myCenter" >परिणाम</td>
                              <td class="myCenter" >जम्मा मूल्य</td>
                              <td></td>
                          </tr>
                          <?php $count= 1; $total_rate = 0; $khud_total = 0; foreach($napi_details as $napi_detail):
                                $lagat = Estimatelagatanuman::find_by_plan_id_sno($_GET['id'],$napi_detail->sno);
                                $total_evaluation = NapiLagatAnuman::find_total_evaluation_previous_bill($_GET['id'],$napi_detail->sno,$_GET['period']);
//                                echo $total_evaluation; exit;
                                $total_rate_till = NapiLagatAnuman::find_total_rate_by_plan_id_sno($_GET['id'],$napi_detail->sno,$_GET['period']);
                                
                                $khud_evaluation = NapiLagatAnuman::find_total_evaluation_previous_bill($_GET['id'],$napi_detail->sno,$_GET['period']+1);
//                                echo $khud_evaluation; exit;
                                $khud_evaluation = $khud_evaluation - $total_evaluation;
                                if($khud_evaluation <0)
                                {
                                    $khud_evaluation = 0;
                                }
                                $khud_total_rate = $khud_evaluation*$napi_detail->task_rate;
                                $khud_rate_till = NapiLagatAnuman::find_total_rate_by_plan_id_sno($_GET['id'],$napi_detail->sno,$_GET['period']+1);
//                                $total_estimate = Estimatelagatanuman::find_by_plan_id_period_task_id_task_name($_GET['id'],$napi_detail->task_id,$napi_detail->task_name);
//                                $last_bill      = NapiLagatAnuman::find_by_plan_id_period_task_id_task_name($_GET['id'],$_GET['period']-1,$napi_detail->task_id,$napi_detail->task_name);
//                                if(empty($last_bill))
//                                {
//                                    $last_bill = NapiLagatAnuman::setEmptyObjects();
//                                }
//                                $sql="select * from estimate_add where task_id=".$napi_detail->task_id;
//                                $task_results = Estimateadd::find_by_sql($sql);
//                                $task_selected = Estimateadd::find_by_id($napi_detail->task_name);
                                $work_selected = Worktopic::find_by_id($napi_detail->task_id);
                                $unit_selected = Units::find_by_id($napi_detail->unit_id);
                                if($_GET['period']>1)
                                {
                                    $napi_detail_old   = NapiLagatAnuman::find_by_plan_id_period_sno($_GET['id'],$_GET['period']-1,$napi_detail->sno);
                                    if(!$napi_detail_old){ $napi_detail_old = Napilagatanuman::setEmptyObjects();}
                                }
                                else
                                {
                                    $napi_detail_old = NapiLagatAnuman::setEmptyObjects();
                                }
                                $haal_evaluation = $napi_detail->total_evaluation-$total_evaluation;
                                 $haal_total_rate  = $napi_detail->task_rate*($khud_evaluation-$total_evaluation);
                                if($haal_evaluation<0)
                                {
                                    $haal_evaluation = 0;
                                     $haal_total_rate  = 0;
                                }
                               
                           ?>
                          <tr>
                              <td class="myCenter" ><?=$count?></td>
                              <td class="myCenter" ><!--<strong>क्षेत्र : </strong><?=$work_selected->work_name?><br/><strong>काम :--> </strong><?=$napi_detail->main_work_name?></td>
                              <td class="myCenter" ><?=$unit_selected->name?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=$lagat->total_evaluation?></td>
                              <td class="myCenter" ><?=placeholder($lagat->task_rate)?></td>
                              <td class="myCenter" ><?=placeholder($lagat->total_rate)?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=$total_evaluation?></td>
                              <td class="myCenter" ><?= placeholder($total_rate_till)?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=$khud_evaluation;?></td>
                              <td class="myCenter" ><?=placeholder($khud_total_rate);?></td>
                              <td class="myCenter" ><?=$haal_evaluation?></td>
                              <td class="myCenter" ><?=placeholder($haal_total_rate)?></td>
                              
                              <td></td>
                          </tr>
                          <?php $count++; $total_rate += $haal_total_rate; $khud_total +=$khud_total_rate; endforeach; ?>
                          <tr>
                              <td></td>
                              <td style="text-align: right;">जम्मा</td>
<!--                              <td></td>
                              <td></td>
                              <td></td>-->
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="myCenter"  style="font-weight: bold;">जम्मा रु</td>
                              <td class="myCenter" id="khud_total"  style="font-weight: bold;"><?=$khud_total?></td>
                              <td class="myCenter" style="font-weight: bold;">जम्मा रु</td>
                              <td class="myCenter" id="current_total" style="font-weight: bold;"><?=$total_rate?></td>
                              <td></td>
                          </tr>
                      </table>
                      <div class="bankdetails myCenter"><b>भुक्तानी विवरण </b></div>
<div class="bankdetails">
<table class="table-bordered myWidth100">
  <tr>
  	<td>भुक्तानी दिनुपर्ने कुल रकम </td>
        <td id="total_bhuktani_amount"><?=$estimate_profile->gaupalika_anudan + $invest_details->costumer_agreement?></td>
  </tr>
  <tr>
    <td class="myWidth50">यस बिल बमोजिम भुक्तानी दिनुपर्ने  जम्मा रु.</td>
    <td><?php if($estimate_type==1){ ?> <input type="text" id="bhuktani_bill_amount" value="<?=$payment_details->bhuktani_bill_amount?>" name="bhuktani_bill_amount" width="50" /> <?php } else { echo convertedcit(placeholder($total_rate)); }?></td>
    
    
  </tr>
  <tr>
    <td>अघिल्लो बिलबाट भुक्तानी भएको रु</td>
    <td id="total_back_amount"><?=$prev_bhuktani?></td>
    
    
  </tr>
  <tr>
      <td >भुक्तानी दिनुपर्ने बाकी रु</td>
      <td><input type="text" name="bhuktani_rem_amount" id="bhuktani_rem_amount" value="<?=$payment_details->bhuktani_rem_amount?>" /></td>
      
  </tr>
  
  
</table>
</form>
</div>
                     
                       
                    </div>
                </div><!-- main menu ends -->
        
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>