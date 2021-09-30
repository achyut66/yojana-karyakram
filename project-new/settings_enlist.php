<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php
 $enlist="";
if(!empty($_GET['id']))
{
$id = $_GET['id'];
$enlist= Enlist::find_by_id($id);
}
if (isset($_POST['submit'])) {
    $update_id=$_POST['update_id'];
    empty($update_id)? $enlist_type =  new Enlist : $enlist_type = Enlist::find_by_id($update_id);
    if ($enlist_type->savePostData($_POST)) {

        $session->message("सूची दर्ता विवरण हाल्न सफल");
        redirect_to("settings_enlist_view.php");
    }
}

$update_value = "";
  if(empty($enlist))
  {
      $enlist = Enlist::setEmptyObjects();
      //print_r($enlist); exit;
  }
?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>सूची दर्ता:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
                    <h2 class="headinguserprofile">सूची दर्ता विवरण भर्नुहोस्  | <a href="settings_enlist_view.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                        
                        <div class="userprofiletable">
                            <form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>सूची दर्ता विवरण भर्नुहोस्  </h1>
                                    <div class="titleInput">संचालन गर्ने:</div>
                                    <div class="newInput"><select name="type" class="showhide">
                                               <option value="">छान्नुहोस्</option>
                                               <option value="0" <?php if($enlist->type==="0"){echo "selected='selected'";} ?>>फर्म/कम्पनी</option>
                                               <option value="1" <?php if($enlist->type==="1"){echo "selected='selected'";} ?>>कर्मचारी</option>
                                               <option value="2" <?php if($enlist->type==="2"){echo "selected='selected'";} ?>>संस्था</option>
                                               <option value="3" <?php if($enlist->type==="3"){echo "selected='selected'";} ?>>पदाधिकारी</option>
                                                 <option value="4" <?php if($enlist->type==="4"){echo "selected='selected'";} ?>>अन्य समूह </option>
                                                 <option value="4" <?php if($enlist->type==="4"){echo "selected='selected'";} ?>>उपभोक्ता समिति</option>
                                           </select></div>
                                    <div id="company" style="display: none">
                                    	<div class="titleInput">फर्म/कम्पनीका नाम : </div>
                                    	<div class="newInput"><input type="text"  name="name0" value="<?php echo $enlist->name0; ?>" /></div>
                                        <div class="titleInput">ठेगाना : </div>
                                    	<div class="newInput"><input type="text"  name="address0" value="<?php echo $enlist->address0; ?>"/></div>
                                        <div class="titleInput">सम्पर्क नं : </div>
                                    	<div class="newInput"><input type="text" name="number0" value="<?php echo $enlist->number0; ?>"/></div>
                                    </div><!-- company ends -->
                                    <div id="staff" style="display: none">
                                    	<div class="titleInput">कर्मचारीका नाम : </div>
                                        <div class="newInput"><input type="text" name="name1" value="<?php echo $enlist->name1; ?>"/></div>
                                        <div class="titleInput">पद : </div>
                                        <div class="newInput"><input type="text"  name="post1" value="<?php echo $enlist->post1; ?>"/></div>
                                        <div class="titleInput">कार्यरत शाखा : </div>
                                        <div class="newInput"><input type="text"  name="branch1" value="<?php echo $enlist->branch1; ?>"/></div>
                                        <div class="titleInput">ठेगाना : </div>
                                        <div class="newInput"><input type="text"  name="address1" value="<?php echo $enlist->address1; ?>"/></div>
                                        <div class="titleInput">सम्पर्क नं : </div>
                                        <div class="newInput"><input type="text"  name="number1" value="<?php echo $enlist->number1; ?>"/></div>
                                    </div><!-- staff ends -->
                                    <div id="group" style="display: none">
                                    	<div class="titleInput">संस्थाका नाम : </div>
                                        <div class="newInput"><input type="text" name="name2" value="<?php echo $enlist->name2; ?>"></div>
                                        <div class="titleInput">ठेगाना : </div>
                                        <div class="newInput"><input type="text"  name="address2" value="<?php echo $enlist->address2; ?>"></div>
                                        <div class="titleInput">सम्पर्क नं : </div>
                                        <div class="newInput"><input type="text"  name="number2" value="<?php echo $enlist->number2; ?>"></div>	
                                    </div><!-- group ends -->
                                    <div id="working-field" style="display: none">
                                    	<div class="titleInput">कर्मचारीका नाम : </div>
                                        <div class="newInput"><input type="text" name="name3" value="<?php echo $enlist->name3; ?>"/></div>
                                        <div class="titleInput">पद : </div>
                                        <div class="newInput"><input type="text"  name="post3" value="<?php echo $enlist->post3; ?>"/></div>
                                        <div class="titleInput">ठेगाना : </div>
                                        <div class="newInput"><input type="text"  name="address3" value="<?php echo $enlist->address3; ?>"/></div>
                                        <div class="titleInput">सम्पर्क नं : </div>
                                        <div class="newInput"><input type="text"  name="number3" value="<?php echo $enlist->number3; ?>"/></div>
                                    </div><!-- working field ends-->
                                    <div id="other-field" style="display: none">
                                    	<div class="titleInput">नाम : </div>
                                        <div class="newInput"><input type="text" name="name4" value="<?php echo $enlist->name4; ?>"/></div>
                                        <div class="titleInput">ठेगाना : </div>
                                        <div class="newInput"><input type="text"  name="address4" value="<?php echo $enlist->address4; ?>"/></div>
                                        <div class="titleInput">सम्पर्क नं : </div>
                                        <div class="newInput"><input type="text"  name="number4" value="<?php echo $enlist->number4; ?>"/></div>
                                    
                                    </div><!-- input other field ends -->
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn">
                                         <input type="hidden" name="update_id" value="<?php echo $enlist->id?>"/></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
