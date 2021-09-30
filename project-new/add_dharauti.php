<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

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
        $data8=new Contractdharautiadd();

        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->contractor_name=$_POST['contractor_name'];
        $data8->contractor_id=$_POST['contractor_id'];
        $data8->dharauti_amount=$_POST['dharauti_amount'];
        $data8->taken_date= $_POST['taken_date'];
        $data8->taken_date_english= DateNepToEng($_POST['taken_date']);
        $data8->plan_id=$_POST['plan_id'];
        $data8->save();
        echo alertBox("थप सफल ","add_dharauti.php?plan_id=".$_GET['plan_id']."&contractor_id=".$_GET['contractor_id']);
}
$plan_selected = Plandetails1::find_by_id($_GET['plan_id']);
$value = "सेभ गर्नुहोस";
$inst_count = Contractdharautiadd::getMaxInsallmentByPlanIdAndContractorId($_GET['plan_id'],$_GET['contractor_id']);
empty($inst_count)? $inst_count=0 : '';    
$data= Contractentryfinal::find_by_id($_GET['contractor_id']);
//print_r($data);exit;
$contractor_details=  Contractordetails::find_by_id($data->contractor_id);
//print_r($data);exit;
if($data->status==1)
{
       $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_GET['plan_id']);
       $get_amount=  Contractdharautiadd::getTotalPayableAmount($_GET['plan_id'],$data->contractor_id);
       $analysis_amount=  Contractanalysisbasedwithdraw::getTotalDharautiPayableAmount($_GET['plan_id']);
       $final_amount=  Contractamountwithdrawdetails::find_by_plan_id($_GET['plan_id']);
       $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount + $analysis_amount + $final_amount->final_due_amount;
   
}
else
{
    $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_GET['plan_id']);
    $get_amount=  Contractdharautiadd::getTotalPayableAmount($_GET['plan_id'],$data->contractor_id);
    $final_dharauti_amount= $bid_result->dharauti_amount + $get_amount;
}
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | <a href="contractdharauti.php" class="btn">पछि जानुहोस</a></h2>
         
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">
                
                <h2><?php echo $contractor_details->contractor_name;?>को जम्मा धरौटी रकम रु. <?php echo convertedcit(placeholder($final_dharauti_amount));?></h2>
                <div class="userprofiletable">
                   
                     <div>
                                
                                 <?php for($i=1; $i<=$inst_count; $i++): 
                                        $inst_data = Contractdharautiadd::find_by_payment_count($i,$_GET['plan_id']);
                                      
                                     ?>
                                 
                    <h3 class="myheader"><?=$inst_array[$i]?> धरौटी थप विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered table-hover">
                                        
                                <tr>
                                    <td> धरौटी थप  </td>
                                    <td><?php echo $inst_array[$i]; ?></td>
                                </tr>
                                 <tr>
                                    <td>निर्माण ब्यवोसायीको नाम</td>
                                    <td><?php echo $inst_data->contractor_name; ?></td>
                                </tr>
                               <tr>
                                <td width="176">धरौटी थप  रकम</td>
                                <td width="243"><?php echo convertedcit($inst_data->dharauti_amount); ?></td>
                              </tr>
                              <tr>
                                <td width="176">मिती</td>
                                <td width="243"><?php echo convertedcit($inst_data->taken_date); ?></td>
                              </tr>
                            
                            
                       </table>
                     </div>
                         
                         <?php endfor; ?>      
                         
                         <?php if(!empty($data_selected_final)){ exit;}?>
                          <h3><?=$inst_array[$inst_count+1]?> धरौटी थप्नुहोस</h3>
                          <form method="post" enctype="multipart/form_data" id="analysis_form" >
                             <input type="hidden" name="plan_id" value="<?php echo $_GET['plan_id'];?>"/>
                             <input type="hidden" name="contractor_id" value="<?php echo $_GET['contractor_id'];?>"/>      
                                <table class="table table-bordered">
                                 
                                 <tr>
                                <td >धरौटी थप </td>
                                <td >
                                    <select name="payment_evaluation_count"  required>
                                            <option value="<?=$inst_count+1?>"><?=$inst_array[$inst_count+1]?></option>
                                       </select>
                                </td>
                              </tr>
                               <tr>
                                <td >निर्माण ब्यवोसायीको नाम</td>
                                <td > <input type="text" readonly="true" name="contractor_name" value="<?php echo $contractor_details->contractor_name;?>" required  /></td>
                              </tr>
                              <tr>
                                <td >धरौटी थप रकम</td>
                                <td > <input type="text" name="dharauti_amount" required  /></td>
                              </tr>
                               <tr>
                                <td >मिती</td>
                                <td ><input readonly="true" type="text" name="taken_date" required id="nepaliDate3" /></td>
                              </tr>
                               
                            </table></br></br>
                        <input type="submit"  name="submit" onClick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस ');" value="सेभ गर्नुहोस" class="btn">
                                    
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>