<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$user = getUser();
$ward_address = WardWiseAddress();
$address = getAddress();
$date_selected= $_GET['date_selected'];
$datas  = Costumerassociationdetails::find_by_plan_id($_GET['id']);
$worker =  Moreplandetails::find_by_plan_id($_GET['id']);
$data1  =  Plandetails1::find_by_id($_GET['id']);
$fiscal =  FiscalYear::find_by_id($data1->fiscal_id);
$data3  =  Costumerassociationdetails0::find_by_plan_id($_GET['id']); 
$url = get_base_url();
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
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title> योजना संझौता | print page:: <?php echo SITE_SUBHEADING;?></title>

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
										यस गाउँपालिकाको <strong><?php echo $data1->parishad_sno;?></strong>बाट वडा नं. <strong><?php echo convertedcit($data1->ward_no);?></strong> मा संचालित <strong><?php echo $data1->program_name;?></strong> योजनाको लागि विनियोजित रकम रु. <strong><?php echo convertedcit($data1->investment_amount);?></strong> बाट मिति <strong><?php echo convertedcit($worker->samiti_gathan_date);?></strong> मा गठित <strong><?php echo $data3->program_organizer_group_name;?></strong> उपभोक्ता समितिले मिति <strong><?php echo convertedcit($worker->miti);?></strong> मा योजना सम्झौताको लागि सिफारिस गराई पाउँ भनि अनुरोध भइ आएकोमा सो योजना सार्वजनिक खरिद नियमावली २०६४ को नियम ९७ को उपनियम ९ मा व्यवस्था भए अनुसार उपभोक्ता समिति वा लाभग्राही समुदायबाट संचालित हुने निर्माण कार्यमा लोडर, ऐक्साभेटर, डोजर, ग्रेडर विटुमिन डिस्ट्रीव्युटर, विटुमिन व्याइलर जस्ता हेव्वी मेसिनहरु प्रयोग नगरि श्रममुलक प्राविधिबाट कार्य गराउने गरी लागत अनुमान स्वीकृत गराई सोही बमोजिम सम्झौता गरी मेशिनरी उपकरणको प्रयोग र उपनियम १० वमोजिम कुनै निर्माण व्यवसायी वा सव–कन्ट्राक्टरबाट कार्य नगराई सार्वजानिक खरिद नियमाली २०६४ को व्यवस्था र भावना बमोजिम वडा अध्यक्ष र वडामा निर्वाचित जनप्रतिनिधिको प्रत्यक्ष निर्देशन र नियन्त्रणमा राखि <strong><?php echo $data3->program_organizer_group_name;?></strong> उपभोक्ता समिति लाई कार्य गराईने छ । प्राविधिक स्टमेट बमोजिमको कार्य सम्पन्न गरि भविश्यमा मर्मत संभारको जिम्मेवारी समेत उपभोक्ता समितिबाट हुने गरि योजना सम्झौता गरिदिनहुन अनुरोध छ ।

                                        </div><br>
										<div class="banktextdetails1">
                                                                                    <div class="subject" style="margin-bottom: 15px;"><u>तपशिल</u></div>
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
                                              <h5 style="margin-top:5px;"><U>उपभोक्ता समिति  सम्बन्धी विवरण</U></h5>
                                              <div class="mycontent">
                                                   
                                                    <table class="table-bordered myWidth100" style="margin-bottom: 25px;">
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
                                              <h5><U>अनुगमन समिति सम्बन्धी विवरण</U></h5>
    
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
                                                         <?php  $i++; endforeach; ?>
                                                    </table>
                                             
                                              <?php }?>
                                        </div>
                                        <div class="myspacer20"></div>
										<div class="oursignature mymarginright">
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->