<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
error_reporting(1);
$ward_address=WardWiseAddress();
$address= getAddress();

$date_selected= $_GET['date_selected'];
$url = get_base_url();
$user = getUser();
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
?>
<?php $data1=  Plandetails1::find_by_id($_GET['id']);
$result = Plantotalinvestment::find_by_plan_id($_GET['id']);
if(!empty($result))
{
    $data2=  Plantotalinvestment::find_by_plan_id($_GET['id']);
    $data3= Moreplandetails::find_by_plan_id($_GET['id']);
    $name = "उपभोक्ताबाट";
}
else
{
    $data2= AmanatLagat::find_by_plan_id($_GET['id']);
    $data3= Amanat_more_details::find_by_plan_id($_GET['id']);
    $name = "";
}
$percent = ($data2->costumer_agreement / $data1->investment_amount ) * 100;
$percent1 = ($data2->agreement_gauplaika / $data1->investment_amount) * 100;
$percent_final = round( $percent, 2, PHP_ROUND_HALF_UP);
$percent_final1 = round( $percent1, 2, PHP_ROUND_HALF_UP);
$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$group_heading = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>विषय:- योजना संझौता सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?>.</title>
<style>
  table {

    width: 100%;
    border: none;
}
th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 3px solid #ddd;
}

tr:nth-child(even) {background-color: #f2f2f2;}
tr:hover {background-color:#f5f5f5;}
</style>
</head>

<body>

    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
           <div class="printPage">
               <div class="image-wrapper">
                <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                <div />

                <div class="image-wrapper">
                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                    <div />
                    <div style="color:red">
                       <h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
                       <h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>

                       <h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
                       <h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                   </div>
                   <div class="myspacer"></div>
                   <div class="subjectboldright letter_subject">टिप्पणी आदेश</div><div class="myspacer"></div>
                   <div class="printContent">
                      <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                      <div class="patrano">आ.व. : <?php echo convertedcit($fiscal->year); ?></div>
                      <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                      <div class="myspacer"></div>

                      <div class="subject">
                          <u>विषय:-
                              <?php if(!empty($_GET['subject'])){
                              echo $_GET['subject'];
                              }else{
                              echo "योजना संझौता सम्बन्धमा ।";
                              }?>
                          </u>
                      </div>
                      <div class="myspacer"></div>
                      <div class="bankname" style="margin-top: 15px;">श्रीमान , </div>

                      <div class="banktextdetails">
                        यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार देहायको योजना संचालनको लागि देहायको विवरण अनुसारको यसै साथ संलग्न स्पेसिफिकेशन, परिमाण, दर र कुल रकम अनुसारको लागत अनुमान स्वीकृत गरि देहायको उपभोक्ता समितसंग यसैसाथ संलग्न शर्तहरुको अधिनमा रही उपभोक्ता समितसंग योजना सम्झौता गरि योजना निर्माण / संचालन कार्यदेश दिन तथा उपभोक्ता समितिको बैंक खाता खोल्न सिफारिस गर्न मनासिब देखि निर्णयार्थ पेश गरेको छु। 
                    </div>

                       <table class="table table-bordered">

                           <tr>
                               <td class="myWidth50 myTextalignLeft">योजनाको नाम :</td>
                               <td><b><?php echo $data1->program_name;?></b></td>
                           </tr>
                           <tr>
                               <td class="myWidth50 myTextLeft">बिनियोजन श्रोत र ब्याख्या :</td>
                               <td><b><?php echo $data1->parishad_sno;?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">ठेगाना :</td>
                               <td><b><?php echo SITE_NAME?>-<?php echo convertedcit($group_heading->program_organizer_group_address);?></b> </td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">योजनाको बिषयगत क्षेत्रको नाम : </td>
                               <td><b><?php echo Topicarea::getName($data1->topic_area_id); ?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">योजनाको शिर्षकगत नाम : </td>
                               <td><b><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">समितिको नाम :</td>
                               <td><b><?php echo $data4->program_organizer_group_name; ?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">ठेगाना :</td>
                               <td><b><?php echo SITE_NAME.convertedcit($data4->program_organizer_group_address); ?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">विनियोजन किसिम :</td>
                               <td><b><?php echo Topicareainvestment::getName($data1->topic_area_investment_id); ?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft"><?php echo SITE_TYPE;?>बाट अनुदान रकम :</td>
                               <td><b>रु. <?php echo convertedcit($data1->investment_amount);?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">उपभोक्ताबाट जनश्रमदान :</td>
                               <td><b>रु. <?php echo convertedcit($result->costumer_investment);?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">कार्यादेश रकम (<?php echo SITE_TYPE;?> बाट छुटाइएको): (<?php echo convertedcit($percent_final1);?>%)</td>
                               <td><b>रु. <?php echo convertedcit($result->agreement_gauplaika);?></b></td>
                           </tr>
                           <?php
                           $con = Contingency::find_by_sql("select * from contingency where type=1");
                           foreach($con as $con):
                           endforeach;
                           //print_r($con);
                           $cont = ($result->agreement_gauplaika) * $con->amount;
                           //print_r($cont);

                           ?>
                           <tr>
                               <td class="myTextalignLeft">कन्टेन्जेन्सी
                                   (<?php echo convertedcit($con->percent)?>)%
                               </td>
                               <td><b>रु. <?php echo convertedcit($cont);?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">मर्मत
                                   (<?php echo convertedcit($result->marmat_old)?>%)</td>
                               <td><b>रु. <?php echo convertedcit($result->marmat_new);?></b></td>
                           </tr>
                           <tr>
                               <?php if(!empty($data2->other_agreement)){?>
                               <td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान रकम :</td>
                               <td><b>रु. <?php echo convertedcit($data2->other_agreement)  ;?></b></td>
                               <?php }else{?>
                               <?php }?>
                           </tr>
                           <tr>
                               <?php if(!empty($data2->agreement_other)){?>
                               <td class="myTextalignLeft"><?=$name?> नगद साझेदारी रकम:</td>
                               <td><b>रु. <?php echo convertedcit($data2->agreement_other);?></b> </td>
                               <?php }else{?>
                               <?php }?>
                           </tr>
                           <tr>
                               <?php if(!empty($data2->other_agreement)){?>
                               <td class="myTextalignLeft">अन्य साझेदारी रकम :</td>
                               <td> <b>रु. <?php echo convertedcit($data2->other_agreement);?></b></td>
                               <?php }else{?>
                               <?php }?>
                           </tr>
<!--                           <tr>-->
<!--                               <td class="myTextalignLeft">--><?//=$name?><!-- लागत सहभागिता रकम : (--><?//= convertedcit($percent_final)?><!-- %)</td>-->
<!--                               <td> <b>रु. --><?php //echo convertedcit($data2->costumer_agreement);?><!--</b></td>-->
<!--                           </tr>-->
                           <tr>
                               <td class="myTextalignLeft">कुल लागत अनुमान जम्मा रकम :</td>
                               <td> <b>रु. <?php echo convertedcit($data2->total_investment );?></b> </td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">कार्यदेश रकम :</td>
                               <td> <b>रु. <?php echo convertedcit($data2->bhuktani_anudan);?></b> </td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">योजना शुरु हुने मिति :</td>
                               <td><b><?php echo convertedcit($data3->yojana_start_date);?></b></td>
                           </tr>
                           <tr>
                               <td class="myTextalignLeft">योजना सम्पन्न हुने मिति :</td>
                               <td><b><?php echo convertedcit($data3->yojana_sakine_date);?></b></td>
                           </tr>


                       </table>
               <div class="bankdetails" style="margin-top:5px; margin-bottom: 35px;">माथि उल्लेखित उपभोक्ता समितिसँग सम्झौताको लागि सिफारिस गर्दछु ।	</div>

               <div class="oursignature mymarginright" > सदर गर्ने <br>
                <?php 
                if(!empty($worker1))
                {
                    echo $worker1->authority_name."<br/>";
                    echo $worker1->post_name;
                }
                ?>

            </div>

            <div class="oursignatureleft mymarginleft" style="margin-left:10px;"> योजना शाखा   <br/>
                <?php 
                if(!empty($worker3))
                {
                    echo $worker3->authority_name."<br/>";
                    echo $worker3->post_name;
                }
                ?>
            </div>
        </div>
        <hr>
        <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
    </div>
</div>
</div>
