<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$user=getUser();
//print_r($user);
$ward_address=WardWiseAddress();
	$address= getAddress();
	$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
	//print_r($datas);
	$worker=Moreplandetails::find_by_plan_id($_GET['id']);
	//print_r($worker);
    $data1=  Plandetails1::find_by_id($_GET['id']);
        //print_r($data1);
    $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
    $data3=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    //print_r($data3);
      $workers = Workerdetails::find_all();
      $worker_ward = Workerdetails::find_by_sql("select * from worker_details where authority_ward_no =".$user->ward);
//      print_r($worker_ward);
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
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
}  
							
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>
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
    	
                <div class="maincontent">
                    <form method="get" action="print_bank_report_14_final.php">
                    <h2 class="headinguserprofile">योजना संझौता | <a href="dashboard_bhuktani.php" class="btn">पछि जानुहोस </a>
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    </h2>
                    
                    <div class="OurContentFull">
                    	<h2>योजना संझौता </h2>
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
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
                                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
                                        <div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
                                        <div class="chalanino"> चलानी नं . : </div>
										<div class="subject"><u>विषय:- सम्झौताको लागि सिफारिस गरिएको बारे । </u></div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><br/>
                                        <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
										<div class="banktextdetails"  >
										यस गाउँपालिकाको <strong><?php echo $data1->parishad_sno;?></strong>बाट वडा नं. <strong><?php echo convertedcit($data1->ward_no);?></strong> मा संचालित <strong><?php echo $data1->program_name;?></strong> योजनाको लागि विनियोजित रकम रु. <strong><?php echo convertedcit($data1->investment_amount);?></strong> बाट मिति <strong><?php echo convertedcit($worker->samiti_gathan_date);?></strong> मा गठित <strong><?php echo $data3->program_organizer_group_name;?></strong> उपभोक्ता समितिले मिति <strong><?php echo convertedcit($worker->miti);?></strong> मा योजना सम्झौताको लागि सिफारिस गराई पाउँ भनि अनुरोध भइ आएकोमा सो योजना सार्वजनिक खरिद नियमावली २०६४ को नियम ९७ को उपनियम ९ मा व्यवस्था भए अनुसार उपभोक्ता समिति वा लाभग्राही समुदायबाट संचालित हुने निर्माण कार्यमा लोडर, ऐक्साभेटर, डोजर, ग्रेडर विटुमिन डिस्ट्रीव्युटर, विटुमिन व्याइलर जस्ता हेव्वी मेसिनहरु प्रयोग नगरि श्रममुलक प्राविधिबाट कार्य गराउने गरी लागत अनुमान स्वीकृत गराई सोही बमोजिम सम्झौता गरी मेशिनरी उपकरणको प्रयोग र उपनियम १० वमोजिम कुनै निर्माण व्यवसायी वा सव–कन्ट्राक्टरबाट कार्य नगराई सार्वजानिक खरिद नियमाली २०६४ को व्यवस्था र भावना बमोजिम वडा अध्यक्ष र वडामा निर्वाचित जनप्रतिनिधिको प्रत्यक्ष निर्देशन र नियन्त्रणमा राखि <strong><?php echo $data3->program_organizer_group_name;?></strong> उपभोक्ता समिति लाई कार्य गराईने छ । प्राविधिक स्टमेट बमोजिमको कार्य सम्पन्न गरि भविश्यमा मर्मत संभारको जिम्मेवारी समेत उपभोक्ता समितिबाट हुने गरि योजना सम्झौता गरिदिनहुन अनुरोध छ ।

                                        </div><br>
										<div class="banktextdetails1">
                                        <div class="subject"><u>तपशिल</u></div>
                                              <div class="mycontent" >
                                              <?php 
                                              $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <h5>उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन </h5>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <h5><U>उपभोक्ता समिति  सम्बन्धी विवरण </U></h5>
                                              <div class="mycontent">
                                                   
                                                    <table class="table table-bordered table-responsive">
                                                        <tr>
                                                            <td class="myCenter"><strong>सि.नं.</strong></td>
                                                            <td class="myCenter"><strong>पद</strong></td>
                                                            <td class="myCenter"><strong>नामथर</strong></td>
                                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                                            <td class="myCenter"><strong>लिगं</strong></td>
                                                            <td class="myCenter"><strong>नागरिकता नं</strong></td>
                                                            <td class="myCenter"><strong>जारी जिल्ला</strong></td>
                                                            <td class="myCenter"><strong>मोबाइल  नं</strong></td>
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
                                              <h5>अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</h5>
                                               <?php } else {?>
                                              <h5><U>अनुगमन समिति सम्बन्धी विवरण</U></h5>
                                              <div class="mycontent">
                                                    <table class="table table-bordered table-responsive">
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
                                                         <?php $i++; endforeach; ?>
                                                    </table>
                                                </div>
                                              <?php }?>
                                              </div>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer20"></div>
										<div class="oursignature mymarginright">वडा अध्यक्ष<br>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($worker_ward as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                										
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->