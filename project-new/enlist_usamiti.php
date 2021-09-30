<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
error_reporting(1);
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);

if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$sql="select * from costumer_association_details_0 order by id asc";
$usamiti = Costumerassociationdetails0::find_by_sql($sql);

?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">उपभोक्ता समिति सुची दर्ता विवरण | </h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    
                     <table class="table table-bordered table-hover">
                         <tr>       <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>योजना दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>उपभोक्ता समिति दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>उपभोक्ता समितिको नाम</strong></td>
                                    <td class="myCenter"><strong>वडा नं</strong></td>
                                    <td class="myCenter"><strong>गठन मिती</strong></td>
                                    <td class="myCenter"><strong>पुरा विवरण हेर्नुहोस</strong></td>
                                    <td class="myCenter"><strong>पत्र प्रिन्ट गर्नुहोस</strong></td>
                                   
                                </tr>
                                <?php $i=1;
                             
                                  foreach($usamiti as $data):
                                
                                    ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->plan_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_organizer_group_name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->program_organizer_group_address);?></td>
                                    <td class="myCenter"><?= convertedcit(DateEngToNep($data->created_date)) ?></td>
                                    <td class="myCenter"><a href="enlist_upabhokta_samiti.php?id=<?= $data->id ?>" class="btn">पुरा विवरण हेर्नुहोस</a><a href="settings_upabhokta_samiti_add.php?id=<?= $data->id ?>" class="btn">साच्याउनु होस्</a></td>
                                    <td class="myCenter"><a href="print_bank_report_enlist.php?id=<?= $data->id ?>" class="btn">पत्र</a></td>
                                </tr>
                         <?php $i++; 
                        
                         endforeach;?>
                           
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>