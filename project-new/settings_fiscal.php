<?php require_once("includes/initialize.php"); 
		if(!$session->is_logged_in()){ redirect_to("logout.php");}	
	
	if(isset($_POST['submit']))
  {
  	$fiscal = new Fiscalyear();
  	$fiscal->year = $_POST['year'];
  	
  	if(isset($_POST['is_current']))
  	{
  		if($_POST['is_current']==1)
  		{
  			
			updateIsCurrent();
  			$fiscal->is_current = $_POST['is_current'];
  		}
  		else
  		{
  			$fiscal->is_current = 0;
  		}
  	}
  	$fiscal->save();
  	$session->message("Data Saved Successfully");
  	redirect_to('settings_fiscal.php');
  }

   $fiscals = Fiscalyear::find_all();
  

?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>आर्थिक वर्ष  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">आर्थिक वर्ष | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
							<div class="inputWrap100">
                                <div class="inputWrap50 <?php if(empty($fiscals)) { ?>inputWrapLeft<?php }?>">
                                	<h1>आर्थिक वर्ष  </h1>
                                    <table class="table table-bordered table-hover">
                                          <tr>
                                          	<td>आर्थिक वर्ष</td>
                                            <td>हाल चालु</td>
                                          </tr>
                                        <?php foreach($fiscals as $fiscal): ?>                                     		       
                                            <tr>
                                              <td><?=convertedcit($fiscal->year)?></td>
                                              <td><?php if($fiscal->is_current==1){echo "हो";}else{echo "होइन";} ?></td>
                                                                                            
                                            </tr>
                                        <?php endforeach; ?>
                                        </table>
                                </div><!-- input wrap 50 ends -->
                                <div class="inputWrap50 inputWrapLeft">
                                <?php if(empty($fiscals)):?>	
                                    <form method="post">
                                      <h1>नया  आर्थिक वर्ष  थप्नुहोस</h1>
                                      <div class="titleInput myCenter">आर्थिक वर्ष :</div>
                                      <div class="newInput myCenter"><input type="text" name="year"  required></div>
                                      <div class="titleInput myCenter">हाल चालु:</div>
                                      <div class="newInput myCenter"><input type="checkbox" name="is_current" value="1" required> हो </div>
                                      <div class="saveBtn myCenter"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                      
                                    </form>
                                <?php endif;?>
                                </div><!-- input wrap 50 ends -->
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->                        	
                             
                                        
                                    
                          
                        </div>
                         

                        
                  </div>
                </div><!-- main menu ends -->
              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>