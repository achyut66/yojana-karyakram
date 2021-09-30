<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address = WardWiseAddress();
$address = getAddress();
$datas  = Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);
$worker =  Samitimoreplandetails::find_by_plan_id($_GET['id']);
$data1  =  Plandetails1::find_by_id($_GET['id']);
$fiscal =  FiscalYear::find_by_id($data1->fiscal_id);
$data3  =  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']); 
$ward_address=WardWiseAddress();
$address= getAddress();
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title> योजना संझौता | print page:: <?php echo SITE_SUBHEADING;?></title>
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
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                   
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                                                                 <div class="myspacer20"></div>
										
										<div class="subject">   विषय:- संझौता गरिदिने बारे ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--><br>
                                       <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
										उपरोक्त बिषयमा <b><u> <?php echo $data3->program_organizer_group_name;?></u></b>ले यस कार्यालयमा दिएको निबेदन अनुसार <b><u><?php echo $data1->program_name;?></u></b> योजना संचालनका लागि नियम अनुसार योजना संझौता गरिदिनहुन अनुरोध छ ।
                                                                                </div><br>
										<div class="banktextdetails1">
                                                                                    <div class="subject"><u>तपशिल</u></div>
                                              <div class="mycontent" >
                    
                                              <?php 
                                              $data2=Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <h5>संस्था / समिति सम्बन्धी विवरण भरिएको छैन </h5>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <h5>संस्था / समिति सम्बन्धी विवरण </h5>
                                              <div class="mycontent">
                                                   
                                                    <table class="table table-bordered myWidth100">
                                                        <tr>
                                                            <th>सिनं</th>
                                                            <th>पद</th>
                                                            <th>नामथर</th>
                                                            <th>ठेगाना</th>
                                                            <th>लिगं</th>
                                                            <th>नागरिकता नं</th>
                                                            <th>जारी जिल्ला</th>
                                                            <th>मोवाईल नं</th>
                                                        </tr>
                                                     <?php $i=1;foreach($datas as $data):
                                                         if($data->gender==1){
                                                             $gender="पुरुष ";
                                                         }
                                                         elseif($data->gender==2)
                                                         {
                                                              $gender="महिला";
                                                         }
?>
                                                        <tr>
                                                            <td><?php echo convertedcit($i);?></td>
                                                            <td><?php echo Postname::getName($data->post_id);?> </td>
                                                            <td><?php echo $data->name;?></td>
                                                            <td><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td><?php echo $gender;?> </td>
                                                            <td><?php echo convertedcit($data->cit_no);?></td>
                                                            <td><?php echo $data->issued_district;?></td>
                                                            <td><?php echo convertedcit($data->mobile_no);?></td>
                                                        </tr>
                                                        <?php $i++; endforeach;?>
                                                    </table>
                                                </div>
                                              <?php } ?>
                                               <?php $data4=  Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);
                                               if(empty($data4)){?>
                                              <h5>अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</h5>
                                               <?php } else {?>
                                              <h5>अनुगमन समिति सम्बन्धी विवरण</h5>
                                              
                                                    <table class="table table-bordered myWidth100">
                                                        <?php $data4=  Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <th>सिनं</th>
                                                            <th>पद</th>
                                                            <th>नामथर</th>
                                                            <th>ठेगाना</th>
                                                            <th>लिगं</th>
                                                            <th>मोवाईल नं</th>                                    
                                                        </tr>
                                                 <?php $i=1;foreach($data4 as $data):
                                                     if($data->gender==1){
                                                             $gender="पुरुष ";
                                                         }
                                                         elseif($data->gender==2)
                                                         {
                                                              $gender="महिला";
                                                         }?>
                                                        <tr>
                                                            <td><?php echo convertedcit($i);?></td>
                                                            <td><?php echo Postname::getName($data->post_id);?></td>
                                                            <td><?php echo $data->name;?></td>
                                                            <td><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td><?php echo $gender;?> </td>
                                                            <td><?php echo convertedcit($data->mobile_no);?></td>
                                                         </tr>
                                                         <?php endforeach; ?>
                                                    </table>
                                             
                                              <?php }?>
                                        </div>
										
									<div class="myspacer30"></div>
	
<div class="oursignature mymarginright"> सदर गर्ने </div>
<div class="oursignatureleft mymarginright">तयार गर्ने  </div>

<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>

<div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने       </dv>
<div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->