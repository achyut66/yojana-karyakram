<?php require_once("includes/initialize.php");	
if(!$session->is_logged_in()){ redirect_to("logout.php");} ?>
  <?php
if(isset($_POST['submit']))
{       
   $data= Postname::find_by_id($_POST['update_id']);
   $data->name=$_POST['name'];
   if($data->save())
    {
        $session->message(" पद  विवरण  थप सफल");
        redirect_to("view_post.php");
    }
}
$data= Postname::find_by_id($_GET['id']);

?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title>पद  विवरण  सच्याउनुहोस् :: <?php echo SITE_SUBHEADING;?></title>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
                <div class="maincontent">
                    <h2 class="headinguserprofile">पद विवरण सच्याउनुहोस् | <a href="view_post.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	  <form method="post" enctype="multipart/form-data">
                              		<div class="inputWrap">
                                    	<h1>पद विवरण सच्याउनुहोस् </h1>
                                    	<div class="titleInput">पदको नाम : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="name" value="<?php echo $data->name;?>" required></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सच्याउनु होस्" class="btn"></div>
                                        <input type="hidden" name="update_id" value="<?php echo $data->id?>"/>
                                    	<div class="myspacer"></div>
                                    </div><!-- input wrap ends -->
                                    	
                                  </form>
                        </div>
                  </div>
                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>