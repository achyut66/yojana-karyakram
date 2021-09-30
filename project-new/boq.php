<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

$ward_address=WardWiseAddress();
$address= getAddress();
$profile_details = EstimateLagatProfile::find_by_plan_id($_GET['id']);
$sql = "select * from estimate_lagat_anuman where plan_id=".$_GET['id']." order by sno asc";
$lagat_details = Estimatelagatanuman::find_by_sql($sql);
$data1 = Plandetails1::find_by_id($_GET['id']);
$postnames      = Postname::find_all();
$units          = Units::find_all();
$work_details   = Worktopic::find_all();
$estimate_adds = Estimateadd::find_all();
$estimate_details = Estimateanudandetails::find_by_plan_id($_GET['id']);
$added_investment = $data1->investment_amount+ $estimate_details->other_source + $estimate_details->other_agreement;
$contingency = $added_investment*.03;

//$data2      =  Plantotalinvestment::find_by_plan_id($_GET['id']);
//$data3      = Moreplandetails::find_by_plan_id($_GET['id']);
//$data4      = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal     = FiscalYear::find_by_id($data1->fiscal_id); 
include("menuincludes/header.php"); 
?>
<!-- js ends -->
<title>लागत अनुमान फाराम । print page:: <?php echo SITE_SUBHEADING;?></title>

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
									<div class="subjectbold1 myCenter letter_subject">Bill Of Quantity</div>
<div class="myspacer10"></div>
 <div class="textdetails">
     <div class="mydate">मिति : <?=convertedcit($profile_details->date_nepali)?></div>
     <div ><b>आर्थिक बर्ष :- </b> <?=convertedcit($fiscal->year)?></div>
<div>योजनाको नाम :- </b> <?=$data1->program_name?> </div>
<div class="mydate">योजना दर्ता नं:- </b> <?=convertedcit($data1->id)?></div>

<div> ठेगाना :- </b> <?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?> </div>



<!-- table ends -->
</div>
<div class="printContent">
										
										                                                                             
										
    <div class="myWidth100">
        <table class="table-bordered myWidth100">
  <tr>
    <td class="mycenter">सि.नं</td>
    <td class="mycenter tdWidth30">कामको विवरण</td>
    <td class="mycenter">परिमाण</td>
    <td class="mycenter">ईकाई </td>
    <td class="mycenter">दर</td>
    <td class="mycenter">जम्मा लागत रु</td>
  </tr>
 
  <?php  $count = 1; foreach($lagat_details as $lagat_detail): ?>
                                <tr  id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?>>
                                   <td><?=convertedcit($count)?></td>
                                   <td><?php //echo $task_name->work_name?><?=$lagat_detail->main_work_name?></td>
                                   <td><?php echo convertedcit($lagat_detail->total_evaluation); ?></td>
                                   <td><?php echo Units::getName($lagat_detail->unit_id);?></td>
                                   <td><?php echo convertedcit($lagat_detail->task_rate); ?></td>
                                   <td><?php echo convertedcit(placeholder($lagat_detail->total_rate)); ?></td> 
                                   
                               </tr>
                               <?php $count++; endforeach; ?>
                       
            </table>

    </div>
				<div class="myspacer30"></div>
										
                                
										
                                						<div class="myspacer"></div>
							  </div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php // include("menuincludes/footer.php"); ?>