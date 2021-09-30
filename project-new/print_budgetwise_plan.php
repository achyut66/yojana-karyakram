<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php include("menuincludes/header1.php"); ?>    
<?php
              
              $fiscal_id= $_GET['fiscal_id'];
              $budget_id=$_GET['budget_id'];
              $budget_result=  Topicbudgetprofile::find_by_id($budget_id);
              $fiscal_result=  Fiscalyear::find_by_id($fiscal_id);
              $budge_name=  Topicbudget::find_by_id($budget_result->budget_topic_id);
              $sql="select * from plan_details1 where fiscal_id='".$fiscal_id."' and budget_id=".$budget_id;
              $datas=  Plandetails1::find_by_sql($sql);
     ?>
                
                    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1">कार्यक्रम / योजना बजेट उप शीर्षक अनुसार बिनियोजन</h5>
                    
                    <div class="myspacer"></div>
		<div class="printContent">आर्थिक वर्ष : <?= convertedcit($fiscal_result->year);?>  <br>  बजेट उप शीर्षक :<b><?= $budge_name->name;?></div>
                
                <div class="printContent">
                    <table class="table table-bordered table-responsive">
                       
                            <tr>
                              <th rowspan="2" class="myCenter">सि.नं.</th>
                              <th rowspan="2" class="myCenter">दर्ता नं</th>
                              <th rowspan="2" class="myCenter">कार्यक्रम/आयोजनाको नाम</th>
                              <th rowspan="2" class="myCenter">ठेगाना</th>
                              <th rowspan="2" class="myCenter">क्षेत्र</th>
                              <th rowspan="2" class="myCenter">उपक्षेत्र</th>
                              <th colspan="4" class="myCenter">विनियोजन रु.</th>
                              <th rowspan="2" class="myCenter">कैफियत</th>
                            </tr>
                            <tr>
                              <th class="myCenter">प्रथम चौमासिक</th>
                              <th class="myCenter">दोश्रो चौमासिक</th>
                              <th class="myCenter">तेस्रो चौमासिक</th>
                              <th class="myCenter">जम्मा अनुदान </th>
                            </tr>
                            <?php
                            $first_total=0;
                            $second_total=0;
                            $third_total=0;
                            $total=0;
                            $i=1;foreach($datas as $data):
                                $total_amount= $data->first + $data->second + $data->third;?>
                            <tr>
                              <td><?php echo convertedcit($i);?></td>
                              <td><?php echo convertedcit($data->id);?></td>
                              <td><?php echo convertedcit($data->program_name);?></td>
                              <td><?php echo SITE_LOCATION;?>-<?php echo convertedcit($data->ward_no);?></td>
                              <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                              <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                              <td><?php echo convertedcit(placeholder($data->first));?></td>
                              <td><?php echo convertedcit(placeholder($data->second));?></td>
                              <td><?php echo convertedcit(placeholder($data->third));?></td>
                              <td><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                              <td>&nbsp;</td>
                              
                            </tr>
                         <?php $i++; 
                         $first_total +=$data->first;
                         $second_total +=$data->second;
                         $third_total +=$data->third;
                         $total +=$data->investment_amount;
                         endforeach;?>
                            </tr>
                            <tr>
                              <th colspan="6" class="myCenter">कुल जम्मा </th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($first_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($second_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($third_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($total));?></th>
                              <th  class="myCenter">&nbsp;</th>
                            </tr>
                       </table>
                  </div>
                  </div>
                  </div>
                  </div>

