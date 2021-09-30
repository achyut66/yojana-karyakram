<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//echo $_GET['contractor_id'];
$contractbid_final= Contractentryfinal::find_by_plan_id($_SESSION['set_plan_id']);
//print_r($contracbid_final);
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
    if($_POST['dharauti_amount'] < $_POST['dharauti_return_amount'])
    {
        echo alertBox("धरौटी जम्मा रकम भन्दा धरौटी फिर्ता रकम धेरै भयो....!!!","contract_dharauti_firta1.php?contractor_id=".$_GET['contractor_id']);
        return false;
     }
        //मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा 
        $data8=new Contractdharautifirta();
        $data8->payment_evaluation_count = $_POST['payment_evaluation_count'];
        $data8->contractor_id=$_POST['contractor_id'];
        $data8->dharauti_return_amount=$_POST['dharauti_return_amount'];
        $data8->taken_date= $_POST['taken_date'];
        $data8->taken_date_english= DateNepToEng($_POST['taken_date']);
        $data8->plan_id=$_POST['plan_id'];
        $data8->save();
        echo alertBox("थप सफल ","contract_dharauti_firta1.php?contractor_id=".$_GET['contractor_id']);
}
$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
$value = "सेभ गर्नुहोस";
$inst_count = Contractdharautifirta::getMaxInsallmentByPlanIdAndContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
empty($inst_count)? $inst_count=0 : '';    
if(isset($_GET['contractor_id']))
{
    $data= Contractentryfinal::find_by_id($_GET['contractor_id']);
     $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_SESSION['set_plan_id']);
    $contractor_details=  Contractordetails::find_by_id($data->contractor_id);

        if($data->status==1)
        {
            $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$_GET['contractor_id']);
  
            $analysis_amount=  Contractanalysisbasedwithdraw::getTotalDharautiPayableAmount($_SESSION['set_plan_id']);
            
            $final_amount=  Contractamountwithdrawdetails::find_by_plan_id($_SESSION['set_plan_id']);
            
            $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount + $analysis_amount + $final_amount->final_due_amount;
            
            $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
            
            $total_final_amount=$final_dharauti_amount - $amount;
        }
        else
        {
            $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$_GET['contractor_id']);
            $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_SESSION['set_plan_id']);
             $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount;
            $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
           $total_final_amount=$final_dharauti_amount - $amount;
        }
        
}
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | <a href="contract_dharauti_firta.php" class="btn">पछि जानुहोस</a></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">
                <h2> जम्मा धरौटी रकम रु. <?php echo convertedcit(placeholder($final_dharauti_amount));?> || बाकी रकम रु. <?php echo convertedcit(placeholder($total_final_amount));?></h2>
              <div class="userprofiletable">
                    
                     <div>
                                
                                 <?php for($i=1; $i<=$inst_count; $i++): 
//                                     echo $_GET['contractor_id'];exit;
                                        $inst_data = Contractdharautifirta::find_by_payment_count_of_contractor($i,$_SESSION['set_plan_id'],$_GET['contractor_id']);
//                                        print_r($inst_data);exit;
                                       $data= Contractentryfinal::find_by_id($_GET['contractor_id']);
                                        $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
//                                        print_r($inst_data);exit;
                                     ?>
                                 
                                 <h3 class="myheader"><?=$inst_array[$i]?> धरौटी थप विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered table-responsive">
                                        
                                <tr>
                                    <td> धरौटी थप  </td>
                                    <td><?php echo $inst_array[$i]; ?></td>
                                </tr>
                                 <tr>
                                    <td>निर्माण ब्यवोसायीको नाम</td>
                                    <td><?php echo $contractor_details->contractor_name; ?></td>
                                </tr>
                                <tr>
                                <td width="176">धरौटी फिर्ता रकम</td>
                                <td width="243"><?php echo convertedcit($inst_data->dharauti_return_amount); ?></td>
                               </tr>
                              <tr>
                                <td width="176">मिती</td>
                                <td width="243"><?php echo convertedcit($inst_data->taken_date); ?></td>
                              </tr>
                            
                            
                       </table>
                     </div>
                         
                         <?php endfor; 
                         if($total_final_amount!=0){
                         ?>      
                         
                        
                          <h3><?=$inst_array[$inst_count+1]?> धरौटी थप्नुहोस</h3>
                          <form method="post" enctype="multipart/form_data" id="analysis_form" >
                             <input type="hidden" name="plan_id" value="<?php echo $_SESSION['set_plan_id'];?>"/>
                             <input type="hidden" name="contractor_id" value="<?php echo $_GET['contractor_id'];?>"/>      
                                <table class="table table-bordered">
                                 
                                 <tr>
                                <td width="176">धरौटी थप </td>
                                <td width="243">
                                    <select name="payment_evaluation_count"  required>
                                            <option value="<?=$inst_count+1?>"><?=$inst_array[$inst_count+1]?></option>
                                       </select>
                                </td>
                              </tr>
                               <tr>
                                <td width="176">निर्माण ब्यवोसायीको नाम</td>
                                <td width="243"> <input type="text" readonly="true" name="contractor_name" value="<?php echo $contractor_details->contractor_name;?>" required  /></td>
                              </tr>
                              <tr>
                                <td width="176">जम्मा धरौटी रकम</td>
                                <td width="243"> <input type="text" name="dharauti_amount"  value="<?php echo $total_final_amount;?>" required  /></td>
                              </tr>
                               <tr>
                                <td width="176">धरौटी फिर्ता रकम</td>
                                <td width="243"> <input type="text" name="dharauti_return_amount" required  /></td>
                              </tr>
                               <tr>
                                <td width="176">मिती</td>
                                <td width="243"><input readonly="true" type="text" name="taken_date" required id="nepaliDate3" /></td>
                              </tr>
                               
                            </table></br></br>
                        <input type="submit"  name="submit" onclick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस ');" value="सेभ गर्नुहोस" class="btn">
                                    
 </form>
                         <?php }else
                         {
                             echo "<h3>धरौटी रकम सकिएको छ |</h3>";
                         }
                         ?>

                </div>
               
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>