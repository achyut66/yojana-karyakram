<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
?>
<?php include("menuincludes/topwrap.php");?>
<?php include("menuincludes/header.php"); ?>
<title>ठेक्का सम्बन्धि विवरण <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php $invest_details = Ethekkainfo::find_by_plan_id($_GET['id']);
    // print_r($invest_details);
            $plan_details = Plandetails1::find_by_id($_GET['id']);
    ?>
<div id="body_wrap_inner"> 
<div class="maincontent">
<h2 class="headinguserprofile">ठेक्काका लागि छनौट भएका निर्माण व्यवसायीको विवरण | <a href="contract_first_dash.php" class="btn">पछि जानुहोस </a></h2>
<h2 class="headinguserprofile">योजनाको नाम  / दर्ता नं:  <?php echo $plan_details->program_name;?> / <?php echo convertedcit($plan_details->id);?></h2>
<div class="myspacer"></div>
<div class="userprofiletable">
<div class="OurContentFull">
    <table class="table table-bordered table-responsive table-striped">
        <thead>
                <th>सी.नं</th>
                <th>ठेक्काका लागि छनौट भएका निर्माण व्यवसायीको नाम</th>
                <th>फर्म / कम्पनी ठेगाना</th>
                <th>सम्पर्क नं</th>
                <th>ठेक्का नं</th>
                <th>ठेक्का रकम (रु)</th>
                <th>कबोल रकम (रु)</th>
                <th>प्रकाशित मिति</th>
                <th>बैंकको नाम</th>
                <th>ठेगाना</th>
                <th>बैंक ग्यारेन्टी रकम</th>
                <th>बैंक ग्यारेन्टी रकम अवधि</th>
                <th>धरौटी खातामा जम्मा गरिएको रकम</th>
                <th>धरौटी खातामा रकम जम्मा गरेको मिति</th>
                <th>बोलपत्र आव्हान गरेको माध्यम</th>
                <th>बोलपत्र आव्हान मिति</th>
        </thead>
        <?php $i=1;?>
        <tbody>
                <td><?php echo convertedcit($i);?></td>
                <td><?php echo $invest_details->firm_name;?></td>
                <td><?php echo $invest_details->firm_address;?></td>
                <td><?php echo convertedcit($invest_details->contact_no);?></td>
                <td><?php echo convertedcit($invest_details->thekka_no);?></td>
                <td><?php echo convertedcit($invest_details->thekka_rakam);?></td>
                <td><?php echo convertedcit($invest_details->kabol_rakam);?></td>
                <td><?php echo convertedcit($invest_details->print_date);?></td>
                <td><?php echo $invest_details->bank_name;?></td>
                <td><?php echo $invest_details->bank_address;?></td>
                <td><?php echo convertedcit($invest_details->bank_amount);?></td>
                <td><?php echo convertedcit($invest_details->bank_date);?></td>
                <td><?php echo convertedcit($invest_details->dharauti_amt);?></td>
                <td><?php echo convertedcit($invest_details->dharauti_miti);?></td>
                <td><?php echo $invest_details->bolpatra_m;?></td>
                <td><?php echo convertedcit($invest_details->bolpatra_miti);?></td>
        </tbody>
        <?php $i++;?>
    </table>
</div>
</div>
</div>
</div>
</body>
<?php include("menuincludes/footer.php");?>