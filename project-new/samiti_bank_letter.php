<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//echo $_GET['id'];exit;
	$datas= Bankinformation::find_all();
    $workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

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
$ward_address=WardWiseAddress();
$address= getAddress();
?>
  <?php 
  if(isset($_POST['submit']))
  {
      $link="samiti_bank_letter.php?id=".$_GET['id']."&bank_id=".$_POST['bank_id']."";
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
                    <form method="get" action="samiti_bank_letter_final.php?>">
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
                        
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" />
                            <div class="myPrint"><input type="hidden" name="bank_id" value="<?=$_GET['bank_id']?>" />
                            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                     <div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    </div>
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    </div>
                                    
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
									<div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
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
                                    	
                                    <div class="oursignature mymarginright"> सदर गर्ने  <br> 
                                        <select name="worker1" class="form-control worker" id="worker_1" >
                                            <option value="">छान्नुहोस्</option>
                                            <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                            <?php }?>
                                        </select>
                                        <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                    </div>
                                    <div class="oursignatureleft mymarginright">तयार गर्ने  <br/>
                                        <select name="worker2" class="form-control worker" id="worker_2">
                                            <option value="">छान्नुहोस्</option>
                                            <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                            <?php }?>
                                        </select>
                                        <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                      </div>
                                    
                                    <div class="oursignatureleft mymarginright"> पेश गर्ने  <br/>
                                        <select name="worker3" class="form-control worker" id="worker_3">
                                            <option value="">छान्नुहोस्</option>
                                            <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                            <?php }?>
                                        </select>
                                        <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                                     </div>
                                    
                                    <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने  <br/> 
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