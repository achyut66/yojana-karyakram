<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$datas= Bankinformation::find_all();
$address= getAddress();
$ward_address=WardWiseAddress();
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
$print_history->save();
$data1=  Plandetails1::find_by_id($_GET['id']);
// print_r($data1);
// exit;
if(!empty($_GET['worker1']))
{
	$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
	$worker1 = Workerdetails::setEmptyObject();
}

?>

<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>## <?php echo SITE_SUBHEADING;?></title>

</head>

<body>

	<div class="myPrintFinal" > 
		<div class="userprofiletable">
			<div class="printPage">
				<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
				<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
				<h4 class="marginright1 letter_title_one"><?php echo $address;?></h4>
				<h5 class="marginright1 letter_title_one"><?php echo $ward_address;?></h5>
				<div class="myspacer"></div>
				<div class="printContent">
					<div class="mydate">मिति :<?php echo convertedcit($date_selected); ?> </div>
					<div class="patrano">टि.संख्या : </div>
					<div class="subject">विषय:- रकम भुक्तानी दिने बारे  ।</div>
					<div class="myspacer20"></div>
					<div class="bankname">श्रीमान प्रमुख प्रशासकीय अधिकृत ज्यु,</div>
					<div class="bankname"><?php echo SITE_LOCATION;?></div>
					<div class="bankname"><?php echo $address;?></div>
					<div class="bankname"><?php echo $ward_address;?></div>
					<div class="myspacer"></div>
					<p>
						<?php echo SITE_LOCATION;?>, नुवाकोटको आ.व: २०७७/२०७८  को लागि पारित योजना नं / राजपत्र नं : <strong><?php echo convertedcit($_GET["shirshak"]); ?></strong> शीर्षकमा विनियोजित रकमको <strong><?php echo convertedcit($_GET["bajet"]); ?></strong> शीर्षकबाट खर्च गर्ने गरि श्री <strong><?php echo $_GET["address"]; ?></strong> गरि खर्च भए वापतको विल अनुसार भुक्तानी पाउँ भनि माग भई आएकोले संलग्न विल तथा सोको पुस्टि रहने कागजातहरु र तोक आदेशको आधारमा सो योजना / शीर्षकबाट रकम रु. <strong><?php echo convertedcit($_GET["amount"]); ?></strong> भुक्तानी दिन मनासिब देखिएकाले निर्णयार्थ पेश गर्दछु / गर्दछौ ।
						
					</p>
					<div class="myspacer30"></div>
					<table class="table-bordered myWidth100">
						<tr><td class="mycenter"><label>हाल भुक्तानी दिन सिफारिस</label></td>
						<td>रु :<?php echo convertedcit($_GET["bhuktani_dina_baki"])?>/-</td>
						</tr>
						<tr>
						<td class="mycenter"><label>अग्रिम आयकर रकम रु</label></td>
						<td>रु: <?php echo convertedcit($_GET["agrim_aaye_kar"])?>/-</td>
						</tr>
						<tr>
						<td class="mycenter"><label>योजना कुल जम्मा विनियोजित रकम रु</label></td>
						<td>रु: <?php echo convertedcit($_GET["kul_biniyojit"])?>/-</td>
						</tr>
						</table>
					<div class="myspacer30"></div>
					<table class="table table-bordered  myWidth100">
						<thead>
							<th class="mycenter"><strong>पेश गर्ने</th>
								<th class="mycenter"><strong>रुजु गर्नेको दस्तखत</th>
									<th class="mycenter"><strong>सदर गर्नेको दस्तखत</strong></th></thead>
										<tr>
										<td>नाम:</td>
										<td>नाम:</td>
										<td>नाम:</td>
										</tr>
										<tr>
										<td>पद:</td>
										<td>पद:</td>
										<td>पद:</td>
										</tr>
										<tr>
										<td>दस्तखत:</td>
										<td>दस्तखत:</td>
										<td>दस्तखत:</td>
										</tr>
										<tr>
										<td>मिति:</td>
										<td>मिति:</td>
										<td>मिति:</td>
										</tr>
										</table>
										<div class="myspacer30"></div>

										<div class="myspacer"></div>
									</div>
								</div>
							</div>
						</div><!-- main menu ends -->
						<hr><i>
						<p style="margin-left: 135px">"शिक्षा , संस्कृति, कृषि र पूर्वाधारको अभियान । दीगो व्यापारिक केन्द्र विदुरको स्वाभिमान ।। "
						</p></i></hr>
					</div>
				</div>   
    </div><!-- top wrap ends -->