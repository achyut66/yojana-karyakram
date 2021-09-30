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
                       
                                  </div> <div class="ourHeader">';if(empty($_GET['ward_no'])){ $output.=$name." अनुसार सारांसमा रिपोर्ट हेर्नुहोस ";}else{ $output.= "वार्ड नं ".convertedcit($_GET['ward_no'])." अन्तर्गत ".$name."को  सारांसमा रिपोर्ट हेर्नुहोस ";}$output.='</div>
                          ';
                             if($_GET['type'] == 1){
                  $output.='<table class="table table-bordered table-responsive mytable">
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
                                                  
                                                  
                                                </tr>';
                                               $i=1;
                                               $total_count=0;
                                               $final_investment=0;
                                               $total_var =0;
                                               $total_kharcha=0;
                            foreach($topic_area as $topic){ 
                                     $count=  Plandetails1::count_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
                                    $investment=  Plandetails1::get_total_investment_by_topic_area_id($topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
                                    $total_investment=  Plandetails1::get_total_investment();
                                    $amount=get_total_expenditure_from_ekmusta_budget("topic_area_id",$topic->id,$_GET['fiscal_id'],$_GET['ward_no']);
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

                               $output.='<tr>
                                                       <td>'.convertedcit($i).'</td>
                                                        <td>'.$topic->name.'</td>
                                                        <td>वटा</td>
                                                        <td>'.convertedcit($count).'</td>
                                                        <td>'. convertedcit(placeholder($investment)).'</td>
                                                        <td>'.convertedcit($kharcha_amount).'</td>
                                                        <td>'.convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                        <td>&nbsp;</td>
                                                </tr>';
                                      $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    }
                                               $output.=' <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit($total_count).'</td>
                                                  <td>'.convertedcit(placeholder($final_investment)).'</td>
                                                 <td>'.convertedcit($total_kharcha).'</td>
                                                   <td>'.convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                
                                              </table>';
                                   }
                                   else{
                  $output.=' <table class="table table-bordered table-responsive mytable">
                                                <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > बजेट उपशीर्षगत क्षेत्रको किसिम  </td>
                                                  <td rowspan="2" width="40">एकाई</td>
                                                  <td rowspan="2" >कार्यक्रम/आयोजनाको संख्या </td>
                                                  <td rowspan="2" > विनियोजित रकम </td>
                                                  <td rowspan="2">खर्च रकम</td>
                                                  <td rowspan="2">खर्च प्रतिशत</td>
                                                  <td rowspan="2" width="172"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                  
                                                  
                                                </tr>';
                  $i=1;
    $total_count=0;
    $final_investment=0;
    $total_var =0;
     $total_kharcha=0;
    foreach($budget_result as $data){    
        
            $budget_id=  Topicbudgetprofile::find_by_budget_topic_id($data->id);
        if(empty($budget_id))
        {
           continue; 
        }
             $count=  Plandetails1::count_by_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_only_budget_id($data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_GET['ward_no']);
            $amount=get_total_expenditure_from_ekmusta_budget("budget_id",$data->id,$_GET['fiscal_id'],$_GET['ward_no']);
            if($amount==0)
            {
                $kharcha_amount=0;
                $vaar=0;
            }
            else
            {
                $kharcha_amount=$amount;
                $vaar=($kharcha_amount/$investment) *100;
            }
          
                                              $output.='  <tr>
                                                    <td>'.convertedcit($i).'</td>
                                                  <td>'.$data->name.'</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit($count).'</td>
                                                  <td>'.convertedcit(placeholder($investment)).'</td>
                                                  <td>'.convertedcit(placeholder($kharcha_amount)).'</td>
                                                  <td>'.convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                  <td>&nbsp;</td>
                                                </tr>';
                                     $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    } 
                                               $output.=' <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td>'.convertedcit($total_count).'</td>
                                                  <td>'.convertedcit(placeholder($final_investment)).'</td>
                                                   <td>'.convertedcit($total_kharcha).'</td>
                                                   <td>'.convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP)).' %</td>
                                                    <td>&nbsp;</td> 
                                                  <td>&nbsp;</td>
                                                </tr>
                                                
                                              </table>';
                                  }
                                  $output.='</body></html>';
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=sarans_expenditure_report.xls");
echo $output; ?>