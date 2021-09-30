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
                                        <br>
                                        <br>
                                        <h4><b> बोलपत्र दरभाउपत्र खोलिएको मूचूल्का </b></h4>
                                       
                                        
                                    </div>
                                    <div class="my3">
                                        
                                    </div>
                                    <div class="myclear"></div>
                                    <br>
                                   
                                    
                               </div>
                                <!--   letter head close  -->
								<br>
								<div class="bankname">  आज मिति २०७५।२।४ का दिन बडा नं. १ मा ठेक्का नं. ५६ निर्माण कार्यको लागि मिति २०७५।१।५ मा प्रकाशित सुचना अनूसार मिति २०७५।२।४ गते भित्र द. नं. ३ मा दाखिला हून आएको निर्माण वयवसायि श्री <b> प्रदिप कुमार </b> को दरभाउपत्र र बोलपत्र प्रतिनिधिको रोहवर समेतमा खोलि हेर्दा तपसिल अनूसार उल्लेख भएको ।    </div>
								<center>
								    <b> बोलपत्र दरभाउपत्रमा भएको व्यहोरा  </b>
								</center>
								<br>
								<br>
								<br>
								<p> जमानत वापत <b> कृषि विकास </b> वैंककोज.स.नं. <b> १२३ </b> मिति <b> २०७५।१।५</b> वाट रु <b> ७६५४४ </b> को को मिति <b> २०७५।४।१८ </b> सम्म मान्य रहेको जमानीपत्र १ न.पा. व्यवसाय प्रमाणपत्र ६ नि.व्या. वगीकरण इजाजतपत्र ६ स्थाई लेखा नं. (पान) दर्ता प्रमाणपत्र ६ करचुक्ता प्रमाणपत्र छ । शिलबन्दी लाहाछापं थान ३ रहेको । </p>
                                <p> प्रतिनिधि : <b> निर्माण सेवा  </b> </p>
                                <p> नि.व्या. : <b> जे.सन. </b></p>
                                <p class="pull-right"> काम तामिल गर्ने </p>
                                
                                <br><br>
                                <div class="">
                                            <span> <b> <u> प्रतिनिधि </u></b></span><br>
                                            <span> जिल्ला प्रशासन कार्यालय, मोरङ्ग </span><br>
                                            <span> नाम : <b> राजन रेग्मी </b> </span><br>
                                            <span>दस्तखतः </span> <br>
                                            <span>कोष तथा लेखा नियन्त्रण कार्यालय, विराटनगर</span><br>
                                            <span>नाम : डेवि रंगन वराल </span><br>
                                            <span> दस्तखत : </span><br>
                                            <span> नगरपालिका कार्यालय प्रतिनिधि <b> गोपाल पोखरेल </b> </span>
                                            
                                </div>
                           
                               
                            </div>
                            <br>
                            <br>
                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>