<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    $data= Units::find_by_id($_POST['id']);
    //  $data->sn= $_POST['sn'];
    $data->name= $_POST['name'];
    $data->alias= $_POST['alias'];
    if($data->save())
    {
        $session->message("डाटा सेव भयो ||");
        redirect_to("settings_unit.php");
    }
}
$unit = Units::find_by_id($_GET['id']);
?>
    <!-- js ends -->
    <title>भौतिक ईकाई:: <?php echo SITE_SUBHEADING;?></title>
    </head>
    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent">
            <h2 class="headinguserprofile">भौतिक ईकाई | <a href="settings_unit.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
                <div class="myMessage">
                    <?php echo $message;?>
                </div>
                <h2>भौतिक ईकाई </h2>
                <div class="userprofiletable">
                    <form method="post" enctype="multipart/form-data">
                        <div class="inputWrap">
                            <div class="titleInput">भौतिक ईकाईको नाम : </div>
                            <div class="newInput"><input type="text" id="topic_name" name="name" value="<?php echo $unit->name; ?>"></div>
                            <div class="titleInput">भौतिक ईकाईको उपनाम : </div>
                            <div class="newInput"><input type="text" id="topic_alias" name="alias" value="<?php echo $unit->alias; ?>"></div>
                            <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                            <input type="hidden" value="<?php echo $unit->id; ?>" name="id" />
                            <div class="myspacer"></div>
                        </div><!-- input wrap ends -->
                    </form>
                </div>
            </div>
        </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>