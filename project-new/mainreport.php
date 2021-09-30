<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$max_ward = Ward::find_max_ward_no();
$user = getUser();

$topic_area=  Topicarea::find_all();?>
<?php include("menuincludes/header.php"); ?>
<?php
$format="";
$type="";
$topic_area_id="";
 $fiscal_id= Fiscalyear::find_current_id();
if(isset($_POST['submit']))
{   
   ini_set('max_execution_time', 300);
   $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
    $format         = $_POST['format'];
    $type           = $_POST['type'];
    $topic_area_id  = $_POST['topic_area_id'];
    //$topic_area_type_id=$_POST['topic_area_type_id'];
    $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic_area_id);
    if(!empty($topic_area_type_id)){
    $sql="select * from plan_details1 where type=".$type." and topic_area_type_id=".$topic_area_type_id;
    $result=  Plandetails1::find_by_sql($sql);
    }
    
}

?>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"> मुख्य रिपोर्ट हेर्नुहोस  | <a href="report_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            
             
            <div class="OurContentFull">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                  <form method="post">
                    <table class="table table-bordered">
                    	<div class="inputWrap">
                        	<h1>मुख्य रिपोर्ट हेर्नुहोस </h1>
                            <div class="titleInput">किसिम छान्नुहोस्:</div>
                            <div class="newInput"><select name="type" required>
                                                <option value="">--छान्नुहोस्--</option>
                                                <option value="0"<?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
                                                <option value="1"<?php if($type==1){ echo 'selected="selected"';}?>>कार्यक्रम</option>
                                        </select></div>
                             <div class="titleInput">योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम: </div>
                             <div class="newInput"><select name="topic_area_id"  required>
                                       <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($topic_area as $topic): ?> 
                                       <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
                                            <?php endforeach; ?>
                                        </select></div>
                             <div class="titleInput">आंसिक / बिस्तृत : </div>
                             <div class="newInput"><select name="format" required>
                                       <option value="">--छान्नुहोस्--</option>
                                               <option value="1" <?php if($format==1){ echo 'selected="selected"';}?>>आंसिक</option>
                                               <option value="2" <?php if($format==2){ echo 'selected="selected"';}?>>बिस्तृत</option>
                                        </select></div>
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
                                   <div class="myPrint"><a  href="mainreport_excel.php?ward_no=<?=$_POST['ward_no']?>&format=<?php echo $_POST['format'];?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?= $type ?>">Export to excel</a></div>
         <?php $format = $_POST['format'];
             if($format==1)
             {
             ?>
                                           <div class="myPrint"><a target="_blank" href="mainreport_print.php?ward_no=<?=$_POST['ward_no']?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?= $type ?>">प्रिन्ट गर्नुहोस</a></div><br>
                                           <div style="text-align:center;">
                                               <?php if($type==0 && empty($result)):?>
                                               <h2><b>योजना अन्तर्गत <?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>
                                                <table class="table table-bordered table-hover">
                                                         
                                                         <tr class="title_wrap">    
                                                            
                                                             <td class="myCenter"><strong>सि.न </strong></td>
                                                             <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                                             <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                                             <td class="myCenter"><strong>कुल संख्या </strong></td>
                                                             <td class="myCenter"><strong>कुल अनुदान रु </strong></td>
                                                             <td class="myCenter"><strong>खर्च भएको रकम </strong></td>
                                                             <td class="myCenter"><strong>बाकी रकम</strong> </td>
                                                             <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                                                             
                                                         </tr>
                                              <?php            
                                              $i=1;
                                              $total_count=0;
                                              $total_investment=0;
                                              $total_payable=0;
                                              $remaining_payable=0;
//                                              echo count($topic_area_type_ids); exit;
                                              foreach($topic_area_type_ids as $topic_selected):
                                                  
                                                $total_net_payable_amount = get_remaining_amount_mainreport($topic_area_id,$topic_selected->id,$type,$_POST['ward_no']);
                                                $total_net_investment = Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);

                                                 $remaining_net_investment=$total_net_investment - $total_net_payable_amount;
                                                 
                                                         if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])==0)
                                                         {
                                                             continue;
                                                         }   
                                                         ?>
                                                         <tr>
                                                              <td class="myCenter" ><?php echo convertedcit($i);?></td>
                                                             <td class="myCenter"><?php echo Topicarea::getName($topic_area_id);?></td>
                                                             <td class="myCenter"><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td class="myCenter"><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder($total_net_payable_amount));?></td>
                                                               <td class="myCenter"><?php echo convertedcit(placeholder($remaining_net_investment));?></td>
                                                             <td class="myCenter"><a href="view_main_report.php?topic_area_type_id=<?=$topic_selected->id?>&type=<?php echo $type;?>&topic_area_id=<?php echo $topic_area_id;?>&ward=<?=$_POST['ward_no']?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                                         </tr>
                                                  <?php $i++; 
                                                  $total_payable +=$total_net_payable_amount;
                                                  $remaining_payable +=$remaining_net_investment;
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);  
                                                  $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
                                                  endforeach;?>
                                                           <tr>
                                                          <td colspan="2">&nbsp; </td>     
                                                          <td>जम्मा </td>
                                                          <td ><?php echo convertedcit(placeholder($total_count)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_payable)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($remaining_payable)); ?></td>

                                                          </tr> 
                                          </table>
                                               <?php endif;?>
                                              <?php if($type==1):?>
                                                  <h2><b>कार्यक्रम अन्तर्गत <?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>
                                            <table class="table table-bordered table-hover">
                                                         <tr class="title_wrap">    
                                                             <td class="myCenter"><strong>सि.न </strong></td>
                                                             <td class="myCenter"><strong>कार्यक्रमको बिषयगत क्षेत्रको किसिम</strong></td>
                                                             <td class="myCenter"><strong>कार्यक्रमको शिर्षकगत किसिम</strong></td>
                                                             <td class="myCenter"><strong>कुल संख्या </strong></td>
                                                             <td class="myCenter"><strong>कुल अनुदान रु </strong></td>
                                                             <td class="myCenter"><strong>खर्च भएको रकम </strong></td>
                                                             <td class="myCenter"><strong>बाकी रकम </strong></td>
                                                             <td class="myCenter"><strong>विवरण हेर्नुहोस</strong> </td>
                                                         </tr>
                                              <?php            
                                              $i=1;
                                              $total_investment=0;
                                              $total_count=0;
                                             $total_net_amount=0;
                                             $remaining_amount=0;
                                              foreach($topic_area_type_ids as $topic_selected) :
                                                   $data_array=get_remaining_amount_mainreport1($topic_area_id,$topic_selected->id,$type,$_POST['ward_no']);
                                              if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])==0)
                                              {
                                                  continue;
                                              }
                                                  ?>

                                                         <tr>
                                                              <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                             <td class="myCenter"><?php echo Topicarea::getName($topic_area_id);;?></td>
                                                             <td class="myCenter"><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td class="myCenter"><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])));?></td>
                                                              <td class="myCenter"><?php echo convertedcit(placeholder($data_array['total_expenditure_till_now']));?></td>
                                                               <td class="myCenter"><?php echo convertedcit(placeholder($data_array['total_remaining_program_budget']));?></td>
                                                               <td class="myCenter"><a href="view_main_report1.php?ward=<?=$_POST['ward_no']?>&topic_area_type_id=<?=$topic_selected->id?> &type=<?php echo $type;?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                                         </tr>
                                                  <?php $i++;
                                                  $total_net_amount +=$data_array['total_expenditure_till_now'];
                                                  $remaining_amount +=$data_array['total_remaining_program_budget'];
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
                                                   $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
                                                  endforeach;?>
                                                        <tr>
                                                          <td colspan="2">&nbsp; </td>     
                                                          <td>जम्मा </td>
                                                          <td ><?php echo convertedcit(placeholder($total_count)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_net_amount)); ?></td>
                                                          <td colspan="2"><?php echo convertedcit(placeholder($remaining_amount)); ?></td>
                                                          </tr> 
                                          </table>
                                               <?php endif;
             }                                  
        else 
           { 
                    if($_POST['type']==1)
                    {
                        $name="कार्यक्रम अन्तर्गत ";
                    }
                    else
                    {
                        $name="योजना अन्तर्गत ";
                    }
                    $fiscal_id= Fiscalyear::find_current_id();
                    $topic_area_id=$_POST['topic_area_id'];
                    $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_POST['ward_no']);
                   // $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
           ?>
                  <div class="myPrint"><a target="_blank" href="mainreport_details_print.php?type=<?php echo $type;?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&ward_no=<?=$_POST['ward_no']?>">प्रिन्ट गर्नुहोस</a></div><br>  
                  <div style="text-align:center;">
                  <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                  <span  style="text-align:center;"><?=SITE_ADDRESS?></span>
                  <div class="subjectboldright"><b><?php echo $name; if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></div>
                  </div>  
                   <table class="table table-bordered table-hover"> 
                     
                              <tr class="title_wrap">
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>दर्ता नं </strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>वडा नं</strong></td>
                                    <td class="myCenter"><strong>अनुदानको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>योजनाको हाल सम्म लागेको भुक्तानी</strong></td>
                                     <td class="myCenter"><strong>भुक्तानी घटी रकम   </strong></td>
                                    <td class="myCenter"><strong>योजनाको कुल बाँकी रकम</strong></td>

                              </tr>

                       <?php 
                        $total_investment_array=array();
                         $total_net_payable_array=array();
                         $total_remaining_amount_array=array();
                         $final_ghati_array = array();
                       foreach($topic_area_type_ids as $topic_area_selected)
