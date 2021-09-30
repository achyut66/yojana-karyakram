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
                    
                    <div class="OurContentFull" >
                    	
                      <div class="myPrint"><a href="" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable" id="div_print">
                            <!--    header open-->
                        	<div class="printPagea">
                               <div class="head">
                                    <div class="my1">
                                        <img src="images/emblem_nepal.png" alt="Logo"><br><br>
                                        <span> प. स. योजना </span><br>
                                        <span> च. न.  </span>
                                    </div>
                                    <div class="my2">
                                         <div  class="mytitle1"><?=SITE_LOCATION?></div>
                                        <div class="mytitle2"><?=SITE_HEADING?></div>
                                        <div class="mytitle3"> <?=SITE_ADDRESS?> </div>
                                        <br>
                                        <br>
                                        <br>
                                        <h5><b> बिसय : सुचना प्रकाशित गरी दिने बारे | </b></h5>
                                       
                                        
                                    </div>
                                    <div class="my3">
                                        <br><br>
                                        <span> फयास : १७७-२१-५२५४२२ </span><br>
                                        <span> फोन : 123 456 789 </span>
                                    </div>
                                    <div class="myclear"></div>
                                    <br>
                                    <br>
                                    <br>
                                    
                               </div>
                                <!--   letter head close  -->
								<div class="">
								    <div class="my1" style="text-align:center">
								       <span>  श्री. मिडिया  रिलेसन्स एड्भटाईजीङ्ग </span> <br>
								        <span> प्रा.लि. विराटनगर </span>
								    </div>
								    <div class="my2"></div>
								    <div class="my3"></div>
								    <div class="myclear"></div>
								</div>
								<br>
								
								<div class="bankname"> यस आ.व. २०७४ / ०७५ मा तपसिल अनुसारको योजनाहरु को निर्माण कार्य बोलपत्र दरभाउपत्र आह्वान गरी गराउने निर्णय भएको हुदा इजाजत प्राप्त निर्माण व्यवसायीहरु ले यो सुचना प्रकाशित भएको मितिले बोलपत्र ३० औ दिन दरभाउपत्र १५ औ दिन भित्र खरीदारी ( दरभाउपत्र / दस्तुर पछि फिर्ता नहुने गरि ) विराटनगर महानगरपालिकाको नाममा सिलबन्धी बोलपत्र / दरभाउपत्र दर्ता गराउन सम्बधित सबैको जानकारीको लागि यो सुचना प्रकाशित गरिएको छ ।  </div>
								
                           
                               
                            </div>
                            <br>
                            <br>
                               <div class="">
								    <div class="my1"> &nbsp; </div>
								    <div class="my2"> &nbsp; </div>
								    <div class="my3" style="text-align:center">

								        <span class="mySignature"> प्रदिप कुमार निरौला </span> <br>
								        <span> प्रमुख प्रशासकीय अधिकृत </span>
								    </div>
								    <div class="myclear"></div>
								</div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>