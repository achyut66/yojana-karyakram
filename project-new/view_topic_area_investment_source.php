<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$investmentsource= Topicareainvestmentsource::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>आयोजनाको विनियोजन श्रोत  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">शिर्षक</h2>
                    
                    <div class="OurContentFull">
                    	<h2>आयोजनाको विनियोजन श्रोत : </h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu1"><a href="topic_area_investment_source.php">आयोजनाको विनियोजन श्रोत थप्नुहोस +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div><?php echo $message;?></br>
                                    	<table class="table table-bordered">
                                            <tr><a href="topic_area_investment_source.php"><button>ADD</button></a></tr>
                                            <tr>
                                            <th>सी नं</th>
                                            <th>आयोजनाको विनियोजन श्रोत</th>
                                            <th>सच्याउनु होस् </th>
                                          </tr>
                                          <?php foreach($investmentsource as $data): ?>
                                          	<tr>
                                                        <td><?php echo $data->sn; ?></td>
                                                        <td><?php echo $data->name; ?></td>
                                                        <td><a href="edit_topic_area_investment_source.php?id=<?php echo $data->id; ?>">Edit</a></td>
                                                    </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>