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

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">लागत अनुमान फाराम| <a class="btn" href="estimate_paperdashboard.php">पछि जानुहोस </a></h2>
                    <div class="OurContentFull" >
                    	 
                      <div class="myPrint"><a href="print_estimate_lagat_final.php" target="_blank">प्रिन्ट गर्नुहोस</a></div> <div class="myspacer"></div> 
                        
                        <div class="mydate myFont10">म.ले.प. फाराम नं १६७</div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                                                                        <h4 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h4>
									<div class="myspacer"></div>
									<div class="subjectbold1 myCenter letter_subject">लागत अनुमान फाराम	</div>
<div class="textdetails">
    <div class="myspacer30"></div>
<table class="table borderless myWidth100">
  <tr>
      <td><b>योजनाको नाम :- </b> <?=$data1->program_name?> </td>
    
    <td></td>
    <td><b>आर्थिक बर्ष :- </b> <?=convertedcit($fiscal->year)?></td>
    <td></td>
  </tr>
  <tr>
      <td><b> ठेगाना :- </b> <?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?> </td>
    <td></td>
    <td> <b>योजना दर्ता नं:- </b> <?=convertedcit($data1->id)?></td>
    <td></td>
  </tr>
</table>
<!-- table ends -->
</div>
<div class="printContent">
										
										                                                                             
										
<table class="table table-responsive table-bordered">
  <tr>
    <th rowspan="2" class="mycenter">सि.नं</th>
    <th rowspan="2" class="mycenter">कामको विवरण</th>
    <th rowspan="2" class="mycenter">संख्या</th>
    <th height="70" colspan="3" class="mycenter">प्रस्ताबित कामको</th>
    <th rowspan="2"  class="mycenter">परिमाण</th>
    
    <th rowspan="2" class="mycenter">ईकाई </th>
    <th rowspan="2" class="mycenter">दर</th>
    <th rowspan="2" class="mycenter">जम्मा लागत रु</th>
    <th rowspan="2" class="mycenter">कैफियत</th>
  </tr>
  <tr>
    <th class="mycenter">लम्बाई</th>
    <th class="mycenter">चौडाई</th>
    <th class="mycenter">उचाई</th>
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
                                           <td><?=convertedcit($break_lagat->task_count+0)?></td>
                                           <td><?=convertedcit($break_lagat->length+0)?></td>
                                           <td><?=convertedcit($break_lagat->breadth+0)?></td>
                                           <td><?=convertedcit($break_lagat->height+0)?></td>
                                           <td><?php if($break_lagat->deduct_part==1){echo "-".convertedcit($break_lagat->total_evaluation+0); } else {echo convertedcit($break_lagat->total_evaluation+0);} ?></td>
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
                                       <td><?=convertedcit($lagat_detail->total_evaluation+0)?></td>
                                       <td id="unit-1"></td> 
                                       <td><?=convertedcit($lagat_detail->task_rate+0)?></td>
                                       <td><?=convertedcit($lagat_detail->total_rate+0)?></td>
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
                                           <td><?=convertedcit($lagat_detail->total_evaluation+0)?></td>
                                           <td id="unit-1"><?php echo Units::getName($lagat_detail->unit_id); ?></td> 
                                           <td><?=convertedcit($lagat_detail->task_rate+0)?></td>
                                           <td><?=convertedcit($lagat_detail->total_rate+0)?></td>
                                           <td></td>
                                   </tr>
                                 <?php endif;// without break single row ends here ?>
                               <?php $count++; endforeach; ?>
                        <?php if($profile_details->type==1):
                        $percent_one=($data1->investment_amount / $profile_details->sub_total) * 100;
                        $percent_two = ($data1->public_anudan / $profile_details->sub_total) * 100;
                        ?>
                        <tr>
                            <td colspan="9" style="text-align:right;">जम्मा रु:</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->sub_total))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align:right;">गाँउपलिकाबाट अनुदान रु <span> (<?=convertedcit($percent_one) ?>  %)</span> 	</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($data1->investment_amount))?></td>
                          <td>&nbsp;</td>
                        </tr>
                         <tr>
                            <td colspan="9" style="text-align: right;">अन्य निकायबाट प्राप्त निकाशा अनुदान रकम :</td>
                            <td style="text-align: right;"><?=convertedcit(placeholder($estimate_details->other_source))?></td>
                            <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td colspan="9" style="text-align: right;">समितिबाट नगद साझेदारी <?php echo SITE_TYPE;?>मा जम्मा गरेको    रकम :</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($estimate_details->samiti_investment))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align: right;">अन्य साझेदारी निकासा रकम :</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($estimate_details->other_agreement))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align:right;">कन्टिन्जेन्सी रु:</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($contingency))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align:right;">भुक्तानी पाऊने कुल अनुदान रु	:</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->bhuktani_anudan))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align:right;">जनश्रमदान रु: <span> (<?=convertedcit($percent_two) ?>  %)</span></td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->public_anudan))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="9" style="text-align:right;">कुल जम्मा रु:</td>
                          <td style="text-align: right;"><?=convertedcit(placeholder($profile_details->grand_total))?></td>
                          <td>&nbsp;</td>
                        </tr>
                        <?php endif; ?>
                        
                    <?php if($profile_details->type==2): ?>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">जम्मा</td>
                               <td class="myCenter"><?=convertedcit(placeholder($profile_details->sub_total))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">भ्याट (१३ %)</td>
                               <td class="myCenter"><?=convertedcit(placeholder($profile_details->vat_amount))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">ओभरहेड (१५ %)</td>
                               <td class="myCenter"><?=convertedcit(placeholder($profile_details->overhead))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">कुल जम्मा</td>
                               <td class="myCenter"><?=convertedcit(placeholder($profile_details->grand_total))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;"><?=SITE_TYPE?>बााट अनुदान</td>
                               <td class="myCenter"><?=convertedcit(placeholder($data1->investment_amount))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">कन्टिन्जेन्सी</td>
                               <td class="myCenter"><?=convertedcit(placeholder($profile_details->contingency))?></td>
                               <td>&nbsp;</td>
                           </tr>
                           <tr>
                               <td colspan="9"  id="task_name-1" style="text-align: right;">भुक्तानी पाऊने कुल अनुदान</td>
                               <td class="myCenter"><?=convertedcit(placeholder($data1->investment_amount-$contingency_thekka))?></td>
                               <td>&nbsp;</td>
                           </tr>
                         
                    <?php endif; ?>
            </table>

				<div class="myspacer30"></div>
										
										<div class="oursignature">सदर गर्ने</div>
										
<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
<div class="oursignatureleft margin20 ">जाँच गर्ने</div>
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