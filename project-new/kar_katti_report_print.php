<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
include("menuincludes/header1.php"); ?>
<?php
ini_set('max_execution_time', 300);
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$type           = $_GET['type'];
$ward = $_GET['ward_no'];
$date_from = !empty($_GET['date_from'])?DateNepToEng($_GET['date_from']):'';
$date_to = !empty($_GET['date_from'])?DateNepToEng($_GET['date_to']):'';
$topic_area=  Topicarea::find_all();
$fiscal_id= Fiscalyear::find_current_id();
$katti_topics = KattiWiwarn::find_all();
$count_katti = KattiWiwarn::count_all();
$type = $_GET['type'];
if($_GET['type']==1)
{
    $name="बिषयगत क्षेत्र अनुसारको  ";
}
else
{
    $name="योजनाको ";
}
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
                                    <td class="myCenter" colspan="<?=$count_katti+2?>"><strong>कर /कट्टी विवरण </strong></td>
                              </tr>
                              <tr>
                                  <td>कन्टिनजेंन्सी कट्टी रकम </td>
                                  <td>मर्मत संहार कट्टी रकम</td>
                                  <?php foreach ($katti_topics  as $topic):?>
                                  <td class="myCenter"><strong><?=$topic->topic?></strong></td>
                                  <?php endforeach;?>
                              </tr>
                    </thead>
                       <?php 
                        $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_GET['ward_no']);
                foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                              <tr>            
                                    <td colspan="<?=7+$count_katti?>" class="myCenter" >
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

                                                          <tr> <td colspan="<?=7+$count_katti?>" class="myCenter"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
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
          $katti_date = KattiDetails::find_by_plan_id_and_date($data->id,DateNepToEng($_GET['date_from']),DateNepToEng($_GET['date_to']));
          if(empty($katti_date))
          {
              $a=0;
          }
      }
      if($a==0)
      {
          continue;
      }
      $result_katti =get_contingency_and_marmat_samhar_for_all_yojana($data->id);
                ?>
                    <tbody style="height: 10px !important; overflow: scroll; ">
                                <tr>

                                  <td class="myCenter"><?php echo convertedcit($j);?></td>
                                  <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                  <td class="myCenter"><?php echo $data->program_name; ?></td>
                                  <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                  <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                  <td class="myCenter"><?=convertedcit(placeholder($result_katti['contingency']))?></td>
                                  <td class="myCenter"><?=convertedcit(placeholder($result_katti['marmat']))?></td>
                                  <?php foreach ($katti_topics as $topic):
                                     $quantity = KattiDetails::find_by_plan_id_katti_id_id_type($data->id,$topic->id,2);
                                    if(!empty(!$quantity))
                                    {
                                        $katti_amount = $quantity->katti_amount+0;
                                    }
                                    else
                                    {
                                        $katti_amount = KattiDetails::sum_katti_amount_by_plan_id_katti_id_type($data->id,$topic->id,1);
                                    }
                                    
                                     ?>
                                  <td class="myCenter"><?= convertedcit($katti_amount+0   )?></td>
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
        else
        {
?>
            <div class="subjectboldright"><b><?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".$name." बिस्तृत रिपोर्ट हेर्नुहोस ";}
             else if(!empty($_GET['ward_no']) && !empty($_GET['date_from']) && !empty($_GET['date_to'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".$name." मिति ".convertedcit($_GET['date_from'])." देखि मिति  ".convertedcit($_GET['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
             else if(empty($_GET['ward_no']) && !empty($_GET['date_from']) && !empty($_GET['date_to'])){ echo $name." मिति ".convertedcit($_GET['date_from'])." देखि मिति  ".convertedcit($_GET['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
             else{ echo $name." बिस्तृत रिपोर्ट हेर्नुहोस ";};?></b></div>
                 <table class="table table-bordered table-hovtoer table-striped"> 
                      <thead>
                              <tr class="title_wrap">
                                  <td class="myCenter" rowspan="2"><strong>सि.नं.</strong></td>
                                    <td class="myCenter" rowspan="2"><strong>बिषयगत क्षेत्र अनुसार  </strong></td>
                                    <td class="myCenter" colspan="<?=$count_katti+2?>"><strong>कर /कट्टी विवरण </strong></td>
                              </tr>
                              
                              <tr>
                                  <td>कन्टिनजेंन्सी कट्टी रकम </td>
                                  <td>मर्मत संहार कट्टी रकम</td>
                                  <?php foreach ($katti_topics  as $topic):?>
                                  <td class="myCenter"><strong><?=$topic->topic?></strong></td>
                                  <?php endforeach;?>
                              </tr>
                             
                    </thead>   
                    <?php 
                    $i=1;
                    $total_contingency = 0;
                    $total_marmat =0;
                    $total_katti_array= array();
                    foreach($topic_area as $data):
                        $katti_result = get_contingency_marmat_by_topic_ward_date($ward,$data->id,$date_from,$date_to)
                        ?>
                    <tr>
                    <td class="myCenter"><?=convertedcit($i)?></td>
                    <td class="myCenter"><?=$data->name?></td>
                    <td class="myCenter"><?=convertedcit(placeholder($katti_result['contingency']))?></td>
                    <td class="myCenter"><?=convertedcit(placeholder($katti_result['marmat']))?></td>
                    <?php 
                    $j=1;
                    foreach ($katti_topics  as $topic):
                        $katti_amount =get_katti_from_katti_wiwaran($topic->id,$ward,$data->id,$date_from,$date_to)
                        ?>
                    <td class="myCenter"><strong><?=convertedcit(placeholder($katti_amount+0))?></strong></td>
                    <?php 
                    $j++;
                    $total_katti_array[$j] +=$katti_amount; 
                    endforeach;?>
                    </tr>
                 <?php $i++; 
                 $total_contingency+=$katti_result['contingency'];
                 $total_marmat += $katti_result['marmat'];
                 endforeach;?>
                    <tr>
                        <td class="myCenter" colspan="2">जम्मा</td>
                        <td class="myCenter"><?=convertedcit(placeholder($total_contingency))?></td>
                        <td class="myCenter"><?=convertedcit(placeholder($total_marmat))?></td>
                      <?php foreach($total_katti_array as $a):?>
                        <td class="myCenter"><?=convertedcit(placeholder($a))?></td>
                        <?php endforeach;?>
                    </tr>
<?php
        }
//        endif;
        ?>

                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->