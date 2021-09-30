<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
//echo Get_empty_plan();
//$counted_result = getOnlyRegisteredPlans();
//echo $counted_result; exit;
//$type= $_GET['type'];
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php include("menuincludes/header1.php"); ?>


    <div id="body_wrap_inner"> 
		<div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
					<!--<div class="subjectboldright">रिपोर्ट हेर्नुहोस  </div>-->				
									<div class="printContent">  
				  
                                 
                                 
                                
                                  <?php $child_plan = Mergeplandetails::find_by_sql("SELECT * from merge_plan_id"); ?>
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
                                       // echo "<pre>"; print_r($main_plans);
                                ?>
                                
                                
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($cp->plan_id);?></td>
                                    <?php 
                                    $plan_name = Plandetails1::find_by_id($cp->plan_id);//echo "<pre>";print_r($plan_name);exit;
                                    //$plan_name1 = Plandetails1::find_by_id($cp->parent_plan_ids);
                                  //print_r($plan_name1);
                                    
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
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->