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
                                    <span> नि.ब्या. श्री आयुष निर्माण सेवा </span><br>
                                    <span> प्रोः ममता मपध्याय </span><br>
                                
                                </div>
                                <div class="">
                                    <center> <h5> <b> विषय : म्याद थप सम्बन्धमा । </b> </h5></center>
                                </div>
								<br>
								<div class="bankname"> &nbsp; &nbsp; &nbsp; &nbsp;उपरोक्त सम्बन्धमा <?=SITE_NAME?> १ नं. वडा अन्तगत बुद्ध चौक पुर्व सडक निर्माण कार्यको लागि तपाईको बोलपत्र स्विकृत भई कार्य गदै जादा वर्षादको कारणबाट समयमा कार्य सम्पन्न हुन नसकेकाले म्याद थपका लागी दिएको निवेदनमा मिति : २०७५/५/१९ को निणयानुशार २०७५ साल मंसिर मसान्त सम्म म्याद थप गरिएको छ, प्राविधिकको निर्देशनमा तोकिएको समयमा कार्य मम्पन्न गर्न गराउन हुन अनुरोध छ ।      </div>
								<br>
                                <div class="">
                                    <b> वोधार्थ </b>
                                    <span> ई.श्री धनश्याम काफले </span><br>
                                    <span> वि.न.म.न.पा, प्राविधिक निर्देशन तथा </span><br>
                                    <span> ई.गोपाल पोखरेल </span><br>
                                    <span> वि.म.न.पा. </span>
                                </div>
                                
								<br>
								<br>
								
								<div class="">
								        <div class="oursignature"> 
                                           <span> चेतप्रसाद उप्रेती  </span><br>
                                            <span> उपसचिव </span><br>

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