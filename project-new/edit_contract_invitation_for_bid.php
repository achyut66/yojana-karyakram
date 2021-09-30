<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
$document_result=  Contractdocument::find_all();
$data= Plandetails1::find_by_id($_SESSION['set_plan_id']);
$details = Contractinvitationforbid::find_by_id($_GET['id']);
$bid_id=$details->bid_id;
$contract_doc_array=  explode("-",$details->contractor_document);


if(isset($_POST['submit']))
{
            $data = Contractinvitationforbid::find_by_id($_POST['create_id']);	
            $data->bid_id=$_POST['bid_id'];
            $data->contractor_name=$_POST['contractor_name'];
            $data->contractor_address=$_POST['contractor_address'];
             $data->contractor_contact=$_POST['contractor_contact'];
            $data->document_type =$_POST['document_type'];
            $data->contractor_document=implode("-",$_POST['contractor_document']);
            $data->bill_no=$_POST['bill_no'];
            $data->bid_fee=$_POST['bid_fee'];
            $data->contract_date=$_POST['contract_date'];
            $data->contract_date_english = DateNepToEng($_POST['contract_date']);
            $data->plan_id=$_POST['plan_id'];
            $data->save();
            echo alertBox("थप सफल","view_contract_invitation_for_bid.php");

}
?>

<?php include("menuincludes/header.php"); ?>
<title>ठेक्का बोलपत्र बिक्रि किताब  :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
		<div class="maincontent">
            <h2 class="headinguserprofile">ठेक्का बोलपत्र बिक्रि किताब | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
           
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
               
                <div class="userprofiletable">
                
                 
                     <div>
                            <h3><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                            <div class="inputWrap100">
                            	<h1>ठेक्का बोलपत्र बिक्रि किताब  </h1>
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">दर्ता नं : </div>
                                    <div class="newInput"><input type="text" name="bid_id" readonly="true" required value="<?php echo $details->bid_id; ?>"/></div>
                                    <div class="titleInput">निर्माण ब्यवोसायीको नाम : </div>
                                    <div class="newInput"><input type="text" name="contractor_name" value="<?php echo $details->contractor_name;?>" required /></div>
                                    <div class="titleInput">ठेगाना : </div>
                                    <div class="newInput"><input type="text" name="contractor_address" value="<?php echo $details->contractor_address;?>" required /></div>                                    
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">सम्पर्क : </div>
                                    <div class="newInput"><input type="text" name="contractor_contact"   value="<?php echo $details->contractor_contact;?>" required /></div>
                                    <div class="titleInput">पेश गरेको कागजात : </div>
                                    <div class="newInput"><b>वर्ग:&nbsp;</b><input type="radio" name="document_type" value="1"  <?php if($details->document_type == 1){ echo 'checked="checked"';  } ?>/> क &nbsp; 
                            <input type="radio" name="document_type"    value="2"  <?php if($details->document_type == 2){ echo 'checked="checked"';  } ?>/> ख  &nbsp;
                            <input type="radio" name="document_type"   value="3"  <?php if($details->document_type == 3){ echo 'checked="checked"';  } ?>/> ग  &nbsp; 
                            <input type="radio" name="document_type"   value="4"  <?php if($details->document_type == 4){ echo 'checked="checked"';  } ?>/> घ  &nbsp; </div>
                                    <div class="titleInput">अन्य कागजात : </div>
                                    <div class="newInput"><?php foreach($document_result as $data): ?><input type="checkbox" name="contractor_document[]"  value="<?php echo $data->id;?>"  <?php if(in_array($data->id,$contract_doc_array)){ echo 'checked="checked"';  } ?>/> <?php echo $data->name;?> <br><?php endforeach?></div>                                    
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">रसिद नं. : </div>
                                    <div class="newInput"><input type="text" name="bill_no"  required value="<?php echo $details->bill_no;?>"/></div>
                                    <div class="titleInput">बोलपत्र दस्तुर : </div>
                                    <div class="newInput"><input type="text" name="bid_fee"  required  value="<?php echo $details->bid_fee;?>"/></div>
                                    <div class="titleInput">बोलपत्र बिक्रि मिति :</div>
                                    <div class="newInput"><input type="text" name="contract_date" id="nepaliDate9"  required value="<?php echo $details->contract_date;?>" class="datewidth80"/></div>  
                                    <div class="saveBtn myWidth100"><input type="hidden" name="create_id" value="<?=$details->id?>" />
                        <input type="hidden" name="plan_id" value="<?=$_SESSION['set_plan_id']?>" />
                         <input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>                                  
                                </div><!-- input wrap 33 ends -->
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                             
                        
                                          
 </form>
         

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>