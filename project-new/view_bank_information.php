<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas= Bankinformation::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बैंक रेकोर्ड :: <?php echo SITE_SUBHEADING;?></title>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	 <div class="maincontent">
                    <h2 class="headinguserprofile">बैंक रेकोर्ड | <a href="bank_information.php" class="btn">बैंक रेकोर्ड थप्नुहोस +</a> | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>बैंक रेकोर्ड : </h2>
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                            
                                            <tr>
                                            <td class="myCenter"><strong>सि नं</strong></td>
                                            <td class="myCenter"><strong>बैंकको नाम</strong></td>
                                            <td class="myCenter"><strong>बैंकको ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): ?>
                                          	<tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                        <td class="myCenter"><?php echo $data->name;?></td>
                                                        <td class="myCenter"><?php echo $data->address; ?></td>
                                                <form method="post" action="bank_info_delete.php">
                                                        <td class="myCenter">
                                                            <a href="edit_bank_information.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
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