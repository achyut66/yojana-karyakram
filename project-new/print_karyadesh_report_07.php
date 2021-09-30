<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();

?>
<?php
$workers = Workerdetails::find_all();
$program_id=$_GET['id'];
$data1= Plandetails1::find_by_id($_GET['id']);
    //print_r($data1);
$data2=  Moreplandetails::find_by_plan_id($_GET['id']);
$data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
$sn_result= Programmoredetails::find_by_program_id($program_id);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
if(isset($_POST['submit']))
{
    $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $_POST['sn']);
    if($program_more_details->type_id == 5)
    {
       $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
       $name= $u_samiti->program_organizer_group_name;
   }
   else
   {
     $name =Enlist::getName1($program_more_details->enlist_id);   
 }    
 $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $_POST['sn']);
//            print_r($program_payment_final);
 $program_payment= Programpayment::find_by_program_id_and_sn($_GET['id'],$_POST['sn']);

}
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
}
$budget_result= KattiWiwarn::find_by_sql("select * from settings_katti_wiwarn where what_is = 2");
$program_katti = ProgramKatti::find_by_plan_id($program_id);
//print_r($program_katti);
//$abc = KattiWiwarn::find_by_sql("SELECT * FROM settings_katti_wiwarn LEFT JOIN program_katti_bibaran ON settings_katti_wiwarn.id = program_katti_bibaran.topic_name");
//echo "<pre>";
//print_r($abc);


?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>रकम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">

                <div class="maincontent" >
                    <h2 class="headinguserprofile">विषय:- रकम भुक्तानी सम्बन्धमा || <a href="letters_select_programs.php" class="btn">पछी जानुहोस </a></h2>
                    

                    <div class="OurContentFull" >
                      <form method="post">
                       <table class="table table-bordered">
                        <tr>
                            <td>कार्यादेश नं:</td>
                            <td>
                             <select required class="sn1" name="sn">
                                <option value="">--छान्नुहोस्--</option>
                                <?php foreach($sn_result as $sn):?>
                                    <option value="<?= $sn->sn ?>"><?= $sn->sn ?></option>
                                <?php endforeach;?>
                                <input type="hidden" value="<?= $program_id ?>" id="program_id1">
                            </select>   
                        </td>
                    </tr>
                    <tr class="enlist2">

                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" value="खोज्नुहोस" name="submit" class="btn"/>
                        </td>
                    </tr>
                </table>                           
            </form>
            <?php if(!empty($program_payment_final)):?>
             <h2>विषय:- रकम भुक्तानी सम्बन्धमा ।</h2> 
             <form method="get" action="print_karyadesh_report_07_final.php?id=<?=$_GET['id']?>" target="_blank" >
                <div class="myPrint"><input type="hidden" name="id" value="<?=$program_id?>" />
                    <input type="hidden" name="detail_id" value="<?=$program_more_details->id?>" />
                    <input type="hidden" name="sn" value="<?=$_POST['sn']?>" />
                    <input type="hidden" name="final_id" value="<?=$program_payment_final->id?>" />
                    <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    <div class="userprofiletable" id="div_print">
                       <div class="printPage">
                         <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                         <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                         <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                         <h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
                         <div class="subjectbold letter_subject">टिप्पणी आदेश</div>
                     </div>
                     <div class="myspacer"></div>

                     <div class="printContent">
                      <div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate(); ?>" id="nepaliDate5" /></form></div>
                      <div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>

                      <div class="chalanino">कार्यक्रम दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
                      <div class="myspacer20"></div>

                      <div class="subject">   विषय:- रकम भुक्तानी सम्बन्धमा ।</div>
                      <div class="myspacer20"></div>
                      <div class="bankname">श्रीमान् 
                      </div>

                      <div class="banktextdetails"  >
                         यस कार्यालय अन्तरगत वार्ड नं <b><?php echo convertedcit($data1->ward_no);?></b> स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न
                         श्री <b><?= $name ?></b>लाई मिति  <b><?= convertedcit($program_more_details->work_order_date)?></b>
                         मा कार्यादेश दिईएकोमा तोकिएको समय भित्रै काम सम्पन गरि आवश्यक कागज संलग्न राखी मिति <b><?php echo convertedcit($program_payment_final->paid_date);?></b> गते रकम भुक्तानी माग गरेकाले तपशिल बमोजिम भुक्तानी दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
                     </div>


                     <div class="subject">तपशिल</div>

                     <table class="table table-bordered table-responsive myWidth100">
                        <tr>
                         <td class="myWidth50">कार्यादेश नं: </td>
                         <td> <?php echo convertedcit($program_more_details->sn);?></td>
                     </tr>                                            	
                     <tr>
                        <td>बिनियोजन श्रोत र व्याख्या: </td>
                        <td> <?php echo $data1->parishad_sno;?></td>
                    </tr>
                    <tr>
                     <td>कार्यक्रमको नाम : </td>
                     <td><?php echo convertedcit($data1->program_name);?></td>
                 </tr>
                 <tr>
                     <td>कार्यक्रम संचालनको उदेश्य : </td>
                     <td><?php echo $sn->aim;?></td>
                 </tr>
                 <tr>
                     <td>भुक्तानी पाउनेको नाम: </td>
                     <td><?= $name ?></td>
                 </tr>

                 <tr>
                     <td>कार्यादेश  दिईएको रकम : </td>
                     <td>रु. <?php echo convertedcit(placeholder($program_more_details->work_order_budget));?>/-</td>
                 </tr>

                 <!-- change made-->
                 <tr>
                     <td>पेश्की भुक्तानी लगेको कट्टी रकम  : </td>
                     <td> रु. <?php echo convertedcit(placeholder($program_payment->payment_amount));?>/-</td>
                 </tr>
                         <?php foreach($budget_result as $br):
