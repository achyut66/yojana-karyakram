<?php 
    function getUsedPeriodArray()
    {
        $array = array();
        if($_GET['period']>1)
        {
            for($i=1;$i<=$_GET['period'];$i++)
            {
                array_push($array, $i);
            }
        }
        else
        {
            $array[]= $_GET['period'];
        }
        return $array;
    }
    function getNapiView($period)
    {
        $profile_details = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$period);
        $max_period = NapiLagatProfile::find_max_period($_GET['id']);
        $del_link = '';
        if($max_period==$profile_details->period)
        {
            $del_link = '<a class="del-napi" onclick="return(confirm(\'के तपाई निश्चित हुनुहुन्छ ?\'));"  href="delete_napi_details.php?plan_id='.$_GET['id'].'&period='.$period.'" >Delete</a>';
        }
        $sql = "select * from napi_lagat_anuman where plan_id=".$_GET['id']." and period=".$period." order by sno asc";
        $lagat_details = Napilagatanuman::find_by_sql($sql);
//        print_r($lagat_details); exit;
        if(empty($lagat_details))
        {
            return false;
        }
        $sno_array = Napilagatanuman::getAllSnoByPlanId($_GET['id']);
        $nep_char_array = getPeriodArray();
        $html = '';
        $html .='<span>'.$del_link.'</span>';
        $html .= '<span class="myPrint"><a href="print_estimate_naapi_final.php?id='.$_GET['id'].'&period='.$period.'" target="_blank">प्रिन्ट गर्नुहोस</a></span>';
        $html .='<table class=" table-bordered  myWidth100 myFont10">';
        $html .='<tr>'
                . '<td>मिति</td><td>'.convertedcit($profile_details->date_nepali).'</td><td>'.$nep_char_array[$period].' नापी</td>'
                . '</tr>';
        
        $html .='</table>';
        $html .= '<table class=" table-bordered  myWidth100 myFont10">
                        
                            <tr>
                                <td class="mycenter">सि.नं.</td>
                                <td class="mycenter">इष्टिमेट न०</td>';
//                                <td class="mycenter">क्षेत्र</td>
//                                <th></td>
                          $html .='<td class="mycenter">विवरण</td>
                                <td class="mycenter">संख्या</td>
                                <td class="mycenter">लम्बाई</td>
                                <td class="mycenter">चौडाई</td>
                                <td class="mycenter">उचाई</td>
                                <td class="mycenter">परिमाण</td>
                                <td class="mycenter">इकाई</td>
                                <td class="mycenter">दर</td>
                                <td class="mycenter">जम्मा रु.</td>
                                <td></td>
                            </tr>';
                        $count = 1; $sn_index=0; 
                        foreach($lagat_details as $lagat_detail):
//                            print_r($lagat_detail);
        setObjectValuesFromZeroToBlank($lagat_detail);
                        $break_lagats = ''; 
                    if($lagat_detail->break_type==2)
                        {
                            $break_lagats = Napilagatanumanbreak::find_by_plan_id_sno($_GET['id'],$lagat_detail->sno,$period); 
                        
                          $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                  $task_results = Estimateadd::find_by_sql($sql);
                           if(!empty($break_lagats)):// break row starts here 
                           $task_name = Worktopic::find_by_id($lagat_detail->task_id); 
                            
                            $html .= '<tr>
                                <td>'.$count.'</td>
                                <td>'.$lagat_detail->sno.'</td>';
//                                <td class="mycenter">'.$task_name->work_name.'</td>
//                                <td></td>
                            $html .= '<td>'.$lagat_detail->main_work_name.'</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td> 
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                            $j = 1; foreach($break_lagats as $break_lagat):
                            $html .= '<tr>
                                        <td></td>';
//                                        <td></td>
                                        $html .='<td>'.$lagat_detail->sno.'.'.$break_lagat->break_no.'</td>';
//                                        <td>';
                             if($break_lagat->deduct_part==1){$html .='घटाएको भाग';}
//                             </td>
                                        $html .= '<td>'.$break_lagat->break_work_name.'</td>
                                        <td class="mycenter">'.$break_lagat->task_count.'</td>
                                        <td class="mycenter">'.$break_lagat->length.'</td>
                                        <td class="mycenter">'.$break_lagat->breadth.'</td>
                                        <td class="mycenter">'.$break_lagat->height.'</td>
                                        <td>';
                             if($break_lagat->deduct_part==1)
                                 {
                                    $html .='-'.$break_lagat->total_evaluation;
                                 }
                              else 
                              {
                                    $html .= $break_lagat->total_evaluation;
                              }
                                $html .='</td>
                                        <td></td> 
                                        <td></td>
                                        <td></td>
                                        <td></td>
                             </tr>';
                                $j++; endforeach; 
                             //sub total row in case of break starts here -->
                               $html .='<tr>
                                    <td></td>
                                    <td></td>';
//                                    <td></td>
//                                    <td></td>
                                   $html .=' <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="mycenter">जम्मा</td>
                                    <td class="mycenter">'.$lagat_detail->total_evaluation.'</td>
                                    <td></td> 
                                    <td class="mycenter">'.$lagat_detail->task_rate.'</td>
                                    <td class="mycenter">'.$lagat_detail->total_rate.'</td>
                                    <td></td>
                                </tr>';
                                // sub total row in case of break starts here -->
                             endif; // break row ends here
                        }
                             if($lagat_detail->break_type==1):// without break single row starts here
                                 
                                    $single_break = Napilagatanumanbreak::find_single_row($_GET['id'],$count,$period);
                                    setObjectValuesFromZeroToBlank($single_break);
                                    $task_name = Worktopic::find_by_id($lagat_detail->task_id);
                               $html .='<tr>
                                        <td>'.$count.'</td>
                                        <td class="mycenter">'.$lagat_detail->sno.'</td>';
