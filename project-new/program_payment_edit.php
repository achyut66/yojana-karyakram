<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
$id=$_GET['id'];
$program_payment= Programpayment::find_by_id($id);
$sql="select * from program_more_details where program_id={$program_payment->program_id} and sn={$program_payment->sn} limit 1";
$program_more_details= Programmoredetails::find_by_sql($sql);
foreach ($program_more_details as $details):
$work_order_budget= $details->work_order_budget;
endforeach;
;if(isset($_POST['submit']))
{
    $update_id=$_POST['update_id'];
    $paid_date_nepali = $_POST['paid_date'];
    $payment_flow_date_nepali = $_POST['payment_flow_date'];
    $paid_date_english = DateNepToEng($paid_date_nepali);
    $payment_flow_date_english = DateNepToEng($payment_flow_date_nepali);
    $_POST['paid_date_english'] = $paid_date_english;
    $_POST['payment_flow_date_english'] = $payment_flow_date_english;
        $payment = Programpayment::find_by_id($update_id);
	if($payment->savePostData($_POST)){
        $session->message("कार्यक्रम  संचालनमामा पेश्की सच्याउनु सफल");    
        redirect_to("program_payment.php?id=".$payment->program_id);
        }
}
?>
<?php include("menuincludes/header.php");
include("menu/header_script.php");?>
<!-- js ends -->
<title>कार्यक्रम  संचालनमामा पेश्की सच्याउनु:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम  संचालनमामा पेश्की सच्याउनु</h2>
                   
                    <div class="OurContentFull">
                    	<h2>कार्यक्रम  संचालनमामा पेश्की सच्याउनु </h2>
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                            <tr>
                                            <td> पेश्की लिने मुख्य व्यक्तीको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_name" required value="<?php echo $program_payment->payment_holder_name; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको बाबुको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_father_name" required value="<?php echo $program_payment->payment_holder_father_name; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको  बाजेको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_grandfather_name" required value="<?php echo $program_payment->payment_holder_grandfather_name; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की रकम </td>
                                            <td><input type="text" id="work_order_budget" name="payment_amount" required value="<?php echo $program_payment->payment_amount; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td> पेश्की दिएको मिती</td>
                                            <td><input type="text" id="nepaliDate9" name="paid_date" required value="<?php echo $program_payment->paid_date; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की फर्छ्यौट गर्नु पर्ने मिति</td>
                                            <td><input type="text" id="nepaliDate15" name="payment_flow_date" required value="<?php echo $program_payment->payment_flow_date; ?>"></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की दिनु पर्ने कारण</td>
                                            <td><input type="text" id="topictype_name" name="payment_reason" required value="<?php echo $program_payment->payment_reason; ?>"></td>
                                          </tr>
                                          <tr>
                                           <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere" id="submit_payment"></td>
                                          </tr>
                                        </table>
                                         <input type="hidden" name="program_id" value="<?=$program_payment->program_id?>" />
                                    <input type="hidden" value="<?php echo $program_payment->id; ?>" name="update_id"/>
                                     <input type="hidden" name="enlist_id" value="<?=$program_payment->enlist_id?>" />
                                     <input type="hidden" name="sn" value="<?=$program_payment->sn?>" />
                                     <input type="hidden" id="budget" value="<?=$work_order_budget?>" />
                                     
                                    </form>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>