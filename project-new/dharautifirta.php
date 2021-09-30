<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

?>
<?php

$program_id = $_GET['id'];
$program_details=Plandetails1::find_by_id($program_id);
//print_r($program_details);exit;
if (isset($_POST['submit'])) {
    
    $update_id=$_POST['update_id'];
    empty($update_id)? $program =  new Programmoredetails : $program = Programmoredetails::find_by_id($update_id);
    $start_date_nepali = $_POST['start_date'];
    $completion_date_nepali = $_POST['completion_date'];
    $start_date_english = DateNepToEng($start_date_nepali);
    $completion_date_english = DateNepToEng($completion_date_nepali);
    $_POST['start_date_english'] = $start_date_english;
    $_POST['completion_date_english'] = $completion_date_english;
    if ($program->savePostData($_POST)) {

        $session->message("कार्यक्रम संचालन विवरण सच्याउनु सफल");
        redirect_to("program_more_details.php?id=".$program_id);
    }
}

$program_more_details= Programmoredetails::find_by_program_id($program_id);
$update_value = "";
  if(empty($program_more_details))
  {
      $program_more_details = Programmoredetails::setEmptyObjects();
      //print_r($program_more_details); exit;
  }
?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>कार्यक्रम संचालन विवरण सच्याउनु होस्:: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
	        <h2 class="headinguserprofile">धरौटी  विवरण भर्नुहोस् </h2>                    
            	<div class="OurContentFull">
                        <h2><?php echo $program_details->program_name;?></h2>
                        <div class="userprofiletable">
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered table-hover">
                                      <tr>
                                        <td style="width:34.5%">कार्यक्रमको  संचालन गर्ने</td>
                                        <td>  
                                      <select name="type_id" class="show">
                                               <option value="">छान्नुहोस्</option>
                                               <option value="0" <?php if($program_more_details->type_id==="0"){echo "selected='selected'";} ?>>फर्म/कम्पनी</option>
                                               <option value="1" <?php if($program_more_details->type_id==="1"){echo "selected='selected'";} ?>>कर्मचारी</option>
                                               <option value="2" <?php if($program_more_details->type_id==="2"){echo "selected='selected'";} ?>>संस्था</option>
                                               <option value="3" <?php if($program_more_details->type_id==="3"){echo "selected='selected'";} ?>>पदाधिकारी</option>
                                           </select>
                                        </td>
                                     </tr>
                                     <tr id="type">
                                     </tr>
                                </table>
                                <table  class="table table-bordered table-hover" >
                                    <tr>
                                        <td>धरौटी कट्टी रकम</td>
                                        <td><input type="text" name="dharauti_amount" value="<?php ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>धरौटी कट्टी फिर्ता </td>
                                        <td> <input type="text" name="return_amount"/></td>
                                    </tr>
                                </table>
                                 <table class="table table-bordered table-hover">    
                                    <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></td>
                                    <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                                         <input type="hidden" name="update_id" value="<?php echo $program_more_details->id?>"/>
                                    </tr>
                                </table>
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>