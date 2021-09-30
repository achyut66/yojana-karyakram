<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$topic_area=  Topicarea::find_all();?>
<?php include("menuincludes/header1.php"); ?>
<?php
$ward = $_GET['ward_no'];
$format=$_GET['format'];
$topic_area_id=$_GET['topic_area_id'];
$fiscal_id=$_GET['fiscal_id'];
$type=$_GET['type'];
 $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic_area_id);
    if(!empty($topic_area_type_id)){
    $sql="select * from plan_details1 where type=".$type." and topic_area_type_id=".$topic_area_type_id;
    $result=  Plandetails1::find_by_sql($sql);
    }

?>
<body>

  <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                                           <div style="text-align:center;">
                                             <?php $format = $_GET['format'];
             if($format==1)
             {
                  ini_set('max_execution_time',300);
             ?>                         
                                            <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="margin1em"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="margin1em"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="margin1em"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>   
                                           <div style="text-align:center;">
                                               <?php if($type==0 && empty($result)):?>
                                               <h2><b>योजना अन्तर्गत <?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>
                                              
                                                <table class="table table-bordered table-responsive">
                                                         <tr>    
                                                            
                                                              <th rowspan="2" class="myCenter">सि.न </th>
                                                             <th  rowspan="2" class="myCenter">योजनाको बिषयगत क्षेत्रको किसिम</th>
                                                             <th rowspan="2" class="myCenter">योजनाको शिर्षकगत किसिम:</th>
                                                             <th rowspan="2" class="myCenter">कुल संख्या  :</th>
                                                             <th colspan="4" class="myCenter">विनियोजन रु.</th>
                                                             <th rowspan="2" class="myCenter">खर्च भएको रकम </th>
                                                             <th rowspan="2" class="myCenter">बाकी रकम </th>
                                                             
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
//                                              echo count($topic_area_type_ids); exit;
                                              foreach($topic_area_type_ids as $topic_selected):
                                                  
                                                $total_net_payable_amount = get_remaining_amount_mainreport($topic_area_id,$topic_selected->id,$type,$_GET['ward_no']);
                                                $total_net_investment = Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);

                                                 $remaining_net_investment=$total_net_investment - $total_net_payable_amount;
                                                 
                                                         if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])==0)
                                                         {
                                                             continue;
                                                         }   
//                                                         echo $topic_selected->id;exit;
                                                         ?>
                                                         <tr>
                                                              <td><?php echo convertedcit($i);?></td>
                                                             <td><?php echo Topicarea::getName($topic_area_id);?></td>
                                                             <td><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']));?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td> <?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])));?></td>
                                                             <td><?php echo convertedcit(placeholder($total_net_payable_amount));?></td>
                                                               <td><?php echo convertedcit(placeholder($remaining_net_investment));?></td>
                                                        </tr>
                                                  <?php $i++; 
                                                  $first_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $second_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $third_total += Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $total_payable +=$total_net_payable_amount;
                                                  $remaining_payable +=$remaining_net_investment;
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);  
                                                  $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
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
                                               <?php endif;?>
                                              <?php if($type==1):?>
                                                 <h2><b>कार्यक्रम अन्तर्गत <?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></h2>
                                           
                                            <table class="table table-bordered table-responsive">
                                                         <tr>    
                                                             <th rowspan="2" class="myCenter">सि.न </th>
                                                             <th rowspan="2" class="myCenter">कार्यक्रमको बिषयगत क्षेत्रको किसिम</th>
                                                             <th rowspan="2" class="myCenter">कार्यक्रमको शिर्षकगत किसिम:</th>
                                                             <th rowspan="2" class="myCenter">कुल संख्या  :</th>
                                                             <th colspan="4" class="myCenter">विनियोजन रु.</th>
                                                             <th rowspan="2" class="myCenter">खर्च भएको रकम </th>
                                                             <th rowspan="2" class="myCenter">बाकी रकम </th>
                                                            
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
                                                   $data_array=get_remaining_amount_mainreport1($topic_area_id,$topic_selected->id,$type,$_GET['ward_no']);
                                              if(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])==0)
                                              {
                                                  continue;
                                              }
                                                  ?>

                                                         <tr>
                                                              <td><?php echo convertedcit($i);?></td>
                                                             <td><?php echo Topicarea::getName($topic_area_id);;?></td>
                                                             <td><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']));?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_GET['ward_no']))); ?></td>
                                                             <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])));?></td>
                                                              <td><?php echo convertedcit(placeholder($data_array['total_expenditure_till_now']));?></td>
                                                               <td><?php echo convertedcit(placeholder($data_array['total_remaining_program_budget']));?></td>
                                                          </tr>
                                                  <?php $i++;
                                                  $first_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("first",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $second_total +=Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("second",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $third_total += Plandetails1::get_total_investment_of_chaumasik_topic_area_type_id("third",$topic_selected->id,$type,$_GET['ward_no']);
                                                  $total_net_amount +=$data_array['total_expenditure_till_now'];
                                                  $remaining_amount +=$data_array['total_remaining_program_budget'];
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
                                                   $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
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
                                               <?php endif;?>
                                              
                         </div>
       <?php } 
        else 
           {  
                    if($_GET['type']==1)
                    {
                        $name="कार्यक्रम अन्तर्गत ";
                    }
                    else
                    {
                        $name="योजना अन्तर्गत ";
                    }
                    $fiscal_id= Fiscalyear::find_current_id();
                    $topic_area_id=$_GET['topic_area_id'];
                    $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_GET['ward_no']);
                   // $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
           ?>
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>   
                    
                   <table class="table table-bordered table-responsive mytable"> 
                       <div class="subjectboldright"><b><?php echo $name; if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></div>
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
                                         <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_GET['ward_no']);  
                         
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                   if(empty($_GET['ward_no']))
                                   {
                                       $sql = "select * from plan_details1 where type=$type  and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;    
//                                       echo $sql;
                                   }
                                   else
                                   {
                                       $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;    
//                                       echo $sql;
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
                                                                            $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                            if(!empty($budget))
                                                                            {
                                                                                $net_payable_amount =$budget->total_expenditure;
                                                                                $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                            }
                                                                            else{ 
                                                                                     if(empty($contract_result))
                                                                                          { $data->investment_amount = get_investment_amount($data->id);    
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
                                                                     <td><?= convertedcit(placeholder($total3)) ?></td>
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

                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->