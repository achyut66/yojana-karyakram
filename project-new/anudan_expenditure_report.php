<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$max_ward = Ward::find_max_ward_no();
$user = getUser();
$topic_area_agreement= Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();

$topic_area_agreement_id="";
if(isset($_POST['submit']))
{
    ini_set('max_execution_time', 300);
    $fiscal_id=$_POST['fiscal_id'];
    $topic_area_agreement_id=$_POST['topic_area_agreement_id'];
    $result=getPlanArrayForAnudanExpenditure($topic_area_agreement_id,$fiscal_id,$_POST['ward_no']);
}
?>

<?php include("menuincludes/header.php"); ?>
<style>
  <style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
</style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"> अनुदान अनुसार खर्च विवरण   | <a href="anusuchi_dashboard.php" class="btn">पछि जानुहोस</a></h2>
           <div class="OurContentFull">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <form method="post">
                        <table class="table table-responsive table-bordered">
                             
                             <tr>
                                 <td>आर्थिक वर्ष </td>
                                            <td>
                                                <select id="fiscal_id" name="fiscal_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($fiscals as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </td>
                                        <td>   योजना / कार्यक्रमको अनुदानको किसिम:  </td>
					<td> <select name="topic_area_agreement_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_agreement as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"<?php if($topic_area_agreement_id==$topic->id){echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            </td>
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
                                            <td><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></td>
                                          </tr>
                        
                        </table
                         ></form>
                        <?php if(isset($_POST['submit'])):?>
                    <div class="myPrint"><a target="_blank" href="anudan_expenditure_report_print.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $fiscal_id;?>&topic_area_agreement_id=<?php echo $topic_area_agreement_id;?>">प्रिन्ट गर्नुहोस</a>  <a  href="anudan_expenditure_report_excel.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $fiscal_id;?>&topic_area_agreement_id=<?php echo $topic_area_agreement_id;?>">Export to excel</a></div>
                     <br><br>
                     <div class="ourHeader"> <?php if(empty($_POST['ward_no'])){echo Topicareaagreement::getName($topic_area_agreement_id);}else{ echo "वार्ड नं ".convertedcit($_POST['ward_no'])." अन्तर्गत ".Topicareaagreement::getName($topic_area_agreement_id);}?> अनुसार खर्च विवरण   </div>
                   <table class="table table-bordered table-hover">
                                                <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम  </td>
                                                  <td rowspan="2" width="40">एकाई</td>
                                                  <td rowspan="2" >कार्यक्रम/आयोजनाको संख्या </td>
                                                  <td rowspan="2" > विनियोजित रकम </td>
                                                  <td rowspan="2">खर्च रकम</td>
                                                  <td rowspan="2">खर्च प्रतिशत</td>
                                                  <td rowspan="2" width="172"> कैफियत</td>
                                                </tr>
                                                <tr>
                                                  
                                                  
                                                </tr>
                                               
    <?php $i=1;
     $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
foreach($topic_area as $topic){
         $count=count($result[$topic->id]);
         if(!empty($result[$topic->id])){
                $investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$result[$topic->id]));
        }
        else{
            $investment=0;
        }
          $amount=get_total_expenditure_in_anudan_wise_all_plans($topic_area_agreement_id,$fiscal_id,$topic->id,$_POST['ward_no']);
         if($amount==0)
            {
                $kharcha_amount=0;
                $vaar=0;
            }
            
            else
            {
                $kharcha_amount = $amount;
                $vaar=($kharcha_amount/$investment) *100;
            }
            if($count==0)
            {
                continue;
            }
?>
                                                <tr>
                                                        <td><?php echo convertedcit($i);?></td>
                                                        <td><?php echo $topic->name;?></td>
                                                        <td>वटा</td>
                                                        <td><?php echo convertedcit($count);?></td>
                                                        <td><?php echo convertedcit(placeholder($investment));?></td>
                                                        <td><?php echo convertedcit(placeholder($kharcha_amount));?></td>
                                                        <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                     <?php $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
}                                   
                                    $total_vaar=($total_kharcha/ $final_investment)*100;
  ?>
                                                <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td><?php echo convertedcit(placeholder($final_investment));?></td>
                                                <td><?php echo convertedcit(placeholder($total_kharcha));?></td>
                                                    <td><?php echo convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                
                                              </table>
                                  <?php endif;?>
                                                  </div>
           </div>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>