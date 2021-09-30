<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas= Postname::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>पद :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	 <div class="maincontent">
                    <h2 class="headinguserprofile">पद | <a href="add_post.php" class="btn">पद थप्नुहोस + </a> | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>पद : </h2>
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                            <tr>
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>पद</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): ?>
                                          	<tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                        <td class="myCenter"><?php echo $data->name; ?></td>
                                                <form method="post" action="post_delete.php">
                                                        <td class="myCenter">
                                                            <a href="edit_post.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
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