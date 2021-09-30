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
                                        
                                    </div>
                                    <div class="my2">
                                        <div  class="mytitle1"><?=SITE_LOCATION?></div>
                                        <div class="mytitle2"><?=SITE_HEADING?></div>
                                        <div class="mytitle3"> <?=SITE_ADDRESS?> </div>
                                        <br>
                                    
                                        <p><b> बिषय : दरभाउपत्र मुल्याकनमा पेश गर्ने बारे । </b></p>
                                        <h4> टिप्पणी र आदेश </h4>
                                        
                                    </div>
                                    <div class="my3">
                                       <br><br><br>
                                        <p> मिति : २०७५/१/६</p>
                                    </div>
                                    <div class="myclear"></div>
                                    <br>
                                   
                                    
                               </div>
                                <!--   letter head close  -->
								<br>
								<div class="bankname"> <?=SITE_NAME?> बाट नगरको विभिन्न स्थानमा सडक निर्माण मर्मत गर्न भनि मिति <b> २०७५/१/५ </b> मा बोलपत्र दरभाउपत्र आहृानको सूचना प्रकाशित भई मिति <b> २०७५/२/४ </b> गते भित्र दर्ता भएका बोलपत्रहरुको मुल्याकन समितिको मिति <b> २०७५/२/१३ </b> को निर्णय बमोजिम मिति <b> २०७५/२/१५ </b> मा सार्वजनिम खरिद ऐन २०६३ को दफा २७ (२) बमोजिम आसयको सूचना प्रकाशित गरिएको । मिति सम्ममा कुनै दावा विरोध नपरेकाले तपशिलका बोलपत्रहरु स्वीकृतका गरी मिति: २०७६ श्रावण मसान्त सम्म कायम रहेको कार्या सम्पादन जमानत माग गरि ७ दिन भित्र संझौताको लागि आउन पत्राचार गर्ने तर्फ निर्णयार्थ पेश । </div>
								<br>
								<center> <b> तपसिल </b></center>
								<table class="table table-responsive table-bordered">
								    <tr>
								        <th> सि. न. </th>
								        <th> ठे. न. </th>
								        <th> कार्य विवरण </th>
								        <th> घटिकवोलगर्ने नि.ब्या.नाम </th>
								        <th> स्वीकृत रकम भ्याट समेत </th>
								        <th> ला.अ.मा. घटि % </th>
								        <th> कार्य सम्पादन जमानत रकम </th>
								    </tr>
								    <tr>
								        <td></td>
								        <td></td>
								        <td></td>
								        <td></td>
								        <td></td>
								        <td></td>
								        <td></td>
								    </tr>
								</table>
								
                           
                               
                            </div>
                            <br>
                            <br>
                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>