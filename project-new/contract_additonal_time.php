<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$mode=getUserMode();
if($mode!="administrator")
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
        $data = new Contracttimeadditionaffiliation();
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
 $more_plan_details = Contractmoredetails::find_by_plan_id($_GET['id']);
$total_period = Contracttimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
empty($total_period)? $total_period=0 : '';
$extended_date = '';
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?></h2>
            <div class="OurContentLeft">
                   <?php include("menuincludes/contract_side_menu.php");?>
            </div>	
                <?php echo $_GET['msg'];?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                   
                     <div>
                                    <h3>योजनाको म्याद थप सम्बन्धी बिषेश व्यबस्था</h3>
                                    <?php if($total_period>0):
                                     
                                  for($i=1; $i<=$total_period; $i++): 
                                        $period_data = Contracttimeadditionaffiliation::find_by_plan_period($i,$_GET['id']);
                                        $extended_date = $period_data->extended_date;
                                     ?>
                                 
                                 <h3 class="myheader"><?=$inst_array[$i]?> म्याद थपको विवरण</h3>
                            <div class="mycontent"  style="display:none;">
                             <table class="table table-bordered table-responsive">
                                        
                              <tr>
                                    <td>अवधि</td>
                                    <td><?=$inst_array[$i]?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना म्याद भित्र नसकिनुको कारण</td>
                                    <td><?=$period_data->program_problem_reason?></td>
                                  </tr>
                                  <tr>
                                    <td>म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती</td>
                                    <td><?=$period_data->letter_date?></td>
                                  </tr>
                                  <tr>
                                    <td>म्याद थपको कार्यालयबाट निर्णय भएको मिती</td>
                                    <td><?=$period_data->decesion_date?></td>
                                  </tr>
                                  <tr>
                                    <td>थपिएको म्यादको अबधी</td>
                                    <td><?=$period_data->extended_date?></td>
                                  </tr>
                       </table>
                     </div>
                         <?php endfor; ?>        
                         <?php endif; ?>
                                 <h3><?=$inst_array[$total_period+1]?> म्याद थपको विवरण भर्नुहोस्</h3>
                                <div class="mycontent">
                                 <form method="post" >
                                     
                                    <table class="table table-bordered">
                                    <tr>
                                        <td>तोकिएको सम्पन्न मिति </td>
                                        <td><?php echo $more_plan_details->completion_date; ?></td>
                                    </tr>
                                    <?php if(!empty($extended_date)): ?>
                                    <tr>
                                        <td>म्याद थप भइ पुन: तोकिएको सम्पन्न मिति</td>
                                        <td><?php echo $extended_date; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                  <tr>
                                    <td>अवधि</td>
                                    <td><select name="period" required/>
                                    <option value="<?=$total_period+1?>"><?=$inst_array[$total_period+1]?></option>
                                        </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>योजना म्याद भित्र नसकिनुको कारण</td>
                                    <td><textarea name="program_problem_reason"></textarea></td>
                                  </tr>
                                  <tr>
                                    <td>म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती</td>
                                    <td><input type="text" name="letter_date" id="nepaliDate3" /></td>
                                  </tr>
                                  <tr>
                                    <td>म्याद थपको कार्यालयबाट निर्णय भएको मिती</td>
                                    <td><input type="text" name="decesion_date" id="nepaliDate5"/></td>
                                  </tr>
                                  <tr>
                                    <td>थपिएको म्यादको अबधी</td>
                                    <td><input type="text" name="extended_date" id="nepaliDate15" /></td>
                                  </tr>
                                  <tr>
                                      <td>&nbsp;</td>
                                      <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere" /></td>
                                  </tr>
                                </table>
                                     
                                     <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                                 </form>
                                     </br></br>
                                </div>
                                               </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
<script src="js/jquery-1.7.1.min.js"></script>