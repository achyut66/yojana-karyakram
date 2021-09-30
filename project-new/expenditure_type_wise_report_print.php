<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php include("menuincludes/header1.php"); ?>    

<?php
$topic_area_agreement= Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
$budget_result=  Topicbudget::find_all();
$fiscals=  Fiscalyear::find_all();
$type=$_GET['type'];
$fiscal_id=$_GET['fiscal_id'];
 if($_GET['type']==1)
                            {
                                $name="बिषयगत क्षेत्र";
                            }
                            else
                            {
                                $name="बजेट शिर्षक";
                            }
     ?>
                
                    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?></h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
									
				 <div class="ourHeader"><?php if(empty($_GET['ward_no'])){ echo $name." अन्तर्गत ";}else{echo "वडा नं ".convertedcit($_GET['ward_no'])." को  ".$name." अन्तर्गत ";}?>खर्च किसिम अनुसार रिपोर्ट हेर्नुहोस</div>
                                 <?php if($_GET['type']==1){?>
                  <table class="table table-bordered table-responsive mytable">
                                              <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                    <td rowspan="2" style="text-align: center;">विवरण</td>
                                                    <td rowspan="2" >परिमाण</td>
                                                    <td rowspan="2">एकाई</td>
                                                    <td colspan="3" style="text-align: center;">विनियोजित रकम</td>
                                                    <td colspan="3" style="text-align: center;">खर्च रकम</td>
                                                    <td rowspan="2">खर्च प्रतिशत</td>
                                                    <td rowspan="2">कैफियत</td>
                                                  </tr>
                                                <tr>
                                                    <td style="text-align: center;">पुँजीगत </td>
                                                    <td style="text-align: center;">चालु</td>
                                                    <td style="text-align: center;">जम्मा</td>
                                                    <td style="text-align: center;">पुँजीगत </td>
                                                    <td style="text-align: center;">चालु</td>
                                                    <td style="text-align: center;">जम्मा</td>
                                                </tr>
                                                
                                               
    <?php $i=1;
//    $topic_area_investment_array=array();
   $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
    $total_pujigat_investment=0;
    $total_chalu_investment=0;
    $total_pujigat_kharcha=0;
    $total_chalu_kharcha=0;
    foreach($topic_area as $topic){    
//        echo $topic->id;exit;
            $count=  Plandetails1::count_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_investment=  Plandetails1::get_total_investment_by_topic_area_id_expenditure_type($topic->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_investment= Plandetails1::get_total_investment_by_topic_area_id_expenditure_type($topic->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_GET['ward_no']);
            $amount=get_total_expenditure_from_ekmusta_budget("topic_area_id",$topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_kharcha=get_total_expenditure_from_ekmusta_budget_topic_area_id_expenditure_type("topic_area_id",$topic->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_kharcha=get_total_expenditure_from_ekmusta_budget_topic_area_id_expenditure_type("topic_area_id",$topic->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
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
            
        ?>
                                                <tr>
                                                        <td><?php echo convertedcit($i);?></td>
                                                        <td><?php echo $topic->name;?></td>
                                                        <td><?php echo convertedcit($count);?></td>
                                                        <td>वटा</td>
                                                       <td><?php echo convertedcit(placeholder($pujigat_investment));?></td>
                                                       <td><?php echo convertedcit(placeholder($chalu_investment));?></td>
                                                       <td><?php echo convertedcit(placeholder($investment));?></td>
                                                        <td><?php echo convertedcit(placeholder($pujigat_kharcha));?></td>
                                                          <td><?php echo convertedcit(placeholder($chalu_kharcha));?></td>
                                                        <td><?php echo convertedcit(placeholder($kharcha_amount));?></td>
                                                        <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                     <?php $i++;
                                     $total_pujigat_investment+=$pujigat_investment;
                                     $total_chalu_investment+=$chalu_investment;
                                     $total_pujigat_kharcha+=$pujigat_kharcha;
                                     $total_chalu_kharcha+=$chalu_kharcha;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    } 
    $pujigat_vaar=($total_pujigat_kharcha/$total_pujigat_investment) *100;
    $chalu_vaar=($total_chalu_kharcha/$total_chalu_investment) *100;
    $total_exp_vaar=($total_kharcha/$final_investment)*100;
    ?>
                                                <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit(placeholder($total_pujigat_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_chalu_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($final_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_pujigat_kharcha));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_chalu_kharcha));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_kharcha));?></td>
                                                    <td><?php echo convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><b>क</b></td>
                                                    <td colspan="8" style="text-align: center;"><b>कुल जम्मा चालु खर्च </b></td>
                                                    <td><b><?php echo convertedcit(placeholder($total_chalu_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($chalu_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                </tr>
                                                 <tr>
                                                     <td><b>ख</b></td>
                                                    <td colspan="8" style="text-align: center;"><b>कुल जम्मा पुजिगत खर्च  </b></td>
                                                    <td><b><?php echo convertedcit(placeholder($total_pujigat_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($pujigat_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                 </tr>
                                                 <tr>
                                                    <td></td>
                                                    <td colspan="8" style="text-align: center;"><b>जम्मा खर्च </b></td>
                                                    <td ><b><?php echo convertedcit(placeholder($total_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($total_exp_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                 </tr>
                                              </table>
                                  <?php }else{?>
                  <table class="table table-bordered table-responsive mytable">
                                                 <tr height="38">
                                                    <td rowspan="2" >क्र.सं.</td>
                                                    <td rowspan="2" style="text-align: center;">विवरण</td>
                                                    <td rowspan="2" >परिमाण</td>
                                                    <td rowspan="2">एकाई</td>
                                                    <td colspan="3" style="text-align: center;">विनियोजित रकम</td>
                                                    <td colspan="3" style="text-align: center;">खर्च रकम</td>
                                                    <td rowspan="2">खर्च प्रतिशत</td>
                                                    <td rowspan="2">कैफियत</td>
                                                  </tr>
                                                <tr>
                                                    <td style="text-align: center;">पुँजीगत </td>
                                                    <td style="text-align: center;">चालु</td>
                                                    <td style="text-align: center;">जम्मा</td>
                                                    <td style="text-align: center;">पुँजीगत </td>
                                                    <td style="text-align: center;">चालु</td>
                                                    <td style="text-align: center;">जम्मा</td>
                                                </tr>
    <?php $i=1;
//    $topic_area_investment_array=array();
      $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
    $total_pujigat_investment=0;
    $total_chalu_investment=0;
    $total_pujigat_kharcha=0;
    $total_chalu_kharcha=0;
    foreach($budget_result as $data){    
        
            $budget_id=  Topicbudgetprofile::find_by_budget_topic_id($data->id);
        if(empty($budget_id))
        {
           continue; 
        }
            $count=  Plandetails1::count_by_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_only_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_investment=  Plandetails1::get_total_investment_by_budget_id_expenditure_type($data->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_investment= Plandetails1::get_total_investment_by_budget_id_expenditure_type($data->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_GET['ward_no']);
            $amount = get_total_expenditure_from_ekmusta_budget("budget_id",$data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_kharcha=get_total_expenditure_from_ekmusta_budget_topic_area_id_expenditure_type("budget_id",$data->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_kharcha=get_total_expenditure_from_ekmusta_budget_topic_area_id_expenditure_type("budget_id",$data->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
            
                $kharcha_amount=$pujigat_kharcha + $chalu_kharcha;
                $vaar=($kharcha_amount/$investment) *100;
            
        ?>
                                                <tr>
                                                    <td><?php echo convertedcit($i);?></td>
                                                  <td><?php echo $data->name;?></td>
                                                  <td><?php echo convertedcit($count);?></td>
                                                    <td>वटा</td>
                                                   <td><?php echo convertedcit(placeholder($pujigat_investment));?></td>
                                                   <td><?php echo convertedcit(placeholder($chalu_investment));?></td>
                                                   <td><?php echo convertedcit(placeholder($investment));?></td>
                                                    <td><?php echo convertedcit(placeholder($pujigat_kharcha));?></td>
                                                    <td><?php echo convertedcit(placeholder($chalu_kharcha));?></td>
                                                    <td><?php echo convertedcit(placeholder($kharcha_amount));?></td>
                                                    <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                   <?php $i++;
                                     $total_pujigat_investment+=$pujigat_investment;
                                     $total_chalu_investment+=$chalu_investment;
                                     $total_pujigat_kharcha+=$pujigat_kharcha;
                                     $total_chalu_kharcha+=$chalu_kharcha;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    } $pujigat_vaar=($total_pujigat_kharcha/$total_pujigat_investment) *100;
    $chalu_vaar=($total_chalu_kharcha/$total_chalu_investment) *100;
    $total_exp_vaar=($total_kharcha/$final_investment)*100;?>
                                                <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit(placeholder($total_pujigat_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_chalu_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($final_investment));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_pujigat_kharcha));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_chalu_kharcha));?></td>
                                                  <td><?php echo convertedcit(placeholder($total_kharcha));?></td>
                                                    <td><?php echo convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                 <tr>
                                                    <td><b>क</b></td>
                                                    <td colspan="8" style="text-align: center;"><b>कुल जम्मा चालु खर्च </b></td>
                                                    <td><b><?php echo convertedcit(placeholder($total_chalu_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($chalu_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                </tr>
                                                 <tr>
                                                     <td><b>ख</b></td>
                                                    <td colspan="8" style="text-align: center;"><b>कुल जम्मा पुजिगत खर्च  </b></td>
                                                    <td><b><?php echo convertedcit(placeholder($total_pujigat_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($pujigat_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                 </tr>
                                                 <tr>
                                                    <td></td>
                                                    <td colspan="8" style="text-align: center;"><b>जम्मा खर्च </b></td>
                                                    <td ><b><?php echo convertedcit(placeholder($total_kharcha));?></b></td>
                                                    <td><b><?php echo convertedcit(round($total_exp_vaar, 2, PHP_ROUND_HALF_UP));?> %</b></td>
                                                    <td></td>
                                                 </tr>
                                              </table>
                                  <?php }?>
                                 
                  </div>
                  </div>
                  </div>


