<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}	
        $base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
        $ward_address=WardWiseAddress();
	$address= getAddress();
	$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
	$worker=Moreplandetails::find_by_plan_id($_GET['id']);
        $data1=  Plandetails1::find_by_id($_GET['id']);
        $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
        $data3=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
        
							
                        ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजना संझौता | <a href="dashboard_bhuktani.php" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>योजना संझौता </h2>
                    	<form method="get" action="print_bank_report_14_final.php" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
									<h5 class="margin1em letter_title_three"><?php echo $ward_address;?> </h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
                                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
                                        <div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
                                       
<!--                                        <div class="myspacer"></div>-->
										<div class="subject">विषय:- संझौता गरिदिने बारे ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><br/>
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
                                                  <h5>उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन </h5>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <h5>उपभोक्ता समिति  सम्बन्धी विवरण </h5>
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
                                              <h5>अनुगमन समिति सम्बन्धी विवरण</h5>
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
                                                         <?php endforeach; ?>
                                                    </table>
                                                </div>
                                              <?php }?>
                                              </div>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer"></div>
										
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>