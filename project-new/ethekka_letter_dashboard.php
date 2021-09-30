<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);

$program_id=$_SESSION['set_plan_id'];
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
        <h2 class="dashboard">ठेक्का  संचालन प्रकृया | <a href="contract_dashboard.php?id=<?= $program_id ?>" class="btn" >पछी जानुहोस </a></h2>
            <div class="OurContentFull">
				<h1 class="myHeading1">योजनाको नाम :: <?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>ठेक्का सम्झौता संग सम्बन्धित पत्रहरु छान्नुहोस् </h2>
                <div class="grid-container">
                    <a href="ethekka_tippani_patra.php">
                        <div class="userprofile grid-item">
                        	<h4>लागत अनुमान स्वीकृत गरि कार्य अगाडी बढाउने सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
               		  <a href="ethekka_aashay_suchana.php"> 
                      <div class="userprofile grid-item">
                        	<h4>आशयको सूचना प्रकाशन सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="ethekka_bolpatra_aashay.php">
                        <div class="userprofile grid-item">
                        	<h4>बोलपत्र स्वीकृत गर्ने आशयको सुचना</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="ethekka_jamanat_fukuwa.php">
                        <div class="userprofile grid-item">
                        	<h4>कार्य सम्पादन जमानत फुकुवा सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="ethekka_bolpatra_samjhauta.php">
                        <div class="userprofile grid-item">
                        	<h4>बोलपत्र स्वीकृत  एवं सम्झौता सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="ethekka_samjhauta.php">
                        <div class="userprofile grid-item">
                        	<h4>सम्झौता गर्न आउने सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="ethekka_karyadesh_patra.php">
                        <div class="userprofile grid-item">
                        	<h4>कार्यादेश सम्बन्धमा</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
            </div>
            <div class="myspacer"></div>
            <h2>ठेक्का पेस्की/म्याद थप/मुल्यांकन र अन्तिम भुक्तानी सम्बन्धित पत्रहरु छान्नुहोस् </h2>
            <div class="grid-container">
                <a href="contract_print_karyadesh_report_03.php">
                        <div class="userprofile grid-item">
                        	<h4>पेश्की कार्यदेशको टिप्पणी</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="contract_print_karyadesh_report_04.php">
                        <div class="userprofile grid-item">
                        	<h4>म्याद थप को टिप्पणी </h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="contract_print_karyadesh_report_05.php">
                        <div class="userprofile grid-item">
                        	<h4>म्याद थप को पत्र  </h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                          <a href="contract_print_karyadesh_report_06.php"> 
                          <div class="userprofile grid-item">
                        	<h4>मुल्यांकन भुक्तानीको टिप्पणी</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="contract_print_karyadesh_report_07.php">
                        <div class="userprofile grid-item">
                        	<h4>अन्तिम भुक्तानीको टिप्पणी</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
            </div>
       </div>
    </div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>