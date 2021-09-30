<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
include("menuincludes/header1.php"); ?>
<?php
$topic_area_agreement= Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
ini_set('max_execution_time', 300);
$fiscal_id=$_GET['fiscal_id'];
$topic_area_agreement_id=$_GET['topic_area_agreement_id'];
 $result=getPlanArrayForAnudanExpenditure($topic_area_agreement_id,$fiscal_id,$_GET['ward_no']);
?>
<body>
 <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
									
									<div class="printContent">  
             <div class="ourHeader"> <?php if(empty($_GET['ward_no'])){echo Topicareaagreement::getName($topic_area_agreement_id);}else{ echo "वार्ड नं ".convertedcit($_GET['ward_no'])." अन्तर्गत ".Topicareaagreement::getName($topic_area_agreement_id);}?> अनुसार खर्च विवरण </div>
                   <table class="table table-bordered table-responsive mytable">
                                                <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम  </td>
                                                  <td rowspan="2" width="40">एकाई</td>
                                                  <td rowspan="2" >कार्यक्रम/आयोजनाको संख्या </td>
                                                  <td rowspan="2" > विनियोजित रकम </td>
                                                  <td rowspan="2">खर्च रकम</td>
                                                  <td rowspan="2">खर्च प्रतिशत</td>
                                                  <td rowspan="2" width="172"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                  
                                                  
                                                </tr>
                                               
    <?php $i=1;
     $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
foreach($topic_area as $topic){
         $count=count($result[$topic->id]);
         if(!empty($result[$topic->id])){
                $investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$result[$topic->id]));
        }
        else{
            $investment=0;
        }
          $amount=get_total_expenditure_in_anudan_wise_all_plans($topic_area_agreement_id,$fiscal_id,$topic->id,$_GET['ward_no']);
         if($amount==0)
            {
                $kharcha_amount=0;
                $vaar=0;
            }
            
            else
            {
                $kharcha_amount = $amount;
                $vaar=($kharcha_amount/$investment) *100;
            }
            if($count==0)
            {
                continue;
            }
?>
                                                <tr>
                                                        <td><?php echo convertedcit($i);?></td>
                                                        <td><?php echo $topic->name;?></td>
                                                        <td>वटा</td>
                                                        <td><?php echo convertedcit($count);?></td>
                                                        <td><?php echo convertedcit(placeholder($investment));?></td>
                                                        <td><?php echo convertedcit(placeholder($kharcha_amount));?></td>
                                                        <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                     <?php $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
}                                   
                                    $total_vaar=($total_kharcha/ $final_investment)*100;
  ?>
                                                <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td><?php echo convertedcit(placeholder($final_investment));?></td>
                                                <td><?php echo convertedcit(placeholder($total_kharcha));?></td>
                                                    <td><?php echo convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                
                                              </table>
                                  
                     
            </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
   