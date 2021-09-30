<?php
require_once 'includes/initialize.php';
error_reporting(1);
if(isset($_POST['submit']))
{
//    print_r($_POST['selected_plan_id']);exit;
    foreach($_POST['selected_plan_id'] as $id)
    {
                $database = new MySQLDatabase("localhost","pdmtcom_kanep","kane$$##123","pdmtcom_kanep");
                $obj = Plandetails1::find_by_id($id);
                $database = new MySQLDatabase("localhost","pdmtcom_kaneplan","kanepokhariplan123","pdmtcom_kaneplan");
                $data = new Plandetails1();
                $data->prev_id                    = $obj->id;
                unset($obj->id);
                $data->status                     = 1;
                $data->budget_id                  = $obj->budget_id;
                $data->fiscal_id                  = $obj->fiscal_id;
                $data->type                       = $obj->type;
                $data->expenditure_type           = $obj->expenditure_type;
                $data->parishad_sno               = $obj->parishad_sno;
                $data->topic_area_id              = $obj->topic_area_id;
                $data->topic_area_type_id         = $obj->topic_area_type_id;
                $data->topic_area_type_sub_id     = $obj->topic_area_type_sub_id;
                $data->topic_area_agreement_id    = $obj->topic_area_agreement_id;
                $data->topic_area_investment_id   = $obj->topic_area_investment_id;
                $data->ward_no                    = $obj->ward_no;
                $data->program_name               = $obj->program_name;
                $data->investment_amount          = $obj->investment_amount;
                $data->first                      = $obj->first;
                $data->second                     = $obj->second;
                $data->third                      = $obj->third;
                $plan_id = $data->save();

                $database = new MySQLDatabase("localhost","root","","test");
                $obj = Plandetails1::find_by_id($id);

                if($obj->type==0)
                 {
                        $plan_investment_details= Plantotalinvestment::find_by_plan_id($id);
                        $plan_customer1      = Costumerassociationdetails0::find_by_plan_id($id);
                        $plan_customer2      = Costumerassociationdetails::find_by_plan_id($id);
                        $plan_investigation  = Investigationassociationdetails:: find_by_plan_id($id);
                        $plan_moredetails    = Moreplandetails::find_by_plan_id($id);
                        $plan_family_details = Profitablefamilydetails::find_by_plan_id($id);
                        $plan_advance        = Planstartingfund::find_by_plan_id($id);
                        $plan_analysis       = Analysisbasedwithdraw::find_by_plan_id($id);
                        $plan_addition       = Plantimeadditionaffiliation::find_by_plan_id($id);


                        $samiti_investment_details = Samitiplantotalinvestment::find_by_plan_id($id);
                        $samiti_customer1 = Samiticostumerassociationdetails0:: find_by_plan_id($id);
                        $samiti_customer2 = Samiticostumerassociationdetails:: find_by_plan_id($id);
                        $samiti_investigation = Samitiinvestigationassociationdetails::find_by_plan_id($id);
                        $samiti_more_details = Samitimoreplandetails::find_by_plan_id($id);
                        $samiti_family_details = Samitiprofitablefamilydetails::find_by_plan_id($id);
                        
                        $contract_info = Contractinfo::find_by_plan_id($id);
                        $contract_invitation_bid = Contractinvitationforbid::find_by_plan_id($id);
                        $contract_invitation_entry = Contractinvitationentry::find_by_plan_id($id);
                        $contract_bid_final = Contractbidfinal::find_by_plan_id($id);
                        $contract_entry_final = Contractentryfinal::find_by_plan_id($id);
                        $contract_total_investment = Contract_total_investment::find_by_plan_id($id);
                        $contract_more_details = Contractmoredetails::find_by_plan_id($id);
                        $contingency = Contingencyexenditure::find_by_plan_id($id);
                        $contract_advance = Contractstartingfund::find_by_plan_id($id);
                        $contract_analysis = Contractanalysisbasedwithdraw::find_by_plan_id($id);
                        $contract_dharauti = Contractdharautiadd::find_by_plan_ids($id);
                        $contract_firta= Contractdharautifirta::find_by_plan_id($id);
                        $contract_addition = Contracttimeadditionaffiliation::find_by_plan_id($id);
                        
                        
                       
                        if(!empty($plan_investment_details))
                        {
                                $database = new MySQLDatabase("localhost","pdmtcom_kaneplan","kanepokhariplan123","pdmtcom_kaneplan");
                                $invest = new Plantotalinvestment();
                                $invest->unit_total              =  $plan_investment_details->unit_total;
                                $invest->unit_id                 =  $plan_investment_details->unit_id;
                                $invest->agreement_gauplaika     =  $plan_investment_details->agreement_gauplaika;
                                $invest->agreement_other         =  $plan_investment_details->agreement_other;
                                $invest->costumer_agreement      =  $plan_investment_details->costumer_agreement;
                                $invest->other_agreement         =  $plan_investment_details->other_agreement;
                                $invest->bhuktani_anudan         =  $plan_investment_details->bhuktani_anudan;
                                $invest->costumer_investment     =  $plan_investment_details->costumer_investment;
                                $invest->total_investment        =  $plan_investment_details->total_investment;
                                $invest->created_date            =  $plan_investment_details->created_date;
                                $invest->plan_id                 =  $plan_id;
                                $invest->save();

                                if(!empty($plan_customer1))
                                {
                                    $customer1 = new Costumerassociationdetails0();
                                    $customer1->program_organizer_group_name     = $plan_customer1->program_organizer_group_name;
                                    $customer1->program_organizer_group_address  = $plan_customer1->program_organizer_group_address;
                                    $customer1->plan_id                          = $plan_id;
                                    $customer1->created_date                     = $plan_customer1->created_date;
                                    $customer1->save();
                                }

                                if(!empty($plan_customer2))
                                {
                                    foreach($plan_customer2 as $data)
                                    {
                                           $customer2 = new Costumerassociationdetails();
                                           $customer2->plan_id         = $plan_id;
                                           $customer2->post_id         = $data->post_id_0;
                                           $customer2->name            = $data->name;
                                           $customer2->address         = $data->address;
                                           $customer2->gender          = $data->gender;
                                           $customer2->cit_no          = $data->cit_no;
                                           $customer2->issued_district = $data->issued_district;
                                           $customer2->mobile_no       = $data->mobile_no;
                                           $customer2->created_date    = $data->created_date;
                                           $customer2->save();
                                    }
                                }

                                if(!empty($plan_investigation))
                                {
                                    foreach($plan_investigation as $data)
                                    {
                                           $public = new Investigationassociationdetails();
                                           $public->plan_id       = $plan_id;
                                           $public->post_id       = $data->post_id;
                                           $public->name          = $data->name;
                                           $public->address       = $data->address;
                                           $public->gender        = $data->gender;
                                           $public->mobile_no     = $data->mobile_no;
                                           $public->created_date  = $data->created_date;
                                           $public->save();
                                    }
                                 }
                                 if(!empty($plan_moredetails))
                                 {
                                       $more = new Moreplandetails();
                                       $more->plan_id                     = $plan_id;
                                       $more->samiti_gathan_date          = $plan_moredetails->samiti_gathan_date;
                                       $more->samiti_gathan_date_english  = $plan_moredetails->samiti_gathan_date_english ;      
                                       $more->costumer_total_population   = $plan_moredetails->costumer_total_population;
                                       $more->yojana_start_date           = $plan_moredetails->yojana_start_date;
                                       $more->yojana_start_date_english   = $plan_moredetails->yojana_start_date_english;
                                       $more->yojana_sakine_date          = $plan_moredetails->yojana_sakine_date;
                                       $more->yojana_sakine_date_english  = $plan_moredetails->yojana_sakine_date_english;
                                       $more->samjhauta_party             = $plan_moredetails->samjhauta_party;
                                       $more->post_id_3                   = $plan_moredetails->post_id_3;
                                       $more->created_date                = $plan_moredetails->created_date;
                                       $more->miti                        = $plan_moredetails->miti;
                                       $more->miti_english                = $plan_moredetails->miti_english;
                                       $more->save();
                                 }
                                 if(!empty($plan_family_details))
                                 {
                                       $family = new Profitablefamilydetails();
                                       $family->pariwar_population      =  $plan_family_details->pariwar_population;
                                       $family->female                  =  $plan_family_details->female;
                                       $family->male                    =  $plan_family_details->male;
                                       $family->total                   =  $plan_family_details->total;
                                       $family->plan_id                 =  $plan_id;
                                       $family->created_date            =  $plan_family_details->created_date;
                                       $family->save();
                                 }
                                 if(!empty($plan_advance))
                                 {
                                       $advance= new Planstartingfund();
                                       $advance->advance                     =  $plan_advance->advance;
                                       $advance->advance_taken_date          =  $plan_advance->advance_taken_date;
                                       $advance->advance_taken_date_english  =  $plan_advance->advance_taken_date_english;
                                       $advance->advance_return_date         =  $plan_advance->advance_return_date;
                                       $advance->advance_return_date_english =  $plan_advance->advance_return_date_english;
                                       $advance->advance_reason              =  $plan_advance->advance_reason;
                                       $advance->plan_id                     =  $plan_id;
                                       $advance->created_date                =  $plan_advance->created_date;
                                       $advance->save();
                                 }
                                 if(!empty($plan_analysis))
                                 {
                                     foreach($plan_analysis as $data)
                                     {
                                           $data8=new Analysisbasedwithdraw();
                                           $data8->payment_evaluation_count     = $data->payment_evaluation_count;
                                           $data8->evaluated_date               = $data->evaluated_date;
                                           $data8->evaluated_date_english       = $data->evaluated_date_english;
                                           $data8->evaluated_amount             = $data->evaluated_amount;
                                           $data8->payable_amount               = $data->payable_amount;
                                           $data8->advance_payment              = $data->advance_payment;
                                           $data8->contengency_amount           = $data->contengency_amount;
                                           $data8->renovate_amount              = $data->renovate_amount;
                                           $data8->due_amount                   = $data->due_amount;
                                           $data8->disaster_management_amount   = $data->disaster_management_amount;
                                           $data8->total_amount_deducted        = $data->total_amount_deducted;
                                           $data8->total_paid_amount            = $data->total_paid_amount;
                                           $data8->plan_id                      = $plan_id;
                                           $data8->created_date                 = $data->created_date;
                                           $data8->created_date_english         = $data->created_date_english;
                                           $data8->save();
                                     }

                                 }
                                 if(!empty($plan_addition))
                                 {
                                     foreach($plan_addition as $data)
                                     {
                                        $addition= new Plantimeadditionaffiliation();
                                        $addition->period                    = $data->period ;
                                        $addition->program_problem_reason    = $data->program_problem_reason ;
                                        $addition->letter_date               = $data->letter_date;
                                        $addition->letter_date_english       = $data->letter_date_english;
                                        $addition->decesion_date             = $data->decesion_date;
                                        $addition->decesion_date_english     = $data->decesion_date_english;
                                        $addition->extended_date             = $data->extended_date;
                                        $addition->extended_date_english     = $data->extended_date_english;
                                        $addition->plan_id                   =$plan_id;
                                        $addition->save();
                                     }
                                 }
                                 
                        }
                        
                        
                        elseif(!empty($samiti_investment_details))
                        {
                                 $database = new MySQLDatabase("localhost","pdmtcom_kaneplan","kanepokhariplan123","pdmtcom_kaneplan");
                                 
                                $invest = new Samitiplantotalinvestment();
                                $invest->unit_total              =  $samiti_investment_details->unit_total;
                                $invest->unit_id                 =  $samiti_investment_details->unit_id;
                                $invest->agreement_gauplaika     =  $samiti_investment_details->agreement_gauplaika;
                                $invest->agreement_other         =  $samiti_investment_details->agreement_other;
                                $invest->costumer_agreement      =  $samiti_investment_details->costumer_agreement;
                                $invest->other_agreement         =  $samiti_investment_details->other_agreement;
                                $invest->bhuktani_anudan         =  $samiti_investment_details->bhuktani_anudan;
                                $invest->costumer_investment     =  $samiti_investment_details->costumer_investment;
                                $invest->total_investment        =  $samiti_investment_details->total_investment;
                                $invest->created_date            =  $samiti_investment_details->created_date;
                                $invest->plan_id                 =  $plan_id;
                                $invest->save();
                                
                                if(!empty($samiti_customer1))
                             {
                                 $customer1 = new Samiticostumerassociationdetails0();
                                 $customer1->program_organizer_group_name     = $plan_customer1->program_organizer_group_name;
                                 $customer1->program_organizer_group_address  = $plan_customer1->program_organizer_group_address;
                                 $customer1->plan_id                          = $plan_id;
                                 $customer1->created_date                     = $plan_customer1->created_date;
                                 $customer1->save();
                             }

                             if(!empty($samiti_customer2))
                             {
                                 foreach($samiti_customer2 as $data)
                                 {
                                        $customer2 = new Samiticostumerassociationdetails();
                                        $customer2->plan_id         = $plan_id;
                                        $customer2->post_id         = $data->post_id_0;
                                        $customer2->name            = $data->name;
                                        $customer2->address         = $data->address;
                                        $customer2->gender          = $data->gender;
                                        $customer2->cit_no          = $data->cit_no;
                                        $customer2->issued_district = $data->issued_district;
                                        $customer2->mobile_no       = $data->mobile_no;
                                        $customer2->created_date    = $data->created_date;
                                        $customer2->save();
                                 }
                             }

                             if(!empty($samiti_investigation))
                             {
                                 foreach($samiti_investigation as $data)
                                 {
                                        $public = new Samitiinvestigationassociationdetails();
                                        $public->plan_id       = $plan_id;
                                        $public->post_id       = $data->post_id;
                                        $public->name          = $data->name;
                                        $public->address       = $data->address;
                                        $public->gender        = $data->gender;
                                        $public->mobile_no     = $data->mobile_no;
                                        $public->created_date  = $data->created_date;
                                        $public->save();
                                 }
                              }
                              if(!empty($samiti_more_details))
                              {
                                    $more = new Samitimoreplandetails();
                                    $more->plan_id                     = $plan_id;
                                    $more->samiti_gathan_date          = $samiti_more_details->samiti_gathan_date;
                                    $more->samiti_gathan_date_english  = $samiti_more_details->samiti_gathan_date_english ;      
                                    $more->costumer_total_population   = $samiti_more_details->costumer_total_population;
                                    $more->yojana_start_date           = $samiti_more_details->yojana_start_date;
                                    $more->yojana_start_date_english   = $samiti_more_details->yojana_start_date_english;
                                    $more->yojana_sakine_date          = $samiti_more_details->yojana_sakine_date;
                                    $more->yojana_sakine_date_english  = $samiti_more_details->yojana_sakine_date_english;
                                    $more->samjhauta_party             = $samiti_more_details->samjhauta_party;
                                    $more->post_id_3                   = $samiti_more_details->post_id_3;
                                    $more->created_date                = $samiti_more_details->created_date;
                                    $more->miti                        = $samiti_more_details->miti;
                                    $more->miti_english                = $samiti_more_details->miti_english;
                                    $more->save();
                              }
                              if(!empty($samiti_family_details))
                              {
                                    $family = new Samitiprofitablefamilydetails();
                                    $family->pariwar_population      =  $samiti_family_details->pariwar_population;
                                    $family->female                  =  $samiti_family_details->female;
                                    $family->male                    =  $samiti_family_details->male;
                                    $family->total                   =  $samiti_family_details->total;
                                    $family->plan_id                 =  $plan_id;
                                    $family->created_date            =  $samiti_family_details->created_date;
                                    $family->save();
                              }
                              if(!empty($plan_advance))
                              {
                                    $advance= new Planstartingfund();
                                    $advance->advance                     =  $plan_advance->advance;
                                    $advance->advance_taken_date          =  $plan_advance->advance_taken_date;
                                    $advance->advance_taken_date_english  =  $plan_advance->advance_taken_date_english;
                                    $advance->advance_return_date         =  $plan_advance->advance_return_date;
                                    $advance->advance_return_date_english =  $plan_advance->advance_return_date_english;
                                    $advance->advance_reason              =  $plan_advance->advance_reason;
                                    $advance->plan_id                     =  $plan_id;
                                    $advance->created_date                =  $plan_advance->created_date;
                                    $advance->save();
                              }
                              if(!empty($plan_analysis))
                              {
                                  foreach($plan_analysis as $data)
                                  {
                                        $data8=new Analysisbasedwithdraw();
                                        $data8->payment_evaluation_count     = $data->payment_evaluation_count;
                                        $data8->evaluated_date               = $data->evaluated_date;
                                        $data8->evaluated_date_english       = $data->evaluated_date_english;
                                        $data8->evaluated_amount             = $data->evaluated_amount;
                                        $data8->payable_amount               = $data->payable_amount;
                                        $data8->advance_payment              = $data->advance_payment;
                                        $data8->contengency_amount           = $data->contengency_amount;
                                        $data8->renovate_amount              = $data->renovate_amount;
                                        $data8->due_amount                   = $data->due_amount;
                                        $data8->disaster_management_amount   = $data->disaster_management_amount;
                                        $data8->total_amount_deducted        = $data->total_amount_deducted;
                                        $data8->total_paid_amount            = $data->total_paid_amount;
                                        $data8->plan_id                      = $plan_id;
                                        $data8->created_date                 = $data->created_date;
                                        $data8->created_date_english         = $data->created_date_english;
                                        $data8->save();
                                  }
                                      
                              }
                              if(!empty($plan_addition))
                                 {
                                     foreach($plan_addition as $data)
                                     {
                                        $addition= new Plantimeadditionaffiliation();
                                        $addition->period                    = $data->period ;
                                        $addition->program_problem_reason    = $data->program_problem_reason ;
                                        $addition->letter_date               = $data->letter_date;
                                        $addition->letter_date_english       = $data->letter_date_english;
                                        $addition->decesion_date             = $data->decesion_date;
                                        $addition->decesion_date_english     = $data->decesion_date_english;
                                        $addition->extended_date             = $data->extended_date;
                                        $addition->extended_date_english     = $data->extended_date_english;
                                        $addition->plan_id                   =$plan_id;
                                        $addition->save();
                                     }
                                 }
                        }
                        else
                        {
                             $database = new MySQLDatabase("localhost","pdmtcom_kaneplan","kanepokhariplan123","pdmtcom_kaneplan");
                                if(!empty($contract_info))
                                {
                                    $info = new Contractinfo();
                                    $info->created_date_english    =  $contract_info->created_date_english;
                                    $info->created_date            =  $contract_info->created_date;
                                    $info->contract_amount         =  $contract_info->contract_amount;
                                    $info->amount                  =  $contract_info->amount;
                                    $info->contract_type           =  $contract_info->contract_type;
                                    $info->last_entry_date         =  $contract_info->last_entry_date;
                                    $info->last_entry_date_english =  $contract_info->last_entry_date_english;
                                    $info->plan_id                 =   $plan_id;
                                    $info->save();
                                }
                                if(!empty($contract_invitation_bid))
                                {
                                    foreach($contract_invitation_bid as $data)
                                    {
                                        $bid = new Contractinvitationforbid();
                                        $bid->bid_id                  =  $data->bid_id;
                                        $bid->contractor_id           =  $data->contractor_id;
                                        $bid->contractor_address      =  $data->contractor_address;
                                        $bid->contractor_contact     =   $data->contractor_contact;
                                        $bid->document_type           =  $data->document_type;
                                        $bid->contractor_document     =  $data->contractor_document;
                                        $bid->bill_no                 =  $data->bill_no;
                                        $bid->bid_fee                 =  $data->bid_fee;
                                        $bid->contract_date           =  $data->contract_date;
                                        $bid->contract_date_english   =  $data->contract_date_english;
                                        $bid->plan_id                 =  $plan_id;
                                        $bid->save();
                                    }
                                }
                                if(!empty($contract_invitation_entry ))
                                {
                                    foreach($contract_invitation_entry as $data)
                                    {
                                        $entry = new Contractinvitationentry();
                                        $entry->bid_id                   =    $data->bid_id;
                                        $entry->contractor_id            =    $data->contractor_id;
                                        $entry->contractor_address       =    $data->contractor_address;
                                        $entry->contractor_contact       =    $data->contractor_contact;
                                        $entry->darta_miti               =    $data->darta_miti;
                                        $entry->darta_miti_english       =    $data->darta_miti_english;
                                        $entry->plan_id                  =    $plan_id;
                                        $entry->save();
                                    }
                                }
                                if(!empty($contract_bid_final))
                                {
                                    foreach($contract_bid_final as $data)
                                    {
                                        $final  =new Contractbidfinal();
                                        $final->contractor_id         = $data->contractor_id;
                                        $final->bank_name           = $data->bank_name;
                                        $final->bank_address         = $data->bank_address;
                                        $final->bank_guarentee        = $data->bank_guarentee;
                                        $final->bank_guarentee_date    = $data->bank_guarentee_date;
                                        $final->dharauti_amount     = $data->dharauti_amount;
                                        $final->details              = $data->details;
                                        $final->created_date         = $data->created_date;
                                        $final->created_date_english = $data->created_date_english;
                                        $final->plan_id             =   $plan_id;
                                        $final->save();
                                    }
                                }
                                if(!empty($contract_entry_final))
                                {
                                    foreach($contract_entry_final as $data)
                                    {
                                            $entry_final = new Contractentryfinal();
                                            
                                           $entry_final->bill_type                = $data->bill_type;
                                           $entry_final->bid_amount               = $data->bid_amount;
                                           $entry_final->total_bid_amount         = $data->total_bid_amount;
                                           $entry_final->created_date             = $data->created_date;
                                           $entry_final->created_date_english     = $data->created_date_english;
                                           $entry_final->contractor_id            = $data->contractor_id;
                                           $entry_final->approved_date            = $data->approved_date;
                                           $entry_final->approved_date_english    = $data->approved_date_english;
                                           $entry_final->status                   = $data->status;
                                           $entry_final->plan_id                  = $plan_id;
                                           $entry_final->save();
                                    }
                                }
                                if(!empty($contract_total_investment ))
                                {
                                    $contract_total = new Contract_total_investment();
                                    $contract_total->unit_total                   = $contract_total_investment->unit_total;
                                    $contract_total->unit_id                      = $contract_total_investment->unit_id;
                                    $contract_total->agreement_gaupalika          = $contract_total_investment->agreement_gaupalika;
                                    $contract_total->total_investment             = $contract_total_investment->total_investment;
                                    $contract_total->contract_total_amount        = $contract_total_investment->contract_total_amount;
                                    $contract_total->bhuktani_anudan              = $contract_total_investment->bhuktani_anudan;
                                    $contract_total->contractor_id                = $contract_total_investment->contractor_id;
                                    $contract_total->plan_id                      = $plan_id;
                                    $contract_total->save();
                                    
                                }
                                if(!empty($contract_more_details ))
                                {
                                    $more_details = new Contractmoredetails();
                                    $more_details->budget                            = $contract_more_details->budget;
                                    $more_details->work_order_date                   = $contract_more_details->work_order_date;
                                    $more_details->work_order_budget                 = $contract_more_details->work_order_budget;
                                    $more_details->start_date                        = $contract_more_details->start_date;
                                    $more_details->start_date_english                = $contract_more_details->start_date_english;
                                    $more_details->completion_date                   = $contract_more_details->completion_date;
                                    $more_details->completion_date_english           = $contract_more_details->completion_date_english;
                                    $more_details->venue                             = $contract_more_details->venue;
                                    $more_details->samjhauta_party                   = $contract_more_details->samjhauta_party;
                                    $more_details->post_id_3                         = $contract_more_details->post_id_3;
                                    $more_details->miti                              = $contract_more_details->miti;
                                    $more_details->total_family_members              = $contract_more_details->total_family_members;
                                    $more_details->female                            = $contract_more_details->female;
                                    $more_details->male                              = $contract_more_details->male;
                                    $more_details->total_members                     = $contract_more_details->total_members;
                                    $more_details->plan_id                           = $plan_id;
                                    $more_details->save();
                                }
                                
                                if(!empty($contingency ))
                                {
                                    foreach($contingency as $data)
                                    {
                                        $amount = new Contingencyexenditure();
                                        $amount->payment_evaluation_count            = $data->payment_evaluation_count;
                                        $amount->contingency_amount                  = $data->contingency_amount;
                                        $amount->taken_date                          = $data->taken_date;
                                        $amount->taken_date_english                  = $data->taken_date_english;
                                        $amount->plan_id                             = $plan_id;
                                        $amount->save();
                                    }
                                }
                                if(!empty($contract_advance))
                                {
                                    $data4 = new Contractstartingfund();
                                    $data4->advance                                  = $contract_advance->advance;
                                    $data4->advance_taken_date                       = $contract_advance->advance_taken_date;
                                    $data4->advance_taken_date_english               = $contract_advance->advance_taken_date_english;
                                    $data4->advance_return_date                      = $contract_advance->advance_return_date;
                                    $data4->advance_return_date_english              = $contract_advance->advance_return_date_english;
                                    $data4->advance_reason                           = $contract_advance->advance_reason;
                                    $data4->plan_id                                  = $plan_id;
                                    $data4->created_date                             = $contract_advance->created_date;
                                    $data4->save();
                                }
                                if(!empty($contract_analysis))
                                {
                                    foreach($contract_analysis as $data)
                                    {
                                            $data8=new Contractanalysisbasedwithdraw();
                                            $data8->payment_evaluation_count      = $data->payment_evaluation_count;
                                            $data8->evaluated_date                = $data->evaluated_date;
                                            $data8->evaluated_date_english        = $data->evaluated_date_english;
                                            $data8->evaluated_amount              = $data->evaluated_amount;
                                            $data8->payable_amount                = $data->payable_amount;
                                            $data8->advance_payment               = $data->advance_payment;
                                            $data8->renovate_amount               = $data->renovate_amount;
                                            $data8->due_amount                    = $data->due_amount;
                                            $data8->disaster_management_amount    = $data->disaster_management_amount;
                                            $data8->total_amount_deducted         = $data->total_amount_deducted;
                                            $data8->total_paid_amount             = $data->total_paid_amount;
                                            $data8->plan_id                       = $plan_id;
                                            $data8->created_date                  = $data->created_date;
                                            $data8->created_date_english          = $data->created_date_english;
                                            $data8->save();
                                    }
                                }
                                if(!empty($contract_dharauti))
                                {
                                    foreach($contract_dharauti as $data)
                                    {
                                        $data8=new Contractdharautiadd();
                                        $data8->payment_evaluation_count         = $data->payment_evaluation_count;
                                        $data8->contractor_name                  = $data->contractor_name;
                                        $data8->contractor_id                    = $data->contractor_id;
                                        $data8->dharauti_amount                  = $data->dharauti_amount;
                                        $data8->taken_date                       = $data->taken_date;
                                        $data8->taken_date_english               = $data->taken_date_english;
                                        $data8->plan_id                          = $plan_id;
                                        $data8->save();
                                    }
                                }
                                
                                 if(!empty($contract_firta))
                                {
                                    foreach($contract_firta as $data)
                                    {
                                        $data8=new Contractdharautifirta();
                                        $data8->payment_evaluation_count         = $data->payment_evaluation_count;
                                        $data8->contractor_id                    = $data->contractor_id;
                                        $data8->dharauti_return_amount           = $data->dharauti_return_amount;
                                        $data8->taken_date                       = $data->taken_date;
                                        $data8->taken_date_english               = $data->taken_date_english;
                                        $data8->plan_id                          = $plan_id;
                                        $data8->save();
                                    }
                                }
                                if(!empty($contract_addition))
                                {
                                    foreach($contract_addition as $data)
                                    {
                                        $addition = new Contracttimeadditionaffiliation();
                                        $addition->period                    = $data->period ;
                                        $addition->program_problem_reason    = $data->program_problem_reason ;
                                        $addition->letter_date               = $data->letter_date;
                                        $addition->letter_date_english       = $data->letter_date_english;
                                        $addition->decesion_date             = $data->decesion_date;
                                        $addition->decesion_date_english     = $data->decesion_date_english;
                                        $addition->extended_date             = $data->extended_date;
                                        $addition->extended_date_english     = $data->extended_date_english;
                                        $addition->plan_id                   =$plan_id;
                                        $addition->save();
                                    }
                                }
                        }
                 }
                 else
                 {
                        $program_more_details   = Programmoredetails::find_by_program_id($id);
                        $program_payment        = Programpayment::find_by_program_id2($id);
                        $program_payment_final  =Programpaymentfinal::find_by_program_id2($id);
                        $program_payment_deposit_return = Programpaymentdepositreturn::find_by_program_id($id);
                        $program_addition = Programtimeadditionaffiliation::find_by_program_id($id);
                        
                          $database = new MySQLDatabase("localhost","pdmtcom_kaneplan","kanepokhariplan123","pdmtcom_kaneplan");
                          
                          if(!empty($program_more_details))
                          {
                              foreach($program_more_details as $data)
                              {
                                    $program_more= new Programmoredetails();  
                                    
                                    $program_more->sn                      = $data->sn;
                                    $program_more->budget                  = $data->budget;
                                    $program_more->remaining_budget        = $data->remaining_budget;
                                    $program_more->work_order_date         = $data->work_order_date;
                                    $program_more->work_order_budget       = $data->work_order_budget;
                                    $program_more->start_date              = $data->start_date;
                                    $program_more->start_date_english      = $data->start_date_english;
                                    $program_more->completion_date         = $data->completion_date;
                                    $program_more->completion_date_english = $data->completion_date_english;
                                    $program_more->venue                   = $data->venue;
                                    $program_more->enlist_id               = $data->enlist_id;
                                    $program_more->type_id                 = $data->type_id;
                                    $program_more->total_family_members    = $data->total_family_members;
                                    $program_more->male                    = $data->male;
                                    $program_more->$female                 = $data->$female;
                                    $program_more->total_members           = $data->total_members; 
                                    $program_more->worker_id               = $data->worker_id;
                                    $program_more->samjhauta_miti          = $data->samjhauta_miti;
                                    $program_more->program_id              = $plan_id;       
                                    $program_more->save();
                              }
                          }
                          if(!empty($program_payment))
                          {
                              foreach($program_payment as $data)
                              {
                                  $payment = new Programpayment();
                                    $payment->sn                               =$data->sn;
                                    $payment->payment_holder_name              = $data->payment_holder_name;
                                    $payment->payment_holder_father_name       = $data->payment_holder_father_name;
                                    $payment->payment_holder_grandfather_name  = $data->payment_holder_grandfather_name;
                                    $payment->payment_amount                   = $data->payment_amount;
                                    $payment->paid_date                        = $data->paid_date;
                                    $payment->paid_date_english                = $data->paid_date_english;
                                    $payment->payment_flow_date                = $data->payment_flow_date;
                                    $payment->payment_flow_date_english        = $data->payment_flow_date_english;
                                    $payment->payment_reason                   = $data->payment_reason;
                                    $payment->program_id                       = $plan_id;
                                    $payment->enlist_id                        = $data->enlsit_id;
                                    $payment->save();
                              }
                          }
                          if(!empty($program_payment_final))
                          {
                              foreach($program_payment_final as $data)
                              {
                                  $final = new Programpaymentfinal();
                                    $final->sn                              = $data->sn;
                                    $final->program_remaining_amount        = $data->program_remaining_amount;
                                    $final->paid_date                       = $data->paid_date;
                                    $final->paid_date_english               = $data->paid_date_english;
                                    $final->total_payment_amount            = $data->total_payment_amount;
                                    $final->payment_taken_amount            = $data->payment_taken_amount;
                                    $final->congentency_amount              = $data->congentency_amount;
                                    $final->maintainance_amount             = $data->maintainance_amount;
                                    $final->deposit_amount                  = $data->deposit_amount;
                                    $final->emergency_amount                = $data->emergency_amount;
                                    $final->total_amount                    = $data->total_amount;
                                    $final->net_total_amount                = $data->net_total_amount;
                                    $final->program_id                      = $plan_id;
                                    $final->enlist_id                       = $data->enlist_id;
                                    $final->save();
                              }
                          }
                          if(!empty($program_payment_deposit_return))
                          {
                              foreach($program_payment_deposit_return as $data)
                              {
                                  $deposit = new Programpaymentdepositreturn();
                                    $deposit->period             = $data->period;
                                    $deposit->program_id         = $plan_id;
                                    $deposit->sn                 = $data->sn;
                                    $deposit->deposit_amount     = $data->deposit_amount;
                                    $deposit->enlist_id          = $data->enlist_id;
                                    $deposit->date               = $data->date;
                                    $deposit->save();
                              }
                          }
                        if(!empty($program_addition))
                        {
                            foreach($program_addition as $data)
                            {
                                $addition = new Programtimeadditionaffiliation();
                                $addition->sn= $data->sn;
                                $addition->period = $data->period;
                                $addition->program_problem_reason= $data->program_problem_reason ;
                                $addition->letter_date= $data->letter_date;
                                $addition->letter_date_english= $data->letter_date_english;
                                $addition->decesion_date= $data->decesion_date;
                                $addition->decesion_date_english= $data->decesion_date_english;
                                $addition->extended_date= $data->extended_date;
                                $addition->extended_date_english= $data->extended_date_english;
                                $addition->program_id = $plan_id;
                                $addition->save();
                            }
                        }
                 }
    }
    redirect_to("transfer_programs.php");
}