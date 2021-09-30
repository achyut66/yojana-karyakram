<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas= Worktopic::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कामको क्षेत्रको रेकोर्ड हेर्नुहोस :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">कामको क्षेत्रको रेकोर्ड | <a href="work_topic_add.php" class="btn">कामको क्षेत्रको थप्नुहोस +</a> | <a href="settings.php" class="btn"> पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>कामको क्षेत्रको रेकोर्ड हेर्नुहोस </h2>
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                            <tr>
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>कामको क्षेत्रको  नाम</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): ?>
                                          	<tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                        <td class="myCenter"><?php echo $data->work_name;?></td>
                                                       <td class="myCenter"><a href="work_topic_edit.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a></td>
                                                    </tr>
                                        
                                          <?php $i++; endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>