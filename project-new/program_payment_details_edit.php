<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php

$program_id=$_GET['id'];
$program_payment_details= Programpaymentdetails::find_by_program_id($program_id);
if (isset($_POST['submit'])) {
    $update_id=$_POST['update_id'];
    $program =Programpaymentdetails::find_by_id($update_id);
    $paid_date_nepali = $_POST['paid_date'];
    $paid_date_english = DateNepToEng($paid_date_nepali);
    $_POST['paid_date_english'] = $paid_date_english;
    if ($program->savePostData($_POST)) {

        $session->message("कार्यक्रम  भुक्तानी विवरण सच्याउनु सफल");
        redirect_to("program_total_view.php?id=".$program_id);
    }
}

?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>कार्यक्रमको  भुक्तानी विवरण सच्याउनु:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रमको  भुक्तानी विवरण सच्याउनु</h2>
                    
                    <div class="OurContentFull">
                        <h2>कार्यक्रमको  भुक्तानी विवरण  सच्याउनु</h2>
                        <div class="userprofiletable">
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="238">विनियोजित कुल बजेट रु</td>
                                        <td><input type="text" id="topictype_name" name="total_budget" value="<?php echo $program_payment_details->total_budget; ?>"></td>
                                    </tr>

                                    <tr>
                                        <td width="238">भुक्तानीको किसिम</td>
                                        <td><input type="text" id="topictype_name" name="payment_type" value="<?php echo $program_payment_details->payment_type;?>"></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><input type="text" id="topictype_name" name="program_remaining_budget" value="<?php echo $program_payment_details->program_remaining_budget ; ?>"></td>
                                    </tr>
                                    <tr>                                            
                                        <td width="238">हाल भुक्तानी दिनु पर्ने रकम</td>
                                        <td><input type="text" id="topictype_name" name="present_paid_amount" value="<?php echo $program_payment_details->present_paid_amount; ?>"></td>
                                    </tr>
                                    <tr>                                           
                                        <td width="238">भुक्तानी दिएको मिती</td>
                                        <td><input type="text" id="nepaliDate5" name="paid_date" value="<?php echo $program_payment_details->paid_date; ?>"></td>
                                    </tr>
                                    <tr>                                         
                                        <td width="238">कन्टेन्जेन्सी  कट्टी रकम</td>
                                        <td><input type="text" id="topictype_name" name="congentency_amount" value="<?php echo $program_payment_details->congentency_amount; ?>"></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td width="238">मर्मत सम्हार कोष कट्टी रकम</td>
                                        <td><input type="text" id="topictype_name" name="maintainance_amount" value="<?php echo $program_payment_details->maintainance_amount; ?>"></td>
                                    </tr>
                                     <tr>
                                        <td width="238">धरौटी कट्टी रकम</td>
                                        <td><input type="text" id="topictype_name" name="deposit_amount" value="<?php echo $program_payment_details-> deposit_amount; ?>"></td>
                                    </tr>
                                     <tr>
                                        <td width="238">विपद व्यबसथापन कोष कट्टी रकम</td>
                                        <td><input type="text" id="topictype_name" name="emergency_amount" value="<?php echo $program_payment_details->emergency_amount ; ?>"></td>
                                    </tr>
                                     <tr>
                                        <td width="238">जम्मा कट्टी रकम</td>
                                        <td><input type="text" id="topictype_name" name="total_amount" value="<?php echo $program_payment_details-> total_amount; ?>"></td>
                                    </tr>
                                     <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                        <td><input type="text" id="topictype_name" name="net_total_amount" value="<?php echo $program_payment_details->net_total_amount ; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                    </tr>
                                </table>
                                 <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                                <input type="hidden" name="update_id" value="<?php echo $program_payment_details->id;?>">
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>