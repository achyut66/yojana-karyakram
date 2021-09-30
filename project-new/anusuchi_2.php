<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
///phpinfo(); exit;
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
 $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
 ini_set('max_execution_time',300);
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
  <style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }
  .borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
  }
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
</style>
<body>
  <?php include("menuincludes/topwrap.php"); ?>
  <div id="body_wrap_inner"> 
    <div class="">
      <div class="">
        <div class="maincontent">
          <h2 class="headinguserprofile"> अनुसूची रिपोर्ट हेर्नुहोस /<a href="anusuchi_dashboard.php" class="btn">पछि जानुहोस </a> </h2>
          <div class="OurContentFull">
            <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
            <div class="userprofiletable">
              <h3>अनुसूची रिपोर्ट हेर्नुहोस </h3>
              <form method="post">
                <table class="table table-bordered">
                 <tr>
                  <td>किसिम छान्नुहोस्</td>
                  <td>
                    <select name="type" required>
                      <option value="">--छान्नुहोस्--</option>
                      <option value="0"<?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
                      <option value="1"<?php if($type==1){ echo 'selected="selected"';}?>>कार्यक्रम</option>
                    </select>
                  </td>
                </tr>               
                <tr>
                  <td> योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम: </td>
                  <td><select name="topic_area_id"  required>
                   <option value="">--छान्नुहोस्--</option>
                   <?php foreach($topic_area as $topic): ?> 
                     <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
                   <?php endforeach; ?>
                 </select>
               </td>
             </tr>
             <tr>
              <td>अन्सिक / बिस्तृत : </td>
              <td><select name="format" required>
               <option value="">--छान्नुहोस्--</option>
               <option value="1" <?php if($format==1){ echo 'selected="selected"';}?>>अन्सिक</option>
               <option value="2" <?php if($format==2){ echo 'selected="selected"';}?>>बिस्तृत</option>
             </select>
           </td>
         </tr>
         <tr>
          <td>वार्ड छान्नुहोस् :</td>
          <td>
           <?php if($mode=="user"):?>
             <select name="ward_no">
               <option value="<?=$user->ward?>"><?=convertedcit($user->ward)?></option>
             </select>
             <?php else:?>
              <select name="ward_no">
                <option value="">-छान्नुहोस्-</option>
                <?php for($i=1;$i<=$max_ward;$i++):?>
                  <option value="<?=$i?>" <?php if($ward==$i){ echo 'selected="selected"';}?>><?=convertedcit($i)?></option>
                <?php endfor;?>
              </select>
            <?php endif;?>
          </td>
        </tr>
        <tr id="topic_area_type_id">
        </tr>
        <tr>
         <td colspan="2"> <input type="submit" name="submit" value="खोज्नुहोस" class="submithere"></td>
       </tr>
     </table>
   </form>
   <?php if(isset($_POST['submit'])):?>
    <div class="myPrint"><a target="_blank" href="anusuchi_2_print.php?ward_no=<?=$_POST['ward_no']?>&format=<?php echo $format?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?= $type ?>">प्रिन्ट गर्नुहोस</a>  <a  href="anusuchi_2_excel.php?ward_no=<?=$_POST['ward_no']?>&format=<?php echo $_POST['format'];?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?= $type ?>">Export to excel</a></div>
    <br><br><?php $format = $_POST['format'];
    if($format==1 && $type==0)
    {
     ?>
     <div style="text-align:center;">
       <h2><b>योजना अन्तर्गत <?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>

       <table class="table table-bordered table-responsive">
         <tr>    
          <th rowspan="2" class="myCenter">सि.न </th>
          <th rowspan="2" class="myCenter">योजनाको बिषयगत क्षेत्रको किसिम</th>
          <th rowspan="2" class="myCenter">योजनाको शिर्षकगत किसिम:</th>
          <th rowspan="2" class="myCenter">कुल संख्या  :</th>
          <th colspan="4" class="myCenter">विनियोजन रु.</th>
          <th rowspan="2" class="myCenter">खर्च भएको रकम </th>
          <th rowspan="2" class="myCenter">बाकी रकम </th>
          <th rowspan="2" class="myCenter">विवरण हेर्नुहोस </th>
        </tr>
        <tr>
          <th class="myCenter">प्रथम चौमासिक</th>
          <th class="myCenter">दोश्रो चौमासिक</th>
          <th class="myCenter">तेस्रो चौमासिक</th>
          <th class="myCenter">जम्मा</th>
        </tr>
        <?php            
        $i=1;
        $first_total=0;
        $second_total=0;
        $third_total=0;
        $total_count=0;
        $total_investment=0;
        $total_payable=0;
        $remaining_payable=0;
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
          <td><?php echo convertedcit($i);?></td>
          <td><?php echo Topicarea::getName($topic_area_id);?></td>
          <td><?php echo $topic_selected->topic_area_type;?></td>
          <td><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']));?></td>
          <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
          <td> <?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
          <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
          <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])));?></td>
          <td><?php echo convertedcit(placeholder($total_net_payable_amount));?></td>
          <td><?php echo convertedcit(placeholder($remaining_net_investment));?></td>
          <td><a href="view_main_report.php?ward=<?=$_POST['ward_no']?>&topic_area_type_id=<?=$topic_selected->id?>&type=<?php echo $type;?>&topic_area_id=<?php echo $topic_area_id;?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
        </tr>
        <?php $i++; 
        $first_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_POST['ward_no']);
        $second_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_POST['ward_no']);
        $third_total += Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_POST['ward_no']);
        $total_payable +=$total_net_payable_amount;
        $remaining_payable +=$remaining_net_investment;
        $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);  
        $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
      endforeach;?>
      <tr>
       <td colspan="2">&nbsp; </td>     
       <td>जम्मा </td>
       <td ><?php echo convertedcit(placeholder($total_count)); ?></td>
       <td><?php echo convertedcit(placeholder($first_total)); ?></td>
       <td><?php echo convertedcit(placeholder($second_total)); ?></td>
       <td><?php echo convertedcit(placeholder($third_total)); ?></td>
       <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
       <td ><?php echo convertedcit(placeholder($total_payable)); ?></td>
       <td ><?php echo convertedcit(placeholder($remaining_payable)); ?></td>
     </tr> 
   </table>
 <?php } elseif($format==1 && $type==1){?>
  <h2><b>कार्यक्रम अन्तर्गत <?php if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>
  <table class="table table-bordered table-responsive">
   <tr>    
     <th rowspan="2" class="myCenter">सि.न </th>
     <th rowspan="2" class="myCenter">कार्यक्रमको बिषयगत क्षेत्रको किसिम</th>
     <th rowspan="2" class="myCenter">कार्यक्रमको शिर्षकगत किसिम:</th>
     <th rowspan="2" class="myCenter">कुल संख्या  :</th>
     <th colspan="4" class="myCenter">विनियोजन रु.</th>
     <th rowspan="2" class="myCenter">खर्च भएको रकम </th>
     <th rowspan="2" class="myCenter">बाकी रकम </th>
     <th rowspan="2" class="myCenter">विवरण हेर्नुहोस </th>
   </tr>
   <tr>
    <th class="myCenter">प्रथम चौमासिक</th>
    <th class="myCenter">दोश्रो चौमासिक</th>
    <th class="myCenter">तेस्रो चौमासिक</th>
    <th class="myCenter">जम्मा</th>
  </tr>
  <?php            
  $i=1;
  $first_total=0;
  $second_total=0;
  $third_total=0;
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
    <td><?php echo convertedcit($i);?></td>
    <td><?php echo Topicarea::getName($topic_area_id);;?></td>
    <td><?php echo $topic_selected->topic_area_type;?></td>
    <td><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']));?></td>
    <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
    <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
    <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_POST['ward_no']))); ?></td>
    <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no'])));?></td>
    <td><?php echo convertedcit(placeholder($data_array['total_expenditure_till_now']));?></td>
    <td><?php echo convertedcit(placeholder($data_array['total_remaining_program_budget']));?></td>
    <td><a href="view_main_report1.php?ward=<?=$_POST['ward_no']?>&topic_area_type_id=<?=$topic_selected->id?> &type=<?php echo $type;?>">पुरा विवरण हेर्नुहोस</a></td>
  </tr>
  <?php $i++;
  $first_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_POST['ward_no']);
  $second_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_POST['ward_no']);
  $third_total += Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_POST['ward_no']);
  $total_net_amount +=$data_array['total_expenditure_till_now'];
  $remaining_amount +=$data_array['total_remaining_program_budget'];
  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
  $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_POST['ward_no']);
