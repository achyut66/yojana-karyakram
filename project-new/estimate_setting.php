<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin" && $mode!="subadmin")
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
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कामको विवरण सेटिंग || <a href="estimate_dashboard.php">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरणमा जानुहोस</a></h2>
                    
                    <div class="dashboardcontent">
                    	<a href="view_work_topic.php"><div class="userprofile">
                            <h3>कामको क्षेत्र थप्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="view_estimate.php"><div class="userprofile">
                            <h3>कामको विवरण थप्नुहोस</h3>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->	
                        
                        <div class="myspacer"></div>

                        
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>