<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
} 	
$plan_id= $_GET['id'];
print_r($plan_id);
?> 
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना को विवरण हटाऊने   :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको विवरण हटाऊनुहोस | <a href="plan_form_delete.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	<div class="settingsMenuWrap">
                            <div class="newMenu">
                     <?php $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                     ?>
                        <?php if(empty($data2)){?><h2  class="">उपभोक्ता समिति सम्बन्धी विवरण भरिएको छैन  </h2><?php }else{?>
                        <h2  class="">उपभोक्ता समिति  सम्बन्धी विवरण | <a class="btn"  href="settings_plan_form1_1_delete.php?id=<?=$plan_id?>" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')"> हटाउनुहोस्  </a></h2>
                        <div class="mycontent"  ><?php 
                                $data3=Costumerassociationdetails::find_by_plan_id($_GET['id']);?>
                            
                           
                            <table class=" table table-bordered table-hover">
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
                             <?php $i=1;foreach($data3 as $data):
                                 if($data->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($data->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
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
                         
                         <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);?>
                          <?php if(empty($data4)){?><h2  class=""> अनुगमन समिति सम्बन्धी थप विवरण भरिएको छैन   </h2><?php }else{?>
                         <h2  class="">अनुगमन समिति सम्बन्धी विवरण |  <a class="btn" href="settings_plan_form1_2_delete.php?id=<?=$plan_id?>" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')"> हटाउनुहोस्  </a></h2>
                       <div class="mycontent" >
                      
                           <table class="table table-bordered table-hover">
                                
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>ठेगाना</strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>मोबाइल नं</strong></td>
                                    
                                </tr>
                         <?php $i=1;foreach($data4 as $data):
                             if($data->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($data->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                             
                             ?>
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
                        </div>
                          <?php } ?>
                            <?php   $data=Plantotalinvestment::find_by_plan_id($_GET['id']);?>
                     <?php if(empty($data)){?><h2 class="myheader">  योजनाको कुल लागत अनुमान थप विवरण भरिएको छैन  </h2><?php }else{?>
                       <h2  class="myheader"> योजनाको कुल लागत अनुमान | <a class="btn" href="settings_plan_form1_9_delete.php?id=<?=$plan_id?>" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')"> हटाउनुहोस्  </a></h2>
                        <div class="mycontent" >
                         
                          <table class="table table-bordered table-hover">
                            <?php 
                              
                                $unit = Units::find_by_id($data->unit_id);
                            ?>
                             <tr>
                                <td class="myCenter myWidth50"> भौतिक ईकाईको  परिणाम :</td>
                                <td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                              <tr>
                              <td class="myCenter"><?php echo SITE_TYPE;?>बाट अनुदान रकम :</td>
                              <td>रु. <?php echo convertedcit($data->agreement_gauplaika);?></td>
                            </tr>
                            <tr>
                              <td class="myCenter">अन्य निकायबाट प्राप्त अनुदान रकम :</td>
                              <td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                            </tr>
                            <tr>
                              <td class="myCenter">समितिबाट नगद साझेदारी रकम :</td>
                              <td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                            </tr>
                            <tr>
                              <td class="myCenter">अन्य साझेदारी रकम :</td>
                              <td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                            </tr>
                            <tr>
                              <td class="myCenter">समितिबाट जनश्रमदान रकम  :</td>
                              <td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                            </tr>
                            <tr>
                              <td class="myCenter">कुल लागत अनुमान जम्मा रकम :</td>
                              <td>रु. <?php echo convertedcit($data->total_investment);?></td>
                            </tr>
                           
                          </table>
                        </div>
                     <?php } ?>
                          <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); ?>
                            <?php if(empty($data)){?><h2  class="">योजना सम्बन्धी अन्य विवरण भरिएको छैन  </h2><?php }else{?>
                         <h2 class="myheader">योजना सम्बन्धी अन्य विवरण | <a class="btn" href="settings_plan_form1_3_delete.php?id=<?=$plan_id?>" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">हटाउनुहोस्  </a>   </h2>
                          <div class="mycontent" >
                                    
                          <table class="table table-bordered table-hover">
                              
                              <tr>
                                    <td class="myWidth50 myCenter">उपभोक्ता समिति गठन भएको मिति :</td>
                                    <td ><?php echo convertedcit($data->samiti_gathan_date);?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter">उपभोक्ता भेलामा उपस्थिति संख्या :</td>
                                    <td><?php echo convertedcit($data->costumer_total_population);?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter">योजना शुरु हुने मिति :</td>
                                    <td><?php echo convertedcit($data->yojana_start_date);?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter">योजना सम्पन्न हुने मिति :</td>
                                    <td><?php echo convertedcit($data->yojana_sakine_date);?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम :</td>
                                    <td><?php echo  Workerdetails::getName($data->samjhauta_party);?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter">पद :</td>
                                    <td><?php  echo  $data->post_id_3;?></td>
                                  </tr>
                                  <tr>
                                    <td class="myCenter">मिती :</td>
                                    <td><?php echo convertedcit($data->miti);?></td>
                                  </tr>
                           </table>
                           </div>
                          
                          <h2 class="myheader"> योजनाबाट लाभान्वित घरधुरी तथा परिवारको विवरण </h2>
                            <div class="mycontent" >
                          <table class="table table-bordered table-hover">
                            <tr>
                                 
                                  <td colspan="5" style="text-align:center">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                	
                                        <td class="myCenter" ><strong>घर परिवार संख्या</strong></td>
                                      <td class="myCenter"><strong>महिला</strong></td>
                                      <td  class="myCenter"><strong>पुरुष</strong></td>
                                      <td  class="myCenter"><strong>जम्मा</strong></td>
                                    </tr>
                                    <?php $data= Profitablefamilydetails::find_by_type_id(0,$_GET['id']);?>
                                 <tr>

                                      <td class="myCenter"><?php echo convertedcit($data->pariwar_population);?></td>
                                     <td  class="myCenter"><?php echo convertedcit($data->female);?></td>
                                      <td class="myCenter"><?php echo convertedcit($data->male);?></td>
                                      <td class="myCenter"><?php echo convertedcit($data->total);?></td>
                                  </tr>
                          </table>
                             </div>
                            <?php } ?>
                       </div>
                            
                        </div>
                        <div class="myspacer"></div>

                </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
   
    <?php include("menuincludes/footer.php"); ?>