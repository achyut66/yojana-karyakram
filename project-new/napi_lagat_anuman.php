<?php require_once("includes/initialize.php");
//error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}

if(isset($_POST['submit']))
{
//    echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
    if($_POST['update']==1)
    {
        $profile = NapiLagatProfile::find_by_plan_id_period($_POST['plan_id'],$_POST['period']);
        $del_lagats = Napilagatanuman::find_by_plan_id_period($_POST['plan_id'],$_POST['period']);
        foreach($del_lagats as $del_lagat)
        {
            $del_lagat->delete();
        }
        $del_break_lagats = Napilagatanumanbreak::find_by_plan_id_period($_POST['plan_id'],$_POST['period']);
        foreach($del_break_lagats as $del_break_lagat)
        {
            $del_break_lagat->delete();
        }
    }
    else
    {
        $profile = new NapiLagatProfile;
    }
//   Save the profile first
     $profile->date_nepali  = $_POST['date_nepali'];
     $profile->date_english = DateNepToEng($_POST['date_nepali']);
     $profile->period       = $_POST['period'];
     $profile->antim        = $_POST['antim'];
     $profile->sub_total    = $_POST['sub_total'];
     $profile->plan_id      = $_POST['plan_id'];
     $profile->save();
   $task_count = count($_POST['main_work_name']);
   $j=1;
   $cross_check = 0;
   $i = 0;
   foreach($_POST['sno'] as $sno)
   {
        $j = $sno;
        $data = new NapiLagatAnuman;
        $data->break_type = 1;
//        $data->task_id               = $_POST['task_id'][$i];
        $data->main_work_name        = $_POST['main_work_name'][$i];
        $data->total_evaluation      = $_POST['total_evaluation'][$i];
        $data->unit_id               = $_POST['unit_id'][$i];
        $data->task_rate             = $_POST['task_rate'][$i];
        $data->total_rate            = $_POST['total_rate'][$i];
        $data->plan_id               = $_POST['plan_id'];
        $data->total_evaluation      = $_POST['total_evaluation'][$i];
        $data->sno                   = $sno;
        $data->period                = $_POST['period'];
        $lagat_anuman_id = $data->save();
       $break_work_index = "break_work_name-".$j;
       $task_break_index = "task_count-".$j;
       $length_break_index = "length-".$j;
       $breadth_break_index = "breadth-".$j;
       $height_break_index = "height-".$j;
       $total_evaluation_break_index = "total_evaluation-".$j;
       $break_no_break_index = "break_no-".$j;
       
       if(isset($_POST[$task_break_index]))
       {
           $update_data = NapiLagatAnuman::find_by_id($lagat_anuman_id);
           $update_data->break_type = 2;
           $update_data->save();
           $break_count = count($_POST[$task_break_index]);
           $added_k = 1;
           for($k=0; $k<$break_count; $k++)
           {
                $break_data =  new Napilagatanumanbreak;
                $break_data->break_work_name         = $_POST[$break_work_index][$k];
                $break_data->task_count              = $_POST[$task_break_index][$k];
                $break_data->length                  = $_POST[$length_break_index][$k];
                $break_data->breadth                 = $_POST[$breadth_break_index][$k];
                $break_data->height                  = $_POST[$height_break_index][$k];
                $break_data->total_evaluation        = $_POST[$total_evaluation_break_index][$k];
                $break_data->plan_id                 = $_POST['plan_id'];
                $break_data->sno_taken               = $j;
                $break_data->break_no                = $_POST[$break_no_break_index][$k];
                $break_data->deduct_part             = 0;
                $break_data->period                  = $_POST['period'];
                $deduct_break_index = "deduct-".$j."_".$_POST[$break_no_break_index][$k];
                if(isset($_POST[$deduct_break_index]))
                {
                    $break_data->deduct_part         = 1;
                }
                $break_data->save();
                $added_k++;
           }
           
       }
       else
       {
           $break_data =  new Napilagatanumanbreak;
           $break_data->task_count              = $_POST['task_count'][$cross_check];
           $break_data->length                  = $_POST['length'][$cross_check];
           $break_data->breadth                 = $_POST['breadth'][$cross_check];
           $break_data->height                  = $_POST['height'][$cross_check];
           $break_data->total_evaluation        = $_POST['total_evaluation'][$i];
//           $break_data->unit_id                 = $_POST['unit_id'][$i];
           $break_data->plan_id                 = $_POST['plan_id'];
           $break_data->sno_taken               = $sno;
           $break_data->period                  = $_POST['period'];
           $break_data->deduct_part             = 0;
           $break_data->save();
          
           $cross_check++;
       }
       
       $j++;
       $i++;
   }
   
//   if($_POST['update']==1)
//   {
//       $profile =  EstimateLagatProfile::find_by_plan_id($_POST['plan_id']);
//       $lagat_updates = Estimatelagatanuman::find_by_plan_id($_POST['plan_id']);
//       foreach ($lagat_updates as $lagat_update)
//       {
//           $lagat_update->delete();
//       }
//   }
//   else
//   {
//        $profile = new EstimateLagatProfile;
//   }
//    if($_POST['type']==1)
//    {
//        $profile->gaupalika_anudan  = $_POST['gaupalika_anudan'];
//        $profile->contingency       = $_POST['contingency'];
//        $profile->bhuktani_anudan   = $_POST['bhuktani_anudan'];
//        $profile->public_anudan     = $_POST['public_anudan'];
//    }
//    if($_POST['type']==2)
//    {
//        $profile->contingency       = $_POST['contingency'];
//        $profile->vat_amount        = $_POST['vat_amount'];
//        $profile->overhead          = $_POST['overhead'];
//       
//    }
//    $profile->sub_total         = $_POST['sub_total'];
//    $profile->grand_total   = $_POST['grand_total'];
//    $profile->plan_id       = $_POST['plan_id'];
//    $profile->save();
//    for($i=0;$i<count($_POST['task_id']);$i++)
//    {
//        $data                   = new Estimatelagatanuman();
//        $data->task_id          = $_POST['task_id'][$i];
//        $data->task_name        = $_POST['task_name'][$i];
//        $data->task_count       = $_POST['task_count'][$i];
//        $data->length           = $_POST['length'][$i];
//        $data->breadth          = $_POST['breadth'][$i];
//        $data->height           = $_POST['height'][$i];
//        $data->total_evaluation = $_POST['total_evaluation'][$i];
//        $data->unit             = $_POST['task_name'][$i];
//        $data->task_rate        = $_POST['task_rate'][$i];
//        $data->total_rate       = $_POST['total_rate'][$i];
//        $data->plan_id          = $_POST['plan_id'];
//        $data->save();
//    }
//    redirect_to("estimate_lagat_anuman.php");
//}
}

