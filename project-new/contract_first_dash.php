<?php
require_once("includes/initialize.php");
include("menuincludes/header.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$plan_selected = Plandetails1::find_by_sn($_SESSION['sn']);
?>
<title>ठेक्का मार्फत योजना संचालन प्रक्रिया </title>
<body>
    <?php include("menuincludes/topwrap.php");?>
    <div id="body_wrap_inner"> 
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 maincontent">
                    <h2 class="dashboard">ठेक्का मार्फत  | <a href="yojanasanchalandash.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="dashboardcontent">
                    <h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                      <?php if($mode=="user"||$mode=="administrator"||$mode=="superadmin" || $mode=="section"):?>
                       <a href="contract_dashboard.php">
                       <div class="userprofile">
                       <h3>सुचिकृत फर्म कम्पनी  मार्फत </h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a>
                       <a href="contract_second_dash.php"><div class="userprofile">
                       <h3>इलेक्ट्रोनिक (ई) बिडिंग मार्फत</h3>
                            <div class="dashimg">
                            	<img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                       </div></a>
                      <?php endif;?>
                    </div>
                </div>
    </div>
</body>
<?php 
include("menuincludes/footer.php");?>