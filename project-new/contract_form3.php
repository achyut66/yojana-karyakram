<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$setting =KattiWiwarn::find_all();
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$data_selected_final = Contractamountwithdrawdetails::find_by_plan_id($_GET['id']);
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
        $data8=new Contractanalysisbasedwithdraw();
        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->evaluated_date=$_POST['evaluated_date'];
        $data8->evaluated_date_english= DateNepToEng($_POST['evaluated_date']);
        $data8->evaluated_amount=$_POST['evaluated_amount'];
        $data8->payable_amount=$_POST['payable_amount'];
        $data8->advance_payment=$_POST['advance_payment'];
        $data8->renovate_amount=$_POST['renovate_amount'];
        $data8->due_amount=$_POST['due_amount'];
        $data8->disaster_management_amount=$_POST['disaster_management_amount'];
        $data8->total_amount_deducted=$_POST['total_amount_deducted'];
        $data8->total_paid_amount = $_POST['total_paid_amount'];
        $data8->plan_id=$_POST['plan_id'];
        $data8->created_date=$_POST['created_date'];
        $data8->created_date_english=DateNepToEng($_POST['created_date']);
        $data8->advance_rate = $_POST['advance_rate'];
        $data8->local_body_rate = $_POST['local_body_rate'];
        $data8->aaya_rate = $_POST['aaya_rate'];
        $data8->marmat_samhar_rate = $_POST['marmat_samhar_rate'];
        $data8->dharauti_rate = $_POST['dharauti_rate'];
        $data8->fine_rate = $_POST['fine_rate'];
        $data8->disaster_rate = $_POST['disaster_rate'];
        $data8->local_body_rate_amount = $_POST['local_body_rate_amount'];
        $data8->aaya_rate_amount = $_POST['aaya_rate_amount'];
        $data8->fine_rate_amount = $_POST['fine_rate_amount'];
        
        $data8->vat = $_POST['vat'];
        $data8->vat_amt = $_POST['vat_amt'];
        $data8->bipat_per = $_POST['bipat_per'];
        $data8->bipat = $_POST['bipat'];
        $data8->dharauti_per = $_POST['dharauti_per'];
        $data8->dharauti = $_POST['dharauti'];
        $data8->cont_per = $_POST['cont_per'];
        $data8->contingency = $_POST['contingency'];
        $data8->marmat_per = $_POST['marmat_per'];
        $data8->marmat = $_POST['marmat'];
        $data8->vat_per = $_POST['vat_per'];
        $data8->agrim_kar_per = $_POST['agrim_kar_per'];
        $data8->agrim_kar_amt = $_POST['agrim_kar_amt'];
        $data8->bahal_per = $_POST['bahal_per'];
        $data8->bahal_amt = $_POST['bahal_amt'];
        $data8->paris_per = $_POST['paris_per'];
        $data8->paris_amt = $_POST['paris_amt'];
        $data8->samajik_per = $_POST['samajik_per'];
        $data8->samajik_amt = $_POST['samajik_amt'];
        $data8->save();
        
           for($i=0;$i<count($_POST['katti']);$i++)
        {
             $data= new KattiDetails();
             $data->plan_id = $_POST['plan_id'];
             $data->payment_count = $_POST['payment_evaluation_count'];
             $data->created_date = $_POST['created_date'];
             $data->created_date_english = DateNepToEng($_POST['created_date']);
             $data->katti_id = $_POST['katti_id'][$i];
             $data->katti_amount = $_POST['katti'][$i];
             $data->type = 1;
             $data->save();
        }
}

$value = "सेभ गर्नुहोस";
 $plan_selected = Plandetails1::find_by_id($_GET['id']);
 $total_investment = Contract_total_investment::find_by_plan_id($_GET['id']);
