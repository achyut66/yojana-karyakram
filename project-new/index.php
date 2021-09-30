<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
//error_reporting(1);
$url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$base_url1 = Explode("/", $url);
array_pop($base_url1);
$base_url ="https://".implode("/",$base_url1)."/";

$json1 =file_get_contents($base_url."get_yojana_report.php");
$yojana_data = json_decode($json1, true);

$yojana_array =array();
$count_array = array();
$anudan_array = array();
$kharcha_array = array();
$baki_array = array();
foreach ($yojana_data as $key => $value) {
    array_push($yojana_array,$value['yojana']);
    array_push($count_array, $value['count']);
    array_push($anudan_array,$value['anudan']);
    array_push($kharcha_array,$value['kharcha']);
    array_push($baki_array,$value['baki']);
}

$json2 =file_get_contents($base_url."get_karyakam_report.php");
$yojana_data1 = json_decode($json2, true);
$yojana_array1 =array();
$count_array1 = array();
$anudan_array1 = array();
$kharcha_array1 = array();
$baki_array1 = array();

foreach ($yojana_data1 as $key => $value) {
    array_push($yojana_array1,$value['yojana']);
    array_push($count_array1, $value['count']);
    array_push($anudan_array1,$value['anudan']);
    array_push($kharcha_array1,$value['kharcha']);
    array_push($baki_array1,$value['baki']);
}

$json3 =file_get_contents($base_url."get_yojana_bikash_report.php");
$yojana_data2 = json_decode($json3, true);
$topic_array =array();
$count_array2 = array();
foreach ($yojana_data2 as $key => $value) {
    array_push($topic_array,$value['topic']);
    array_push($count_array2, $value['count']);
}
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$samjhauta_array=$counted_result['more_detail_count_array'];

$total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $samjhauta_array));
$result=  Plandetails1::find_by_plan_id(implode(",", $samjhauta_array));
//print_r($result);
$miti = generateCurrDate();
$mode= getUserMode();
?>
<?php include("menuincludes/header.php"); ?>
<?php include("menuincludes/topwrap.php"); ?>
<?php include("menuincludes/suchana.php");?>
<html>
<style>
    #noback {
  height: 100%;
  background-image: url(images/9.jpg);
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  
}
#tala {
      height: 100%;
      background-image: url(images/9.jpg);
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
}
</style>

<div id="body_wrap_inner">
    
    <div class="maincontent">
        <h2 class="headinguserprofile">ग्राफिकल रिपोर्ट</h2>
        <div class="myMessage">
            <?php echo $message;?>
        </div>
        <div class="OurContentFull">
            <div id = "noback">
            <div class="my_chart_box">
                <div class="chart-container">
                    <canvas id="yojana_report"> </canvas>
                </div>
                <div id="yojana_detail" class="chart_detail" style="display: none">
                    <table class="chart_index borderless">
                        <?php $i=0;
                                foreach($yojana_array as $data){?>
                        <tr>
                            <td>
                                <div class="yojana_<?=$i?>"></div>
                                <?=$data?>&nbsp;(
                                <?=convertedcit($count_array[$i])?>)
                            </td>
                        </tr>
                        <?php $i++;}?>

                    </table>
                </div>
                <div class="chart_clear"></div>
            </div>
            <div class="my_chart_box">
                <div class="chart-container">
                    <canvas id="yojana_report1"> </canvas>
                </div>
                <div id="yojana_detail1" class="chart_detail" style="display: none">
                    <table class="chart_index borderless">
                        <?php $i=0;
                                        foreach($yojana_array1 as $data){ 
                                            if(empty($count_array1[$i]))
                                            {
                                                $count = 0;
                                            }
                                            else
                                            {
                                                $count =$count_array1[$i];
                                            }
                                        ?>
                        <tr>
                            <td>
                                <div class="yojana1_<?=$i?>"></div>
                                <?=$data?>&nbsp;(
                                <?=convertedcit($count)?>)
                            </td>
                        </tr>
                        <?php $i++;}?>

                    </table>
                </div>
                <div class="chart_clear"></div>
            </div>
            <div class="my_chart_box">
                <div class="chart-container">
                    <canvas id="yojana_report2"> </canvas>
                </div>
                <div id="yojana_detail2" class="chart_detail" style="display: none">
                    <table class="chart_index borderless">
                        <tr>
                            <td>
                                <div class="yojana2_1"> </div>जम्मा खर्च
                            </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="yojana2_2"> </div>हाल सम्मको खर्च
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="yojana2_3"> </div>बाकी रकम
                        </td>

                        </tr>

                    </table>
                </div>
                <div class="chart_clear"></div>
            </div>
            <div class="my_chart_box">
                <div class="chart-container">
                    <canvas id="yojana_report3"> </canvas>
                </div>
                <div id="yojana_detail3" class="chart_detail" style="display: none; margin-top: -40px;">
                    <table class="chart_index borderless">

                        <?php $i=0;
                                    foreach($topic_array as $data){ 
                                    ?>
                        <tr>

                            <td>
                                <div class="yojana3_<?=$i?>"></div>
                                <?=$data?>&nbsp;(
                                <?=convertedcit($count_array2[$i])?>)
                            </td>

                        </tr>
                        <?php $i++;}?>

                    </table>
                </div>
                <div class="chart_clear"></div>
            </div>
            </div>
         <div class="chart_clear"></div>
    </table> 
