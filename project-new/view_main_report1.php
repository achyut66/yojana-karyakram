<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(empty($_GET['ward']))
{
    $sql="select * from plan_details1 where type=".$_GET['type']." and topic_area_type_id=".$_GET['topic_area_type_id'];
 
}
else
{
    $sql="select * from plan_details1 where ward_no=".$_GET['ward']." and type=".$_GET['type']." and topic_area_type_id=".$_GET['topic_area_type_id'];
 
}
$result=  Plandetails1::find_by_sql($sql);
 
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">रिपोर्ट हेर्नुहोस </h2>
           
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3><?php if(!empty($_GET['ward'])){ echo "वडा नं ". convertedcit($_GET['ward']). " को  ".Topicareatype::getName($_GET['topic_area_type_id']);}else{ echo Topicareatype::getName($_GET['topic_area_type_id']);};?>को रिपोर्ट हेर्नुहोस  | <a href="mainreport.php" class="btn">पछि जानुहोस </a> </h3>
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                     <th>सि.न </th>
                                    <th >दर्ता नं</th>
                                    <th>कार्यक्रमको नाम</th>
                                    <th>कार्यक्रमको  बिषयगत क्षेत्रको किसिम</th>
                                    <th>कार्यक्रमको शिर्षकगत किसिम:</th>
                                    <th>कार्यक्रमको  विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                    <th>हाल सम्मको खर्च</th>
                                    <th>बाँकी रकम</th>
                                    <th>विवरण हेर्नुहोस </th>
                                </tr>
                                <?php 
                                $i=1;
                                
                                $total_investment_amount = 0;
                                $total_expendiutre_till_now=0;
                                $total_remaining_program_budget=0;
                                
                                foreach($result as $data):
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $expenditure_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                    
                                    $total_investment_amount += $data->investment_amount;
                                    $total_expendiutre_till_now += $expenditure_amount;
                                    $total_remaining_program_budget += $rem_budget;
                                ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><?php echo convertedcit($expenditure_amount);?></td>
                                    <td><?php echo convertedcit($rem_budget);?></td>
                                    <td><a href="program_total_view.php?id=<?=$data->id?>">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php 
                         $i++;
                      
                         endforeach;
                         ?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment_amount)); ?></td>
                              <td ><?php echo convertedcit(placeholder($total_expendiutre_till_now)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_program_budget)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>