// print_r($total_investment);exit;
 
 //print_r($total_investment); exit;
 //$net_investment = $total_investment->total_investment - $total_investment->costumer_investment;
 $net_investment = $total_investment->bhuktani_anudan;
 //echo $net_investment; exit;
 $advance = Contractstartingfund::find_by_plan_id($_GET['id']);
 $inst_count = Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 $total_paid_amount = array();
 if(empty($advance))
 {
  $advance = Planstartingfund::setEmptyObjects();
 }
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | <a href="contract_bhuktani_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <h2 class="headinguserprofile">योजनाको कुल भुक्तानी दिनु पर्ने रकम: रु <span id="net_investment"><?php echo convertedcit($net_investment); ?></span></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php if(!empty($data_selected_final)): ?>
                    <h3 class="myheader">अन्तिम भुक्तानी भइ सकेको छ | <a href="contract_final.php">विवरण हेर्नुहोस</a>   </h3>
                   
                   <?php  endif; ?>
                     <div>
                                 <h3>मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा</h3>
                                <?php 
                                if(!empty($inst_count))
                                            {
                                if($mode=="superadmin"){
                                            
                                    ?>
                                  <a onClick="return confirm('के तपाई डेटा हाटाउन चाहनुहुन्छ ?');" href="delete_contract_analysis_payment.php?plan_id=<?php echo $_GET['id'];?>" ><button class="btn">मुल्यांकन को आधारमा भुक्तानी हटाउनु होस्</button></a>
                                            <?php }} ?>
                                 <?php $net_payable_amount = $net_investment;
                                 $maramt_samhar_katti = Marmatsamhar::get_marmat_samhar_percent();
                                    $advance_amount = Contractanalysisbasedwithdraw::get_total_advance_amount($_GET['id']);
                                    $net_advancce_amount = $advance->advance - $advance_amount;
                                 if($inst_count>0):
                                     $inst_amount = array();
                                     $inst_payable_amount = array();
                                     $inst_selected = array();
                                     
                                 ?>
                                 <?php for($i=1; $i<=$inst_count; $i++): 
                                        $inst_data = Contractanalysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
                                        array_push($inst_amount, $inst_data->payable_amount);
                                        array_push($inst_selected, $inst_array[$i]);
                                        $net_payable_amount -= $inst_data->payable_amount;
                                         $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type_payment_count($_GET['id'],1,$i);
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
                                <td width="243"><?php echo convertedcit(placeholder($inst_data->evaluated_amount)); ?></td>
                              </tr>

                              <tr>
                                <td width="176">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><?php echo convertedcit(placeholder($inst_data->payable_amount)); ?></td>
                              </tr>
                              <tr>
                                <td width="176">पेश्की भुक्तानी प्रतिसत </td>
                                <td width="243"><?=convertedcit(placeholder($inst_data->advance_rate))?></td>
                              </tr>
                              <tr>
                                <td width="176">पेश्की भुक्तानी रकम</td>
                                <td width="243"><?=convertedcit(placeholder($inst_data->advance_payment))?></td>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                              <tr>
                                    <?php foreach($katti_bibaran_payment as $sa):?>
                                       <th><?=  KattiWiwarn::getName($sa->katti_id)?></th>
                                    <?php endforeach;?>
                               </tr>
                               <tr>
                                   <?php foreach($katti_bibaran_payment as $sa):?>
                                   <td><?= convertedcit($sa->katti_amount+0)?></td>
                                   <?php endforeach;?>
                               </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_amount_deducted)); ?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_paid_amount)); ?></td>
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
                              <?php endfor; 
                              $contract_result=Contractanalysisbasedwithdraw::find_by_payment_count(1,$_GET['id']);
                              if(empty($contract_result))
                              {
                                  $advance_taken = $advance->advance;
                              }
                              else{
                                  $advance_taken=0;
                              }
                                      
                              ?> 
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
                                <td width="176">योजनाको मुल्यांकन  रकम (भ्याट बाहेक)</td>
                                <td width="243"><input type="text" name="evaluated_amount" class="evaluated_amounts" id="evaluated_amounts" required/></td>
                              </tr>
                              <input type="hidden" name="payable_amount" id="payable_amounts" value="<?php echo convertedcit(placeholder($inst_data->evaluated_amount)); ?>"/>
                              <tr>
                                <td width="176">भुक्तानी दिनु पर्ने कुल रकम (भ्याट सहित)</td>
                                <td width="243"><input type="text" name="payable_amount_1" class="payable_amounts_1" id="payable_amounts_1" required/></td>
                              </tr>
                              <tr>
                               <td width="176">कन्टिनजेन्सि रकम </td>
                                <td width="243"><input type="text" name="contingency" id="contingency" value="0" /></td>
                              </tr>
                              <tr>
                               <td width="176">विपत व्यवस्थापन रकम </td>
                                <td width="243"><input type="text" name="bipat" id="bipat" value="0" /></td>
                              </tr>
                              <tr>
                               <td width="176">मर्मत रकम</label></td>
                                <td width="243"><input type="text" name="marmat" id="marmat" value="0" /></td>
                              </tr>
                              <tr>
                               <td width="176">पेश्की भुक्तानी प्रतिसत</td>
                                <td width="243"><input type="text" name="advance_rate" id="advance_rate"></td>
                              </tr>
                              <tr>
                               <td width="176">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td width="243"><input type="text" name="advance_payment" id="advance_payments"  readonly="readonly" value="0" /></td>
                              </tr>
                              <tr>
                               <td width="176">मुल्य अभिवृद्धि कर कट्टी रकम - <label>
                               <input style="border-color:red" type="text" name="vat" id="vat" size="4" placeholder="13%" readonly="true" /></label></td>
                                <td width="243"><input type="text" name="vat_amt" id="vat_amt" value="0" readonly="true" /></td>
                              </tr>
                              
                              <tr>
                               <td width="176">धरौटी कर कट्टी रकम  - <label>
                               <input style="border-color:red" type="text" name="dharauti_per" id="dharauti_per" size="4" placeholder="%" /></label></td>
                                <td width="243"><input type="text" name="dharauti" id="dharauti"  readonly="readonly" value="0" /></td>
                              </tr>
                              
                              <tr>
                               <td width="176">अग्रिम आय कर	  - <label>
                               <input style="border-color:red" type="text" name="agrim_kar_per" id="agrim_kar_per" size="4" placeholder="%" /></label></td>
                                <td width="243"><input type="text" name="agrim_kar_amt" id="agrim_kar_amt"  readonly="readonly" value="0" /></td>
                              </tr>
                              <!--<tr>-->
                              <!-- <td width="176">बहाल कर	- <label>-->
                              <!-- <input style="border-color:red" type="text" name="bahal_per" id="bahal_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="bahal_amt" id="bahal_amt"  readonly="readonly" value="0" /></td>-->
                              <!--</tr>-->
                              <!--<tr>-->
                              <!-- <td width="176">पारिश्रमीक कर कट्टी	- <label>-->
                              <!-- <input style="border-color:red" type="text" name="paris_per" id="paris_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="paris_amt" id="paris_amt"  readonly="readonly" value="0" /></td>-->
                              <!--</tr>-->
                              <!--<tr>-->
                              <!-- <td width="176">सामाजिक सुरक्षा कर  - <label>-->
                              <!-- <input style="border-color:red" type="text" name="samajik_per" id="samajik_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="samajik_amt" id="samajik_amt"  readonly="readonly" value="0" /></td>-->
                              <!--</tr>-->
                              <tr>
                                  <input type="hidden" name="jamma_katti" id = "jamma_katti" value=""/>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                                <tr><td>मूल्य अभिवृद्धि कर (६.५ %)</td>
                                <td><input type="text" id="vat_per" name="vat_per" value="" readonly="true"/></td>
                                </tr>
                            </table>
                            <table class="table table-bordered"> 
                            <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><input type="text" id="total_amount_deductedd" name="total_amount_deducted" value=""/></td>
                              </tr>
                              <?php if($inst_count>0): ?>
                              <tr>
                                  <td>जम्मा किस्ता रकम ( <?= implode(" + ", $inst_selected)?> )</td>
                                <td><input type="text" value="<?= array_sum($inst_amount)?>" readonly="true" name="inst_amount" /></td>
                              </tr>
                              <?php endif; ?>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="total_paid_amount" id="total_paid_amounts" /></td>
                              </tr>
                              <tr>
                                <td>मुल्यांकनको आधारमा भुक्तानी भएको मिति </td>
                                <td><input type="text" required name="created_date" id="nepaliDate9" readonly="true" value="<?=DateEngToNep(date("Y-m-d",time()))?>" /></td>
                              </tr>
                            </table></br></br>
                            <input type="hidden" id="contract_advance_amount" value="<?=$net_advancce_amount?>"
                            <input type="hidden" name="costumer_agreement" id="costumer_agreement" value="<?php echo $total_investment->costumer_agreement;?>" class="btn"/>
                        <input type="submit"  id="rakam_check" name="submit" onclick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस हालिएको  डेटा सच्याउन  मिल्दैन');" value="सेभ गर्नुहोस" class="btn">
                                          
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
     <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
     <script>
         JQ(document).ready(function(){
            JQ(document).on("input","#evaluated_amounts,#vat,#bipat_per,#dharauti_per,#cont_per,#marmat_per,#agrim_kar_per,#bahal_per,#paris_per,#samajik_per",function(){
                var mul_rak_with_vat = JQ("#evaluated_amounts").val() || 0;
                var mul_vat = parseFloat(mul_rak_with_vat)*13/100;
                var tot_mul = parseFloat(mul_rak_with_vat)+parseFloat(mul_vat);
                JQ("#payable_amounts_1").val(tot_mul);
                
                var vat_per = 13;
                var bipat_per = JQ("#bipat_per").val()||0;
                var dharauti_per = JQ("#dharauti_per").val()||0;
                var cont_per = JQ("#cont_per").val()||0;
                var marmat_per = JQ("#marmat_per").val()||0;
                
                var agrim_kar_per = JQ("#agrim_kar_per").val()||0;
                var bahal_per = JQ("#bahal_per").val()||0;
                var paris_per = JQ("#paris_per").val()||0;
                var samajik_per = JQ("#samajik_per").val()||0;
                
                
                var vat_rakam = parseFloat(mul_rak_with_vat)*vat_per/100;
                var bipat_rakam = JQ("#bipat").val()||0;
                var dharauti_rakam = parseFloat(mul_rak_with_vat)*dharauti_per/100;
                var cont_rakam = JQ("#contingency").val()||0;
                var marmat_rakam = JQ("#marmat").val()||0;
                var muakar = parseFloat(vat_rakam)*50/100;
                
                var agrim_kar_amt = parseFloat(mul_rak_with_vat)*agrim_kar_per/100;
                var bahal_amt = parseFloat(mul_rak_with_vat)*bahal_per/100;
                var paris_amt = parseFloat(mul_rak_with_vat)*paris_per/100;
                var samajik_amt = parseFloat(mul_rak_with_vat)*samajik_per/100;
                
                
                var total_katti_1 = vat_rakam+bipat_rakam+dharauti_rakam+cont_rakam+marmat_rakam;
                
                JQ("#vat_amt").val(vat_rakam);
                JQ("#bipat").val(bipat_rakam);
                JQ("#dharauti").val(dharauti_rakam);
                JQ("#contingency").val(cont_rakam);
                JQ("#marmat").val(marmat_rakam);
                
                JQ("#agrim_kar_amt").val(agrim_kar_amt);
                JQ("#bahal_amt").val(bahal_amt);
                JQ("#paris_amt").val(paris_amt);
                JQ("#samajik_amt").val(samajik_amt);
                
                JQ("#vat_per").val(muakar);
                JQ("#jamma_katti").val(total_katti_1);
            
            });
    JQ(document).on("click","#total_amount_deductedd",function(){
                
                var mul_rak_with_vat = JQ("#evaluated_amounts").val() || 0;
                var mul_vat = parseFloat(mul_rak_with_vat)*13/100;
                var tot_mul = parseFloat(mul_rak_with_vat)+parseFloat(mul_vat);
                //console.log(tot_mul);
                //JQ("#payable_amounts").val(tot_mul);
                
                var vat_per = JQ("#vat").val()||0;
                var bipat_per = JQ("#bipat_per").val()||0;
                var dharauti_per = JQ("#dharauti_per").val()||0;
                var cont_per = JQ("#cont_per").val()||0;
                var marmat_per = JQ("#marmat_per").val()||0;
                
                var agrim_kar_per = JQ("#agrim_kar_per").val()||0;
                var bahal_per = JQ("#bahal_per").val()||0;
                var paris_per = JQ("#paris_per").val()||0;
                var samajik_per = JQ("#samajik_per").val()||0;
                var vat_half    = JQ("#vat_per").val()||0;
                
                
                var vat_rakam = parseFloat(mul_rak_with_vat)*vat_per/100;
                var bipat_rakam = parseFloat(mul_rak_with_vat)*bipat_per/100;
                var dharauti_rakam = parseFloat(mul_rak_with_vat)*dharauti_per/100;
                var cont_rakam = parseFloat(mul_rak_with_vat)*cont_per/100;
                var marmat_rakam = parseFloat(mul_rak_with_vat)*marmat_per/100;
                var muakar = parseFloat(vat_rakam)*50/100;
                
                var agrim_kar_amt = parseFloat(mul_rak_with_vat)*agrim_kar_per/100;
                var bahal_amt = parseFloat(mul_rak_with_vat)*bahal_per/100;
                var paris_amt = parseFloat(mul_rak_with_vat)*paris_per/100;
                var samajik_amt = parseFloat(mul_rak_with_vat)*samajik_per/100;
                
                
                var total_katti_1 = parseFloat(vat_half)+bipat_rakam+dharauti_rakam+cont_rakam+marmat_rakam+agrim_kar_amt+bahal_amt+paris_amt+samajik_amt;
                //console.log(total_katti_1);
       
                //var total_amt_deduct = JQ("#total_amount_deductedd").val()||0;
                console.log(total_amt_deduct);
                var total_amt_deduct = parseFloat(total_amt_deduct).toFixed(2);
                var vat_per_val = JQ("#vat_per").val();
                var tt1 = parseFloat(total_katti_1);
                var tt1 = tt1.toFixed(2);
                //console.log(tt1);
                JQ("#total_amount_deductedd").val(tt1);
                
                var total_paid_amounts = parseFloat(tot_mul)-parseFloat(tt1);
                var total_paid_amounts = total_paid_amounts.toFixed(2);
                JQ("#total_paid_amounts").val(total_paid_amounts);
       
       //alert("string"); 
    });
});
     </script>