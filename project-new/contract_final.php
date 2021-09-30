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
  
//योजना भुक्तानी सम्बन्धी विवरण   
     if(strtotime(DateNepToEng($_POST['plan_end_date'])) >  strtotime(DateNepToEng($_POST['yojana_sakine_date'])))
     {     
         
         $msg="योजना  सम्पन्न समयमा हुन नसकेको कारणले पुनः म्याद थप गरि आउनु होला ";
         $link="contract_additionaldate.php?msg=".$msg."&id=".$_POST['plan_id'];
         redirect_to($link);
         return false;
     }
        $data = new Contractamountwithdrawdetails();
        $data->plan_end_date = $_POST['plan_end_date'];
        $data->yojana_sakine_date=$_POST['yojana_sakine_date'];
        $data->yojana_sakine_date_english=  DateNepToEng($_POST['yojana_sakine_date']);
        $data->plan_evaluated_date=$_POST['plan_evaluated_date'];
        $data->plan_evaluated_date_english = DateNepToEng($_POST['plan_evaluated_date']);
        $data->plan_evaluated_amount=$_POST['plan_evaluated_amount'];
        $data->final_payable_amount=$_POST['final_payable_amount'];
        $data->payment_till_now=$_POST['payment_till_now'];
        $data->advance_payment=$_POST['advance_payment'];
        $data->remaining_payment_amount=$_POST['remaining_payment_amount'];
        $data->final_renovate_amount=$_POST['final_renovate_amount'];
        $data->final_due_amount=$_POST['final_due_amount'];
        $data->final_disaster_management_amount=$_POST['final_disaster_management_amount'];
        $data->final_total_amount_deducted=$_POST['final_total_amount_deducted'];
        $data->final_total_paid_amount=$_POST['final_total_paid_amount'];
        $data->plan_id=$_POST['plan_id'];
        $data->created_date=$_POST['created_date'];
        $data->created_date_english=DateNepToEng($_POST['created_date']);
        
        $data->vat = $_POST['vat'];
        $data->vat_amt = $_POST['vat_amt'];
        $data->bipat_per = $_POST['bipat_per'];
        $data->bipat = $_POST['bipat'];
        $data->dharauti_per = $_POST['dharauti_per'];
        $data->dharauti = $_POST['dharauti'];
        $data->cont_per = $_POST['cont_per'];
        $data->contingency = $_POST['contingency'];
        $data->marmat_per = $_POST['marmat_per'];
        $data->marmat = $_POST['marmat'];
        $data->vat_per = $_POST['vat_per'];
        $data->agrim_kar_per = $_POST['agrim_kar_per'];
        $data->agrim_kar_amt = $_POST['agrim_kar_amt'];
        $data->bahal_per = $_POST['bahal_per'];
        $data->bahal_amt = $_POST['bahal_amt'];
        $data->paris_per = $_POST['paris_per'];
        $data->paris_amt = $_POST['paris_amt'];
        $data->samajik_per = $_POST['samajik_per'];
        $data->samajik_amt = $_POST['samajik_amt'];
        $data->save();
        
          for($i=0;$i<count($_POST['katti']);$i++)
        {
             $data= new KattiDetails();
             $data->plan_id = $_POST['plan_id'];
             $data->created_date = $_POST['created_date'];
             $data->created_date_english = DateNepToEng($_POST['created_date']);
             $data->katti_id = $_POST['katti_id'][$i];
             $data->katti_amount = $_POST['katti'][$i];
             $data->type = 2;
             $data->save();
        }
        echo alertBox("भुक्तानी गर्न सफल ","contract_final.php");
        

}
 
