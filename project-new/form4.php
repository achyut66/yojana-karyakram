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
                                        <img src="images/emblem_nepal.png" alt="Logo"><br><br>
                                        <span> प. स. योजना </span><br>
                                        <span> च. न. : १ </span>
                                    </div>
                                    <div class="my2">
                                        <div  class="mytitle1"><?=SITE_LOCATION?></div>
                                        <div class="mytitle2"><?=SITE_HEADING?></div>
                                        <div class="mytitle3"> <?=SITE_ADDRESS?> </div>
                                        <!--<div class="">  १ नं. प्रदेश नेपाल </div>-->
                                        <br>
                                        <br>
                                        <br>
                                        <h5><b> बिसय : सुचना टास सम्बन्धमा | </b></h5>
                                       
                                        
                                    </div>
                                    <div class="my3">
                                        <br><br>
                                        <span> फ्याक्स  : -----</span><br>
                                        <span> फोन : ------ </span><br>
                                        <br>
                                        <br>
                                        <span> मिति : २०७५/१/६</span>
                                    </div>
                                    <div class="myclear"></div>
                                    <br>
                                    <br>
                                    <br>
                                    
                               </div>
                                <!--   letter head close  -->
								<div class="">
								    <div class="my1" style="text-align:center">
								       <span>  श्री. कोष तथा लेखा नियन्त्रण कायालय समेत </span> <br>
								        <span> विराटनगर </span>
								    </div>
								    <div class="my2"> </div>
								    <div class="my3"> </div>
								    <div class="myclear"></div>
								</div>
								<br>
								
								<div class="bankname"> &nbsp; &nbsp; विराटनगर महानगरपालिकावाट मिति २०७५ / १ / ५ गते प्रकाशित बोलपत्र दरभाउपत्र अहृान सवन्धी सार्वजनिक सूचना यसै साथ संलग्न छ । तांहाको सूचना पाटीमा टांस गरि सो को जानकारी पठाई दिन हुन अनुरोध छ ।   </div>
								
                           
                               
                            </div>
                            <br>
                            <br>
                               <div class="">
								    <div class="my1"> &nbsp; </div>
								    <div class="my2"> &nbsp; </div>
								    <div class="my3" style="text-align:center">

								        <span class="mySignature"> प्रदिप कुमार निरौला </span> <br>
								        <span> &nbsp; </span>
								    </div>
								    <div class="myclear"></div>
								</div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>