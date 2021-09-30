<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$ward_address=WardWiseAddress();
        $address= getAddress();
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
                        	<div class="printPage">
                                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                                <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                                <h5 class="margin1em letter_title_three"> <?php echo $ward_address;?></h5>
                                 <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
                                <div class="myspacer"></div>
                               
                                <div class="subject"> विषय:- योजना संझौता सम्बन्धमा । </div><br>
                                <div class="printContent">
                                
				               
								<div class="subject letter_subject">  टिप्पणी आदेश </div>
								
								<div class="bankname"> आ. व. 2074075 को नगरसभा बाट पारित बजेट शि. न. 6.05.4 सडक नाला तथा अन्य पुर्वाधार विकास कार्यक्रम र बजेट शि.नं. ६.०५.८ बडा स्तरीय योजना अन्तरगत बडाका विभिन्न तपशिल बमोजिक योजनाहरुको प्राविधिक बाट लागत अनुमान समेत पेश भएकाले सार्वजनिक खरिद ऐन २०६३ को दफा ११ अनुशार सिलबन्दि दरभाउपत्र  बोलपत्र आहृान गर्नु पर्ने देखी पेश गरेको छु ।  </div>
								<center> <b> तपशिल</b></center>
								<table class="table table-responsive table-bordered">
								    <tr>
								        <th class="myCenter"> सि. न. </th>
								        <th class="myCenter"> वडा. नं. </th>
								        <th class="myCenter"> ठे. न. </th>
								        <th class="myCenter"> कार्य विवरण </th>
								        <th class="myCenter"> ल. ई. रकम </th>
								        <th class="myCenter"> ओभर हेड </th>
								        <th class="myCenter"> मु. अ. कर </th>
								        <th class="myCenter"> जम्मा रकम </th>
								    </tr>
								    <tr>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								        <td>  </td>
								    </tr>
								</table>
  
								
										<div class="myspacer"></div>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>