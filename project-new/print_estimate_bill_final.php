<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

$bill_payment = BillPayment::find_by_plan_id_period($_GET['id'],$_GET['period']);
$bill_payment->bhuktani_bill_amount = $_GET['bhuktani_bill_amount'];
$bill_payment->bhuktani_rem_amount  = $_GET['bhuktani_rem_amount'];
$bill_payment->period               = $_GET['period'];
$bill_payment->plan_id              = $_GET['id'];
$bill_payment->bill_date_nepali     = $_GET['bill_date'];
$bill_payment->bill_date_english    = DateNepToEng($_GET['bill_date']);
$bill_payment->save();

        $profile        = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']);
        $napi_details   = NapiLagatAnuman::find_by_plan_id_period($_GET['id'],$_GET['period']);
//        $estimate       = Estimatelagatanuman::find_by_plan
        if($_GET['period']>1)
        {
            $profile_old        = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']-1);
        }
//print_r($profile); exit;
$ward_address=WardWiseAddress();
$address= getAddress();
$data1 =  Plandetails1::find_by_id($_GET['id']);
$data2 =  Plantotalinvestment::find_by_plan_id($_GET['id']);
$data3 = Moreplandetails::find_by_plan_id($_GET['id']);
$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
if($profile->antim==1)
{
    $period_text = "अन्तिम";
}
else
{
    $period_text = getPeriodArray()[$_GET['period']];
}


// saving the bill date
$date_types             = Engdate::getDateTypes();
$engdate                = Engdate::get_estimate_date($_GET['id']);
$engdate->date_nepali   = $_GET['bill_date'];
$engdate->date_english  = DateNepToEng($_GET['bill_date']);
$engdate->plan_id       = $_GET['id'];
$engdate->period       = $_GET['period'];
$engdate->type          = $date_types['bill'];
$engdate->save();
$invest_details = Plantotalinvestment::find_by_plan_id($_GET['id']);
$estimate_profile = EstimateLagatProfile::find_by_plan_id($_GET['id']);
$bhuktani_till_date = BillPayment::find_total_bhuktani_amount($_GET['id']);
$prev_bhuktani = BillPayment::find_prev_bhuktani_amount($_GET['id'],$_GET['period']);
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$period_text?> रनिङ विल । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body onload="window.print()">
    <?php // include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                
                <div class="maincontent" >
                    
                    <div class="OurContentFull" >
                         
                        <div class="mydate myFont10">म.ले.प. फाराम नं १६७</div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                                    <h4 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h4>
									<div class="myspacer"></div>
									<h4 class="subjectbold1 myCenter letter_subject"><?=$period_text?> रनिङ विल</h4>
<div class="textdetails">
    

     <div class="mydate">मिति : <?=convertedcit($_GET['bill_date'])?></div>
     <div >आर्थिक बर्ष :-  <?=convertedcit($fiscal->year)?></div>
     <div>योजनाको नाम :- <?=$data1->program_name?> </div>
	 <div class="mydate">योजना दर्ता नं:-  <?=convertedcit($data1->id)?></div>
	 <div> ठेगाना :-  <?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?> </div>
</div>
<div class="printContent">
										
										                                                                             
										
<table class="table-bordered myWidth100">
  <tr>
      <td rowspan="2" class="myCenter">सि.नं.</td>
    <td rowspan="2" class="myCenter tdWidth30">कामको विवरण</td>
    <td rowspan="2" class="myCenter">इकाई</td>
    <td colspan="3" class="myCenter">ईष्टमेट बमोजिमको</td>
    <td colspan="2" class="myCenter">अघिल्लो बिलमा चढेको</td>
    <td class="myCenter" colspan="2">खुद भएको काम </td>
    <td colspan="2" class="myCenter">हाल भएको काम</td>
    <td rowspan="2" class="myCenter">कैफियत</td>
  </tr>
  <tr>

      <td class="myCenter"> परिणाम </td>
    <td class="myCenter"> दर</td>
    <td class="myCenter"> जम्मा मूल्य</td>
    <td class="myCenter"> परिणाम</td>
    <td class="myCenter"> जम्मा मूल्य</td>
    <td class="myCenter"> परिणाम</td>
    <td class="myCenter">जम्मा मूल्य</td>
    <td class="myCenter"> परिणाम</td>
    <td class="myCenter">जम्मा मूल्य</td>

    
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
                              <td class="myCenter" ><?=convertedcit($count)?></td>
                              <td class="myCenter" ><!--<strong>क्षेत्र : </strong><?=$work_selected->work_name?><br/><strong>काम :--> </strong><?=$napi_detail->main_work_name?></td>
                              <td class="myCenter" ><?=$unit_selected->name?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=convertedcit(placeholder($lagat->total_evaluation))?></td>
                              <td class="myCenter" ><?=convertedcit(placeholder($lagat->task_rate))?></td>
                              <td class="myCenter" ><?=convertedcit(placeholder($lagat->total_rate))?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=convertedcit(placeholder($total_evaluation))?></td>
                              <td class="myCenter" ><?= convertedcit(placeholder($total_rate_till))?></td>
                              <!--<td></td>-->
                              <td class="myCenter" ><?=convertedcit(placeholder($khud_evaluation));?></td>
                              <td class="myCenter" ><?=convertedcit(placeholder($khud_evaluation*$napi_detail->task_rate));?></td>
                              <td class="myCenter" ><?=convertedcit(placeholder($haal_evaluation))?></td>
                              <td class="myCenter" ><?=convertedcit(placeholder($haal_total_rate))?></td>
                              
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
                              <td class="myCenter" id="khud_total"  style="font-weight: bold;"><?=convertedcit(placeholder($khud_total))?></td>
                              <td class="myCenter" style="font-weight: bold;">जम्मा रु</td>
                              <td class="myCenter" id="current_total" style="font-weight: bold;"><?=convertedcit(placeholder($total_rate))?></td>
                              <td></td>
                          </tr>
</table>

<div class="bankdetails myCenter"><b>भुक्तानी विवरण </b></div>
<div class="bankdetails">
<table class="table-bordered myWidth100">
  <tr>
  	<td>भुक्तानी दिनुपर्ने कुल रकम </td>
        <td><?= convertedcit(placeholder($estimate_profile->gaupalika_anudan + $invest_details->costumer_agreement))?></td>
  </tr>
  <tr>
    <td class="myWidth50">यस बिल बमोजिम भुक्तानी दिनुपर्ने  जम्मा रु.</td>
    <td><?=convertedcit(placeholder($bill_payment->bhuktani_bill_amount))?></td>
   </tr>
  <tr>
    <td>अघिल्लो बिलबाट भुक्तानी भएको रु</td>
    <td><?=convertedcit(placeholder($prev_bhuktani))?></td>
    
    
  </tr>
  <tr>
    <td>भुक्तानी दिनुपर्ने बाकी रु</td>
    <td><?=convertedcit(placeholder($bill_payment->bhuktani_rem_amount))?></td>
    
  </tr>
  
  
</table>

</div>
										<div class="myspacer30"></div>
										
										<div class="oursignature">सदर गर्ने</div>
										
<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
<div class="oursignatureleft " style="margin-left:150px;">जाँच गर्ने</div>
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php // include("menuincludes/footer.php"); ?>