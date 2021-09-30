<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//get_access_form($_GET['id']);
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
if(isset($_POST['submit']))
{
        //योजना संचालनमा पेश्की दिनु पर्ने अत्याबश्यक भएमा   
        if(!empty($_POST['create_id']))
        {
          $data4 = Planstartingfund::find_by_id($_POST['create_id']);
        }
        else
        {
          $data4= new Planstartingfund();  
        }
        $data4->advance=$_POST['advance'];
        $data4->advance_taken_date=$_POST['advance_taken_date'];
         $data4->advance_taken_date_english=  DateNepToEng($_POST['advance_taken_date']);
     	$data4->advance_return_date=$_POST['advance_return_date'];
     	$data4->advance_return_date_english=DateNepToEng($_POST['advance_return_date']);
        $data4->advance_reason=$_POST['advance_reason'];
        $data4->plan_id=$_POST['plan_id'];
         $data4->created_date=date("Y-m-d",time());
        $data4->save();
        $session->message("Data Saved Successfully");
        redirect_to("plan_form2.php");
 
}

 $value = "सेभ गर्नुहोस";
 $plan_selected = Plandetails1::find_by_id($_GET['id']);
 $upov_selected = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
 $data = Planstartingfund::find_by_plan_id($_GET['id']);
 
 if(empty($data))
 {
  $data = Planstartingfund::setEmptyObjects();
  $value = "अपडेट गर्नुहोस";
 }
$samiti_plan_total = Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
  $total_investment = Plantotalinvestment::find_by_plan_id($_GET['id']);
 if(!empty($total_investment))
 {
    $link="bhuktani_select.php";
 }
 elseif(!empty($samiti_plan_total))
 {
      $link="samiti_bhuktani_select.php";
 }
 else
 {
     $link = "amanat_bhuktani_dashboard.php";
 }
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> , दर्ता न :<?=convertedcit($_GET['id'])?> | <a href="<?=$link?>" class="btn">पछि जानुहोस</a> | <a href="plan_form4" class="btn">अगाडी जानुहोस</a> | <a href="plan_form5.php" class="btn">अन्तिम भुक्तानीमा जानुहोस</a></h2>
            
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                     <div>
                            <form method="post" enctype="multipart/form_data">
                            <div class="inputWrap">
                            <h1>योजना संचालनमा पेश्की दिनु पर्ने अत्याबश्यक भएमा </h1>
                                
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                               <div class="titleInput">पेश्की  रकम</div>
                               <div class="newInput"><input type="text" name="advance" value="<?=$data->advance?>" required /></div> 
                               <div class="titleInput">पेश्की दिएको मिती</div>
                               <div class="newInput"><input type="text" name="advance_taken_date" value="<?=$data->advance_taken_date?>" required  id="nepaliDate3" class="datewidth70"/></div> 
                               <div class="titleInput">पेश्की फर्छ्यौट गर्नु पर्ने मिति</div>
                               <div class="newInput"><input type="text"  name="advance_return_date" value="<?=$data->advance_return_date?>" required   id="nepaliDate5" class="datewidth70" /></div> 
                               <div class="titleInput">पेश्की दिनु पर्ने कारण</div>
                               <div class="newInput"><textarea name="advance_reason"  required ><?=$data->advance_reason?></textarea></div> 
                               <div class="saveBtn myWidth100"><input type="hidden" name="create_id" value="<?=$data->id?>">
                        <input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                  
                              
                                
                        </div><!-- input wrap ends -->
                                          
 </form>
              
                </div>
                  </div>
                </div><!-- main menu ends -->
              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>