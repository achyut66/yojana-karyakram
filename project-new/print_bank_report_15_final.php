<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
?>
     <?php
     $user = getUser();
     $data1=  Plandetails1::find_by_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    
    $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
     if(!empty($result))
        {
           $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
            $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $data4= AmanatLagat::find_by_plan_id($_GET['id']);
            $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
$data5=Planstartingfund::find_by_plan_id($_GET['id']);    
  $link = get_return_url($_GET['id']);
  $ward_address=WardWiseAddress();
$address= getAddress();
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$ward1 = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
	?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>पेश्की संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>
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

                                        <h5 class="marginright1.5 letter-title-four">
                                            <?php
                                            if($user->mode==user){
                                                echo $user->ward_add;
                                            }else {
                                                echo $ward_address;
                                            }
                                            ?>
                                        </h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    </div> 
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति :<?= convertedcit($_GET['date_selected']) ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<!--<div class="chalanino">चलानी नं :</div>-->
<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>


                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo "पेश्की उपलब्ध गराउने सम्बन्धमा ।";
                                                }?>
                                            </u>
                                        </div>
										<div class="myspacer"></div>
										<div class="bankname">श्री आर्थिक प्रशासन शाखा,<br/>
                                        <?php echo SITE_NAME ?>,<?php echo $ward_address;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार  तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न श्री <?php echo $data3->program_organizer_group_name;?>बीच  <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> मिति ‍<?php echo convertedcit($data2->miti);?> यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data5->advance_return_date);?><!--(पेश्की फर्छ्यौट गर्नु पर्ने मिति)--> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी रु <?php echo convertedcit($data5->advance);?><!--पेश्की दिएको रकम)--> पेश्की उपलब्ध गराउन हुन अनुरोध छ |
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered myWidth100">
                                                <!--	<tr>-->
                                                <!--    <td class="myWidth50 myTextalignLeft">बिनियोजन श्रोत र व्याख्या: </td>-->
                                                <!--    <td> <?php echo $data1->parishad_sno;?></td>-->
                                                <!--</tr>-->
                                            	<tr>
                                                	<td class="myWidth50 myTextalignLeft">योजनाको नाम : </td>
                                                    <td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">ठेगाना : </td>
                                                    <td><?php echo SITE_NAME?>-<?php echo convertedcit($ward1->program_organizer_group_address);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">विषयगत क्षेत्र किसिम : </td>
                                                        <td><?php echo Topicareatype::getName($data1->topic_area_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">शिर्षकगत किसिम : </td>
                                                    <td><?php echo Topicareatype::getName($data1->topic_area_type_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अनुदानको किसिम: </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignLeft">बजेट बिनियोजन :</td>
                                                    <td>रु. <?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft"><?=$name?> नगद साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य साझेदारी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft"><?=$name?> जनश्रमदान रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">कुल लागत अनुमान जम्मा रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->total_investment);?></td>
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
										
										<div class="myspacer30"></div>
										<div class="oursignature"></div>
									</div>
                                
                            
                        </div>
                        </div>
                  </div>
    