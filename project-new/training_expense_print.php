<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$sn = $_GET['sn'];
$plan_id= $_GET['plan_id'];
$expense_details   = TrainingExpense::find_by_program_id_and_sn($plan_id,$sn);
    $grand_total       = TrainingExpense::find_grand_total_by_plan_id($plan_id,$sn);
    $current = Fiscalyear::find_current_id();
    $fiscal= Fiscalyear::find_by_id($current);
?>
  
<?php include("menuincludes/header1.php"); ?>

<title>पेश्की संझौताको टिप्पणी print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                   
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
                                                                            <div class="mydate">मिति:  <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या :<?= convertedcit($fiscal->year) ?> </div>
										<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['plan_id'])?></div>
<div class="myspacer20"></div>
										<div class="subject">विषय:- कार्यक्रमको लागत परिमाण ।</div>
<div class="myspacer20"></div>
										<!--<div class="bankname">श्रीमान्</div>-->
										
										<div class="banktextdetails">
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
                                                                                            $unit = Units::find_by_id($result->unit);
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=convertedcit($i)?></td>
                                                                                    <td><?=$result->description?></td>
                                                                                    <td><?=$unit->name?></td>
                                                                                    <td><?=convertedcit($result->rate)?></td>
                                                                                    <td><?=convertedcit($result->quantity)?></td>
                                                                                    <td><?=convertedcit($result->total)?></td>
                                                                                    <td><?=$result->remarks?></td>
                                                                                </tr>
                                                                                <?php 
                                                                                        $i++;}
                                                                                    }
                                                                                ?>
                                                                                <tr>
                                                                                    <th>&nbsp;</th>
                                                                                    <th colspan='4'>जम्मा</th>
                                                                                    <td><?=convertedcit($grand_total)?></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                                </div> 
										<div class="myspacer30"></div>
										<div class="oursignature"> सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>
									</div><!-- print content ends -->
                                
                            </div>
                        </div>
                  </div>
</div>
            


                