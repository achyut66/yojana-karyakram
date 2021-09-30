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
        $bill_dash_html = getBillDashHtml($max_period);
        
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
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="estimatedashboard.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="subadmin"||$mode="superadmin"):?>
                        <?php echo $bill_dash_html; ?>
                      <?php endif;?>
                        
                       
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>