if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$check_plan = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
$napi_profile = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']);
$profile_details = EstimateLagatProfile::find_by_plan_id($_GET['id']);
$sql = "select * from estimate_lagat_anuman where plan_id=".$_GET['id']." order by sno asc";
$lagat_details = Estimatelagatanuman::find_by_sql($sql);

     $update = 0;
     $save_text = "सेभ गर्नुहोस";

if(empty($profile_details))
{
    $profile_details = EstimateLagatProfile::setEmptyObjects();
}
$data1 = Plandetails1::find_by_id($_GET['id']);
$estimate_details = Estimateanudandetails::find_by_plan_id($_GET['id']);
//if(empty($estimate_details)):
//    echo alertBox("अनुदान विवरण भरिएको छैन", "estimate_anudan_details.php");
//endif;
$added_investment = $data1->investment_amount+ $estimate_details->other_source + $estimate_details->other_agreement;
$contingency = $added_investment*.03;
$postnames      = Postname::find_all();
$units          = Units::find_all();
$work_details   = Worktopic::find_all();
$estimate_adds = Estimateadd::find_all();
include("menuincludes/header.php"); ?>
<title>नापी</title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent ">
            <h2 class="dashboard">नापी किताब  | <a href="napi_lagat_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            
                
            <div class="OurContentFull" >
	     <div class="myMessage"><?php echo $message; ?></div>
                 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <div class="userprofiletable">
               
                    <?php $data = Plandetails1::find_by_id($_GET['id']); ?>
                   
                     <div>
                            <h3 class="myHeading3"><?php echo $data->program_name; ?></h3>
                            <?php if($_GET['period']>1):
