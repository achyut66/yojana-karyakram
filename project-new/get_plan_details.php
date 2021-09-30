<?php 
    require_once 'includes/initialize.php';
    $is_mobile=0;
    if(isset($_GET['is_mobile']))
            {
                $is_mobile=$_GET['is_mobile'];
            }
    if($is_mobile==1)
    	{
                	$key=$_GET['key'];
                	if($key!="2df176461ec1f62d769e4fe09a9ffc86")
                	{
                	 $res=array();
                	 $res['error']=TRUE;
                	 echo json_encode($res);exit;
                	}
    	}
     if(isset($_GET['page']))
    {
        $ward = $_GET['page'];
    }
    
    if($ward!= 0)
    {
        $sql = "select * from plan_details1 where ward_no={$ward}";
    }
    else
    {
        $sql = "select * from plan_details1 where topic_area_investment_id=2";
    }
    $plan_details = PlanDetails1::find_by_sql($sql);
    
    if(!empty($plan_details))
    {
        $res = [];
        $i= 0; 
        foreach($plan_details as $data)
        {
            if($data->type==0){
                $name = "योजना";
            }else{
                $name = "कार्यक्रम";
            }
            $data3=Costumerassociationdetails::find_by_post_plan_id(1,$data->id);
            $contractor_details = Contract_total_investment::find_by_plan_id($data->id);
            if(!empty($contractor_details))
            {
                 $contractor_name = Contractordetails::find_by_id($contractor_details->contractor_id);
            }
            $profitable                     = Profitablefamilydetails::find_by_plan_id($data->id);
            $more_details                   = Moreplandetails::find_by_plan_id($data->id);
            $customer                       = Costumerassociationdetails0::find_by_plan_id($data->id);
            $res[$i]['program_name']        = $data->program_name;
            $res[$i]['amount']              = $data->investment_amount;
            $res[$i]['accept_date']         = $more_details->miti;
            $res[$i]['start_date']          = $more_details->yojana_start_date;
            $res[$i]['end_date']            = $more_details->yojana_sakine_date;
            $res[$i]['pariwar_population']  = $profitable->pariwar_population;
            $res[$i]['customer_name']       = $data3->name;
            $res[$i]['customer_phone']      = $data3->mobile_no;
            $res[$i]['ward_no']             = $data->ward_no;
            $res[$i]['contractor_name']     = $contractor_name->contractor_name;
            $res[$i]['contractor_phone']    = $contractor_name ->contractor_contact;
            $res[$i]['project_type'] = $name;
            $res[$i]['error']               = FALSE;
            $i++;
        }
        echo json_encode($res);exit;
    }
    else
    {
        $res = [];
        $res[]['error'] = TRUE;
        echo json_encode($res);exit;
    }
    
?>