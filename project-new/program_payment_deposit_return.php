<?php require_once("includes/initialize.php");
error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
?>
<?php
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;

    $inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
$user=getUser();
$program_id=$_GET['id'];
$program_payment_final_result= Programpaymentdepositreturn::find_by_program_id2($program_id);
if (isset($_POST['submit'])) 
{
 
                   $program_payment_final= Programpaymentdepositreturn::find_by_program_id_and_sn($program_id,$_POST['sn']);
                
                   $program =  new Programpaymentdepositreturn() ;
                       $date = $_POST['date'];
                      $date_english = DateNepToEng($date);
                      $_POST['date'] = $date_english;
                      
                      if ($program->savePostData($_POST,'create')) 
                              {
                 
                          echo alertBox("धरौटी फिर्ता थप्न सफल","program_payment_deposit_return.php");
                              }
                   
}


$sql= "select * from program_payment_final where program_id={$program_id} and deposit_amount>0"; 
$result= Programpaymentfinal::find_by_sql($sql);
$sn_result1= array();
$sn_result13= array();
foreach ($result as $data)
{
    array_push($sn_result1, $data->sn);
}

 $sn_result12 = array_unique($sn_result1);
foreach($sn_result12 as $data)
{
    $sum= Programpaymentdepositreturn::getsum($program_id,$data);
    $sum_pp= Programpaymentfinal::find_by_program_id_and_sn($program_id, $data);
    $diff=$sum_pp->deposit_amount-$sum; 
    if($diff==0)
    {
    array_push($sn_result13, $data);
    }
       
}
$sn_result21=array_diff($sn_result12, $sn_result13);
$sn_result2 = array_unique($sn_result21);


?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>धरौटी फिर्ता  :: Kanepokhari Gaupalika</title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">धरौटी फिर्ता  / <a href="program_dashboard.php?id=<?= $program_id ?>">Go Back</a></h2>
                    
                    <div class="OurContentFull">
                             
             <?php if(!empty($program_payment_final_result)):?>
          <?php foreach($program_payment_final_result as $program_payment_final) :
              
                 $program_more_details1 = Programmoredetails::find_by_program_id_and_sn($program_id, $program_payment_final->sn);
              
              ?>  
                         <h2 class="header1">
                             <?php if($program_more_details1->type_id == 5)
                                {
                                     $up_sam = Upabhoktasamitiprofile::find_by_id($program_payment_final->enlist_id);
                                     echo $up_sam->program_organizer_group_name." द्वारा लागिएको";
                                }
                                else
                                {
                                     echo Enlist::getName1($program_payment_final->enlist_id)." द्वारा लागिएको";
                                }  ?> 
                         </h2>
                                  <div style="display: none;" class="userprofiletable">
                                <table class="table table-bordered">
                                     <tr>
                                        <td>कर्यादेस न:</td>
                                        <td><?= convertedcit(placeholder($program_payment_final-> sn)) ?></td>     
                                        
                                    </tr>
                                   <tr>
                                    <td>अवधि</td>
                                    <td><?= $inst_array[$program_payment_final->period] ?></td>
                                  </tr>    
                                            <tr>
                                                <td width="238">धरौटी रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final->deposit_amount));?></td>
                                            </tr>
                                              <tr>                                           
                                                <td width="238">धरौटी काटिएको मिति  </td>
                                                <td><?php echo convertedcit(DateEngToNep($program_payment_final->date));?></td>
                                            </tr>
                                   <?php if( $user->mode=="superadmin"):?>
                                                <tr>
                                                <a href="program_payment_final_deposit_return_delete.php?id=<?php echo $program_payment_final->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere btn">हटाउनु होस्</button></a>
                                               </tr>
                                               
                                             <?php endif;?>
                                </table>
                             </div>
                        <?php endforeach; ?>
            <?php endif; ?>
                        
                              <div class="userprofiletable">
           <?php if (!empty($sn_result2)) : ?>                   
                            <h3>अन्तिम भुक्तानी थप्नुहोस + </h3>
                             <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered">
                                    <tr>
                                          <td>कर्यादेस न:</td>
                                            <td>
                                                <select class="sn5" id="sn_deposit" name="sn">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($sn_result2 as $sn):?>
                                                    <option value="<?= $sn ?>"><?= $sn ?></option>
                                                    <?php endforeach; ?>
                                                    <input type="hidden" value="<?= $program_id ?>" class="program_id">
                                                </select> 
                                            </td>
                                      </tr>
                                         <tr class="enlist5">
                                             
                                         </tr>
                                       <tr>
                                    <td>अवधि</td>
                                    <td><input type="text" id="period" ></td>
                                  </tr>     
                                    <tr>
                                        <td width="238">धरौटी रकम</td>
                                        <td><input type="text"  name="deposit_amount" id="deposit_amount"></td>
                                    </tr>
                                      <tr>                                           
                                        <td width="238">धरौटी काटिएको मिति </td>
                                        <td><input type="text" id="nepaliDate5" name="date" ></td>
                                    </tr>
                                   <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" id="submitdeposit" class="submithere"></td>
                                    </tr>
                                </table>
                                  <input type="hidden" id="program_id" name="program_id" value="<?=(int) $_GET['id']?>" />
                                  <input type="hidden" id="period_no" value="" name="period">
                                  <input type="hidden" id="enlist_id" value="" name="">
                                  <input type="hidden" id="total_deposit" >
                                  
                              </form>
<?php endif; ?>
                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
