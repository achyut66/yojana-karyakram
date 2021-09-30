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
$data_selected_final = Samitiplanamountwithdrawdetails::find_by_plan_id($_GET['id']);
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
if(isset($_POST['submit']))
{
        //मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा 
        $data8=new Samitianalysisbasedwithdraw();

        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->evaluated_date=$_POST['evaluated_date'];
        $data8->evaluated_date_english= DateNepToEng($_POST['evaluated_date']);
        $data8->evaluated_amount=$_POST['evaluated_amount'];
        $data8->payable_amount=$_POST['payable_amount'];
        $data8->advance_payment=$_POST['advance_payment'];
        $data8->contengency_amount=$_POST['contengency_amount'];
        $data8->renovate_amount=$_POST['renovate_amount'];
        $data8->due_amount=$_POST['due_amount'];
        $data8->disaster_management_amount=$_POST['disaster_management_amount'];
        $data8->total_amount_deducted=$_POST['total_amount_deducted'];
        $data8->total_paid_amount = $_POST['total_paid_amount'];
        $data8->plan_id=$_POST['plan_id'];
        $data8->created_date=date("Y-m-d",time());
        $data8->save();
}

$value = "सेभ गर्नुहोस";
 $plan_selected = Plandetails1::find_by_id($_GET['id']);
 $total_investment = Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
