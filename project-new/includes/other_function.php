    <?php
    function get_katti_from_katti_wiwaran($katti_id,$ward,$topic_id,$date_from,$date_to)
    {
        global $database;
         if(empty($ward) && empty($date_from) && empty($date_to))
        {
             $katti_sql = "select sum(katti_amount) from  katti_details as a left join plan_details1 as b on a.plan_id=b.id where a.katti_id=$katti_id and b.topic_area_id=".$topic_id;
             $result_katti =$database->query($katti_sql);
             $row= $database->fetch_array($result_katti);
             $katti_amount = array_shift($row);
        }
         if(!empty($ward) && empty($date_from) && empty($date_to))
        {
             $katti_sql = "select sum(katti_amount) from  katti_details as a left join plan_details1 as b on a.plan_id=b.id where a.katti_id=$katti_id and b.ward_no=$ward and b.topic_area_id=".$topic_id;
             $result_katti =$database->query($katti_sql);
             $row= $database->fetch_array($result_katti);
             $katti_amount = array_shift($row);
        }
        if(!empty($ward) && !empty($date_from) && !empty($date_to))
        {
             $katti_sql = "select sum(katti_amount) from  katti_details as a left join plan_details1 as b on a.plan_id=b.id where a.katti_id=$katti_id and b.ward_no=$ward and b.topic_area_id=$topic_id and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";;
             $result_katti =$database->query($katti_sql);
             $row= $database->fetch_array($result_katti);
             $katti_amount = array_shift($row);
        }
        if(empty($ward) && !empty($date_from) && !empty($date_to))
        {
             $katti_sql = "select sum(katti_amount) from  katti_details as a left join plan_details1 as b on a.plan_id=b.id where a.katti_id=$katti_id and b.topic_area_id=$topic_id and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";;
             $result_katti =$database->query($katti_sql);
             $row = $database->fetch_array($result_katti);
             $katti_amount = array_shift($row);
        }
        return $katti_amount;
    }
    function get_contingency_marmat_by_topic_ward_date($ward,$topic_id,$date_from,$date_to)
    {
        global $database;
        if(empty($ward) && empty($date_from) && empty($date_to))
        {
            $final_sql_con = "select sum(final_contengency_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and  b.topic_area_id=".$topic_id;
            $final_sql_marmat = "select sum(final_renovate_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=".$topic_id;
            $result_set_con = $database->query($final_sql_con);
            $result_set_marmat = $database->query($final_sql_marmat);
            $row_con = $database->fetch_array($result_set_con);
            $row_marmat = $database->fetch_array($result_set_marmat);
            if(!empty($row_con))
            {
                $contingency_final = array_shift($row_con);
                $marmat_final = array_shift($row_marmat);
            }
            else
            {
                $analysis_sql_con = "select sum(contengency_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=".$topic_id;
                $analysis_sql_marmat = "select sum(renovate_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=".$topic_id;
                $analysis_result_set_con = $database->query($analysis_sql_con);
                $analysis_result_set_marmat = $database->query($analysis_sql_marmat);
                $analysis_row_con = $database->fetch_array($analysis_result_set_con);
                $analyis_row_marmat = $database->fetch_array($analysis_result_set_marmat);
                $contingency_analysis = array_shift($analysis_row_con);
                $marmat_analysis = array_shift($analyis_row_marmat);
            }
            $total_contingecny = $contingency_final+$contingency_analysis;
            $total_marmat = $marmat_final + $marmat_analysis;
        }
        if(!empty($ward) && empty($date_from) && empty($date_to))
        {
            $final_sql_con = "select sum(final_contengency_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and b.ward_no=$ward";
            $final_sql_marmat = "select sum(final_renovate_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where  a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and b.ward_no=$ward";
            $result_set_con = $database->query($final_sql_con);
            $result_set_marmat = $database->query($final_sql_marmat);
            $row_con = $database->fetch_array($result_set_con);
            $row_marmat = $database->fetch_array($result_set_marmat);
            if(!empty($row_con))
            {
                $contingency_final = array_shift($row_con);
                $marmat_analysis = array_shift($row_marmat);
            }
            else
            {
                $analysis_sql_con = "select sum(contengency_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id and b.ward_no=$ward";
                $analysis_sql_marmat = "select sum(renovate_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id wherea.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id and b.ward_no=$ward";
                $analysis_result_set_con = $database->query($analysis_sql_con);
                $analysis_result_set_marmat = $database->query($analysis_sql_marmat);
                $analysis_row_con = $database->fetch_array($analysis_result_set_con);
                $analyis_row_marmat = $database->fetch_array($analysis_result_set_marmat);
                $contingency_analysis = array_shift($analysis_row_con);
                $marmat_analysis = array_shift($analyis_row_marmat);
            }
            $total_contingecny = $contingency_final+$contingency_analysis;
            $total_marmat = $marmat_final + $marmat_analysis;
        }
        if(!empty($ward) && !empty($date_from) && !empty($date_to))
        {
            $final_sql_con = "select sum(final_contengency_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and b.ward_no=$ward and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
            $final_sql_marmat = "select sum(final_renovate_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and b.ward_no=$ward and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
            $result_set_con = $database->query($final_sql_con);
            $result_set_marmat = $database->query($final_sql_marmat);
            $row_con = $database->fetch_array($result_set_con);
            $row_marmat = $database->fetch_array($result_set_marmat);
            if(!empty($row_con))
            {
                $contingency_final = array_shift($row_con);
                $marmat_final = array_shift($row_marmat);
            }
            else
            {
                $analysis_sql_con = "select sum(contengency_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id and b.ward_no=$ward and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
                $analysis_sql_marmat = "select sum(renovate_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id and b.ward_no=$ward and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
                $analysis_result_set_con = $database->query($analysis_sql_con);
                $analysis_result_set_marmat = $database->query($analysis_sql_marmat);
                $analysis_row_con = $database->fetch_array($analysis_result_set_con);
                $analyis_row_marmat = $database->fetch_array($analysis_result_set_marmat);
                $contingency_analysis = array_shift($analysis_row_con);
                $marmat_analysis = array_shift($analyis_row_marmat);
            }
            $total_contingecny = $contingency_final+$contingency_analysis;
            $total_marmat = $marmat_final + $marmat_analysis;
        }
        if(empty($ward) && !empty($date_from) && !empty($date_to))
        {
            $final_sql_con = "select sum(final_contengency_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and  a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
            $final_sql_marmat = "select sum(final_renovate_amount) from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM analysis_based_withdraw) and b.topic_area_id=$topic_id and  a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
            $result_set_con = $database->query($final_sql_con);
            $result_set_marmat = $database->query($final_sql_marmat);
            $row_con = $database->fetch_array($result_set_con);
            $row_marmat = $database->fetch_array($result_set_marmat);
            if(!empty($row_con))
            {
                $contingency_final = array_shift($row_con);
                $marmat_final = array_shift($row_marmat);
            }
            else
            {
                $analysis_sql_con = "select sum(contengency_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id  and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
                $analysis_sql_marmat = "select sum(renovate_amount) from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id = b.id where a.plan_id NOT IN (SELECT plan_id FROM plan_amount_withdraw_details) and b.topic_area_id=$topic_id  and a.created_date_english>='".$date_from."' and a.created_date_english<='".$date_to."'";
                $analysis_result_set_con = $database->query($analysis_sql_con);
                $analysis_result_set_marmat = $database->query($analysis_sql_marmat);
                $analysis_row_con = $database->fetch_array($analysis_result_set_con);
                $analyis_row_marmat = $database->fetch_array($analysis_result_set_marmat);
                $contingency_analysis = array_shift($analysis_row_con);
                $marmat_analysis = array_shift($analyis_row_marmat);
            }
            $total_contingecny = $contingency_final+$contingency_analysis;
            $total_marmat = $marmat_final + $marmat_analysis;
        }
        $result_array =array("contingency"=>round($total_contingecny),
                               "marmat"=>round($total_marmat));
        return $result_array;
    }
    function get_contingency_and_marmat_samhar_for_all_yojana($plan_id)
    {
        $final = Planamountwithdrawdetails::find_by_plan_id($plan_id);
       if(!empty($final))
        {
            $contingency = $final->final_contengency_amount;
            $maramt = $final->final_renovate_amount;
        }
        else
        {
            $contingency = Analysisbasedwithdraw::sum_katti_by_name('contengency_amount',$plan_id);
            $maramt = Analysisbasedwithdraw::sum_katti_by_name('renovate_amount',$plan_id);  
        }
        $result_array =array("contingency"=>round($contingency),
                               "marmat"=>round($maramt));
        return $result_array;

    }
    function get_return_url($plan_id)
    {
            $result = Plantotalinvestment::find_by_plan_id($plan_id);
            if(!empty($result))
            {
                 $link = "letters_select.php";
            }
            else
            {
                 $link = "amanat_letter_select.php";
            }
            return $link;
    }
    function get_chaumasik_expenditure_program_array($clause,$topic_area_id,$type,$ward,$from,$to)
    {
            global $database;
            if(empty($ward))
            {
             $final_sql = "select distinct(program_id) from program_payment_final as a left join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and a.paid_date_english>='".$from."' and a.paid_date_english<='".$to."'";

            }
            else
            {
                $final_sql = "select distinct(program_id) from program_payment_final as a left join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and a.paid_date_english>='".$from."' and a.paid_date_english<='".$to."'";

            }

             $result=$database->query($final_sql);
            $final_array= array();
            while($data=  mysqli_fetch_object($result))
            {
                array_push($final_array, $data->id);
            }
            return $array;
    }
    function get_contract_paln_array_for_chaumasik_report($clause,$topic_area_id,$type,$ward,$from,$to)
    {
            global $database;
            if(empty($ward))
            {
                 $final_sql = "select * from contract_amount_withdraw_details as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";

            }
            else
            {
                 $final_sql = "select * from contract_amount_withdraw_details as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and  b.ward_no=".$ward." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";

            }
    //        echo $final_sql;exit;
            $result=$database->query($final_sql);
            $final_array= array();
            while($data=  mysqli_fetch_object($result))
            {
                array_push($final_array, $data->id);
            }
            $analysis_array=array();
            if(empty($ward))
            {
                 $analysis_sql= "select * from contract_analysis_based_withdraw as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            else
            {
                 $analysis_sql= "select * from contract_analysis_based_withdraw as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            $analysis_result= $database->query($analysis_sql);
            while($data= mysqli_fetch_object($analysis_result))
            {
                array_push($analysis_array,$data->id);
            }

            $array = array("final_array"=>$final_array,"analysis_array"=>$analysis_array);
            return $array;
    }
    function get_upabhokta_paln_array_for_chaumasik_report($clause,$topic_area_id,$type,$ward,$from,$to)
    {
            global $database;
            if(empty($ward))
            {
                $final_sql = "select * from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            else
            {
                $final_sql = "select * from plan_amount_withdraw_details as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            $result=$database->query($final_sql);
            $final_array= array();
            while($data=  mysqli_fetch_object($result))
            {
                array_push($final_array, $data->id);
            }
            $analysis_array=array();
            if(empty($ward))
            {
                $analysis_sql= "select * from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            else
            {
                $analysis_sql= "select * from analysis_based_withdraw as a left join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            $analysis_result= $database->query($analysis_sql);
            while($data= mysqli_fetch_object($analysis_result))
            {
                array_push($analysis_array,$data->id);
            }

            $array = array("final_array"=>$final_array,"analysis_array"=>$analysis_array);
            return $array;
    }
    function get_amount_chaumasik_uopabhokta_samiti($clause,$topic_area_id,$type,$ward,$from,$to)
    {
           global $database;
           $array_result = get_upabhokta_paln_array_for_chaumasik_report($clause,$topic_area_id,$type,$ward,$from,$to);
           if(!empty($array_result['analysis_array']))
            {   if(empty($ward))
                {
                    $advance_sql = "select sum(advance) from plan_starting_fund as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.advance_taken_date_english >='".$from."' and a.advance_taken_date_english<='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['analysis_array']).")";
                }
                else
                {
                    $advance_sql = "select sum(advance) from plan_starting_fund as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.advance_taken_date_english >='".$from."' and a.advance_taken_date_english<='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['analysis_array']).")";
                }
                $result=$database->query($advance_sql);

                $advance_amount = mysqli_fetch_row($result);
                if(empty($advance_amount[0]))
                {
                    $advance_amount=0;
                }
                else 
                {
                    $advance_amount = array_pop($advance_amount);
                }
            }
            else
            {
                $advance_amount=0;
            }
            if(!empty($array_result['final_array']))
            {
               if(empty($ward))
               {
                   $analysis_sql = "select sum(payable_amount) from analysis_based_withdraw as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english >='".$from."' and a.created_date_english <='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['final_array']).")";
               }
               else
               {
                   $analysis_sql = "select sum(payable_amount) from analysis_based_withdraw as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english >='".$from."' and a.created_date_english <='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['final_array']).")";
               }
               $analysis_result = $database->query($analysis_sql);
               $analysis_amount  = mysqli_fetch_row($analysis_result);
               if(empty($analysis_amount[0]))
               {
                   $analysis_amount=0;
               }
               else 
               {
                   $analysis_amount = array_pop($analysis_amount);
               }

        //        echo "analysis : ".$analysis_amount; exit;
            }
            else
            {
                $analysis_amount=0;
            }
            if(empty($ward))
            {
                $final_sql = "select sum(final_payable_amount - final_bhuktani_ghati_amount) from plan_amount_withdraw_details as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            else
            {
                $final_sql = "select sum(final_payable_amount - final_bhuktani_ghati_amount) from plan_amount_withdraw_details as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
           $final_result = $database->query($final_sql);
           if(!empty($final_result))
           {
               $final_amount = array_pop(mysqli_fetch_row($final_result));
           }
           else
           {
               $final_amount = 0;
           }
           $total_amount = $advance_amount + $analysis_amount + $final_amount;
           return $total_amount;
    }

    function get_amount_chaumasik_contract($clause,$topic_area_id,$type,$ward,$from,$to)
    {
            global $database;
            $array_result = get_contract_paln_array_for_chaumasik_report($clause,$topic_area_id,$type,$ward,$from,$to);
           if(!empty($array_result['analysis_array']))
            {
                if(empty($ward))
                {
                    $advance_sql = "select sum(advance) from contract_starting_fund as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.advance_taken_date_english >='".$from."' and a.advance_taken_date_english<='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['analysis_array']).")";
                }
                else
                {
                    $advance_sql = "select sum(advance) from contract_starting_fund as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.advance_taken_date_english >='".$from."' and a.advance_taken_date_english<='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['analysis_array']).")";
                }
                $result=$database->query($advance_sql);

                $advance_amount = mysqli_fetch_row($result);
                if(empty($advance_amount[0]))
                {
                    $advance_amount=0;
                }
                else 
                {
                    $advance_amount = array_pop($advance_amount);
                }
            }
            else
            {
                $advance_amount=0;
            }
            if(!empty($array_result['final_array']))
            {
               if(empty($ward))
               {
                   $analysis_sql = "select sum(payable_amount) from contract_analysis_based_withdraw as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english >='".$from."' and a.created_date_english <='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['final_array']).")";
               }
               else
               {
                   $analysis_sql = "select sum(payable_amount) from contract_analysis_based_withdraw as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english >='".$from."' and a.created_date_english <='".$to."' and a.plan_id NOT IN (".implode(",",$array_result['final_array']).")";
               }
               $analysis_result = $database->query($analysis_sql);
               $analysis_amount  = mysqli_fetch_row($analysis_result);
               if(empty($analysis_amount[0]))
               {
                   $analysis_amount=0;
               }
               else 
               {
                   $analysis_amount = array_pop($analysis_amount);
               }

        //        echo "analysis : ".$analysis_amount; exit;
            }
            else
            {
                $analysis_amount=0;
            }
            if(empty($ward))
            {
                $final_sql = "select sum(final_payable_amount - final_disaster_management_amount) from contract_amount_withdraw_details as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
            else
            {
                $final_sql = "select sum(final_payable_amount - final_disaster_management_amount) from contract_amount_withdraw_details as a inner join plan_details1 as b on a.plan_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.created_date_english>='".$from."' and a.created_date_english<='".$to."'";
            }
           $final_result = $database->query($final_sql);
           if(!empty($final_result))
           {
               $final_amount = array_pop(mysqli_fetch_row($final_result));
           }
           else
           {
               $final_amount = 0;
           }
           $total_amount = $advance_amount + $analysis_amount + $final_amount;
           return $total_amount;
    }

    function get_chaumasik_expenditure_program($clause,$topic_area_id,$type,$ward,$from,$to)
    {
            global $database;
            $array_result = get_chaumasik_expenditure_program_array($clause,$topic_area_id,$type,$ward,$from,$to);
           if(!empty($array_result))
            {
               if(empty($ward))
               {
                $advance_sql = "select sum(payment_amount) from program_payment as a inner join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and a.paid_date_english >='".$from."' and a.paid_date_english<='".$to."' and a.program_id NOT IN (".implode(",",$array_result).")";
               }
               else
               {
                   $advance_sql = "select sum(payment_amount) from program_payment as a inner join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.paid_date_english >='".$from."' and a.paid_date_english<='".$to."' and a.program_id NOT IN (".implode(",",$array_result).")";
                }
                $result=$database->query($advance_sql);

                $advance_amount = mysqli_fetch_row($result);
                if(empty($advance_amount[0]))
                {
                    $advance_amount=0;
                }
                else 
                {
                    $advance_amount = array_pop($advance_amount);
                }
            }
            else
            {
                $advance_amount=0;
            }
            if(empty($ward))
            {
                $final_sql = "select sum(net_total_amount) from program_payment_final as a inner join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and a.paid_date_english>='".$from."' and a.paid_date_english<='".$to."'";
            }
            else
            {
                $final_sql = "select sum(net_total_amount) from program_payment_final as a inner join plan_details1 as b on a.program_id=b.id where b.".$clause."=".$topic_area_id." and b.ward_no=".$ward." and  a.paid_date_english>='".$from."' and a.paid_date_english<='".$to."'";
            }
            $final_result = $database->query($final_sql);
            if(!empty($final_result))
            {
                $final_amount = array_pop(mysqli_fetch_row($final_result));
            }
            else
            {
                $final_amount = 0;
            }
            $total_amount = $advance_amount  + $final_amount;
           return $total_amount;
    }
    function get_chaumasik_date($fiscal,$first,$last)
    {
        $first_array = getStartEndDates($fiscal,$first);
        $last_array = getStartEndDates($fiscal,$last);
    //    print_r($last_array);exit;
        $final_array = array(

            "1"=>$first_array[0],
            "2" =>$last_array[1]
        );

        return $final_array;
    }