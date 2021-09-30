<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

$result= Contractinvitationentry::find_by_plan_id($_GET['plan_id']);
$program_selected=  Plandetails1::find_by_id($_GET['plan_id']);
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>ठेक्का बोलपत्र दर्ता किताब  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                     <div class="chalanino"><b>योजना  दर्ता नं</b> :<b> <u><?php echo convertedcit($_GET['plan_id'])?></u></b></div>
                     <div class="chalanino"><b>योजनाको नाम </b>:<b><u><?php echo $program_selected->program_name;?></u></b></b> </div>
                    <div class="myspacer"></div>
                    <div class="subject"><b><u>ठेक्का बोलपत्र दर्ता किताब</b></u> </div>	
                                <div class="myspacer"></div>
                                <table class="table table-bordered">
                                        <tr>
                                            <th>दर्ता नं</th>
                                            <th>निर्माण ब्यवोसायीको नाम </th>
                                            <th>ठेगाना</th>
                                            <th>सम्पर्क </th>
                                            <th>बोलपत्र दर्ता मिति  </th>
                                          

                                          </tr>
                                          <?php foreach($result as $data):
                                              $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                                              
?>
                                          <tr>
                                               <td><?php echo convertedcit($data->bid_id);?></td>
                                              <td><?php echo $contractor_details->contractor_name;?></td>
                                              <td><?php echo $contractor_details->contractor_address;?></td>
                                              <td><?php echo $contractor_details->contractor_contact;?></td>
                                               <td><?php echo convertedcit($data->darta_miti);?></td>
                                             </tr>
                                          <?php endforeach;?>
                                        </table>
									
                    
										<div class="myspacer20"></div>
<div class="oursignature">&nbsp</div><div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->