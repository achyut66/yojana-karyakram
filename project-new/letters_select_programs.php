<?php require_once("includes/initialize.php"); ?>
<?php	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);

$program_id=$_SESSION['set_plan_id'];
?>
<?php include("menuincludes/header.php"); ?>
<title>पत्रहरु छान्नुहोस् </title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
             <h2 class="dashboard"><a href="program_dashboard.php" >कार्यक्रम संचालन प्रकृया</a> | <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछी जानुहोस </a></h2>
            <div class="OurContentFull">
				<h1 class="myHeading1"><?=$plan_selected->program_name?></h1>
                <div class="myMessage"><?php echo $message;?></div>
                <h2>पत्रहरु छान्नुहोस् </h2>
                <div class="userprofiletable">
               	       <a href="print_karyadesh_report_01.php">	
                       <div class="userprofile">
                        	<h4>कार्यदेशको टिप्पणी</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>                            
                        </div>
                        </a><!-- user profile ends -->
                       <!--  <div class="userprofiletable"> -->
               		<a href="print_karyadesh_report_02.php">
                        <div class="userprofile">
                        	<h4>कार्यदेश पत्र</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Billing Icons" class="dashimg" />
                            </div>
                        </div>
                        </a>
                        <!-- user profile ends -->
                        <a href="print_karyadesh_report_13.php"><div class="userprofile">
                        	<h4>संझौता पत्र</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                            
                        </div></a><!-- user profile ends -->
                        <a href="letters_select3.php">
                        <div class="userprofile">
                        	<h4>पेश्की संझौताको टिप्पणी / आर्थिक प्रशासन शाखा पत्र </h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        
                        
                        <a href="print_karyadesh_report_04.php">
                        <div class="userprofile">
                        	<h4>पेश्की कार्यदेश पत्र</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <a href="print_karyadesh_report_05.php">
                        <div class="userprofile">
                        	<h4>म्यादको थपको टिप्पणी</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <!--<a href="#">-->
                        <!--<div class="userprofile">-->
                        <!--	<h4>म्यादको थपको पत्र</h4>-->
                        <!--    <div class="dashimg">-->
                        <!--    	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />-->
                        <!--    </div>-->
                        <!--</div></a><!-- user profile ends -->
                      
                        <a href="print_karyadesh_report_12.php">
                        <div class="userprofile">
                        	<h4>भुक्तानीको सिफारिस </h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                         
                        <a href="letters_select4.php">
                        <div class="userprofile">
                        	<h4>अन्तिम भुक्तानीको टिप्पणी / आर्थिक प्रशासन शाखा पत्र</h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />
                            </div>
                        </div></a><!-- user profile ends -->
                        <!--<a href="#"><div class="userprofile3">-->
                        <!--	<h4>फोटो हाल्नुहोस्</h4>-->
                        <!--    <div class="dashimg">-->
                        <!--    	<img src="images/pen-icon.png" alt="Report Icons" class="dashimg" />-->
                        <!--    </div>-->
                        <!--</div></a><!-- user profile ends -->
                        
                        
                        <a href="print_karyadesh_report_14.php"><div class="userprofile">
                        	<h4>धरौटी फिर्ता </h4>
                            <div class="dashimg">
                            	<img src="images/pen-icon.png" alt="Upabhokta Icon" class="dashimg" />
                            </div>
                            
                        </div></a><!-- user profile ends -->
                        
                        
                        
                        
              </div>
              
                    
                  </div>
                </div><!-- main menu ends -->
               
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>