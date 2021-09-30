<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">अनुसूची ६| <a href="letters_select.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="myPrint"><a href="anusuchi6_print.php" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    <br>
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									 <h5 class="letter_title_three mr">अनुसूची ६</h5>
                                    <h1 class="margin1em letter_title_one mr"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?></h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?> </h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>                              
                                        <div class="myspacer"></div>
										
										<div class="banktextdetails1">
                                           <h4> <?=SITE_NAME?> </h4>
                                        	<center> टोल विकास संस्थाको भौतिक तथा वित्तीय प्रगति प्रतिवेदन </center>
                                        	<center> विवरण पेश गरेको कार्यालय.................... </center>
                                        <div class="mycontent" >
                                           
                                            <table border="1px" class="table table-bordered table-responsive">
                                               आयोजनाको विवरणः
                                                    <tr>
                                                    <td>आयोजनाको नामः   </td>
                                                    <td> &nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td> वडा नं. टोल÷बस्तीः  </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> टोल विकास संस्थाका अध्यक्षः  </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>सचिवः</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना सम्पन्न हुने मितिः </td>
                                                    <td></td>
                                                </tr>
                                                
                                            </table>
                                            
                                            <table class="table table-responsive table-bordered">
                                                आयोजनाको लागतः 
                                                <tr>
                                                    <td>प्राप्त अनुदान रकम रू:</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>चन्दा रकम रू:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>जनसहभागिता रकम रू:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>जम्मा रकम रू. </td>
                                                    <td></td>
                                                </tr>       
                                            </table>
                                            
                                            <div>
                                                हालसम्मको खर्च रू. 
                                            </div>
                                            
                                           
                                               <div>कार्यालयबाट प्राप्त रकम रू:</div>
                                                <div>निर्माण सामग्रीमा (सिमेन्ट, छड, काठ, ढुंगा वा फुवा, गिट्टी, उपकरण आदि) रू.</div>
                                                <table class="table table-responsive table-bordered">
                                                  <div>
                                                      . ज्यालाः–
                                                  </div>
                                                   <tr>
                                                       <td> दक्ष रूः–  </td>
                                                       <td> </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                       <td>अदक्ष रू.    </td>
                                                       <td></td>
                                                   </tr>
                                                   <tr>
                                                       <td>जम्मा रू.</td>
                                                       <td></td>
                                                   </tr>
                                           
                                                </table>
                                               <div>मसलन्द सामान (कपि, कलम, मसी, कागज आदि) रू.  </div>
                                               <div>दैनिक भ्रमण भत्ता (सम्झौतामा स्वीकृत भए) रू.  </div>
                                               <div>प्राविधिक निरीक्षण बापत खर्च (सम्झौतामा स्वीकृत भए) रू. 	</div>
                                               <div>अन्य</div>
                                               
                                               <table class="table table-responsive table-bordered">
                                                    <tr>
                                                        <td>जनसहभागिताबाट व्यहोरिएको खर्च रूः </td>
                                                        <td></td>
                                                    </tr>
                                                       <tr>
                                                           <td>श्रमको मूल्य बराबर रकम रू. </td>
                                                           <td></td>
                                                    </tr>
                                                       <tr>
                                                        <td>जिन्सी सामान मूल्य बराबर रकम रू</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>कूल जम्मा रू</td>
                                                        <td> </td>
                                                    </tr>   
                                                   
                                               </table>
                                               <div class="">
                                                   ४. प्राविधिक प्रतिवेदन बमोजिम मूल्यांकन रकम रू. .............
                                               </div>
                                               <div class="">
                                                   ५. टोल विकास संस्थाको निर्णय बमोजिम÷समीक्षाबाट खर्च देखिएको रू. .............
                                               </div>
                                               <div class="">
                                                   ६. कार्यान्वयनमा देखिएका मुख्य समस्याहरूः क. ख. ग. 
                                               </div>
                                               <div class="">
                                                   ७. समाधानका उपायहरू क. 		ख.		ग. 
                                               </div>
                                               <div class="">
                                                   ८. कार्यालयबाट र अन्य निकायबाट अनुगमन भए अनुगमनको सुझावः 
                                               </div>
                                               <div class="">
                                                   ९. हाल माग गरेको किस्ता रकम रू. 
                                               </div>
                                               <div class="">
                                                   १०. मुख्य खर्च प्रयोजन 
                                               </div>
                                               <div class="">
                                                   ११. प्राप्त रकम आयोजना बाहेक अन्य कार्यमा खर्च गर्ने गराउने छैनौ ।  
                                               </div>
                                           
										
										<div class="myspacer"></div>
			
                                            
                                        <div class="myspacer30"></div>
										
<!--										<div class="oursignature">कोषाध्यक्ष </div>-->
										<div class="oursignatureleft mymarginright">सहसचिव	  </div>
                                        <div class="oursignatureleft mymarginright"> सचिव   </div>
                                        <div class="oursignatureleft "> कोषाध्यक्ष      </div>
                                        <div class="oursignatureleft "> उपाध्यक्ष      </div>
                                        <div class="oursignatureleft "> अध्यक्ष      </div>   
										</div><!-- bank details ends -->
										<div class="">
										    रोहबरमा बस्ने जनप्रतिनिधि
										</div>
										<div class="myspacer"></div>
										
                        </div>
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>