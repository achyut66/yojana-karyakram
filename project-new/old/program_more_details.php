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
$postnames=  Workerdetails::find_by_sql("select * from worker_details where status=1");  

$program_id = $_GET['id'];
$i=0;



$program_details = Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
if(empty($amount))
{
    $remaining_amount=$program_details->investment_amount;
}
else
{
    $remaining_amount=($program_details->investment_amount)-($amount);
}


    



$program_selected_details = Programmoredetails::find_by_program_id($_GET['id']);
$total_budget= $program_details->investment_amount;

if (isset($_POST['submit']))
{
    $program_result=Programmoredetails::find_by_program_id_and_sn($program_id,$_POST['sn']);
    $program =  new Programmoredetails ;
    $start_date_nepali = $_POST['start_date'];
    $completion_date_nepali = $_POST['completion_date'];
    $start_date_english = DateNepToEng($start_date_nepali);
    $completion_date_english = DateNepToEng($completion_date_nepali);
    $_POST['start_date_english'] = $start_date_english;
    $_POST['completion_date_english'] = $completion_date_english;
    $_POST['remaining_budget']= $remaining_amount-$_POST['work_order_budget'];
    if ($program->savePostData($_POST)) 
            {
                $session->message("कार्यक्रम संचालन विवरण हाल्न सफल");
                redirect_to("training_expense.php?id=".$program_id);
            }
}