//                                        <td>'.$task_name->work_name.'</td>
//                                        <td></td>
                                    $html .='<td class="mycenter">'.$lagat_detail->main_work_name.'</td>
                                        <td class="mycenter">'.$single_break->task_count.'</td>
                                        <td class="mycenter">'.$single_break->length.'</td>
                                        <td class="mycenter">'.$single_break->breadth.'</td>
                                        <td class="mycenter">'.$single_break->height.'</td>
                                        <td class="mycenter">'.$lagat_detail->total_evaluation.'</td>
                                        <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td> 
                                        <td class="mycenter">'.$lagat_detail->task_rate.'</td>
                                        <td class="mycenter">'.$lagat_detail->total_rate.'</td>
                                        <td></td>
                                </tr>';
                              endif;// without break single row ends here 
                             $count++; $sn_index++; endforeach; 
                            
                                
                        $html .='<tr>
                                    <td colspan="10" style="text-align:right">कुल जम्मा रु</td>
                                    <td>'.$profile_details->sub_total.'</td>
                                    <td></td>
                                </tr>
                          
                       </table>';
                        return $html;
    }
    
    function getNapiLetter($period)
    {
        $profile_details = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$period);
        $sql = "select * from napi_lagat_anuman where plan_id=".$_GET['id']." and period=".$period." order by sno asc";
        $lagat_details = Napilagatanuman::find_by_sql($sql);
        if(empty($lagat_details))
        {
            return false;
        }
        $sno_array = Napilagatanuman::getAllSnoByPlanId($_GET['id']);
        $nep_char_array = getPeriodArray();
        $html = '';
        
       $html .= '<table class=" table-bordered  myWidth100 myFont10">
                        
                            <tr>
                                <td class="mycenter">सि.नं.</td>
                                <td class="mycenter">इष्टिमेट न०</td>';
//                                <td class="mycenter">क्षेत्र</td>
//                                <th></td>
                          $html .='<td class="mycenter">विवरण</td>
                                <td class="mycenter">संख्या</td>
                                <td class="mycenter">लम्बाई</td>
                                <td class="mycenter">चौडाई</td>
                                <td class="mycenter">उचाई</td>
                                <td class="mycenter">परिमाण</td>
                                <td class="mycenter">इकाई</td>
                                <td class="mycenter">दर</td>
                                <td class="mycenter">जम्मा रु.</td>
                                
                            </tr>';
                        $count = 1; $sn_index=0; 
                        foreach($lagat_details as $lagat_detail):
