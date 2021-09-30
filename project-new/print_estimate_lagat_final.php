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
$con = get_contingency_for_plan($_GET['id']);
$contingency = $added_investment* $con;

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
									<div class="subjectbold1 myCenter letter_subject">लागत अनुमान फाराम	</div>
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
        <table class="table-bordered myWidth100" style="font-size:10px;">
  <tr>
    <td rowspan="2" class="mycenter" style="width:3%;">सि.नं</td>
    <td rowspan="2" class="mycenter tdWidth30">कामको विवरण</td>
    <td rowspan="2" class="mycenter">संख्या</td>
    <td colspan="3" class="mycenter">प्रस्ताबित कामको</td>
    <td rowspan="2"  class="mycenter">परिमाण</td>
    
    <td rowspan="2" class="mycenter">ईकाई </td>
    <td rowspan="2" class="mycenter">दर</td>
    <td rowspan="2" class="mycenter">जम्मा लागत रु</td>
    <td rowspan="2" class="mycenter">कैफियत</td>
  </tr>
  <tr>
    <td class="mycenter">लम्बाई</td>
    <td class="mycenter">चौडाई</td>
    <td class="mycenter">उचाई</td>
    </tr>
  <?php  $count = 1; foreach($lagat_details as $lagat_detail): ?>
                               <?php $break_lagats = ''; if($lagat_detail->break_type==2){$break_lagats = Estimatelagatanumanbreak::find_by_plan_id_sno($_GET['id'], $count); }?>
                               <?php $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                     $task_results = Estimateadd::find_by_sql($sql);
                               ?>
                               <?php if(!empty($break_lagats)):// break row starts here ?>
                               <?php $task_name = Worktopic::find_by_id($lagat_detail->task_id); 
                                ?>
                               <tr  id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?>>
                                   <td><?=convertedcit($count)?></td>
                                   <td><?php //echo $task_name->work_name?><?=$lagat_detail->main_work_name?></td>
                                   <td id="task_name_column-<?=$count?>"></td>
                                   <td id="estimate_sub-<?=$count?>"></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td><?php echo Units::getName($lagat_detail->unit_id);?></td>
                                   <td></td>
                                   <td></td> 
                                   <td></td>
                                   
                                   
                               </tr>
                                   <?php $j = 1; foreach($break_lagats as $break_lagat): // populating the breaks?>
                                         <tr id="break_row-<?=convertedcit($count)?>_<?=convertedcit($j)?>" class="break_row-<?=$count?>">
                                           
                                           <td></td>
                                           <td><?=convertedcit($count)?>.<?=convertedcit($j)?>) <?=$break_lagat->break_work_name?><?php if($break_lagat->deduct_part==1){echo  " (घटाएको भाग)";} ?></td>
                                           <td><?=convertedcit($break_lagat->task_count)?></td>
                                           <td><?=convertedcit($break_lagat->length)?></td>
                                           <td><?=convertedcit($break_lagat->breadth)?></td>
                                           <td><?=convertedcit($break_lagat->height)?></td>
                                           <td><?php if($break_lagat->deduct_part==1){echo "-".convertedcit($break_lagat->total_evaluation); } else {echo convertedcit($break_lagat->total_evaluation);} ?></td>
                                           <td id="unit-1"></td> 
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                </tr>
                                   <?php $j++; endforeach; ?>
                                <!-- sub total row in case of break starts here -->
                                   <tr id="total_output_row-<?=$count?>">
                                       
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td style="text-align:right">जम्मा</td>
                                       <td><?=convertedcit($lagat_detail->total_evaluation)?></td>
                                       <td id="unit-1"></td> 
                                       <td><?=convertedcit($lagat_detail->task_rate)?></td>
                                       <td style="text-align:right;"><?=convertedcit($lagat_detail->total_rate)?></td>
                                       <td></td>
                                   </tr>
                                   <!-- sub total row in case of break starts here -->
                               <?php endif; // break row ends here ?>
                                <?php if(empty($break_lagats)):// without break single row starts here
                                       $single_break = Estimatelagatanumanbreak::find_single_row($_GET['id'],$count);
                                       $task_name = Worktopic::find_by_id($lagat_detail->task_id);
                                ?>
                                       <tr id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?> >
                                           <td><?=convertedcit($count)?></td>
                                           <td><?php //echo $task_name->work_name?><?=$lagat_detail->main_work_name?></td>
                                           <td><?=convertedcit($single_break->task_count+0)?></td>
                                           <td><?=convertedcit($single_break->length+0)?></td>
                                           <td><?=convertedcit($single_break->breadth+0)?></td>
                                           <td><?=convertedcit($single_break->height+0)?></td>
                                           <td><?=convertedcit(placeholder($lagat_detail->total_evaluation+0))?></td>
                                           <td id="unit-1"><?php echo Units::getName($lagat_detail->unit_id); ?></td> 
                                           <td><?=convertedcit(placeholder($lagat_detail->task_rate+0))?></td>
                                           <td style="text-align:center;"><?=convertedcit(placeholder($lagat_detail->total_rate+0))?></td>
                                           <td></td>
                                   </tr>
                                 <?php endif;// without break single row ends here ?>
                               <?php $count++; endforeach; ?>
                        <?php if($profile_details->type==1):
                                $contingency = $data1->investment_amount * $con;
                                $actual_amount = $data1->investment_amount - $contingency;
                             $percent_one=($actual_amount / ($profile_details->sub_total + $contingency)) * 100;
                        $percent_two = ($profile_details->public_anudan / ($profile_details->sub_total + $contingency)) * 100;?> 
                          <table class="table table-bordered myWidth100 myFont10 p0">
                                   <tr>
                                       <td colspan="10" style="text-align: center;" style="padding:0px;">जम्मा</td>
                                       <td style="text-align: center;"><?=convertedcit(placeholder($profile_details->sub_total+0))?></td>
                                   </tr>
                                   
                                   <tr>
                                       <td colspan="10" style="text-align: center;">कन्टिन्जेन्सी <?=convertedcit($con* 100)?> %</td>
                                       <td style="text-align: center;"><?=convertedcit(placeholder($contingency+0))?></td>
                                   </tr>
                                   <tr>
                                       <td colspan="10" style="text-align: center;">कुल जम्मा</td>
                                    <td style="text-align: center;"><?= convertedcit(placeholder($profile_details->sub_total+$contingency +0))?></td>
                                   </tr>
                       </table>
                        <table class="table table-bordered myWidth100 myFont10 p0">
                        <tr>
                            <th>विवरण </th>
                            <th>रकम </th>
                            <th>प्रतिशत(%)</th>   
                        </tr>
                         <tr>
                            <td style="padding:0px;"><?=SITE_TYPE?>बाट अनुदान </td>
                            <td><?=convertedcit(placeholder($data1->investment_amount-($data1->investment_amount * $con)))?></td>
                            <td> ( <span id="percent_one"><?=convertedcit(round( $percent_one, 2, PHP_ROUND_HALF_UP))?> %</span>)</td>   
                        </tr>
                        <tr>
                            <td>जनश्रमदान</td>
                            <td><?=convertedcit(placeholder($profile_details->public_anudan+0))?></td>
                            <td> ( <span id="percent_two"><?=convertedcit(round( $percent_two, 2, PHP_ROUND_HALF_UP))?></span>)%</td>
                        </tr>
                         <tr>
                            <td>कुल जम्मा</td>
                          <td><?=convertedcit(placeholder($profile_details->public_anudan + $profile_details->bhuktani_anudan+0)) ?></td>
                            <td> ( <span id="">१००</span>)%</td>
                        </tr>
                        </table>
                        <?php endif; ?>
                        <table class="table table-bordered myWidth100 myFont10 p0">
                    <?php if($profile_details->type==2): ?>
                     
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">जम्मा</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->sub_total))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">ओभरहेड (१५ %)</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->overhead))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">भ्याट (१३ %)</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->vat_amount))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">कुल जम्मा</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->grand_total))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;"><?=SITE_TYPE?>बााट अनुदान</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($data1->investment_amount))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">कन्टिन्जेन्सी</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->contingency))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">भुक्तानी पाऊने कुल अनुदान</td>
                               <td style="text-align: right;"><?=convertedcit(placeholder($data1->investment_amount-$contingency_thekka))?></td>
                               <td>&nbsp;</td>
                           </tr>
                         
                    <?php endif; ?>
            </table>

    </div>
				<div class="myspacer30"></div>
										
                                <div class="oursignature"> <b>सदर गर्ने </b></div>
										
                                    <div class="oursignatureleft mymarginright"><b> पेश गर्ने  </b></div>
                                    <div class="oursignatureleft margin20"> <b> जाँच गर्ने </b></div>
										<div class="myspacer"></div>
							  </div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php // include("menuincludes/footer.php"); ?>