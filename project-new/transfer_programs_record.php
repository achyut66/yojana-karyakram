<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user = getUser();
$datas = Plandetails1::find_by_sql("select * from plan_details1 where status=1");
$fiscals=  Fiscalyear::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area=  Topicarea::find_all();
?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना / कार्यक्रम हेर्नुहोस / <a href="index.php">ड्यासबोर्डमा जानुहोस </a></h2>
            <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <div class="ourHeader">योजना / कार्यक्रम  हेर्नुहोस </div>
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                    
                                    <th>सि नं </th>     
                                    <th> नयाँ दर्ता नं</th>
                                    <th>पुरानो दर्ता नं </th>
                                    <th>योजना / कार्यक्रमको नाम</th>
                                    <th>बिषयगत क्षेत्रको किसिम</th>
                                    <th>अनुदानको किसिम</th>
                                    <th>विनियोजन किसिम</th>
                                    <th>वार्ड नं</th>
                                    <th>अनुदान रकम (रु.)</th>
                                   
                                </tr>
                                <?php 
                                 $i=1;
                                 foreach($datas as $data):
                                ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo convertedcit($data->prev_id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td style="width:10%"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                </tr>
                         <?php $i++;endforeach;?>
                         
                     </table>
          
                    
                        


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>