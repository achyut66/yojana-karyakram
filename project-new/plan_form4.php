<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
error_reporting(1);
$setting =KattiWiwarn::find_all();
//get_access_form($_GET['id']);
$mode=getUserMode();
$units = Units::find_all();
$settingbhautikPariman = SettingbhautikPariman::find_all();
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$data_selected_final = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
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
     for($i=0;$i<count($_POST['qty']);$i++)
        {
            $detail = new Bhautik_lakshya();
            $detail->details_id = $_POST['details_id'][$i];
            $detail->prev_qty = $_POST['prev_qty'][$i];
            $detail->qty = $_POST['qty'][$i];
            $detail->unit_id = $_POST['unit_id'][$i];
            $detail->plan_id = $_POST['plan_id'];
            $detail->payment_count = $_POST['payment_evaluation_count'];
            $detail->type = 2;
            $detail->miti=$_POST['created_date'];
            $detail->miti_english=DateNepToEng($_POST['created_date']);
            $detail->save();
        }
        
        $data8=new Analysisbasedwithdraw();
        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->evaluated_date=$_POST['evaluated_date'];
        $data8->evaluated_date_english= DateNepToEng($_POST['evaluated_date']);
        $data8->evaluated_amount=$_POST['evaluated_amount'];
        $data8->payable_amount=$_POST['payable_amount'];
        $data8->advance_payment=$_POST['advance_payment'];
        $data8->contengency_amount=$_POST['contengency_amount'];
        $data8->renovate_amount=$_POST['renovate_amount'];
        $data8->dpr_amount=$_POST['dpr_amount'];
        $data8->due_amount=$_POST['due_amount'];
        $data8->janshramdan=$_POST['janshramdan'];
        $data8->disaster_management_amount=$_POST['disaster_management_amount'];
        $data8->total_amount_deducted=$_POST['total_amount_deducted'];
        $data8->total_paid_amount = $_POST['total_paid_amount'];
        $data8->plan_id=$_POST['plan_id'];
        $data8->created_date=$_POST['created_date'];
        $data8->created_date_english=DateNepToEng($_POST['created_date']);
        $data8->agreement_gauplaika_calc = $_POST['agreement_gauplaika_calc'];
        $data8->agreement_other_calc     = $_POST['agreement_other_calc'];
        $data8->other_agreement_calc     = $_POST['other_agreement_calc'];
        $data8->customer_agreement_calc  = $_POST['customer_agreement_calc'];
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
         for($i=0;$i<count($_POST['topic']);$i++)
        {
            $kar_bibran = new Kar_Bibran();
            $kar_bibran->darta_id = $_GET['id'];
            $kar_bibran->kar_rakam = $_POST['karrakam'][$i];
            $kar_bibran->kar_percent = $_POST['precent'][$i];
            $kar_bibran->total_kar_amount = $_POST['total_amt'][$i];
            $kar_bibran->kar_topic = $_POST['topic'][$i];
            $kar_bibran->save();
        }
}
$plan_total_amount = Plantotalinvestment::find_by_plan_id($_GET['id']);
//print_r($plan_total_amount);
 $value = "सेभ गर्नुहोस";
 $plan_selected = Plandetails1::find_by_id($_GET['id']);
 $samiti_plan_total = Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
  $total_investment = Plantotalinvestment::find_by_plan_id($_GET['id']);
