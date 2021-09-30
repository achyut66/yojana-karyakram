<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
// get_access_to_fourth_form($_GET['id']);
$data1 = Plandetails1::find_by_id($_GET['id']); 
if(isset($_POST['submit']))
{
    
     if($_POST['update']==1)
        {
          $data3 = Amanat_more_details::find_by_plan_id($_POST['plan_id']); 
        }
     else
     {
        $data3 = new Amanat_more_details();
      
     }
   //योजना सम्बन्धी अन्य विवरण
//   print_r($_POST);exit;
       $data3->plan_id = $_POST['plan_id'];
       $data3->organizer_name =$_POST['organizer_name'];
       $data3->chalani_no = $_POST['chalani_no'];
       $data3->place_to_organize=  $_POST['place_to_organize'] ;      
       $data3->pariwar_population = $_POST['pariwar_population'];
       $data3->male = $_POST['male'];
       $data3->female = $_POST['female'];
       $data3->aadesh_per_post = $_POST['aadesh_per_post'];
       $data3->organizer_name_address = $_POST['organizer_name_address'];
       $data3->organizer_name_post = $_POST['organizer_name_post'];
       $data3->total = $_POST['total'];
       $data3->yojana_start_date = $_POST['yojana_start_date'];
       $data3->yojana_samjhauta_date = $_POST['yojana_samjhauta_date'];
       $data3->yojana_start_date_english=  DateNepToEng($_POST['yojana_start_date']);
       $data3->yojana_sakine_date = $_POST['yojana_sakine_date'];
       $data3->yojana_sakine_date_english = DateNepToEng($_POST['yojana_sakine_date']);
       $data3->save();
       
       //योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण
       

    echo alertBox("थप सफल ","amanat_more_details.php");
}
if(isset($_GET['id'])){
$more_plan_details = Amanat_more_details::find_by_plan_id($_GET['id']);
 $value="सेभ गर्नुहोस";
 $update = 0; 
if(!empty($more_plan_details))
  {
    $value="अपडेट गर्नुहोस"; 
    $update = 1;
  } 
}

$postnames=  Workerdetails::find_by_sql("select * from worker_details where status=1");
//print_r($postnames);exit;

?>

