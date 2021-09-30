<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}	
$datas = SettingSpecs::find_by_sql("select * from settings_specification order by task_id asc");
include("menuincludes/header.php"); 
?>
<title>कामको क्षेत्र थपनुहोस :: Kanepokhari Gaupalika</title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">Specifications रेकोर्ड / <a href="settings.php">Go Back</a></h2>
                    <div class="OurContentLeft">
                   	   <?php include("menuincludes/main_dashboard.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>रेकोर्ड : </h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu2"><a href="settings_specification_add.php">Specification Add +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div>
								<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered">
                                            <tr>&nbsp;</tr>
                                            <tr>
                                            <th>सि नं</th>
                                            <th>Specification name</th>
                                            <th>Default</th>
                                            <th>कामको क्षेत्रको  नाम</th>
                                            <th>सच्याउनु होस् </th>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): ?>
                                          <?php ($data->default_spec==0)? $default="No" : $default="Yes"; ?>
                                          	<tr>
                                                        <td><?php echo convertedcit($i); ?></td>
                                                        <td><?php echo $data->name;?></td>
                                                        <td><?php echo $default;?></td>
                                                        <td><?php echo Worktopic::getName($data->task_id);?></td>
                                                        <td><a href="settings_specification_edit.php?id=<?php echo $data->id; ?>">सच्याउनु होस्</a></td>
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