//                             print_r($br);
                             ?>
                         <tr>
                             <td><?=$br->topic.' '.'('.$br->percent.')'?></td>
                             <td><?php
                                 $hh = ProgramKatti::find_by_topic_id($br->id) ?>
                                 रु. <?=convertedcit($hh->katti_kar);?>/-
                             </td>
                         </tr>
                        <?php endforeach;?>
                         <tr>
                             <td>कन्टिन्जेन्सी -:</td>
                             <td>रु. <?=convertedcit($program_payment_final->cont)?>/-</td>
                         </tr>
                         <tr>
                             <td>मर्मत -:</td>
                             <td>रु. <?=convertedcit($program_payment_final->marmat)?>/-</td>
                         </tr>
                         <tr>
                             <td>बिपत -:</td>
                             <td>रु. <?=convertedcit($program_payment_final->bipat)?>/-</td>
                         </tr>
                         <tr>
                                 <td>जम्मा कट्टी रकम  : </td>
                                 <td> रु.<?php echo convertedcit(placeholder($program_payment_final->katti_amt));?>/-</td>
                         </tr>
                         <tr>
                                 <td>हाल भुक्तानी दिनु पर्ने खुद रकम   : </td>
                                 <td> रु.<?php echo convertedcit(placeholder($program_payment_final->net_total_amount));?>/-</td>
                         </tr>
                         <tr>
                                <td>संस्थाको खाता नं :</td>
                                <td><?php echo convertedcit($program_payment_final->sanstha_acc_no);?></td>
                         </tr>
                        </table>
                    </div>
                    <div class="myspacer20"></div>
                    <div class="oursignature mymarginright"> सदर गर्ने <br> 
                        <select name="worker1" class="form-control worker" id="worker_1">
                            <option value="">छान्नुहोस्</option>
                            <?php foreach($workers as $worker){?>
                                <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                            <?php }?>
                        </select>
                        <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                    </div>
                    <div class="oursignatureleft mymarginright"> पेस गर्ने <br/>
                        <select name="worker2" class="form-control worker" id="worker_2">
                            <option value="">छान्नुहोस्</option>
                            <?php foreach($workers as $worker){?>
                                <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                            <?php }?>
                        </select>
                        <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                    </div>
                    <div class="oursignatureleft margin4" style="margin-left: 245px">सिफारिस गर्ने<br/> 
                        <select name="worker4" class="form-control worker" id="worker_4">
                            <option value="">छान्नुहोस्</option>
                            <?php foreach($workers as $worker){?>
                                <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                            <?php }?>
                        </select>
                        <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>"></form>
                    </div>
                    <div class="myspacer"></div>
                </div>
            <?php endif ;?>

        </div>
    </div>
</div>
</div><!-- main menu ends -->
</div>
</div>   
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>