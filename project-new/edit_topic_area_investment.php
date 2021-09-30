<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  
$id=$_GET['id'];
$topic= Topicareainvestment::find_by_id($id);
if(isset($_POST['submit']))
{       
	$topic = Topicareainvestment::find_by_id($_POST['post_id']);
	//$topic->sn = $_POST['sn'];
        $topic->name = $_POST['name'];
	$topic->save();
	$session->message("विनियोजन किसिम थप सफल");
	redirect_to("view_topic_area_investment.php");
}
?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title>विनियोजन किसिम सच्याउनुहोस्</title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">विनियोजन किसिम सच्याउनुहोस्  | <a href="view_topic_area_investment.php" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	    <form method="post" enctype="multipart/form-data">
                                	<div class="inputWrap">
                                    	<h1>विनियोजन किसिम सच्याउनुहोस् </h1>
                                    	<div class="titleInput">विनियोजन किसिम : </div>
                                        <div class="newInput"><input type="text" id="topic_name" name="name" value="<?php echo $topic->name?>" required></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                        <input type="hidden" name="post_id" value="<?php echo $topic->id; ?>" />
                                    	<div class="myspacer"></div>
                                    </div><!-- input wrap ends -->
                                    	
											
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>