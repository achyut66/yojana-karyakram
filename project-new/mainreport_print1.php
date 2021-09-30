<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>

 <?php
$type=$_GET['type'];
 $topic_area_id=$_GET['topic_area_id'];
 $topic_area_type_id=$_GET['topic_area_type_id'];
 $fiscal_id= Fiscalyear::find_current_id();
 $ward_no= $_GET['ward'];
 if(empty($ward_no))
 {
     $sql="select * from plan_details1 where type=".$_GET['type']." and topic_area_id={$topic_area_id} and topic_area_type_id=".$_GET['topic_area_type_id'];
 
 }
 else
 {
    $sql="select * from plan_details1 where ward_no=".$ward_no." and type=".$_GET['type']." and topic_area_id={$topic_area_id} and topic_area_type_id=".$_GET['topic_area_type_id'];
     
 }
 $result=  Plandetails1::find_by_sql($sql);
 
 ?>
<?php
if(empty($ward_no))
{
    $data1= Planamountwithdrawdetails::find_all();

}
 else 
 {
     $data1= get_wardwise_result_sql($ward_no,"plan_amount_withdraw_details");

 }
$final_array=array();
foreach($data1 as $data)
{
    array_push($final_array, $data->plan_id);
}
?>
<?php include("menuincludes/header1.php"); ?>

<body>
   
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
           
            	
              
            

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                
                    <h3 style="text-align: center;"><?php if(!empty($ward_no)){ echo "वडा नं ". convertedcit($ward_no). " को  ".Topicareatype::getName($_GET['topic_area_type_id']);}else{ echo Topicareatype::getName($_GET['topic_area_type_id']);};?>को रिपोर्ट</h3>
                  
                    
                    <table class="table table-bordered table-responsive">
                           <tr>   
                                    <th>सि.न </th>
                                    <th >दर्ता नं</th>
                                    <th>योजनाको नाम</th>
                                    <th>योजनाको बिषयगत क्षेत्रको किसिम</th>
                                    <th>योजनाको शिर्षकगत किसिम:</th>
                                    <th>योजनाको उपशिर्षकगत किसिम:</th>
                                    <th>योजनाको विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                      <th>हाल सम्म लागेको भुक्तानी</th>
                                    <th> कुल बाँकी रकम</th>
                                   
                                </tr>
                                <?php $i=1; 
                                $total_investment0=0;
                                $total_net_payable_amount=0;
                                $total_remaining_amount=0;
                                foreach($result as $data):
                                        // भुक्तानी दिन बाँकी रकम
                                    if(in_array($data->id, $final_array))
                                    {
                                        $net_payable_amount=$data->investment_amount;
                                         $remaining_amount=0; 
                                    }
                                    else
                                    {
                                         $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                    }
                               ?>
                                <tr>
                                      <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><?php echo convertedcit($net_payable_amount);?></td>
                                      <td><?php echo convertedcit($remaining_amount);?></td>
                                   
                                </tr>
                         <?php $i++; 
                         $total_investment0 +=$data->investment_amount;
                          $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment0)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
   
