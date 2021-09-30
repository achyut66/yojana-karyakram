<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if(isset($_POST['submit']))
{
    $data=new Programdetails();
   // $data->sn=$_POST['sn'];
    $data->fiscal_id=$_POST['fiscal_id'];
    $data->topic_area_id=$_POST['topic_area_id'];
    $data->topic_area_type_id=$_POST['topic_area_type_id'];
    $data->topic_area_type_sub_id=$_POST['topic_area_type_sub_id'];
    $data->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
    $data->topic_area_investment_id=$_POST['topic_area_investment_id'];
    $data->ward_no=$_POST['ward_no'];
    $data->program_name=$_POST['program_name'];
    $data->investment_amount=$_POST['investment_amount'];
    $plan_id=$data->save();
	$session->message("नया कार्यक्रम दर्ता न० ".$plan_id);
	redirect_to("plan_form.php");
}
$postnames = Postname::find_all();
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
$bank_details=  Bankinformation::find_all();
$fiscals=  Fiscalyear::find_all();

?>

<?php include("menuincludes/header.php"); ?>
<title>नया योजना विवरण दर्ता फाराम :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">नया कार्यक्रम विवरण दर्ता फाराम / <a href="index.php">Go Back</a></h2>
           
            <div class="OurContentFull">
					<div class="myMessage"> <?php echo $message;?></div>
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                 <form method="post" enctype="multipart/form_data" >
                     <h3>नया कार्यक्रमको विवरण भर्नुहोस</h3>
                     <table class="table table-bordered table-responsive">
                                        <tr>
                                            <td>आर्थिक वर्ष </td>
                                            <td>
                                                <select name="fiscal_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($fiscals as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </td>
                                          </tr>    
										   <tr>
                                            <td>कार्यक्रमको नाम</td>
                                            <td><textarea id="topic_name" name="program_name" required></textarea></td>
                                          </tr>              
                                       
                                            <tr>
                                        <td> बिषयगत क्षेत्रको किसिम: </td>
										    <td><select name="topic_area_id" id="topic_area_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
										</td>
                                          </tr>
                                           <tr id="topic_area_type_id">
                                              
                                           </tr>
                                           <tr id="topic_area_type_sub_id">
                                              
                                           </tr>
                                           <tr>
                                           <td>    अनुदानको किसिम:  </td>
										   <td> <select name="topic_area_agreement_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_agreement as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></td>
                                          </tr>
                                           <tr>
                                            <td>  विनियोजन किसिम:</td>
											<td><select name="topic_area_investment_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
													</td>
                                          </tr>
                                          
                                          
                                           <tr>
                                            <td>वार्ड नं :</td>
                                            <td><input type="text" id="topic_name"  name="ward_no" required></td>
                                           </tr>
                                         
                                           <tr>
                                            <td> अनुदान रु :</td>
                                            <td><input type="text" id="topic_name" name="investment_amount" required></td>
                                           </tr>
                                          
                                        <tr>
                                            <td>&nbsp;</td>
                                           <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                          </tr>
                                        </table>


 </form>


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>