<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$user = getUser();
error_reporting(-1);
//echo Get_empty_plan();
$type="";
$ward ="";
$max_ward = Ward::find_max_ward_no();
?>
<title>जोडिएका योजनाका रिपोर्ट </title>
<?php include("menuincludes/header.php"); ?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
            <h2 class="headinguserprofile">जोडिएका योजनाको रिपोर्ट हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">
                <div class="userprofiletable">
                                  <form method="post" onsubmit="form.submit()" >
                                  <div class="inputWrap">
                                  		<h1>जोडिएका योजनाको रिपोर्ट हेर्नुहोस</h1>
                                        <div class="titleInput">योजना / कार्यक्रम  खोज्नुहोस:</div>
                                        <div class="newInput"><select name="type"  onchange="form.submit();">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0" <?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
                                                </select></div>
                                         <div class="saveBtn myWidth100"><input type="submit" class="btn" name="submit" value="खोज्नुहोस"/></div>   
                                        <div class="myspacer"></div>    	
                                  </div><!-- input wrap ends -->
                                  </form>
                                  <?php if(isset($_POST['submit'])):
                                  $type=$_POST['type'];    
                                  ?>
                                <div class="myPrint"><a target="_blank" href="added_plan_report_print.php?type=<?= $type ?>&ward_no=<?=$ward?>">प्रिन्ट गर्नुहोस</a></div>
                                <div class="myspacer"></div>
                                 <?php if(!empty($ward)){
                                                                  echo "<h2>".convertedcit($ward)." नं वार्ड को ".get_type_nepali($type)." हेर्नुहोस </h2>";
                                                              }
                                    ?>
                                 <?php if($_POST['type']==0):?>
                                <?php $child_plan = Mergeplandetails::find_by_sql("SELECT * from merge_plan_id");// print_r($child_plan);?>
                                  <table class="table table-bordered table-hover">
                                <tr>   
                                    <th class="myCenter">सि नं </th>     
                                    <th class="myCenter">दर्ता नं</th>
                                    <th class="myCenter">जोडिएर बनेको नयाँ योजनाको नाम</th>
                                    <th class="myCenter">नयाँ योजनाको अनुदान रकम(रु.)</th>
                                    <th class="myCenter">वार्ड नं</th>
                                    <th class="myCenter">बिनियोजन श्रोत र व्याख्या</th>
                                    <th class="myCenter">जोडिएका योजना हरु</th>
                                </tr>
                                <?php 
                                $plan = Plandetails1::find_all();//echo "<pre>";print_r($plan);
                                $i=1; foreach($child_plan as $cp): 
                                    $ids = explode('-',$cp->parent_plan_ids);
                                        $new_ids = implode(',', $ids);
                                        $main_plans = Plandetails1::find_by_sql('select * from plan_details1 where id in('."{$new_ids}".')');
                                     
                                ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><a href="yojana_merge.php"><?php echo convertedcit($cp->plan_id);?></a></td>
                                    <?php 
                                    $plan_name = Plandetails1::find_by_id($cp->plan_id);
                                    ?>
                                    <td class="myCenter"><?php echo $plan_name->program_name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($plan_name->investment_amount);?>/-</td>
                                    <td class="myCenter"><?php echo convertedcit($plan_name->ward_no);?></td>
                                    <td class="myCenter"><?php echo $plan_name->parishad_sno;?></td>
                                    <td class="myCenter">
                                        <?php if(!empty($main_plans)) :
                                        foreach($main_plans as $mainplan) :
                                        $amount = $mainplan->first;//print_r($amount);
                                        $amount1 = $mainplan->second;//print_r($amount1);
                                        $amount2 = $mainplan->third;//print_r($amount2);
                                        ?>
                                        <li>
                                            <?php echo $mainplan->program_name;?>-(<?php echo convertedcit($mainplan->id);?>)-
                                            <?php if(!empty($amount)){
                                                echo convertedcit($amount);    
                                            }else if(!empty($amount1)){
                                                echo convertedcit($amount1);
                                            }else{
                                                echo convertedcit($amount2);
                                            }?>
                                        </li>
                                        <?php endforeach;endif;?>
                                    </td>
                                </tr>
                                <?php $i++; endforeach;?>
                               
                                      </table>
                                      <?php endif;?>
                                      <?php endif;?>
</div>
</div>
</div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>