<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(0);
$mode=getUserMode();
$user = getUser();
$max_ward = Ward::find_max_ward_no();
$topic_result = Topicarea::find_all();
$budget_result=  Topicbudget::find_all();
//print_r($budget_result);exit;
$fiscals=  Fiscalyear::find_all();
if(isset($_POST['submit']))
{
    ini_set('max_execution_time', 300);
    if($_POST['type']==0)
    {
        $name=" योजनाको ";
    }
    else
    {
        $name = " कार्यक्रमको ";
    }
    if($_POST['format']==1)
    {
        $topic = " बिषयगत क्षेत्र ";
    }
    else
    {
        $topic = " बजेट उपशीर्षक ";
    }
    if(!empty($_POST['ward_no']))
    {
        $ward = "वडा नं ".convertedcit($_POST['ward_no'])." को ";
    }
    else
    {
        $ward="";
    }
}
?>

<?php include("menuincludes/header.php"); ?>
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
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">चौमासिक खर्च रिपोर्ट हेर्नुहोस /<a href="anusuchi_dashboard.php" class="btn">पछि जानुहोस </a></h2>
           <div class="OurContentFull">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <form method="post">
                    <div class="inputWrap">
                                <div class="titleInput">आर्थिक वर्ष </div>
                                <div class="newInput">
                                    <select id="fiscal_id" required name="fiscal_id">
                                        <option value="">--छान्नुहोस्--</option>
                                        <?php foreach($fiscals as $fiscal):
