<?php require_once("includes/initialize.php"); 
    if(!$session->is_logged_in())
    {
        redirect_to("logout.php");
    }
$postnames = Postname::find_all();
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
//print_r($topic_area_type);exit;
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
$bank_details=  Bankinformation::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area_sub=  Topicareatypesub::find_all();
$budget_result=  Topicbudget::find_all();
//print_r($budget_result);exit;
// on form submit
if(isset($_POST['submit']))
  {
        $data=  Plandetails1::find_by_id($_POST['update_id']);
        $data->budget_id=$_POST['budget_id'];
        $data->fiscal_id=$_POST['fiscal_id'];
        $data->parishad_sno=$_POST['parishad_sno'];
        $data->program_name=$_POST['program_name'];
        $data->topic_area_id=$_POST['topic_area_id'];
        $data->topic_area_type_id=$_POST['topic_area_type_id'];
        $data->topic_area_type_sub_id=$_POST['topic_area_type_sub_id'];
        $data->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
        $data->topic_area_investment_id=$_POST['topic_area_investment_id'];
        $data->ward_no=$_POST['ward_no'];
        $data->type = $_POST['type'];
        $data->expenditure_type= $_POST['expenditure_type'];
        $data->first=$_POST['first'];
    	$data->second=$_POST['second'];
  	$data->third=$_POST['third'];
        $data->investment_amount=$_POST['investment_amount'];
        if($data->save())
        {
            $session->message("सच्याउन सफल भयो |||");
            redirect_to("plan_form_view.php?page_no=".$_GET['id']);
        }
  }
  
$id=$_GET['id'];
//$id1 = $_POST['id'];
//print_r($id);
$result=  Plandetails1::find_by_id($id);
//print_r($result);exit;
include("menuincludes/header.php");
?>
<!-- js ends -->
<title>नया योजना विवरण सच्याउनुहोस्</title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
            <h2 class="headinguserprofile">नया योजना विवरण विवरण  सच्याउनुहोस् | <a href="plan_form_view.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	<div class="userprofiletable">
                        	 <form method="post" enctype="multipart/form-data">
                             	<div class="inputWrap100">
                                	<h1>नया योजना विवरण  हाल्नुहोस सच्याउनुहोस् </h1>
                                	<div class="inputWrap33 inputWrapLeft">
                                    	<div class="titleInput">आर्थिक वर्ष </div>
                                        <div class="newInput"><select name="fiscal_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($fiscals as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?><?php if($result->fiscal_id==$data->id){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                    <?php endforeach;?>
                                                </select></div>
                                        <div class="titleInput">बजेट उपशिर्षक : </div>
                                        <div class="newInput"><select name="budget_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($budget_result as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($result->budget_id == $data->id){?> selected="selected" <?php }?>><?php echo $data->name;?></option>
                                                    <?php endforeach;?>
                                                </select></div>
                                        <div class="titleInput">बिनियोजन श्रोत र व्याख्या : </div>
                                        <div class="newInput"><textarea  id="parishad_sno"  name="parishad_sno" required><?php echo $result->parishad_sno;?></textarea></div>
                                        <div class="titleInput">योजनाको नाम : </div>
                                        <div class="newInput"><textarea id="topic_name" name="program_name"   required><?php echo $result->program_name;?></textarea></div>
                                        <div class="titleInput">खर्च किसिम छान्नुहोस् : </div>
                                        <div class="newInput">
                                                    <select name="expenditure_type"required>
                                            			<option value="">--छान्नुहोस्--</option>
                                                        <option value="1" <?php if($result->expenditure_type==1){ echo 'selected="selected"';}?>>पुँजीगत खर्च </option>
                                            			<option value="2" <?php if($result->expenditure_type==2){ echo 'selected="selected"';}?>>चालु खर्च </option>
                                            		</select></div>
                                        
                                    </div><!-- input wrap 33 ends -->
                                    <div class="inputWrap33 inputWrapLeft">
                                    	
                                        <div class="titleInput">किसिम छान्नुहोस् : </div>
                                        <div class="newInput"><select name="type" required>
                                            			<option value="">--छान्नुहोस्--</option>
                                                                <option value="0" <?php if($result->type==0) {?> selected="selected" <?php }?>>योजना</option>
                                            			<option value="1" <?php if($result->type==1) {?> selected="selected" <?php }?>>कार्यक्रम</option>
                                            		</select></div>
                                        <div class="titleInput">योजनाको बिषयगत क्षेत्रको किसिम: </div>
                                        <div class="newInput"><select name="topic_area_id" id="topic_area_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                
                                                   <option value="<?php echo $topic->id?>"<?php if($result->topic_area_id==$topic->id){?> selected="selected" <?php }?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                                        
                                        <div class="newInput" id="topic_area_type_id"><select name="topic_area_type_id" id="topic_area_type_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_type as $data): ?> 
                                                   <option value="<?php echo $data->id?>"<?php if($result->topic_area_type_id==$data->id){?> selected="selected" <?php }?>><?php echo $data->topic_area_type;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                                        
                                        <div class="newInput" id="topic_area_type_sub_id"><select name="topic_area_type_sub_id" id="topic_area_type_sub_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_sub as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"<?php if($result->topic_area_type_sub_id==$topic->id){?> selected="selected" <?php }?>><?php echo $topic->topic_area_type_sub;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                                        <div class="titleInput">योजनाको अनुदानको किसिम:  </div>
                                        <div class="newInput"><select name="topic_area_agreement_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_agreement as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>" <?php if($result->topic_area_agreement_id==$topic->id){?> selected="selected" <?php }?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                                        
                                    </div><!-- input wrap 33 ends -->
                                    <div class="inputWrap33 inputWrapLeft">
                                    	<div class="titleInput">योजनाको विनियोजन किसिम: </div>
                                        <div class="newInput"><select name="topic_area_investment_id" required>
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>" <?php if($result->topic_area_investment_id==$topic->id){?> selected="selected" <?php }?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                                        <div class="titleInput">वार्ड नं : </div>
                                        <div class="newInput"><input type="text" id="topic_name"  name="ward_no"  value="<?php echo $result->ward_no;?>" required></div>
                                        <div class="titleInput">अनुदान रु : </div>
                                        <div class="newInput"><input type="text" name="investment_amount" id="investment_first" value="<?php echo $result->investment_amount;?>" required></div>
                                        <div class="titleInput">पहिलो चौमासिक : </div>
                                        <div class="newInput"><input type="text"  name="first" id="first"  value="<?php echo $result->first;?>"></div>
                                        <div class="titleInput">दोस्रो चौमासिक : </div>
                                        <div class="newInput"><input type="text"  name="second" id="second"   value="<?php echo $result->second;?>"></div>
                                        <div class="titleInput">तेस्रो चौमासिक : </div>
                                        <div class="newInput"><input type="text"  name="third" id="third"   value="<?php echo $result->third;?>"></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" id="first_check"  value=" अपडेट गर्नुहोस " class="btn">
                                          </div>
                                          <input type="hidden" name="update_id" value="<?php echo $result->id;?>"/>
                                        
                                    </div><!-- input wrap 33 ends -->
                                	
                                	<div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                             
                             
                     
                                  </form>
                             



                        </div>
                  </div>    
                </div><!-- main menu ends -->
         
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>