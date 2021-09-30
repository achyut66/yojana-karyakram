<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$sql="select * from worker_details";	
$datas= Workerdetails::find_by_sql($sql);
	?>
 <?php if(isset($_GET['status']))
       {
            $data=  Workerdetails::find_by_id($_GET['id']);
            $data->status = 1 - $_GET['status'];
            if($data->save()){
                    $link="view_worker_details.php";
                    redirect_to($link);
                }
        }
?>  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्यकारी व्यक्ति विवरण  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	 <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यकारी व्यक्ति विवरण | <a href="worker_details.php" class="btn">कार्यकारी व्यक्ति विवरण  थप्नुहोस  +</a> | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>                  
                    <div class="OurContentFull">
                    	<h2>कार्यकारी व्यक्ति विवरण  </h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu2"></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                            <tr>
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>पदको नाम</strong></td>
                                            <td class="myCenter"><strong>आधिकारिक व्यक्ति</strong></td>
                                            <td class="myCenter"><strong>वडा नं</strong></td>
                                            <td class="myCenter"><strong>कार्य अवधि</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data):
                                               ($data->status==0)? $status= '<a href="view_worker_details.php?id='.$data->id.'&status='.$data->status.'"><img src="images/wrong.png" height="20px" width="20px" /></a>'
                                             : $status =  '<a href="view_worker_details.php?id='.$data->id.'&status='.$data->status.'"><img src="images/right.png" height="20px" width="20px" /></a>'; ?>
                                          	<tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                          <td class="myCenter"><?php echo $data->post_name; ?></td>
                                                            <td class="myCenter"><?php echo $data->authority_name ?></td>
                                                            <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->authority_ward_no);?></td>
                                                        <td class="myCenter"><?php echo $status; ?></td>
                                                        <td class="myCenter"><a href="edit_worker_details.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a></td>
                                                    </tr>
                                        
                                          <?php $i++; endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>