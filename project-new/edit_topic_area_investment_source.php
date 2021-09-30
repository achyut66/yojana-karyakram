<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  
$id=$_GET['id'];
$topic= Topicareainvestmentsource::find_by_id($id);
if(isset($_POST['submit']))
{       
	$topic = Topicareainvestmentsource::find_by_id($_POST['post_id']);
	$topic->sn = $_POST['sn'];
        $topic->name = $_POST['name'];
	$topic->save();
	$session->message("विनियोजन श्रोत थप सफल");
	redirect_to("view_topic_area_investment_source.php");
}
?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title>विनियोजन किसिम सच्याउनु होस्</title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">विनियोजन  श्रोत सच्याउनु होस् </h2>
                   
                    <div class="OurContentFull">
                    	<h2>विनियोजन  श्रोत हाल्नुहोस सच्याउनु होस् </h2>
                        <div class="userprofiletable">
                        	    <form method="post" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                         <tr>
                                            <td>सी नं</td>
                                            <td><input type="text" id="topic_name" name="sn" value="<?php echo $topic->sn?>"></td>
                                          </tr>
                                          	
                                            <tr>
                                            <td>विनियोजन  श्रोत</td>
                                            <td><input type="text" id="topic_name" name="name" value="<?php echo $topic->name?>"></td>
                                          </tr>
                                         
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>
											<input type="hidden" name="post_id" value="<?php echo $topic->id; ?>" />
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>