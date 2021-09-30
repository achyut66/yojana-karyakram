<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

if(isset($_POST['submit']))
{
        $data = SettingSpecs::find_by_id($_POST['update_id']);
        $_POST['enable']=1;
        if($data->savePostData($_POST,"create"))
        {
           echo alertBox("Specification added Successfully", "settings_specification.php");    
        }

}

$work_details   = Worktopic::find_all();
$specification  = SettingSpecs::find_by_id((int) $_GET['id']); 
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>प्राबिधिक इष्टिमेट थपनुहोस  :: Kanepokhari Gaupalika</title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्राबिधिक Specification थपनुहोस  / <a href="settings_specification.php">Go back</a></h2>
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
                                                    <option value="<?php echo $data->id;?>" <?php if($specification->task_id==$data->id){ ?> selected="selected" <?php } ?> ><?php echo $data->work_name;?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                          </tr>
                                          <tr>
                                              <td>Specification ko  नाम</td>
                                              <td><input type="text" name="name" value="<?=$specification->name?>"/></td>
                                          </tr>
                                          <tr>
                                              <td>Default </td>
                                              <td> 
                                                  Yes : <input type="radio" name="default_spec" value="1" <?php if($specification->default_spec==1){ ?> checked="checked" <?php } ?> /> 
                                                  No : <input type="radio" name="default_spec" value="0"  <?php if($specification->default_spec==0){ ?> checked="checked" <?php } ?>/>
                                              </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>
                                    <input type="hidden" name="update_id" value="<?=$specification->id?>" />
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>