<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$datas= Bankinformation::find_all();
        
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
$ward_address=WardWiseAddress();
$address= getAddress();
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
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
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
                                            	
                                            <div class="oursignature mymarginright"> सदर गर्ने <br>
                                                <?php 
                                                    if(!empty($worker1))
                                                    {
                                                        echo $worker1->authority_name."<br/>";
                                                        echo $worker1->post_name;
                                                    }
                                                ?>

                                            </div>
                                            <div class="oursignatureleft mymarginright">तयार गर्ने   <br/>
                                                    <?php 
                                                        if(!empty($worker2))
                                                        {
                                                            echo $worker2->authority_name."<br/>";
                                                            echo $worker2->post_name;
                                                        }
                                                    ?>
                                            </div>
                                            
                                            <div class="oursignatureleft mymarginright"> पेश गर्ने    <br/>
                                                    <?php 
                                                        if(!empty($worker3))
                                                        {
                                                            echo $worker3->authority_name."<br/>";
                                                            echo $worker3->post_name;
                                                        }
                                                    ?>
                                             </div>
                                            
                                            <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने    <br/>
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
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->