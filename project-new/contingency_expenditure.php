<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
if(isset($_POST['submit']))
{
        //मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा 
        $data8=new Contingencyexenditure();

        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->contingency_amount=$_POST['contingency_amount'];
        $data8->taken_date= $_POST['taken_date'];
        $data8->taken_date_english= DateNepToEng($_POST['taken_date']);
        $data8->plan_id=$_POST['plan_id'];
        $data8->save();
}
$plan_selected = Plandetails1::find_by_id($_GET['id']);
$value = "सेभ गर्नुहोस";
$inst_count = Contingencyexenditure::getMaxInsallmentByPlanId($_GET['id']);
 empty($inst_count)? $inst_count=0 : '';    
 
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | <a href="contract_bhuktani_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            	
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                   
                     <div>
                                
                                 <?php for($i=1; $i<=$inst_count; $i++): 
                                        $inst_data = Contingencyexenditure::find_by_payment_count($i,$_GET['id']);
                                      
                                     ?>
                                 
                                 <h3 class="myheader"><?=$inst_array[$i]?> कन्टेन्जेन्सी खर्च विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered table-responsive">
                                        
                                        <tr>
                                            <td>कन्टेन्जेन्सी खर्च किसिम</td>
                                            <td><?php echo $inst_array[$i]; ?></td>
                                        </tr>
                               <tr>
                                <td width="176">कन्टेन्जेन्सी खर्च रकम</td>
                                <td width="243"><?php echo convertedcit($inst_data->contingency_amount); ?></td>
                              </tr>
                              <tr>
                                <td width="176">कन्टेन्जेन्सी भरेको मिती</td>
                                <td width="243"><?php echo convertedcit($inst_data->taken_date); ?></td>
                              </tr>
                            
                            
                       </table>
                     </div>
                         
                         <?php endfor; ?>      
                         
                         <?php if(!empty($data_selected_final)){ exit;}?>
                          <h3><?=$inst_array[$inst_count+1]?> कन्टेन्जेन्सी खर्च  भर्नुहोस्  </h3>
                          <form method="post" enctype="multipart/form_data" id="analysis_form" >
                             <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                                   
                                <table class="table table-bordered">
                                 
                                 <tr>
                                <td width="176">कन्टेन्जेन्सी खर्च किसिम</td>
                                <td width="243">
                                    <select name="payment_evaluation_count"  required>
                                            <option value="<?=$inst_count+1?>"><?=$inst_array[$inst_count+1]?></option>
                                       </select>
                                </td>
                              </tr>
                               <tr>
                                <td width="176">कन्टेन्जेन्सी खर्च रकम</td>
                                <td width="243"> <input type="text" name="contingency_amount" required  /></td>
                              </tr>
                               <tr>
                                <td width="176">कन्टेन्जेन्सी भरेको मिती</td>
                                <td width="243"><input type="text" name="taken_date" required id="nepaliDate3" /></td>
                              </tr>
                               
                            </table></br></br>
                        <input type="submit"  name="submit" onclick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस ');" value="सेभ गर्नुहोस" class="btn">
                                          
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
     <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>