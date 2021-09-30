<?php require_once("includes/initialize.php"); 	
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
if(isset($_POST['submit']))
{
	$data = new Topicareatypesub();
  $data->topic_area_type_id = $_POST['topic_area_type_id'];
  $data->topic_area_type_sub = $_POST['topic_area_type_sub'];
  if($data->save())
  {
	   $session->message("सह शिर्षक थप सफल");
	   redirect_to("topic_area_type_sub.php");
  }
}
$topic_result= Topicarea::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको उपशिर्षकगत किसिम:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको उपशिर्षकगत किसिम | <a href="topic_area_type_sub_view.php" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull">
                    	
                        <div class="myMessage"><?php echo $message;?></div>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>योजनाको उपशिर्षक शिर्षक थप्नुहोस </h1>
                                	<div class="titleInput">बिषयगत क्षेत्रको नाम : </div>
                                    <div class="newInput" ><select id="topic_area_id" name="topic_id" required>
                                                	<option value="">--छान्नुहोस्--</option>
                                                   	<?php foreach($topic_result as $data): ?> 
                                                    <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                                                    <?php endforeach; ?>
                                                </select></div>
                                    <div class="titleInput" id="topic_area_type_id"></div>
                                    <div class="titleInput">योजनाको शिर्षकगत किसिम : </div>
                                    <div class="newInput"><input type="text" id="topic_name" name="topic_area_type_sub" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>