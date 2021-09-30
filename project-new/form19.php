<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
//{
//  redirectUrl();
//}
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>विषय:- योजना संझौता सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>



<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">  <a href="" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull" style="padding:10px;">
                    	
                      <div class="myPrint"><a href="" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable" id="div_print">
                            <!--    header open-->
                        	<div class="printPagea">
                               <div class="head">
                                    <div class="my1">
                                        <img src="images/emblem_nepal.png" alt="Logo"><br><br><br>
                                        <span> प. स. योजना</span><br>
                                        <span> च. नं. २८८७९ </span><br>
                                        
                                    </div>
                                    <div class="my2">
                                       <div  class="mytitle1"><?=SITE_LOCATION?></div>
                                        <div class="mytitle2"><?=SITE_HEADING?></div>
                                        <div class="mytitle3"> <?=SITE_ADDRESS?> </div>
                                        <br>
                                        <br>
                                          
                                    </div>
                                    <div class="my3">
                                      <br>
                                      <br>
                                       <span>फ्याक्स : ९७७-२१-५२५४५२</span><br>
                                       <span> फोन : ९७७-२१-५२३६३४ </span><br>
                                       <br>
                                       <br>
                                        <p> मिति : २०७५/१/६</p>
                                    </div>
                                    <div class="myclear"></div>
                                    
                               </div>
                                <!--   letter head close  -->
                                <br><br>
                                <div class="">
                                    <span> दोश्रो पक्ष ( निर्माण व्यवसायि ) श्री आयुष निर्माण सेवा </span><br>
                                    <span> प्रोः श्रीममता उपाध्याय </span><br>
                                    <span> विराटनगर </span>
                                </div>
                                <div class="">
                                    <center> <h5> <b> विषय : बैंक ग्यारेन्टी वारे । </b> </h5></center>
                                </div>
								<br>
								<div class="bankname"> &nbsp; &nbsp; &nbsp; &nbsp; <?=SITE_NAME?> अन्तरगत साविका वडा नं. २ पुर्वाञ्चल मेनेजमेन्ट कलेज नला निर्माणकार्यका लागी तपाई संग भएको संझौताका कममा तपाइले पेश गरेको कार्यसम्पादन जमानीपत्र सख्या : PB0016-0124-4274-18 को समय २०७६/४/३०  सम्म मात्र रहेकोमा उक्त योजनाको समयाबधी थप हुने भएकाले उक्त कार्यसम्पन्न जमानीपत्रको समय २०७६ असोज मसान्त सम्म थप गरी यथासिघ्र आउन हुन अनुरोध छ ।     </div>
								<br>
                                <b> तपसिल </b>
                                <p> १. कृषि विकास बैंक लि. <br> ( जानकरिका लागि )</p>
								<br>
								<br>
								
								<div class="">
								        <div class="oursignature"> 
                                           <span> कुमार प्रसाद दाहाल  </span><br>
                                            <span> प्रमुख प्रशासकीय अधिकृत </span><br>

                                        </div><br>
                                        
								    </div>
                            </div>
                            <br>
                            <br>
                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>