<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//echo $_GET['id'];exit;
	$datas= Bankinformation::find_all();
        $base_url = get_base_url(1);
        $max_date   = DateEngToNep(PrintDetails::get_max_date($base_url,$_GET['id']));
	?>
  <?php 
  if(isset($_POST['submit']))
  {
      $link="samiti_bank_letter.php?id=".$_GET['id']." & bank_id=".$_POST['bank_id']."";
      redirect_to($link);
  }
  ?>
<?php include("menuincludes/header.php"); ?>

<!-- js ends -->
<title>बैंक रेकोर्ड print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">बैंक रेकोर्ड <a class="btn" href="samiti_letters_select.php"> पछी  जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    
                        <div class="bankReport">
                        	<div class="inputWrap">
                            <form method="post">
                                <h1>बैंक छान्नुहोस :</h1>
                                <div class="newInput">
                                <select name="bank_id">
                                    <option value="">छान्नुहोस् </option>
                                    <?php foreach($datas as $data):?>
                                    <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                                    <?php endforeach;?>
                                </select></div>
                                <div class="saveBtn myWidth100">
                                <input type="submit" name="submit" value="खोज्नुहोस " class="btn"/></div>
                            </form></div><!-- input wrap ends -->
                        </div>
                       
                       <?php if(isset($_GET['bank_id'])):?>
                        <?php $bank_id=$_GET['bank_id'];
                        $bank=  Bankinformation::find_by_id($bank_id);
                        $data=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                        $data1=  Plandetails1::find_by_id($_GET['id']);  
                        $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
                        $data3=Samiticostumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                        $data3_1=  Samiticostumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                        $data3_2=Samiticostumerassociationdetails::find_by_post_plan_id(4,$_GET['id']);
                        ?>
                        <div class="myPrint">  <a href="print_details_view.php?id=<?=$_GET['id']?>&page=<?=$base_url?>" class="btn" target="_blank">प्रिन्ट विवरण</a>&nbsp;</div><br/><br/>
                        <form method="get" action="samiti_bank_letter_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <?php if(!empty($max_date)){?>
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" onclick="return confirm('के तपाई मिति सच्याउन चाहनुहुन्छ?');" name="submit" /></div>
                        <?php }else{?>
                         <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <?php }?>
                         <div class="userprofiletable">
                        	<div class="printPage">
                                     <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($max_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
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
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
  
    <?php include("menuincludes/footer.php"); ?>
 <?php endif; ?>