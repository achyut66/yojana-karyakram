<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

 include("menuincludes/header.php"); ?>
<?php
$id=$_GET['id'];
$plan_details= Plandetails1::find_by_id($id);
$result=Estimatelagatanuman::find_by_plan_id($_GET['id']);
?>

<!-- js ends -->
<title>लागत अनुमान print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">लागत अनुमान</h2>
                    <div class="OurContentLeft">
                   	  <?php include("menuincludes/lettersmenu.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>लागत अनुमान: </h2>
                      
                        
                       
                        <div class="myPrint"><a href="print_estimate_final.php?id='<?php echo $_GET['id'];?>'" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                     <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    
									<h1><?php echo SITE_LOCATION;?></h1>
									<h4><?php echo SITE_HEADING;?> </h4>
									<h5>वयरवन,</h5>
									<div class="myspacer"></div>
									<div class="printContent">
										<div class="mydate">मिति :<?php echo convertedcit(generateCurrDate()); ?> </div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer20"></div>
                                                                                
										<div class="myspacer20"></div>
                                                                                <h1><b><u>लागत अनुमान </u></b></h1>
										
										
										<div class="myspacer"></div>
                                                                                <strong>अयोजनाको नाम:</strong> <?= $plan_details->program_name ?><br>
                                                                                <strong>स्थान:</strong>  <?= SITE_NAME.$plan_details->ward_no ?>
                                                                                <table class="table table-bordered table-responsive">
                                                                                    <tr>
                                                                                        <th>सि.नं</th>
                                                                                        <th>कामको विवरण</th>
                                                                                        <th colspan="4">प्रस्तावित कामको विवरण</th>
                                                                                        <th>जम्मा परिमाण</th>
                                                                                        <th>इकाइ</th>
                                                                                        <th>स्वीकृत विभागिय दर </th>
                                                                                        <th>जम्मा लागत</th>
                                                                                         <th>कैफियत</th>
                                                                                    </tr>
                                                                                    
                                                                                    <tr>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>संख्या</td>
                                                                                        <td>लम्बाइ</td>
                                                                                        <td>चौडाइ</td>
                                                                                        <td>उचाइ</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        
                                                                                        
                                                                                    </tr>
                                                                                    <?php $i=1;foreach($result as $data):
                                                                                        $name= Estimateadd::find_by_id($data->task_name);
                                                                                        $unit=  Units::getName($name->unit_id);
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo convertedcit($i);?></td>
                                                                                        <td><?php echo $name->task_name ;?></td>
                                                                                        <td><?php echo convertedcit($data->task_count) ;?></td>
                                                                                        <td><?php echo convertedcit($data->length);?></td>
                                                                                        <td><?php echo convertedcit($data->breadth);?></td>
                                                                                        <td><?php echo convertedcit($data->height);?></td>
                                                                                        <td><?php echo convertedcit($data->total_evaluation) 	;?></td>
                                                                                        <td><?php echo $unit ;?></td>
                                                                                        <td><?php echo convertedcit($data->task_rate) ;?></td>
                                                                                        <td><?php echo convertedcit(placeholder(($data->total_rate))) ;?></td>
                                                                                        
                                                                                    </tr>
                                                                                     <?php $i++;endforeach;?>
                                                                                </table>
									</div>
                                                                        <div class="myspacer"></div>
										<div class="oursignature">&nbsp;</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
  
    <?php include("menuincludes/footer.php"); ?>
