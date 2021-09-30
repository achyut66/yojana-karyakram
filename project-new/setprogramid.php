<?php require_once("includes/initialize.php");
if(!$session->is_logged_in())
{
    redirect_to("logout.php");
}
$user=getUser();
if(isset($_POST['search'])){
    if(!is_numeric($_POST['sn']))
{
    echo alertBox("कृपया नम्बर हल्नुहोस ","setprogramid.php");
}

 $result = Plandetails1::find_by_id($_POST['sn']);
 if(empty($result))
{
    echo alertBox("निम्न दर्ता नं भेटिएन ..","setprogramid.php");
}
  
 if($result->type==0)
 	{
 	$result="";
 	}
}

if(isset($_GET['id']))
{
  setPlanId($_GET['id']);
  redirect_to("upabhoktasamitidashboard.php");
}
$postnames=  Postname::find_all();
$units = Units::find_all();
?>

<?php include("menuincludes/header.php"); ?>
<title>योजना खोज्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">कार्यक्रम खोज्नुहोस | <a href="index.php" class="btn">पछाडी जानुहोस</a></h2>
            	
                
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
                                
                <div class="userprofiletable">
                      <form  method="post">
                      	<div class="inputWrap">
                        	<div class="titleInput">कार्यक्रम दर्ता नं: </div>
                            <div class="newInput"><input type="text" class= "checkInput" name="sn" required/></div>
                            <div class="saveBtn myWidth100"><input type="submit" name="search" value="खोज्नुहोस" class="btn"/></div>
                        	<div class="myspacer"></div>
                        </div><!-- input wrap ends -->
                    </form>
              </div>
              <?php if(isset($_POST['search'])):?>
              	 <?php if(empty($result) || $result->type==0){?>
                 		<h3>No Records Found</h3>
                 <?php } 
                                elseif($user->mode=="administrator"||$user->mode=="subadmin"||$user->mode=="superadmin") 
                                {
                                        setPlanId($result->id);
  					redirect_to("program_dashboard.php");  
                                }
                           elseif($user->mode=="user"& $user->ward==$result->ward_no)     
                                { 	
                                    setPlanId($result->id);
                                             redirect_to("program_dashboard.php");
                                }
                            else
                            {
                                ?>
                                
                                <h3>कृपया आफ्नो वार्ड को मात्र खोज्नुहोस आन्यथा सम्बन्धित निकायमा रिपोर्ट जानेछ !!!!!</h3>
                   
                   <?php } ?>
                                    
              <?php endif;?>
                
                  </div>
                </div><!-- main menu ends -->
              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>