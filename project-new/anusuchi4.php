<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">अनुसूची ४ | <a href="letters_select.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="myPrint"><a href="anusuchi4_print.php" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    <br>
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									 <h5 class="letter_title_three mr">अनुसूची ४</h5>
                                    <h1 class="margin1em letter_title_one mr"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?></h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?> </h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                         <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>                              
                                        <div class="myspacer"></div>
										
										<div class="banktextdetails1">
                                        	<h4>कार्यविधिको दफा २०(ग) सँग सम्वन्धित</h4>
                                        <div class="mycontent" >
                                            <center> खर्च सार्वजनिक सूचना फाराम</center>
                                            <table class="table table-bordered table-responsive">
                                                <tr>
                                                    <td>आयोजनाको नामः  </td>
                                                    <td> &nbsp; </td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना स्थलः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> विनियोजित वजेटः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना स्विकृत भएको आ.वः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> आयोजना सम्झौता भएको मितिः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> काम सम्पन्न गर्नु पर्ने मितिः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> काम सम्पन्न भएको मितिः </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> टोल विकास संस्थाको बैठकले खर्च स्वीकृत गरेको मितिः— </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="">
                                                <b> आम्दानी र खर्चको विवरण   </b>
                                            </div>
                                            <table class="table table-bordered table-responsive">
                                                <tr>
                                                    <th colspan="2" class="myCenter"> आम्दानी </th>
                                                    <th colspan="2" class="myCenter"> खर्च </th>
                                                </tr>
                                                <tr>
                                                    <th class="myCenter"> विवरण </th>
                                                    <th class="myCenter"> रकम रू </th>
                                                    <th class="myCenter"> विवरण </th>
                                                    <th class="myCenter"> रकम </th>
                                                </tr>
                                                <tr>
                                                    <td>प्रथम किस्ता</td>
                                                    <td></td>
                                                    <td>ज्याला</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> दोश्रो किस्ता</td>
                                                    <td></td>
                                                    <td>निर्माण सामाग्री खरिद</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>तेश्रो किस्ता</td>
                                                    <td></td>
                                                    <td> ढुवानी</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> जनश्रमदान</td>
                                                    <td></td>
                                                    <td>भाडा	</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> वस्तुगत सहायता</td>
                                                    <td></td>
                                                    <td> व्यवस्थापन खर्च </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td> लागत सहभागिता</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                         <div class="">
                                             उपर्युक्तानुसारको आम्दानी तथा खर्च विवरण यथार्थ हो । यसमा सबै आम्दानी तथा खर्चहरु समावेश गरिएको छ । साथै उपभोक्ताहरुको प्रत्यक्ष सहभागितामा आयोजना कार्यान्वयन गरिएको छ । यसको एक प्रति वडा कार्यालयमा समेत पेश गरिएको छ । 
                                         </div>
                                        <div class="myspacer30"></div>
										
<!--										<div class="oursignature">कोषाध्यक्ष </div>-->
										<div class="oursignatureleft mymarginright">कोषाध्यक्ष  </div>
                                        <div class="oursignatureleft mymarginright"> सचिव   </div>
                                        <div class="oursignatureleft "> अध्यक्ष      </div>
                                            
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