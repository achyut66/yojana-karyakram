<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas= Estimateadd::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कामको  विवरण  रेकोर्ड :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कामको  विवरण  रेकोर्ड / <a href="estimate_setting.php">Go Back</a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>कामको  विवरण  रेकोर्ड </h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu2"><a href="estimate_add.php">कामको  विवरण  थप्नुहोस +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div>
								<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered">
                                            <tr>&nbsp;</tr>
                                            <tr>
                                            <th>सि. नं.</th>
                                            <th>क्षेत्र</th>
                                            <th>कामको विवरण </th>
                                            <th>इकाई </th>
                                            <th>सच्याउनुहोस् </th>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): ?>
                                          	<tr>
                                                        <td><?php echo convertedcit($i); ?></td>
                                                        <td><?php echo Worktopic::getName($data->task_id);?></td>
                                                        <td><?php echo $data->task_name; ?></td>
                                                        <td><?php echo Units::getName($data->unit_id); ?></td>
                                                        <td><a href="estimate_edit.php?id=<?php echo $data->id; ?>">सच्याउनु होस्</a></td>
                                                    </tr>
                                        
                                          <?php $i++; endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>