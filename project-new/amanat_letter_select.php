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
                    <a href="amanat_tippani_patra.php">
                        <div class="userprofile grid-item">
                            <h3>संझौताको टिप्पणी</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" target="_blank" />
                            </div>
                        </div></a><!-- user profile ends -->
                    <?php endif; if($mode=="administrator"|| $mode=="superadmin"):?>
                        <a href="amanat_karyadesh_patra.php">
                            <div class="userprofile grid-item">
                                <h3>संझौता कार्यदेश</h3>
                                <div class="dashimg">
                                    <img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                                </div>
                            </div></a><!-- user profile ends -->
                    <?php endif;?>
                    <a href="amanat_rakam_nikasa_patra.php">
                        <div class="userprofile grid-item">
                            <h3>रकम निकासा सम्बन्धमा</h3>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a>
                    <a href="print_bank_report_04.php">
                        <div class="userprofile grid-item">
                            <h3>पेश्की संझौताको टिप्पणी</h3>
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
                        </div></a><!-- user profile ends-->
                </div>
                <div class="myspacer"></div>
                    <h1 class="myHeading1">मुल्यांकन तथा अन्तिम भुक्तानी सम्बन्धित पत्रहरु</h1>
                    <div class="grid-container">
                        <a href="print_bank_report_09.php">
                            <div class="userprofile grid-item">
                                <h3>मुल्यांकनको आधारमा  भुक्तानीको टिप्पणी</h3>
                                <div class="dashimg">
                                    <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                                </div>
                            </div></a><!-- user profile ends -->
                        <?php if(empty($final_data)){?>
                        <?php }else{?>
                        <a href="amanat_bhuktani_patra.php">
                            <div class="userprofile grid-item">
                                <h3>अन्तिम भुक्तानीको टिप्पणी</h3>
                                <div class="dashimg">
                                    <img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                                </div>
                            </div></a><!-- user profile ends -->
                        <?php }?>
                    </div>
            </div>
        </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>