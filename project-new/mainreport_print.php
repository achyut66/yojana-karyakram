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
$format="";
$type="";
$topic_area_id=$_GET['topic_area_id'];
$fiscal_id=$_GET['fiscal_id'];
$type=$_GET['type'];
$ward = $_GET['ward_no'];
 $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic_area_id);
   

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
            <!--<h2 class="headinguserprofile"> अन्ग्सिक मुख्य रिपोर्ट हेर्नुहोस  </h2>-->
            
         
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
            
				

        
                                  
                                           <div style="text-align:center;">
                                               <?php if($type==0 ):?>
                                              <table class="table table-bordered table-hover">
                                                    <tr>
                                                        <td colspan="7" style="text-align: center;"><b>योजना अन्तर्गत <?php if(!empty($ward)){ echo "वडा नं ". convertedcit($ward). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></td>
                                                    </tr>
                                                         <tr class="title_wrap">    
                                                            
                                                             <td class="myCenter"><strong>सि.न </strong></td>
                                                             <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                                             <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                                             <td class="myCenter"><strong>कुल संख्या </strong></td>
                                                             <td class="myCenter"><strong>कुल अनुदान रु </strong></td>
                                                              <td class="myCenter"><strong>खर्च भएको रकम </strong></td>
                                                             <td class="myCenter"><strong>बाकी रकम</strong> </td>
                                                            </tr>
                                              <?php            
                                              $i=1;
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
                                                         ?>
                                                         <tr>
                                                              <td class="myCenter" ><?php echo convertedcit($i);?></td>
                                                             <td class="myCenter"><?php echo Topicarea::getName($topic_area_id);?></td>
                                                             <td class="myCenter"><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td class="myCenter"><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder($total_net_payable_amount));?></td>
                                                               <td class="myCenter"><?php echo convertedcit(placeholder($remaining_net_investment));?></td>
                                                             </tr>
                                                  <?php $i++; 
                                                  $total_payable +=$total_net_payable_amount;
                                                  $remaining_payable +=$remaining_net_investment;
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);  
                                                  $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
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
                                            <table class="table table-bordered table-hover">
                                                 <tr>
                                                        <td colspan="7" style="text-align: center;"><b>कार्यक्रम अन्तर्गत <?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".Topicarea::getName($_GET['topic_area_id']);}else{ echo Topicarea::getName($_GET['topic_area_id']);};?>को रिपोर्ट हेर्नुहोस </b></td>
                                                    </tr>
                                                         <tr class="title_wrap">    
                                                             <td class="myCenter"><strong>सि.न </strong></td>
                                                             <td class="myCenter"><strong>कार्यक्रमको बिषयगत क्षेत्रको किसिम</strong></td>
                                                             <td class="myCenter"><strong>कार्यक्रमको शिर्षकगत किसिम</strong></td>
                                                             <td class="myCenter"><strong>कुल संख्या </strong></td>
                                                             <td class="myCenter"><strong>कुल अनुदान रु </strong></td>
                                                             <td class="myCenter"><strong>खर्च भएको रकम </strong></td>
                                                             <td class="myCenter"><strong>बाकी रकम </strong></td>
                                                         </tr>
                                              <?php            
                                              $i=1;
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
                                                              <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                             <td class="myCenter"><?php echo Topicarea::getName($topic_area_id);;?></td>
                                                             <td class="myCenter"><?php echo $topic_selected->topic_area_type;?></td>
                                                             <td class="myCenter"><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']));?></td>
                                                             <td class="myCenter"><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no'])));?></td>
                                                              <td class="myCenter"><?php echo convertedcit(placeholder($data_array['total_expenditure_till_now']));?></td>
                                                               <td class="myCenter"><?php echo convertedcit(placeholder($data_array['total_remaining_program_budget']));?></td>
                                                         </tr>
                                                  <?php $i++;
                                                  $total_net_amount +=$data_array['total_expenditure_till_now'];
                                                  $remaining_amount +=$data_array['total_remaining_program_budget'];
                                                  $total_count +=Plandetails1::count_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
                                                   $total_investment +=Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id,$type,$_GET['ward_no']);
                                                  endforeach;?>
                                                        <tr>
                                                                 <td colspan="2">&nbsp; </td>     
                                                          <td>जम्मा </td>
                                                          <td ><?php echo convertedcit(placeholder($total_count)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($total_net_amount)); ?></td>
                                                          <td ><?php echo convertedcit(placeholder($remaining_amount)); ?></td>
                                                          </tr> 
                                          </table>
                                               <?php endif;?>
                                             
                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->