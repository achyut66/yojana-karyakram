<?php require_once("includes/initialize.php"); ?>

<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
?>
<?php $mode= getUserMode();?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$plan_selected->program_name?> ::Kanepokhari Gaupalika</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="estimatedashboard.php">पत्रहरुमा जानुहोस</a> | <a href="index.php">ड्यासबोर्डमा जानुहोस</a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="subadmin"||$mode="superadmin"):?>
                      <a href="print_estimate_lagat.php"><div class="userprofile">
                            <h3>लागत अनुमान</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->	
                        <a href="print_estimate_pratibedan.php"><div class="userprofile">
                            <h3>कार्यसम्पन्न प्रतिबेदन</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_estimate_naapi_dash.php"><div class="userprofile">
                            <h3>नापी किताब</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        
                        <a href="print_estimate_bill.php"><div class="userprofile">
                            <h3>ठेक्का को बिल</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <?php endif;?>
                        
                       
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>