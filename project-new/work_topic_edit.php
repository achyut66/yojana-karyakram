<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	?>
  <?php
if(isset($_POST['submit']))
{       
   $data= Worktopic::find_by_id($_POST['update_id']);
   $data->work_name=$_POST['work_name'];;
   if($data->save())
    {
        $session->message("कामको क्षेत्र विवरण  थप सफल");
        redirect_to("view_work_topic.php");
    }
}
$data= Worktopic::find_by_id($_GET['id']);

?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title>कामको क्षेत्रको विवरण  सच्याउनुहोस्  </title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile"> कामको क्षेत्रको विवरण  सच्याउनुहोस् | <a href="view_work_topic.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="OurContentFull">
                    	<h2>कामको क्षेत्रको विवरण सच्याउनुहोस् </h2>
                        <div class="userprofiletable">
                        	  <form method="post" enctype="multipart/form-data">
                                    <div class="inputWrap">
                                    	<div class="titleInput">कामको क्षेत्रको नाम</div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="work_name" value="<?php echo $data->work_name;?>"></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सच्याउनुहोस्" class="btn">                                        <input type="hidden" name="update_id" value="<?php echo $data->id?>"/></div>
                                    	<div class="myspacer"></div>
                                    </div><!-- input wrap ends -->
                                       </form>
                                    
                                    

                      </div>
                </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>