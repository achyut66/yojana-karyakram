<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

?>
<?php
$result= Contractentryfinal::find_by_plan_id($_SESSION['set_plan_id']);
                    ?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>धरौटी विवरण:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                <div class="maincontent">
                   
                    <h2 class="headinguserprofile">धरौटी  विवरण भर्नुहोस् | <a href="contractdharauti_dashboard.php" class="btn">पछि जानुहोस</a> </h2>
                   
                    <div class="OurContentFull">
                        <h2><?php echo $data->program_name;?></h2>
                        <div class="userprofiletable">
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>निर्माण ब्यवोसायीको नाम</strong></td>
                                            <td class="myCenter"><strong>धरौटी रकम थप्नुहोस</strong></td>

                                          </tr>
                                          <?php $i=1; foreach($result as $data):
                                                 $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                                          ?>
                                          <tr>
                                                <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                <td class="myCenter"><?php echo $contractor_details->contractor_name;?></td>
                                               <td class="myCenter"><a href="add_dharauti.php?plan_id=<?php echo $_SESSION['set_plan_id'];?>&contractor_id=<?php echo $data->id;?>" class="btn">थप्नुहोस</a></td>
                                              </tr>
                                          <?php $i++;endforeach;?>
                                        </table>
                            </form>
                        </div>
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>