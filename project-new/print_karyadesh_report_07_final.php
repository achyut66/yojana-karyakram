<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$ward_address=WardWiseAddress();
$address= getAddress();

$data1=  Plandetails1::find_by_id($_GET['id']);
$data2=  Moreplandetails::find_by_plan_id($_GET['id']);
$data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id);
$program_id=$_GET['id'];
$program_more_details= Programmoredetails::find_by_id($_GET['detail_id']);
if($program_more_details->type_id == 5)
{
 $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
 $name= $u_samiti->program_organizer_group_name;
}
else
{
   $name =Enlist::getName1($program_more_details->enlist_id);   
}    
$program_payment_final= Programpaymentfinal::find_by_id($_GET['final_id']);
$program_payment=  Programpayment::find_by_program_id_and_sn($_GET['id'],$_GET['sn']);
$date_selected= $_GET['date_selected'];

$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];
$print_history->save();

if(!empty($_GET['worker1']))
{
    $worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker2']))
{
    $worker2 = Workerdetails::find_by_id($_GET['worker2']);
}
else
{
    $worker2 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker3']))
{
    $worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker4']))
{
    $worker4 = Workerdetails::find_by_id($_GET['worker4']);
}
else

{
    $worker4 = Workerdetails::setEmptyObject();
}
$budget_result= KattiWiwarn::find_by_sql("select * from settings_katti_wiwarn where what_is = 2");
$program_katti = ProgramKatti::find_by_plan_id($program_id);
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यादेश  पत्र  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
           <div class="printPage">

            <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
            <h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
            <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
            <h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
            <div class="myspacer"></div>

            <div class="printContent">
                <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
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
                <table class="table table-bordered myWidth100">
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
            <?php 
            if(!empty($worker1))
            {
                echo $worker1->authority_name."<br/>";
                echo $worker1->post_name;
            }
            ?>
        </div>
        <div class="oursignatureleft mymarginright"> पेस गर्ने  <br/>
            <?php 
            if(!empty($worker2))
            {
                echo $worker2->authority_name."<br/>";
                echo $worker2->post_name;
            }
            ?>
        </div>
        <div class="oursignatureleft" style="margin-left: 120px"> सिफारिस गर्ने   <br/>
            <?php 
            if(!empty($worker4))
            {
                echo $worker4->authority_name."<br/>";
                echo $worker4->post_name;
            }
            ?>
        </div>
        <div class="myspacer"></div>
    </div><!-- print page ends -->
</div><!-- userprofile table ends -->
</div><!-- my print final ends -->