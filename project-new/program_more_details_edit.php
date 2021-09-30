<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php

$id=$_GET['id'];
$program_id=$_GET['program_id'];
$program_details = Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
$remaining_amount=($program_details->investment_amount)-($amount);
$program_more_details= Programmoredetails::find_by_id($id);
if(!empty($program_more_details->worker_id))
{
$worker= Workerdetails::find_by_id($program_more_details->worker_id);
}
else
{
$worker="";
}
//print_r($program_more_details);exit;

$enlist= Enlist::find_by_id($program_more_details->enlist_id);
$postnames=  Workerdetails::find_by_sql("select * from worker_details where status=1"); 
if (isset($_POST['submit'])) {
    $update_id=$_POST['update_id'];
    $program =  Programmoredetails::find_by_id($update_id);
    $start_date_nepali = $_POST['start_date'];
    $completion_date_nepali = $_POST['completion_date'];
    $start_date_english = DateNepToEng($start_date_nepali);
    $completion_date_english = DateNepToEng($completion_date_nepali);
    $_POST['start_date_english'] = $start_date_english;
    $_POST['completion_date_english'] = $completion_date_english;
    $_POST['remaining_budget']= $program_details->investment_amount-$_POST['work_order_budget'];
    if ($program->savePostData($_POST)) {
        $session->message("कार्यक्रम संचालन विवरण सच्याउनु सफल");
        redirect_to("program_more_details.php?id=".$program->program_id);
    }
}

