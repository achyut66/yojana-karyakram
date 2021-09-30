<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
include("menuincludes/header1.php"); ?>
<?php
ini_set('max_execution_time', 300);
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$topic_area=  Topicarea::find_all();
$fiscal_id= Fiscalyear::find_current_id();
$bhautik_lakshya_topics = SettingbhautikPariman::find_all();
$count_bhautik_lakshya = SettingbhautikPariman::count_all();
$type = $_GET['type'];
?>
<body>

  <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                                <div style="text-align:center;">
                                                                  
                    <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>   
                        <div style="text-align:center;">
                       <?php if($_GET['type']==0){ ?> 
                    <div class="subjectboldright"><b><?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".$name." बिस्तृत रिपोर्ट हेर्नुहोस ";}
                     else if(!empty($_GET['ward_no']) && !empty($_GET['date_from']) && !empty($_GET['date_to'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".$name." मिति ".convertedcit($_GET['date_from'])." देखि मिति  ".convertedcit($_GET['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
                     else if(empty($_GET['ward_no']) && !empty($_GET['date_from']) && !empty($_GET['date_to'])){ echo $name." मिति ".convertedcit($_GET['date_from'])." देखि मिति  ".convertedcit($_GET['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
                     else{ echo $name." बिस्तृत रिपोर्ट हेर्नुहोस ";};?></b></div>
                 <?php foreach($topic_area as $topic){
                      $topic_area_id= $topic->id;?>
                    <h2><?=$topic->name?></h2>
                  <table class="table table-bordered table-hovtoer table-striped"> 
                      <thead>
                              <tr class="title_wrap">
                                  <td class="myCenter" rowspan="2"><strong>सि.नं.</strong></td>
                                    <td class="myCenter" rowspan="2"><strong>दर्ता नं </strong></td>
                                    <td class="myCenter" rowspan="2"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter" rowspan="2"><strong>वडा नं</strong></td>
                                    <td class="myCenter" rowspan="2"><strong>अनुदानको किसिम</strong></td>
                                    <td class="myCenter" colspan="<?=$count_bhautik_lakshya?>"><strong>भौतिक लक्ष्य </strong></td>
                                    <td class="myCenter" colspan="<?=$count_bhautik_lakshya?>"><strong>प्राप्त लक्ष्य </strong></td>
                                    
                              </tr>
                              <tr>
                                  <?php foreach ($bhautik_lakshya_topics as $topic):?>
                                  <td class="myCenter"><strong><?=$topic->name?></strong></td>
                                  <?php endforeach;?>
                                  <?php foreach ($bhautik_lakshya_topics as $to):?>
                                  <td class="myCenter"><strong><?=$to->name?></strong></td>
                                   <?php endforeach;?>
                              </tr>
                    </thead>
                       <?php 
                        $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_GET['ward_no']);
                foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                              <tr>            
                                    <td colspan="<?=9+$count_bhautik_lakshya?>" class="myCenter" >
                                    <strong><?php echo Topicareatype::getName($topic_area_selected); ?></strong>
                                    
                                    </td>
                              </tr>
                                       <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_GET['ward_no']);  
                          if(empty($topic_area_type_sub_ids))
                     {
                         continue;
                     }
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id){
                                   if(empty($_GET['ward_no']))
                                   {
                                        $sql = "select * from plan_details1 where type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                   else
                                   {
                                        $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                         
                                                $result =  Plandetails1::find_by_sql($sql);
                 if(empty($result))
                     {
                         continue;
                     }
                                                $total_amount=0;
                                                $total_remaining_amount=0;
                                                $total_investment_amount=0;
                                                ?>

                                <?php if(!empty($result)):  
                                             $final_array=array_unique(array_merge($counted_result['analysis_count_array'], $counted_result['final_count_array']));?>

                                                          <tr> <td colspan="<?=9+$count_bhautik_lakshya?>" class="myCenter"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
                                                      <?php
                                                        $j=1;  
                                                        
                                            foreach($result as $data)
                                                { 
                                                if(!in_array($data->id,$final_array))
                                                {
                                                    continue;
                                                }
                                                  $a=1;
                                                  if(!empty($_GET['date_from']) && !empty($_GET['date_to']))
                                                  {
                                                      $bhautik_lakshya_date = Bhautik_lakshya::find_by_plan_id_and_date($data->id,DateNepToEng($_GET['date_from']),DateNepToEng($_GET['date_to']));
                                                      if(empty($bhautik_lakshya_date))
                                                      {
                                                          $a=0;
                                                      }
                                                  }
                                                  if($a==0)
                                                  {
                                                      continue;
                                                  }
                                                         
                                                            ?>
                                                                <tbody style="height: 10px !important; overflow: scroll; ">
                                                                            <tr>

                                                                              <td class="myCenter"><?php echo convertedcit($j);?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                                                              <td class="myCenter"><?php echo $data->program_name; ?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                                                              <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                                                             <?php foreach ($bhautik_lakshya_topics as $topic):
                                                                                 $quantity = Bhautik_lakshya::find_by_plan_id_detail_id_type($data->id,$topic->id,1);
//                                                                                 print_r($quantity);
                                                                                 ?>
                                                                              <td class="myCenter"><?= convertedcit($quantity->qty)?></td>
                                                                            <?php endforeach;?>
                                                                            <?php foreach ($bhautik_lakshya_topics as $to):
                                                                                $qty_result = Bhautik_lakshya::find_by_plan_id_detail_id_type($data->id,$to->id,3);
//                                                                                print_r($qty_result);
                                                                                if(!empty($qty_result))
                                                                                {
                                                                                    $quantitys = $qty_result->qty;
                                                                                }
                                                                                else
                                                                                {
                                                                                    $quantitys=Bhautik_lakshya::sum_qty_by_plan_id_detail_id_type($data->id,$to->id,2);
                                                                                }
                                                                                ?>
                                                                              <td class="myCenter"><?=convertedcit($quantitys)?></td>
                                                                             <?php endforeach;?> 
                                                                            </tr>
                                                                </tbody>
                                                                            <?php

                                                                        $j++ ; 
                                                                       }
                                                                       endif;
                               }
                                 }                        ?> 
                                                                            
                  </table>

                  <?php
                            
                        
                 }
                
                
                  
        } 
//        endif;
        ?>

                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->