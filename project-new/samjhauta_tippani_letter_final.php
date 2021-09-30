<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
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
	$data2=  Samitiplantotalinvestment::find_by_plan_id($_GET['id']);?>
    <?php $data3= Samitimoreplandetails::find_by_plan_id($_GET['id']);
     $data4= Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$ward_address=WardWiseAddress();
$address= getAddress();
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
                                    
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div><div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer"></div>
										
										<div class="subject">   विषय:- योजना संझौता सम्बन्धमा ।</div>
										<div class="myspacer"></div>
										<div class="bankname">श्रीमान् </div>
                                                                               
										यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको संस्था / समितिसँग सम्झौता गरी योजनाको कार्यदेश दिनका लागि श्रीमान समक्ष यो टिप्पणी पेश गरेको छु ।	
										</div>
<table class="table-bordered myWidth100 ">
     <tr>
         <td class="myWidth50 myTextalignRight">योजनाको नाम :</td>
         <td><?php echo $data1->program_name;?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">ठेगाना :</td>
         <td><?php echo SITE_NAME.convertedcit($data1->ward_no);?> </td>
     </tr>
     <tr>
         <td class="myTextalignRight">योजनाको बिषयगत क्षेत्रको नाम : </td>
         <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">योजनाको शिर्षकगत नाम : </td>
         <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">समितिको नाम :</td>
         <td><?php echo $data4->program_organizer_group_name; ?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">ठेगाना :</td>
         <td><?php echo SITE_NAME.convertedcit($data4->program_organizer_group_address); ?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">विनियोजन किसिम :</td>
         <td><?php echo Topicareainvestment::getName($data1->topic_area_agreement_id); ?></td>
     </tr>
     <tr>
         <td class="myTextalignRight"><?php echo SITE_TYPE;?>बाट अनुदान रकम :</td>
         <td><?php echo convertedcit($data1->investment_amount);?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">अन्य निकायबाट प्राप्त अनुदान रकम :</td>
         <td><?php echo convertedcit($data2->other_agreement)  ;?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">संस्था / समितिबाट नगद साझेदारी रकम:</td>
         <td><?php echo convertedcit($data2->costumer_agreement);?> </td>
     </tr>
     <tr>
         <td class="myTextalignRight">अन्य साझेदारी रकम :</td>
         <td> <?php echo convertedcit($data2->other_agreement);?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">संस्था / समितिबाट जनश्रमदान रकम :</td>
         <td> <?php echo convertedcit($data2->costumer_investment);?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">कुल लागत अनुमान जम्मा रकम :</td>
         <td> <?php echo convertedcit($data2->total_investment );?> </td>
     </tr>
     <tr>
         <td class="myTextalignRight">कार्यदेश रकम :</td>
         <td> <?php echo convertedcit($data2->bhuktani_anudan);?> </td>
     </tr>
     <tr>
         <td class="myTextalignRight">योजना शुरु हुने मिति :</td>
         <td><?php echo convertedcit($data3->yojana_start_date);?></td>
     </tr>
     <tr>
         <td class="myTextalignRight">योजना सम्पन्न हुने मिति :</td>
         <td><?php echo convertedcit($data3->yojana_sakine_date);?></td>
     </tr>
     

</table>
<div class="bankdetails" stylel="margin-top:5px;">माथि उल्लेखित संस्था / समितिसँग सम्झौताको लागि सिफारिस गर्दछु ।	</div>
										<div class="myspacer30"></div>
	
<div class="oursignature mymarginright"> सदर गर्ने <br/>
    <?php 
        if(!empty($worker1))
        {
            echo $worker1->authority_name."<br/>";
            echo $worker1->post_name;
        }
    ?>
</div>
<div class="oursignatureleft mymarginright">तयार गर्ने <br/>
<?php 
    if(!empty($worker2))
    {
        echo $worker2->authority_name."<br/>";
        echo $worker2->post_name;
    }
?>
</div>

<div class="oursignatureleft mymarginright"> पेश गर्ने  <br/>
    <?php 
        if(!empty($worker3))
        {
            echo $worker3->authority_name."<br/>";
            echo $worker3->post_name;
        }
    ?>
</div>

<div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने<br/>
    <?php 
        if(!empty($worker4))
        {
            echo $worker4->authority_name."<br/>";
            echo $worker4->post_name;
        }
?>
</div>
<div class="myspacer"></div>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