?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>कार्यक्रम संचालन विवरण:: <?= SITE_TITLE ?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम संचालन विवरण सच्याउनु होस्</h2>
                   
                    <div class="OurContentFull">
                        <h2>कार्यक्रम संचालन विवरण सच्याउनु होस् </h2>
                        <div class="userprofiletable">
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="238">कार्यक्रमको  विनियोजित बजेट रु</td>
                                        <td><input type="text" id="topictype_name" name="budget" value="<?php echo $program_details->investment_amount; ?>" readonly="true"</td>
                                    </tr>
                                    <tr>
                                        <td width="238">कन्टिन्जेन्सी - <label>
                                            <input type="text" name="con_per" id="con_per" value="<?php echo $program_more_details->con_per;?>" placeholder="%" size="4" style="border-color:yellow" />
                                        </label></td>
                                        <td><input type="text" id="contingency" name="contingency" value="<?php echo $program_more_details->contingency; ?>" readonly="true"</td>
                                    </tr>
                                    <tr>
                                        <td width="238">विपद व्यवस्थापन - <label>
                                            <input type="text" name="bipat_per" id="bipat_per" placeholder="%" value="<?php echo $program_more_details->bipat_per;?>" size="4" style="border-color:yellow" />
                                        </label></td>
                                        <td><input type="text" id="bipat" name="bipat" value="<?php echo $program_more_details->bipat; ?>" readonly="true"</td>
                                    </tr>
                                    <tr>
                                        <td width="238">मर्मत सम्भार - <label>
                                            <input type="text" name="marmat_per" id="marmat_per" size="4" value="<?php echo $program_more_details->marmat_per;?>" placeholder="%" style="border-color:yellow" />
                                        </label></td>
                                        <td><input type="text" id="marmat" name="marmat" value="<?php echo $program_more_details->marmat; ?>" readonly="true"</td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="238">कार्यादेश दिने निर्णय भएको मिति</td>
                                        <td><input type="text" id="nepaliDate3" name="work_order_date" value="<?= $program_more_details->work_order_date ?>" /></td>
                                    </tr>
                                    <tr>                                            
                                        <td width="238">कार्यादेश दिईएको रकम रु</td>
                                        <td><input type="text" class="work_budget" id="karyadesh_rakam" name="work_order_budget" value="<?php echo $program_more_details->work_order_budget; ?>" /></td>
                                    </tr>
                                    <tr>                                           
                                        <td width="238">कार्यक्रम शुरु हुने मिति</td>
                                        <td><input type="text" id="nepaliDate15" name="start_date" value="<?=  $program_more_details->start_date ?>" /></td>
                                    </tr>
                                    <tr>                                         
                                        <td width="238">कार्यक्रम सम्पन्न हुने मिति</td>
                                        <td><input type="text" name="completion_date" id="nepaliDate10" value="<?= $program_more_details->completion_date ?>" /></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td width="238">कार्यक्रम संचालन हुने स्थान</td>
                                        <td><input type="text" id="topictype_name" name="venue" value="<?php echo $program_more_details->venue; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td width="238">कार्यक्रम संचालनको उदेश्य </td>
                                        <td><textarea type="text" id="aim" name="aim" value="<?php echo $program_more_details->aim; ?>" /></textarea></td>
                                    </tr>
                                     <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                     <td>
                                         <select name="worker_id" required class="authority_name1" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($program_more_details->worker_id==$name->id){?> selected="selected" <?php } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><input class="authority_post1" value="<?= $worker->post_name ?>" type="text" readonly="true" /></td>
                                  </tr>
                                  
                                  <tr>
                                    <td>मिती</td>
                                    <td><input type="text" name="samjhauta_miti" id="nepaliDate12" value="<?= $program_more_details->samjhauta_miti ?>" /></td>
                                  </tr> 
                                    <tr>
                                        <td width="238">कार्यक्रमको  संचालन गर्ने</td>
                                        <td>
                                            <select name="type_id" id="show2">
                                               <option value="">छान्नुहोस्</option>
                                               <option <?php if($program_more_details->type_id==="0"){echo "selected='selected'";} ?> value="0" >फर्म/कम्पनी</option>
                                               <option  <?php if($program_more_details->type_id==="1"){echo "selected='selected'";} ?> value="1" >कर्मचारी</option>
                                               <option <?php if($program_more_details->type_id==="2"){echo "selected='selected'";} ?>  value="2" >संस्था</option>
                                               <option <?php if($program_more_details->type_id==="3"){echo "selected='selected'";} ?>  value="3">पदाधिकारी</option>
                                                <option <?php if($program_more_details->type_id==="4"){echo "selected='selected'";} ?>  value="4">अन्य समूह</option>
                                                 <option <?php if($program_more_details->type_id==="5"){echo "selected='selected'";} ?>  value="5">उपभोक्ता समिति</option>
                                                 <option <?php if($program_more_details->type_id==="6"){echo "selected='selected'";} ?>  value="6">बिद्यालय</option>
                                           </select>
                                        </td>
                                     </tr>
                                     <?php
                                     
                                     if($program_more_details->type_id==5)
                                     {
                                          $names= Upabhoktasamitiprofile::find_all();
                                         
                                     }
                                     else
                                     {
                                           $names=Enlist::getname_by_type_id($program_more_details->type_id);
                                     }
                                   
                                             
                                             ?>
                                     <tr id="type3">
                                         <td>&nbsp;</td>
                                         <td>
                                        
                                             <select name="enlist_id">
                                             <option value="">छान्नुहोस्</option>
                                             <?php foreach ($names as $name):
                                                  if($program_more_details->type_id==5)
                                                            { 
                                                              $naam = $name->program_organizer_group_name.', वडा न: '.convertedcit($name->program_organizer_group_address);
                                                            }
                                                            else
                                                            {
                                                              $naam= $name->name0.$name->name1.$name->name2.$name->name3.$name->name4;
                                                            }
                                                 
                                                 ?>
                                             <option <?php if($program_more_details->enlist_id==$name->id){echo "selected='selected'";} ?> value="<?php echo $name->id; ?>" ><?= $naam ?></option>
                                            <?php endforeach;?>
                                             </select>
                                        
                                         </td>
                                     </tr>
                                 </table>
                                 <table id="type">
                                 </table>
                                <table class="table table-bordered table-responsive">
                                   
                                  
                                    <h3>कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण<h3> 
                               
                                <tr>
                                	
                                    <td>घर परिवार संख्या</td>
                                    <td>महिला</td>
                                    <td >पुरुष</td>
                                    <td >जम्मा</td>
                                </tr>
                                
                                 
                                  <tr>
                                  <td><input type="text" class="row1-family input100percent" name="total_family_members" value="<?php echo $program_more_details->total_family_members; ?>"/></td>
                                  <td><input type="text" class="row2"  name="female" value="<?php echo $program_more_details->female; ?>" /></td>
                                  <td><input type="text" class="row2"    name="male" value="<?php echo $program_more_details->male; ?>" /></td>
                                  <td><input type="text" id="row2-value" class="input100percent" name="total_members"value="<?php echo $program_more_details->total_members; ?>"/></td>
                                  </tr>               
                                             
                                </table>
                           <table class="table table-bordered">    
                                    <tr>
                                         <td width="238">&nbsp;</td>
                                         <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere submit2"></td>
                                         <input type="hidden" name="program_id" value="<?php echo $program_more_details->program_id;?>"/>
                                          <input type="hidden" name="update_id" value="<?php echo $program_more_details->id?>"/>
                                         
                                    </tr>
                                </table>
                                                
                                
                                <input type="hidden" name="sn" value="<?= $program_more_details->sn  ?>"/>
                                <input type="hidden" class="remaining_amount" value="<?= $remaining_amount + $program_more_details->work_order_budget  ?>"/>
                                
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    
    <script type="text/javascript" src="calendar/js/jquery-2.1.0.min.js"></script> 
        <script type="text/javascript" src="calendar/js/jquery-1.7.1.min.js"></script>
        <script>
        JQ(document).ready(function(){
           JQ(document).on("input","#con_per,#bipat_per,#marmat_per",function(){
              
            var budget = JQ("#topictype_name").val();
            var con_per = JQ("#con_per").val()||0;
            var bipat_per = JQ("#bipat_per").val()||0;
            var marmat_per = JQ("#marmat_per").val()||0;
            
            var contingency_amt = parseFloat(budget*con_per/100);
            var contingency_amt = (contingency_amt).toFixed(2);
            var bipat_amt       = parseFloat(budget*bipat_per/100);
            var bipat_amt = (bipat_amt).toFixed(2);
            var marmat_amt      = parseFloat(budget*marmat_per/100);
            var marmat_amt = (marmat_amt).toFixed(2);
            
            JQ("#contingency").val(contingency_amt);
            JQ("#bipat").val(bipat_amt);
            JQ("#marmat").val(marmat_amt);
            
            var karyadesh = parseFloat(budget)-contingency_amt-bipat_amt-marmat_amt;
            
            JQ("#karyadesh_rakam").val(karyadesh);
           }); 
        });
    </script>