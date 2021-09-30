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
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
if(isset($_POST['submit']))
{
        //मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा 
        $data = new Plantimeadditionaffiliation;
        $data->period = $_POST['period'];
        $data->program_problem_reason = $_POST['program_problem_reason'];
        $data->letter_date = $_POST['letter_date'];
        $data->letter_date_english = DateNepToEng($data->letter_date);
        $data->decesion_date = $_POST['decesion_date'];
        $data->decesion_date_english = $data->decesion_date;
        $data->extended_date = $_POST['extended_date'];
        $data->extended_date_english = DateNepToEng($data->extended_date);
        $data->plan_id = $_POST['plan_id'];
        $data->save();
        $session->message("म्याद थप सफल");
        redirect_to("additionaldate.php");
}

$value = "सेभ गर्नुहोस";
 $plan_selected = Plandetails1::find_by_id($_GET['id']);
 $more_plan_details = Moreplandetails::find_by_plan_id($_GET['id']);
$total_period = Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
empty($total_period)? $total_period=0 : '';
$extended_date = '';
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
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> , दर्ता न :<?=convertedcit($_GET['id'])?> | <a href="<?=$link?>" class="btn">पछि जानुहोस</a></h2>
           
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                   
                     <div>
                                    <h3>योजनाको म्याद थप सम्बन्धी बिषेश व्यबस्था</h3>
                                    <?php if($total_period>0):
                                     
                                  for($i=1; $i<=$total_period; $i++): 
                                        $period_data = Plantimeadditionaffiliation::find_by_plan_period($i,$_GET['id']);
                                        $extended_date = $period_data->extended_date;
                                     ?>
                                 
                            <h3 class="myheader"><?=$inst_array[$i]?> म्याद थपको विवरण</h3>
                            <div class="mycontent"  style="display:none;">
                            <div class="inputWrap100">
                            	<div class="inputWrap50 inputWrapLeft">
                                	<div class="titleInput">अवधि : <span class="underline"><?=$inst_array[$i]?></span></div>
                                    <div class="titleInput">योजना म्याद भित्र नसकिनुको कारण : <span class="underline"><?=$period_data->program_problem_reason?></span></div>
                                </div>
                                <div class="inputWrap50 inputWrapLeft">
                                	<div class="titleInput">म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती : <span class="underline"><?=$period_data->letter_date?></span></div>
                                    <div class="titleInput">म्याद थपको कार्यालयबाट निर्णय भएको मिती : <span class="underline"><?=$period_data->decesion_date?></span></div>
                                <div class="titleInput">थपिएको म्यादको अबधी : <span class="underline"><?=$period_data->extended_date?></span></div>
                                
                                
                                	
                                    
                                </div>
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends --> 
                            
                     </div>
                         <?php endfor; ?>        
                         <?php endif; ?>
                                 <h3><?=$inst_array[$total_period+1]?> म्याद थपको विवरण भर्नुहोस्</h3>
                                <div class="mycontent">
                                 <form method="post" >
                                    <div class="inputWrap100">
                                    	<div class="inputWrap50 inputWrapLeft">
                                        	<div class="titleInput">तोकिएको सम्पन्न मिति : <span class="underline"><?php echo $more_plan_details->yojana_sakine_date; ?></span></div>
                                            <div class="titleInput"><?php if(!empty($extended_date)): ?>
                                    		म्याद थप भइ पुन: तोकिएको सम्पन्न मिति : <span class="underline"><?php echo $extended_date; ?></span>
                                    </tr>
                                    <?php endif; ?></div>
                                            <div class="titleInput">अवधि</div>
                                            <div class="newInput"><select name="period" required/>
                                    <option value="<?=$total_period+1?>"><?=$inst_array[$total_period+1]?></option>
                                        </select></div>
                                        <div class="titleInput">योजना म्याद भित्र नसकिनुको कारण:</div>
                                        <div class="newInput"><textarea name="program_problem_reason"></textarea></div>
                                        </div><!-- input wrap 50 ends -->
                                        <div class="inputWrap50 inputWrapLeft">
                                        	<div class="titleInput">म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती:</div>
                                            <div class="newInput"><input type="text" name="letter_date" id="nepaliDate3" class="datewidth" /></div>
                                            <div class="titleInput">म्याद थपको कार्यालयबाट निर्णय भएको मिती:</div>
                                            <div class="newInput"><input type="text" name="decesion_date" id="nepaliDate5" class="datewidth"/></div>
                                            <div class="titleInput">थपिएको म्यादको अबधी:</div>
                                            <div class="newInput"><input type="text" name="extended_date" id="nepaliDate15" class="datewidth" /></div>
                                            <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn" /></div>
                                        </div><!-- input wrap 50 ends -->
                                    	<div class="myspacer"></div>
                                    </div><!-- input wrap 100 ends --> 
                                    
                                     <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                                 </form>
                                     
                                </div>
                                               </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
<script src="js/jquery-1.7.1.min.js"></script>