<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(isset($_POST['search'])){
 $result= Plandetails1::find_by_searched_id($_POST['sn']);
// print_r($result);exit;
//print_r($result);exit;
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
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना खोज्नुहोस | <a href="yojanasanchalandash.php">उपभोक्ता समिति मार्फत</a></h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/upabhoktasamitimenu.php");?>
            </div>	
                
            <div class="OurContentRight">
				<div class="myMessage"><?php echo $message;?></div>
                <h2>योजना खोज्नुहोस </h2>
                <div class="userprofiletable">
               
                      <form  method="post">
                      	<table class="table table-bordered">
                       	<tr>
                        	<td>योजनाको नाम:</td>
                            <td><input type="text" name="program"/></td>
                        </tr>
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
                 <?php } else { 
				 	 setPlanId($result->id);
  					redirect_to("upabhoktasamitidashboard.php");
				 ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>दर्ता फाराम नं</th>
                            <th>योजनाको नाम</th>
                        </tr>
                       
                        <tr>
                            <td><?php echo $result->sn;?></td>
                            <td><a href="setid.php?id=<?=$result->id?>"><?php echo $result->program_name;?></a></td>
                        </tr>
                       
                    </table>
                   <?php } ?>
              <?php endif;?>
                
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>