$data_selected_final = Contractamountwithdrawdetails::find_by_plan_id($_GET['id']); 
//print_r($data_selected_final);
$plan_selected = Plandetails1::find_by_id($_GET['id']);
 $total_investment = Contract_total_investment::find_by_plan_id($_GET['id']);
 //$net_investment = $total_investment->total_investment - $total_investment->costumer_investment;
 $net_investment = $total_investment->bhuktani_anudan;
 $advance = Contractstartingfund::find_by_plan_id($_GET['id']);
 $inst_count = Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 $total_paid_amount = array();
 if(empty($advance))
 {
   $advance = Contractstartingfund::setEmptyObjects();
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
 $inst_data = Contractanalysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
   array_push($inst_amount, $inst_data->total_paid_amount);
   array_push($payable_amount, $inst_data->total_paid_amount);
   array_push($inst_selected, $inst_array[$i]);
   $net_payable_amount -= $inst_data->payable_amount;
  endfor;
  endif;
   ?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> || <a href="contract_bhuktani_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            <h2 class="headinguserprofile">योजनाको कुल भुक्तानी दिनु पर्ने रकम: रु <span id="net_investment"><?php echo convertedcit(placeholder($net_investment)); ?></span></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                     <?php if(!empty($data_selected_final)):
                               $katti_bibaran_payment = KattiDetails::find_by_sql("select * from katti_details where type=2 and plan_id=".$_GET['id']);
                            
                             ?>
                      
 
                    <div>
                               <h3>योजनाको अन्तिम भुक्तानी </h3>
                            <table  id="plan_amount_withdraw" class="table table-bordered">
                                    <tr>
                                <td>योजना सम्पन्न हुने मिति</td>
                                <td><?=convertedcit($data_selected_final->yojana_sakine_date);?></td>
                              </tr>
                             <tr>
                                <td>योजनाको काम सम्पन्न भएको मिति</td>
                                <td><?=convertedcit($data_selected_final->plan_end_date)?></td>
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
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_renovate_amount)?></td>
                              </tr>
                             </tr>
                              <?php foreach($katti_bibaran_payment as $sa):?>
                              <tr><td  class="myTextalignLeft"><?=  KattiWiwarn::getName($sa->katti_id)?></td>
                                  <td><?= convertedcit($sa->katti_amount+0)?></td></tr>
                               <?php endforeach;?>
                              <tr>
                              <tr>
                                <td>काम घटी कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_disaster_management_amount)?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?=convertedcit($data_selected_final->final_total_amount_deducted)?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?=convertedcit($data_selected_final->final_total_paid_amount)?></td>
                              </tr>
                             </table>
                              </div>
                    <?php endif; ?>
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);
                    $datas=Contract_total_investment::find_by_plan_id($_GET['id']);
                    $add=$datas->bhuktani_anudan;
                    //print_r($add);
                    $final_result=Contractanalysisbasedwithdraw::find_by_plan_id($_GET['id']);
                    //print_r($final_result);
                    if(empty($final_result))
                    {
                      $net_total_payable_amount=$add-$advance->advance;
                    }
                    else
                    {
                        $net_total_payable_amount=$add-array_sum($payable_amount);
                    }?>
                     <div <?php if(!empty($data_selected_final)): ?> style="display:none;" <?php endif; ?>>
                            <form method="post" enctype="multipart/form-data" >
                               <h3>योजनाको अन्तिम भुक्तानी </h3>
                            <table  id="plan_amount_withdraw" class="table table-bordered">
                              <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                                   
                            <tr>
                                <td>योजना सम्पन्न हुने मिति</td>
                                <td><input type="text" name="yojana_sakine_date" value="<?=getcontractcompletiondate($_GET['id']);?>" readonly="true"</td>
                              </tr>
                             <tr>
                                <td width="178">योजनाको काम सम्पन्न भएको मिति</td>
                                <td width="190"><input type="text" name="plan_end_date" id="nepaliDate5"/></td>
                              </tr>
                             
                              <tr>
                                <td>योजनाको मुल्यांकन मिति</td>
                                <td><input type="text" name="plan_evaluated_date" id="nepaliDate12"/></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम (भ्याट बाहेक)</td>
                                <td><input type="text" id="plan_evaluated_amount" name="plan_evaluated_amount"/></td>
                              </tr>
                               <tr>
                                <td width="176"> भुक्तानी दिनु पर्ने कुल रकम (भ्याट सहित)</td>
                                <td width="243"><input style="text-align:left;"  type="text" name="final_payable_amount" id="final_payable_amounts" value="<?php echo $add;?>"/></td>
                              </tr>
                              <tr>
                               <td width="176">कन्टिनजेन्सि कट्टी रकम 
                               </td>
                                <td width="243"><input type="text" name="contingency" id="contingency" value="0" style="text-align:left;" /></td>
                              </tr>
                              <tr>
                               <td width="176">मर्मत कट्टी रकम 
                               </td>
                                <td width="243"><input type="text" name="marmat" id="marmat" value="0" style="text-align:left;" /></td>
                              </tr>
                              <tr>
                               <td width="176">विपत व्यवस्थापन कर कट्टी रकम 
                               </td>
                                <td width="243"><input type="text" name="bipat" id="bipat" value="0" style="text-align:left;" /></td>
                              </tr>
                               <tr>
                                <td width="176"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></td>
                                <td width="243"><input type="text" name="payment_till_now" id="payment_till_nows" readonly="true" value="<?=array_sum($payable_amount)?>" style="text-align:left;"/></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><input type="text" name="advance_payment" id="advance_paymentss" readonly="true" value="<?=$advance->advance?>" style="text-align:left;"/></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम</td>
                                <td><input type="text" id="remaining_payment_amount" name="remaining_payment_amount" class="remaining_sample" readonly="true" value="<?=$net_total_payable_amount?>" style="text-align:left;"/></td>
                              </tr>
                              <tr>
                               <td width="176">मुल्य अभिबृधि कर कट्टी रकम - <label>
                               <input style="border-color:red" type="text" name="vat_per" id="vat_per" size="4" placeholder="13%" readonly="true" /></label></td>
                                <td width="243"><input type="text" name="vat_amt" id="vat_amt" value="0" style="text-align:left;" readonly="true" /></td>
                              </tr>
                              
                              <tr>
                               <td width="176">धरौटी कर कट्टी रकम  - <label>
                               <input style="border-color:red" type="text" name="dharauti_per" id="dharauti_per" size="4" placeholder="%" /></label></td>
                                <td width="243"><input type="text" name="dharauti" id="dharauti"  readonly="readonly" value="0" style="text-align:left;" /></td>
                              </tr>
                              
                               <tr>
                               <td width="176">अग्रिम आय कर	  - <label>
                               <input style="border-color:red" type="text" name="agrim_kar_per" id="agrim_kar_per" size="4" placeholder="%" /></label></td>
                                <td width="243"><input type="text" name="agrim_kar_amt" id="agrim_kar_amt"  readonly="readonly" value="0" style="text-align:left;" /></td>
                              </tr>
                              <!--<tr>-->
                              <!-- <td width="176">बहाल कर	- <label>-->
                              <!-- <input style="border-color:red" type="text" name="bahal_per" id="bahal_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="bahal_amt" id="bahal_amt"  readonly="readonly" value="0" style="text-align:right;" /></td>-->
                              <!--</tr>-->
                              <!--<tr>-->
                              <!-- <td width="176">पारिश्रमीक कर कट्टी	- <label>-->
                              <!-- <input style="border-color:red" type="text" name="paris_per" id="paris_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="paris_amt" id="paris_amt"  readonly="readonly" value="0" style="text-align:right;" /></td>-->
                              <!--</tr>-->
                              <!--<tr>-->
                              <!-- <td width="176">सामाजिक सुरक्षा कर  - <label>-->
                              <!-- <input style="border-color:red" type="text" name="samajik_per" id="samajik_per" size="4" placeholder="%" /></label></td>-->
                              <!--  <td width="243"><input type="text" name="samajik_amt" id="samajik_amt"  readonly="readonly" value="0" style="text-align:right;" /></td>-->
                              <!--</tr>-->
                              <tr>
                               <td width="176">मुल्य अभिवृद्धि कर (६.५%)  - <label>
                               <input style="border-color:red" type="text" name="half_vat" id="half_vat" size="4" placeholder="6.5%" value="6.5" readonly="true" /></label></td>
                                <td width="243"><input type="text" name="half_vat_amt" id="half_vat_amt"  readonly="readonly" value="0" style="text-align:left;" /></td>
                              </tr>
                                <td>काम घटी कट्टी रकम</td>
                                <td><input type="text" name="final_disaster_management_amount"  class="disaster_one" id="disaster_one"  value="0" style="text-align:left;"/></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><input type="text" name="final_total_amount_deducted"  class="deducted_amount" id="final_deducted_one" value="0" readonly="true" style="text-align:left;"/></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="final_total_paid_amount" id="total_sample" value="<?=$net_total_payable_amount?>" readonly="true" value="0" style="text-align:left;" /></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी भएको मिति </td>
                                <td><input type="text" name="created_date" id="nepaliDate9" value="<?=DateEngToNep(date("Y-m-d",time()))?>" style="text-align:left;" readonly="true"/></td>
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
 <script>
     JQ(document).ready(function(){
        JQ(document).on("input","#plan_evaluated_amount,#vat_per,#dharauti_per,#bipat_per,#cont_per,#marmat_per,#agrim_kar_per,#bahal_per,#paris_per,#samajik_per",function(){
           var plan_evaluated_amount = JQ("#plan_evaluated_amount").val() ||0;
           var plan_evaluated_amount_tax = parseFloat(plan_evaluated_amount)*13/100;
           var after_tax_amount = parseFloat(plan_evaluated_amount)+plan_evaluated_amount_tax;
           var final_payable_amounts = JQ("#final_payable_amounts").val();
           
           var vat_per = 13;
           var bipat_per = JQ("#bipat_per").val();
           var dharauti_per = JQ("#dharauti_per").val();
           var cont_per = JQ("#cont_per").val();
           var marmat_per = JQ("#marmat_per").val();
           
          var agrim_kar_per = JQ("#agrim_kar_per").val()||0;
          var bahal_per = JQ("#bahal_per").val()||0;
          var paris_per = JQ("#paris_per").val()||0;
          var samajik_per = JQ("#samajik_per").val()||0;
          var half_vat = JQ("#half_vat").val()||0;
           
            var vat_amt = parseFloat(plan_evaluated_amount)*vat_per/100;
            var bipat_amt = JQ("#bipat").val()||0;
            var dharauti_amt = parseFloat(plan_evaluated_amount)*dharauti_per/100;
            var cont_amt = JQ("#contingency").val()||0;
            var marmat_amt = JQ("#marmat").val()||0;
            var agrim_kar_amt = parseFloat(plan_evaluated_amount)*agrim_kar_per/100;
            var bahal_amt = parseFloat(plan_evaluated_amount)*bahal_per/100;
            var paris_amt = parseFloat(plan_evaluated_amount)*paris_per/100;
            var samajik_amt = parseFloat(plan_evaluated_amount)*samajik_per/100;
            var half_vat_amt = parseFloat(plan_evaluated_amount)*half_vat/100;
            
           
               JQ("#vat_amt").val(vat_amt)||0;
               JQ("#bipat").val(bipat_amt)||0;
               JQ("#dharauti").val(dharauti_amt)||0;
               JQ("#contingency").val(cont_amt)||0;
               JQ("#marmat").val(marmat_amt)||0;
               JQ("#final_payable_amounts").val(after_tax_amount);
               JQ("#half_vat_amt").val(half_vat_amt);
           
                JQ("#agrim_kar_amt").val(agrim_kar_amt);
                JQ("#bahal_amt").val(bahal_amt);
                JQ("#paris_amt").val(paris_amt);
                JQ("#samajik_amt").val(samajik_amt);
     
           var ghati_katti = JQ("#remaining_payment_amount").val();
           
          var kaam_ghati_katti = (parseFloat(ghati_katti)-plan_evaluated_amount).toFixed(2);
          JQ("#disaster_one").val(kaam_ghati_katti);
           
          var total_sum_katti = parseFloat(half_vat_amt) + parseFloat(dharauti_amt) + parseFloat(agrim_kar_amt);
          JQ("#final_deducted_one").val(total_sum_katti);
           
          var total_sample = (parseFloat(final_payable_amounts)-parseFloat(total_sum_katti)).toFixed(2);
          JQ("#total_sample").val(total_sample);
    });
});
 </script>