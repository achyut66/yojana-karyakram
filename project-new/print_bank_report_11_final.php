<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$date_selected= $_GET['date_selected'];
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
            $investment_data = Plantotalinvestment::find_by_plan_id($_GET['id']);
            $gaupalika_percent = ($investment_data->agreement_gauplaika/$investment_data->total_investment)*100;
            $sajhe_percent = ($investment_data->costumer_agreement/$investment_data->total_investment)*100;
            $costumer_investment_percent = ($investment_data->costumer_investment/$investment_data->agreement_gauplaika)*100;
            $gaupalika_percent = number_format((float) $gaupalika_percent, 3,'.','');
            $sajhe_percent = number_format((float) $sajhe_percent, 3,'.','');
            $costumer_investment_percent = number_format((float) $costumer_investment_percent, 3,'.','');
$data2=  Moreplandetails::find_by_plan_id($_GET['id']);
$data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id);
$user = getUser();
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];

$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];

$print_history->save();
if(!empty($_GET['worker1']))
{
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker2']))
{
$worker2 = Workerdetails::find_by_id($_GET['worker2']);
}
else
{
    $worker2 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker3']))
{
$worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker4']))
{
$worker4 = Workerdetails::find_by_id($_GET['worker4']);
}
else
{
    $worker4 = Workerdetails::setEmptyObject();
}

        $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type($_GET['id'],2);
        $data_1 = Analysisbasedwithdraw::find_by_plan_id($_GET['id']); //print_r($data_1);
        $data_2 = Planamountwithdrawdetails::find_by_plan_id($_GET['id']); //print_r($data_2);
        $kar_rakam_details = Kar_Bibran::find_by_plan_id($_GET['id']);
        $ward_address=WardWiseAddress();
$address= getAddress();
?>
<?php $customer = Costumerassociationdetails::find_by_plan_id_post_id($_GET['id'],1); //print_r($customer);?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>अन्तिम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>
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
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage"><div class="image-wrapper">
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
                                    <div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
                                    </div>
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										
                                        <div class="chalanino">योजना दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
                                        <div class="chalanino"> चलानी नं . : </div>
										<div class="myspacer"></div>

                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo "रकम भुक्तानी सम्बन्धमा ।";
                                                }?>
                                            </u>
                                        </div>
										<div class="myspacer"></div>
										<div class="bankname">श्रीमान् 
                                        </div>
                                                                               
										<div class="banktextdetails"  >
									    यस कार्यालयको स्वीकृत वार्षिक  कार्यक्रम अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस कार्यलय र  <b><u> <?php echo $data3->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच संझौता भई यस <?php echo SITE_TYPE;?>को वडा नं <?php echo convertedcit($data3->program_organizer_group_address);?><!--(योजना संचालन हुने वडा नं)-->  मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)-->
    योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data2->yojana_sakine_date);?><!--(योजनाको काम सम्पन्न भएको मिति)--> मा तोकिएको काम सम्पन्न गरी उपभोक्ता
    समितिको मिति <?php echo convertedcit($data4->upabhokta_aproved_date);?><!--(उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बैठक बसी आम्दानी खर्च अनुमोदन तथा सार्बजनिक 
    गरी सार्बजनिक परिक्षण समेत गरेको र अनुगमन समितको मिति <?php echo convertedcit($data4->expenditure_approved_date);?><!--(अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बैठक 
    बसी योजनाको अन्तिम भुक्तानीको लागि सिफारिस गरेको र उपभोक्ता समितिले योजनाको बिल भरपाई प्राबिधिक मुल्यांकन तथा योजनाको
    फोटोसहित यस <?php echo SITE_TYPE;?>मा निबेदन पेश गरी उक्त योजनाको भुक्तानीका लागि माग भएको । 
    </div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                                 <?php   $datas=Plantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>
                                            <table class="table table-bordered myWidth100">
                                            	<tr>
                                                    <td class="myWidth50 myTextalignLeft">बिनियोजन श्रोत र व्याख्या : </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजनाको कुल अनुदान रकम : </td>
                                                    <td>रु. <?php echo convertedcit($add);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">जनश्रमदान (<?=convertedcit($costumer_investment_percent)?> % ) : </td>
                                                    <td> <?php echo convertedcit($investment_data->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">योजनाको कुल लागत अनुमान : </td>
                                                    <td> <?php echo convertedcit($investment_data->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">कार्यदेश दिएको रकम: </td>
                                                    <td> <?php echo convertedcit($investment_data->bhuktani_anudan);?></td>
                                                </tr>
                                            	<tr>
                                                	<td class="myTextalignLeft">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data4->plan_evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजनाको मुल्यांकन रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->plan_evaluated_amount);?></td>
                                                </tr>
                                                    <!-- calculattion change -->
                                                <tr>
                                                    <td class="myTextalignLeft"><?=SITE_TYPE?> contribution रकम  (<?=convertedcit(100-$costumer_investment_percent)?> %):</td>
                                                    <td>रु. <?php echo convertedcit($data4->agreement_gauplaika_calc);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft"> उपभोक्ता नगद साझेदारी contribution रकम: </td>
                                                    <td>रु. <?php echo convertedcit($data4->customer_agreement_calc);?></td>
                                                </tr>
                                                    <!-- calculattion change -->
                                                <tr>
                                                	<td class="myTextalignLeft">मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->payment_till_now);?></td>
                                                </tr>
                                                <tr>
                                                    <?php if(!empty($data4->advance_payment)){?>
                                                	<td class="myTextalignLeft">पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->advance_payment);?></td>
                                                    <?php }else{?>
                                                    <?php }?>
                                                </tr>
                                                <tr style="display:none;">
                                                	<td class="myTextalignLeft">भुक्तानी दिनु पर्ने कुल बाँकी  रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->remaining_payment_amount);?></td>
                                                </tr>
                                                <!-- change made-->
                                                <?php 
                                                $new_estimate = $investment_data->total_investment;
                                                //print_r($new_estimate);
                                                    if($data4->plan_evaluated_amount > $new_estimate)
                                                            {
                                                            	$amt = " + " .($data4->plan_evaluated_amount - $new_estimate );
                                                            	//print_r($amt);
                                                            }
                                                            elseif($data4->plan_evaluated_amount < $new_estimate)
                                                            {
                                                            	$amt = " - " .( $new_estimate - $data4->plan_evaluated_amount  );
                                                            	//print_r($amt);
                                                            }
                                                            else
                                                            {
                                                            	$amt = 0;
                                                            }
                                                ?>
                                                <?php $con = Contingency::find_by_sql("select * from contingency where type=1"); //print_r($con);
                                                foreach($con as $cn):
                                                // print_r($add);
                                                // print_r($cn->amount);
                                                $contingency_rakam =  $add * ($cn->amount); //print_r($contingency_rakam);
                                                ?>
                                                <?php endforeach;?>
                                                <tr style="display:none; ">
                                                     <td class="myTextalignLeft">भुक्तानी घटी कट्टी / बढी रकम</td>
                                                    <td>रु. <?=convertedcit($data4->final_bhuktani_ghati_amount - $data4->customer_agreement_calc)?></td>
                                                </tr>
                                                 <tr>
                                                     <td class="myTextalignLeft">भुक्तानी घटी कट्टी / बढी रकम</td>
                                                    <td>रु.(<?=convertedcit($amt)?>)</td>
                                                </tr>
                                                <!--<tr>-->
                                                    
                                                <!--	<td class="myTextalignLeft">कन्टेन्जेन्सी  कट्टी रकम : </td>-->
                                                <!--    <td>रु. <?php echo convertedcit($data4->final_contengency_amount);?></td>-->
                                                <!--</tr>-->
                                                <tr>
                                                	<td class="myTextalignLeft">मर्मत सम्हार कोष कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_renovate_amount);?></td>
                                                </tr>
                                                
                                                 <!-- change made-->
                                                <!--<tr>-->
                                                <!--	<td class="myTextalignLeft">जम्मा कट्टी रकम : </td>-->
                                                <!--    <td>रु. <?php echo convertedcit($data4->final_total_amount_deducted);?></td>-->
                                                <!--</tr>-->
                                                <tr>
                                                	<td class="myTextalignLeft">आयोजना व्यवस्थापन खर्च (२.५%): </td>
                                                    <td>रु. <?php echo convertedcit($contingency_rakam);?></td>
                                                </tr>
                                                <tr>
                                                    <?php if(!empty($result->bipat_new)){?>
                                                	<td class="myTextalignLeft">बिपत व्यवस्थापन कोष कट्टी : </td>
                                                    <td>रु. <?php echo convertedcit($result->bipat_new);?></td>
                                                    <?php }else{}?>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td> रु.<?php echo convertedcit($data4->final_total_paid_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">उपभोक्ता समितिको अध्यक्षको नाम थर: </td>
                                                    <td><?php echo $customer->name;?> (<?php echo convertedcit($customer->mobile_no)?>)</td>
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <div class="myspacer20"></div>
                                                <div class="oursignature" style="margin-right:11px">सदर गर्ने <br/>
                                                                        
                                                                            <?php 
                                                                                if(!empty($worker1))
                                                                                {
                                                                                    echo $worker1->authority_name."<br/>";
                                                                                    echo $worker1->post_name;
                                                                                }
                                                                            ?>
                                                                        </div>
										                                <div class="oursignatureleft">पेस गर्ने<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                        </div>
                                                                        <!--<div class="oursignatureleft" style="margin-left:45px">सिफारिस गर्ने<br/>-->
                                                                                    <?php 
                                                                                        // if(!empty($worker3))
                                                                                        // {
                                                                                        //     echo $worker3->authority_name."<br/>";
                                                                                        //     echo $worker3->post_name;
                                                                                        // }
                                                                                    ?>
                                                                        <!--</div>-->
                                                                        <div class="oursignatureleft" style="margin-left:100px">सिफारिस गर्ने<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker4))
                                                                                        {
                                                                                            echo $worker4->authority_name."<br/>";
                                                                                            echo $worker4->post_name;
                                                                                        }
                                                                                    ?>
                                                                        </div>
                                                                        <div class="myspacer30"></div>
                                                                        
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
                                         if(!empty($kar_rakam_details)) :
                                            $total_amount = '';
                                            foreach ($kar_rakam_details as $key => $value) :?>
                                                <tr>
                                                  <td><?php echo convertedcit($i++)?></td>
                                                  <td><?php echo !empty($value->kar_topic) ? convertedcit($value->kar_topic) : '--';?></td>
                                                  <td><?php echo !empty($value->kar_rakam) ? convertedcit($value->kar_rakam): convertedcit(0);?></td>
                                                  <td><?php echo !empty($value->kar_percent) ? convertedcit($value->kar_percent) : convertedcit(0);?></td>
                                                  <td><?php echo !empty($value->total_kar_amount) ? convertedcit($value->total_kar_amount) :convertedcit(0);?></td>
                                                  <?php $total_amount +=$value->total_kar_amount;?>
                                                  
                                              </tr>
                                          <?php endforeach;endif;?>
                                
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                            <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                            <td><?php echo convertedcit($data4->final_total_paid_amount);?> </td>
                                            <td colspan =2><b>जम्मा कर रकम</b> </td>
                                            <td> <?php echo convertedcit($total_amount)?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>कर पछीको खुद भुक्तानी योग्य रकम </b></td>
                                            <td><?php $total_amount_after_tax =$data4->final_total_paid_amount - $total_amount;
                                            echo convertedcit($total_amount_after_tax) ?>
                                        </td>
                                    </tr>
                                </tfoot>
                                </table>
                                   </div>
                                    <?php $datas= Bankinformation::find_all();//print_r($datas);?>
								<div class="banktextdetails" style="margin-left:5px">
                                    उपरोक्तानुसार  <strong>
                                    <?php echo $data1->program_name;?></strong> 
                                    कार्यसंग  सम्बन्धित बील भरपाई स्वीकृत प्रस्ताव, सम्बन्धित वडा कार्यालयको
                                    चलानी नं <strong><?php echo convertedcit($data4->chalani_no)?></strong>
                                    मिति <strong><?php echo convertedcit($public_inv->survey_date)?></strong>
                                    को
                                    कार्य सम्पन्न सिफारिस, प्राविधिकको
                                    मुल्यांकन, नगरस्तरीय योजना सुपरिवेक्षण तथा अनुगमन समितिको अनुगमन मुल्यांकन र अन्य कागजात यस कार्यालयमा
                                    पेश भैसकेकोले सम्झौता अनुसार 
                                    उपभोक्ता नगद साझेदारी रकम 
                                    <strong><?php echo $data4->us_bank_name;?></strong>
                                    स्थित खाता नं 
                                    <strong><?php echo convertedcit($data4->us_bank_acc)?></strong>
                                    मा 
                                    रु. <strong><?php echo convertedcit($data4->customer_agreement_calc)?></strong>
                                    दाखिला गरिएकोले
                                    नियम बमोजिम कट्टी गरि भुक्तानी दिन बाँकी रहेको रकम रु
                                    <strong><?php echo convertedcit($total_amount_after_tax);?></strong>/-<strong> 
                                    <?php echo $data3->program_organizer_group_name;?>,</strong><strong><?php echo SITE_LOCATION;?> 
                                    <?php echo convertedcit($data3->program_organizer_group_address);?></strong> / कामदारहरुको 
                                    
                                    <?php 
                                    // foreach($datas_1 as $datas_1):
                                    //     endforeach;
                                    //         echo $datas_1->address;
                                    ?>
                                    नाममा
                                    <strong> <?php echo $datas->name;?>, <?php echo $datas->address;?></strong> 
                                    शाखा स्थित
                                    <strong>
                                    <?php  
                                    foreach($data_1 as $d1) if (!empty($d1)){
                                    echo convertedcit($d1->bank_acc);
                                    }else{
                                    echo convertedcit($data_2->bank_acc);
                                    }?>
                                    <?php echo convertedcit($data_2->bank_acc);?>
                                    </strong>
                                    मा जम्मा हुने रकम भुक्तानी दिन मनासिय देखि निर्णयार्थ यो टिप्पणी पेश गर्दछु |
                                    
                                    </div>
									<div class="myspacer20"></div>

                                                                        <div class="oursignature" style="margin-right:11px">सदर गर्ने <br/>
                                                                        
                                                                            <?php 
                                                                                if(!empty($worker1))
                                                                                {
                                                                                    echo $worker1->authority_name."<br/>";
                                                                                    echo $worker1->post_name;
                                                                                }
                                                                            ?>
                                                                        </div>
										                                <div class="oursignatureleft">पेस गर्ने<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                        </div>
                                                                        <!--<div class="oursignatureleft" style="margin-left:45px">सिफारिस गर्ने<br/>-->
                                                                                    <?php 
                                                                                        // if(!empty($worker3))
                                                                                        // {
                                                                                        //     echo $worker3->authority_name."<br/>";
                                                                                        //     echo $worker3->post_name;
                                                                                        // }
                                                                                    ?>
                                                                        <!--</div>-->
                                                                        <div class="oursignatureleft" style="margin-left:100px">सिफारिस गर्ने<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker4))
                                                                                        {
                                                                                            echo $worker4->authority_name."<br/>";
                                                                                            echo $worker4->post_name;
                                                                                        }
                                                                                    ?>
                                                                        </div>
										<div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->