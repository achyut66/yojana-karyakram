<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user=getUser();
if(isset($_POST['search'])){
 $result= Plandetails1::find_by_id($_POST['sn']);

 $check_customer = Costumerassociationdetails0::find_by_plan_id($result->id);
 if($result->type==1 || !empty($check_customer))
 {
     $result = "";
 }
//print_r($result);exit;
}

$postnames=  Postname::find_all();
$units = Units::find_all();
?>

<?php include("menuincludes/header.php"); ?>
<title>योजना खोज्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना खोज्नुहोस | <a href="yojanasanchalandash.php">योजना संचालन प्रकृया</a></h2>
            <div class="OurContentLeft">
                     <?php include("menuincludes/main_dashboard.php");?>
            </div>	
                
            <div class="OurContentRight">
				<div class="myMessage"><?php echo $message;?></div>
                <h2>योजना खोज्नुहोस </h2>
                <div class="userprofiletable">
               
                      <form  method="post">
                      	<table class="table table-bordered">
                       	
                        <tr>
                        	<td>दर्ता फाराम नं:</td>
                            <td><input type="text" name="sn" required/></td>
                        </tr>
                        <tr>
                        	<td>&nbsp;</td>
                            <td><input type="submit" name="search" value="खोज्नुहोस" class="submithere"/></td>
                        </tr>
                       
                       </table>
                    </form>
              </div>
              <?php if(isset($_POST['search'])):?>
              	 <?php if(empty($result)){?>
                 		<h3>No Records Found</h3>
                   <?php } elseif($user->mode=="administrator"||$user->mode=="subadmin"||$user->mode=="superadmin") 
                                {
                                        setPlanId($result->id);
  					redirect_to("estimatedashboard.php");  
                                }
                           elseif($user->mode=="user"& $user->ward==$result->ward_no)     
                                { 	
                                    setPlanId($result->id);
                                             redirect_to("estimatedashboard.php");
                                }
                            else
                            {?>
                                <h3>कृपया आफ्नो वार्ड को मात्र खोज्नुहोस अन्यथा सम्बन्धित निकायमा रिपोर्ट जानेछ ....!!!!!</h3>
                   
                   <?php } ?>
              <?php endif;?>
                
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>