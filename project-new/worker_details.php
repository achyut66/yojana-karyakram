<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(isset($_POST['submit']))
{
	$data = new Workerdetails();
	if($data->savePostData($_POST,"create")){
        $session->message("पद थप सफल");    
        redirect_to("view_worker_details.php");
        
        }
}

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्यकारी व्यक्ति विवरण  :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">कार्यकारी व्यक्ति विवरण  | <a href="view_worker_details.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>कार्यकारी व्यक्ति विवरण  थप्नुहोस </h1>
                                    <div class="titleInput">पदको नाम : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="post_name" required></div>
                                    <div class="titleInput">आधिकारिक व्यक्ति : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="authority_name" required></div>
                                    <div class="titleInput">वार्ड नं : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="authority_ward_no" required></div>
                                    <div class="titleInput">कार्य अवधि : </div>
                                    <div class="newInput">ACTIVE : <input type="radio" name="status" value="1" required> &nbsp; &nbsp; INACTIVE :  <input type="radio" name="status" value="0" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                            </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>