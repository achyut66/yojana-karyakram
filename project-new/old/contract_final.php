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
        $data->plan_evaluated_amount_without_vat=$_POST['plan_evaluated_amount_without_vat'];
        $data->vat_per=$_POST['vat_per'];
        $data->vat_amount=$_POST['vat_amount'];
        $data->vat=$_POST['vat'];
        $data->tds_per=$_POST['tds_per'];
        $data->tds=$_POST['tds'];
        $data->reten_per=$_POST['reten_per'];
        $data->retention=$_POST['retention'];
        $data8->created_date=$_POST['created_date'];
        $data8->created_date_english=DateNepToEng($_POST['created_date']);
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
   array_push($payable_amount, $inst_data->payable_amount);
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
            		 <?php if(!empty($data_selected_final)):?>
            		 <a href="contract_final_delete.php?id=<?=$data_selected_final->plan_id ?>" class="btn btn-info">अन्तिम भुक्तानी विवरण हटाउनुहोस्</a>
                             <?php  $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type($_GET['id'],2);
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
                                <td>भ्याट बाहेकको मुल्यांकन रकम </td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_amount_without_vat)?></td>
                              </tr>
                              <tr>
                                 <td>भ्याट रकम (१३%)</td>
                                <td><?=convertedcit($data_selected_final->vat_amount)?></td> 
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम</td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_amount)?></td>
                              </tr>
                              <tr>
                                <td>भ्याट (६.५ %)</td>
                                <td><?=convertedcit($data_selected_final->vat)?></td>
                              </tr>
                              <tr>
                                <td>TDS (१.५ %)</td>
                                <td><?=convertedcit($data_selected_final->tds)?></td>
                              </tr>
                              <tr>
                                <td>Retention Amount (५ %)</td>
                                <td><?=convertedcit($data_selected_final->retention)?></td>
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
                    $final_result=Contractanalysisbasedwithdraw::find_by_plan_id($_GET['id']);
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
                                <td>भ्याट बाहेकको मुल्यांकन रकम </td>
                                <td><input type="text" id="plan_evaluated_amount_without_vat" name="plan_evaluated_amount_without_vat"/></td>
                              </tr>
                              <tr>
                                <td>भ्याट रकम (13%) </td>
                                <td><input type="text" id="vat_amount" name="vat_amount" readonly="true" /></td> 
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम</td>
                                <td><input type="text" id="plan_evaluated_amount" name="plan_evaluated_amount" readonly="true" /></td>
                              </tr>
                              <tr>
                                <td>भ्याट (६.५ %)
                                <label><input type="text" style="width: 50px; border-color:red;" name="vat_per" id="vat_per"></label> </td>
                                <td><input type="text" id="vat" name="vat" readonly="true" /></td> 
                              </tr>
                              <tr>
                                <td>TDS (१.५ %) <label><input type="text" style="width: 50px; border-color:red;" name="tds_per" id="tds_per"/></label> </td>
                                <td><input type="text" id="tds" name="tds" readonly="true"/></td> 
                              </tr>
                              <tr>
                                <td>Retention Amount (५ %) <label><input type="text" name="reten_per" style="width: 50px; border-color:red;" id="reten_per"/></label> </td>
                                <td><input type="text" id="retention" name="retention" readonly="true"/></td>  
                              </tr>
                               <tr>
                                <td width="176"> भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><input style="text-align:right;"  type="text" name="final_payable_amount" id="final_payable_amounts" value="<?php echo $add;?>"/></td>
                              </tr>
                               <tr>
                                <td width="176"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></td>
                                <td width="243"><input type="text" name="payment_till_now" id="payment_till_nows" readonly="true" value="<?=array_sum($payable_amount)?>" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><input type="text" name="advance_payment" id="advance_paymentss" readonly="true" value="<?=$advance->advance?>" style="text-align:right;"/></td>
                              </tr>
                              <!--<tr>-->
                              <!--  <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम</td>-->
                              <!--  <td><input type="text" name="remaining_payment_amount" class="remaining_sample" readonly="true" value="<?=$net_total_payable_amount?>" style="text-align:right;"/></td>-->
                              <!--</tr>-->
                              
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><input type="text" name="final_renovate_amount" class="final_one" id="final_one" value="0" style="text-align:right;" /></td>
                              </tr>
                             <?php $i=1; foreach($setting as $s):?>
                              <tr>
                                <td><?=$s->topic?></td>
                                <td><input type="text" name="katti[]" style="text-align:right;" id="katti_<?=$i?>"/><input type="hidden" value="<?=$s->percent?>" name="katti_percent[]" id="katti_percent_<?=$i?>"/>
                                <input type="hidden" value="<?=$s->id?>" name="katti_id[]" /></td>
                              </tr>
                               <?php $i++; endforeach;?>
                              <tr>
                                <td>काम घटी कट्टी रकम</td>
                                <td><input type="text" name="final_disaster_management_amount"  readonly="true" class="disaster_one" id="disaster_one"  value="0" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><input type="text" name="final_total_amount_deducted"  class="deducted_amount" id="final_deducted_one" value="0" readonly="true" style="text-align:right;"/></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="final_total_paid_amount" id="total_sample" value="<?=$net_total_payable_amount?>" readonly="true" value="0" style="text-align:right;" /></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी भएको मिति </td>
                                <td><input type="text" name="created_date" id="nepaliDate9" value="<?=DateEngToNep(date("Y-m-d",time()))?>" style="text-align:right;" readonly="true"/></td>
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
       JQ(document).on("input","#plan_evaluated_amount_without_vat,#reten_per,#vat_per,#tds_per,#katti_1",function(){
           //alert("here");
           var plan_amt = JQ('#plan_evaluated_amount_without_vat').val();
           var vat_rakam = parseFloat(plan_amt)*13/100;
           var vat_rakam = parseFloat(vat_rakam).toFixed(2);
           JQ('#vat_amount').val(vat_rakam) || 0;
           var evaluated_amt = parseFloat(plan_amt)+parseFloat(vat_rakam);
           var evaluated_amt = parseFloat(evaluated_amt).toFixed(2);
           JQ("#plan_evaluated_amount").val(evaluated_amt) || 0;
           var vat_per = JQ("#vat_per").val();
           var tds_per = JQ("#tds_per").val();
           var reten_per = JQ("#reten_per").val();
           var vat_rakam = parseFloat(plan_amt)*vat_per/100;
           var vat_rakam = parseFloat(vat_rakam).toFixed(2);
           var tds_rakam = parseFloat(plan_amt)*tds_per/100;
           var tds_rakam = parseFloat(tds_rakam).toFixed(2);
           var reten_rakam = parseFloat(plan_amt)*reten_per/100;
           var reten_rakam = parseFloat(reten_rakam).toFixed(2);
           JQ("#vat").val(vat_rakam) || 0;
           JQ("#tds").val(tds_rakam) || 0;
           JQ("#retention").val(reten_rakam) || 0;
           var final_payable_amt = JQ("#final_payable_amounts").val();
           var disaster = parseFloat(final_payable_amt)-parseFloat(plan_amt);
           var disaster = parseFloat(disaster).toFixed(2);
           JQ("#disaster_one").val(disaster) || 0;
           var katti = JQ("#katti_1").val();
           var final_deducted = parseFloat(vat_rakam)+parseFloat(tds_rakam)+parseFloat(reten_rakam)+parseFloat(katti);
           JQ("#final_deducted_one").val(final_deducted);
           var total_bhuktani = parseFloat(evaluated_amt)-parseFloat(final_deducted);
           JQ("#total_sample").val(total_bhuktani);
         
       }); 
     });
 </script>