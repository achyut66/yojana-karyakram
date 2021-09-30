<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$plan_list = EstimateLagatProfile::find_by_sql("select plan_id, date_english,date_nepali from estimate_lagat_profile order by date_english asc ");
require_once("menuincludes/header.php");
?>
<title>योजना</title>
<body>
<?php include("menuincludes/topwrap.php"); ?>
        <div class="maincontent">
            <h2 class="headinguserprofile myHeadingone">इष्टिमेट भएको योजनाहरु | <a class="btn" href="index.php" class="btn"> पछि जानुहोस </a></h2>
            
                
            <div class="OurContentFull title_wrap" >
					<div class="myMessage"><?php echo $message;?></div>
                 <!--<h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>-->
                <div class="userprofiletable">
               
                    <?php // $data = Plandetails1::find_by_id($_GET['id']);?>
                   
                     <div>
                            <h3 class="myHeading3"><?php // echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                            <table class="table table-fixed table-bordered table-responsive myWidth100 myFont10 " id="tableFixHead">
                            <tr>
                                <th>सि.नं.</th>
                                <th>दर्ता न०</th>
                                <th>योजनाको नाम</th>
                                <th>इष्टिमेट मिति</th>
                                <th>पुरा विवरण हेर्नुहोस </th>
                                
                            </tr>
                            <?php $counter = 1; foreach($plan_list as $plan): 
                                  $data1 = Plandetails1::find_by_id($plan->plan_id);
                            ?>
                            <tr>
                                <td><?=convertedcit($counter)?></td>
                                <td><?=convertedcit($plan->plan_id)?></td>
                                <td><?=$data1->program_name?></td>
                                <td><?=convertedcit($plan->date_nepali)?></td>
                                  <td><a href="estimatedashboard.php?plan_id=<?=$plan->plan_id?>" class="btn"> पुरा विवरण</a></td>
                                </tr>
                          <?php $counter++; endforeach; ?>    
                        </table>
                        
                  
                        
                        
                                       
 </form>
                     </div>
                    <div id="dialog_show" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                           
                    
                </div><!-- main menu ends 
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>