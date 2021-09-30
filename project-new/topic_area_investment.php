<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
if(isset($_POST['submit']))
{
	$topic = new Topicareainvestment();
	if($topic->savePostData($_POST,"create")){
        $session->message("अनुदान थप सफल");    
        redirect_to("view_topic_area_investment.php");
        }
}
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको विनियोजन किसिम :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको विनियोजन किसिम | <a href="view_topic_area_investment.php" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>योजनाको विनियोजन किसिम थप्नुहोस </h1>
                                	<div class="titleInput">विनियोजन किसिम : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="name" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>