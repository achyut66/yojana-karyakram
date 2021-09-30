<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
$mode=getUserMode();
$user = getUser();
$max_ward = Ward::find_max_ward_no();
//error_reporting(1);
$topic_area_agreement= Topicareaagreement::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
$budget_result=  Topicbudget::find_all();
$fiscals=  Fiscalyear::find_all();
$type="";
if(isset($_POST['submit']))
{
    ini_set('max_execution_time', 300);
    $type=$_POST['type'];
    $fiscal_id=$_POST['fiscal_id'];
}
?>

<?php include("menuincludes/header.php"); ?>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">सारांसमा रिपोर्ट हेर्नुहोस /<a href="anusuchi_dashboard.php" class="btn">पछि जानुहोस </a></h2>
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
                                <td>छान्नुहोस्</td>
                                <td><select name="type" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                   <option value="1" <?php if($type==1){?>selected="selected"<?php } ?>>बिषयगत क्षेत्र</option>
                                                    <option value="2" <?php if($type==2){?>selected="selected"<?php } ?>>बजेट उपशीर्षक</option>
                                                    </select></td>
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
                         </form>
                        <?php if(isset($_POST['submit'])):
                             if($_POST['type']==1)
                            {
                                $name="बिषयगत क्षेत्र";
                            }
                            else
                            {
                                $name="बजेट शिर्षक";
                            }?>
                    <div class="myPrint"><a target="_blank" href="sarans_expenditure_report_print.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?php echo $type;?> ">प्रिन्ट गर्नुहोस</a>  <a  href="sarans_expenditure_report_excel.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $fiscal_id;?>&type=<?php echo $type;?> ">Export to excel</a></div>
                     <br><br>
				  <div class="ourHeader"><?php if(empty($_POST['ward_no'])){ echo $name." अनुसार सारांसमा रिपोर्ट हेर्नुहोस ";}else{ echo "वार्ड नं ".convertedcit($_POST['ward_no'])." अन्तर्गत ".$name."को  सारांसमा रिपोर्ट हेर्नुहोस ";}?></div>
                                  <?php if($_POST['type']==1){?>
                  <table class="table table-bordered table-responsive mytable">
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
//    $topic_area_investment_array=array();
    $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
    foreach($topic_area as $topic){    
//        echo $topic->id;exit;
            $count=  Plandetails1::count_by_topic_area_id($topic->id,$_POST['fiscal_id'],$_POST['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_topic_area_id($topic->id,$_POST['fiscal_id'],$_POST['ward_no']);
            $total_investment=  Plandetails1::get_total_investment();
            $amount=get_total_expenditure_from_ekmusta_budget("topic_area_id",$topic->id,$_POST['fiscal_id'],$_POST['ward_no']);
            if($amount==0)
            {
                $kharcha_amount=0;
                $vaar=0;
            }
//            9801515015 biplop anand
            else
            {
                
                $kharcha_amount = $amount;
                $vaar=($kharcha_amount/$investment) *100;
            }
            
        ?>
                                                <tr>
                                                        <td><?php echo convertedcit($i);?></td>
                                                        <td><?php echo $topic->name;?></td>
                                                        <td>वटा</td>
                                                        <td><?php echo convertedcit($count);?></td>
                                                        <td><?php echo convertedcit(placeholder($investment));?></td>
                                                        <td><?php echo convertedcit($kharcha_amount);?></td>
                                                        <td><?php echo convertedcit(round( $vaar, 2, PHP_ROUND_HALF_UP));?> %</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                     <?php $i++;
                                     $total_count +=$count;
                                     $final_investment +=$investment;
                                     $total_var +=$vaar;
                                     $total_kharcha+=$kharcha_amount;
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    } ?>
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
                                  <?php }else{?>
                  <table class="table table-bordered table-responsive mytable">
                                                <tr>
                                                    <td rowspan="2" >क्र.सं.</td>
                                                  <td rowspan="2" > बजेट उपशीर्षगत क्षेत्रको किसिम  </td>
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
//    $topic_area_investment_array=array();
    $total_count=0;
    $final_investment=0;
    $total_var =0;
    $total_kharcha=0;
    foreach($budget_result as $data){    
        
            $budget_id=  Topicbudgetprofile::find_by_budget_topic_id($data->id);
        if(empty($budget_id))
        {
           continue; 
        }
            $count=  Plandetails1::count_by_budget_id($data->id,$_POST['fiscal_id'],$_POST['ward_no']);
            $investment=  Plandetails1::get_total_investment_by_only_budget_id($data->id,$_POST['fiscal_id'],$_POST['ward_no']);
            $total_investment=  Plandetails1::get_total_investment($_POST['ward_no']);
            $amount=get_total_expenditure_from_ekmusta_budget("budget_id",$data->id,$_POST['fiscal_id'],$_POST['ward_no']);
            //echo $amount;exit;
            if($amount==0)
            {
                $kharcha_amount=0;
                $vaar=0;
            }
            else
            {
                $kharcha_amount=$amount;
                $vaar=($kharcha_amount/$investment) *100;
            }
        ?>
                                                <tr>
                                                    <td><?php echo convertedcit($i);?></td>
                                                  <td><?php echo $data->name;?></td>
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
                                     $total_vaar=($total_kharcha/$final_investment)*100;
    } ?>
                                                <tr>
                                                    <td colspan="2"align="left">जम्मा</td>
                                                  <td>वटा</td>
                                                  <td><?php echo convertedcit($total_count);?></td>
                                                  <td><?php echo convertedcit(placeholder($final_investment));?></td>
                                                 <td><?php echo convertedcit(placeholder($total_kharcha));?></td>
                                                    <td><?php echo convertedcit(round( $total_vaar, 2, PHP_ROUND_HALF_UP));?>
                                                    <td>&nbsp;</td> 
                                                  <td>&nbsp;</td>
                                                </tr>
                                                
                                              </table>
                                  <?php }?>
                                  <?php endif;?>
                                                  </div>
           </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>