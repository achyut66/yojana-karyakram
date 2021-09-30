<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    $data=new Plandetails();
    $data->sn=$_POST['sn'];
    $data->topic_area_id=$_POST['topic_area_id'];
    $data->topic_area_type_id=$_POST['topic_area_type_id'];
    $data->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
    $data->topic_area_investment_id=$_POST['topic_area_investment_id'];
    $data->topic_area_investment_source_id=$_POST['topic_area_investment_source_id'];
    $data->ward_no=$_POST['ward_no'];
     $data->program_name=$_POST['program_name'];
      $data->tole_name=$_POST['tole_name'];
      $data->investment_amount=$_POST['investment_amount'];
      if($data->save())
    {
    $session->message("डाटा सेव भयो ||");
    redirect_to("view_plan_details.php");
    }
}
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
?>
<!-- js ends -->
<title>सह शिर्षक थप्नुहोस :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजना बिस्तृत विवरण दर्ता</h2>
                    <div class="OurContentLeft">
                   	  <?php include("menuincludes/settingsmenu.php");
                          ?>
                    </div>	
                        <?php echo $message;?>
                    <div class="OurContentRight">
                    
                        <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                                  <table class="table table-bordered">
                                          <tr>
                                            <td>दर्ता नं</td>
                                            <td><input type="text" id="topic_name" name="sn"></td>
                                          </tr>
                                            <tr>
                                          बिषयगत क्षेत्रको नाम: <select name="topic_area_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                          </tr></br></br>
                                           <tr>
                                                शिर्षकगत नाम:
                                                  <select name="topic_area_type_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_type as $data): ?> 
                                                   <option value="<?php echo $data->id?>"><?php echo $data->topic_area_type;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                          </tr></br></br>
                                           <tr>
                                            आयोजनाको अनुदानको किसिम: <select name="topic_area_agreement_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_agreement as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                          </tr></br></br>
                                           <tr>
                                            आयोजनाको विनियोजन किसिम:<select name="topic_area_investment_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                          </tr></br></br>
                                           <tr>
                                           आयोजनाको विनियोजन श्रोत:<select name="topic_area_investment_source_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment_source as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                           
                                          </tr></br></br>
                                           <tr>
                                            <td>आयोजनाको नाम</td>
                                            <td><input type="text" id="topic_name" name="program_name"></td>
                                          </tr></br></br>
                                           <tr>
                                            <td>आयोजना सचालन हुने स्थान</td>
                                            <td><?php echo SITE_LOCATION;?></td>
                                            <td><input type="text" id="topic_name" placeholder="वडा नं" name="ward_no"></td>
                                           </tr></br></br>
                                          <tr>
                                            <td>टोल बस्तीको नाम</td>
                                            <td><input type="text" id="topic_name" name="tole_name"></td>
                                          </tr></br></br>
                                           <tr>
                                            <td> <?php echo SITE_TYPE;?> बाट बिनियोजन रकम</td>
                                            <td><input type="text" id="topic_name" name="investment_amount"></td>
                                           </tr></br></br>
                                          
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