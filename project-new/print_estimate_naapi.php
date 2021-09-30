<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

$ward_address=WardWiseAddress();
$address= getAddress();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    	$data2=  Plantotalinvestment::find_by_plan_id($_GET['id']);
        $data3= Moreplandetails::find_by_plan_id($_GET['id']);
        $data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
        $max_period = NapiLagatProfile::find_max_period($_GET['id']);
        $napi_profile = NapiLagatProfile::find_by_plan_id_period($_GET['id'],$_GET['period']);
        
//        print_r($data1); exit;
        ?>
            <?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>नापी किताब	। print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
         <div class="maincontent" >
              <h2 class="headinguserprofile">नापी किताब |  <a href="print_estimate_naapi_dash.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="OurContentFull" >
                    	 
                        <div class="myPrint"><a href="print_estimate_naapi_final.php?id=<?=$_GET['id']?>&period=<?=$_GET['period']?>" target="_blank">प्रिन्ट गर्नुहोस</a></div> <div class="myspacer"></div> 
                        
                        <div class="mydate myFont10">म.ले.प. फाराम नं १७१</div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em"><?php echo $address;?></h4>
                                                                        <h4 class="margin1em"><?php echo SITE_ADDRESS;?></h4>
									<div class="myspacer"></div>
									<div class="subjectbold1 myCenter letter_subject"><?=getPeriodArray()[$_GET['period']]?> नापी किताब</div>

    
 <div class="textdetails">
     <div class="mydate">मिति : <?=convertedcit($napi_profile->date_nepali)?></div>
     <div ><b>आर्थिक बर्ष :- </b> <?=convertedcit($fiscal->year)?></div>
     <div>योजनाको नाम :- </b> <?=$data1->program_name?> </div>
	 <div class="mydate">योजना दर्ता नं:- </b> <?=convertedcit($data1->id)?></div>
	 <div> ठेगाना :- </b> <?=SITE_FIRST_NAME?> - <?=convertedcit($data1->ward_no)?> </div>
</div>
<div class="printContent">
										
										                                                                             
										
<?php echo getNapiLetter($_GET['period']); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

				<div class="myspacer30"></div>
										
										<div class="oursignature">सदर गर्ने</div>
										
<div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
<div class="oursignatureleft ">जाँच गर्ने</div>
										<div class="myspacer"></div>
							  </div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
      
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>