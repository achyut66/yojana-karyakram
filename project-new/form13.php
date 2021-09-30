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
                                    
                                        <p><b> दरभाउपत्र स्विकृत आशयको सार्वजनिक सूचना </b></p>
                                        <p><b> सूचना &nbsp; सूचना &nbsp;  सूचना </b></p>
                                        <p><b> सूचना प्रकाशित मिति : २०७५/१/५ </b></p>
                                        
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
								<div class="bankname"> इसि कार्यालयवाट सडक निर्माण कार्यका लागी मिति : <b> २०७५/१/५ </b> गते प्रकाशित बोलपत्र आहृान सम्बन्धी सूचना अनुसार तपशिल वमोजिमको  शिलबन्दी बोलपत्रहरु न्यूनतम मुल्याकित सारभुत रुपमा प्रभावग्राही ठहर भई स्वीकृत गरीने भएकाले सार्वजनिक खरिद ऐन, २०६३ को दझा २७ २ को प्रयोगनार्थ सम्बन्धित सबै सरोकारबालाहरुको जानकारीको लागि ७ दिने सार्वजनिक सूचना प्रकाशित गरिएको छ ।  </div>
								<br>
								<center> <b> तपसिल </b></center>
								<table class="table table-responsive table-bordered">
								    <tr>
								        <th> सि. न. </th>
								        <th> ठे. न. </th>
								        <th> कार्य विवरण </th>
								        <th> घटिकवोलगर्ने नि.ब्या.नाम </th>
								        <th> ठेगाना </th>
								        <th> दरभाउ पत्रमा घटि कवोल रकम </th>
								        <th> ला.अ.मा घटि % </th>
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