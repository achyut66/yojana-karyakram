<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  
  
if(isset($_POST['submit']))
{
	$data = new Bankinformation();
	if($data->savePostData($_POST,"create"))
       {
        $session->message("बैंक थप सफल");    
        redirect_to("view_bank_information.php");
        
      }

 }

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बैंकको नाम थप्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">बैंकको नाम थप्नुहोस  | <a href="view_bank_information.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                                   <div class="inputWrap">
                                   		<h1>बैंक थप्नुहोस </h1>
                                        <div class="titleInput">बैंकको नाम : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="name" required></div>
                                        <div class="titleInput">बैंकको ठेगाना : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="address" required></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                   		<div class="myspacer"></div>
                                   </div><!-- input wrap ends -->
                                        

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>