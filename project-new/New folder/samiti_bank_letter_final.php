<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$datas= Bankinformation::find_all();
        $base_url = get_base_url();
        $plan_id  = $_GET['id'];
        $user     = getUser();
        $max_count = PrintDetails::find_max_counter($base_url,$plan_id);
        $print_details  = new PrintDetails;
        $print_details->url  = $base_url;
        $print_details->plan_id = $plan_id;
        $print_details->user_id = $user->id;
        $print_details->nepali_date = $_GET['date_selected'];
        $print_details->english_date = DateNepToEng($_GET['date_selected']);
        $print_details->counter       = $max_count + 1;
        $print_details->save();
        $date_selected= $_GET['date_selected'];
	?>
  
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>बैंक रेकोर्ड print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
   
                        <?php $bank_id=$_GET['bank_id'];
                         $bank=  Bankinformation::find_by_id($bank_id);
                        $data=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                        $data1=  Plandetails1::find_by_id($_GET['id']);  
                        $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
                        $data3=Samiticostumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                        $data3_1=  Samiticostumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                        $data3_2=Samiticostumerassociationdetails::find_by_post_plan_id(4,$_GET['id']);?>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
	
<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									
<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                                <div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति :<?php echo convertedcit($date_selected); ?> </div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer20"></div>
                                                                                <div class="subject">विषय:- बैंक खाता सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
                                                                                <div class="bankname">श्री <?php echo $bank->name;?></div>
										<div class="bankaddress"><?php echo $bank->address;?></div>
										<div class="banktextdetails">
											उपरोक्त बिषयमा यस <?php echo SITE_TYPE;?> र <?php echo $data->program_organizer_group_name;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौता भएको मिति)--> मा <?php echo $data1->program_name;?> योजना संचालन गर्ने भनि संझौता भएकोमा उक्त्त योजना संचालन गर्न संस्था / समितिको नाममा बैंक खाता आबश्यक भएकाले संस्था / समितिका अध्यक्ष श्री <?php echo $data3->name;?><!--(नामथर)--> , सचिब श्री <?php echo $data3_1->name;?><!--(नामथर)--> र कोषाध्यक्ष श्री <?php echo $data3_2->name;?><!--(नामथर)--> को संयुक्त दस्तखतबाट संचालन हुने गरी चल्ती खाता खोली दिनहुन अनुरोध छ ।
										</div>
										<div class="myspacer30"></div>
                                            	
                                            <div class="oursignature mymarginright"> सदर गर्ने </div>
                                            <div class="oursignatureleft mymarginright">तयार गर्ने  </div>
                                            
                                            <div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
                                            
                                            <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने       </dv>
                                            <div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->