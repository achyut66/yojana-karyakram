<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address = WardWiseAddress();
$address = getAddress();
$date_selected= $_GET['date_selected'];
$base_url = get_base_url();
$plan_id  = $_GET['id'];
$user     = getUser();
$max_count = PrintDetails::find_max_counter($base_url,$plan_id);
$print_details  = new PrintDetails;
$print_details->url  = $base_url;
$print_details->plan_id = $plan_id;
$print_details->user_id = $user->id;
$print_details->nepali_date = $_GET['date_selected'];
$print_details->english_date = DateNepToEng($_GET['date_selected']);
$print_details->counter       = $max_count + 1;
$print_details->save();
$datas  = Costumerassociationdetails::find_by_plan_id($_GET['id']);
$worker =  Moreplandetails::find_by_plan_id($_GET['id']);
$data1  =  Plandetails1::find_by_id($_GET['id']);
$fiscal =  FiscalYear::find_by_id($data1->fiscal_id);
$data3  =  Costumerassociationdetails0::find_by_plan_id($_GET['id']); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title> योजना संझौता | print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
									<h5 class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
                                   
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                                                                
										
										<div class="subject">   विषय:- संझौता गरिदिने बारे ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--><br>
                                       <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
										उपरोक्त बिषयमा <b><u> <?php echo $data3->program_organizer_group_name;?></u></b>ले यस कार्यालयमा दिएको निबेदन अनुसार <b><u><?php echo $data1->program_name;?></u></b> योजना संचालनका लागि मिति <?php echo convertedcit($worker->samiti_gathan_date);?> मा उपभोक्ताहरुको भेलाबाट देहाय बमोजिमको उपभोक्ता समिति र अनुगमन समिति गठन भएकाले नियम अनुसार योजना संझौता गरिदिनहुन अनुरोध छ ।
                                                                                </div><br>
										<div class="banktextdetails1">
                                                                                    <div class="subject"><u>तपशिल</u></div>
                                              <div class="mycontent" >
                    
                                              <?php 
                                              $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <h5 style="margin-top:5px;">उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन </h5>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <h5 style="margin-top:5px;">उपभोक्ता समिति  सम्बन्धी विवरण </h5>
                                              <div class="mycontent">
                                                   
                                                    <table class="table-bordered myWidth100">
                                                        <tr>
                                                            <td class="myCenter"><strong>सि.नं.</strong></td>
                                                            <td class="myCenter"><strong>पद</strong></td>
                                                            <td class="myCenter"><strong>नामथर</strong></td>
                                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                                            <td class="myCenter"><strong>लिगं</strong></td>
                                                            <td class="myCenter"><strong>नागरिकता नं</strong></td>
                                                            <td class="myCenter"><strong>जारी जिल्ला</strong></td>
                                                            <td class="myCenter"><strong>मोवाईल नं</strong></td>
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
                                                            <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                            <td class="myCenter"><?php echo Postname::getName($data->post_id);?> </td>
                                                            <td class="myCenter"><?php echo $data->name;?></td>
                                                            <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                            <td class="myCenter"><?php echo $gender;?> </td>
                                                            <td class="myCenter"><?php echo convertedcit($data->cit_no);?></td>
                                                            <td class="myCenter"><?php echo $data->issued_district;?></td>
                                                            <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                                        </tr>
                                                        <?php $i++; endforeach;?>
                                                    </table>
                                                </div>
                                              <?php } ?>
                                               <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
                                               if(empty($data4)){?>
                                             <div class="mycontent">
                                                  <h5>अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</h5>
                                               <?php } else {?>
                                              <h5>अनुगमन समिति सम्बन्धी विवरण</h5>
    
                                             </div>                                          
                                                    <table class="table-bordered myWidth100">
                                                        <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <td class="myCenter"><strong>सि.नं.</strong></td>
                                                            <td class="myCenter"><strong>पद</strong></td>
                                                            <td class="myCenter"><strong>नामथर</strong></td>
                                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                                            <td class="myCenter"><strong>लिगं</strong></td>
                                                            <td class="myCenter"><strong>मोवाईल नं</strong></td>                                    
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
                                                            <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                            <td class="myCenter"><?php echo Postname::getName($data->post_id);?></td>
                                                            <td class="myCenter"><?php echo $data->name;?></td>
                                                            <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td class="myCenter"><?php echo $gender;?> </td>
                                                            <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                                         </tr>
                                                         <?php endforeach; ?>
                                                    </table>
                                             
                                              <?php }?>
                                        </div>
<div class="myspacer30"></div>
										<div class="oursignature mymarginright"> सदर गर्ने </div>
										<div class="oursignatureleft mymarginright">तयार गर्ने  </div>
                                        <div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
                                        <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने       </div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->