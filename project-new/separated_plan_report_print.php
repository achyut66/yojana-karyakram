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
				  
                                 
                                 
                                
                                  <?php $child_plan = Childplandetails::find_by_sql("SELECT * from child_plan_details"); 
                                 //echo "<pre>";print_r($child_plan);?>
                                  <table class="table table-bordered table-hover">
                                <tr>   
                                    <th class="myCenter">सि नं </th>     
                                    <th class="myCenter">दर्ता नं</th>
                                    <th class="myCenter">टुक्रिएर बनेको नयाँ योजनाको नाम</th>
                                    <th class="myCenter">नयाँ योजनाको अनुदान रकम(रु.)</th>
                                    <th class="myCenter">वार्ड नं</th>
                                    <th class="myCenter">बिनियोजन श्रोत र व्याख्या</th>
                                    <th class="myCenter">मुख्य योजना / कार्यक्रमको नाम (दर्ता नं)</th>
                                </tr>
                                <?php 
                                $plan = Plandetails1::find_all();//echo "<pre>";print_r($plan);
                                $i=1; foreach($child_plan as $cp): ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($cp->plan_id);?></td>
                                    <?php $plan_name = Plandetails1::find_by_id($cp->plan_id);//echo "<pre>";print_r($plan_name);
                                        $plan_name1 = Plandetails1::find_by_id($cp->parent_plan_id);
                                    ?>
                                    <td class="myCenter"><?php echo $plan_name->program_name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($plan_name->investment_amount);?>/-</td>
                                    <td class="myCenter"><?php echo convertedcit($plan_name->ward_no);?></td>
                                    <td class="myCenter"><?php echo $plan_name->parishad_sno;?></td>
                                    <td class="myCenter"><?php echo $plan_name1->program_name;?>-(<?php echo convertedcit($plan_name1->id);?>)</td>
                                </tr>
                                <?php $i++; endforeach;?>
                               
                                      </table>  
                                
					
                </div>
                  </div>
                </div><!-- main menu ends -->
         
    </div><!-- top wrap ends -->
    