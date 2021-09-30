<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}	$ward_address=WardWiseAddress();
	$address= getAddress();
	$datas  = Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);
        $worker =  Samitimoreplandetails::find_by_plan_id($_GET['id']);
        $data1  =  Plandetails1::find_by_id($_GET['id']);
        $fiscal =  FiscalYear::find_by_id($data1->fiscal_id);
        $data3  =  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
        $base_url = get_base_url(1);
        $print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
        $max_date   = DateEngToNep($print_date);
							
                        ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजना संझौता <a class="btn" href="dashboard_samiti_bhuktani.php"> पछी  जानुहोस </a> </h2>
                   
                    <div class="OurContentFull">
                    	<h2>योजना संझौता </h2>
                        <div class="myPrint">  <a href="print_details_view.php?id=<?=$_GET['id']?>&page=<?=$base_url?>" class="btn" target="_blank">प्रिन्ट विवरण</a>&nbsp;</div><br/><br/>
                        <form method="get" action="samiti_print_bank_report_14_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
								<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
	
<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									
<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($max_date)){echo $max_date;
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
										उपरोक्त बिषयमा <b><u> <?php echo $data3->program_organizer_group_name;?></u></b>ले यस कार्यालयमा दिएको निबेदन अनुसार <b><u><?php echo $data1->program_name;?></u></b> योजना संचालनका लागि नियम अनुसार योजना संझौता गरिदिनहुन अनुरोध छ ।
                                                                                </div><br>
										<div class="banktextdetails1">
                                                                                    <div class="subject"><u>तपशिल</u></div>
                                              <div class="mycontent" >
                    
                                              <?php 
                                              $data2=Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <h5>संस्था / समिति  सम्बन्धी विवरण भरिएको छैन </h5>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <h5>संस्था / समिति सम्बन्धी विवरण </h5>
                                              <div class="mycontent">
                                                   
                                                    <table class="table table-bordered table-responsive">
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
                                              <div class="mycontent">
                                                    <table class="table table-bordered table-responsive">
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
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>