//                            print_r($lagat_detail);
        setObjectValuesFromZeroToBlank($lagat_detail);
                        $break_lagats = ''; 
                    if($lagat_detail->break_type==2)
                        {
                            $break_lagats = Napilagatanumanbreak::find_by_plan_id_sno($_GET['id'],$lagat_detail->sno,$period); 
                        
                          $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                  $task_results = Estimateadd::find_by_sql($sql);
                           if(!empty($break_lagats)):// break row starts here 
                           $task_name = Worktopic::find_by_id($lagat_detail->task_id); 
                            
                            $html .= '<tr>
                                <td>'.convertedcit($count).'</td>
                                <td>'.convertedcit($lagat_detail->sno).'</td>';
//                                <td class="mycenter">'.$task_name->work_name.'</td>
//                                <td></td>
                            $html .= '<td>'.$lagat_detail->main_work_name.'</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td> 
                                <td></td>
                                <td></td>
                                
                            </tr>';
                            $j = 1; foreach($break_lagats as $break_lagat):
                            $html .= '<tr>
                                        <td></td>';
//                                        <td></td>
                                        $html .='<td>'.convertedcit($lagat_detail->sno).'.'.convertedcit($break_lagat->break_no).'</td>';
//                                        <td>';
                             if($break_lagat->deduct_part==1){$html .='घटाएको भाग';}
//                             </td>
                                        $html .= '<td>'.$break_lagat->break_work_name.'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->task_count).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->length).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->breadth).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->height).'</td>
                                        <td>';
                             if($break_lagat->deduct_part==1)
                                 {
                                    $html .='-'.convertedcit($break_lagat->total_evaluation);
                                 }
                              else 
                              {
                                    $html .= convertedcit($break_lagat->total_evaluation);
                              }
                                $html .='</td>
                                        <td></td> 
                                        <td></td>
                                        <td></td>
                                        
                             </tr>';
                                $j++; endforeach; 
                             //sub total row in case of break starts here -->
                               $html .='<tr>
                                    <td></td>
                                    <td></td>';
//                                    <td></td>
//                                    <td></td>
                                   $html .=' <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="mycenter">जम्मा</td>
                                    <td class="mycenter">'.convertedcit($lagat_detail->total_evaluation).'</td>
                                    <td></td> 
                                    <td class="mycenter">'.convertedcit($lagat_detail->task_rate).'</td>
                                    <td class="mycenter">'.convertedcit($lagat_detail->total_rate).'</td>
                                    
                                </tr>';
                                // sub total row in case of break starts here -->
                             endif; // break row ends here
                        }
                             if($lagat_detail->break_type==1):// without break single row starts here
                                 
                                    $single_break = Napilagatanumanbreak::find_single_row($_GET['id'],$count,$period);
                                    setObjectValuesFromZeroToBlank($single_break);
                                    $task_name = Worktopic::find_by_id($lagat_detail->task_id);
                               $html .='<tr>
                                        <td>'.convertedcit($count).'</td>
                                        <td class="mycenter">'.convertedcit($lagat_detail->sno).'</td>';
//                                        <td>'.$task_name->work_name.'</td>
//                                        <td></td>
                                    $html .='<td class="mycenter">'.$lagat_detail->main_work_name.'</td>
                                        <td class="mycenter">'.convertedcit($single_break->task_count).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->length).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->breadth).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->height).'</td>
                                        <td class="mycenter">'.convertedcit($lagat_detail->total_evaluation).'</td>
                                        <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td> 
                                        <td class="mycenter">'.convertedcit($lagat_detail->task_rate).'</td>
                                        <td class="mycenter">'.convertedcit($lagat_detail->total_rate).'</td>
                                        
                                </tr>';
                              endif;// without break single row ends here 
                             $count++; $sn_index++; endforeach; 
                            
                                
                        $html .='<tr>
                                    <td colspan="10" style="text-align:right">कुल जम्मा रु</td>
                                    <td>'.convertedcit($profile_details->sub_total).'</td>
                                   
                                </tr>
                          
                       </table>';
                        return $html;
    }
    
   function getNapiLetterBackup($period)
    {
        $profile_details = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$period);
        $sql = "select * from napi_lagat_anuman where plan_id=".$_GET['id']." and period=".$period." order by sno asc";
        $lagat_details = Napilagatanuman::find_by_sql($sql);
        if(empty($lagat_details))
        {
            return false;
        }
        $sno_array = Napilagatanuman::getAllSnoByPlanId($_GET['id']);
        $nep_char_array = getPeriodArray();
        $html = '';
        
        $html .= '<table class=" table-bordered myWidth100">
                    <tr>
                      <td rowspan="2" class="mycenter">सि.नं</td>
                      <td rowspan="2" class="mycenter">कामको विवरण</td>
                      <td rowspan="2" class="mycenter">इकाई</td>
                        <td rowspan="2" class="mycenter">संख्या</td>
                      <td  colspan="3" class="mycenter">कामको परिमाण</td>
                      <td rowspan="2"  class="mycenter">जम्मा नापी</td>

                      <td rowspan="2" class="mycenter">कैफियत</td>
                    </tr>
                    <tr>
                      <td class="mycenter">लम्बाई</td>
                      <td class="mycenter">चौडाई</td>
                      <td class="mycenter">उचाई</td>
                      </tr>';
