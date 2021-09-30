<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
include("menuincludes/header1.php"); ?>
<?php
$ward = $_GET['ward_no'];
$format=$_GET['format'];
$fiscal_id=$_GET['fiscal_id'];
$type=$_GET['type'];
ini_set('max_execution_time',300);
$fiscals=  Fiscalyear::find_all();
if($_GET['type']==0)
    {
        $name=" योजनाको ";
    }
    else
    {
        $name = " कार्यक्रमको ";
    }
    if($_GET['format']==1)
    {
        $topic = " बिषयगत क्षेत्र ";
    }
    else
    {
        $topic = " बजेट उपशीर्षक ";
    }
    if(!empty($_GET['ward_no']))
    {
        $ward = "वडा नं ".convertedcit($_GET['ward_no'])." को ";
    }
    else
    {
        $ward="";
    }
$topic_result = Topicarea::find_all();
$budget_result=  Topicbudget::find_all();
?>
<body>

  <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                                           <div style="text-align:center;">
                                                                  
                    <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>   
                                           <div style="text-align:center;">
                                               <div class="ourHeader"><?php echo  $ward.$name.$topic." अनुसार " ;?>चौमासिक खर्च रिपोर्ट हेर्नुहोस </div>
                               <?php if($_GET['type']==0 && $_GET['format']==1){ ?>  
                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम</Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($topic_result as $topic){
     
                                                $first_date = get_chaumasik_date($_GET['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_GET['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_GET['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("topic_area_id",$topic->id,$_GET['ward_no'],$_GET['type']);
//                                               echo $total_investment;exit;
                                                $first_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,2,$_GET['ward_no'],$first_date[1],$first_date[2]);
                                                $second_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,1,$_GET['ward_no'],$second_date[1],$second_date[2]);
                                                $third_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,1,$_GET['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                $first_contract_amount = get_amount_chaumasik_contract("topic_area_id",$topic->id,2,$_GET['ward_no'],$first_date[1],$first_date[2]);
                                                $second_contract_amount = get_amount_chaumasik_contract("topic_area_id",$topic->id,1,$_GET['ward_no'],$second_date[1],$second_date[2]);
                                                $third_contract_amount =  get_amount_chaumasik_contract("topic_area_id",$topic->id,1,$_GET['ward_no'],$third_date[1],$third_date[2]);
                                               
                                                $total_first_amount = $first_plan_amount + $first_contract_amount;
                                                $total_second_amount = $second_plan_amaount + $second_contract_amount;
                                                $total_third_amount = $third_plan_amount + $third_contract_amount;
                                                 $total_expenditure= $total_first_amount + $total_second_amount + $total_third_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                            <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($total_first_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_second_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_third_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                               <?php }
                               elseif($_GET['type']==0 && $_GET['format']==2){?>
                                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>बजेट उपशीर्षगत क्षेत्रको किसिम </Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($budget_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_GET['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_GET['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_GET['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("budget_id",$topic->id,$_GET['ward_no'],$_GET['type']);
//                                               echo $total_investment;exit;
                                                $first_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,2,$_GET['ward_no'],$first_date[1],$first_date[2]);
                                                $second_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,1,$_GET['ward_no'],$second_date[1],$second_date[2]);
                                                $third_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,1,$_GET['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                $first_contract_amount = get_amount_chaumasik_contract("budget_id",$topic->id,2,$_GET['ward_no'],$first_date[1],$first_date[2]);
                                                $second_contract_amount = get_amount_chaumasik_contract("budget_id",$topic->id,1,$_GET['ward_no'],$second_date[1],$second_date[2]);
                                                $third_contract_amount =  get_amount_chaumasik_contract("budget_id",$topic->id,1,$_GET['ward_no'],$third_date[1],$third_date[2]);
                                               
                                                $total_first_amount = $first_plan_amount + $first_contract_amount;
                                                $total_second_amount = $second_plan_amaount + $second_contract_amount;
                                                $total_third_amount = $third_plan_amount + $third_contract_amount;
                                                 $total_expenditure= $total_first_amount + $total_second_amount + $total_third_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                             <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($total_first_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_second_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_third_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                <?php }else{ ?>
                                   
                                  <?php if($_GET['type']==1 && $_GET['format']==1){ ?>  
                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम</Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($topic_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_GET['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_GET['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_GET['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("topic_area_id",$topic->id,$_GET['ward_no'],$_GET['type']);
//                                               echo $total_investment;exit;
                                                $first_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,2,$_GET['ward_no'],$first_date[1],$first_date[2]);
                                                $second_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,1,$_GET['ward_no'],$second_date[1],$second_date[2]);
                                                $third_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,1,$_GET['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                 $total_expenditure= $first_program_amount + $second_program_amount + $third_program_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                            <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($first_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($second_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($third_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                               <?php }
                               elseif($_GET['type']==1 && $_GET['format']==2){?>
                                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>बजेट उपशीर्षगत क्षेत्रको किसिम </Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($budget_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_GET['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_GET['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_GET['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("budget_id",$topic->id,$_GET['ward_no'],$_GET['type']);
//                                               echo $total_investment;exit;
                                                $first_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,2,"",$first_date[1],$first_date[2]);
                                                $second_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,1,"",$second_date[1],$second_date[2]);
                                                $third_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,1,"",$third_date[1],$third_date[2]);
                                                
                                              
                                                 $total_expenditure= $first_program_amount + $second_program_amount + $third_program_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                             <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($first_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($second_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($third_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>  
                                   
                                   
                <?php } } ?>

                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->