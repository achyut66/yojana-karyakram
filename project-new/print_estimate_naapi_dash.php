<?php require_once("includes/initialize.php");
 error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    	$data2 =  Plantotalinvestment::find_by_plan_id($_GET['id']);
        $data3= Moreplandetails::find_by_plan_id($_GET['id']);
        $data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
        $max_period = NapiLagatProfile::find_max_period($_GET['id']);
//        print_r($data4); exit;
        ?>
            <?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>नापी किताब	। print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">नापी किताब |  <a href="estimate_paperdashboard.php">पछि जानुहोस </a></h2>
                    <h1 class="myHeading1"><?=$data1->program_name?></h1>
                      <h1 class="myHeading1">योजना दर्ता न :<?=convertedcit($data1->id)?></h1>
                    <div class="OurContentFull" >
                    	 
                      <?php echo getNapiLetterDashHtml($max_period); ?>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>