//        return $html;
                        $count = 1; $sn_index=0; foreach($lagat_details as $lagat_detail): 
                        $break_lagats = ''; 
                            if($lagat_detail->break_type==2)
                                {
                                    $break_lagats = Napilagatanumanbreak::find_by_plan_id_sno($_GET['id'],$lagat_detail->sno,$period); 
                                }
                          $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                  $task_results = Estimateadd::find_by_sql($sql);
                           if(!empty($break_lagats)):// break row starts here 
                           $task_name = Worktopic::find_by_id($lagat_detail->task_id); 
                            
                            $html .= '<tr>
                                        <td class="mycenter">'.convertedcit($count).'</td>
                                        <td>'.$task_name->work_name.' '.$lagat_detail->main_work_name.'</td>
                                        <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td>
                                        <td class="mycenter"></td>
                                        <td class="mycenter"></td>
                                        <td class="mycenter"></td>
                                        <td class="mycenter"></td>
                                        <td class="mycenter"></td>
                                        <td class="mycenter"></td>
                                      </tr>';
                            $j = 1; foreach($break_lagats as $break_lagat):
                            $html .= '<tr>
                                        <td></td>
                                       <td>'.convertedcit($break_lagat->break_no).') '.$break_lagat->break_work_name;
                             if($break_lagat->deduct_part==1){$html .=' (घटाएको भाग)';}
                             $html .= '</td>
                                        <td></td>
                                        <td class="mycenter">'.convertedcit($break_lagat->task_count).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->length).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->breadth).'</td>
                                        <td class="mycenter">'.convertedcit($break_lagat->height).'</td>
                                        <td class="mycenter">';
                             if($break_lagat->deduct_part==1)
                                 {
                                    $html .='-'.convertedcit($break_lagat->total_evaluation);
                                 }
                              else 
                              {
                                    $html .= convertedcit($break_lagat->total_evaluation);
                              }
                                $html .='</td>
                                        <td></td> 
                                        
                             </tr>';
                                $j++; endforeach; 
                             //sub total row in case of break starts here -->
                               $html .='<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   <td>जम्मा</td>
                                    <td class="mycenter">'.convertedcit($lagat_detail->total_evaluation).'</td>
                                    <td></td> 
                                   
                                </tr>';
                                // sub total row in case of break starts here -->
                             endif; // break row ends here
                             if(empty($break_lagats)):// without break single row starts here
                                    $single_break = Napilagatanumanbreak::find_single_row($_GET['id'],$lagat_detail->sno,$period);
//                                    print_r($single_break); exit;
                                    $task_name = Worktopic::find_by_id($lagat_detail->task_id);
                               $html .='<tr>
                                        <td class="mycenter">'.convertedcit($count).'</td>
                                        <td>'.$lagat_detail->main_work_name.'</td>
                                        <td class="mycenter">'.Units::getName($lagat_detail->unit_id).'</td>
                                         <td class="mycenter">'.convertedcit($single_break->task_count).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->length).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->breadth).'</td>
                                        <td class="mycenter">'.convertedcit($single_break->height).'</td>
                                        <td class="mycenter">'.convertedcit($lagat_detail->total_evaluation).'</td>
                                        <td></td> 
                                        
                                </tr>';
                              endif;// without break single row ends here 
                             $count++; $sn_index++; endforeach; 
                            
                                
                        $html .='</table>';
                        return $html;
    }
function getNapiLetterDashHtml($max_period)
{
    $total_count = $max_period;
    $html = '';
    $last_flag = '';
        for($i=1;$i<=$total_count;$i++)
        {
                $html .= '<a href="print_estimate_naapi.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>'.getPeriodText($i).'  हेर्नुहोस</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
        }
    
    
    return $html;
}
?>