<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//print_r($_GET);
$date_selected= $_GET['date_selected'];
?>
<?php $data1=  Plandetails1::find_by_id($_GET['id']);
$result = Plantotalinvestment::find_by_plan_id($_GET['id']);
if(!empty($result))
   {
      $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
       $investment_data=Plantotalinvestment::find_by_plan_id($_GET['id']);
        $name = "उपभोक्ताबाट";

   }
   else
   {
       $investment_data= AmanatLagat::find_by_plan_id($_GET['id']);
       $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
        $name = "";

   }
$data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$data5=  Analysisbasedwithdraw::find_by_max($_GET['max_id'],$_GET['id']);
$katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type_payment_count($_GET['id'],1,$_GET['max_id']);
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

$address= getAddress();
  $ward_address=WardWiseAddress();
    ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>मुल्यांकनको आधारमा भुक्तानीको टिप्पणी । print page:: <?php echo SITE_SUBHEADING;?></title>
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
             <div class="printPage">
             	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
                                    	<div style="color:red">
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    </div>
                                    
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate"><?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino"> चलानी नं . : </div>
										<div class="myspacer"></div>
										
										<div class="subject">   विषय:- मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer"></div>
										<div class="bankname">श्रीमान् </div>
                                                                               
										<div class="banktextdetails"  >
											 यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम 
                                                                                         अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस 
                                                                                         कार्यलय र  <b><u> <?php echo $data3->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)-->
                                                                                         बिच संझौता भई यस <?php echo SITE_TYPE;?>को वडा नं <?php echo convertedcit($data3->program_organizer_group_address);?><!--(योजना संचालन हुने वडा नं)-->  
                                                                                         मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)--> योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data5->evaluated_date);?><!--(योजनाको काम सम्पन्न भएको 
                                                                                         मिति)--> मा प्राबिधिक मुल्याकन गर्दा तपशिल अनुसारको रकम
                                                                                         दिन मनासिब देखिएकाले श्रीमान् समक्ष निणयार्थ यो 
                                                                                         टिप्पणी पेश गरको छु । 
</div>                         
										
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                               
    <?php 
    if($data5->payment_evaluation_count==1)
    {
        $period="पहिलो";
    }
    if($data5->payment_evaluation_count==2)
    {
        $period="दोस्रो";
    }
    if($data5->payment_evaluation_count==3)
    {
        $period="तेस्रो";
    }
     if($data5->payment_evaluation_count==4)
    {
        $period="चौथो";
    }
     if($data5->payment_evaluation_count==5)
    {
        $period="पाचौ";
    }
     if($data5->payment_evaluation_count==5)
    {
        $period="छैठो";
    }
?>
 <?php   $datas=Plantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>
						<tr>
                                                    <td class="myWidth50 myTextalignLeft">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजनाको कुल अनुदान रकम</td>
                                                	<td>रु. <?php echo convertedcit($add); ?></td>
                                                </tr>
                                                <tr>
                                                    <td  class="myTextalignLeft">योजनाको कुल लागत अनुमान : </td>
                                                    <td> <?php echo convertedcit($investment_data->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">उपभोक्ताबाट जनश्रमदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($result->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td  class="myTextalignLeft">कार्यदेश दिएको रकम: </td>
                                                    <td> <?php echo convertedcit($investment_data->bhuktani_anudan);?></td>
                                                </tr>
                                            		<tr>
                                                	<td  class="myTextalignLeft">योजनाको मुल्यांकन किसिम : </td>
                                                    <td> <?php echo $period;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजनाको मुल्यांकन रकम : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">भुक्तानी दिनु पर्ने कुल  रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->payable_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">कन्टेन्जेन्सी  कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->contengency_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->advance_payment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">मर्मत सम्हार कोष कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->renovate_amount);?></td>
                                                </tr>
                                               <?php foreach($katti_bibaran_payment as $sa):?>
                                                <tr>  
                                                    <td class="myTextalignLeft"><?=  KattiWiwarn::getName($sa->katti_id)?></td>
                                                    <td><?= convertedcit($sa->katti_amount+0)?></td>
                                                </tr>
                                                 <?php endforeach;?>
                                                <tr>
                                                	<td class="myTextalignLeft">जम्मा कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->total_amount_deducted);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->total_paid_amount);?></td>
                                                </tr>
                                            
                                            </table>
                                        </div>
										
										<div class="myspacer30"></div>

                                                                                <div class="oursignature">सदर गर्ने <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="oursignatureleft">पेस गर्ने <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="myspacer"></div>
</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->
