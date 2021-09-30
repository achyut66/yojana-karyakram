<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
if(isset($_POST['submit']))
{
	$data = Estimateadd::find_by_id($_POST['update_id']);
        $data->task_id=$_POST['task_id'];
        $data->task_name=$_POST['task_name'];
        $data->unit_id=$_POST['unit_id'];
	if($data->save())
       {
        $session->message("प्राबिधिक इष्टिमेट सच्याउन सफल");    
        redirect_to("view_estimate.php");
        
      }

 }
 $result=  Estimateadd::find_by_id($_GET['id']);
 $units = Units::find_all();
$work_details=Worktopic::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>प्राबिधिक इष्टिमेट विवरण  सच्याउनु होस्  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्राबिधिक इष्टिमेट विवरण  सच्याउनु होस्</h2>
                    <div class="OurContentLeft">
                   	  <?php include("menuincludes/main_dashboard.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>प्राबिधिक इष्टिमेट विवरण  सच्याउनु होस्</h2>
                        <div class="userprofiletable">
                        	<form method="POST" enctype="multipart/form-data">
                                    	<table class="table table-bordered">
                                         
                                                                                         
                                         <tr>
                                            <td>क्षेत्र</td>
                                            <td>
                                                <select name="task_id">
                                                    <option value="">---छान्नुहोस्---</option>
                                                    <?php foreach($work_details as $data):?>
                                                    <option value="<?php echo $data->id;?>"<?php if($data->id==$result->id){ echo 'selected="selected"';}?>><?php echo $data->work_name;?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                          </tr>
                                          <tr>
                                              <td>कामको विवरण </td>
                                              <td><input type="text" name="task_name" value="<?=$result->task_name?>"/></td>
                                          </tr>
                                          <tr>
                                              <td>इकाई </td>
                                                <td > <select name="unit_id">
                                                        <option value="">--छान्नुहोस् --</option>
                                                        <?php foreach($units as $unit): ?>
                                                          <option value="<?=$unit->id?>" <?php if($unit->id==$result->unit_id){ echo 'selected="selected"';}?>><?=$unit->name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                            <input type="hidden" name="update_id" value="<?php echo $_GET['id'];?>"/>
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