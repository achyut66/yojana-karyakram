<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas= Plandetails::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>आयोजनाको अनुदानको किसिम  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">शिर्षक</h2>
                  
                    <div class="OurContentFull">
                    	<h2>योजना बिस्तृत विवरण : </h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu1"><a href="plan_details.php">  योजना बिस्तृत विवरण  थप्नुहोस +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div><?php echo $message;?></br>
                                    	<table class="table table-bordered">
                                            <tr><a href="plan_details.php"><button>ADD</button></a></tr>
                                            <tr>
                                            <th>दर्ता नं</th>
                                            <th>बिषयगत क्षेत्रको नाम</th>
                                            <th>शिर्षकगत नाम </th>
                                            <th>आयोजनाको अनुदानको किसिम </th>
                                            <th>आयोजनाको विनियोजन किसिम</th>
                                            <th>आयोजनाको विनियोजन श्रोत</th>
                                            <th>आयोजनाको नाम</th>
                                             <th>आयोजना सचालन हुने स्थान(<?php echo SITE_LOCATION;?>(वडा नं))</th>
                                              <th>टोल बस्तीको नाम</th>
                                              <th> <?php echo SITE_TYPE;?> बाट बिनियोजन रकम</th>
                                          </tr>
                                          <?php foreach($datas as $data): ?>
                                          	<tr>
                                                        <td><?php echo $data->sn; ?></td>
                                                        <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                                        <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                                        <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                                        <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                                        <td><?php echo Topicareainvestmentsource::getName($data->topic_area_investment_source_id);?></td>
                                                        <td><?php echo $data->program_name; ?></td>
                                                        <td><?php echo $data->ward_no; ?></td>
                                                        <td><?php echo $data->tole_name; ?></td>
                                                        <td><?php echo $data->investment_amount; ?></td>
                                                        <td><a href="edit_plan_details.php?id=<?php echo $data->id; ?>">Edit</a></td>
                                                    </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>