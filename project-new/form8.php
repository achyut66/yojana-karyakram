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
                                    
                                        <p><b> बिषय : बोलपत्र दरभाउपत्र खोलिएको मूचूल्का </b></p>
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
								<div class="bankname"> श्रीमान् <br> &nbsp; &nbsp; &nbsp;  बिराटनगर महानगरपालिका कार्यालयबाट आ.व. <b> २०७४/०७५ </b> का लागी स्वीकृत योजना अन्तरगत नगरको विभिन्न क्षेत्रमा सडक निर्माण कार्यका लागी मिति : <b> २०७५/१/५ </b> गते बोलपत्र / दरभाउपत्र आहृान भएकोमा मिति : <b> २०७५/२/४ </b>  गते भित्र ठेक्का नं. <b> ५६ </b> मा <b> ९  </b> थान बोलपत्र विक्री भएकोमा ५ थान बोलपत्रहरु समय भित्र दर्ता भएकाले दर्ता भएका बोलपत्रहरु बोलपत्र मुल्याकन समितिमा पेश गर्ने तर्फ निर्णयार्थ पेश ।  </div>
								
								
                           
                               
                            </div>
                            <br>
                            <br>
                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>