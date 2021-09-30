<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$max_ward = Ward::find_max_ward_no();

$user = getUser();
$topic_area=  Topicarea::find_all();

?>
<?php include("menuincludes/header.php"); ?>
<?php
$format="";
$type="";

$fiscal_id= Fiscalyear::find_current_id();
$bhautik_lakshya_topics = SettingbhautikPariman::find_all();
$count_bhautik_lakshya = SettingbhautikPariman::count_all();
if(isset($_POST['submit']))
{   
   ini_set('max_execution_time', 300);
   $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
   $type           = $_POST['type'];
}

?>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"> बिस्तृत रिपोर्ट हेर्नुहोस  | <a href="report_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                  <form method="post">
                    <table class="table table-bordered">
                    	<div class="inputWrap">
                        	<h1>भौतिक प्रगति रिपोर्ट हेर्नुहोस </h1>
                            <div class="titleInput">किसिम छान्नुहोस्:</div>
                            <div class="newInput"><select name="type" required>
                                                        <option value="">--छान्नुहोस्--</option>
                                                        <option value="0"<?php if($type==0){ echo 'selected="selected"';}?>> योजना अनुसार </option>
                                                        <!--<option value="1"<?php if($type==1){ echo 'selected="selected"';}?>>बिषयगत क्षेत्र अनुसार </option>-->
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
                    // $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
           ?>
                    <div class="myPrint"><a target="_blank" href="bhautik_pragati_report_print.php?date_from=<?=$_POST['date_from']?>&date_to=<?=$_POST['date_to']?>&type=<?php echo $type;?>&ward_no=<?=$_POST['ward_no']?>">प्रिन्ट गर्नुहोस</a> </div><br>  
                        <!--|| <a  href="bhautik_pragati_report_excel.php?date_from=<?=$_POST['date_from']?>&date_to=<?=$_POST['date_to']?>&ward_no=<?=$_POST['ward_no']?>&type=<?= $type ?>">Export to excel</a>-->
<!--                <div style="text-align:center;">
                  <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                  <span  style="text-align:center;"><?=SITE_ADDRESS?></span>
                   </div> -->
                    <!--first condition starts-->
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
                        $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_POST['ward_no']);
                foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                              <tr>            
                                    <td colspan="<?=9+$count_bhautik_lakshya?>" class="myCenter" >
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
                                                  if(!empty($_POST['date_from']) && !empty($_POST['date_to']))
                                                  {
                                                      $bhautik_lakshya_date = Bhautik_lakshya::find_by_plan_id_and_date($data->id,DateNepToEng($_POST['date_from']),DateNepToEng($_POST['date_to']));
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
        endif;
        ?>
                </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->