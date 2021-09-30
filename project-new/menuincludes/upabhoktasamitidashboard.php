<?php require_once("includes/initialize.php"); ?>

<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
?>
<?php $mode= getUserMode();?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$plan_selected->program_name?> ::<?php echo SITE_SUBHEADING;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">उपभोक्ता समिति मार्फत | <a href="yojanasanchalandash.php">योजना संचालन प्रकृया</a> | <a href="index.php">Dashboard</a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"):?>
                    	<div class="userprofile">
                        	<h3><a href="plan_form1.php">योजनाको कुल लागत अनुमान</a></h3>
                            <div class="dashimg">
                            	<a href="plan_form1.php"><img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <div class=" userprofile">
                        	<h3><a href="plan_form1_1.php">उपभोक्ता समिति विवरण </a></h3>
                            <div class="dashimg">
                            	<a href="plan_form1_1.php"><img src="images/user-profile.png" alt="Settings Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                       
                        <div class="userprofile">
                        	<h3><a href="plan_form1_2.php">अनुगमन समिति विवरण</a></h3>
                            <div class="dashimg">
                            	<a href="plan_form1_2.php"><img src="images/office-icon.png" alt="Billing Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        
                        <div class="userprofile">
                        	<h3><a href="plan_form1_3.php">योजना सम्बन्धी अन्य विवरण</a></h3>
                            <div class="dashimg">
                            	<a href="plan_form1_3.php"><img src="images/report-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <div class="userprofile">
                        	<h3><a href="letters_select.php">पत्रहरु </a></h3>
                            <div class="dashimg">
                            	<a href="letters_select.php"><img src="images/patra-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                        <?php endif;?>
                         <?php if($mode=="administrator"):?>
                        <div class="userprofile">
                        	<h3><a href="bhuktani_select.php">भुक्तानी </a></h3>
                            <div class="dashimg">
                            	<a href="bhuktani_select.php"><img src="images/report-icon.png" alt="Report Icons" class="dashimg" /></a>
                            </div>
                        </div><!-- user profile ends -->
                      <?php endif;?>
                       
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>