<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
error_reporting(1);
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ", 
    6=>"छैठो",
);
  $data4= Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
?>
    <?php
    if(isset($_POST['submit']))
    {
        $max_id = $_POST['max_id'];
                $data1=  Plandetails1::find_by_id($_GET['id']);
                $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                $fiscal = FiscalYear::find_by_id($data1->fiscal_id); 

                $data5=  Analysisbasedwithdraw::find_by_max($_POST['max_id'],$_GET['id']);
                $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type_payment_count($_GET['id'],1,$data4);
                $result = Plantotalinvestment::find_by_plan_id($_GET['id']); //print_r($result);
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
                $link = get_return_url($_GET['id']);
                $workers = Workerdetails::find_all();
                $url = get_base_url(1);
                $print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

                if(!empty($print_history))
                {
                    $worker1 = Workerdetails::find_by_id($print_history->worker1);
                    $worker2 = Workerdetails::find_by_id($print_history->worker2);
                }
                else
                {
                    $print_history = PrintHistory::setEmptyObject();
                    if(empty($worker1))
                    {
                        $worker1 = Workerdetails::setEmptyObject();
                    }
                    if(empty($worker2))
                    {
                        $worker2 = Workerdetails::setEmptyObject();
                    }

                }
}
$address= getAddress();
  $ward_address=WardWiseAddress();    
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>मुल्यांकनको आधारमा भुक्तानीको टिप्पणी :: <?php echo SITE_SUBHEADING;?></title>
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
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
         <div class="maincontent" >
             <form method="get" action="print_bank_report_09_final.php">
                    <h2 class="headinguserprofile"> मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा | <a href="<?=$link?>" class="btn">पछि जानुहोस</a>
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    </h2>
                  
                    <div class="OurContentFull" >
                    <div class="inputWrap">
                        		<h1>पत्र छान्नुहोस् </h1>
                                        <form method="post">		
                        <div class="newInput">
                                <select name="max_id">
                            <option value="">छान्नुहोस्</option>
                            <?php for($i=1;$i<=$data4;$i++):
                                if($i==1)
 {
        $period="पहिलो";
    }
    if($i==2)
    {
        $period="दोस्रो";
    }
    if($i==3)
    {
        $period="तेस्रो";
    }
     if($i==4)
    {
        $period="चौथो";
    }
     if($i==5)
    {
        $period="पाचौ";
    }
     if($i==6)
    {
        $period="छैठो";
    }
	
                            
?>
                            <option value="<?php echo $i;?>"><?php echo $period;?></option>
                            <?php endfor;?>
                        </select>
                        </div>
                        <div class="saveBtn myWidth100">
                        	<input type="submit" name="submit" class="btn"  value="खोज्नुहोस"/>
                        </div>
                        </form>
                    </div>
                <?php if(isset($_POST['submit'])){?>
                        
                        <input type="hidden" name="max_id" value="<?=$max_id?>"/>
                         
                       <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    <div class="image-wrapper">
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
									<div class="subjectbold letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino"> चलानी नं . : </div>
										<div class="myspacer20"></div>
										
										<div class="subject">   विषय:- मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
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
                                            <table class="table table-bordered table-responsive myWidth100">
                                               
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
                                                	<td  class="myTextalignLeft">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">योजनाको मुल्यांकन रकम : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">भुक्तानी दिनु पर्ने कुल  रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->payable_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">कन्टेन्जेन्सी  कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->contengency_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->advance_payment);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">मर्मत सम्हार कोष कट्टी रकम : </td>
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
										
										
                                                                                <div class="myspacer20"></div>
                                                                                <div class="oursignature">सदर गर्ने <br/>
                                                                                    <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
                                                                                <div class="oursignatureleft">पेस गर्ने <br/>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                </div>
										<div class="myspacer"></div>
									</div>
                            </div>
                         <?php } ?>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>