//                        print_r($data);?>
                                        <option value="<?php echo $fiscal->id;?>" <?php if($fiscal->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($fiscal->year);?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            <div class="titleInput">किसिम छान्नुहोस्:</div>
                            <div class="newInput"><select name="type" required>
                                                <option value="">--छान्नुहोस्--</option>
                                                <option value="0"<?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
                                                <option value="1"<?php if($type==1){ echo 'selected="selected"';}?>>कार्यक्रम</option>
                                        </select></div>
                                <div class="titleInput">छान्नुहोस्</div>
                                <div class="newInput"><select name="format" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                   <option value="1" <?php if($type==1){?>selected="selected"<?php } ?>>बिषयगत क्षेत्र</option>
                                                    <option value="2" <?php if($type==2){?>selected="selected"<?php } ?>>बजेट उपशीर्षक</option>
                                                    </select></div>
                               <div class="titleInput">वार्ड छान्नुहोस् :</div>
                                       <?php if($mode=="user"):?> 
                                          <div class="newInput"><select name="ward_no">
                                               <option value="<?=$user->ward?>"><?=convertedcit($user->ward)?></option>
                                    		</select></div>
                                         <?php else:?>
                                        <div class="newInput"><select name="ward_no">
                                                <option value="">-छान्नुहोस्-</option>
                                               <?php for($i=1;$i<=$max_ward;$i++):?>
                                                <option value="<?=$i?>" <?php if($ward==$i){ echo 'selected="selected"';}?>><?=convertedcit($i)?></option>
                                    		<?php endfor;?>
                                            </select></div>
                                            <?php endif;?>
                         <div class="saveBtn myWidth100 "><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></div>
                    </div>
                         </form>
                        <?php  if(isset($_POST['submit'])):?>
                    <div class="myPrint"><a target="_blank" href="chaumasik_report_print.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $_POST['fiscal_id'];?>&type=<?php echo $_POST['type'];?>&format=<?=$_POST['format']?> ">प्रिन्ट गर्नुहोस</a>  <a  href="chaumasik_report_excel.php?ward_no=<?=$_POST['ward_no']?>&fiscal_id=<?php echo $_POST['fiscal_id'];?>&type=<?php echo $_POST['type'];?>&format=<?=$_POST['format']?>">Export to excel</a></div>
                     <br><br>
                                  <div class="ourHeader"><?php echo  $ward.$name.$topic." अनुसार " ;?>चौमासिक खर्च रिपोर्ट हेर्नुहोस </div>
                               <?php if($_POST['type']==0 && $_POST['format']==1){ ?>  
                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम</Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($topic_result as $topic){
     
                                                $first_date = get_chaumasik_date($_POST['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_POST['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_POST['fiscal_id'],12,3);
                                                // print_r($first_date);
                                                // echo "<br>";
                                                // print_r($second_date);
                                                // echo "<br>";
                                                // print_r($third_date);
                                                // exit;
                                                $total_investment = Plandetails1::get_total_investment_by_clause("topic_area_id",$topic->id,$_POST['ward_no'],$_POST['type']);
                                                $first_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,2,$_POST['ward_no'],$first_date[1],$first_date[2]);
                                                $second_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,1,$_POST['ward_no'],$second_date[1],$second_date[2]);
                                                $third_plan_amount = get_amount_chaumasik_uopabhokta_samiti("topic_area_id",$topic->id,1,$_POST['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                $first_contract_amount = get_amount_chaumasik_contract("topic_area_id",$topic->id,2,$_POST['ward_no'],$first_date[1],$first_date[2]);
                                                $second_contract_amount = get_amount_chaumasik_contract("topic_area_id",$topic->id,1,$_POST['ward_no'],$second_date[1],$second_date[2]);
                                                $third_contract_amount =  get_amount_chaumasik_contract("topic_area_id",$topic->id,1,$_POST['ward_no'],$third_date[1],$third_date[2]);
                                               
                                                $total_first_amount = $first_plan_amount + $first_contract_amount;
                                                $total_second_amount = $second_plan_amaount + $second_contract_amount;
                                                $total_third_amount = $third_plan_amount + $third_contract_amount;
                                                 $total_expenditure= $total_first_amount + $total_second_amount + $total_third_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                            <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($total_first_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_second_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_third_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                               <?php }
                               elseif($_POST['type']==0 && $_POST['format']==2){?>
                                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>बजेट उपशीर्षगत क्षेत्रको किसिम </Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($budget_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_POST['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_POST['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_POST['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("budget_id",$topic->id,$_POST['ward_no'],$_POST['type']);
//                                               echo $total_investment;exit;
                                                $first_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,2,$_POST['ward_no'],$first_date[1],$first_date[2]);
                                                $second_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,1,$_POST['ward_no'],$second_date[1],$second_date[2]);
                                                $third_plan_amount = get_amount_chaumasik_uopabhokta_samiti("budget_id",$topic->id,1,$_POST['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                $first_contract_amount = get_amount_chaumasik_contract("budget_id",$topic->id,2,$_POST['ward_no'],$first_date[1],$first_date[2]);
                                                $second_contract_amount = get_amount_chaumasik_contract("budget_id",$topic->id,1,$_POST['ward_no'],$second_date[1],$second_date[2]);
                                                $third_contract_amount =  get_amount_chaumasik_contract("budget_id",$topic->id,1,$_POST['ward_no'],$third_date[1],$third_date[2]);
                                               
                                                $total_first_amount = $first_plan_amount + $first_contract_amount;
                                                $total_second_amount = $second_plan_amaount + $second_contract_amount;
                                                $total_third_amount = $third_plan_amount + $third_contract_amount;
                                                 $total_expenditure= $total_first_amount + $total_second_amount + $total_third_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                             <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($total_first_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_second_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_third_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                <?php }else{ ?>
                                   
                                  <?php if($_POST['type']==1 && $_POST['format']==1){ ?>  
                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>कार्यक्रम/आयोजनाको बिषयगत क्षेत्रको किसिम</Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($topic_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_POST['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_POST['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_POST['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("topic_area_id",$topic->id,$_POST['ward_no'],$_POST['type']);
//                                               echo $total_investment;exit;
                                                $first_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,2,$_POST['ward_no'],$first_date[1],$first_date[2]);
                                                $second_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,1,$_POST['ward_no'],$second_date[1],$second_date[2]);
                                                $third_program_amount = get_chaumasik_expenditure_program("topic_area_id",$topic->id,1,$_POST['ward_no'],$third_date[1],$third_date[2]);
                                                
                                                 $total_expenditure= $first_program_amount + $second_program_amount + $third_program_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                            <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($first_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($second_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($third_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>
                               <?php }
                               elseif($_POST['type']==1 && $_POST['format']==2){?>
                                  <table class="table table-bordered table-responsive table-hover">
                                            <tr class="title_wrap">
                                                    <td>क्र.सं.</td>
                                                    <td  class="myCenter"><Strong>बजेट उपशीर्षगत क्षेत्रको किसिम </Strong></td>
                                                    <td  class="myCenter"><Strong>विनियोजित रकम </Strong></td>
                                                    <td  class="myCenter"><Strong>प्रथम चौमासिक </Strong></td>
                                                    <td  class="myCenter"><Strong>दोस्रो चौमासिक</Strong> </td>
                                                    <td class="myCenter"><Strong>तेस्रो चौमासिक</Strong></td>
                                                    <td class="myCenter"><Strong>जम्मा खर्च</Strong></td>
                                                    <td class="myCenter"><Strong>बाकी रकम</Strong></td>
                                                    <td class="myCenter"><Strong>कैफियत</Strong></td>
                                            </tr>
                                            <?php $i=1; foreach($budget_result as $topic){
     
                                                 $first_date = get_chaumasik_date($_POST['fiscal_id'],4,7);
                                                $second_date = get_chaumasik_date($_POST['fiscal_id'],8,11);
                                                $third_date = get_chaumasik_date($_POST['fiscal_id'],12,3);
                                                $total_investment = Plandetails1::get_total_investment_by_clause("budget_id",$topic->id,$_POST['ward_no'],$_POST['type']);
//                                               echo $total_investment;exit;
                                                $first_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,2,"",$first_date[1],$first_date[2]);
                                                $second_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,1,"",$second_date[1],$second_date[2]);
                                                $third_program_amount = get_chaumasik_expenditure_program("budget_id",$topic->id,1,"",$third_date[1],$third_date[2]);
                                                
                                              
                                                 $total_expenditure= $first_program_amount + $second_program_amount + $third_program_amount;
                                                $remaining_amount = $total_investment - $total_expenditure;
                                                ?>
                                             <tr>
                                                 <td><?=  convertedcit($i)?></td>
                                                   <td><?=$topic->name?></td>
                                                   <td><?=convertedcit(placeholder($total_investment))?></td>
                                                   <td><?=convertedcit(placeholder($first_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($second_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($third_program_amount))?></td>
                                                   <td><?=convertedcit(placeholder($total_expenditure))?></td>
                                                   <td><?=convertedcit(placeholder($remaining_amount))?></td>
                                                   <td>&nbsp;</td>
                                             </tr>
                                            <?php $i++;
                                            
                                            } ?>
                                              </table>  
                                   
                                   
                <?php } } ?>
                        <?php endif;?>
                                 
                                                  </div>
           </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>