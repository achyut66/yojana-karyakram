<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$user = getUser();
error_reporting(1);
//echo Get_empty_plan();
$type="";
$ward ="";
$max_ward = Ward::find_max_ward_no();
?>
<title>टुक्रिएका योजनाका रिपोर्ट </title>
<?php include("menuincludes/header.php"); ?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">टुक्रिएका योजनाको रिपोर्ट हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                
                <div class="userprofiletable">
				  
                                  <form method="post" onsubmit="form.submit()" >
                                  <div class="inputWrap">
                                  		<h1>टुक्रिएका योजनाको रिपोर्ट हेर्नुहोस</h1>
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
        <div class="myPrint"><a target="_blank" href="separated_plan_report_print.php?type=<?= $type ?>&ward_no=<?=$ward?>">प्रिन्ट गर्नुहोस</a></div>
        <!--<div class="myPrint"><a class="" href="report_excel.php?type=<?php echo $type;?>&ward_no=<?=$ward?>">Export to EXCEL</a></div>-->
        <!--<div class="exporte"></div><br>-->
        <div class="myspacer"></div>
         <?php if(!empty($ward)){
                                          echo "<h2>".convertedcit($ward)." नं वार्ड को ".get_type_nepali($type)." हेर्नुहोस </h2>";
                                      }
?>
                                 <?php if($_POST['type']==0):?>
                                
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
                                    <td class="myCenter"><a href="plan_form.php?break_plan_id=<?php echo $cp->plan_id?>"><?php echo convertedcit($cp->plan_id);?></a></td>
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
                                      <?php endif;?>
                                      <?php endif;?>
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>