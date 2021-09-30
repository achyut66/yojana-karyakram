
<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  
  
if(isset($_POST['submit']))
{
	$topic = new Topicareainvestmentsource();
	if($topic->savePostData($_POST,"create")){
        $session->message("विनियोजन श्रोत थप सफल");    
        redirect_to("view_topic_area_investment_source.php");
        
        }
	
	
        
        
}

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>आयोजनाको विनियोजन श्रोत :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">आयोजनाको विनियोजन श्रोत</h2>
                   
                    <div class="OurContentFull">
                    	<h2>आयोजनाको विनियोजन श्रोत थप्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                         <tr>
                                            <td>सी नं</td>
                                            <td><input type="text" id="topictype_name" name="sn"></td>
                                          </tr>
                                        
                                            <tr>
                                            <td>विनियोजन श्रोत</td>
                                            <td><input type="text" id="topictype_name" name="name"></td>
                                          </tr>
                                           <tr>
                                           
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>