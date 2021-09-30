<?php require_once("includes/initialize.php"); ?>

<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
        if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
        {
          redirectUrl();
        }
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
        $data1 = Plandetails1::find_by_id($_GET['id']);
        $max_period = NapiLagatProfile::find_max_period($_GET['id']);
        $napi_dash_html = getNapiDashHtml($max_period);
        
?>
<?php $mode= getUserMode();?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title><?=$plan_selected->program_name?> </title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">नापी   हेर्नुहोस | <a href="estimatedashboard.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="subadmin"||$mode="superadmin"):?>
                        <?php echo $napi_dash_html; ?>
                      <?php endif;?>
                        
                       
                    </div>
                </div><!-- main menu ends -->
              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>