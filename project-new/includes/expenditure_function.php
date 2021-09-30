<?php
function get_total_expenditure_from_ekmusta_budget_topic_area_id_expenditure_type($clause,$string,$fiscal_id,$expenditure_type,$ward)
{
    if(empty($ward))
    {
        $sql="select * from plan_details1 where $clause=".$string." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
    }
    else
    {
        $sql="select * from plan_details1 where $clause=".$string." and ward_no=".$ward." and fiscal_id=".$fiscal_id." and expenditure_type=".$expenditure_type;
    }
     $result=Plandetails1::find_by_sql($sql);
      $counted_result = getOnlyRegisteredPlans($ward);
      $final_array    = $counted_result['final_count_array'];
    $total_expenditure=0;
     foreach($result as $data)
     {
             if($data->type==0)
                        {   
                                $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                    if(empty($contract_result))
                                                    {
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount    = Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount      = $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                                {
                                                                    $payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }  
                                                                 $contingency_expenditure=  Contingencyexenditure::getTotalPayableAmount($data->id);
                                                                 $net_payable_amount=$contingency_expenditure + $payable_amount;
                                                    }
                                 }
                        }
                        else
                        {
                            $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $net_payable_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                 }

                        }
                        $total_expenditure +=$net_payable_amount;
         }
         
    
     return $total_expenditure;
}
function get_total_expenditure_in_anudan_wise_all_plans($topic_area_agreement_id,$fiscal_id,$topic,$ward)
{
    $counted_result = getOnlyRegisteredPlans($ward);
    $final_array    = $counted_result['final_count_array'];
    $exp_result=getPlanArrayForAnudanExpenditure($topic_area_agreement_id,$fiscal_id,$ward);
    $result =  $exp_result[$topic];
    $total_expenditure=0;
     foreach($result as $id)
     {
         $data=  Plandetails1::find_by_id($id);
         if($data->type==0)
                        {   
                                $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                    if(empty($contract_result))
                                                    {
                                                        $data->investment_amount = get_investment_amount($data->id);
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount    = Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount      = $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                                {
                                                                    $payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }  
                                                                 $contingency_expenditure=  Contingencyexenditure::getTotalPayableAmount($data->id);
                                                                 $net_payable_amount=$contingency_expenditure + $payable_amount;
                                                    }
                                 }
                        }
                        else
                        {
                            $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $net_payable_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                 }

                        }
                        $total_expenditure +=$net_payable_amount;
     }
     return $total_expenditure;
}