<?php include("menuincludes/header.php"); ?>
<title><?=$data1->program_name ?> :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

    <div class="">
        <div class="maincontent">
        <h2 class="headinguserprofile">योजना सम्बन्धी अन्य विवरण  | <a href="amanatdashboard.php" class="btn">पछि जानुहोस </a></h2>
            <h2 class="headinguserprofile"><?=$data1->program_name ?> | दर्ता न :<?=convertedcit($_GET['id'])?></h2>
           
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                    ?>
                    <h3 class="myheader">योजनाको विवरण</h3>
                    <div class="mycontent" style="display: none;" >
                    	<div class="inputWrap100">
                        	<div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">आर्थिक वर्ष : <span class="underline"><?php echo convertedcit($fiscal->year); ?></span></div>
                                <div class="titleInput">दर्ता नं <span class="underline"><?php echo convertedcit($data->id);?></span></div>
                                <div class="titleInput">योजनाको बिषयगत क्षेत्रको नाम: <span class="underline"><?php echo Topicarea::getName($data->topic_area_id); ?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको  शिर्षकगत नाम :<span class="underline"><?php echo Topicareatype::getName($data->topic_area_type_id); ?></span></div>
                                <div class="titleInput">योजनाको  उपशिर्षकगत नाम :<span class="underline"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></span></div>
                                <div class="titleInput">योजनाको अनुदानको किसिम :<span class="underline"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको विनियोजन किसिम :<span class="underline"><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">योजनाको नाम : <span class="underline"><?php echo $data->program_name;?></span></div>
                                <div class="titleInput">आयोजना सचालन हुने स्थान : <span class="underline"><?php echo SITE_LOCATION;?>-<?php echo convertedcit($data->ward_no); ?></span></div>
                                <div class="titleInput">अनुदान रु : <span class="underline"><?php echo convertedcit($data->investment_amount);?></span></div>
                            </div><!-- input wrap 33 ends -->
                        	<div class="myspacer"></div>
                        </div><!-- input wrap 100 ends -->
                     </div><!-- my content ends -->
                      <?php $data=  AmanatLagat::find_by_plan_id($data->id);?>
                        <h3  class="myheader"> योजनाको कुल लागत अनुमान </h3>
                        <div class="mycontent" style="display: none;">
                         <?php 
                            if(empty($data))
                            {
                                echo "योजनाको कुल लागत अनुमान विवरण भरिएको छैन ";
                            }
                               else{
                                $unit = Units::find_by_id($data->unit_id);?>
                          <div class="inputWrap100">
                          		<div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">भौतिक ईकाईको  परिणाम : <span class="underline"><?=convertedcit($data->unit_total)?> <?=$unit->name?></span></div>
                                    <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान : <span class="underline"> <?php echo convertedcit($data->agreement_gauplaika);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">अन्य निकायबाट प्राप्त अनुदान : <span class="underline"><?php echo convertedcit($data->agreement_other);?></span></div>
                                    <div class="titleInput"> नगद साझेदारी : <span class="underline"><?php echo convertedcit($data->costumer_agreement);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">अन्य साझेदारी : <span class="underline"><?php echo convertedcit($data->other_agreement);?></span></div>
                                    <div class="titleInput"> जनश्रमदान : <span class="underline"><?php echo convertedcit($data->costumer_investment);?></span></div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा : <span class="underline"><?php echo convertedcit($data->total_investment);?></span></div>
                                </div><!-- input wrap 33 ends -->
                          		<div class="myspacer"></div>
                          </div><!-- input wrap 100 ends -->
                               <?php } ?>
                        </div>
                    
                    <form method="post" enctype="multipart/form_data">
                       <h3>योजना सम्बन्धी अन्य विवरण</h3>
                       <div class="inputWrap100">
                       		<h1>योजनाको नाम: <span class="underline"><?php echo $data1->program_name; ?></span>
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/></h1>
                       		
                       		<div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                       
                       
                       <div class="inputWrap100">
                       		<div class="inputWrap50 inputWrapLeft">
                            	 <div class="titleInput">योजना संचालन गर्नेको नाम थर :</div>
                            <div class="newInput"><input type="text" name="organizer_name" value="<?=$more_plan_details->organizer_name?>"/></div>
                            <div class="titleInput">योजना संचालन गर्नेको पद :</div>
                            <div class="newInput"><input type="text" name="organizer_name_post" value="<?=$more_plan_details->organizer_name_post?>"/></div>
                            <div class="titleInput">योजना संचालन गर्नेको ठेगाना :</div>
                            <div class="newInput"><input type="text" name="organizer_name_address" value="<?=$more_plan_details->organizer_name_address?>"/></div>
                            <div class="titleInput">योजना  हुने स्थान</div>
                            <div class="newInput"><input type="text" name="place_to_organize"  value="<?=$more_plan_details->place_to_organize?>"/></div>
                            <div class="titleInput">चलानी नं</div>
                            <div class="newInput"><input type="text" name="chalani_no"  value="<?=$more_plan_details->chalani_no?>"/></div>
                            </div><!-- input wrap 50 ends -->
                            <div class="inputWrap50 inputWrapLeft">
                              <div class="titleInput">तोक आदेश दिने व्यक्तिको पद</div>
                            <div class="newInput">
                              <input type="text" name="aadesh_per_post"  
                              value="<?php
                              if(!empty($more_plan_details->aadesh_per_post)) {
                                echo $more_plan_details->aadesh_per_post;
                              }else{
                                echo "श्रीमान् नगर प्रमुखज्यू";
                              }?>"
                              placeholder="पद लेख्नुहोस !!!" />
                            </div>
                           <div class="titleInput">योजना शुरु हुने मिति:</div>
                                <div class="newInput"><input type="text" name="yojana_start_date" id="nepaliDate3" value="<?=$more_plan_details->yojana_start_date?>"/></div>
                          
                                <div class="titleInput">योजना सम्पन्न हुने मिति:</div>
                            <div class="newInput"><input type="text" name="yojana_sakine_date" id="nepaliDate5" value="<?=$more_plan_details->yojana_sakine_date?>"/></div>
                            <div class="titleInput">योजना सम्झौता मिति:</div>
                            <div class="newInput"><input type="text" name="yojana_samjhauta_date" id="nepaliDate6" value="<?=$more_plan_details->yojana_samjhauta_date?>"/></div>

                                
                            <div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                                  
                                    
                             
                                <div class="myspacer"></div>
                         <h3>योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                           <table class="table table-bordered table-hover">
                                <tr>
                                 
                                  <td colspan="5" class="myCenter">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                	
                                    <td class="myCenter">घर परिवार संख्या</td>
                                  <td class="myCenter">महिला</td>
                                  <td class="myCenter">पुरुष</td>
                                  <td class="myCenter">जम्मा</td>
                                </tr>
                                
                                 
                                  <tr>
                                 
                                  <td><div class="myWidth100"><input type="text" class="row1-family" name="pariwar_population" value="<?php echo $more_plan_details->pariwar_population;?>" /></div></td>
                                 <td ><div class="myWidth100"><input type="text" class="row2"  name="female" value="<?php echo $more_plan_details->female;?>"/></div></td>
                                  <td><div class="myWidth100"><input type="text" class="row2"   name="male" value="<?php echo $more_plan_details->male;?>"/></div></td>
                                  <td><div class="myWidth100"><input type="text" id="row2-value" class="myWidth100" name="total" value="<?php echo $more_plan_details->total;?>"/></div></td>
                                  </tr>
                            
                          </table>
                           <input type="hidden" name="update" value="<?=$update?>">
                           <div class="inputWrap">
                           		<div class="saveBtn myWidth100"><input type="submit" name="submit" value="<?=$value?>" class="btn"></div>
                           </div>
                           
                           
 </form>
              

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>