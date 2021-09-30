<?php require_once("includes/initialize.php"); ?>
<?php
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
//get_access_form($_SESSION['set_plan_id']);
$final_data = Planamountwithdrawdetails::find_by_plan_id($_SESSION['set_plan_id']);
?>
<?php $mode = getUserMode(); ?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् :: <?php echo SITE_SUBHEADING; ?></title>
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
        <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="upabhoktasamitidashboard.php" class="btn">पछि
                जानुहोस </a></h2>

        <div class="dashboardcontent">
            <h1 class="myHeading1"><?= $plan_selected->program_name ?></h1>
            <div class="myMessage"><?php echo $message; ?></div>
            <h1 class="myHeading1">पत्रहरु छान्नुहोस् </h1>
            <?php if ($mode == "administrator" || $mode == "superadmin"): ?>
            <div class="grid-container">

                <?php endif;
                if ($mode == "administrator" || $mode == "user" || $mode == "superadmin"): ?>


                    <a href="quotation_letter.php">
                        <div class="userprofile grid-item">
                            <h3>कोटेशनबाट खरीद टिप्पणी/ दररेट पेश पत्र </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->

                    <a href="print_quotation_kabol.php">
                        <div class="userprofile grid-item">
                            <h3>कोटेसन स्वीकृत गर्ने सम्बन्धमा </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->

                    <a href="print_quotation_kabol_samjhauta.php">
                        <div class="userprofile grid-item">
                            <h3>सम्झौता गर्न आउने बारेको चिठी </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->

                    <a href="print_quotation_kabol_samjhauta_patra.php">
                        <div class="userprofile grid-item">
                            <h3>गाउँ कार्यपालिकाको कार्यालय र स्वीकृत निर्माण व्यवसायी/कम्पनी/फर्मबीचको
                                सम्झौता-पत्र </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->
                    <a href="print_quotation_kabol_karyadesh.php">
                        <div class="userprofile grid-item">
                            <h3>स्वीकृत फर्म/कम्पनीलाई दिइने कार्यादेश-पत्र </h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->
                    <a href="quotation_antim_bhuktani.php">
                        <div class="userprofile grid-item">
                            <h3>अन्तिम भुक्तानीको टिप्पणी</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg"/>
                            </div>
                        </div>
                    </a><!-- user profile ends -->

                <?php endif; ?>


            </div>


        </div>
    </div><!-- main menu ends -->

</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
