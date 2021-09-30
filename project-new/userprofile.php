<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>User Profile :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">नागरिक प्रोफाइल</h2>
                    <div class="OurContentLeft">
                    	<?php include("menuincludes/nagarikprofilemenu.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>प्रोफाइल थप्नुहोस </h2>
                        <div class="userprofiletable">
                            <table class="table table-bordered table-responsive">
                              <tr>
                                <td>पुरा नाम :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                               <td>पिताको नाम :</td>
                                <td><input type="text">	</td>
                              </tr>
                              <tr>
                                <td>हजुर बुबाको नाम :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>स्थायी ठेगाना :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>अस्थायी ठेगाना :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>नागरिकता नं:</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>नागरिकता जारी स्थान :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>नागरिकता जारी मिति :</td>
                                <td><input type="text"></td>
                              </tr>
                              <tr>
                                <td>सम्पर्क नं :</td>
                                <td><input type="text"></td>
                              </tr>
                              
                              <tr>
                                <td>फोटो :</td>
                                <td><input name="pic" required="" type="file"></td>
                              </tr>
                              <tr>
                                <td>नागरिकताको अगाडी :</td>
                                <td><input name="pic" required="" type="file"></td>
                              </tr>
                              <tr>
                                <td>नागरिकताको पछाडी :</td>
                                <td><input name="pic" required="" type="file"></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>फाइल अपलोड गर्नुहोस : </td>
                                <td><input name="pic" required="" type="file"></td>
                              </tr>
                              <tr>
                                <td>स्याम्पल :</td>
                                <td><a href="#">डाउनलोड </a></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" value="इन्ट्री गर्नुहोस" class="submithere"></td>
                              </tr>
                              
                            </table>
                        </div>

                        
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>