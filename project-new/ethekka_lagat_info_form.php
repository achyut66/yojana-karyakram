<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$data = Ethekkainfo::find_by_plan_id($_GET['id']);
$data_1= Plandetails1::find_by_id($_SESSION['set_plan_id']);
if(isset($_POST['submit']))
{

        $data->delete();

        $data = new Ethekkainfo();
        $data->created_date_english = DateNepToEng($_POST['created_date']);
        $data->print_date = $_POST['print_date'];
        $data->firm_name = $_POST['firm_name'];
        $data->firm_address = $_POST['firm_address'];
        $data->contact_no = $_POST['contact_no'];
        $data->bolpatra_m = $_POST['bolpatra_m'];
        $data->bolpatra_miti = $_POST['bolpatra_miti'];
        $data->last_entry_date_english = DateNepToEng($_POST['last_entry_date']);
        $data->plan_id = $_POST['plan_id'];
        $data->thekka_no = $_POST['thekka_no'];
        $data->thekka_rakam = $_POST['thekka_rakam'];
        $data->kabol_rakam = $_POST['kabol_rakam'];
        $data->bank_name = $_POST['bank_name'];
        $data->dharauti_no = $_POST['dharauti_no'];
        $data->bank_address = $_POST['bank_address'];
        $data->bank_amount = $_POST['bank_amount'];
        $data->bank_date = $_POST['bank_date'];
        $data->dharauti_amt = $_POST['dharauti_amt'];
        $data->place_to_organize = $_POST['place_to_organize'];
        $data->dharauti_miti = $_POST['dharauti_miti'];
        if ($data->save()) {
            echo alertBox("थप / सच्याउन  सफल", "ethekka_lagat_info_form.php");
        }
}
$invest_details = Ethekkainfo::find_by_plan_id($_GET['id']); //print_r($invest_details);
                         if(empty($invest_details))
                          {
                            $invest_details = Ethekkainfo::setEmptyObjects(); 
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस"; 

$thekka_rakam = Ethekka_lagat::find_by_plan_id($_GET['id']);
?>

<?php include("menuincludes/header.php"); ?>
<title>ठेक्का सम्बन्धि विवरण <?php echo SITE_SUBHEADING;?></title>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner"> 
<div class="maincontent">
<h2 class="headinguserprofile">इलेक्ट्रोनिक (ई) बिडिंग मार्फत विवरण | <a href="ethekka_lagat_info_form.php" class="btn">पछि जानुहोस </a></h2>
<div class="OurContentFull">
	<div class="myMessage"><?php echo $message;?></div>
        <div class="userprofiletable">
            <div>
                            <h3><?php echo $data_1->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                            <div class="inputWrap2">
                             	<h1>ठेक्का सम्बन्धि विवरण / योजना दर्ता नं:- <?php echo convertedcit($data_1->id);?>  योजनाको बजेट :-<?php echo convertedcit($data_1->investment_amount);?>/-</h1>
                             	<div class="inputWrap33 inputWrapLeft">
                                    
                                    <div class="titleInput">ठेक्काका लागि छनौट भएका निर्माण व्यवसायीको नाम :</div>
                                    <div class="newInput"><input type="text" id="firm_name"  name="firm_name" value="<?php echo $invest_details->firm_name;?>"></div>
                                    
                                    <div class="titleInput">फर्म / कम्पनी ठेगाना :</div>
                                    <div class="newInput"><input type="text"  id="firm_address"  name="firm_address" value="<?php echo $invest_details->firm_address;?>"></div>
                                    
                                    <div class="titleInput">सम्पर्क नं :</div>
                                    <div class="newInput"><input type="text"  id="contact_no"  name="contact_no" value="<?php echo ($invest_details->contact_no);?>"></div>
                                    
                                </div><!--input wrap 33 ends-->
                                <div class="inputWrap33 inputWrapLeft">
                        
                                    <div class="titleInput">ठेक्का नं :</div>
                                    <div class="newInput"><input type="text"  id="thekka_no"  name="thekka_no" value="<?= ($invest_details->thekka_no);?>"></div>
                                    
                                    <div class="titleInput">ठेक्का रकम (रु) :</div>
                                    <div class="newInput"><input type="text"  id="thekka_rakam"  name="thekka_rakam" value="<?= ($thekka_rakam->total_investment);?>"></div>
                                    
                                    <div class="titleInput">कबोल (भ्याट र पी.एस सहित) रकम (रु) :</div>
                                    <div class="newInput"><input type="text"  id="kabol_rakam"  name="kabol_rakam" value="<?= ($invest_details->kabol_rakam);?>"></div>
                                    
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">

                                    <div class="titleInput">योजना संचालन हुने स्थान :</div>
                                    <div class="newInput"><input type="text"  id="place_to_organize"  name="place_to_organize" value="<?php echo $invest_details->place_to_organize;?>"></div>

                                    <div class="titleInput">प्रकाशित मिति </div>
                                    <div class="newInput"><input type="text" required   name="print_date" id="nepaliDate15"  value="<?php echo ($invest_details->print_date)?>" class="datewidth80" /></div>
                        
                                </div><!-- input wrap 33 ends -->
                            </div>
                            <div class="myspacer"></div>
                            <div class="inputWrap2">
                                <h1>धरौटी खाता विवरण</h1>
                                <div class="inputWrap33 inputWrapLeft">
                                    
                                    <div class="titleInput">बैंकको नाम:</div>
                                    <div class="newInput"><input type="text"  id="bank_name"  name="bank_name" value="<?php echo $invest_details->bank_name;?>"></div>
                                    
                                    <div class="titleInput">ठेगाना :</div>
                                    <div class="newInput"><input type="text"  id="bank_address"  name="bank_address" value="<?php echo $invest_details->bank_address;?>"></div>
                                    
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput">बैंक ग्यारेन्टी रकम :</div>
                                    <div class="newInput"><input type="text"  id="bank_amount"  name="bank_amount" value="<?php echo ($invest_details->bank_amount);?>"></div>

                                    <div class="titleInput">धरौटी खाता नं :</div>
                                    <div class="newInput"><input type="text"  id="dharauti_no"  name="dharauti_no" value="<?php echo ($invest_details->dharauti_no);?>"></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput">बैंक ग्यारेन्टी रकम अवधि :</div>
                                    <div class="newInput"><input type="text" name="bank_date" id="nepaliDate13"  value="<?=($invest_details->bank_date)?>" class="datewidth80" /></div>

                                    <div class="titleInput">धरौटी खातामा जम्मा गरिएको रकम  :</div>
                                    <div class="newInput"><input type="text"  id="dharauti_amt"  name="dharauti_amt" value="<?php echo ($invest_details->dharauti_amt)?>"></div>
                                                   
                                    <div class="titleInput">धरौटी खातामा रकम जम्मा गरेको मिति :</div>
                                    <div class="newInput"><input type="text" name="dharauti_miti" id="nepaliDate14"  value="<?=($invest_details->dharauti_miti)?>" class="datewidth80" /></div>
                                    
                                </div><!-- input wrap 33 ends -->
                            </div>
                                <div class="myspacer"></div>
                                <div class="inputWrap2">
                                    <h1>बोलपत्र आव्हान विवरण</h1>
                                    <div class="inputWrap33 inputWrapLeft">
                                        <div class="titleInput">बोलपत्र आव्हान गरेको माध्यम: (पत्रिका / रेडियो / टेलिभिजन)</div>
                                        <div class="newInput"><input type="text"  id="bolpatra_m"  name="bolpatra_m" value="<?php echo ($invest_details->bolpatra_m);?>"></div>
                                    </div><!-- input wrap 33 ends -->
                                    <div class="inputWrap33 inputWrapLeft">
                                        <div class="titleInput">बोलपत्र आव्हान मिति :</div>
                                        <div class="newInput"><input type="text"  id="nepaliDate12"  class="datewidth100" name="bolpatra_miti" value="<?php echo ($invest_details->bolpatra_miti);?>"></div>
                                    </div><!-- input wrap 33 ends -->
                                </div>
                                <div class="myspacer"></div>
                            <div class="mysapcer20"></div>
                            <div class="inputWrap33 inputWrapLeft" style="margin-left:70px">
                                    <div class="saveBtn myWidth100"
                                    <input type="hidden" name="create_id" value="<?=$invest_details->id?>" />
                                    <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                                    <input type="submit" name="submit" value="<?=$value?>" class="btn"></div>
                                </div><!--input wrap 33 ends-->
                            </form>
            </div>
        </div>
    </div><!-- main menu ends -->
</div><!-- top wrap ends -->
</div>
<?php include("menuincludes/footer.php"); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>

