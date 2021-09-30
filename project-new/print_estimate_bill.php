<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
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
$period_text = getPeriodArray()[$_GET['period']];

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$period_text?> रनिङ विल । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile"><?=$period_text?> रनिङ विल | <a class="btn" href="bill_letter_dashboard.php">पछि जानुहोस </a></h2>
                    <div class="OurContentFull" >
                    	 
                        <div class="myPrint"><a href="print_estimate_bill_final.php?id=<?=$_GET['id']?>&period=<?=$_GET['period']?>" target="_blank">प्रिन्ट गर्नुहोस</a></div> <div class="myspacer"></div> 
                        
                        <div class="mydate myFont10">म.ले.प. फाराम नं १६७</div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                  <h5 class="marginright1 letter_title_three"> <?php echo SITE_ADDRESS;?> </h5>
                  <br>
									<div class="myspacer"></div>
									<h4 class="margin1em letter_subject"><?=$period_text?> रनिङ विल</h4>
<div class="textdetails">									
<table class="table table-bordered table-responsive">
  <tr>
    <td>योजनाको नाम: </td>
    
    <td><?=$data1->program_name?></td>
    <td>आर्थिक बर्ष: </td>
    <td><?=convertedcit($fiscal->year)?></td>
  </tr>
  <tr>
    <td>ठेगाना: </td>
    <td><?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?></td>
    <td>योजना दर्ता नं:</td>
    <td><?=convertedcit($data1->id)?></td>
  </tr>
  <tr>
    <td>उपभोक्ता समितिको नाम: </td>
    <td><?=$data4->program_organizer_group_name?></td>
    <td>अनुदान रु: </td>
    <td><?=convertedcit(placeholder($data1->investment_amount))?></td>
  </tr>
  <tr>
    <td>शूरु हुने मिति: </td>
    <td><?=convertedcit($data3->yojana_start_date)?></td>
    <td>संझौता भएको मिति: </td>
    <td><?=convertedcit($data3->miti)?></td>
  </tr>
  <tr>
    <td>सम्पन्न हुने मिति: </td>
    <td><?=convertedcit(getcompletiondate($_GET['id']))?></td>
    <td>नापी लिईएको मिति: </td>
    <td><?=convertedcit($profile->date_nepali)?></td>
  </tr>
</table><!-- table ends -->
</div>
<div class="printContent">
										
										                                                                             
										
<table class="table table-responsive table-bordered">
  <tr>
      <th rowspan="2" class="myCenter">सि.नं.</th>
    <th rowspan="2" class="myCenter">कामको विवरण</th>
    <th rowspan="2" class="myCenter">इकाई</th>
    <th colspan="3" class="myCenter">ईष्टमेट बमोजिमको</th>
    <th colspan="2" class="myCenter">अघिल्लो बिलमा चढेको</th>
    <th colspan="2" class="myCenter">हाल भएको काम</th>
    <th class="myCenter" colspan="2">खुद भएको काम </th>
    <th rowspan="2" class="myCenter">कैफियत</th>
  </tr>
  <tr>

      <th class="myCenter"> परिणाम </th>
    <th class="myCenter"> दर</th>
    <th class="myCenter"> जम्मा मूल्य</th>
    <th class="myCenter"> परिणाम</th>
    <th class="myCenter"> जम्मा मूल्य</th>
    <th class="myCenter"> परिणाम</th>
    <th class="myCenter">जम्मा मूल्य</th>
    <th class="myCenter"> परिणाम</th>
    <th class="myCenter">जम्मा मूल्य</th>

    
  </tr>
  <?php $count= 1; $total_rate = 0; $total_back_amount = 0; foreach($napi_details as $napi_detail):
                                $lagat = Estimatelagatanuman::find_by_plan_id_sno($_GET['id'],$napi_detail->sno);
                                $total_evaluation_till = NapiLagatAnuman::find_total_evaluation_by_plan_id_sno($_GET['id'],$napi_detail->sno,$_GET['period']);
                                $total_rate_till = NapiLagatAnuman::find_total_rate_by_plan_id_sno($_GET['id'],$napi_detail->sno,$_GET['period']);
                                
                                $khud_evaluation = NapiLagatAnuman::find_total_evaluation_by_plan_id_sno($_GET['id'],$napi_detail->sno,$_GET['period']+1);
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
                                    
                           ?>
                          <tr>
                              <td><?=$count?></td>
                              <td><!--<strong>क्षेत्र : </strong><?=$work_selected->work_name?><br/><strong>काम :--> </strong><?=$napi_detail->main_work_name?></td>
                              <td><?=$unit_selected->name?></td>
                              <!--<td></td>-->
                              <td><?=convertedcit($lagat->total_evaluation)?></td>
                              <td><?=convertedcit(placeholder($lagat->task_rate))?></td>
                              <td><?=convertedcit(placeholder($lagat->total_rate))?></td>
                              <!--<td></td>-->
                              <td><?=convertedcit($total_evaluation_till)?></td>
                              <td><?= convertedcit(placeholder($total_rate_till))?></td>
                              <!--<td></td>-->
                              <td><?=convertedcit($napi_detail->total_evaluation)?></td>
                              <td><?=convertedcit(placeholder($napi_detail->total_rate))?></td>
                              <td><?=convertedcit($khud_evaluation);?></td>
                              <td><?=convertedcit(placeholder($khud_rate_till));?></td>
                              <td></td>
                          </tr>
                          <?php $count++; $total_rate += $napi_detail->total_rate; 
                                   $total_back_amount +=$total_rate_till;
                          endforeach; ?>
</table>

<div class="bankdetails">उपर्युक्त बमाजिम ठीक छ भनी प्रमाणित गर्नेको सही |</div>
<div class="bankdetails">
<table class="table table-responsive table-bordered">
  <tr>
    <td>यस बिल बमोजिम जम्मा रु.</td>
    <td><?=convertedcit(placeholder($total_rate))?></td>
    <td>मालसामानको मोल</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>अघिल्लो बिलबाट भुक्तानी भएको रु</td>
    <td><?=convertedcit(placeholder($total_back_amount))?></td>
    <td>मेशेनरी औजारको बहाल</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>भुक्तानी दिनुपर्ने बाकी रु</td>
    <td>&nbsp;</td>
    <td>धरौटी</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>कट्टा गर्नु पर्ने रु</td>
    <td>&nbsp;</td>
    <td>अन्य</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> पेश्की रु</td>
    <td>&nbsp;</td>
    <td>खुद दिनु पर्ने रु</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
										<div class="myspacer30"></div>
										
										<div class="oursignature">सदर गर्ने</div>
										
<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
<div class="oursignatureleft ">जाँच गर्ने</div>
										<div class="myspacer"></div>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>