$net_investment=0;
 if(!empty($total_investment))
 {
    $net_investment = $total_investment->agreement_gauplaika + $total_investment->agreement_other + $total_investment->costumer_agreement + $total_investment->other_agreement;
 }//echo $net_investment; exit;
 $advance = Samitiplanstartingfund::find_by_plan_id($_GET['id']);
 $inst_count = Samitianalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 $total_paid_amount = array();
 if(empty($advance))
 {
  $advance = Samitiplanstartingfund::setEmptyObjects();
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
                    <?php if(!empty($data_selected_final)): ?>
                    <h3 class="myheader">अन्तिम भुक्तानी भइ सकेको छ | <a href="plan_form5.php">विवरण हेर्नुहोस</a>   </h3>
                   
                   <?php  endif; ?>
                     <div>
                                 <h3>मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा</h3>
                                 <?php $net_payable_amount = $net_investment; if($inst_count>0):
                                     $inst_amount = array();
                                     $inst_payable_amount = array();
                                     $inst_selected = array();
                                     
                                 ?>
                                 <?php for($i=1; $i<=$inst_count; $i++): 
                                        $inst_data = Samitianalysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
                                        array_push($inst_amount, $inst_data->total_paid_amount);
                                        array_push($inst_selected, $inst_array[$i]);
                                        $net_payable_amount -= $inst_data->payable_amount;
                                     ?>
                                 
                                 <h3 class="myheader"><?=$inst_array[$i]?> भुक्तानी विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered table-responsive">
                                        
                                        <tr>
                                            <td>योजनाको मुल्यांकन किसिम</td>
                                            <td><?php echo $inst_array[$i]; ?></td>
                                        </tr>
                                        <tr>
                                <td width="176">योजनाको मुल्यांकन  मिती</td>
                                <td width="243"><?php echo convertedcit($inst_data->evaluated_date); ?></td>
                              </tr>
                               <tr>
                                <td width="176">योजनाको मुल्यांकन  रकम</td>
                                <td width="243"><?php echo convertedcit($inst_data->evaluated_amount); ?></td>
                              </tr>

                              <tr>
                                <td width="176">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><?php echo convertedcit($inst_data->payable_amount); ?></td>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                              <tr>
                                <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                <th>कन्टेन्जेन्सी  कट्टी रकम</th>
                                <th>मर्मत सम्हार कोष कट्टी रकम</th>
                                <th>धरौटी कट्टी रकम</th>
                                <th>विपद व्यबसथापन कोष कट्टी रकम</th>
                               </tr>
                               <tr>
                                <td><?php echo convertedcit($inst_data->advance_payment); ?></td>
                                <td><?php echo convertedcit($inst_data->contengency_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->renovate_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->due_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->disaster_management_amount); ?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo convertedcit($inst_data->total_amount_deducted); ?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo convertedcit($inst_data->total_paid_amount); ?></td>
                              </tr>
                       </table>
                     </div>
                         <?php 
                            $total_paid_amount[$i]=$inst_data->total_paid_amount;
                            $total_payable_amount[$i]=$inst_data->payable_amount;
                         ?>
                         <?php endfor; ?>        
                         <?php endif; ?>
                          <?php if(!empty($data_selected_final)){ exit;}?>
                          <h3><?=$inst_array[$inst_count+1]?> भुक्तानी भर्नुहोस्  </h3>
                          <form method="post" enctype="multipart/form_data" id="analysis_form" >
                             <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                                   
                                <table class="table table-bordered">
                                   <?php for($i=1; $i<=$inst_count; $i++): ?>
                                        <tr>
                                         <td width="176"><?=$inst_array[$i]?> भुक्तानी रकम</td>
                                         <td width="243"><input type="text" class="inst_amount" value="<?=$total_payable_amount[$i]?>" name="inst_amount[]" readonly="true" required/></td>
                                       </tr>
                              <?php endfor; ?> 
                                 <tr>
                                <td width="176">योजनाको मुल्यांकन किसिम</td>
                                <td width="243">
                                    <select name="payment_evaluation_count" id="payment_evaluation_count" required>
                                            <option value="<?=$inst_count+1?>"><?=$inst_array[$inst_count+1]?></option>
                                       </select>
                                </td>
                              </tr>
                               <tr>
                                <td width="176">भुक्तानी दिन बाकी रकम</td>
                                <td width="243" id="net_payable_amount"><?=$net_payable_amount?></td>
                              </tr>
                               <tr>
                                <td width="176">योजनाको मुल्यांकन  मिती</td>
                                <td width="243"><input type="text" name="evaluated_date" required id="nepaliDate3" /></td>
                              </tr>
                               <tr>
                                <td width="176">योजनाको मुल्यांकन  रकम</td>
                                <td width="243"><input type="text" name="evaluated_amount" required/></td>
                              </tr>
                              <tr>
                                <td width="176">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><input type="text" name="payable_amount" id="payable_amount" required/></td>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                              <tr>
                                <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                <th>कन्टेन्जेन्सी  कट्टी रकम</th>
                                <th>मर्मत सम्हार कोष कट्टी रकम</th>
                                <th>धरौटी कट्टी रकम</th>
                                <th>विपद व्यबसथापन कोष कट्टी रकम</th>
                               </tr>
                               <tr>
                                <td><input type="text" name="advance_payment" id="advance_payment" value="<?=$advance->advance?>" readonly="readonly" value="0" /></td>
                                <td><input type="text" name="contengency_amount" id="contengency_amount"  value="0" /></td>
                                <td><input type="text" name="renovate_amount" id="renovate_amount" value="0" /></td>
                                <td><input type="text" name="due_amount" id="due_amount" value="0" /></td>
                                <td><input type="text" name="disaster_management_amount" id="disaster_management_amount" value="0" /></td>
                              </tr>
                            </table>
                            <table class="table table-bordered"> 
                            <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><input type="text" id="total_amount_deducted" name="total_amount_deducted"/></td>
                              </tr>
                              <?php if($inst_count>0): ?>
                              <tr>
                                  <td>जम्मा किस्ता रकम ( <?= implode(" + ", $inst_selected)?> )</td>
                                <td><input type="text" value="<?= array_sum($inst_amount)?>" readonly="true" name="inst_amount"/></td>
                              </tr>
                              <?php endif; ?>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="total_paid_amount" id="total_paid_amount" /></td>
                              </tr>
                            </table></br></br>
                            <input type="hidden" name="costumer_agreement" id="costumer_agreement" value="<?php echo $total_investment->costumer_agreement;?>" />
                        <input type="submit" name="submit" onclick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस हालिएको  डेटा सच्याउन  मिल्दैन');" value="सेभ गर्नुहोस" class="submithere">
                                          
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
     <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>