<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
 if(isset($_POST['upload_excel']))
  {
  //print_r($_FILES); exit;
   set_time_limit(5000);
  ini_set('memory_limit','512M');
  set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
  include 'PHPExcel/IOFactory.php';
    $filename = $_FILES["excel_file"]["tmp_name"];
      move_uploaded_file($filename, "uploads/".$_FILES['excel_file']['name']);
      $inputFileName = "uploads/".$_FILES['excel_file']['name'];
      
          $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
          $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
      $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

      for($i=2;$i<=$arrayCount;$i++){
          if(empty(trim($allDataInSheet[$i]["A"])))
          {
              continue;
          }
		  $plan = new Plandetails1();
		  $plan->fiscal_id=$_POST['fiscal_id'];
                  $plan->budget_id=$_POST['budget_id'];
                  $plan->type=$_POST['type'];
                  $plan->expenditure_type=$_POST['expenditure_type'];
                  $plan->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
                  $plan->topic_area_investment_id=$_POST['topic_area_investment_id'];
		  $plan->topic_area_id=$_POST['topic_area_id'];
		  $plan->topic_area_type_id=$_POST['topic_area_type_id'];
		  $plan->topic_area_type_sub_id=$_POST['topic_area_type_sub_id'];
		  $plan->program_name  = trim($allDataInSheet[$i]["A"]);
		  $plan->ward_no = trim($allDataInSheet[$i]["B"]);
		  if(isset($_POST['check_th']))
		  {
		    $plan->investment_amount  = trim($allDataInSheet[$i]["C"]) * 1000;
                  $plan->first  = trim($allDataInSheet[$i]["D"]) * 1000;
                  $plan->second  = trim($allDataInSheet[$i]["E"]) * 1000;
                  $plan->third  = trim($allDataInSheet[$i]["F"]) * 1000;
              
		  }
		  else
		  {
		      $plan->investment_amount  = trim($allDataInSheet[$i]["C"]);
                  $plan->first  = trim($allDataInSheet[$i]["D"]);
                  $plan->second  = trim($allDataInSheet[$i]["E"]);
                  $plan->third  = trim($allDataInSheet[$i]["F"]);
          
		  }
		          $plan->parishad_sno  = trim($allDataInSheet[$i]["G"]);
		  $plan->type =$_POST['type'];
		  $plan->save();
	  }
      redirect_to("plan_form_test.php");
    }
    
$postnames = Postname::find_all();
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
$bank_details=  Bankinformation::find_all();
$fiscals=  Fiscalyear::find_all();
$budget_result= Topicbudget::find_all();

?>

<?php include("menuincludes/header.php"); ?>
<title>नया योजना विवरण दर्ता फाराम :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">नया योजना विवरण दर्ता फाराम / <a href="index.php">Go Back</a></h2>
            
               
            <div class="OurContentFull">
					<div class="myMessage"> <?php echo $message;?></div>
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                  <form method="post" enctype="multipart/form-data">
                     <div class="inputWrap2">
                        <h3>नया योजनाको विवरण भर्नुहोस</h3>
                        <div class="inputWrap33 inputWrapLeft">
                       <div class="titleInput">आर्थिक वर्ष :</div>
                       <div class="newInput"><select id="fiscal_id"  name="fiscal_id">
                                                   <option value="">--छान्नुहोस्--</option>
                                                   <?php foreach($fiscals as $data):?>
                                                   <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                   <?php endforeach;?>
                                               </select>
                       </div>
                       <div class="titleInput">बजेट उपशिर्षक :</div>
                       <div class="newInput"> <select id="budget_id" name="budget_id">
                                                   <option value="">--छान्नुहोस्--</option>
                                                   <?php foreach($budget_result as $data):?>
                                                   <option value="<?php echo $data->id;?>" ><?php echo $data->name;?></option>
                                                   <?php endforeach;?>
                                               </select>

                       </div>
                      <div class="titleInput">खर्च किसिम छान्नुहोस् :</div>
                       <div class="newInput"><select name="expenditure_type  " >
                                                               <option value="">--छान्नुहोस्--</option>
                                                               <option value="1" <?php if($expenditure_type==1){ echo 'selected="selected"';}?>>पुँजीगत खर्च </option>
                                                               <option value="2" <?php if($expenditure_type==2){ echo 'selected="selected"';}?>>चालु खर्च </option>
                                                       </select></div>
                       <div class="titleInput">किसिम छान्नुहोस् :</div>
                       <div class="newInput"><select name="type" required>
                                                               <option value="">--छान्नुहोस्--</option>
                                                               <option value="0">योजना</option>
                                                               <option value="1">कार्यक्रम</option>
                                                       </select></div>
                       <div class="titleInput"> योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम: </div>
                       <div class="newInput"><select name="topic_area_id" id="topic_area_id" >
                                                  <option value="">--छान्नुहोस्--</option>
                                                           <?php foreach($topic_area as $topic): ?> 
                                                  <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                       <?php endforeach; ?>
                                                   </select></div>
                   </div><!-- input wrap 33 ends -->
                    <div class="inputWrap33 inputWrapLeft">

                       <div id="topic_area_type_id"></div>
                       <div id="topic_area_type_sub_id"></div>
                       <div class="titleInput">योजना / कार्यक्रमको अनुदानको किसिम:  </div>
                       <div class="newInput"><select name="topic_area_agreement_id" >
                                                  <option value="">--छान्नुहोस्--</option>
                                                           <?php foreach($topic_area_agreement as $topic): ?> 
                                                  <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                       <?php endforeach; ?>
                                                   </select></div>


                       <div class="titleInput">योजना / कार्यक्रमको विनियोजन किसिम:</div>
                        <div class="newInput"><select name="topic_area_investment_id" >
                                                  <option value="">--छान्नुहोस्--</option>
                                                           <?php foreach($topic_area_investment as $topic): ?> 
                                                  <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                       <?php endforeach; ?>
                                                   </select></div>
                         <div class="titleInput" style="color:red;"> रु हजारमा  भए टिक लगाउनुहोस  :  <input type="checkbox" name="check_th" value="1" /> </div>
                        
                      <div class="titleInput">Upload File</div>
                      <div class="newInput"><input type="file" name="excel_file" required/></div>
                                     
                   </div><!-- input wrap 33 ends -->
            </div> <div class="myspacer"></div>
                      <div class="saveBtn myCenter"><input type="submit" name="upload_excel" value="Upload" class="btn"></div>
                   
 <span><a href="sample/sampletest.xlsx" type="download" class="btn">Download Sample</a></span>
                                        	
                                           
                                      

 </form>


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
	
    
    
    
    
    
    
    
    
    
    
    