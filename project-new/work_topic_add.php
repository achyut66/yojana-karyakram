<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
if(isset($_POST['submit']))
{
	$data = new Worktopic();
	if($data->savePostData($_POST,"create"))
       {
        $session->message("कामको क्षेत्र थप सफल");    
        redirect_to("view_work_topic.php");
        
      }

 }

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कामको क्षेत्र थपनुहोस  :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">कामको क्षेत्र थप्नुहोस | <a href="view_work_topic.php" class="btn"> पछि जानुहोस </a></h2>                    
                   <div class="OurContentFull">
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>कामको क्षेत्र थप्नुहोस </h1>
                                    <div class="titleInput">कामको क्षेत्रको नाम:</div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="work_name" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                            </form>
                      </div>
                </div>
          </div><!-- main menu ends -->              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>