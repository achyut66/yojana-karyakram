<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
if(isset($_POST['submit']))
{
	$topic = Topic::find_by_id($_POST['post_id']);
	$topic->parent_id = $_POST['parent_id'];
	$topic->topic_no = $_POST['topic_no'];
	$topic->topic_name = $_POST['topic_name'];
	$topic->rate = $_POST['rate'];
	$topic->save();
	$session->message("सह शिर्षक थप सफल");
	redirect_to("settings_topic.php");
}
$data = Topic::find_by_id((int) $_GET['id']);
$parent_topics = Topic::find_parent_topic();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>सह शिर्षक  सच्याउनु होस् :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">सह शिर्षक सच्याउनु होस् </h2>
                   
                    <div class="OurContentFull">
                    	<h2>सह शिर्षक हाल्नुहोस सच्याउनु होस् </h2>
                        <div class="userprofiletable">
                        	    <form method="post" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                         
                                          	<tr>
                                            <td>मुख्य शिर्षक</td>
                                            <td>
                                            	<select name="parent_id" required>
                                                	<option value="">--छान्नुहोस्--</option>
                                                   	<?php foreach($parent_topics as $parent): ?> 
                                                    <option value="<?=$parent->id?>" <?php if($data->parent_id==$parent->id){?> selected="selected" <?php }?>><?=$parent->topic_name?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                          </tr>
                                           <tr>
                                            <td>शिर्षक नं</td>
                                            <td><input type="text" id="topic_no" name="topic_no" value="<?=$data->topic_no?>"></td>
                                          </tr>

                                          <tr>
                                            <td>शिर्षकको नाम</td>
                                            <td><input type="text" id="topic_name" name="topic_name" value="<?=$data->topic_name?>"></td>
                                          </tr>
                                           <tr>
                                            <td>दर रेट</td>
                                            <td><input type="text" id="rate" name="rate" value="<?=$data->rate?>"></td>
                                          </tr>
                                          
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>
											<input type="hidden" name="post_id" value="<?php echo $data->id; ?>" />
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>