<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php
$id=$_GET['id'];
$program_payment_final= Programpaymentfinal::find_by_id($id);
if (isset($_POST['submit'])) {
    $update_id=$_POST['update_id'];
    $program = Programpaymentfinal::find_by_id($update_id);
    $paid_date_nepali = $_POST['paid_date'];
    $paid_date_english = DateNepToEng($paid_date_nepali);
    $_POST['paid_date_english'] = $paid_date_english;
    if ($program->savePostData($_POST)) {

        $session->message("पेश्की फर्छयौट तथा भुक्तानी सच्याउनु सफल");
        redirect_to("program_payment_final.php?id=".$program->program_id);
    }
}

?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>पेश्की फर्छयौट तथा भुक्तानी  सच्याउनु :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">पेश्की फर्छयौट तथा भुक्तानी  सच्याउनु</h2>
                  
                    <div class="OurContentFull">
                        <h2>कार्यक्रम संचालन विवरण थप्नुहोस </h2>
                        <div class="userprofiletable">
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><input type="text" id="topictype_name" name="program_remaining_amount" readonly="true" value="<?php echo $program_payment_final-> program_remaining_amount;?>"></td>
                                    </tr>
                                      <tr>                                           
                                        <td width="238">भुक्तानी दिएको मिती</td>
                                         <td><input type="text" id="nepaliDate5" name="paid_date" value="<?php echo $program_payment_final-> paid_date;?>"></td>
                                     </tr>
                                       <tr>                                           
                                        <td width="238">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                        <td><input type="text" readonly="true" id="nepaliDate5" class="work_order_budget" name="total_payment_amount" value="<?php echo $program_payment_final-> total_payment_amount;?>"></td>
                                     </tr>
                                       <tr>                                           
                                        <td width="238">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                        <td><input type="text" readonly="true" id="nepaliDate5"  class="program_payment" name="payment_taken_amount" value="<?php echo $program_payment_final-> payment_taken_amount;?>"></td>
                                     </tr>
                                     <tr>
                                        <td width="238">धरौटी कट्टी रकम</td>
                                        <td><input type="text" class="deposit_amount" name="deposit_amount" value="<?php echo $program_payment_final-> deposit_amount;?>"></td>
                                     </tr>
                                     <tr>
                                        <td width="238">जम्मा कट्टी रकम</td>
                                        <td><input type="text"  class="total_amount" name="total_amount" value="<?php echo $program_payment_final-> total_amount;?>" readonly="true"></td>
                                    </tr>
                                     <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                        <td><input type="text"  class="net_total_amount" name="net_total_amount" value="<?php echo $program_payment_final->net_total_amount ;?>" readonly="true"></td>
                                    </tr>
                                   <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="update_id" value="<?php echo $program_payment_final->id;?>"/>
                              <input type="hidden" name="program_id" value="<?=$program_payment_final->program_id?>" />
                               <input type="hidden" name="enlist_id" value="<?=$program_payment_final->enlist_id?>" />
                               <input type="hidden" name="sn" class="sn5" value="<?= $program_payment_final->sn ?>" />
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>