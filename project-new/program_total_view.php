<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$program_id = $_GET['id'];
$program_details = Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
$ekmusta_exp=  Ekmustabudget::find_by_plan_id($program_id);

if(empty($amount))
{   
    if(!empty($ekmusta_exp))
    {
        $remaining_amount=$program_details->investment_amount - $ekmusta_exp->total_expenditure;
    }
    else
    {
         $remaining_amount=$program_details->investment_amount ;
    }
    
}
else
{
    $remaining_amount=($program_details->investment_amount)-($amount);
}


$program_selected_details = Programmoredetails::find_by_program_id($_GET['id']);
?>
<?php include("menuincludes/header.php"); ?>
<title>कार्यक्रम विवरण :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम संचालन विवरण | <a href="report.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
               <h2><?php echo $program_details->program_name;?> :: <?="विनियोजित बजेट रु ".convertedcit(placeholder($program_details->investment_amount))." / कार्यक्रमको बाँकी रकम::रु".convertedcit(placeholder($remaining_amount))?></h2>         
       <?php if(!empty($program_selected_details)):?>
                                    <?php foreach($program_selected_details as $program_more_details):
                                            if(!empty($program_more_details->worker_id))
                                                   {
                                                   $worker= Workerdetails::find_by_id($program_more_details->worker_id);
                                                   //print_r($worker);exit;
                                                   }
                                            $program_payment = Programpayment::find_by_program_id_and_sn($program_id,$program_more_details->sn);
                                            $program_payment_final = Programpaymentfinal::find_by_program_id_and_sn($program_id,$program_more_details->sn);
                                            if(!empty($program_more_details->enlist_id))
                                                {
                                                 $enlist= Enlist::find_by_id($program_more_details->enlist_id);
                                                }
                                            if ($program_more_details->type_id == '0')
                                                {
                                                $organizer = "फर्म/कम्पनी";

                                                } 
                                            elseif ($program_more_details->type_id == '1') 
                                                {
                                                $organizer = "कर्मचारी";
                                                } 
                                            elseif ($program_more_details->type_id == '2') 
                                                {
                                                $organizer = "संस्था";
                                                }
                                            elseif ($program_more_details->type_id =='3') 
                                            {
                                                $organizer ="पदाधिकारी";
                                            }
                                            else
                                            {
                                                $organizer ="अन्य समूह";
                                            }    
                                             ?>
                                                        <h2 class="header1">
                                                            <?php 

                                                             echo Enlist::getName1($program_more_details->enlist_id)." द्वारा लागिएको";

                                                            ?>
                                                        </h2>
                                                        <div style="display: none" class="userprofiletable">
                                                          
                                                            
                                                         <?php if(!empty($program_more_details)){?>
                                                             <h3>कार्यक्रम संचालन विवरण: </h3>
                                                             <div class="inputWrap100">
                                                             	<div class="inputWrap33 inputWrapLeft">
                                                                	<div class="titleInput">कार्यादेस न <span class="underline"><?php echo convertedcit(placeholder($program_more_details->sn)); ?></span></div>
                                                                    <div class="titleInput">कार्यादेश दिने निर्णय भएको मिति : <span class="underline"><?php echo convertedcit($program_more_details->work_order_date); ?></span></div>
                                                                    <div class="titleInput">कार्यादेश दिईएको रकम रु : <span class="underline"><?php echo convertedcit(placeholder($program_more_details->work_order_budget)); ?></span></div>
                                                                    <div class="titleInput">कार्यक्रम शुरु हुने मिति : <span class="underline"><?php echo convertedcit($program_more_details->start_date); ?></span></div>
                                                                    <div class="titleInput">कार्यक्रम सम्पन्न हुने मिति : <span class="underline"><?php echo convertedcit($program_more_details->completion_date); ?></span></div>
                                                                </div><!-- input wrap 33 ends  -->
                                                                <div class="inputWrap33 inputWrapLeft">
                                                                	<div class="titleInput">कार्यक्रम संचालन हुने स्थान : <span class="underline"><?php echo convertedcit($program_more_details->venue); ?></span></div>
                                                                    <div class="titleInput">कार्यक्रमको  संचालन गर्ने : 
                                                                        <span class="underline"><?php echo $organizer; ?></span></div>
                                                                    <div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                </div><!-- input wrap 33 ends  -->
                                                                <div class="inputWrap33 inputWrapLeft">
                                                                	<div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                    <div class="titleInput"></div>
                                                                </div><!-- input wrap 33 ends  -->
                                                             	<div class="myspacer"></div>
                                                             </div><!-- input wrap 100 ends -->
                                                             <table class="table table-bordered">
                                                                    
                                                                    
                                                                    <tr>                               
                                                                    <th> नाम</th>
                                                                    <td><?php echo $enlist->name0.$enlist->name1.$enlist->name2.$enlist->name3.$enlist->name4; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                     <th>ठेगाना </th>
                                                                     <td><?php echo $enlist->address0.$enlist->address1.$enlist->address2.$enlist->address3.$enlist->address4;?></td>
                                                                    </tr>
                                                                    <tr>
                                                                     <th>सम्पर्क नं</th>
                                                                     <td><?php echo $enlist->number0.$enlist->number1.$enlist->number2.$enlist->number3.$enlist->number4;?></td>
                                                                    </tr>
                                                             <?php if($program_more_details->type_id == '1'):?>      
                                                                    <tr>
                                                                    <th>पद</th>
                                                                    <td><?php echo $enlist->post1; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                     <th>कार्यरत शाखा</th>
                                                                     <td><?php echo $enlist->branch1; ?></td>
                                                                    </tr>
                                                           <?php endif; ?>
                                                                <?php if(!empty($program_more_details->worker_id)) : ?>
                                                                    <tr>
                                                                    <th><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</th>
                                                                    <td><?= $worker->authority_name;   ?></td>

                                                                  </tr>
                                                                  <tr>
                                                                    <th>पद</th>
                                                                   <td><?= $worker->post_name ?></td>
                                                                  </tr>

                                                                  <tr>
                                                                    <th>संझौता मिती</th>
                                                                    <td><?= convertedcit($program_more_details->samjhauta_miti) ?></td>
                                                                  </tr>
                                                                  
                                                          <?php endif; ?>   
                                                              </table>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th colspan="4" style="text-align: center;">कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण</th>
                                                                    </tr>
                                                                    <tr>   
                                                                        <th colspan="4" style="text-align: center;">लाभान्वित जनसंख्या</th>
                                                                    </tr>
                                                                    <tr>

                                                                       <th>घरपरिबार संख्या</th>
                                                                        <th>महिला</th>
                                                                        <th>पुरुष</th>
                                                                        <th>जम्मा</th>
                                                                    </tr>
                                                                    <tr>

                                                                        <td><?php echo convertedcit($program_more_details->total_family_members); ?></td>
                                                                        <td><?php echo convertedcit($program_more_details->female); ?></td>
                                                                        <td><?php echo convertedcit($program_more_details->male); ?></td>
                                                                        <td><?php echo convertedcit($program_more_details->total_members); ?></td>
                                                                    </tr>
                                                                </table>

                                                          <?php } 
                                                   else { ?>
                                                             
                                                       <h3>कार्यक्रम संचालन विवरण हाल्न बाकी </h3>      
                                                            
                                                   <?php } ?>
                                                          

                                                <?php if(!empty($program_payment)){ ?>
                                                                 <h3>कार्यक्रम  संचालनमामा पेश्की: </h3>
                                                                <table class="table table-bordered">

                                                                    <tr><th>पेश्की लिने मुख्य व्यक्तीको नाम</th>
                                                                        <td><?php echo $program_payment->payment_holder_name; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की लिने मुख्य व्यक्तीको बाबुको नाम</th>
                                                                        <td><?php echo $program_payment->payment_holder_father_name; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की लिने मुख्य व्यक्तीको  बाजेको नाम</th>
                                                                        <td><?php echo $program_payment->payment_holder_grandfather_name; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की रकम</th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment->payment_amount)); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की दिएको मिती</th>
                                                                        <td><?php echo convertedcit($program_payment->paid_date); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की फर्छ्यौट गर्नु पर्ने मिति</th>
                                                                        <td><?php echo convertedcit($program_payment->payment_flow_date); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की दिनु पर्ने कारण</th>
                                                                        <td><?php echo $program_payment->payment_reason; ?></td>
                                                                    </tr>
                                                                </table>
                                                              <?php } 
                                                   else { ?>
                                                            <h3>कार्यक्रम  संचालनमामा पेश्की लागिएको छैन: </h3>   
                                                  <?php  }?>
                                                     


                                                           

                                                <?php if(!empty($program_payment_final)){ ?>
                                                             <h3>अन्तिम भुक्तानी : </h3>
                                                                <table class="table table-bordered">


                                                                    <tr>
                                                                        <th>भुक्तानी दिएको मिती</th>
                                                                        <td><?php echo convertedcit($program_payment_final->paid_date); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>भुक्तानी दिनु पर्ने कुल  रकम</th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment_final->total_payment_amount)); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment_final->payment_taken_amount)); ?></td>
                                                                    </tr>


                                                                    <tr>
                                                                        <th>धरौटी कट्टी रकम </th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment_final->deposit_amount)); ?></td>

                                                                    <tr>
                                                                        <th>जम्मा कट्टी रकम </th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment_final->total_amount)); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>हाल भुक्तानी लगिएको  खुद रकम</th>
                                                                        <td><?php echo convertedcit(placeholder($program_payment_final->net_total_amount)); ?></td>
                                                                    </tr>

                                                                </table>
                                                                              <?php } 
                                                   else { ?>
                                                             
                                                       <h3>अन्तिम भुक्तानी लागिएको छैन: </h3>            
                                                   <?php } ?>
                                                                         

                                                        </div>
                                 <?php endforeach; ?>             
           <?php endif; ?>
                    </div><!-- main menu ends -->
                
        </div><!-- top wrap ends -->
        <?php include("menuincludes/footer.php"); ?>
  