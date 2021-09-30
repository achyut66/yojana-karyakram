<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
error_reporting(1);
// get_access_to_fourth_form($_GET['id']);
$data1 = Plandetails1::find_by_id($_GET['id']); 
if(isset($_POST['submit']))
{
    
     if($_POST['update']==1)
        {
          $data3 = Quotationmoredetails::find_by_plan_id($_POST['plan_id']);
        }
     else
     {
        $data3 = new Quotationmoredetails();
      
     }
   //योजना सम्बन्धी अन्य विवरण
//   print_r($_POST);exit;
       $data3->plan_id = $_POST['plan_id'];
       $data3->yojana_start_date =$_POST['yojana_start_date'];
       $data3->yojana_end_date=  $_POST['yojana_end_date'] ;
       $data3->yojana_place = $_POST['yojana_place'];
       $data3->samjhauta_party = $_POST['samjhauta_party'];
       $data3->post_id_3 = $_POST['post_id_3'];
       $data3->miti = DateNepToEng($_POST['miti']);
       $data3->save();
       
       //योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण
       

    echo alertBox("थप सफल ","quotation_more_details.php");
}
if(isset($_GET['id'])){
$more_plan_details = Quotationmoredetails::find_by_plan_id($_GET['id']);
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
        <h2 class="headinguserprofile">योजना सम्बन्धी अन्य विवरण  | <a href="quotationDashboard.php" class="btn">पछि जानुहोस </a></h2>
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
                      <?php $data=  Quotationtotalinvestment::find_by_plan_id($data->id);?>
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
                                    <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान : <span class="underline"> <?php echo convertedcit($data->gaupalika_anudan);?></span></div>
                                </div><!-- input wrap 33 ends -->

                                <div class="inputWrap33 inputWrapLeft">
                                   <div class="titleInput"> कन्टेन्जेन्सी रकम : <span class="underline"><?php echo convertedcit($data->contigency_amount);?></span></div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा : <span class="underline"><?php echo convertedcit($data->kul_lagat_anudan);?></span></div>
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
                       		<?php if(empty($more_plan_details)){?>
                       		<div class="inputWrap50 inputWrapLeft">
                                <div class="titleInput">योजना संचालन हुने स्थान</div>
                            <div class="newInput"><input type="text" name="yojana_place" /></div>
                                <div class="titleInput"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम:</div>
                                <div class="newInput"><select name="samjhauta_party" required id="authority_name" >
                                        <option value="">छान्नुस</option>
                                        <?php foreach($postnames as $name): ?>
                                            <option value="<?=$name->id?>"><?=$name->authority_name?></option>
                                        <?php endforeach;?>
                                    </select></div>
                                <div class="titleInput">पद:</div>
                                <div class="newInput"><input id="authority_post" type="text" name="post_id_3"  required /></div>
                                <div class="titleInput">मिती: </div>
                                <div class="newInput "><input type="text" name="miti"  required  id="nepaliDate15" placeholder="yyyy-mm-dd" value="<?php echo DateEngToNep(date('Y-m-d',time()));?>" class="datewidth"/></div>


                            </div><!-- input wrap 50 ends -->
                            <div class="inputWrap50 inputWrapLeft">
                           <div class="titleInput">योजना शुरु हुने मिति:</div>
                                <div class="newInput"><input type="text" name="yojana_start_date" id="nepaliDate3" /></div>
                          
                                <div class="titleInput">योजना सम्पन्न हुने मिति:</div>
                            <div class="newInput"><input type="text" name="yojana_end_date" id="nepaliDate5" /></div>



                                </div><!-- input wrap 50 ends -->
                       		<div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                       <?php }else{ ?>
                       <div class="inputWrap100">
                       		<div class="inputWrap50 inputWrapLeft">
                            <div class="titleInput">योजना संचालन हुने स्थान</div>
                            <div class="newInput"><input type="text" name="yojana_place"  value="<?=$more_plan_details->yojana_place?>"/></div>

                                <div class="titleInput"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम:</div>
                                <div class="newInput"><select name="samjhauta_party" required id="authority_name" >
                                        <option value="">छान्नुस</option>
                                        <?php foreach($postnames as $name): ?>
                                            <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party == $name->id){ echo "selected='selected'";  } ?>><?=$name->authority_name?></option>
                                        <?php endforeach;?>
                                    </select></div>
                                <div class="titleInput">पद:</div>
                                <div class="newInput"><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $more_plan_details->post_id_3;?>"/></div>
                                <div class="titleInput">मिती: </div>
                                <div class="newInput "><input type="text" name="miti"  required  id="nepaliDate15" placeholder="yyyy-mm-dd" value="<?php echo DateEngToNep($more_plan_details->miti);?>" class="datewidth"/></div>

                              </div><!-- input wrap 50 ends -->
                            <div class="inputWrap50 inputWrapLeft">
                           <div class="titleInput">योजना शुरु हुने मिति:</div>
                                <div class="newInput"><input type="text" name="yojana_start_date" id="nepaliDate3" value="<?=$more_plan_details->yojana_start_date?>"/></div>
                          
                                <div class="titleInput">योजना सम्पन्न हुने मिति:</div>
                            <div class="newInput"><input type="text" name="yojana_end_date" id="nepaliDate5" value="<?=$more_plan_details->yojana_end_date?>"/></div>

                                
                            <div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                                  
                                    
                              <?php }?>
                                <div class="myspacer"></div>


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
