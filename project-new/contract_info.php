<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$data= Plandetails1::find_by_id($_SESSION['set_plan_id']);
if(isset($_POST['submit']))
{
    if(!empty($_POST['create_id']))
{
	$data = Contractinfo::find_by_id($_POST['create_id']);	
}
else
{
	$data = new Contractinfo();
}
    
    
    $data->created_date_english=  DateNepToEng($_POST['created_date']);
    $data->created_date=$_POST['created_date'];
    $data->contract_amount=$_POST['contract_amount'];
    $data->amount=$_POST['amount'];
    $data->contract_type=$_POST['contract_type'];
    $data->last_entry_date=$_POST['last_entry_date'];
    $data->last_entry_date_english=  DateNepToEng($_POST['last_entry_date']);
    $data->plan_id=$_POST['plan_id'];
    $data->ps=$_POST['ps'];
    $data->thekka_id = $_POST['thekka_id'];
    if($data->save())
    {
        echo alertBox("थप / सच्याउन  सफल","view_contract_info.php");
    }
}
 
$postnames=  Postname::find_all();
$units = Units::find_all();
 $sql="select * from enlist where type=0";
  $enlist=Enlist::find_by_sql($sql);
//print_r($units);exit;
  $invest_details = Contractinfo::find_by_plan_id($_GET['id']); //print_r($invest_details);
  //print_r($invest_details);exit;
                         if(empty($invest_details))
                          {
                            $invest_details = Contractinfo::setEmptyObjects(); 
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस"; 
                          if(empty($invest_details))
                          {
                              $contract_type = 2;
                          }
                          else
                          {
                              $contract_type = $invest_details->contract_type;
                          }
?>

<?php include("menuincludes/header.php"); ?>
<title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING;?></title>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
		
        <div class="maincontent">
            <h2 class="headinguserprofile">ठेक्का सूचना प्रकाशन | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
               
                <div class="userprofiletable">
                
                 
                     <div>
                            <h3><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                             <div class="inputWrap">
                             	<h1>ठेक्का सूचना प्रकाशन </h1>
                             	<div class="titleInput">ठेक्का नं: </div>
                                <div class="newInput"><input type="text" name="thekka_id" id="thekka_no" value="<?=$invest_details->thekka_id?>" required /></div>
                                <div class="titleInput">ठेक्का किसिम : </div>
                                <div class="newInput"><input type="radio" name="contract_type" class="radioBtnClass" value="1" required <?php if($invest_details->contract_type == 1){ echo 'checked="checked"';  } ?> />भ्याट सहित &nbsp;&nbsp;<input type="radio" name="contract_type" class="radioBtnClass" value="2" required <?php if($contract_type == 2){ echo 'checked="checked"'; } ?>/>भ्याट बाहेक</div>
                                <div class="titleInput">ठेक्का रकम </div>
                                <div class="newInput"><input type="text" name="amount" id="amount" value="<?=$invest_details->amount?>" required /></div>
                                <div class="titleInput">पी.एस रकम </div>
                                <div class="newInput"><input type="text" name="ps" id="ps_amt" value="<?php echo $invest_details->ps;?>" required /></div>
                                <div class="titleInput">कुल ठेक्का रकम</div>
                                <div class="newInput"><input type="text" name="contract_amount" id="contract_amount" required value="<?=$invest_details->contract_amount?>"/></div>
                                <div class="titleInput">प्रकाशित मिति </div>
                                <div class="newInput"><input type="text" required   name="created_date" id="nepaliDate15"  value="<?=$invest_details->created_date?>" class="datewidth80" /></div>
                                <div class="titleInput">बोलपत्र दाखिला गर्नुपर्ने अन्तिम मिति </div>
                                <div class="newInput"><input type="text" required   name="last_entry_date" id="nepaliDate9"  value="<?=$invest_details->last_entry_date?>" class="datewidth80" /></div>
                                <div class="saveBtn myWidth100"><input type="hidden" name="create_id" value="<?=$invest_details->id?>" />
                        <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                         <input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                
                             	<div class="myspacer"></div>
                             </div><!-- input wrap ends -->
                             
                        <div class="myspacer"></div>
                        
                                          
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

