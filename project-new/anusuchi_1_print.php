<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$counted_result = getOnlyRegisteredPlans();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$topic_area_agreement= Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
    $topic_area_agreement_id=$_GET['topic_area_agreement_id'];
    $result=getPlanArray($topic_area_agreement_id,$_GET['ward_no']);

?>
<?php include("menuincludes/header1.php"); ?>
<?php

?>
<body>

  <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
         <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
         <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>   
                                  
                                           <div style="text-align:center;">
            <div class="ourHeader"><?php if(empty($_GET['ward_no'])){ echo "अनुसूची रिपोर्ट हेर्नुहोस ";}else{ echo "वडा नं ".convertedcit($_GET['ward_no'])." को अनुसूची रिपोर्ट हेर्नुहोस"; }?></div>
                            <table class="table table-bordered mytable myWidth100">
                                                <tr>
                                                  <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > कार्यक्रम/क्रियाकलाप</td>
                                                  <td rowspan="2">एकाई</td>
                                                  <td colspan="3">आयोजनाको    कुल<br>
                                                  क्रियाकलापको</td>
                                                  <td colspan="2">सम्पूर्ण    कार्यमध्ये गत<br>
                                                  आ.व. सम्मको</td>
                                                  <td colspan="3">वार्षिक    लक्ष्य</td>
                                                  <td colspan="3">प्रथम    चौमासिक </td>
                                                  <td colspan="3">दोस्रो    चौमासिक </td>
                                                  <td colspan="3">तेस्रो    चौमासिक</td>
                                                  <td rowspan="2"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                  <td>परिमाण </td>
                                                  <td>लागत </td>
                                                  <td>भार</td>
                                                  <td>भारित<br>
                                                  प्रगती</td>
                                                  <td>परिमाण    लागत भार</td>
                                                  <td>परिमाण</td>
                                                  <td> भार </td>
                                                  <td>बजेट</td>
                                                  <td>परिमाण</td>
                                                  <td> भार </td>
                                                  <td>बजेट</td>
                                                  <td>परिमाण</td>
                                                  <td> भार </td>
                                                  <td>बजेट</td>
                                                  <td>परिमाण</td>
                                                  <td> भार </td>
                                                  <td>बजेट</td>
                                                </tr>
                                               
    <?php $i=1;
//    $topic_area_investment_array=array();
     $total_count=0;
    $total_investment=0;
    $total_var =0;
    $total_first_chaumasik_count=0;
    $total_second_chaumasik_count=0;
    $total_third_chamasik_count=0;
     $total_first_chaumasik_anudan=0;
     $total_second_chaumasik_anudan=0;
     $total_third_chaumasik_anudan=0;
     $total_first_vaar=0;
    $total_second_vaar=0;
    $total_third_vaar=0;
    foreach($topic_area as $topic){    
        if(!empty($result[$topic->id])){
            $investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$result[$topic->id]));
        }
        else{
            $investment=0;
        }
        $count=count($result[$topic->id]);
        $total_investment=  Plandetails1::get_total_investment_by_topic_area_agreement_id($topic_area_agreement_id,$_GET['ward_no']);
//        echo $investment;exit;
        $vaar =($investment/$total_investment)*100;
        $first_chaumasik_anudan=  Plandetails1::get_total_investment_by_chaumasik("first",$topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        $second_chaumasik_anudan=Plandetails1::get_total_investment_by_chaumasik("second",$topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        $third_chaumasik_anudan=Plandetails1::get_total_investment_by_chaumasik("third",$topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        $topic_area_total_investment=  Plandetails1::get_total_investment_by_topic_area_id_and_agreement($topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        if($investment!=0){
	        $first_vaar=($first_chaumasik_anudan/$investment)*100;
	        $second_vaar=($second_chaumasik_anudan/$investment)*100;
	        $third_vaar=($third_chaumasik_anudan/$investment)*100;
        }
        else
        {
        	$first_vaar=0;
        	$second_vaar=0;
        	$third_vaar=0;
        }
        $first_chaumasik_count=  Plandetails1::count_all_first_chaumasik_plan($topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        $second_chaumasik_count=  Plandetails1::count_all_second_chaumasik_plan($topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        $third_chamasik_count=  Plandetails1::count_all_third_chaumasik_plan($topic->id,$topic_area_agreement_id,$_GET['ward_no']);
        if($count==0){
        continue;
        }
        ?>
                                                <tr>
                                                    <td><?php echo convertedcit($i);?></td>
                                                  <td><?php echo $topic->name;?></td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit($count);?></td>
                                                  <td><?php echo convertedcit(placeholder($investment));?></td>
                                                  <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><?php echo convertedcit($count);?></td>
                                                  <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($investment));?></td>
                                                  <td><?php echo convertedcit($first_chaumasik_count);?></td>
                                                  <td><?php echo convertedcit(round( $first_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($first_chaumasik_anudan));?></td>
                                                  <td><?php echo convertedcit($second_chaumasik_count);?></td>
                                                  <td><?php echo convertedcit(round( $second_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($second_chaumasik_anudan));?></td>
                                                  <td><?php echo convertedcit($third_chamasik_count);?></td>
                                                  <td><?php echo convertedcit(round( $third_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($third_chaumasik_anudan));?></td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                     <?php $i++;
                                     $total_count +=$count;
                                     $total_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_first_chaumasik_count +=$first_chaumasik_count;
                                     $total_second_chaumasik_count +=$second_chaumasik_count;
                                     $total_third_chamasik_count +=$third_chamasik_count;
                                      $total_first_chaumasik_anudan +=$first_chaumasik_anudan;
                                      $total_second_chaumasik_anudan +=$second_chaumasik_anudan;
                                      $total_third_chaumasik_anudan +=$third_chaumasik_anudan;
                                      $total_first_vaar +=$first_vaar;
                                      $total_second_vaar +=$second_vaar;
                                      $total_third_vaar +=$third_vaar;
    } ?>
                                                <tr>
                                                  <td height="20" align="left">(क) </td>
                                                  <td align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td><?php echo convertedcit($total_investment);?></td>
                                                  <td><?php echo convertedcit(round($total_var, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td><?php echo convertedcit(round($total_var, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($total_investment));?></td>
                                                  <td><?php echo convertedcit($total_first_chaumasik_count);?></td>
                                                  <td><?php echo convertedcit(round($total_first_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($total_first_chaumasik_anudan));?></td>
                                                  <td><?php echo convertedcit($total_second_chaumasik_count);?></td>
                                                  <td><?php echo convertedcit(round($total_second_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($total_second_chaumasik_anudan));?></td>
                                                 <td><?php echo convertedcit($total_third_chamasik_count);?></td>
                                                   <td><?php echo convertedcit(round($total_third_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td><?php echo convertedcit(placeholder($total_third_chaumasik_anudan));?></td>
                                                <td>&nbsp;</td>
                                                </tr>
                                                <tr height="20">
                                                  <td height="20" align="left">(ख) </td>
                                                  <td align="left">प्रशासनिक    खर्च</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr height="40">
                                                  <td height="40" align="left">(ग)</td>
                                                  <td align="left" width="111"><br>
                                                  कुल जम्मा</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                              </table>
                                  

                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->