endforeach;?>
<tr>
 <td colspan="2">&nbsp; </td>     
 <td>जम्मा </td>
 <td ><?php echo convertedcit(placeholder($total_count)); ?></td>
 <td><?php echo convertedcit(placeholder($first_total)); ?></td>
 <td><?php echo convertedcit(placeholder($second_total)); ?></td>
 <td><?php echo convertedcit(placeholder($third_total)); ?></td>
 <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
 <td ><?php echo convertedcit(placeholder($total_net_amount)); ?></td>
 <td ><?php echo convertedcit(placeholder($remaining_amount)); ?></td>
</tr> 
</table>
</div>
<?php } 
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
 ?>
  <div style="text-align:center;">
    <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
    <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>
  </div>
  <div class="subjectboldright"><b><?php echo $name; if(!empty($_POST['ward_no'])){ echo "वडा नं ". convertedcit($_POST['ward_no']). " को  ".Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></div>
  <br><br>  
  <table class="table table-bordered table-responsive mytable"> 
    <strong> <span  style="text-align:left;"> <?php echo Topicarea::getName($_POST['topic_area_id']);?></span></strong><br>
    <tr>
      <th rowspan="2" class="myCenter">सि नं</th>
      <th rowspan="2" class="myCenter">योजनाको नाम</th>
      <th rowspan="2" class="myCenter">वडा नं</th>
      <th rowspan="2" class="myCenter">अनुदानको किसिम</th>
      <th colspan="4" class="myCenter">विनियोजन रु.</th>
      <th  rowspan="2" class="myCenter"> भुक्तानी घटी रकम </th>
      <th rowspan="2" class="myCenter">योजनाको हाल सम्म लागेको भुक्तानी</th>
      <th rowspan="2" class="myCenter">योजनाको कुल बाँकी रकम</th>
    </tr>
    <tr>
      <th class="myCenter">प्रथम चौमासिक</th>
      <th class="myCenter">दोश्रो चौमासिक</th>
      <th class="myCenter">तेस्रो चौमासिक</th>
      <th class="myCenter">जम्मा</th>
    </tr>
    <?php 
    $first_total_array=array();
    $second_total_array=array();
    $third_total_array=array();
    $total_investment_array=array();
    $total_net_payable_array=array();
    $total_remaining_amount_array=array();
    $ghati_amount_array = array();
    foreach($topic_area_type_ids as $topic_area_selected)
     { ?>
      <tr>            
        <td colspan="10"><div style="text-align:center;">
          <strong> <span  style="text-align:center;"><?php echo Topicareatype::getName($topic_area_selected); ?></span></strong><br>
        </div>
      </td>
    </tr>
    <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_POST['ward_no']);  
    ?>
    <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
     if(empty($_POST['ward_no']))
     {
       $sql = "select * from plan_details1 where type=$type  and topic_area_id=".$topic_area_id." 
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
       <tr> <td colspan="10"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
       <?php
       $j=1;  
       $first_total=0;
       $second_total=0;
       $third_total=0;
       $total_investment=0;
       $total_net_payable_amount=0;
       $total_remaining_amount=0;
       $net_total_investment=0;
       $net_total_payable_amount=0;
       $net_total_remaining_amount=0;
       $total3=0;
       foreach($result as $data){
        $final_amount_result= Planamountwithdrawdetails::find_by_plan_id($data->id);
        if(!empty($final_amount_result))
        {
          $ghati_amount = $final_amount_result->final_bhuktani_ghati_amount;
        }
        else
        {
         $ghati_amount =0;
       }
       $contract_result= Contract_total_investment::find_by_plan_id($data->id);
       if($data->type==0)
       {  
        $budget=  Ekmustabudget::find_by_plan_id($data->id);//print_r($budget);
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
$total_investment+=get_investment_amount($data->id);
$total_net_payable_amount +=$net_payable_amount;
$total_remaining_amount +=$remaining_amount;
$total3+=$ghati_amount;         
?>
<tr>
  <td><?php echo convertedcit($j);?></td>
  <td><?php echo $data->program_name; ?></td>
  <td><?php echo convertedcit($data->ward_no);?></td>
  <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
  <td><?php echo convertedcit(placeholder($data->first));?></td>
  <td><?php echo convertedcit(placeholder($data->second));?></td>
  <td><?php echo convertedcit(placeholder($data->third));?></td>
  <td><?php echo convertedcit(placeholder(get_investment_amount($data->id)));?></td>
  <td ><?=convertedcit(placeholder($ghati_amount))?></td>
  <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
  <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
</tr>
<?php
$first_total +=$data->first;
$second_total +=$data->second;
$third_total +=$data->third;
$j++ ; 
}
endif;
?>  
<tr>
 <td colspan="4">जम्मा</td>
 <td><?= convertedcit(placeholder($first_total)) ?></td>
 <td><?= convertedcit(placeholder($second_total)) ?></td>
 <td><?= convertedcit(placeholder($third_total)) ?></td>
 <td><?= convertedcit(placeholder($total_investment)) ?></td>
 <td><?= convertedcit(placeholder($total3 )) ?></td>
 <td><?= convertedcit(placeholder($total_net_payable_amount )) ?></td>
 <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
</tr>                 
<?php 
array_push($first_total_array,$first_total);
array_push($second_total_array,$second_total);
array_push($third_total_array,$third_total);
array_push($total_investment_array,$total_investment);
array_push($total_net_payable_array,$total_net_payable_amount);
array_push($total_remaining_amount_array,$total_remaining_amount);
array_push($ghati_amount_array,$ghati_amount);
endforeach;
}
$add1=  array_sum($total_investment_array);
$add2=  array_sum($total_net_payable_array);
$add3=  array_sum($total_remaining_amount_array);
$add4=  array_sum($first_total_array);
$add5=  array_sum($second_total_array);
$add6=  array_sum($third_total_array);
$add7=array_sum($ghati_amount_array);
?>
<tr>
  <td colspan="4"><strong>कुल जम्मा</stong></td>
   <td><?= convertedcit(placeholder($add4)) ?></td>
   <td><?= convertedcit(placeholder($add5)) ?></td>
   <td><?= convertedcit(placeholder($add6)) ?></td>
   <td><?= convertedcit(placeholder($add1)) ?></td>
   <td><?= convertedcit(placeholder($add7)) ?></td>
   <td><?= convertedcit(placeholder($add2)) ?></td>
   <td><?= convertedcit(placeholder($add3)) ?></td>
 </tr> 
</table><br><br>
<?php } ?>
<?php endif;?>
</div>
</div><!-- main menu ends -->
</div>
</div>   
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>