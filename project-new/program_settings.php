<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>सेटिंग :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">सूची दर्ता | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>
                   <div class="OurContentFull">
                    	<a href="settings_enlist_view.php">
                        	<div class="userprofile">
                            	<h3>सूची दर्ता हेर्नुहोस् </h3>
                                <div class="dashimg">
                            	<img src="images/new_plan_icon.png" alt="New Plan  Icons" class="dashimg" />
                            </div>
                            </div>
                        </a>
                        <a href="settings_enlist.php">
                        	<div class="userprofile">
                                <h3>सूची दर्ता भर्नुहोस् </h3>
                                <div class="dashimg">
                                    <img src="images/new_plan_icon.png" alt="New Plan  Icons" class="dashimg" />
                                </div>
                            </div>
                        </a>
							
                        
                  </div>
                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>