//                           echo $topic_area_selected;exit;
                                     { ?>
                              <tr>            
                                    <td colspan="8" class="myCenter" >
                                    <strong><?php echo Topicareatype::getName($topic_area_selected); ?></strong>
                                    
                                    </td>
                              </tr>
                                       <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_POST['ward_no']);  
                         
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
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
 
                                                $total_amount=0;
                                                $total_remaining_amount=0;
                                                $total_investment_amount=0;
                                                ?>

                                <?php if(!empty($result)):  
                                             $final_array=$counted_result['final_count_array'];?>

                                                          <tr> <td colspan="9" class="myCenter"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
                                                      <?php
                                                        $j=1;  
                                                        $total_investment=0;
                                                        $total_net_payable_amount=0;
                                                         $total_remaining_amount=0;
                                                         $net_total_investment=0;
                                                         $net_total_payable_amount=0;
                                                         $net_total_remaining_amount=0;
                                                         $total_ghati_amount =0;
                                                        foreach($result as $data)
                                                        { 
                                                            $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                            $final_amount_result= Planamountwithdrawdetails::find_by_plan_id($data->id);
                                                            
                                                            if(!empty($final_amount_result))
                                                            {
                                                                $ghati_amount = $final_amount_result->final_bhuktani_ghati_amount;
                                                            }
                                                            else
                                                            {
                                                                 $ghati_amount =0;
                                                            }
                                                         if($data->type==0)
                                                         {  
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else{ 
                                                                             if(empty($contract_result))
                                                                                  {
                                                                                      $data->investment_amount = get_investment_amount($data->id);
                                                                                          if(in_array($data->id, $final_array))
                                                                                              {
                                                                                                   $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                                                   $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                              }
                                                                                              else
                                                                                              {

                                                                                                   $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                      //                                             echo $net_payable_amount;exit;
                                                                                                  $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                                              } 
                                                                                  }
                                                                                  else
                                                                                  {
                                                                                     if(in_array($data->id, $final_array))
                                                                                          {
                                                                                              $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                                               $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                          }
                                                                                          else
                                                                                          {

                                                                                               $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                                               $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                                          }  

                                                                                  }
                                                                           }
                                                         }
                                                         else
                                                         {
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else
                                                                    {
                                                                        $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                                                        $net_payable_amount= Programmoredetails::getSum($data->id);
                                                                        if(empty($amount))
                                                                        {
                                                                            $remaining_amount=$data->investment_amount;
                                                                        }
                                                                        else
                                                                        {
                                                                            $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                                                        }
                                                                    }
                                                                
                                                         }
                                                                     $total_investment+=$data->investment_amount;
                                                                        $total_net_payable_amount +=$net_payable_amount;
                                                                        $total_remaining_amount +=$remaining_amount;
                                                                        $total_ghati_amount+=$ghati_amount;
                                                                      
                                                            ?>

                                                                            <tr>

                                                                              <td class="myCenter"><?php echo convertedcit($j);?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                                                              <td class="myCenter"><?php echo $data->program_name; ?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                                                              <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                                                              <td class="myCenter"><?=convertedcit(placeholder($ghati_amount))?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder($remaining_amount));?></td>

                                                                            </tr>

                                                                            <?php

                                                                        $j++ ; 
                                                                        
                                                        }
                                                                          
                                      endif;
                                                                      
                                                        ?>  

                                                                  <tr>
                                                                     <td colspan="5">जम्मा</td>
                                                                     <td><?= convertedcit(placeholder($total_investment)) ?></td>
                                                                     <td><?= convertedcit(placeholder($total_net_payable_amount )) ?></td>
                                                                     <td><?=convertedcit($total_ghati_amount)?></td>
                                                                     <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
                                                                  </tr>                 
                              <?php 
                                              array_push($total_investment_array,$total_investment);
                                              array_push($total_net_payable_array,$total_net_payable_amount);
                                               array_push($final_ghati_array,$total_ghati_amount);
                                              array_push($total_remaining_amount_array,$total_remaining_amount);
                              
                              endforeach;
                             
                              }
                              $add1=array_sum($total_investment_array);
                             $add2=array_sum($total_net_payable_array);
                             $add3=array_sum($total_remaining_amount_array);
                             $add4=array_sum($final_ghati_array);
                           ?>
                                                              
                            <tr>
                                 <td colspan="5"><strong>कुल जम्मा</stong></td>
                                 <td><?= convertedcit(placeholder($add1)) ?></td>
                                 <td><?= convertedcit(placeholder($add2)) ?></td>
                                  <td><?= convertedcit(placeholder($add4)) ?></td>
                                 <td colspan="2"><?= convertedcit(placeholder($add3)) ?></td>
                              </tr> 
                  </table>


                        
        <?php } ?>
 <?php endif;?>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>