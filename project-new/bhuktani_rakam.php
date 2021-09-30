<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
	redirectUrl();
}	$ward_address=WardWiseAddress();
$address= getAddress();
$datas= Bankinformation::find_all();

?>
<?php 
if(isset($_POST['submit']))
{
	$link="bhuktani_rakam?id=".$_GET['id']."&bank_id=".$_POST['bank_id']."";
	redirect_to($link);
}
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$data1 = Plandetails1::find_by_id($_GET['id']);
// print_r($data1);
// exit;
?>
<?php include("menuincludes/header.php"); ?>

<!-- js ends -->
<title>###:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
	<?php include("menuincludes/topwrap.php"); ?>
	<div id="body_wrap_inner"> 
		<div class="maincontent">
			<h2 class="headinguserprofile">##| <a href="letters_select.php" class="btn">पछि जानुहोस</a></h2>

			<div class="OurContentFull">

				<form method="get" action="bhuktani_rakam_final.php?id=<?=$_GET['id']?>" target="_blank" >
					<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" />
						<input type="hidden" name="bank_id" value="<?=$_GET['bank_id']?>" />
						<input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
						<div class="userprofiletable">
							<div class="printPage">
								<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>

								<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
								<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
								<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
								<div class="myspacer"></div>
								<div class="printContent">
									<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
									if(!empty($print_history->nepali_date))
									{
										echo $print_history->nepali_date;
									}
									else
									{
										echo generateCurrDate();}?>" id="nepaliDate5" /></div>
										<div class="patrano">टि.संख्या : </div>
										<div class="subject">विषय:- रकम भुक्तानी दिने बारे  ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्रीमान प्रमुख प्रशासकीय अधिकृत ज्यु,</div>
										<div class="bankname"><?php echo SITE_LOCATION;?></div>
										<div class="bankname"><?php echo $address;?></div>
										<div class="bankname"><?php echo $ward_address;?></div>

										<div form action="bhuktani_rakam_final.php" method="get">
											<div class="form-group form-group-sm">
											<div class="myspacer"></div>

					<p>
					 		                                               			
					<?php echo SITE_LOCATION;?>, नुवाकोटको आ.व: २०७७/२०७८ को लागि पारित योजना नं / राजपत्र नं : <label><Strong><input type="text" name="shirshak" value="" placeholder="राजपत्र नं"></strong></label> शीर्षकमा विनियोजित रकमको <label><strong><input type="text" name="bajet" value="" placeholder="बजेट श्रोत"></strong></label> शीर्षकबाट खर्च गर्ने गरि श्री <label><strong><input type="text" name="address" value="" placeholder="ठेगाना"></strong></label> गरि खर्च भए वापतको विल अनुसार भुक्तानी पाउँ भनि माग भई आएकोले संलग्न विल तथा सोको पुस्टि रहने कागजातहरु र तोक आदेशको आधारमा सो योजना / शीर्षकबाट रकम रु. <label><strong><input type="text" name="amount" value="" placeholder="रकम"></strong></label> भुक्तानी दिन मनासिब देखिएकाले निर्णयार्थ पेश गर्दछु / गर्दछौ ।
					
					</p>
							<div class="myspacer30"></div>
								<table class="table-bordered myWidth100 table-responsive">
							<tr><td class="mycenter"><label>हाल भुक्तानी दिन सिफारिस</label></td>
							<td>रु : <label><input type="text" name="bhuktani_dina_baki" value="" placeholder="रकम"></label></td>
								</tr>
								<tr>
							<td class="mycenter"><label>अग्रिम आयकर रकम रु</label></td>
							<td>रु:<label><input type="text" name="agrim_aaye_kar" value="" placeholder="रकम"></label></td>
								</tr>
								<tr>
							<td class="mycenter"><label>योजना कुल जम्मा विनियोजित रकम रु</label></td>
							<td>रु:<label><input type="text" name="kul_biniyojit" value="" placeholder="रकम "></label></td>
								</tr>
								</table>
										<div class="myspacer30"></div>
											<table class="table table-responsive myWidth100">
														<thead>
														<th class="mycenter"><strong>पेश गर्ने</th>
															<th class="mycenter"><strong>रुजु गर्नेको दस्तखत</th>
																<th class="mycenter"><strong>सदर गर्नेको दस्तखत</strong></th></tr>
																</thead>
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
																<!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
															</div>
														</div>
													</div>
												</div><!-- main menu ends -->

											</div><!-- top wrap ends -->
											<hr><i>
									<p style="margin-left: 280px">"शिक्षा , संस्कृति, कृषि र पूर्वाधारको अभियान । दीगो व्यापारिक केन्द्र विदुरको स्वाभिमान ।। "
											</p></i></hr>
											<?php include("menuincludes/footer.php"); ?>
