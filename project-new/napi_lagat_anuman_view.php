<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$check_plan = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
$profile_details = NapiLagatProfile::find_by_plan_id($_GET['id']);
$sql = "select * from napi_lagat_anuman where plan_id=".$_GET['id']." and period=".$_GET['period']." order by sno asc";
$lagat_details = Napilagatanuman::find_by_sql($sql);
$sno_array = Napilagatanuman::getAllSnoByPlanId($_GET['id']);
if(!empty($profile_details) || !empty($lagat_details))
{
    $update = 1;
    $save_text = "अपडेट गर्नुहोस";
}
 else 
{
     $update = 0;
     $save_text = "सेभ गर्नुहोस";
     
}
if(empty($profile_details))
{
    $profile_details = NapiLagatProfile::setEmptyObjects();
}
$data1 = Plandetails1::find_by_id($_GET['id']);
$estimate_details = Estimateanudandetails::find_by_plan_id($_GET['id']);
if(empty($estimate_details)):
    echo alertBox("अनुदान विवरण भरिएको छैन", "estimate_anudan_details.php");
endif;
$added_investment = $data1->investment_amount+ $estimate_details->other_source + $estimate_details->other_agreement;
$contingency = $added_investment*.03;
$postnames      = Postname::find_all();
$units          = Units::find_all();
$work_details   = Worktopic::find_all();
$estimate_adds = Estimateadd::find_all();
?>

<?php include("menuincludes/header_new.php"); ?>
 
<title>योजनाको कुल लागत अनुमान :: Kanepokhari Gaunpalika</title>
<body>
   
    <?php include("menuincludes/topwrap.php"); ?>
  
        <div class="maincontent">
            <h2 class="headinguserprofile">योजनाको इष्टिमेटको कुल लागत अनुमान | <a href="estimatedashboard.php">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण</a></h2>
            
                
            <div class="OurContentFull title_wrap" >
					<div class="myMessage"><?php echo $message;?></div>
                 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <div class="userprofiletable">
               
                    <?php $data = Plandetails1::find_by_id($_GET['id']);?>
                   
                     <div>
                            <h3 class="myHeading3"><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                            <h3 class="myHeading3">योजनाको इष्टिमेटको कुल लागत अनुमान</h3>
                                
                       
                        <table class="table table-bordered table-responsive myWidth100 myFont10">
                        
                            <tr>
                                <th>सि.नं.</th>
                                <th>इष्टिमेट न०</th>
                                <th>क्षेत्र</th>
                                <th></th>
                                <th>विवरण</th>
                                <th>संख्या</th>
                                <th>लम्बाई</th>
                                <th>चौडाई</th>
                                <th>उचाई</th>
                                <th>परिमाण</th>
                                <th>इकाई</th>
                                <th>दर</th>
                                <th>जम्मा लागत रु.</th>
                                <th></th>
                            </tr>
                            <?php  $count = 1; $sn_index=0; foreach($lagat_details as $lagat_detail): ?>
                            <?php $break_lagats = ''; 
                            if($lagat_detail->break_type==2)
                                {
                                    $break_lagats = Napilagatanumanbreak::find_by_plan_id_sno($_GET['id'],$sno_array[$sn_index],$_GET['period']); 
                                }?>
                            <?php $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                  $task_results = Estimateadd::find_by_sql($sql);
                            ?>
                            <?php if(!empty($break_lagats)):// break row starts here ?>
                            <?php $task_name = Worktopic::find_by_id($lagat_detail->task_id); 
                             ?>
                            <tr  id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?>>
                                <td><?=$count?></td>
                                <td><?=$sno_array[$sn_index]?></td>
                                <td><?=$task_name->work_name?></td>
                                <td id="task_name_column-<?=$count?>"></td>
                                <td id="estimate_sub-<?=$count?>"><?=$lagat_detail->main_work_name?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="unit-1"><?php echo Units::getName($lagat_detail->unit_id);?></td> 
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                                <?php $j = 1; foreach($break_lagats as $break_lagat): // populating the breaks?>
                                      <tr id="break_row-<?=$count?>_<?=$j?>" class="break_row-<?=$count?>">
                                        <td></td>
                                        <td></td>
                                        <td><?=$sno_array[$sn_index]?>.<?=$break_lagat->break_no?></td>
                                        <td><?php if($break_lagat->deduct_part==1){echo  "घटाएको भाग";} ?> </td>
                                        <td><?=$break_lagat->break_work_name?></td>
                                        <td><?=$break_lagat->task_count?></td>
                                        <td><?=$break_lagat->length?></td>
                                        <td><?=$break_lagat->breadth?></td>
                                        <td><?=$break_lagat->height?></td>
                                        <td><?php if($break_lagat->deduct_part==1){echo "-".$break_lagat->total_evaluation; } else {echo $break_lagat->total_evaluation;} ?></td>
                                        <td id="unit-1"></td> 
                                        <td></td>
                                        <td></td>
                                        <td></td>
                             </tr>
                                <?php $j++; endforeach; ?>
                             <!-- sub total row in case of break starts here -->
                                <tr id="total_output_row-<?=$count?>">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right">जम्मा</td>
                                    <td><?=$lagat_detail->total_evaluation?></td>
                                    <td id="unit-1"></td> 
                                    <td><?=$lagat_detail->task_rate?></td>
                                    <td><?=$lagat_detail->total_rate?></td>
                                    <td></td>
                                </tr>
                                <!-- sub total row in case of break starts here -->
                            <?php endif; // break row ends here ?>
                             <?php if(empty($break_lagats)):// without break single row starts here
                                    $single_break = Estimatelagatanumanbreak::find_single_row($_GET['id'],$count);
                                    $task_name = Worktopic::find_by_id($lagat_detail->task_id);
                             ?>
                                    <tr id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?> >
                                        <td><?=$count?></td>
                                        <td></td>
                                        <td><?=$task_name->work_name?></td>
                                        <td id="task_name_column-1"></td>
                                        <td id="estimate_sub-1"><?=$lagat_detail->main_work_name?></td>
                                        <td><?=$single_break->task_count?></td>
                                        <td><?=$single_break->length?></td>
                                        <td><?=$single_break->breadth?></td>
                                        <td><?=$single_break->height?></td>
                                        <td><?=$lagat_detail->total_evaluation?></td>
                                        <td id="unit-1"><?php echo Units::getName($lagat_detail->unit_id); ?></td> 
                                        <td><?=$lagat_detail->task_rate?></td>
                                        <td><?=$lagat_detail->total_rate?></td>
                                        <td></td>
                                </tr>
                              <?php endif;// without break single row ends here ?>
                            <?php $count++; $sn_index++; endforeach; ?>
                            
                                
                        </table>
                           <table class="table table-bordered table-responsive myWidth100 myFont10">
                           <tr>
                               <td colspan="10"  id="task_name-1" style="text-align: right;">जम्मा</td>
                               <td><?=$profile_details->sub_total?></td>
                           </tr>
                          
                       </table>
                        
                                       
 </form>
                     </div>
                    <div id="dialog_show" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                           
                    
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>