<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$units = Units::find_all();
?>

<?php include("menuincludes/header.php"); ?>
    <!-- js ends -->
    <title>भौतिक ईकाई :: <?php echo SITE_SUBHEADING;?></title>
    </head>
    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent">
            <h2 class="headinguserprofile">भौतिक ईकाई | <a href="settings_unit_add.php" class="btn">भौतिक ईकाई थप्नुहोस +</a> | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>

            <div class="OurContentFull">
                <h2>भौतिक ईकाईहरु:  </h2>
                <div class="userprofiletable">
                    <div class="myMessage"><?php echo $message;?></div>
                    <table class="table table-bordered table-hover">
                        <tr>

                            <td class="myCenter"><strong>क्रम संख्या</strong></td>
                            <td class="myCenter"><strong>भौतिक ईकाईको नाम</strong></td>
                            <td class="myCenter"><strong>भौतिक ईकाईको उपनाम</strong></td>
                            <td class="myCenter"><strong>सच्याउनुहोस्</strong></td>

                        </tr>
                        <?php $i = 1; foreach($units as $data): ?>
                            <tr>
                                <td class="myCenter"> <?php echo convertedcit($i); ?></td>
                                <td class="myCenter"><?php echo $data->name;?></td>
                                <td class="myCenter"><?php echo $data->alias;?></td>
                                <form method="post" action="unit_delete.php">
                                <td class="myCenter">
                                    <a href="settings_unit_edit.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
                                    <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                    <input type="hidden" name="id" value="<?=$data->id?>">
                                </td>
                                </form>
                            </tr>

                            <?php $i++; endforeach; ?>
                    </table>

                </div>
            </div>
        </div><!-- main menu ends -->

    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>