<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  
  
if(isset($_POST['submit']))
{
	$data = new Estimateadd();
	if($data->savePostData($_POST,"create"))
       {
        $session->message("प्राबिधिक इष्टिमेट थप सफल");    
        redirect_to("view_estimate.php");
        
      }

 }
 $units = Units::find_all();
$work_details=Worktopic::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>प्राबिधिक इष्टिमेट थपनुहोस  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्राबिधिक इष्टिमेट थपनुहोस  / <a href="view_work_topic.php">Go back</a></h2>
                    <div class="OurContentLeft">
                   	 <?php include("menuincludes/main_dashboard.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>प्राबिधिक इष्टिमेट थपनुहोस</h2>
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                         
                                                                                         
                                         <tr>
                                            <td>कामको क्षेत्रको नाम</td>
                                            <td>
                                                <select name="task_id">
                                                    <option value="">---छान्नुहोस्---</option>
                                                    <?php foreach($work_details as $data):?>
                                                    <option value="<?php echo $data->id;?>"><?php echo $data->work_name;?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                          </tr>
                                          <tr>
                                              <td>कामको क्षेत्रको नाम</td>
                                              <td><input type="text" name="task_name" value=""/></td>
                                          </tr>
                                          <tr>
                                              <td>इकाई </td>
                                                <td > <select name="unit_id">
                                                        <option value="">--छान्नुहोस् --</option>
                                                        <?php foreach($units as $unit): ?>
                                                          <option value="<?=$unit->id?>"><?=$unit->name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>