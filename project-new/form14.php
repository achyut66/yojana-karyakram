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
                                        <span> च. नं. २८८७९ </span><br><br><br>
                                        <span> श्री नि. ब्या.आयुष निर्माण सेवा </span><br>
                                        <span> &nbsp; &nbsp; &nbsp; &nbsp; बिराटनगर </span>
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
                                    <div class="">
                                        <div class="my1" style="text-align:center">
                                            
                                        </div>
                                    </div>
                                   
                                    
                               </div>
                               <center> <h5> <b> बिषय : संझौता गर्न आउनहुन ।</b> </h5> </center>
                                <!--   letter head close  -->
								<br>
								<div class="bankname"> उपरोक्त सम्वन्धमा आ.व. <b> २०७५/०७५ </b> को स्वीकृत योजनाहरुको निर्माण कार्यको लागि बोलपत्र / दरभाउपत्र आव्हानको सूचना प्रकाशित भई दाखिला हुन आएका बोलपत्र / दरभाउपत्र मा सबैभन्दा घटी तपाईको स्वीकृत भएको हुदा जमानत तपशिलको हुने रकम को नगद वैंक भौचर वा  २०७६ श्रवण मसान्त सम्म अवधिको परफरमेन्सवौण्ड जमानत धरौटी सहित पत्र पाएको मितिले ०७ दिन भित्र संझौता गर्न आउनुहोला अन्यथा नियमनुसार हुने व्यहोरा समेत जानकारी गराइन्छ ।    </div>
								<br>
                                <b> तपसिल </b>
								<table class="table table-responsive table-bordered">
								    <tr>
                                        <th> # </th>
								        <th> योजनाको नाम </th>
								        <th> कबोलरकम ( मु. अ. कर समेत )  </th>
								        <th> ( धरौतिरकम वा पर्फमेन्सबोन्ड ) </th>
								        
								    </tr>
								    <tr>
                                        <td> 1 </td>
								        <td>  बूदचोक पूर्वसडक निर्माण ( ठे. न.)</td>
								        <td> रु १८७४,३७०/५५ </td>
								        <td> रु ३९५,०००</td>
								       
								    </tr>
								</table>
								<br>
								<br>
								<br>
								<div class="">
								        <div class="oursignature"> 
                                           <span> गोपाल पोखरेल  </span><br>
                                            <span> प्रमुख </span><br>
                                            <span> शहरी विकास तथा योजना महाशाखा </span>
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