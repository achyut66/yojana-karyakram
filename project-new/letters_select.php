<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
        //get_access_form($_SESSION['set_plan_id']);
        $final_data=  Planamountwithdrawdetails::find_by_plan_id($_SESSION['set_plan_id']);
?>
<?php $mode= getUserMode();
$user = getUser();
//print_r($mode);
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>
<style>
* {
  box-sizing: border-box;
}

/* Create three equal columns that floats next to each other */
.userprofile {
  float: left;
  width: 33.33%;
  padding: 20px;
  background-color:#bbb;
  height: 150px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
             <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="upabhoktasamitidashboard.php" class="btn">पछि जानुहोस </a> </h2>
          
            <div class="dashboardcontent">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h1 class="myHeading1">सम्झौता संग सम्बन्धित पत्रहरु</h1>
                <?php if($mode=="administrator"||$mode=="superadmin"):?>
                    <div class="grid-container">
                        <a href="print_bank_report08.php">
                    	<div class="userprofile grid-item">
                        	<h3>संझौताको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" target="_blank" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php endif; if($mode=="administrator"|| $mode=="superadmin"):?>
                        <a href="print_bank_report02.php">
                        <div class="userprofile grid-item">
                        	<h3>संझौता पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_05.php">
                        <div class="userprofile grid-item">
                        	<h3>संझौता कार्यदेश</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php endif;?>
                        <a href="dashboard_bhuktani.php">
                        <div class="userprofile grid-item">
                        	<h3>योजना सिफारिस </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="anugaman_samiti_patra.php">
                        <div class="userprofile grid-item">
                        	<h3>अनुगमन समितिको प्रतिबेदन</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="upabhokta_praman_patra.php">
                        <div class="userprofile grid-item">
                        	<h3>उपभोक्ता समिति दर्ता प्रमाण पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends-->
                    </div>
                    <div class="myspacer"></div>
                    <h1 class="myHeading1">पेस्की तथा म्याद थप र बैंक खाता सम्बन्धित पत्रहरु</h1>
                    <div class="grid-container">
                        
                        <a href="print_bank_report03_yojana.php">
                        <div class="userprofile grid-item">
                        	<h3>पेश्की टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_15.php">
                        <div class="userprofile grid-item">
                        	<h3>पेश्की टिप्पणी (आर्थिक प्रशासन)</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_04.php">
                        <div class="userprofile grid-item">
                        	<h3> पेश्की संझौताको कार्यदेश</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report07.php">
                        <div class="userprofile grid-item">
                        	<h3>म्याद थपको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                         <a href="print_bank_report06.php">
                            <div class="userprofile grid-item">
                        	<h3> म्याद थपको पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report01.php">
                            <div class="userprofile grid-item">
                        	<h3>बैंक खाता संचालनको पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                    </div>
                    <div class="myspacer"></div>
                <?php if($user->mode==user){?>
                <?php }else{?>
                    <h1 class="myHeading1">मुल्यांकन तथा अन्तिम भुक्तानी सम्बन्धित पत्रहरु</h1>
                    <div class="grid-container">
                        <a href="print_bank_report_bhuktani.php">
                        <div class="userprofile grid-item">
                        	<h3>उपभोक्ता समिति रनिंग बिल भुक्तानी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="karya_sampan.php">
                        <div class="userprofile grid-item">
                        	<h3>उपभोक्ता समिति अन्तिम भुक्तानी रकम माग निवेदन</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_09.php">
                        <div class="userprofile grid-item">
                        	<h3>मुल्यांकन टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_bank_report_16.php">
                        <div class="userprofile grid-item">
                        	<h3>मुल्यांकन टिप्पणी (आर्थिक प्रशासन)</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php if(!empty($final_data)):?>
                         <a href="print_bank_report_11.php">
                        <div class="userprofile grid-item">
                        	<h3>अन्तिम भुक्तानीको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <?php endif;?>
                        <?php if(!empty($final_data)):?>
                         <a href="print_bank_report_17.php">
                        <div class="userprofile grid-item">
                        	<h3>अन्तिम भुक्तानीको टिप्पणी (आर्थिक प्रशासन शाखा)</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="yojana_hastantaran_samjhauta.php">
                        <div class="userprofile grid-item">
                        	<h3>योजना हस्तान्तरण संझौता फारम</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <a href="plan_ifsuccess_letter.php">
                        <div class="userprofile grid-item">
                        	<h3>योजना प्रगति विवरण (प्राविधिक कर्मचारीहरुले भर्ने)</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                        <?php endif;?>
                    </div>
    <?php }?>
        </div>
    </div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>