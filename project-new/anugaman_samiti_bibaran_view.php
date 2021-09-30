<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
} 	?>

<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>सेटिंग :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
                <div class="maincontent">
                    <h2 class="headinguserprofile">सेटिंग | <a href="index.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	<div class="dashboardcontent">
                            <a href="anugaman_samiti_bibaran.php">
                                	<div class="userprofile25">
                                		<h4>अनुगमन समिति सम्बन्धी विवरण भर्नुहोस्</h4>
                                		<div class="dashimg">
		                                        <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
		                                </div>
                                	</div>
                            </a>
                        </div>
                  </div>
                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>