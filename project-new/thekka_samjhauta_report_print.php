<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  $mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}

$contract_result=  Contract_total_investment::find_all();
$plan_array=array();
foreach($contract_result as $data1)
{
    array_push($plan_array, $data1->plan_id);
}
$count0=count($plan_array);
$result=  Plandetails1::find_by_plan_id(implode(",", $plan_array));
    ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>उपभोक्ता समिति मार्फत सम्झौता   print page:: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                      <div class="myspacer"></div>
                    <div class="subject"><b><u>उपभोक्ता समिति मार्फत सम्झौता भएको योजनाहरु</b></u> </div>	
                                <div class="myspacer"></div>
                        <table class="table table-bordered table-responsive">
                           <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></t>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>अनुदान रु </strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong> कुल बाँकी रकम</strong></td>
                                   </tr>
                                <?php $i=1; 
                                foreach ($result as $re):
                                    //print_r($re);
                                    $baki = $re->investment_amount-$data1->bhuktani_anudan;
                               ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($re->id);?></td>
                                    <td class="myCenter"><?php echo $re->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($re->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($re->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($re->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($re->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($re->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($re->investment_amount));?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($data1->bhuktani_anudan));?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($baki));?></td>
                                </tr>
                         <?php $amount_total += $re->investment_amount;
                                $total_bhuktani += $data1->bhuktani_anudan;
                                $total_baki += $baki;
                                $i++; endforeach;?>
                        <tr>
                             <td colspan="8">जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($amount_total)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_bhuktani)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_baki)); ?></td>
                        </tr>
                     </table>
				<div class="myspacer20"></div>
<div class="oursignature">&nbsp</div><div class="myspacer"></div>
</div><!-- print page ends -->
</div><!-- userprofile table ends -->
</div><!-- my print final ends -->