$new_sn = Programmoredetails::countSnByProgramId($_GET['id']) + 1 ;
?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>कार्यक्रम संचालन विवरण:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम संचालन विवरण  | दर्ता न:<?=convertedcit($_GET['id'])?>   | <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछि जानुहोस </a> </h2>
                 
                <div class="OurContentFull">
                    <div class="userprofiletable">
                    <h3><?php echo $program_details->program_name;?> :: <?="विनियोजित बजेट रु ".convertedcit(placeholder($program_details->investment_amount))." / कार्यक्रमको बाँकी रकम::रु ".convertedcit(placeholder($remaining_amount))?></h3>
            <?php
        if(!empty($program_selected_details)):
            foreach($program_selected_details as $details): 
            if(!empty($details->worker_id))
            {
            $worker= Workerdetails::find_by_id($details->worker_id);
            }
            
            $sn_check=Programpaymentfinal::check_sn($details->sn,$program_id); 
            $sn_check1= Programpayment::check_sn($details->sn,$program_id);
                                             if($details->type_id != 5)
                                             {
                                                  $enlist= Enlist::find_by_id($details->enlist_id);
                                                  $name = $enlist->name0.$enlist->name1.$enlist->name2.$enlist->name3.$enlist->name4; 
                                                  $address = $enlist->address0.$enlist->address1.$enlist->address2.$enlist->address3.$enlist->address4;
                                                  $number = $enlist->number0.$enlist->number1.$enlist->number2.$enlist->number3.$enlist->number4;
                                             }
                                             else
                                             {
                                                  $upabhokta_samiti = Upabhoktasamitiprofile::find_by_id($details->enlist_id);
                                                  $name = $upabhokta_samiti->program_organizer_group_name;
                                                  $address = 'वडा न : '.convertedcit($upabhokta_samiti->program_organizer_group_address);
                                                  $a_details = Upabhoktasamitidetails::find_adakshya($upabhokta_samiti->id);
                                                  $number = $a_details->mobile_no;
                                                  
                                             }
                                                
                                           
                                            if ($details->type_id == '0')
                                                {
                                                $organizer = "फर्म/कम्पनी";

                                                } 
                                            elseif ($details->type_id == '1') 
                                                {
                                                $organizer = "कर्मचारी";
                                                } 
                                            elseif ($details->type_id == '2') 
                                                {
                                                $organizer = "संस्था";
                                                }
                                            elseif ($details->type_id =='3') 
                                            {
                                                $organizer ="पदाधिकारी";
                                            }
                                            elseif ($details->type_id =='4' )
                                            {
                                                $organizer ="अन्य समूह";
                                            } 
                                            elseif ($details->type_id =='5' )
                                            {
                                                $organizer ="उपभोक्ता समिति";
                                            } 
            
            
            ?>

                           
                                <h3 class="header1">
                                <?php 
                                if($details->type_id == 5)
                                {
                                     $up_sam = Upabhoktasamitiprofile::find_by_id($details->enlist_id);
                                     echo $up_sam->program_organizer_group_name." द्वारा लागिएको";
                                }
                                else
                                {
                                     echo Enlist::getName1($details->enlist_id)." द्वारा लागिएको";
                                }
                                
                                  
                                ?>
                                </h3>
                              <div  style="display: none;" >
                              	  <div class="inputWrap100"></div>
                              
                              <table class="table table-bordered" >
                                
                                    <tr>
                                        <td width="238">कर्यादेस न:</td>
                                        <td><?= convertedcit(placeholder($details->sn));?></td>
                                    </tr>
                                   <tr>
                                        <td width="238">कार्यक्रमको  विनियोजित बजेट रु</td>
                                        <td><?= convertedcit(placeholder($program_details->investment_amount));?></td>
                                    </tr>

                                    <tr>
                                        <td width="238">कार्यादेश दिने निर्णय भएको मिति</td>
                                        <td><?= convertedcit($details->work_order_date);?></td>
                                    </tr>
                                     <tr>                                            
                                        <td width="238">कार्यादेशको नाम</td>
                                        <td><?= (($details->work_name));?></td>
                                    </tr>
                                    <tr>                                            
                                        <td width="238">कार्यादेश दिईएको रकम रु</td>
                                        <td><?= convertedcit(placeholder($details->work_order_budget));?></td>
                                    </tr>
                                    
                                    <tr>                                           
                                        <td width="238">कार्यक्रम शुरु हुने मिति</td>
                                        <td><?= convertedcit($details->start_date);?></td>
                                    </tr>
                                    <tr>                                         
                                        <td width="238">कार्यक्रम सम्पन्न हुने मिति</td>
                                        <td><?= convertedcit($details->completion_date);?></td>
                                    </tr>
                                  <tr>
	                                <td>कार्यक्रमको  संचालन गर्ने </td>
	                                <td><?php echo $organizer; ?></td>
	                            </tr>
                                    <tr>                               
                                    <td>कार्यक्रमको  संचालन गर्नेको  नाम</td>
                                    <td><?php echo $name; ?></td>
                                    </tr>
                                    <tr>
                                     <td>कार्यक्रमको  संचालन गर्नेको  ठेगाना </td>
                                     <td><?php echo $address;?></td>
                                    </tr>
                                    <tr>
                                     <td>कार्यक्रमको  संचालन गर्नेको  सम्पर्क नं</td>
                                     <td><?php echo convertedcit($number);?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">कार्यक्रम संचालन हुने स्थान</td>
                                        <td><?= $details->venue;?></td>
                                    </tr>
                      <?php if(!empty($details->worker_id)) : ?>
                                      <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                    <td><?= $worker->authority_name;   ?></td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><?= $worker->post_name ?></td>
                                  </tr>
                                  
                                  <tr>
                                    <td>मिती</td>
                                    <td><?= convertedcit($details->samjhauta_miti) ?></td>
                                  </tr>
                        <?php endif; ?>          
                                    
                                   
                                      <?php if(($sn_check==0 && $sn_check1==0)||$user->mode=="superadmin"||$user->mode=="administrator"):?>
                                                <tr>
                                                <a href="program_more_details_edit.php?id=<?php echo $details->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere btn" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')" >सच्याउनु होस्</button></a> <a href="program_more_details_delete.php?id=<?php echo $details->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere btn" onClick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')" >हटाउनु होस्</button></a>
                                               </tr>
                                             <?php endif;?>
                                </table>
                                
                                
                         <h3>कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3> 
                               <table class="table table-bordered ">
                                <tr>
                                	
                                    <th class="text-center">घर परिवार संख्या</th>
                                  <th class="text-center">महिला</th>
                                  <th class="text-center">पुरुष</th>
                                  <th class="text-center">जम्मा</th>
                                </tr>
                                
                                 
                                  <tr>
                                  <td><?= convertedcit($details->total_family_members);?></td>
                                  <td><?= convertedcit($details->female);?></td>
                                  <td><?= convertedcit($details->male);?></td>
                                  <td><?= convertedcit($details->total_members);?></td>
                                  </tr>               
                                             
                                </table>   
           </div>
                          
                     <?php endforeach;?>
       <?php endif; ?>
                       <?php  if($remaining_amount!=0):?>              
                        <div>
                          
                      
                                 <h3> नया कार्यक्रमको  विवरण थप्नुहोस + </h3>
                                 
                                 <form method="post">
                                 <table class="table table-bordered" >
                                     <tr>
                                        <td width="238">कर्यादेस न</td>
                                        <td><?php echo convertedcit($new_sn);?> <input type="hidden" name="sn" value="<?=$new_sn?>" /></td>
                                    </tr>
                                    <tr>
                                        <td width="238">कार्यक्रमको  विनियोजित बजेट रु</td>
                                        <td><?=$total_budget?>
                                      <input type="hidden" id="total_budget" name="budget" value="<?= $total_budget ?>" ></td>
                                    </tr>

                                    <tr>
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><?= $remaining_amount ?>
                                            
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="238">कार्यादेश दिने निर्णय भएको मिति</td>
                                        <td><input type="text" id="nepaliDate9" name="work_order_date" ></td>
                                    </tr>
                                     <tr>                                            
                                        <td width="238">कार्यादेशको नाम</td>
                                         <td><input type="text" id="work_name" name="work_name" ></td>
                                    </tr>
                                    
                                    <tr>                                            
                                        <td width="238">कार्यादेश दिईएको रकम रु</td>
                                        <td><input type="text" class="work_budget" name="work_order_budget" ></td>
                                    </tr>
                                    
                                    <tr>                                           
                                        <td width="238">कार्यक्रम शुरु हुने मिति</td>
                                        <td><input type="text" id="nepaliDate3" name="start_date" ></td>
                                    </tr>
                                    
                                    <tr>                                         
                                        <td width="238">कार्यक्रम सम्पन्न हुने मिति</td>
                                        <td><input type="text" id="nepaliDate5" name="completion_date" ></td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="238">कार्यक्रम संचालन हुने स्थान</td>
                                        <td><input type="text" id="topictype_name" name="venue" ></td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="238">कार्यक्रमको  संचालन गर्ने</td>
                                        <td>  
                                      <select name="type_id" required class="show">
                                               <option value="">छान्नुहोस्</option>
                                               <option value="0" >फर्म/कम्पनी</option>
                                               <option value="1" >कर्मचारी</option>
                                               <option value="2" >संस्था</option>
                                               <option value="3" >पदाधिकारी</option>
                                               <option value="4" >अन्य समूह </option>
                                               <option value="5" >उपभोक्ता समिति </option>
                                           </select>
                                        </td>
                                     </tr>
                                     <tr id="type">
                                     </tr>
                                  <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                     <td>
                                         <select name="worker_id" required class="authority_name1" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party==$name->id){?> selected="selected" <?php } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><input class="authority_post1" type="text" /></td>
                                  </tr>
                                  
                                  <tr>
                                    <td>मिती</td>
                                    <td><input type="text" name="samjhauta_miti" id="nepaliDate15" /></td>
                                  </tr>    
                                </table>
                                
                                
                         <h3>कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3> 
                               <table class="table table-bordered ">
                                <tr>
                                	
                                    <th class="text-center">घर परिवार संख्या</th>
                                  <th class="text-center">महिला</th>
                                  <th class="text-center">पुरुष</th>
                                  <th class="text-center">जम्मा</th>
                                </tr>
                                
                                 
                                  <tr>
                                  <td><input type="text" class="row1-family input100percent" name="total_family_members" /></td>
                                  <td><input type="text" class="row2"  name="female" /></td>
                                  <td><input type="text" class="row2"    name="male" /></td>
                                  <td><input type="text" id="row2-value" class="input100percent" name="total_members"/></td>
                                  </tr>               
                                             
                               </table>
                           <table class="table table-bordered">    
                                    <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit"  name="submit" value="सेभ गर्नुहोस" class="submithere submit2"></td>
                                       <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                                        <input type="hidden" class="remaining_amount" value="<?= $remaining_amount ?>"/>
                                       
                                    </tr>
                                </table>
                                 </form> 
                                 
                          

                                 </div> 
                    <?php endif; ?>
                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>