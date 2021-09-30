<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$user = getUser();
$ward_address=WardWiseAddress();
        $address= getAddress();
	$datas= Bankinformation::find_all();
        $workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    
}
	?>
  <?php 
  if(isset($_POST['submit']))
  {
      $link="print_bank_report01.php?id=".$_GET['id']."&bank_id=".$_POST['bank_id']."";
      redirect_to($link);
  }
$worker_ward = Workerdetails::find_by_sql("select * from worker_details where authority_ward_no =".$user->ward);
  ?>
<?php include("menuincludes/header.php"); ?>

<!-- js ends -->
<title>बैंक रेकोर्ड :: <?php echo SITE_SUBHEADING;?></title>
<style>
    input{
        background: #eeeeee;
    }
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">बैंक रेकोर्ड | <a href="letters_select.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="bankReport">
                        	<div class="inputWrap">
                            <form method="post">
                                <h1>बैंक छान्नुहोस :</h1>
                                <div class="newInput">
                                    <label style="font-weight:bold;">  बैंक छान्नुहोस   </label>
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
                        $data=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                        $data1=  Plandetails1::find_by_id($_GET['id']);  
                        $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
                        $data3=Costumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                        $data3_1=Costumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                        $data3_2=Costumerassociationdetails::find_by_post_plan_id(4,$_GET['id']);
                           $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
                        ?>
                        <form method="get" action="print_bank_report01_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" />
                                <input type="hidden" name="bank_id" value="<?=$_GET['bank_id']?>" />
                                <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                     <div class="printlogo"><img src="images/janani.png" alt="Logo"></div>
                                    
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                                <h5 class="marginright1 letter-title-four">
                                    <?php
                                    if($user->mode==user){
                                        echo $user->ward_add;
                                    }else {
                                        echo $ward_address;
                                    }
                                    ?>
                                </h5>
									<div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति <input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या :<?= convertedcit($fiscal->year) ?> </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="rajpatrano">राजपत्र नं : <?php echo convertedcit($data1->rajpatra_no)?></div>
									        <div class="chalanino">च न. : </div>
                                        <div class="subject" border="none">
                                            <u>बिषय :- <label style="margin-left: 5px;">
                                                    <input type="text" style="border:none" name="subject" value="बैंक खाता संचालन पत्र"/></label></u>
                                        </div>
										<div class="myspacer20"></div>
									        <div class="bankname">श्री <?php echo $bank->name;?></div>
										<div class="bankaddress"><?php echo $bank->address;?></div>
										<div class="banktextdetails">
										
											उपरोक्त बिषयमा यस <b><?php echo SITE_TYPE;?></b> र <b><u><?php echo $data->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच मिति <b><?php echo convertedcit($data2->miti);?></b><!--(योजना संझौता भएको मिति)--> मा <b><?php echo $data1->program_name;?></b> योजना संचालन गर्ने भनि संझौता भएकोमा उक्त्त योजना संचालन गर्न उपभोक्ता समितिको नाममा बैंक खाता आबश्यक भएकाले उपभोक्ता समितिका अध्यक्ष श्री <b><?php echo $data3->name;?></b><!--(नामथर)--> , सचिब श्री <b><?php echo $data3_1->name;?></b><!--(नामथर)--> र कोषाध्यक्ष श्री <b><?php echo $data3_2->name;?></b><!--(नामथर)--> को  संयुक्त दस्तखतबाट संचालन हुने गरी चल्ती खाता खोली दिनहुन अनुरोध छ ।
										</div>
											<div class="myspacer30"></div>
									            <?php if(empty($user->mode==user)){?>
                                                                                        <div class="oursignature mymarginright"><br/>
                                                                                            <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                    </div>
                                                <?php }else{?>
                                                                                    <div class="oursignature mymarginright"><br/>
                                                                                            <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($worker_ward as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                    </div>
                                                    <?php }?>
									
										<div class="myspacer"></div>
                        </form>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
                
                
                


           
    </div><!-- top wrap ends -->
  
    <?php include("menuincludes/footer.php"); ?>
 <?php endif; ?>