//  print_r($total_investment);exit;
 if(!empty($total_investment))
 {
    $net_investment = $total_investment->agreement_gauplaika + $total_investment->agreement_other+ $total_investment->other_agreement;
    $customer  = $total_investment->costumer_agreement;
    $link="bhuktani_select.php";
    $estimated_amount = $total_investment->total_investment;
    if(!empty($plan_total_amount->marmat_new)){
       $karyadesh_amount= $total_investment->bhuktani_anudan + $plan_total_amount->marmat_new; 
    }else{
       $karyadesh_amount= $total_investment->bhuktani_anudan; 
    }
    //print_r($karyadesh_amount);
    // for hidden fields to acquire while calculating
    $lakshya = $total_investment->unit_total;
    $unit_id = $total_investment->unit_id;
    $hid_agreement_gauplaika = $total_investment->agreement_gauplaika;
    $hid_agreement_other = $total_investment->agreement_other;
    $hid_other_agreement = $total_investment->other_agreement;
    $hid_costumer_agreement = $total_investment->costumer_agreement;
    $hid_janashramdhan = $total_investment->costumer_investment;
 }
 elseif(!empty($samiti_plan_total))
 {
       $net_investment = $samiti_plan_total->agreement_gauplaika + $samiti_plan_total->agreement_other  + $samiti_plan_total->other_agreement;
       $customer  = $samiti_plan_total->costumer_agreement;
       $link="samiti_bhuktani_select.php";
       $estimated_amount = $samiti_plan_total->total_investment;
       $karyadesh_amount= $samiti_plan_total->bhuktani_anudan;
        
        $lakshya = $samiti_plan_total->unit_total;
        $unit_id = $samiti_plan_total->unit_id;
        $hid_agreement_gauplaika = $samiti_plan_total->agreement_gauplaika;
        $hid_agreement_other = $samiti_plan_total->agreement_other;
        $hid_other_agreement = $samiti_plan_total->other_agreement;
        $hid_costumer_agreement = $samiti_plan_total->costumer_agreement;
        $hid_janashramdhan = $samiti_plan_total->costumer_investment;
 }
 else
 {
    $amanat_lagat = AmanatLagat::find_by_plan_id($_GET['id']);
    $net_investment = $amanat_lagat->agreement_gauplaika + $amanat_lagat->agreement_other+ $amanat_lagat->other_agreement;
    $customer  = $amanat_lagat->costumer_agreement;
    $estimated_amount = $amanat_lagat->total_investment;
    $karyadesh_amount= $amanat_lagat->bhuktani_anudan;
    
     $lakshya = $amanat_lagat->unit_total;
    $unit_id = $amanat_lagat->unit_id;
    $hid_agreement_gauplaika = $amanat_lagat->agreement_gauplaika;
    $hid_agreement_other = $amanat_lagat->agreement_other;
    $hid_other_agreement = $amanat_lagat->other_agreement;
    $hid_costumer_agreement = $amanat_lagat->costumer_agreement;
    $hid_janashramdhan = $amanat_lagat->costumer_investment;
    
    $link = "amanat_bhuktani_dashboard.php";
 }

 $advance = Planstartingfund::find_by_plan_id($_GET['id']);
 $inst_count = Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 $total_paid_amount = array();
 if(empty($advance))
 {
  $advance = Planstartingfund::setEmptyObjects();
 }
 if($inst_count > 0)
 {
     $advance_amount = 0;
 }
 else
 {
     $advance_amount = $advance->advance;
 }
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | दर्ता न :<?=convertedcit($_GET['id'])?> | <a href="<?=$link?>" class="btn">पछि जानुहोस</a></h2>
            <h2 class="headinguserprofile">योजनाको कुल भुक्तानी दिनु पर्ने रकम: रु <span id="net_investment"><?php echo convertedcit($net_investment); ?></span></h2>
            	
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php if(!empty($data_selected_final)): ?>
                    <h3 class="myheader">अन्तिम भुक्तानी भइ सकेको छ | <a href="plan_form5.php" class="btn">विवरण हेर्नुहोस</a>   </h3>
                   
                   <?php  endif; ?>
                     <div class="myCenter">
                                 <h3>मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा</h3>
                                <?php  
                                if(!empty($inst_count))
                                            {
                                if($mode=="superadmin"){
                                            
                                    ?>
                                  <a onClick="return confirm('के तपाई डेटा हाटाउन चाहनुहुन्छ ?');" href="delete_analysis_payment.php?plan_id=<?php echo $_GET['id'];?>"><button class="btn">मुल्यांकन को आधारमा भुक्तानी हटाउनु होस्</button></a>
                               <?php } 
                                }?>
                                 <?php $net_payable_amount = $net_investment; if($inst_count>0):
                                     $inst_amount = array();
                                     $inst_payable_amount = array();
                                     $inst_selected = array();
                                     
                                 ?>
                                 <?php for($i=1; $i<=$inst_count; $i++): 
                                        $inst_data = Analysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
                                        array_push($inst_amount, $inst_data->total_paid_amount);
                                        array_push($inst_selected, $inst_array[$i]);
                                        $net_payable_amount -= $inst_data->payable_amount;
                                        $bhautik_lakshya_payment = Bhautik_lakshya::find_by_plan_id_and_type_payment_count($_GET['id'],2,$i);
                                        //$katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type_payment_count($_GET['id'],1,$i);
                                        //print_r($bhautik_lakshya_payment);exit;
                                     ?>
                                 
                                 <h3 class="myheader"><?=$inst_array[$i]?> भुक्तानी विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered table-hover">
                                        
                                        <tr>
                                            <td class="myTextalignRight myWidth50">योजनाको मुल्यांकन किसिम</td>
                                            <td><?php echo $inst_array[$i]; ?></td>
                                        </tr>
                                        <tr>
                                <td class="myTextalignRight">योजनाको मुल्यांकन  मिती</td>
                                <td ><?php echo convertedcit($inst_data->evaluated_date); ?></td>
                              </tr>
                               <tr>
                                <td class="myTextalignRight">योजनाको मुल्यांकन  रकम</td>
                                <td ><?php echo convertedcit(placeholder($inst_data->evaluated_amount)); ?></td>
                              </tr>
                              <tr>
                                <td class="myTextalignRight">उपभोक्ताबाट जनश्रमदान रकम</td>
                                <td ><?php echo convertedcit(placeholder($inst_data->janshramdan)); ?></td>
                              </tr>
                              <tr>
                                <td class="myTextalignRight">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td ><?php echo convertedcit(placeholder($inst_data->payable_amount)); ?></td>
                              </tr>
                            </table>
                            <table class="table table-bordered table-hover">
                            <tr>
                                <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                 <th>कन्टेन्जेन्सी  कट्टी रकम</th>
                                  <th>मर्मत सम्हार कोष कट्टी रकम</th>
                            </tr>
                            <tr>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->advance_payment)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->contengency_amount)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->renovate_amount)); ?></td>
                            </tr>
                            <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_amount_deducted)); ?></td>
                            </tr>
                            <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_paid_amount)); ?></td>
                            </tr>
                            </table><br>
                            <h2><?=$inst_array[$i]?> प्राप्त भौतिक लक्ष्य </h2>
                                <table class="table table-bordered">
                                <tr>
                                    <th>सि. नं </th>
                                    <th>परिमाणको शिर्षक </th>
                                    <th>अनुमानित परिमाण</th>
                                    <th>प्राप्त परिमाण</th>
                                    <th>भौतिक इकाई </th>
                                    
                                </tr>
                            <?php 
                                    $i=1;
                                    foreach($bhautik_lakshya_payment as $result):
                                    ?>
                                <tr>
                                <td><?=convertedcit($i)?></td>
                                    <td><?=SettingbhautikPariman::getName($result->details_id)?></td>
                                    <td><?=convertedcit($result->prev_qty+0)?></td>
                                    <td><?=convertedcit($result->qty+0)?></td>
                                    <td><?=  Units::getName($result->unit_id)?></td>
                                   
                                </tr>
                                <?php $i++;endforeach;?>
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
                             <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $_GET['id'];?>"/>
                               <input type="hidden" name="marmat_rate" id="marmat_rate" value="<?=Marmatsamhar::get_marmat_samhar_percent();?>"/>    
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
<!--                              <tr>
                                <td width="176">भुक्तानी दिन बाकी अनुदान रकम</td>
                                <td width="243" id="net_payable_amount"><?=$net_payable_amount?></td>
                              </tr>
                              <tr>
                                <td width="176">भुक्तानी दिनुपर्ने उपभोक्ताबाट नगद साझेदारी रकम</td>
                                <td width="243" id="net_payable_amount"><?=$customer?></td>
                              </tr>-->
                               <tr>
                                <td width="176">योजनाको मुल्यांकन  मिती</td>
                                <td width="243"><input type="text" name="evaluated_date" required id="nepaliDate3" /></td>
                              </tr>
                              <tr>
                                <td width="176">इष्टिमेट भएको रकम </td>
                               <td width="243"><input type="text" id="analysis_estimated_amount" name="estimated_amount" value="<?=$estimated_amount?>"/></td>
                               <input type="hidden" id="karyadesh_rakam" value=<?=$karyadesh_amount?>/>
                           </tr>
                              <tr>
                                <td width="176">योजनाको हाल मुल्यांकन  रकम</td>
                                <td width="243"><input type="text" name="evaluated_amount" id="evaluated_amount" required /></td>
                              </tr>
                            <tr>
                                <td width="176">योजनाको खुद मुल्यांकन  रकम</td>
                                <td width="243"><input type="text" name="khud_evaluated_amount" id="khud_evaluated_amount" required readonly="true" /></td>
                            </tr>
