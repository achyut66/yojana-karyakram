<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">अनुसूची ३ | <a href="letters_select.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="myPrint"><a href="anusuchi3_print.php" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    <br>
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									 <h5 class="letter_title_three mr">अनुसूची ३</h5>
                                    <h1 class="margin1em letter_title_one mr"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?></h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?> </h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>                              
                                        <div class="myspacer"></div>
										
										<div class="banktextdetails1">
                                        	<h4>कार्यविधिको दफा २०(ख) सँग सम्वन्धित</h4>
                                        <div class="mycontent" >
                                            <center> सार्वजनिक परीक्षण फारामको ढाँचा पेश गरेको कार्यालय..........</center>
                                            <table class="table table-bordered table-responsive">
                                                <tr>
                                                    <td> आयोजनाको नामः </td>
                                                    <td> आयोजनाको नामः  </td>
                                                </tr>
                                                <tr>
                                                    <td> स्थलः</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> लागत अनुमानः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना शुरू हुने मितिः   </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना सम्पन्न हुने मितिः </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="">
                                                <b> <center> टोल विकास संस्थाको</center>   </b>
                                            </div>
                                            <table class="table table-bordered table-responsive">
                                                <tr>
                                                    <td> नामः</td>
                                                    <td> name</td>
                                                </tr>
                                                <tr>
                                                    <td> अध्यक्षको नामः  </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> सदस्य संख्याः    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> महिलाः</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>  पुरूषः </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="">
                                                <center><b> आम्दानी खर्चको विवरणः  </b></center>
                                                <div class="">क) आम्दानीतर्फ जम्माः</div>
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th>  आम्दानीको श्रोत (कहाँबाट कति नगद तथा जिन्सी प्राप्त भयो खुलाउने) </th>
                                                        <th> रकम वा परिमाण </th>
                                                        <th> कैफियत </th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="">
                                                <div class=""> ख) खर्चतर्फ </div>
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th>खर्चको विवरण</th>
                                                        <th> दर </th>
                                                        <th> परिमाण </th>
                                                        <th> जम्मा </th>
                                                    </tr>
                                                    <tr>
                                                        <td>१. सामाग्री (के के सामाग्री खरिद भयो ?)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>२. ज्याला (के मा कति भुक्तानी भयो ?)</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> ३. श्रमदान (कति जनाले श्रमदान गरे ?) </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> ४. व्यवस्थापन खर्च (ढुवानी तथा अन्य खर्च) </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="">
                                                <div class="">ग) मौज्दात </div>
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th> विवरण</th>
                                                        <th>  रकम वा परिमाण</th>
                                                        <th> कैफियत</th>
                                                    </tr>
                                                    <tr>
                                                        <td>१ नगद</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>बैंक</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>व्यक्तिको जिम्मा</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> २ सामग्रीहरु </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="">
                                                <div class=""> घ) भुक्तानी दिन बाँकी </div>
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th>विवरण</th>
                                                        <th> रकम वा परिमाण</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="">
                                                <div class=""> ४. सम्पन्न आयोजनाको लक्ष्य तथा प्रगति विवरण </div>
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th> कामको विवरण </th>
                                                        <th> लक्ष्य</th>
                                                        <th> प्रगति </th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="">
                                                <div class=""> 
                                                    ५. आयोजनाले पु¥याएको लाभ तथा प्रत्यक्ष रूपमा लाभान्वित जनसंख्या (आयोजना सञ्चालन भएको स्थानका उपभोक्ताहरू) । 
                                                </div>
                                                <div class="">
                                                    ६. आयोजना सञ्चालन गर्दा आयोजक संस्थामा कामको जिम्मेवारी बाँडफाँड (कस कसले कस्तो कस्तो कामको जिम्मेवारी लिएका थिए खुलाउने)
                                                </div>
                                                <div class="">उपस्थितिः</div>
                                                <table class="table table-responsive table-bordered">
                                                   <tr>
                                                       <th> # </th>
                                                       <th> नाम </th>
                                                   </tr>
                                                    <tr>
                                                        <td> 1 </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> 2 </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> 3 </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> 4 </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> 5 </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                                
                                            </div>
                                            <div class="">
                                                <table class="table table-bordered table-responsive">
                                                    <tr>
                                                        <td> रोहवरमा बस्ने जनप्रतिनिधिको नामथरः	 </td>
                                                        <td> full name</td>
                                                    </tr>
                                                    <tr>
                                                        <td> पदः </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> रोहवरमा बस्ने जनप्रतिनिधिको हस्ताक्षरः </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td> मितिः </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                                <div class="">द्रष्टव्यः सार्वजनिक परिक्षण कार्यक्रममा उपस्थित सरोकारवालाहरुको उपस्थिति अनिवार्य रूपमा संलग्न हुनुपर्नेछ ।</div>
                                            </div>
                                            
										</div><!-- bank details ends -->
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