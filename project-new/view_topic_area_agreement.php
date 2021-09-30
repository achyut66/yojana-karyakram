<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$agreement= Topicareaagreement::find_all();

	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको अनुदानको किसिम  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको अनुदानको किसिम | <a href="add_topic_area_agreement.php" class="btn">योजनाको अनुदानको किसिम थप्नुहोस +</a> |<a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	<div class="userprofiletable">
                        	<h2>योजनाको अनुदानको किसिम</h2>
							<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                            
                                            <tr>
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>योजनाको अनुदानको किसिम</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                          <?php $i=1; foreach($agreement as $data): ?>
                                          	<tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                        <td class="myCenter"><?php echo $data->name; ?></td>
                                                <form method="post" action="topic_area_agg_delete.php">
                                                        <td class="myCenter">
                                                            <a href="edit_topic_area_agreement.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
                                                            <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                            <input type="hidden" name="id" value="<?=$data->id?>">
                                                        </td>
                                                </form>
                                                    </tr>
                                        
                                          <?php $i++; endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>