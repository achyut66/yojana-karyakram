<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
include("menuincludes/header1.php"); ?>
<?php
$plan_type="";
$topic_area_id=$_GET['topic_area_id'];
$fiscal_id=$_GET['fiscal_id'];
$ward = $_GET['ward_no'];
$type="";
$total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
$final_array= array();
$total_amount_array=array();
$total_investment_amount_array=array();
$total_remaining_amount_array=array();
$topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,1,$ward);


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
             <table class="table table-bordered table-responsive mytable"> 
            <strong> <span  style="text-align:left;"> <?php if(!empty($_GET['ward_no'])){echo "वार्ड नं ".convertedcit($_GET['ward_no'])." को ". Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']) ;}?>का कार्यक्रमहरु हेर्नुहोस </span></strong><br>
                  <tr>
                                                <th>सिनं</th>
                                                <th>कार्यक्रमको नाम</th>
                                                <th>वडा नं</th>
                                                <th>अनुदानको किसिम</th>
                                                 <th>कार्यक्रमको विनियोजित बजेट</th>
                                                <th>कार्यक्रमको खर्च भएको रकम</th>
                                                <th>कार्यक्रमको बाकी  रकम</th>
                                                                    
                                              </tr>
    
           <?php foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                                  
                          
                            
                          
                          
                          <tr>            
                               <td colspan="7"><div style="text-align:center;">
                                               <strong> <span  style="text-align:center;"><?php echo Topicareatype::getName($topic_area_selected); ?></span></strong><br>
                                   </div></td>
                           </tr>
                           <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,1,$_GET['ward_no']);  ?>
                                         <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                      
                    
                                                       if(empty($_GET['ward_no']))
                                                    {
                                                    
                                                        $sql = "select * from plan_details1 where type=1 and topic_area_id=".$topic_area_id." 
                                                            and topic_area_type_id=".$topic_area_selected
                                                 .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                                 .          " and fiscal_id=".$fiscal_id;    
                                                    }
                                                    else
                                                    {
                                                           $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=1 and topic_area_id=".$topic_area_id." 
                                                            and topic_area_type_id=".$topic_area_selected
                                                 .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                                 .          " and fiscal_id=".$fiscal_id;    
                                                    }  
                                                        $result =  Plandetails1::find_by_sql($sql);
                                                  
                                                         
                                                        ?>
                                                        <?php 
                                                        
                                                        $total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
                                                        ?>
   
                                                    
<?php if(!empty($result)):  ?>
                                
                       
                                              <tr> <td colspan="7"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
                                       
                                          
                                             


                                              <?php

                                              $j=1; 
                                            foreach($result as $data)
                                            { 
                                            
                                                     $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                                        $amount= Programmoredetails::getSum($data->id);
                                                            if(empty($amount))
                                                            {
                                                                $remaining_amount=$data->investment_amount;
                                                            }
                                                            else
                                                            {
                                                                $remaining_amount=($data->investment_amount)-($amount);
                                                              $total_investment_amount+=$amount;
                                                            }
                                      $total_amount+=$data->investment_amount;
                                      $total_remaining_amount+=$remaining_amount;
                                      
                                      ?>

                                                      <tr>
                                                          
                                                        <td><?php echo convertedcit($j);?></td>
                                                        <td><?php echo $data->program_name; ?></td>
                                                        <td><?php echo convertedcit($data->ward_no);?></td>
                                                        <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                                        <td><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                                        <td><?php echo convertedcit(placeholder($amount));?></td>
                                                        <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
                                                     
                                                      </tr>
                                                       
                                                      <?php

                                                      $j++ ; 
                                            }
                                  endif;
                                  
                                            ?>  
                                             
                 <tr>
                                                         <td colspan="4">जम्मा</td>
                                                         <td><?= convertedcit(placeholder($total_amount)) ?></td>
                                                         <td><?= convertedcit(placeholder($total_investment_amount)) ?></td>
                                                         <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
                                                      </tr>                 
                     <?php
                                              array_push($total_amount_array,$total_amount);
                                              array_push($total_investment_amount_array,$total_investment_amount);
                                              array_push($total_remaining_amount_array,$total_remaining_amount);
                              
                     
                      endforeach;
                             $add1=array_sum($total_amount_array);
                             $add2=array_sum($total_investment_amount_array);
                             $add3=array_sum($total_remaining_amount_array);
                } ?>
                
                                                    <tr>
                                 <td colspan="4"><strong>कुल जम्मा</strong></td>
                                 <td><?= convertedcit(placeholder($add1)) ?></td>
                                 <td><?= convertedcit(placeholder($add2)) ?></td>
                                 <td><?= convertedcit(placeholder($add3)) ?></td>
                               </tr> 
                                                      </table><br><br>
               
                     
            </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
   