//                                echo "here"; exit;
                                for($n=1;$n<$_GET['period'];$n++):
                                     
                                    echo getNapiView($n);
                                endfor;
                            endif;
                            ?>
                            
                            <?php if(!getNapiView($_GET['period'])){// if new napi lagat ?>    
                            <form method="post" enctype="multipart/form_data" >
                            <div class="inputWrap100">
                            	<h1>नापी विवरण</h1>
                            	<div class="inputWrap50 inputWrapLeft">
                            		<div class="newInput"><input type="text" name="date_nepali" id="nepaliDate5" required/></div>
                            	</div>
                            	<div class="inputWrap50 inputWrapLeft">
                            	<h1>अन्तिम नापी :</h1>
                            	<div class="newInput" ><b style="margin-left:230px;">हो </b><input type="radio" name="antim" value="1" required/>  <b style="margin-left:70px;">होइन </b><input type="radio" name="antim" value="0" required/></div>
                            	</div>
                            	<div class="myspacer"></div>
                            	
                            	
                            </div>
                            
                        <table class="table table-bordered table-responsive myWidth100 myFont10">
                        
                            <tr>
                                <td class="myCenter">सि.नं.</td>
                                <td class="myCenter">&nbsp;</td>
<!--                            <td>क्षेत्र</td>
                                <td></td>-->
                                <td colspan="3"  class="myCenter">विवरण</td>
                                <td  class="myCenter">संख्या</td>
                                <td class="myCenter">लम्बाई</td>
                                <td class="myCenter">चौडाई</td>
                                <td class="myCenter">उचाई</td>
                                <td class="myCenter">परिमाण</td>
                                <td class="myCenter">इकाई</td>
                                <td class="myCenter">दर</td>
                                <td class="myCenter">जम्मा लागत रु.</td>
                                
                            </tr>
                            <?php  $count = 1; foreach($lagat_details as $lagat_detail): ?>
                            <?php $break_lagats = ''; if($lagat_detail->break_type==2){$break_lagats = Estimatelagatanumanbreak::find_by_plan_id_sno($_GET['id'], $count); }?>
                            <?php $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                  $task_results = Estimateadd::find_by_sql($sql);
                            ?>
                            <?php if(!empty($break_lagats)):// break row starts here ?>
                            <tr  id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?>>
                                <td><?=$count?><input type="hidden" name="sno[]" value="<?=$count?>" /></td>
                                <td><img id="break-<?=$count?>" class="row_delete" src="images/cross.png" width="20px" height="20px" /></td>
<!--                                <td>
                                     <select name="task_id[]" id="task_id-<?=$count?>">
                                                    <option value="">---छान्नुहोस्---</option>
                                                    <?php foreach($work_details as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($lagat_detail->task_id==$data->id){?> selected="selected" <?php }?>><?php echo $data->work_name;?></option>
                                                    <?php endforeach; ?>
                                    </select>
                                </td>
                                <td id="task_name_column-<?=$count?>"></td>-->
                                <td colspan="3" id="estimate_sub-<?=$count?>"><textarea rows="4" name="main_work_name[]"><?=$lagat_detail->main_work_name?></textarea></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="unit-1"><select name="unit_id[]">
                                        <option value="">----</option>
                                    <?php foreach($units as $unit): ?>
                                        <option value="<?=$unit->id?>" <?php if($lagat_detail->unit_id==$unit->id){?> selected="selected" <?php } ?>><?=$unit->name?></option>
                                    <?php endforeach; ?></td> 
                                <td></td>
                                <td></td>
                                
                            </tr>
                                <?php $j = 1; foreach($break_lagats as $break_lagat): // populating the breaks
                                            setObjectValuesFromZeroToBlank($break_lagat);
                                    ?>
                                      <tr id="break_row-<?=$count?>_<?=$j?>" class="break_row-<?=$count?>">
                                        <td><input type="hidden" name="break_no-<?=$count?>[]" value="<?=$break_lagat->break_no?>"</td>
                                        <!--<td></td>-->
                                        <td><?=$count?>.<?=$j?></td>
                                        <td> घटाउने भाग <input class="deduct_part" <?php if($break_lagat->deduct_part==1){ ?> checked="checked" <?php } ?> id="deduct-<?=$count?>_<?=$j?>" type="checkbox" name="deduct-<?=$count?>_<?=$j?>" value="1" /></td>
                                        <td colspan="2"><textarea  rows="3" name="break_work_name-<?=$count?>[]"><?=$break_lagat->break_work_name?></textarea></td>
                                        <td><input type="text" id="task_count-<?=$count?>_<?=$j?>" name="task_count-<?=$count?>[]" value="<?=$break_lagat->task_count?>" class="myWidth100"></td>
                                        <td><input type="text" id="length-<?=$count?>_<?=$j?>" name="length-<?=$count?>[]" value="<?=$break_lagat->length?>"  class="myWidth100"></td>
                                        <td><input type="text" id="breadth-<?=$count?>_<?=$j?>" name="breadth-<?=$count?>[]" value="<?=$break_lagat->breadth?>"  class="myWidth100"></td>
                                        <td><input type="text" id="height-<?=$count?>_<?=$j?>" name="height-<?=$count?>[]" value="<?=$break_lagat->height?>"  class="myWidth100"></td>
                                        <td><input type="text" id="total_evaluation-<?=$count?>_<?=$j?>" name="total_evaluation-<?=$count?>[]" value="<?=$break_lagat->total_evaluation?>"  class="myWidth100"></td>
                                        <td id="unit-1"></td> 
                                        <td><input type="hidden" name="break_no-<?=$count?>[]" value="<?=$break_lagat->break_no?>" /></td>
                                        <td></td>
                                        <td><img src="images/cross.png" class="remove_break" id="cross-<?=$count?>_<?=$j?>" name="cross" width="20px" height="20px" /></td>
                             </tr>
                                <?php $j++; endforeach; ?>
                             <!-- sub total row in case of break starts here -->
                                <tr id="total_output_row-<?=$count?>">
<!--                                    <td></td>
                                    <td></td>
                                    <td></td>-->
                                    <td colspan="4"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right">जम्मा</td>
                                    <td><input type="text" id="total_evaluation-<?=$count?>" name="total_evaluation[]" value="<?=$lagat_detail->total_evaluation?>" class="myWidth100"></td>
                                    <td id="unit-1"></td> 
                                    <td><input type="text" id="task_rate-<?=$count?>" name="task_rate[]" value="<?=$lagat_detail->task_rate?>" class="myWidth100"></td>
                                    <td><input type="text" id="total_rate-<?=$count?>" name="total_rate[]" value="<?=$lagat_detail->total_rate?>" class="myWidth100"></td>
                                    
                                </tr>
                                <!-- sub total row in case of break starts here -->
                            <?php endif; // break row ends here ?>
                             <?php if(empty($break_lagats)):// without break single row starts here
                                    $single_break = Estimatelagatanumanbreak::find_single_row($_GET['id'],$count);
                                        setObjectValuesFromZeroToBlank($single_break);
                             ?>
                                    <tr id="remove_estimate_detail-<?=$count?>" <?php if($count>1): ?> class="remove_estimate_detail" <?php endif; ?> >
                                        <td><?=$count?><input type="hidden" name="sno[]" value="<?=$count?>" /></td>
                                        <td><img id="break-<?=$count?>" class="row_delete" src="images/cross.png" width="20px" height="20px" /></td>
<!--                                        <td>
                                             <select name="task_id[]" id="task_id-1">
                                                            <option value="">---छान्नुहोस्---</option>
                                                            <?php foreach($work_details as $data):?>
                                                            <option value="<?php echo $data->id;?>" <?php if($lagat_detail->task_id==$data->id){?> selected="selected" <?php } ?>><?php echo $data->work_name;?></option>
                                                            <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td id="task_name_column-1"></td>-->
                                        <td id="estimate_sub-1" colspan="3"><textarea  cols="30"  rows="3" name="main_work_name[]"><?=$lagat_detail->main_work_name?></textarea></td>
                                        <td><input type="text"  id="task_count-<?=$count?>" name="task_count[]" class="myWidth100" value="<?=$single_break->task_count?>" /></td>
                                        <td><input type="text" id="length-<?=$count?>" name="length[]" class="myWidth100" value="<?=$single_break->length?>" /></td>
                                        <td><input type="text" id="breadth-<?=$count?>" name="breadth[]"  class="myWidth100" value="<?=$single_break->breadth?>"/></td>
                                        <td><input type="text" id="height-<?=$count?>" name="height[]"  class="myWidth100" value="<?=$single_break->height?>"/></td>
                                        <td><input type="text" id="total_evaluation-<?=$count?>" name="total_evaluation[]" value="<?=$lagat_detail->total_evaluation?>" class="myWidth100" /></td>
                                        <td id="unit-1"><select name="unit_id[]">
                                                <option value="">----</option>
                                            <?php foreach($units as $unit): ?>
                                                <option value="<?=$unit->id?>" <?php if($lagat_detail->unit_id==$unit->id){?> selected="selected"<?php } ?>><?=$unit->name?></option>
                                            <?php endforeach; ?>
                                        </td> 
                                        <td><input type="text" id="task_rate-<?=$count?>" name="task_rate[]" class="myWidth100" value="<?=$lagat_detail->task_rate?>" /></td>
                                        <td><input type="text" id="total_rate-<?=$count?>" name="total_rate[]" class="myWidth100" value="<?=$lagat_detail->total_rate?>"  /></td>
                                        
                                </tr>
                              <?php endif;// without break single row ends here ?>
                            <?php $count++; endforeach; ?>
                           
                                <tbody id="estimate_add_more_table" >
                                
                                </tbody>
                                <tr>
                               <td colspan="12"  id="task_name-1" style="text-align: right;"> कुल जम्मा</td>
                               <td><input type="text" name="sub_total" value="<?=$profile_details->sub_total?>" id="sub_total" /></td>
                           </tr>
                           <tr>
                        
                        <input type="hidden" name="update" value="<?=$update?>" />
                        <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                        <input type="hidden" name="period" value="<?=$_GET['period']?>" />
                        <td colspan="6"></td>
                        <td > <input type="submit" name="submit" value="<?=$save_text?>" class="btn" ></td>
                        <td colspan="6"></td>
                    </tr>
                        </table>
                            
                
                            
                           
                        <input type="hidden" id="type" name="type" value="2" />
                        
                                       
 </form>
                     </div>
                    <?php } else{ 
                        
                        echo getNapiView($_GET['period']); 
                    } ?>
                    <div id="dialog_show" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                           
                    
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>