<!--                               <tr>
                                <td width="176">उपभोक्ताबाट जनश्रमदान रकम</td>
                                <td width="243"><input type="text" name="janshramdan" id="janshramdan_amount" required /></td>
                              </tr>-->
                              <tr>
                                <td width="176">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><input type="text" name="payable_amount" id="payable_amount" required/></td>
                              </tr>
                                </table>
                             
                            <table class="table table-bordered">
                            <tr>
                                 <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                 <th >कन्टेन्जेन्सी  कट्टी रकम</th>
                                 <?php if(empty($amanat_lagat)){?>
                                  <th >मर्मत सम्हार कोष कट्टी रकम</th>
                                  <?php }else{}?>
                            </tr>
                            <tr>
                                <td><input type="text" name="advance_payment" id="advance_payment" value="<?=$advance_amount?>" readonly="readonly" value="0" /></td>
                                <td><input type="text" name="contengency_amount" id="contengency_amount" /></td>
                                <?php if(empty($amanat_lagat)){?>
                                <td><input type="text" name="renovate_amount" id="renovate_amount" value="0" /></td>
                                <?php }else{}?>
                                <input type="hidden" id="after_cont_all">
                            </tr>
                            </table>
                            <?php if(empty($amanat_lagat)){?>
                            <table class="table borderless">
                            <thead>
                            <tr>
                                <th class="myCenter" style="border:3px double black;"><strong>सी.न </th>
                                <th class="myCenter" style="border:3px double black;"><strong>शिर्षक</th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर योग्य रकम</strong></th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर(%)</strong></th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर रकम</strong></th>

                            <tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            if(!empty($setting)) :
                                foreach ($setting as $key => $value) :?>
                                    <tr>
                                        <td><?php echo convertedcit($i++)?></td>
                                        <td><?php echo $value->topic?>
                                            <input type = "hidden" name="topic[]" value="<?php echo $value->topic?>">
                                        </td>
                                        <td><input type="text" name="karrakam[]
                                                    " value=""  class="form-control karrakam"></td>
                                        <td><input type="text" name="precent[]"  class="percent" value="<?php echo $value->percent?>" readonly="true" style="background: #e5e5e5;"></td>
                                        <td><input type="text" name="total_amt[]" value="" class="form-control sum_item"></td>
                                    </tr>
                                <?php endforeach;endif;?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" value="<?=$final_total_paid_amount?>" name= "final_t_amount" id="final_t_amount" readonly="readonly"> </td>
                                <td colspan =2></td>
                                <td>
                                    <input type="text" name="total_kar_rakam"  id = "total" readonly="true" style="background: #e5e5e5;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">करपछि भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="f_amount_after_tax" id="f_amount_after_tax" readonly="true" style="background: #e5e5e5"></td>
                            </tr>
                            </tfoot>
                        </table>
                        <?php }else{}?>
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
                                <td><input type="text" required name="total_paid_amount" id="total_paid_amount" /> <hr><a id="calculate_analysis" class="btn btn-info"> CACULATE</a></td>
                              </tr>
                              <tr>
                                <td>मुल्यांकनको आधारमा भुक्तानी भएको मिति </td>
                                <td><input type="text" required name="created_date" id="nepaliDate9" readonly="true" value="<?=DateEngToNep(date("Y-m-d",time()))?>" /></td>
                              </tr>
                            </table></br>
                            <h2>प्राप्त भौतिक लक्ष्य भर्नुहोस्</h2>
                                <table class="table table-bordered">
                                <tr>
                                    <th>सि. नं </th>
                                     <th> भौतिक लक्ष्य को शिर्षक </th>
                                     <th>अनुमानित लक्ष्य </th>
                                    <th>प्राप्त लक्ष्य </th>
                                    <th>भौतिक इकाई </th>
                                    
                                </tr>
                            <?php 
                                    $i=1;
                                    foreach($bhautik_details as $result):
                                    ?>
                                <tr <?php if($i!=1){?>class="remove_plan_form_details"<?php }?>>
                                <td><?=$i?></td>
                                    <td>
                                        <select name="details_id[]" readonly="true">
                                            <option value="">--------</option>
                                            <?php foreach($settingbhautikPariman as $data):?>
                                            <option value="<?=$data->id?>" <?php if($data->id==$result->details_id){ echo 'selected="selected"';}?>><?=$data->name?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="prev_qty[]" value="<?php echo $result->qty; ?>">
                                    </td>
                                    <td><input type="text" name="qty[]"  /></td>
                                    <td>
                                            <select name="unit_id[]" readonly="true">
                                                <option value="">--छान्नुहोस् --</option>
                                                <?php foreach($units as $unit): ?>
                                                <option value="<?=$unit->id?>" <?php if($unit->id==$result->unit_id){ echo 'selected="selected"';}?>><?=$unit->name?></option>
                                                <?php endforeach; ?>
                                           </select>
                                    </td>
                                </tr>
                                <?php $i++;endforeach;?>
                                </table>
                            </br>
                            <input type="hidden" name="costumer_agreement" id="costumer_agreement" value="<?php echo $hid_costumer_agreement;?>" />
                            <!-- added hidden fields for actual contingency calculation -->
                              <input type="hidden" name="hid_agreement_gauplaika" id="hid_agreement_gauplaika" value="<?php echo $hid_agreement_gauplaika ;?>" />
                            <input type="hidden" name="hid_agreement_other" id="hid_agreement_other" value="<?php echo $hid_agreement_other;?>" />
                            <input type="hidden" name="hid_other_agreement" id="hid_other_agreement" value="<?php echo $hid_other_agreement;?>" />
                            <input type="hidden" name="hid_total_evaluated" id="hid_total_evaluated" value="<?php echo Analysisbasedwithdraw::getevaluated_Amount($_GET['id']);?>" />
                            <!-- for calculated values -->
                             <input type="hidden" name="agreement_gauplaika_calc" value="" id="agreement_gauplaika_calc" />
                             <input type="hidden" name="agreement_other_calc" value="" id="agreement_other_calc" />
                             <input type="hidden" name="other_agreement_calc" value="" id="other_agreement_calc" />
                             <input type="hidden" name="customer_agreement_calc" value="" id="customer_agreement_calc" />

                        <input type="submit" name="submit" onClick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस हालिएको  डेटा सच्याउन  मिल्दैन');" value="सेभ गर्नुहोस" class="btn">
                                             
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
              <script src="js/bhuktani.js"></script>
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
     <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script>
    JQ(document).ready(function(){
      $(document).on('keyup change','.karrakam',function(){
            var karrakam = $(this).val();
            if(karrakam == '' || isNaN(karrakam)) {
                karrakam = 0;
                $(this).closest('tr').find('.karrakam').val(0);
            }
            var unit_other = $(this).closest('tr').find('.percent').val();
            var total_karRakam = unit_other*karrakam/100;
            if(total_karRakam != '' && total_karRakam !=NaN) {
                $(this).closest('tr').find('.sum_item').val(total_karRakam);
            }
            var sum = 0;
            $('.sum_item').each(function(){
                var item_val=parseFloat($(this).val());
                if(isNaN(item_val)){
                    item_val = 0 ;
                }
                sum+= item_val;
                $('#total').val(sum.toFixed(2))||0;
            });
            var amount_final = $('#final_total_amount_deducted').val();
            var final_amt = $('#final_total_amount_deducted').val();
            var final_t_amount = amount_final - final_amt;
            console.log(final_t_amount);
            var final_t_amount = $('#final_t_amount').val();
            if(isNaN(final_t_amount)) {
                final_t_amount = 0;
            }
            var final_amount_after_tax = parseFloat(final_t_amount)-parseFloat(sum);
            $('#f_amount_after_tax').val(final_amount_after_tax);
            JQ("#total_amount_deducted").val(sum)||0;
            JQ("#total_paid_amount").val(final_amount_after_tax)||0;
        });
    });
</script>