<div class="card text-center">
  <div class="card-header">
   <h2>म्याद थप गर्नु पर्ने सम्झौता भएका योजना हरु </h2>
  </div>
      <div id = "tala">
  <div class="card-body">
    <table class="table table-hover table-bordered table-responsive table-striped" style="background-color:white">
                        <thead>
                        <tr>
                            <th>सी.नं.</th>
                            <th>योजनाको नाम</th>
                            <th>दर्ता नं</th>
                            <th>योजना शुरू हुने मिति</th>
                            <th>योजना सकिने मिति</th>
                            <th>योजना सम्झौता मिति</th>
                            <th>उपभोक्ता समितिको (अध्यक्षको नाम)</th>
                            <th>मोबाइल नं</th>
                            <th>सम्झौता अनुसारको मिति सकिन बाकी दिन</th>
                        </tr>
                        </thead>
                        <tbody>
                             
                            <?php $i = 1; foreach($result as $data):
                            $samjhauta_plan = Moreplandetails::find_by_plan_id($data->id);
                            $name = Costumerassociationdetails::find_by_plan_id_post_id($data->id,1);
                            //$date1 = $samjhauta_plan->yojana_sakine_date;
                            $miti_days = Moreplandetails::find_by_plan_id($data->id);//print_r($miti_days);
                            //print_r($miti_days);
                            $date1 = $miti_days->yojana_sakine_date;
                             ?>
                             <?php
                                $datetime1 = new DateTime("$date1");

                                $datetime2 = new DateTime("$miti");
                                
                                $difference = $datetime1->diff($datetime2);
                            ?>
                        <tr>
                            <td><?php echo convertedcit($i);?></td>
                            <td><?php echo $data->program_name;?></td>
                            <td><button type="button" class="darta_id btn-info" ><?php echo convertedcit($data->id);?></button></td>
                            <td><?php echo convertedcit($samjhauta_plan->yojana_start_date);?></td>
                            <td><?php echo convertedcit($samjhauta_plan->yojana_sakine_date);?></td>
                            <td><?php echo convertedcit($samjhauta_plan->miti);?></td>
                            <td><?php echo $name->name;?></td>
                            
                            <td>
                                <input type = "hidden" name="mobile" value = "<?php echo $name->mobile_no?>" id="mobile">
                                <input type = "hidden" name="mobile" value = "<?php echo $data->program_name?>" id="prgrm_name">
                                <input type = "hidden" name="mobile" value = "<?php echo convertedcit($samjhauta_plan->miti)?>" id="miti">
                                <input type = "hidden" name="name" value = "<?php echo $name->name?>" id= "name">
                                
                                <button type="btn" class="mobile btn-info" value="<?php echo convertedcit($name->mobile_no);?>" id="<?php echo $name->mobile_no?>"><?php echo convertedcit($name->mobile_no);?></button></td>
                            <td>
                            <?php if($datetime1 <= $datetime2){
                                 echo convertedcit($difference->days); echo "<div style='background-color:red;'>दिन सकिएको</div>";
                            }else{
                                 echo convertedcit($difference->days); echo "<div style='background-color:green;'>दिन बाँकी</div>";
                            }?>
                                <input type = "hidden" name="mobile" value = "<?php echo convertedcit($difference->days)?>" id="diff">
                            </td>
                        </tr>
                        </tbody>
                         <?php  $i++;endforeach;?>
                    </table>
  </div>
  <div class="card-footer text-muted">
    <p style="color:white">म्याद सकिएको योजनाको उपभोक्ता समिति अध्यक्ष ज्यु लाई म्यासेज पठाउनु पर्ने भए दर्ता नं मा Click गर्नुहोला !!!</p>
    <div class="text-right">
    <button class="button btn-info"><a href="http://beta.thesmscentral.com/">SMS Panel</a></button>
    </div> 
</div>
</div>
    
</div><!-- main menu ends -->
<script src="js/graphical.js"></script>
</div><!-- top wrap ends -->
    </div>
</div>
</html>
<?php include("menuincludes/footer.php"); ?>
<script>
JQ(document).ready(function(){
    JQ(document).on("click",".darta_id",function() {
        var mobile_no = JQ(this).closest('tr').find('#mobile').val();
        var prgrm_name = JQ(this).closest('tr').find('#prgrm_name').val();
        var miti = JQ(this).closest('tr').find('#miti').val();
        var name = JQ(this).closest('tr').find('#name').val();
        var diff = JQ(this).closest('tr').find('#diff').val();
        JQ.ajax({
           method:"POST",
           data:{mobile_no:mobile_no,prgrm_name:prgrm_name,miti:miti,name:name,diff:diff},
           url:'date_check_sms.php',
           success: function(resp) {
               console.log(resp);
               //ajaxResult.push(resp);
                current_balance = resp.current_balance;
                    alert('Success');
                    //alert(current_balance);
                    //exit;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status); // I would like to get what the error is
                }
        });
    });   
});
</script>