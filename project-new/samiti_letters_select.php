<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
//        get_access_form($_SESSION['set_plan_id']);
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>
<!--<style>-->
<!--.grid-container {-->
<!--  display: grid;-->
<!--  grid-column-gap: 0px;-->
<!--  grid-row-gap:5px;-->
<!--  grid-template-columns: 500px 500px 500px;-->
<!--  background-color: #98AFC7;-->
<!--  padding: 10px;-->
<!--}-->

<!--.grid-item {-->
<!--  background-color: rgba(255, 255, 255, 0.8);-->
<!--  border: 3px solid rgba(0, 0, 0, 0.8);-->
<!--  padding: 5px;-->
<!--  font-size: 20px;-->
<!--  text-align: center;-->
<!--}-->
<!--</style>-->
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
          <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="anyasamitidasboard.php" class="btn">पछि जानुहोस </a> </h2>
            <div class="ourcontent">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <div class="grid-container">
               		    <a href="samjhauta_tippani_letter.php">
                        <div class="userprofile grid-item">
                        	<h3>संझौताको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samjhauta_letter.php">
                        <div class="userprofile grid-item">
                        	<h3>संझौता पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Settings Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_samjhauta_karyadesh.php">
                        <div class="userprofile grid-item">
                        	<h3>संझौता कार्यदेश</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_peski_samjhauta_tippani.php">
                        <div class="userprofile grid-item">
                        	<h3>पेश्की संझौताको टिप्पणी </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_peski_samjhauta_karyadesh.php">
                        <div class="userprofile grid-item">
                        	<h3> पेश्की संझौताको कार्यदेश </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_bank_letter.php">
                        <div class="userprofile grid-item">
                        	<h3> बैंक खाता संचालनको पत्र </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_additional_date_tippani_letter.php">
                        <div class="userprofile grid-item">
                        	<h3>म्यादको थपको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_add_date_letter.php">
                        <div class="userprofile grid-item">
                        	<h3> म्यादको थपको पत्र</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_analysis_letter.php">
                        <div class="userprofile grid-item">
                        	<h3> मुल्यांकनको आधारमा  भुक्तानीको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="samiti_final_letter.php">
                        <div class="userprofile grid-item">
                        	<h3>अन्तिम भुक्तानीको टिप्पणी</h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="dashboard_samiti_bhuktani.php">
                        <div class="userprofile grid-item">
                        	<h3>संस्था / समिति सिफारिस </h3>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                </div>
             </div>
        </div><!-- main menu ends -->
</div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>