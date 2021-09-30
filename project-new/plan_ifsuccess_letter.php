<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
}
$ward_address=WardWiseAddress();
$address= getAddress();
?>
    <?php $data1 =  Plandetails1::find_by_id($_GET['id']);//print_r($data1);
    $data2 =  Moreplandetails::find_by_plan_id($_GET['id']);//print_r($data2);
    $data3 =  Costumerassociationdetails0::find_by_plan_id($_GET['id']);//print_r($data3);
    $data4 = Plantotalinvestment::find_by_plan_id($_GET['id']);
    //print_r($data4);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$costumer_ass = Costumerassociationdetails::find_by_plan_id($_GET['id']);//print_r($costumer_ass);
	$final_amount = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);//print_r($final_amount);
	$bhautik_laksh = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);//print_r($bhautik_laksh);
	$bhautik_pragati = Bhautik_lakshya::find_by_sql("select * from bhautik_lakshya where type=3 and plan_id =".$_GET['id']);//print_r($bhautik_pragati);
	$profit = Profitablefamilydetails::find_by_plan_id($_GET['id']);//print_r($profit);
	//$group_heading = Costumerassociationdetails::find_by_plan_id ($_GET['id']);
	?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना हस्तान्तरण सम्झौता । print page:: <?php echo SITE_SUBHEADING;?></title>
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
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent" >
    	    <form method="get" action="plan_ifsuccess_letter_print.php">
                    <h2 class="headinguserprofile">सिफारिस सम्बन्धमा | <a href="dashboard_bhuktani.php" class="btn">पछि जानुहोस</a> 
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    </h2>
                    <div class="OurContentFull" >
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                        <div class="myspacer20"></div>
										<div class="subject"><u>विषय:- योजना हस्तान्तरण संझौता  |</u></div
										
							    <div class="banktextdetails">
										<br>१.जिल्ला :-<span>
										   <strong><?php echo SITE_DISTRICT;?> </strong>
										</span>
										<br>२. योजनाको नाम :-<span>
										    <strong><u><?php echo $data1->program_name;?></u></strong>
										</span>
										<br>३. गाउँपालिकाको नाम :-<span>
										    <strong><u><?php echo SITE_LOCATION;?></u></strong>
										</span>
										<br>४. वडा नं :-<span>
										    <strong><u><?php echo convertedcit($data3->program_organizer_group_address)?></u></strong>
										</span>
										<br>५. वस्ती/टोल :-<span> 
										    <strong></strong>
										</span>
										<br>६. योजनाको कूल लागत :-<span>
										   रु. <strong><?php echo convertedcit($data4->total_investment)?></strong>/-
										</span>
										<br>७. कार्य सम्पन्न प्रतिवेदन अनुसारको रकम :-<span>
										    रु. <strong><?php echo convertedcit($final_amount->final_total_paid_amount);?></strong>/-
										</span>
										<br>८. सहभागिताको योगदान :-<span></span>
										<div class="myspacer"></div>
										<br>
										<span style="margin-left:80px;">
										    प्रदेश _ _ _ _ _ _ _
										</span>
										<span style="margin-left:120px">
										    गा.पा  रु. (<?php echo convertedcit($data4->agreement_gauplaika)?>)/-
										</span>
										<span style="margin-left:160px">
										    उपभोक्ता जनश्रमदान रु. (<?php echo convertedcit($data4->costumer_investment)?>)/-
										</span>
										<span style="margin-left:200px">
										    उपभोक्ता लागत सहभागिता रु. (<?php echo convertedcit($data4->costumer_agreement)?>)/-
										</span>
									<div class="myspacer"></div>	
									<br>९. सम्झौता भएको मिति :-<span> 
									    <strong><?php echo convertedcit($data2->miti)?></strong>
									</span>
									<br>१०. कार्य सम्पन्न भएको मिति :-<span>
									    <strong><?php echo convertedcit($final_amount->plan_end_date)?></strong>
									    
									</span>
									<br>११. भौतिक लक्ष :-<span>
									   <?php $i=1; foreach($bhautik_laksh as $bl):?>
									    <table class="table-bordered table-responsive">
									        <tr>
									            <td width="20%"><?php echo convertedcit($i)?></td>
									            <td width="40%"><?php echo SettingbhautikPariman::getName($bl->details_id)?></td>
									            <td width="20%"><?php echo convertedcit($bl->qty)?></td>
									            <td width="20%"><?php echo Units::getName($bl->unit_id)?></td>
									        </tr>
									    </table>
									   <?php $i++;endforeach;?>
									</span>
									<br>१२. भौतिक प्रगती :-<span>
									    <?php $i=1; foreach($bhautik_pragati as $bl):?>
									    <table class="table-bordered table-responsive">
									        <tr>
									            <td width="20%"><?php echo convertedcit($i)?></td>
									            <td width="40%"><?php echo SettingbhautikPariman::getName($bl->details_id)?></td>
									            <td width="20%"><?php echo convertedcit($bl->qty)?></td>
									            <td width="20%"><?php echo Units::getName($bl->unit_id)?></td>
									        </tr>
									    </table>
									   <?php $i++;endforeach;?>
									</span>
									<br>१३. लाभाम्वित जनसंख्या :-<span></span>
									<div class="mmyspacer"></div>
									    <span style="margin-left:80px;">१३.१) दलित (महिला + पुरुष)</span> =
									        <?php echo convertedcit($profit->dalit_mahila+$profit->dalit_purush);?>
									    <span style="margin-left:120px;">१३.२) जनजाती (महिला + पुरुष)</span> = 
									        <?php echo convertedcit($profit->aadhibasi_mahila+$profit->aadhibasi_purush);?> 
									    <span style="margin-left:160px;">१३.३) अन्य (महिला + पुरुष) </span> =
									        <?php echo convertedcit($profit->anya_mahila+$profit->anya_purush);?>
									    <span style="margin-left:200px;">१३.४)जम्मा जनसंख्या</span> =
									        <?php echo convertedcit($profit->dalit_mahila+$profit->dalit_purush+$profit->aadhibasi_mahila+$profit->aadhibasi_purush+$profit->anya_mahila+$profit->anya_purush);?>
									        
									<div class="myspacer"></div>
									<br>१४. लाभाम्वित घरधुरी :-<span></span>
									<div class="mmyspacer"></div>
									    <span style="margin-left:80px;">१४.१) दलित </span> = 
									    <?php echo convertedcit($profit->dalit_ghar);?>
									    <span style="margin-left:120px;">१४.२) जनजाती  </span> =
									    <?php echo convertedcit($profit->aadhibasi_ghar);?>
									    <span style="margin-left:160px;">१४.३) अन्य </span> =
									    <?php echo convertedcit($profit->anya_ghar);?>
									    <span style="margin-left:200px;">१४.४) जम्मा घरधुरी </span> = 
									        <?php echo convertedcit($profit->dalit_ghar+$profit->aadhibasi_ghar+$profit->anya_ghar);?>
									<div class="myspacer"></div>
									</div>
									</div>
										<div class="myspacer30"></div>
										<div class="oursignatureleft mymarginright">तयार गर्ने (प्राबिधिक कर्मचारी)<br/>
                                                                                     <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>"></br>
                                                                                    <!--मिति : <?php echo convertedcit(generateCurrDate());?>-->
                                                                                </div>
									</div>
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->