<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$result = Upabhoktasamitiprofile::find_all();
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
                        <h2 class="headinguserprofile">कार्यक्रम संचालन गर्ने  उपभोक्ता समिति सम्बन्धी विवरण  | <a href="settings.php" class="btn">पछि जानुहोस 
</a></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <h2><a href="upabhokta_samiti_info.php" class="btn myWidth50">कार्यक्रम संचालन गर्ने उपभोक्ता समिति थप्नुहोस [+]</a></h2>
                       
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>उपभोक्ता समितिको नाम </strong></td>
                                    <td class="myCenter"><strong>ठेगाना</strong></td>
                                    <td class="myCenter"><strong>पुरा विवरण हेर्नुहोस</strong></td>
                                </tr>
                                <?php $i=1; foreach($result as $data):?>
                                <tr>
                                    <td><?=convertedcit($i)?></td>
                                    <td><?=$data->program_organizer_group_name?></td>
                                    <td><?=$data->program_organizer_group_address?></td>
                                    <td><a href="upabhokta_samiti_view.php?id=<?=$data->id?>" class="btn">विवरण हेर्नुहोस</a> &nbsp;&nbsp;&nbsp;<a href="upabhokta_samiti_info.php?id=<?=$data->id?>" class="btn">सच्याउनुहोस</a></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </table>
                       
                          </div>
            </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>