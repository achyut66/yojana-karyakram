<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//get_access_form($_GET['id']);
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
//$data = new Planamountwithdrawdetails;
//print_r($data); exit;
if(isset($_POST['submit']))
{
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
//सार्बजनिक परिक्षण सम्बन्धी विवरण 
   // echo "<pre>";print_r($_POST); echo "</pre>"; exit;
        $data = new Samitipublicinvestigationdetails();
        $data->survey_date=$_POST['survey_date'];
        $data->survey_date_english = DateNepToEng($data->survey_date);
        $data->population=$_POST['population'];
        $data->plan_id=$_POST['plan_id'];
        $data->save();
      //योजना भुक्तानी सम्बन्धी विवरण   
        $data = new Samitiplanamountwithdrawdetails();
        $data->plan_end_date = $_POST['plan_end_date'];
        $data->yojana_sakine_date=$_POST['yojana_sakine_date'];
        $dsata->yojana_sakine_date=$_POST['yojana_sakine_date_english'];
        $data->upabhokta_aproved_date=$_POST['upabhokta_aproved_date'];
        $data->upabhokta_aproved_date_english = DateNepToEng($data->upabhokta_aproved_date);
        $data->expenditure_approved_date = $_POST['expenditure_approved_date'];
        $data->expenditure_approved_date_english = DateNepToEng($data->expenditure_approved_date_english);
        $data->plan_evaluated_date=$_POST['plan_evaluated_date'];
        $data->plan_evaluated_date_english = DateNepToEng($data->plan_evaluated_date_english);
        $data->plan_evaluated_amount=$_POST['plan_evaluated_amount'];
        
        $data->final_payable_amount=$_POST['final_payable_amount'];
        $data->payment_till_now=$_POST['payment_till_now'];
        $data->advance_payment=$_POST['advance_payment'];
        $data->remaining_payment_amount=$_POST['remaining_payment_amount'];
        $data->final_contengency_amount=$_POST['final_contengency_amount'];
        $data->final_renovate_amount=$_POST['final_renovate_amount'];
        $data->final_due_amount=$_POST['final_due_amount'];
        $data->final_disaster_management_amount=$_POST['final_disaster_management_amount'];
        $data->final_total_amount_deducted=$_POST['final_total_amount_deducted'];
        $data->final_total_paid_amount=$_POST['final_total_paid_amount'];
        $data->plan_id=$_POST['plan_id'];
        $data->save();
        $session->message("Data Saved");
        redirect_to("plan_form5.php");
        

}
$data_selected_public = Samitipublicinvestigationdetails::find_by_plan_id($_GET['id']); 
$data_selected_final = Samitiplanamountwithdrawdetails::find_by_plan_id($_GET['id']); 
$plan_selected = Plandetails1::find_by_id($_GET['id']);
 $total_investment = Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
 //$net_investment = $total_investment->total_investment - $total_investment->costumer_investment;
 $net_investment=0;
 if(!empty($total_investment))
     {
        $net_investment = $total_investment->agreement_gauplaika + $total_investment->agreement_other + $total_investment->costumer_agreement + $total_investment->other_agreement;
 
     }
 $advance = Samitiplanstartingfund::find_by_plan_id($_GET['id']);
 $inst_count = Samitianalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 $total_paid_amount = array();
 if(empty($advance))
 {
   $advance = Samitiplanstartingfund::setEmptyObjects();
 }
 // check for installment amount and calculating the total paid amount i.e. payable amount without contingency amount 
 // but including advance amount in the first installment
 $inst_amount = array(); 
 $inst_selected = array();
 $payable_amount = array();
 $net_payable_amount = $net_investment; 
 $inst_selected = array();
 $check_inst = 0;
 if($inst_count>0):
   $check_inst = 1;
 for($i=1; $i<=$inst_count; $i++): 
 $inst_data = Samitianalysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
   array_push($inst_amount, $inst_data->total_paid_amount);
   array_push($payable_amount, $inst_data->payable_amount);
   array_push($inst_selected, $inst_array[$i]);
   $net_payable_amount -= $inst_data->payable_amount;
  endfor;
  endif;
  if($inst_count==0)
  {
      $final_total_deducted_amount = ($net_payable_amount*.03)+$advance->advance;
      $final_total_paid_amount = $net_payable_amount - $final_total_deducted_amount;
  }
  else
  {
      $final_total_deducted_amount = ($net_payable_amount*.03);
      $final_total_paid_amount = $net_payable_amount - $final_total_deducted_amount;
  }
   ?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | दर्ता न :<?=convertedcit($_GET['id'])?></h2>
            <h2 class="headinguserprofile">योजनाको कुल भुक्तानी दिनु पर्ने रकम: रु <span id="net_investment"><?php echo convertedcit($net_investment); ?></span></h2>
            <div class="OurContentLeft">
                    <?php include("menuincludes/samiti_bhuktani_dashboard.php");?>
            </div>	
                <?php echo $message;?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
            		 <?php if(!empty($data_selected_public)):?>
                      
 
                    <div>
                               <h3>योजनाको अन्तिम भुक्तानी </h3>
                               <?php
                               if($mode=="superadmin"){?>
                                  <a onclick="return confirm('के तपाई डेटा हाटाउन चाहनुहुन्छ ?');" href="delete_final_payment.php?plan_id=<?php echo $_GET['id'];?>"><button>अन्तिम भुक्तानी हटाउनु होस्</button></a><br><br>
                               <?php } ?>
                              <table id="plan_amount_withdraw" class="table table-bordered">
                                   <tr>
                                      <td>सार्बजनिक परिक्षण भएको मिति</td>
                                      <td><?=convertedcit($data_selected_public->survey_date)?></td>
                                    </tr>
                                    <tr>
                                      <td>सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या</td>
                                      <td><?=convertedcit($data_selected_public->population)?></td>
                                    </tr>
                                     <tr>
                                <td>योजना सम्पन्न हुने मिति</td>
                                <td><?=convertedcit($data_selected_final->yojana_sakine_date);?></td>
                              </tr>
                             <tr>
                                <td>योजनाको काम सम्पन्न भएको मिति</td>
                                <td><?=convertedcit($data_selected_final->plan_end_date)?></td>
                              </tr>
                              <tr>
                                <td>उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><?=convertedcit($data_selected_final->upabhokta_aproved_date)?></td>
                              </tr>
                              <tr>
                                <td>अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><?=convertedcit($data_selected_final->expenditure_approved_date)?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन मिति</td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_date)?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम</td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_amount)?></td>
                              </tr>
                               <tr>
                                <td width="176"> भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><?=convertedcit($data_selected_final->final_payable_amount)?></td>
                              </tr>
                               <tr>
                                <td width="176"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></td>
                                <td width="243"><?=convertedcit($data_selected_final->payment_till_now)?></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->advance_payment)?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम</td>
                                <td><?=convertedcit($data_selected_final->remaining_payment_amount)?></td>
                              </tr>
                              <tr>
                                <td>कन्टेन्जेन्सी  कट्टी रकम</td>
                                    <td><?=convertedcit($data_selected_final->final_contengency_amount)?></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_renovate_amount)?></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_due_amount)?></td>
                              </tr>
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_disaster_management_amount)?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_total_amount_deducted)?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिइएको खुद रकम</td>
                                <td><?=convertedcit($data_selected_final->final_total_paid_amount)?></td>
                              </tr>
                             </table>
                              </div>
                    <?php endif; ?>
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);
                    $datas=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>
                     <div <?php if(!empty($data_selected_final)): ?> style="display:none;" <?php endif; ?>>
                            <form method="post" enctype="multipart/form-data" >
                               <h3>योजनाको अन्तिम भुक्तानी </h3>
                            <table  id="plan_amount_withdraw" class="table table-bordered">
                              <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                                   <tr>
                                      <td width="178">सार्बजनिक परिक्षण भएको मिति</td>
                                      <td width="117"><input type="text" name="survey_date" id="nepaliDate3"></td>
                                    </tr>
                                    <tr>
                                      <td>सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या</td>
                                      <td><input type="text" name="population"/></td>
                                    </tr>
                                      <tr>
                                <td>योजना सम्पन्न हुने मिति</td>
                                <td><input type="text" name="yojana_sakine_date" value="<?=getSamitiCompletiondate($_GET['id']);?>" readonly="true"</td>
                              </tr>
                             <tr>
                                <td width="178">योजनाको काम सम्पन्न भएको मिति</td>
                                <td width="190"><input type="text" name="plan_end_date" id="nepaliDate5"/></td>
                              </tr>
                              <tr>
                                <td>उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><input type="text" name="upabhokta_aproved_date" id="nepaliDate10"/></td>
                              </tr>
                              <tr>
                                <td>अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><input type="text" name="expenditure_approved_date" id="nepaliDate11"/></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन मिति</td>
                                <td><input type="text" name="plan_evaluated_date" id="nepaliDate12"/></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम</td>
                                <td><input type="text" id="plan_evaluated_amount" name="plan_evaluated_amount"/></td>
                              </tr>
                               <tr>
                                <td width="176"> भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><input style="text-align:right;"  type="text" name="final_payable_amount" id="final_payable_amount" value="<?php echo $add;?>"/></td>
                              </tr>
                               <tr>
                                <td width="176"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></td>
                                <td width="243"><input type="text" name="payment_till_now" readonly="true" value="<?=array_sum($payable_amount)?>" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><input type="text" name="advance_payment" id="advance_payment" readonly="true" value="<?=$advance->advance?>" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम</td>
                                <td><input type="text" name="remaining_payment_amount" id="remaining_payment_amount" readonly="true" value="<?=$net_payable_amount?>" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>कन्टेन्जेन्सी  कट्टी रकम</td>
                                <td><input type="text" name="final_contengency_amount" id="final_contengency_amount" value="<?=$net_payable_amount*.03?>" readonly="true" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><input type="text" name="final_renovate_amount" id="final_renovate_amount" value="0" style="text-align:right;" /></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम</td>
                                <td><input type="text" name="final_due_amount"  id="final_due_amount"  value="0" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम</td>
                                <td><input type="text" name="final_disaster_management_amount"  id="final_disaster_management_amount"  value="0" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><input type="text" name="final_total_amount_deducted" id="final_total_amount_deducted" value="<?=$final_total_deducted_amount?>" readonly="true" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="final_total_paid_amount" id="final_total_paid_amount"  value="<?=$final_total_paid_amount?>" style="text-align:right;" readonly="true"/></td>
                              </tr>
                             </table></br></br>
                             <input type="hidden" name="check_inst" value="<?=$check_inst?>" id="check_inst" />
                        <input type="submit"  name="submit" onclick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस हालिएको  डेटा सच्याउन  मिल्दैन');" value="सेभ गर्नुहोस" class="submit submithere">
                                          
 </form>
                              </div>
                    
              
                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
 <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>