<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
if(isset($_POST['submit']))
{
  $data =  Topicareatypesub::find_by_id($_POST['edit_id']);
  $data->topic_area_type_id = $_POST['topic_area_type_id'];
  $data->topic_area_type_sub = $_POST['topic_area_type_sub'];
  if($data->save())
  {
	   $session->message("सह शिर्षक थप सफल");
	   redirect_to("topic_area_type_sub_view.php");
  }
}
$editdata = Topicareatypesub::find_by_id($_GET['id']);
$topic_area_type_selected = Topicareatype::find_by_id($editdata->topic_area_type_id);
$parent_topic_selected = Topicarea::find_by_id($topic_area_type_selected->topic_area_id);
$topic_area_types = Topicareatype::find_all();
$parent_topics = Topicarea::find_all();

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको उपशिर्षकगत किसिम सच्याउनुहोस्  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको उपशिर्षकगत किसिम सच्याउनुहोस् | <a href="topic_area_type_sub_view.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="myMessage"><?php echo $message;?></div>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>योजनाको उपशिर्षक शिर्षक सच्याउनुहोस् </h1>
                                    <div class="titleInput">बिषयगत क्षेत्रको नाम : </div>
                                    <div class="newInput"><select id="topic_area_id" name="topic_id" required>
                                                	<option value="">--छान्नुहोस्--</option>
                                                   	<?php foreach($parent_topics as $data): ?> 
                                                        <option value="<?php echo $data->id;?>" <?php if($parent_topic_selected->id==$data->id){?>selected="selected" <?php }?>><?php echo $data->name;?></option>
                                                    <?php endforeach; ?>
                                                </select></div>
                                   
                                   <!-- <div class="titleInput">योजनाको शिर्षकगत किसिम : </div>-->
                                    <div class="newInput" id="topic_area_type_id"><select name="topic_area_type_id" required>
                                               <option value="">--</option>
                                               <?php foreach($topic_area_types as $topic_area_type): ?>
                                               <option value="<?=$topic_area_type->id?>" <?php if($topic_area_type->id==$editdata->topic_area_type_id){?> selected="selected" <?php } ?>><?=$topic_area_type->topic_area_type?></option>
                                               <?php endforeach; ?>
                                           </select></div>
                                    <div class="titleInput">योजनाको उपशिर्षकगत किसिम : </div>
                                    <div class="newInput"><input type="text" id="topic_name" name="topic_area_type_sub" value="<?=$editdata->topic_area_type_sub?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                    <input type="hidden" name="edit_id" value="<?=$editdata->id?>" />
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>