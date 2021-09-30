<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    
}
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
    // print_r($result);exit;
     if(!empty($result))
        {
            $data4=  Plantotalinvestment::find_by_plan_id($_GET['id']);
            $data2= Moreplandetails::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $data4= AmanatLagat::find_by_plan_id($_GET['id']);
            $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $link = get_return_url($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>
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
                          input {
                              background-color: #eee;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <form method="get" action="print_bank_report_05_final.php?>">
                    <h2 class="headinguserprofile">विषय:- योजना संझौता कार्यादेश | <a href="<?=$link?>" class="btn">पछि जानुहोस </a> 
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट" name="submit" /></div>
                    </h2>
                    
                    <div class="OurContentFull" >
                    	<form method="get" action="print_bank_report_05_final.php?>" target="_blank" >
                            <!--<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>-->
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
									
									<div class="printContent">
										<div class="mydate"><input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>


                                        <div class="subject" border="none">
                                            <u>बिषय :- <label style="margin-left: 5px;">
                                                    <input type="text" style="border:none" class="no-outline" name="subject" value="योजना सम्झौता कार्यादेश"/></label></u>
                                        </div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री अध्यक्ष ज्यु,<br> <?php echo $data3->program_organizer_group_name;?>,<br> 
  						 <?php echo SITE_NAME?>-<?php echo convertedcit($data3->program_organizer_group_address);?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार  तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न मिति ‍<?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यो कार्यादेश दिईएको छ । तोकिएको समयमा काम सम्पन्न गरी योजनाको प्राबिधिक मुल्यांकन गराइ उक्त योजनामा भएको यथार्थ खर्चको विवरण उपभोक्ता समिति तथा अनुगमन समितिको बैठकबाट अनुमोदन गराइ खर्चको बिल भरपाई तथा योजनाको फोटो सहित यस <?php echo SITE_TYPE;?>मा पेश गरी भुक्तानी लिनुहुन जानकारी गराइन्छ । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignLeft">योजनाको नाम : </td>
                                                    <td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50 myTextLeft">बिनियोजन श्रोत र ब्याख्या :</td>
                                                    <td><?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">ठेगाना : </td>
                                                    <td><?php echo SITE_NAME?>-<?php echo convertedcit($data3->program_organizer_group_address);?></td>
                                                </tr>
                                                <tr>
                                                <td class="myTextalignLeft">योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td class="myTextalignLeft">अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignLeft">विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignLeft"><?php echo SITE_TYPE;?>बाट अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <?php
                                                $con = Contingency::find_by_sql("select * from contingency where type=1");
                                                foreach($con as $con):
                                                endforeach;
                                                //print_r($con);
                                                $cont = ($result->agreement_gauplaika) * $con->amount;
                                                //print_r($cont);

                                                ?>
                                                <tr>
                                                    <td class="myTextalignLeft">कन्टेन्जेन्सी
                                                        (<?php echo convertedcit($con->percent)?>)%
                                                    </td>
                                                    <td>रु. <?php echo convertedcit($cont);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">मर्मत
                                                        (<?php echo convertedcit($result->marmat_old)?>%)</td>
                                                    <td>रु. <?php echo convertedcit($result->marmat_new);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft"><?=$name?> नगद साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft"><?=$name?> जनश्रमदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">कुल लागत अनुमान जम्मा रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
                                        <div class="">
										
                                        <div class="oursignatureleft" style="float:right; margin-top: 50px;">
                                            <select name="worker1" class="form-control worker" id="worker_1" >
                                                <option value="">छान्नुहोस्</option>
                                                <?php foreach($workers as $worker){?>
                                                <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                <?php }?>
                                            </select>
                                            <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>"></form>
                                        </div>
                                      
                                        </div>
                                      
					 <div>
                                            <b> वोधार्थ </b><br>
                                            <span>१. <?= $data3->program_organizer_group_address ?>  न. वडा कार्यलय निर्माण कार्यको  अनुगमन र सहजिकरण गरिदिनु हुन </span><br>
                                            <span>२. प्राबिधिक शाखा....................... </span><br>
                                            <span style="margin-left:35px;"> <?php echo SITE_LOCATION;?> :- निर्माण कार्यमा प्राबिधिक सहयोग पुर्याउन हुनको साथै कार्य प्रगतिको जानकारी गराउनु हुन</span>
                                            <br><span style="">३. लेखा शाखा.........................</span>
                                        </div>
		                </div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>