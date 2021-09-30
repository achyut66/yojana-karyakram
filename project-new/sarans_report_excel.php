<?php require_once("includes/initialize.php");
$output = "";
$topic_area_agreement = Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
$budget_result=  Topicbudget::find_all();
$fiscals=  Fiscalyear::find_all();
if($_GET['type']==1)
{
    $name="बिषयगत क्षेत्र";
}
else
{
    $name="बजेट शिर्षक";
}
$output.= '<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body><div style="text-align:center;">
                                      <span style="text-align:center;">'.SITE_LOCATION.'</span><br>
                          <span  style="text-align:center;">'.SITE_ADDRESS.'</span><br>
                           <span  style="text-align:center;">योजनाको प्रगती विवरण</span><br><br><br>
                         <span  style="text-align:center;"><b>';if(empty($_GET['ward_no'])){ $output.= $name." अनुसार सारांसमा रिपोर्ट हेर्नुहोस ";}else{ $output.="वार्ड नं ".convertedcit($_GET['ward_no'])." अन्तर्गत ".$name."को  सारांसमा रिपोर्ट हेर्नुहोस ";} $output.='</b></span>
                        
                                  </div>';
                             if($_GET['type']==1){
                  $output.='<table border="2">
                                                <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम  </td>
                                                 <td rowspan="2" >कुल कार्यक्रम/आयोजनाको संख्या </td>
                                                 <td rowspan="2" width="40">एकाई</td>
                                                 <td rowspan="2" width="40">पुँजीगत खर्च रकम </td>
                                                 <td rowspan="2" >चालु खर्च रकम </td>
                                                 <td rowspan="2" > विनियोजित रकम </td>
                                                  <td rowspan="2" >प्रतिशत</td>
                                                  <td rowspan="2" width="172"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                  
                                                  
                                                </tr>';
     $i=1;                                          
   $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_pujigat=0;
    $total_chalu=0;
    $total_pujigat_count=0;
    $total_chalu_count=0;
    foreach($topic_area as $topic){    
            $count=  Plandetails1::count_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_kharcha=  Plandetails1::get_total_expenditure($topic->id,$_GET['fiscal_id'],"expenditure_type",1,$_GET['ward_no']);
            $pujigat_count=  Plandetails1::count_by_topic_area_id_expenditure_type($topic->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_kharcha =  Plandetails1::get_total_expenditure($topic->id,$_GET['fiscal_id'],"expenditure_type",2,$_GET['ward_no']);
            $chalu_count= Plandetails1::count_by_topic_area_id_expenditure_type($topic->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_GET['ward_no']);
            $vaar=($investment/$total_investment) *100;
        
                                                $output.='<tr>
                                                  <td>'.convertedcit($i).'</td>
                                                  <td>'.$topic->name.'</td>
                                                  <td>'.convertedcit($count).'</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit(placeholder($pujigat_kharcha)).'</td>
                                                  <td>'.convertedcit(placeholder($chalu_kharcha)).'</td>
                                                  <td>'.convertedcit(placeholder($investment)).'</td>
                                                  <td>'.convertedcit(round($vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                 
                                                  <td>&nbsp;</td>
                                                </tr>';
                                                 $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                    $total_pujigat+=$pujigat_kharcha;
                                    $total_chalu+=$chalu_kharcha;
                                    $total_pujigat_count+=$pujigat_count;
                                    $total_chalu_count+=$chalu_count;

    }  $pujigat_vaar=($total_pujigat/$total_investment) *100;
    $chalu_vaar=($total_chalu/$total_investment) *100;
    $total_exp_vaar=$pujigat_vaar + $chalu_vaar;
                                                $output.=' <tr>
                                                 <td colspan="2"align="left">जम्मा</td>
                                                  <td>'.convertedcit($total_count).'</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit(placeholder($total_pujigat)).'</td>
                                                  <td>'.convertedcit(placeholder($total_chalu)).'</td>
                                                  <td>'.convertedcit(placeholder($final_investment)).'</td>
                                                  <td>'.convertedcit(round($total_var, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                                                                  <td>&nbsp;</td>
                                                </tr>
                                               <tr>
                                                    <td><b>क</b></td>
                                                    <td colspan="5"><b>कुल जम्मा विनियोजित चालु </b></td>
                                                    <td><b>'.convertedcit(placeholder($total_chalu)).'</b></td>
                                                    <td>'.convertedcit(round($chalu_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                </tr>
                                                 <tr>
                                                     <td><b>ख</b></td>
                                                    <td colspan="5"><b>कुल जम्मा विनियिजत पुजिगत </b></td>
                                                    <td><b>'.convertedcit(placeholder($total_pujigat)).'</b></td>
                                                    <td>'.convertedcit(round($pujigat_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                 </tr>
                                                 <tr>
                                                    <td></td>
                                                    <td colspan="5"><b>जम्मा विनियोजित</b></td>
                                                    <td ><b>'.convertedcit(placeholder($final_investment)).'</b></td>
                                                    <td>'.convertedcit(round($total_exp_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                 </tr>
                                                
                                              </table>';
                                  }else{
                 $output.=' <table table border="2">
                                               <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > बजेट उपशीर्षगत क्षेत्रको किसिम  </td>
                                                  <td rowspan="2" >कार्यक्रम/आयोजनाको संख्या </td>
                                                  <td rowspan="2" width="40">एकाई</td>
                                                  <td rowspan="2" width="40">पुँजीगत खर्च रकम </td>
                                                 <td rowspan="2" >चालु खर्च रकम </td>
                                                  <td rowspan="2" > विनियोजित रकम </td>
                                                  <td rowspan="2" >प्रतिशत</td>
                                                  <td rowspan="2" width="172"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                </tr>';
     $i=1;                                       
     $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_pujigat=0;
    $total_chalu=0;
    $total_pujigat_count=0;
    $total_chalu_count=0;
    foreach($budget_result as $data){    
        
            $budget_id=  Topicbudgetprofile::find_by_budget_topic_id($data->id);
        if(empty($budget_id))
        {
           continue; 
        }
            $count=  Plandetails1::count_by_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_only_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $pujigat_kharcha=  Plandetails1::get_total_expenditureByBudget($data->id,$_GET['fiscal_id'],"expenditure_type",1,$_GET['ward_no']);
            $pujigat_count=  Plandetails1::count_by_budget_id_expenditure_type($data->id,$_GET['fiscal_id'],1,$_GET['ward_no']);
            $chalu_kharcha =  Plandetails1::get_total_expenditureByBudget($data->id,$_GET['fiscal_id'],"expenditure_type",2,$_GET['ward_no']);
            $chalu_count= Plandetails1::count_by_budget_id_expenditure_type($data->id,$_GET['fiscal_id'],2,$_GET['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_GET['ward_no']);
            $vaar=($investment/$total_investment) *100;
        
       
                                               $output.='<tr>
                                                  <td>'.convertedcit($i).'</td>
                                                  <td>'.$data->name.'</td>
                                                  <td>'.convertedcit($count).'</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit(placeholder($pujigat_kharcha)).'</td>
                                                  <td>'.convertedcit(placeholder($chalu_kharcha)).'</td>
                                                  <td>'.convertedcit(placeholder($investment)).'</td>
                                                  <td>'.convertedcit(round($vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                 
                                                  <td>&nbsp;</td>
                                                </tr>';
                                                $i++;
                                    $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_pujigat+=$pujigat_kharcha;
                                    $total_chalu+=$chalu_kharcha;
                                    $total_pujigat_count+=$pujigat_count;
                                    $total_chalu_count+=$chalu_count;
    }
   
    $pujigat_vaar=($total_pujigat/$total_investment) *100;
    $chalu_vaar=($total_chalu/$total_investment) *100;
    $total_exp_vaar=$pujigat_vaar + $chalu_vaar;
                                              $output.=' <tr>
                                                 <td colspan="2"align="left">जम्मा</td>
                                                  <td>'.convertedcit($total_count).'</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit(placeholder($total_pujigat)).'</td>
                                                  <td>'.convertedcit(placeholder($total_chalu)).'</td>
                                                  <td>'.convertedcit(placeholder($final_investment)).'</td>
                                                  <td>'.convertedcit(round($total_var, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><b>क</b></td>
                                                    <td colspan="5"><b>कुल जम्मा विनियोजित चालु </b></td>
                                                    <td><b>'.convertedcit(placeholder($total_chalu)).'</b></td>
                                                    <td>'.convertedcit(round($chalu_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                </tr>
                                                 <tr>
                                                     <td><b>ख</b></td>
                                                    <td colspan="5"><b>कुल जम्मा विनियिजत पुजिगत </b></td>
                                                    <td><b>'.convertedcit(placeholder($total_pujigat)).'</b></td>
                                                    <td>'.convertedcit(round($pujigat_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                 </tr>
                                                 <tr>
                                                    <td></td>
                                                    <td colspan="5"><b>जम्मा विनियोजित</b></td>
                                                    <td ><b>'.convertedcit(placeholder($final_investment)).'</b></td>
                                                    <td>'.convertedcit(round($total_exp_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td></td>
                                                 </tr>
                                                
                                              </table>';
                                  }
                                  $output.='</body></html>';
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=sarans_expenditure_report.xls");
echo $output; ?>