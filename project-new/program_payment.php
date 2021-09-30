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

$max_id= Programpayment::getMaxId($program_id);
$program_payment_result= Programpayment::find_by_program_id2($program_id);

if(isset($_POST['submit']))
{     
    $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $_POST['sn']);
    
   
   $program_payment= Programpayment::find_by_program_id_and_sn($program_id,$_POST['sn']);
   if(!empty($program_payment))
            {
              $session->message("पेश्की लगिसकेको ");
              redirect_to("program_payment.php?id=".$program_id);
            }
 else 
            {
             $payment =  new Programpayment ;
             $paid_date_nepali = $_POST['paid_date'];
             $payment_flow_date_nepali = $_POST['payment_flow_date'];
             $paid_date_english = DateNepToEng($paid_date_nepali);
             $payment_flow_date_english = DateNepToEng($payment_flow_date_nepali);
             $_POST['paid_date_english'] = $paid_date_english;
             $_POST['payment_flow_date_english'] = $payment_flow_date_english;
                if($payment->savePostData($_POST))
                        {
                            echo alertBox("कार्यक्रम  संचालनमामा पेश्की हाल्न सफल","program_payment.php?id=".$program_id);
                     }
           }
        
 }

  

  $enlist_ids = Programmoredetails::find_enlist_ids_by_program_id($program_id);


  $sn_result= Programmoredetails::find_by_program_id($program_id);
  $sn_result_payment= Programpayment::find_by_program_id1($program_id);
  $sn_result_payment_final= Programpaymentfinal::find_by_program_id2($program_id);
  
  $sn_array= array();
  $sn_array_payment= array();
   $sn_array_payment_final= array();
  foreach ($sn_result as $sn):
	  $sn1=$sn->sn;
	  array_push($sn_array,$sn1);
  endforeach;
   foreach ($sn_result_payment as $sn):
	  $sn2=$sn->sn;
	  array_push($sn_array_payment,$sn2);
  endforeach;
   foreach ($sn_result_payment_final as $sn):
	  $sn3=$sn->sn;
	  array_push($sn_array_payment_final,$sn3);
  endforeach;
 
 $sn_result1= array_diff($sn_array,$sn_array_payment);
 $sn_result2 = array_unique($sn_result1);
 $sn_result3 =array_diff($sn_result2,$sn_array_payment_final);
 $sn_result4 = array_unique($sn_result3);
 
?>
<?php include("menuincludes/header.php");
include("menu/header_script.php");?>
<!-- js ends -->
<title>कार्यक्रम  संचालनमामा पेश्की:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम  संचालनमामा पेश्की | दर्ता न:<?=convertedcit($_GET['id'])?>  / <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछी जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                        <?php echo $message; ?>
                                	
                    <?php if(!empty($program_payment_result)):?>
          <?php foreach($program_payment_result as $program_payment) : 
              
              $program_more_details1 = Programmoredetails::find_by_program_id_and_sn($program_id, $program_payment->sn);
              ?>
                       
               
                                       <h2 class="header1">
                                       <?php 
                                if($program_more_details1->type_id == 5)
                                {
                                     $up_sam = Upabhoktasamitiprofile::find_by_id($program_payment->enlist_id);
                                     echo $up_sam->program_organizer_group_name." द्वारा लागिएको";
                                }
                                else
                                {
                                     echo Enlist::getName1($program_payment->enlist_id)." द्वारा लागिएको";
                                }
                                
                                  
                                ?>
                                       </h2>
                                        <div style="display: none;" class="userprofiletable" >
                                        <table class="table table-bordered">
                                             <tr>
	                                        <td>कर्यादेस न:</td>
	                                        <td><?= convertedcit(placeholder($program_payment-> sn)) ?></td>     
                                        
                                           </tr>
                                            <tr>
                                            <td> पेश्की लिने मुख्य व्यक्तीको नाम</td>
                                            <td><?php echo $program_payment->payment_holder_name; ?></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको बाबुको नाम</td>
                                            <td><?php echo $program_payment->payment_holder_father_name; ?></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको  बाजेको नाम</td>
                                            <td><?php echo $program_payment->payment_holder_grandfather_name; ?></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की रकम </td>
                                            <td><?php echo convertedcit(placeholder($program_payment->payment_amount)); ?></td>
                                          </tr>
                                            <tr>
                                            <td> पेश्की दिएको मिती</td>
                                            <td><?php echo convertedcit($program_payment->paid_date); ?></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की फर्छ्यौट गर्नु पर्ने मिति</td>
                                            <td><?php echo convertedcit($program_payment->payment_flow_date); ?></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की दिनु पर्ने कारण</td>
                                            <td><?php echo $program_payment->payment_reason; ?></td>
                                          </tr>
                                           <?php 
                                           $sn_check=Programpaymentfinal::check_sn($program_payment->sn,$program_id);
                                           if($sn_check==0 || $user->mode=="superadmin"):?>
                                                <tr>
                                                <a href="program_payment_edit.php?id=<?php echo $program_payment->id; ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">सच्याउनु होस्</button></a> <a href="program_payment_delete.php?id=<?php echo $program_payment->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">हटाउनु होस्</button></a>
                                               </tr>
                                             <?php endif;?>
                                    </table>
        
                        </div>
                          <?php endforeach; ?>                  
         <?php endif; ?>
         <?php if(!empty($sn_result4)) : ?>
                    	<h2>कार्यक्रम  संचालनमामा पेश्की थप्नुहोस +</h2>
                        <div class="userprofiletable">
         
                           <form method="POST" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                       <h3> नया कार्यक्रम संचालनमामा पेश्की थप्नुहोस + </h3>
                                       <tr>
                                          <td>कर्यादेस न:</td>
                                            <td>
                                                <select id="sn_payment" name="sn">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($sn_result4 as $sn):?>
                                                    <option value="<?= $sn ?>"><?= $sn ?></option>
                                                    <?php endforeach; ?>
                                                    <input type="hidden" value="<?= $program_id ?>" id="program_id">
                                                </select> 
                                            </td>
                                      </tr>
                                         <tr class="enlist1">
                                             
                                         </tr>
                                            <tr>
                                            <td> पेश्की लिने मुख्य व्यक्तीको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_name" required ></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको बाबुको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_father_name" required ></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की लिने मुख्य व्यक्तीको  बाजेको नाम</td>
                                            <td><input type="text" id="topictype_name" name="payment_holder_grandfather_name" required ></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की रकम </td>
                                            <td><input type="text" id="work_order_budget" name="payment_amount" required value="0"></td>
                                          </tr>
                                            <tr>
                                            <td> पेश्की दिएको मिती</td>
                                            <td><input type="text" id="nepaliDate9" name="paid_date" required></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की फर्छ्यौट गर्नु पर्ने मिति</td>
                                            <td><input type="text" id="nepaliDate15" name="payment_flow_date" required ></td>
                                          </tr>
                                            <tr>
                                            <td>पेश्की दिनु पर्ने कारण</td>
                                            <td><input type="text" id="topictype_name" name="payment_reason" required ></td>
                                          </tr>
                                          
                                          <tr>
                                           <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere" id="submit_payment"></td>
                                          </tr>
                                        </table>
                                     <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                                     <input type="hidden" name="budget" value="" id="budget" > 
                           </form>
               <?php endif ?>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>