<?php require_once("includes/initialize.php");
 error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$data1=  Plandetails1::find_by_id($_GET['id']);
$data2=  Plantotalinvestment::find_by_plan_id($_GET['id']);
$data3= Moreplandetails::find_by_plan_id($_GET['id']);
//print_r($data3); exit;
$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$max_period = NapiLagatProfile::find_max_period($_GET['id']);
$profile_details = EstimateLagatProfile::find_by_plan_id($_GET['id']);
$napi_total_rate = Napilagatanuman::find_total_rate_by_plan_id_period($_GET['id'],$max_period);
//echo $napi_total_rate; exit;
$estimate_grand_total = $profile_details->sub_total;
$deviated_amount = $napi_total_rate - $estimate_grand_total;
//echo $deviated_amount; exit;
$negative_deviation = $positive_deviation = $negative_deviation_percentage = $positive_deviation_percentage = 0;
$percentage_text = 'घटी बढीको प्रतिशत ';
if($deviated_amount<0)
{
    $negative_deviation = $deviated_amount;
    $deviation_percentage = ($negative_deviation/$estimate_grand_total)*100;
    $percentage_text = 'घटीको प्रतिशत ';
}
if($deviated_amount>0)
{
    $positive_deviation = $deviated_amount;
    $deviation_percentage = ($positive_deviation/$estimate_grand_total)*100;
    $percentage_text = 'बढीको प्रतिशत ';
}
if($deviated_amount == 0)
{
    $positive_deviation = $deviated_amount;
    $deviation_percentage = ($positive_deviation/$estimate_grand_total)*100;
    $percentage_text = 'बढीको प्रतिशत ';
}
$sql = "select * from estimate_lagat_anuman where plan_id=".$_GET['id']." order by sno asc";
$lagat_details = Estimatelagatanuman::find_by_sql($sql);

include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्य सम्पन्न प्रतिवेदन । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body onload="window.print()">
    <?php //include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                
                <div class="maincontent" >
                  
                        
                        <div class="mydate myFont10">म.ले.प. फाराम नं १७५</div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
									<h5 class="margin1em"><?php echo SITE_ADDRESS;?> </h5><br>
                                    
									<h4 class="subjectbold1 letter_subject">कार्य सम्पन्न प्रतिवेदन</h4>
<div class="textdetails">
<div class="myDate">मिति :<?= convertedcit( $_GET['final_completion_date']) ?></div>	
<div>आर्थिक बर्ष :&nbsp;&nbsp;  <?= convertedcit($fiscal->year)?></div>	
<div   class="myDate">ईष्टमेट भन्दा धटी  :&nbsp;&nbsp; <?=convertedcit(placeholder($negative_deviation))?></div>
<div>योजना दर्ता नं :&nbsp;&nbsp; <?= convertedcit($data1->id)?></div>	
 <div  class="myDate">ईष्टमेट भन्दा बढी  : &nbsp;&nbsp; <?=convertedcit(placeholder($positive_deviation))?></div>
<div>योजनाको नाम :- <?=$data1->program_name?></div>
<div  class="myDate"><?=$percentage_text?> : &nbsp;&nbsp; <?=convertedcit(round($deviation_percentage,2))?> %</div>

      
      <div  >ठेगाना : &nbsp;&nbsp;<?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?></div>
   
    
    
    

  
						


</div>
<div class="printContent">
										
										                                                                             
										
<table class=" myWidth100 table-bordered ">
  <tr>
    <td rowspan="2" class="mycenter">सि.नं</td>
    <td rowspan="2" class="mycenter tdWidth30">कामको विवरण</td>
    <td colspan="3" class="mycenter">ईष्टमेट बमोजिमको</td>
    <td colspan="3" class="mycenter">वास्तविक भएको कामको </td>
    <td colspan="3" class="mycenter">फरक</td>
    <td rowspan="2" class="mycenter">कैफियत </td>
  </tr>
  <tr>
    <td class="mycenter">परिमाण</td>
    <td class="mycenter">दर</td>
    <td class="mycenter">जम्मा</td>
    <td class="mycenter">परिमाण</td>
    <td class="mycenter">दर</td>
    <td class="mycenter">जम्मा</td>
    <td class="mycenter">परिमाण</td>
    <!--<td class="mycenter">दर</td>-->
    <td class="mycenter" colspan="1">घटी </td>
    <td class="mycenter" colspan="1">बढी</td>
 </tr>
<?php 
            $positive_diff = '';
            $negative_diff = '';
            $total_diff_amount = 0;
            $estimate_jamma = 0;
            $napi_jamma = 0;
            $table_sno = 1;
            foreach($lagat_details as $lagat_detail):
            $task_name = Worktopic::find_by_id($lagat_detail->task_id);
            $total_evaluation_sno = Napilagatanuman::find_total_evaluation_by_plan_id_sno_period($_GET['id'],$lagat_detail->sno,$max_period);
            $napi_task_rate     = NapiLagatAnuman::find_task_rate_by_plan_id_sno_period($_GET['id'],$lagat_detail->sno,$max_period);
            $actual_evaluated_amount = $napi_task_rate->task_rate*$total_evaluation_sno;
            $evaluated_diff = $total_evaluation_sno - $lagat_detail->total_evaluation;
            $diff_amount = round($actual_evaluated_amount - $lagat_detail->total_rate);
            $total_diff_amount += $diff_amount;
            if($diff_amount>0)
            {
                $positive_diff = $diff_amount;
            }
            elseif($diff_amount<0)
            {
                $negative_diff = $diff_amount;
            }
            else
            {
                $positive_diff = 0; $negative_diff = 0;
            }
            $estimate_jamma += $lagat_detail->total_rate;
            $napi_jamma += $actual_evaluated_amount;
?>
   <tr>
    <td><?=convertedcit($table_sno)?></td>
    <td><?=$task_name->work_name?> <br/><?=$lagat_detail->main_work_name?></td>
    <td><?=convertedcit(placeholder($lagat_detail->total_evaluation +0))?></td>
    <td><?=convertedcit(placeholder($lagat_detail->task_rate +0))?></td>
    <td><?=convertedcit(placeholder(round($lagat_detail->total_rate +0,2)))?></td>
    <td><?= convertedcit($total_evaluation_sno)?></td>
    <td><?=convertedcit(placeholder($napi_task_rate->task_rate +0))?></td>
    <td><?=convertedcit(placeholder(round($actual_evaluated_amount +0,2)))?></td>
    <td><?= convertedcit(placeholder($evaluated_diff +0))?></td>
    <td><?= convertedcit(placeholder($lagat_detail->task_rate +0))?></td>
    <td><?=convertedcit(placeholder($negative_diff +0))?></td>
    <td><?=convertedcit(placeholder($positive_diff +0))?></td>
    <td></td>
  </tr>
  <?php $table_sno++; endforeach; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>जम्मा</td>
    <td><?=convertedcit(placeholder($estimate_jamma))?></td>
    <td>&nbsp;</td>
    <td>जम्मा</td>
    <td><?=convertedcit(placeholder($napi_jamma))?></td>
    
    <td>जम्मा फरक</td>
    <td colspan="2"><?= convertedcit($total_diff_amount)?></td>
    <td>&nbsp;</td>
  </tr>
</table>
				<div class="myspacer30"></div>
										
										<div class="oursignature">सदर गर्ने</div>
										
<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
<div class="oursignatureleft " style="margin-left:150px;">जाँच गर्ने</div>
										<div class="myspacer"></div>
							  </div>
                                
                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php //include("menuincludes/footer.php"); ?>