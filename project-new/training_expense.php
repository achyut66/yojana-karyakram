<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
  $plan_id = $_GET['id'];
  $program_id = $_GET['id'];
  $sn_result= Programmoredetails::find_by_program_id($program_id);
  $sn_result_expense = TrainingExpense::find_by_program_id($plan_id);
  $sn_array= array();
  $sn_array_payment= array();
   $sn_array_payment_final= array();
  foreach ($sn_result as $sn):
	  $sn1=$sn->sn;
	  array_push($sn_array,$sn1);
  endforeach;
   foreach ($sn_result_expense as $sn):
	  $sn2=$sn->sn;
	  array_push($sn_array_payment,$sn2);
  endforeach;
   
 
 $sn_result1= array_diff($sn_array,$sn_array_payment);
 $sn_result2 = array_unique($sn_array);
 //print_r($sn_result2);exit;
 
$program_id= $_GET['id'];
if(isset($_POST['submit']))
{
    $i = 0;
    $result_details                     = TrainingExpense::find_by_program_id_and_sn($_GET['id'],$_POST['sn_sel']);
    if(!empty($result_details))
    {
        foreach($result_details as $result)
        {
            $result->delete();
        }
    }
    foreach($_POST['description'] as $description)
    {
        
        $training_expense               = new TrainingExpense;
        $training_expense->description  = $description;
        $training_expense->quantity     = $_POST['quantity'][$i];
        $training_expense->rate         = $_POST['rate'][$i];
        $training_expense->unit         = $_POST['unit'][$i];
        $training_expense->total        = $_POST['total'][$i];
        $training_expense->remarks      = $_POST['remarks'][$i];
        $training_expense->plan_id      = $_GET['id'];
        $training_expense->sn           = $_POST['sn_sel'];
        $training_expense->save();
        $i++;
    }
    echo alertBox("सेभ गर्न सफल", "training_expense.php?id=".$_GET['id']);
            
}
if(isset($_GET['submit']))
{
    // echo 'here';exit;
    $sql_expense = "select * from training_expense where plan_id ='".$_GET['id']."' and sn='".$_GET['sn_selected']."'";
    $expense_details   = TrainingExpense::find_by_sql($sql_expense);
    $grand_total       = TrainingExpense::find_grand_total_by_plan_id($_GET['id'],$_GET['sn_selected']);
    if(empty($grand_total))
    {
        $grand_total = 0;
    }
    $a=1;
}
  
    
    $units = Units::find_all();
?>
<?php include("menuincludes/header.php");
include("menu/header_script.php");?>
<!-- js ends -->
<title>कार्यक्रमको कुल लागत:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रमको कुल लागत अनुमान | दर्ता न:<?=convertedcit($_GET['id'])?>  / <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछी जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                        <?php echo $message; ?>
                        
                        <form method="get">
                            <table class="table table-bordered table-hover">
                                <tr>
                                       <td >कर्यादेस न:</td>
                                          <td >
                                                <select id="sn_payment" name="sn_selected">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($sn_result2 as $sn):?>
                                                    <option value="<?= $sn ?>"><?= $sn ?></option>
                                                    <?php endforeach; ?>
                                                </select> 
                                                <input type="hidden" name='id' value="<?= $program_id ?>" id="program_id">
                                         </td>
                                 </tr>
                                   <tr colspan="8" class="enlist1">
                                            
                                   </tr>
                                   <tr>
                                       <th style="text-align:center;" colspan="2"><input class="btn" name="submit" type="submit" value="खोज्नुहोस"></th>
                                   </tr>
                            </table>
                        </form>  
                        
          <?php if($a==1): ?> 
                        
                    <form method="post">
                        <table class="table table-bordered table-responsive">
                                <tr>
                                    <th>क्र.स.</th>
                                    <th>विवरण</th>
                                    <th>एकाई</th>
                                    <th>दर</th>
                                    <th>परिमाण</th>
                                    <th>जम्मा</th>
                                    <th>कैफियत</th>
                                </tr>
                                <?php
                                    if(!empty($expense_details))
                                    {
                                        $i=1;
                                        foreach($expense_details as $result)
                                        {
                                ?>
                                <tr>
                                    <td class="sn max_sn"><?=convertedcit($i)?></td>
                                    <td><input type="text" name="description[]" class="form-control" value="<?=$result->description?>" required></td>
                                    <td>
                                        <select name="unit[]" id="unit_<?=$i?>">
                                            <option value="छान्नुहोस"></option>
                                            <?php foreach($units as $unit){?>
                                            <option value="<?=$unit->id?>" <?php if($result->unit == $unit->id){echo 'selected="selected"';} ?>><?=$unit->name?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="rate[]" id="rate_<?=$i?>" value="<?=$result->rate?>" required></td>
                                    <td><input type="text" name="quantity[]" id="quantity_<?=$i?>" value="<?=$result->quantity?>" required></td>
                                    <td><input type="text" name="total[]" id="total_<?=$i?>" value="<?=$result->total?>" readonly="true" required></td>
                                    <td><textarea name="remarks[]"><?=$result->remarks?></textarea></td>
                                </tr>
                                <?php 
                                        $i++;}
                                    }
                                    else
                                    {
                                ?>
                                <tr>
                                    <td class="sn max_sn">१</td>
                                    <td><input type="text" name="description[]" class="form-control"required></td>
                                    <td>
                                        <select name="unit[]" id="unit_1">
                                            <option value="छान्नुहोस"></option>
                                            <?php foreach($units as $unit){?>
                                            <option value="<?=$unit->id?>"><?=$unit->name?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="rate[]" id="rate_1" required></td>
                                    <td><input type="text" name="quantity[]" id="quantity_1" required></td>
                                    <td><input type="text" name="total[]" id="total_1" readonly="true" required></td>
                                    <td><textarea name="remarks[]"></textarea></td>
                                </tr>
                                <?php 
                                    }
                                ?>
                                <tbody id="training_div">

                                </tbody>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th colspan='4'>जम्मा</th>
                                    <td><input type="text" name="grand_total" id="grand_total"  value="<?=$grand_total?>" readonly="true" required></td>
                                    <td>&nbsp;</td>
                                </tr>
                        </table>
                            <div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft"><div id="add_training" class="btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div id="remove_training" class="btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="सेभ गर्नुहोस्" class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                                <div class="inputWrap33 inputWrapLeft"><a href="training_expense_print.php?sn=<?= $_GET['sn_selected'] ?>&plan_id=<?= $_GET['id'] ?>" target="_blank" class="btn">प्रिन्ट गर्नुहोस</a></div>
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                            <input type="hidden" name="sn_sel" value="<?= $_GET['sn_selected'] ?>">
                        </form>
                        
             <?php endif; ?>           
                    </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>