<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
include("menuincludes/header.php"); 
$mode=getUserMode();
$max_ward = Ward::find_max_ward_no();

$user = getUser();
$topic_area=  Topicarea::find_all();
$fiscal_id= Fiscalyear::find_current_id();
if(isset($_POST['submit']))
{   
//    print_r($_POST);exit;
   ini_set('max_execution_time', 300);
   $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
   $type           = $_POST['type'];
   $ward = $_POST['ward_no'];
   $date_from = !empty($_POST['date_from'])?DateNepToEng($_POST['date_from']):'';
   $date_to = !empty($_POST['date_from'])?DateNepToEng($_POST['date_to']):'';
}
$katti_topics = KattiWiwarn::find_all();
$count_katti = KattiWiwarn::count_all();
?>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"> कर / कट्टी विवरणको  रिपोर्ट हेर्नुहोस  | <a href="report_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                  <form method="post">
                    <table class="table table-bordered">
                    	<div class="inputWrap">
                        	<h1> कर / कट्टी विवरणको</h1>
                            <div class="titleInput">किसिम छान्नुहोस्:</div>
                            <div class="newInput"><select name="type" required>
                                                        <option value="">--छान्नुहोस्--</option>
                                                        <option value="0"<?php if($type==0){ echo 'selected="selected"';}?>> योजना अनुसार </option>
                                                        <option value="1"<?php if($type==1){ echo 'selected="selected"';}?>>बिषयगत क्षेत्र अनुसार </option>
                                                   </select></div>
                            <div class="row">
                                <div class="col-6"><input type="text" name="date_from" id="nepaliDate3" placeholder="मिति देखि "/></div>
                                <div class="col-6 "><input type="text" name="date_to" id="nepaliDate4" placeholder="मिति सम्म "/></div>
                                
                            </div>
                            <br>
                               <div class="titleInput">वार्ड छान्नुहोस् :</div>
                                    <?php if($mode=="user"):?> 
                                          <div class="newInput"><select name="ward_no">
                                               <option value="<?=$user->ward?>"><?=convertedcit($user->ward)?></option>
                                    		</select></div>
                                         <?php else:?>
                                        <div class="newInput"><select name="ward_no">
                                                <option value="">-छान्नुहोस्-</option>
                                               <?php for($i=1;$i<=$max_ward;$i++):?>
                                                <option value="<?=$i?>" <?php if($ward==$i){ echo 'selected="selected"';}?>><?=convertedcit($i)?></option>
                                    		<?php endfor;?>
                                            </select></div>
                                            <?php endif;?>
                              <div class="titleInput" id="topic_area_type_id">
                              	                              </div>
                              <div class="saveBtn myWidth100 "><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></div>
                             <div class="myspacer"></div>
                        </div><!-- input wrap ends -->                  
                </form>
   <?php if(isset($_POST['submit'])):?>
         <?php
                    if($_POST['type']==1)
                    {
                        $name="बिषयगत क्षेत्र अनुसारको  ";
                    }
                    else
                    {
                        $name="योजनाको ";
                    }
                    $fiscal_id= Fiscalyear::find_current_id();
           ?>
                    <div class="myPrint"><a target="_blank" href="kar_katti_report_print.php?date_from=<?=$_POST['date_from']?>&date_to=<?=$_POST['date_to']?>&type=<?php echo $type;?>&ward_no=<?=$_POST['ward_no']?>">प्रिन्ट गर्नुहोस</a> </div><br>  
                       
        <?php if($_POST['type']==0){ ?> 
                    <div class="subjectboldright"><b><?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".$name." बिस्तृत रिपोर्ट हेर्नुहोस ";}
                     else if(!empty($_POST['ward_no']) && !empty($_POST['date_from']) && !empty($_POST['date_to'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".$name." मिति ".convertedcit($_POST['date_from'])." देखि मिति  ".convertedcit($_POST['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
                     else if(empty($_POST['ward_no']) && !empty($_POST['date_from']) && !empty($_POST['date_to'])){ echo $name." मिति ".convertedcit($_POST['date_from'])." देखि मिति  ".convertedcit($_POST['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
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
                                  <?php foreach ($katti_topics  as $topic)://print_r($topic);?>
                                  <td class="myCenter"><strong><?=$topic->topic?></strong></td>
                                  <?php endforeach;?>
                              </tr>
                    </thead>
                       <?php 
                        $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_POST['ward_no']);
                foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                              <tr>            
                                    <td colspan="<?=7+$count_katti?>" class="myCenter" >
                                    <strong><?php echo Topicareatype::getName($topic_area_selected); ?></strong>
                                    
                                    </td>
                              </tr>
                                       <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_POST['ward_no']);  
                          if(empty($topic_area_type_sub_ids))
                     {
                         continue;
                     }
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id){
                                   if(empty($_POST['ward_no']))
                                   {
                                        $sql = "select * from plan_details1 where type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                   else
                                   {
                                        $sql = "select * from plan_details1 where ward_no=".$_POST['ward_no']." and type=$type and topic_area_id=".$topic_area_id." 
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
      if(!empty($_POST['date_from']) && !empty($_POST['date_to']))
      {
          $katti_date = KattiDetails::find_by_plan_id_and_date($data->id,DateNepToEng($_POST['date_from']),DateNepToEng($_POST['date_to']));
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
            <div class="subjectboldright"><b><?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".$name." बिस्तृत रिपोर्ट हेर्नुहोस ";}
             else if(!empty($_POST['ward_no']) && !empty($_POST['date_from']) && !empty($_POST['date_to'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".$name." मिति ".convertedcit($_POST['date_from'])." देखि मिति  ".convertedcit($_POST['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
             else if(empty($_POST['ward_no']) && !empty($_POST['date_from']) && !empty($_POST['date_to'])){ echo $name." मिति ".convertedcit($_POST['date_from'])." देखि मिति  ".convertedcit($_POST['date_to'])." सम्मको बिस्तृत रिपोर्ट हेर्नुहोस ";}
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
        endif;
        ?>
                </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->