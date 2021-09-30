<?php require_once("includes/initialize.php"); ?>
<?php
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	if(isset($_GET['plan_id']))
	{
	     setPlanId($_GET['plan_id']);
	}
        if(isset($_GET['type']))
        {
            $_SESSION['check_type'] = $_GET['type'];
        }
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
        $check_customer = Costumerassociationdetails0::find_by_plan_id($_SESSION['set_plan_id']);
        (!empty($check_customer))? $bill_text = 'रनिङ्ग  बिल' : $bill_text='ठेक्का को बिल';
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
                    <h2 class="dashboard">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण | <a href="index.php" class="btn">ड्यासबोर्डमा जानुहोस</a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($plan_selected->id)?></h1>
                      <?php if(isset($_GET['msg'])):?>
                      <h1 style="color:red;" class="myHeading1"><?php echo $_GET['msg'];?></h1>
                       <?php endif;?>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="subadmin"||$mode="superadmin"):?>
                     <!-- <a href="estimate_anudan_details.php"><div class="userprofile">
                            <h3>अनुदान सम्बन्धी विवरण</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->	
                      <a href="estimate_lagat_anuman.php"><div class="userprofile">
                            <h3>इष्टिमेटको कुल लागत अनुमान</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                       <a href="napi_lagat_dashboard.php"><div class="userprofile">
                            <h3>नापी किताब </h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a>
                        
                        <a href="bill_dashboard.php"><div class="userprofile">
                            <h3>रनिङ्ग बिल</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="boq.php" target="_blank"><div class="userprofile">
                            <h3>BOQ</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a> <!--user profile ends--> 
                        
                        <a href="print_estimate_pratibedan.php"><div class="userprofile">
                            <h3>कार्यसम्पन्न प्रतिबेदन </h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a> 
                        <?php endif;?>
                        
                       
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>