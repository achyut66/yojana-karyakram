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
                                        <br>
                                        <br>
                                        <br>
                                        
                                       
                                        
                                    </div>
                                    <div class="my3">
                                        <br><br>
                                        <span> फयास : -----</span><br>
                                        <span> फोन : ------ </span><br>
                                        <br>
                                        <br>
                                        <span> मिति : २०७५/१/६</span>
                                    </div>
                                    <div class="myclear"></div>
                                    <br>
                                   
                                    
                               </div>
                                <!--   letter head close  -->
								<div class="">
								    <div class="my1" style="text-align:center">
								       <span>  श्री. जिल्ला प्रकासन कार्यलय</span> <br>
								        <span> <?=SITE_ADDRESS?> </span>
								    </div>
								    <div class="my2"> </div>
								    <div class="my3"> </div>
								    <div class="myclear"></div>
								</div>
								<center> <h4><b> विषय : प्रतिनिधि पठाई दिने सम्बन्धमा । </b></h4> </center>
								<br>
								<br>
								<div class="bankname"> &nbsp; &nbsp; &nbsp; &nbsp; उपयुक्त सम्बन्धमा यस महानगरपालिका अन्तरगत नगरको विभिन्न सडकको निर्माण कार्यको बोलपत्र दरभाउपत्र आव्हान भई मिति ः २०६५ । २ । ४ गते दिनको १२ बजे भित्र दाखिला हुन आएका बोलपत्रहरु सोही दिन मिति ः २०७५।२।४ सुक्रवार दिन दिनको १४ बजे देखी वि.म.न.पा मा खोलिने हुदां उक्त समयमा १ जना प्रतिनिधी साक्षीको लागि पठाई दिनहुन अनुरोध गर्दछु ।   </div>
								
                           
                               
                            </div>
                            <br>
                            <br>
                               <div class="">
								    <div class="my1"> &nbsp; </div>
								    <div class="my2"> &nbsp; </div>
								    <div class="my3" style="text-align:center">

								        <span class="mySignature"> ई. गोपाल पोखरेल  </span> <br>
								        <span> प्रपुख <br> शहरी विकास तथा योजना महाशाख</span>
								        
								    </div>
								    <div class="myclear"></div>
								</div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>