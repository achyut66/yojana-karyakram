<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user = getUser();
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
<title>बैंक रेकोर्ड print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
   
                        <?php $bank_id=$_GET['bank_id'];
                        $bank=  Bankinformation::find_by_id($bank_id);
                        $data=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                        $data1=  Plandetails1::find_by_id($_GET['id']);  
                        $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
                        $data3=Costumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                        $data3_1=Costumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                        $data3_2=Costumerassociationdetails::find_by_post_plan_id(4,$_GET['id']);
                           $fiscal = FiscalYear::find_by_id($data1->fiscal_id);?>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             <div class="myspacer30"></div>
             	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
                                    	<div style="color:red">
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>

                                            <h5 class="marginright1 letter-title-four">
                                                <?php
                                                if($user->mode==user){
                                                    echo $user->ward_add;
                                                }else {
                                                    echo $ward_address;
                                                }
                                                ?>
                                            </h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    </div>
                                                <div class="myspacer"></div>
									<div class="printContent">
									        <div class="myspacer30"></div>
										<div class="mydate">मिति :<?php echo convertedcit($date_selected); ?> </div>
										<div class="patrano">पत्र संख्या : <?= convertedcit($fiscal->year) ?>  </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                                                                                <div class="chalanino">च न. : </div>
                                                                                <div class="myspacer20"></div>
                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo " ।";
                                                }?>
                                            </u>
                                        </div>
										<div class="myspacer30"></div>
                                                                                <div class="bankname">श्री <?php echo $bank->name;?></div>
										<div class="bankaddress"><?php echo $bank->address;?></div>
										<div class="banktextdetails">
										<div class="myspacer20"></div>
										
										
														उपरोक्त बिषयमा यस <b><?php echo SITE_TYPE;?></b> र <b><u><?php echo $data->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच मिति <b><?php echo convertedcit($data2->miti);?></b><!--(योजना संझौता भएको मिति)--> मा <b><?php echo $data1->program_name;?></b> योजना संचालन गर्ने भनि संझौता भएकोमा उक्त्त योजना संचालन गर्न उपभोक्ता समितिको नाममा बैंक खाता आबश्यक भएकाले उपभोक्ता समितिका अध्यक्ष श्री <b><?php echo $data3->name;?></b><!--(नामथर)--> , सचिब श्री <b><?php echo $data3_1->name;?></b><!--(नामथर)--> र कोषाध्यक्ष श्री <b><?php echo $data3_2->name;?></b><!--(नामथर)--> को  संयुक्त दस्तखतबाट संचालन हुने गरी चल्ती खाता खोली दिनहुन अनुरोध छ ।
										</div>
										<div class="myspacer30"></div>
									
										<div class="oursignature mymarginright"><br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
																				<div class="myspacer"></div>
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->