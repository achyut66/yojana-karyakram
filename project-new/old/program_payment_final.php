<?php require_once("includes/initialize.php");
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
$user=getUser();
$program_id=$_GET['id'];

$max_id= Programpaymentfinal::getMaxId($program_id);
$program_details = Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
$remaining_amount=($program_details->investment_amount)-($amount);
$program_payment_final_result= Programpaymentfinal::find_by_program_id2($program_id);
if (isset($_POST['submit'])) 
{
            $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id,$_POST['sn']);
           if(!empty($program_payment_final))
                    {
                       echo alertBox("अन्तिम भुक्तानी लगिसकेको ","program_payment_final.php?id=".$program_id);
                    }
         else 
                    {
                      $program =  new Programpaymentfinal ;
                      $paid_date_nepali = $_POST['paid_date'];
                      $paid_date_english = DateNepToEng($paid_date_nepali);
                      $_POST['paid_date_english'] = $paid_date_english;
                      $_POST['program_remaining_amount'] = $remaining_amount;
                      if ($program->savePostData($_POST)) 
                              {
                                echo alertBox("अन्तिम भुक्तानी हाल्न सफल ","program_payment_final.php?id=".$program_id);
     }
                    }
}

$enlist_ids = Programmoredetails::find_enlist_ids_by_program_id($program_id);
$sn_result= Programmoredetails::find_by_program_id($program_id);
$sn_result_final= Programpaymentfinal::find_by_program_id1($program_id);
  $sn_array= array();
  $sn_array_final= array();
  foreach ($sn_result as $sn):
	  $sn1=$sn->sn;
	  array_push($sn_array,$sn1);
  endforeach;
   foreach ($sn_result_final as $sn):
	  $sn2=$sn->sn;
	  array_push($sn_array_final,$sn2);
  endforeach;
 
 $sn_result1= array_diff($sn_array,$sn_array_final);
 $sn_result2 = array_unique($sn_result1);


?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>अन्तिम भुक्तानी :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">अन्तिम भुक्तानी / <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछी जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                             
             <?php if(!empty($program_payment_final_result)):?>
          <?php foreach($program_payment_final_result as $program_payment_final) :
                $program_more_details1 = Programmoredetails::find_by_program_id_and_sn($program_id, $program_payment_final->sn);
              
              ?>  
                         <h2 class="header1"> <?php if($program_more_details1->type_id == 5)
                                {
                                     $up_sam = Upabhoktasamitiprofile::find_by_id($program_payment_final->enlist_id);
                                     echo $up_sam->program_organizer_group_name." द्वारा लागिएको";
                                }
                                else
                                {
                                     echo Enlist::getName1($program_payment_final->enlist_id)." द्वारा लागिएको";
                                }  ?> </h2>
                                  <div style="display: none;" class="userprofiletable">
                                <table class="table table-bordered">
                                  <tr>
                                        <td>कर्यादेस न:</td>
                                        <td><?= convertedcit(placeholder($program_payment_final-> sn)) ?></td>     
                                        
                                    </tr>
                                            
                                            <tr>
                                                <td width="238">कार्यक्रमको बाँकी रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final-> program_remaining_amount));?></td>
                                            </tr>
                                              <tr>                                           
                                                <td width="238">भुक्तानी दिएको मिती</td>
                                                <td><?php echo convertedcit($program_payment_final-> paid_date);?></td>
                                            </tr>
                                               <tr>                                           
                                                <td width="238">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final-> total_payment_amount));?></td>
                                            </tr>
                                               <tr>                                           
                                                <td width="238">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final-> payment_taken_amount));?></td>
                                            </tr>
                                            <tr>
                                                <td width="238">धरौटी कट्टी रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final-> deposit_amount));?></td>
                                            </tr>
                                            <tr>
                                                <td width="238">जम्मा कट्टी रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final-> total_amount));?></td>
                                            </tr>
                                             <tr>
                                                <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                                <td><?php echo convertedcit(placeholder($program_payment_final->net_total_amount)) ;?></td>
                                            </tr>
                                   <?php if($program_payment_final->id==$max_id || $user->mode=="superadmin"):?>
                                                <tr>
                                                <a href="program_payment_final_edit.php?id=<?php echo $program_payment_final->id; ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">सच्याउनु होस्</button></a> <a href="program_payment_final_delete.php?id=<?php echo $program_payment_final->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">हटाउनु होस्</button></a>
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
                                                <select class="sn5" name="sn">
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
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><?= $remaining_amount ?></td>
                                    </tr>
                                      <tr>                                           
                                        <td width="238">भुक्तानी दिएको मिती</td>
                                        <td><input type="text" id="nepaliDate5" name="paid_date" ></td>
                                    </tr>
                                       <tr>                                           
                                        <td width="238">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                        <td>
                                            <input type="text" class="work_order_budget" value="0" name="total_payment_amount" readonly="true"/>
                                        </td>
                                    </tr>
                                       <tr>                                           
                                        <td width="238">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                        <td>
                                            <input type="text" class="program_payment" value="0" name="payment_taken_amount"  readonly="true"/> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">धरौटी कट्टी रकम</td>
                                        <td><input type="text" class="deposit_amount" value="0" name="deposit_amount" ></td>
                                    </tr>
                                  
                                     <tr>
                                        <td width="238">जम्मा कट्टी रकम</td>
                                        <td><input type="text"  value="0" name="total_amount" class="total_amount" readonly="true"></td>
                                     </tr>
                                     <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                        <td>
                                            <input type="text" name="net_total_amount" class="net_total_amount" readonly="true" /> 
                                        </td>
                                    </tr>
                                   
                                   <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                    </tr>
                                </table>
                                  <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                                  
                              </form>
<?php endif; ?>
                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>