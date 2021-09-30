<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");} ?>
<?php $fiscal_curr = FiscalYear::find_current_id();
        $address= getAddress();
	    $ward_address=WardWiseAddress();
      $fiscal = Fiscalyear::find_by_id($fiscal_curr);
 //error_reporting(1);
        $enlist = Costumerassociationdetails0::find_by_id($_GET['id']);
        $plan_details = Plandetails1::find_by_id($enlist->plan_id);
        $plan_res = Moreplandetails::find_by_plan_id($enlist->plan_id);
          if(!empty($enlist->created_date))
        {
          
           $dates=convertedcit(DateEngtoNep($enlist->created_date));
          // echo $dates;exit;
        }
        if((empty($plan_res)) && (!empty($enlist->created_date)))
        {
         $date_echo= $dates;
       
        }
        if(!empty($plan_res))
        {
           $date_echo = convertedcit(($plan_res->samiti_gathan_date));
        }
        
      
?>  
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title></title>

</head>

<body>
   
                       
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                <center style="margin-right: 5em;">
                    <p style="margin-left: 6em;">अनुसूची - २ ख</p>
                    <h6>नियम १८ को उपनियम (२) संग सम्बन्धित</h6>
                </center>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
                                                                        <h5 style="margin-left: 8em; font-weight: normal" class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
                                                <div class="myspacer"></div>
									<div class="printContent">
                                                                            <div class="mydate">मिति :<?php echo $dates;?> </div>
										<div class="patrano">आ.ब : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">सुची दर्ता नं : <?=convertedcit($enlist->id)?></div>
										<div class="myspacer20"></div>
                                                                                <div class="subject">विषय:- सुचिकृत गरिएको बारे ।</div>
										<div class="myspacer20"></div>
                                                                                <div class="bankname">श्री <?=$enlist->program_organizer_group_name ?></div>
										<div class="bankaddress"><?php echo SITE_LOCATION.' वडा नं : '. convertedcit($enlist->program_organizer_group_address) ;?></div>
										<div class="banktextdetails">
											उपरोक्त बिषयमा तपाईले <b><?= $plan_details->program_name ?>  </b> योजना , दर्ता नं: <b><?= convertedcit($plan_details->id) ?></b> संचालनको निम्ती यस कार्यालयमा उपभोक्ता समितिको लागि आ. व. <?php echo convertedcit($fiscal->year); ?> मा सुचिकृत हुन पाऊ भनि दिएको निबेदन अनुसार यस कार्यालयको मौजुदा सुचीमा दर्ता गरी यो निस्सा / प्रमाणपत्र उपलब्ध गराइएको छ |    
										</div>
										<div class="myspacer30"></div>
										<div class="oursignature">&nbsp;</div>
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
