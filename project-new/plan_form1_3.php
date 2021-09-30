<?php require_once("includes/initialize.php");
error_reporting(0);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
 get_access_to_fourth_form($_GET['id']);
$data1 = Plandetails1::find_by_id($_GET['id']); 
  $group_heading = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
  if(!empty($group_heading->created_date))
  {
     $u_created_date = DateEngToNep($group_heading->created_date);
  }
  else
  {
     $u_created_date = " ";
  }
  
if(isset($_POST['submit']))
{
    if($_POST['update']==1 && !empty($_POST['profit_family_id']))
        {
            
            $data3 = Moreplandetails::find_by_plan_id($_POST['plan_id']);
            
            $delete_family= Profitablefamilydetails::find_by_plan_id($_POST['plan_id']);
        //   print_r($delete_family);
        //   exit;
            $delete_family->delete_by_plan_id();
        }
     else
     {
         
         $data3 = new Moreplandetails();
        // 
     }
   
   //योजना सम्बन्धी अन्य विवरण
  //print_r($_POST['update']);exit;
       $data3->plan_id = $_POST['plan_id'];
       $data3->samiti_gathan_date =$_POST['samiti_gathan_date'];
       $data3->samiti_gathan_date_english=  DateNepToEng($_POST['samiti_gathan_date']) ;      
       $data3->costumer_total_population = $_POST['costumer_total_population'];
       $data3->yojana_start_date = $_POST['yojana_start_date'];
       $data3->yojana_start_date_english=  DateNepToEng($_POST['yojana_start_date']);
       $data3->yojana_sakine_date = $_POST['yojana_sakine_date'];
       $data3->yojana_sakine_date_english = DateNepToEng($_POST['yojana_sakine_date']);
       $data3->samjhauta_party = $_POST['samjhauta_party'];
       $data3->post_id_3 = $_POST['post_id_3'];
       $data3->created_date=date("Y-m-d",time());
       $data3->miti=$_POST['miti'];
       $data3->miti_english=DateNepToEng($_POST['miti']);
       $data3->save();
       
       //print_r($data3);
       
            $delete_details=new Profitablefamilydetails();
        //   print_r($_POST);
        //   exit;
            $delete_details->dalit_ghar=$_POST['dalit_ghar'];
            $delete_details->dalit_mahila=$_POST['dalit_mahila'];
            $delete_details->dalit_purush=$_POST['dalit_purush'];
            $delete_details->aadhibasi_ghar=$_POST['aadhibasi_ghar'];
            $delete_details->aadhibasi_mahila=$_POST['aadhibasi_mahila'];
            $delete_details->aadhibasi_purush=$_POST['aadhibasi_purush'];
            $delete_details->anya_ghar=$_POST['anya_ghar'];
            $delete_details->anya_mahila=$_POST['anya_mahila'];
            $delete_details->anya_purush=$_POST['anya_purush'];
            $delete_details->total=$_POST['total'];
            $delete_details->total1=$_POST['total1'];
            $delete_details->total2=$_POST['total2'];
            $delete_details->total6=$_POST['kul4'];
            $delete_details->plan_id=$_POST['plan_id'];
            $delete_details->kul1=$_POST['kul1'];
            $delete_details->kul2=$_POST['kul2'];
            $delete_details->kul3=$_POST['kul3'];
            // echo '<pre>';
            //  print_r($delete_details);
            // exit;
            $delete_details->save();
            // print_r($delete_details);  
            // exit;
            
       
    echo alertBox("थप सफल ","letters_select.php");
}
if(isset($_GET['id'])){
$more_plan_details = Moreplandetails::find_by_plan_id($_GET['id']);
//print_r($more_plan_details); 
$profitable_family= Profitablefamilydetails::find_by_plan_id($_GET['id']);
// print_r($profitable_family);
// exit;

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
        <h2 class="headinguserprofile">योजना सम्बन्धी अन्य विवरण  | <a href="upabhoktasamitidashboard.php" class="btn">पछि जानुहोस </a></h2>
            <h2 class="headinguserprofile"><?=$data1->program_name ?> | दर्ता न :<?=convertedcit($_GET['id'])?>
                (<?php echo $data1->parishad_sno;?>)
            </h2>
           
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
                      <?php $data=Plantotalinvestment::find_by_plan_id($data->id);?>
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
                                    <div class="titleInput">उपभोक्ताबाट नगद साझेदारी : <span class="underline"><?php echo convertedcit($data->costumer_agreement);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">अन्य साझेदारी : <span class="underline"><?php echo convertedcit($data->other_agreement);?></span></div>
                                    <div class="titleInput">उपभोक्ताबाट जनश्रमदान : <span class="underline"><?php echo convertedcit($data->costumer_investment);?></span></div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा : <span class="underline"><?php echo convertedcit($data->total_investment);?></span></div>
                                </div><!-- input wrap 33 ends -->
                          		<div class="myspacer"></div>
                          </div><!-- input wrap 100 ends -->
                               <?php } ?>
                        </div>
                     <div>
                         <h3 class="myheader">उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                     
                        
                        
                            <?php 
                               $data = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                               $group_details = Costumerassociationdetails::find_by_plan_id($_GET['id']);
                            ?>
                            <div class="mycontent" style="display: none;">
                            	<div class="inputWrap100">
                                	<div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">योजनाको संचालन गर्ने उपभोक्ता समितिको नाम: <br>
                                			<span class="underline"><?=$data->program_organizer_group_name?></span>
                                        </div>
                                    </div><!-- input wrap 50 ends -->
                                    <div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना:<br>
                              				<span class="underline"> <?php echo SITE_NAME.$data->program_organizer_group_address;?></span>
                                        </div>
                                    </div><!-- input wrap 50 ends -->
                                	<div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                           <table class="detail_post table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>वडा नं </strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="myCenter"><strong>मोबाइल  नं</strong></td>
                                </tr>
                                <?php $i= 1; foreach($group_details as $group_detail):
                                
                                        $post = Postname::find_by_id($group_detail->post_id);
                                        if($group_detail->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($group_detail->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                                ?>
                                <tr>
                                    <td><?=convertedcit($i)?></td>
                                    <td><?=$post->name?></td>
                                    <td><?=$group_detail->name?></td>
                                    <td><?=SITE_NAME.convertedcit($group_detail->address)?></td>
                                    <td><?=$gender?></td>
                                    <td><?=convertedcit($group_detail->cit_no)?></td>
                                    <td><?=$group_detail->issued_district?></td>
                                    <td><?=convertedcit($group_detail->mobile_no)?></td>
                                </tr>
                            <?php $i++; endforeach; ?>
                            </table>
                        </div>
                    <?php $datas = investigationassociationdetails::find_by_plan_id($_GET['id']);
                            //print_r($datas);
                    ?>
                      <h3 class="myheader">अनुगमन समिति सम्बन्धी विवरण </h3>
                          <div class="mycontent" style="display: none;">
                            <table class="detail_posts table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>वडा नं </strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>मोबाइल  नं</strong></td>
                                    
                                </tr>
                            <?php $i=1; foreach($datas as $data): 
                                  //$post = Postname::find_by_id($group_detail->post_id);
                                  
                                        if($group_detail->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($group_detail->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                            ?>
                                  <tr>
                                  <td><?=convertedcit($i)?></td>
                                  <td><?=Postname::getName($data->post_id);?></td>
                                  <td><?=$data->name?></td>
                                  <td><?=SITE_NAME.convertedcit($data->address)?></td>
                                  <td><?=$gender?></td>
                                  <td><?=convertedcit($data->mobile_no)?></td>
                                  </tr>
                            <?php $i++; endforeach; ?>
                            </table>
                          </div>
                     <div>
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
                            	<div class="titleInput">उपभोक्ता समिति गठन भएको मिति:</div>
                                <div class="newInput"><input class="inspectionDate" type="text" name="samiti_gathan_date" value="<?= $u_created_date ?>" id="nepaliDate9" placeholder="yyyy-mm-dd"/></div>
                                <div class="titleInput">उपभोक्ता भेलामा उपस्थिति संख्या:</div>
                                <div class="newInput"><input type="text" name="costumer_total_population" /></div>
                                <div class="titleInput">योजना शुरु हुने मिति:</div>
                                <div class="newInput"><input class"inspectionDate" type="text" name="yojana_start_date" id="nepaliDate3" placeholder="yyyy-mm-dd" /></div>
                            </div><!-- input wrap 50 ends -->
                            <div class="inputWrap50 inputWrapLeft">
                            	<div class="titleInput">योजना सम्पन्न हुने मिति:</div>
                                <div class="newInput"><input class"inspectionDate" type="text" name="yojana_sakine_date" id="nepaliDate5" placeholder="yyyy-mm-dd"/></div>
                                <div class="titleInput"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम:</div>
                                <div class="newInput"><select name="samjhauta_party" required id="authority_name" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party==$name->id){?> selected="selected" <?php } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select></div>
                                <div class="titleInput">पद</div>
                                <div class="newInput"><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $more_plan_details->post_id_3;?>" /></div>
                                <div class="titleInput">सम्झौता मिती</div>
                                <div class="newInput"><input class"inspectionDate" type="text" name="miti" id="nepaliDate15" class="datewidth" placeholder="yyyy-mm-dd"/></div>
                            </div><!-- input wrap 50 ends -->
                       		<div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                       <?php }else{ ?>
                       <div class="inputWrap100">
                       		<div class="inputWrap50 inputWrapLeft">
                            	<div class="titleInput">उपभोक्ता समिति गठन भएको मिति:</div>
                                <div class="newInput"><input class"inspectionDate" type="text" name="samiti_gathan_date" required id="nepaliDate9" placeholder="yyyy-mm-dd" value="<?php echo $more_plan_details->samiti_gathan_date;?>" class="datewidth"/></div>
                                <div class="titleInput">उपभोक्ता भेलामा उपस्थिति संख्या:</div>
                                <div class="newInput"><input type="text" name="costumer_total_population" required value="<?php echo $more_plan_details->costumer_total_population;?>"/></div>
                                <div class="titleInput">योजना शुरु हुने मिति:</div>
                                <div class="newInput"><input class"inspectionDate" type="text" name="yojana_start_date" required id="nepaliDate3"  placeholder="yyyy-mm-dd" value="<?php echo $more_plan_details->yojana_start_date;?>" class="datewidth"/></div>
                            </div><!-- input wrap 50 ends  -->
                            <div class="inputWrap50 inputWrapLeft">
                            	<div class="titleInput">योजना सम्पन्न हुने मिति:</div>
                                <div class="newInput"><input type="text" name="yojana_sakine_date" required id="nepaliDate5" placeholder="yyyy-mm-dd" value="<?php echo $more_plan_details->yojana_sakine_date;?>" class="datewidth"/></div>
                                <div class="titleInput"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम:</div>
                                <div class="newInput"><select name="samjhauta_party" required id="authority_name" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                           <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party == $name->id){ echo "selected='selected'";  } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select></div>
                                <div class="titleInput">पद:</div>
                                <div class="newInput"><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $more_plan_details->post_id_3;?>"/></div>
                                <div class="titleInput"> सम्झौता मिती:  </div>
                                <div class="newInput "><input class"inspectionDate" type="text" name="miti"  required  id="nepaliDate15" placeholder="yyyy-mm-dd" value="<?php echo $more_plan_details->miti;?>" class="datewidth"/></div>
                            </div><!-- input wrap 50 ends  -->
                            <div class="myspacer"></div>
                       </div><!-- input wrap 100 ends -->
                                  
                                    
                              <?php }?>
                         <h3>योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                           <table class="table table-bordered table-hover table-responsive">
                       <tr>
                        <td colspan="11" class="myCenter">लाभान्वित जनसंख्या</td>
                      </tr>
                      <tr>
                        <label><td class="myCenter" colspan="2">घर परिवार संख्या</td></label>
                        <td class="myCenter" width="25%">महिला</td>
                        <label><td class="myCenter">पुरुष</td></label>
                        <label><td class="myCenter">जम्मा</td></label>
                      </tr>
                      <tr>
                        <td>दलित</td>
                        <input type ="hidden" value="<?php echo $profitable_family->id?>" name="profit_family_id">
                        <td><input type="text" class="row2" name="dalit_ghar" value="<?php echo $profitable_family->dalit_ghar;?>"/></td>
                        <td width="25%"><input type="text" class="female"  name="dalit_mahila" value="<?php echo $profitable_family->dalit_mahila;?>"/></td>
                        <td><input type="text" class="male"   name="dalit_purush" value="<?php echo $profitable_family->dalit_purush;?>"/></td>
                        <td><input type="text" id="dalit" name="total" value="<?php echo $profitable_family->total;?>" readonly="true" /></td>
                      </tr>
                      <tr>
                        <td>आदीबासी जनजाती</td>
                        <td><input type="text" class="row3" name="aadhibasi_ghar" value="<?php echo $profitable_family->aadhibasi_ghar;?>"/></td>
                        <td width="25%"><input type="text" class="female1"  name="aadhibasi_mahila" value="<?php echo $profitable_family->aadhibasi_mahila;?>"/></td>
                        <td><input type="text" class="male1"  name="aadhibasi_purush" value="<?php echo $profitable_family->aadhibasi_purush;?>"/></td>
                        <td><input type="text" id="janajati"  name="total1" value="<?php echo $profitable_family->total1;?>" readonly="true"/></td>
                      </tr>
                      <tr>
                        <td>अन्य घर परिबार</td>
                        <td><input type="text" class="row4" name="anya_ghar" value="<?php echo $profitable_family->anya_ghar;?>"/></td>
                        <td width="25%"><input type="text" class="female2"  name="anya_mahila" value="<?php echo $profitable_family->anya_mahila;?>"/></td>
                        <td><input type="text" class="male2"  name="anya_purush" value="<?php echo $profitable_family->anya_purush;?>"/></td>
                        <td><input type="text" id="anya_ghar"  name="total2" value="<?php echo $profitable_family->total2;?>" readonly="true"/></td>
                      </tr>
                      <tr>
                        <td>कुल जम्मा </td>
                        <td><input type="text" name="kul1" class="tot1" value="<?php echo $profitable_family->kul1;?> " readonly="true"></td>
                        <td><input type="text" name="kul2" class="tot2" value="<?php echo $profitable_family->kul2;?>" readonly="true"></td>
                        <td><input type="text" name="kul3" class="tot3" value="<?php echo $profitable_family->kul3;?>" readonly="true"></td>
                        <td><input type="text" name="kul4" class="tot4" value="<?php echo $profitable_family->total6;?>" readonly="true"></td>
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
    <script type="text/javascript">
      JQ(document).on("input",".row2, .row3, .row4",function() {
         var tt1 = JQ(".row2").val()  || 0;;
         var tt2 = JQ(".row3").val()  || 0;;
         var tt3 = JQ(".row4").val()  || 0;;
         var total = parseInt(tt1) + parseInt(tt2) + parseInt(tt3);
         JQ(".tot1").val(total);
       });
      JQ(document).on("input",".female, .female1, .female2",function(){
        var ttt1 = JQ(".female").val() || 0;; 
        var ttt2 = JQ(".female1").val() || 0;; 
        var ttt3 = JQ(".female2").val() || 0;;
        var total1 = parseInt(ttt1) + parseInt(ttt2) + parseInt(ttt3);
        JQ(".tot2").val(total1); 
      });
      JQ(document).on("input",".male, .male1, .male2",function(){
        var ttt1 = JQ(".male").val() || 0;; 
        var ttt2 = JQ(".male1").val() || 0;; 
        var ttt3 = JQ(".male2").val() || 0;;
        var total2 = parseInt(ttt1) + parseInt(ttt2) + parseInt(ttt3);
        JQ(".tot3").val(total2); 
      });
      JQ(document).on("input",".female, .male",function(){
        var ttt2 = JQ(".female").val() || 0;; 
        var ttt3 = JQ(".male").val() || 0;;
        var total3 = parseInt(ttt2) + parseInt(ttt3);
        JQ("#dalit").val(total3); 
      });
      JQ(document).on("input",".female1, .male1",function(){
        var ttt2 = JQ(".female1").val() || 0;; 
        var ttt3 = JQ(".male1").val() || 0;;
        var total4 = parseInt(ttt2) + parseInt(ttt3);
        JQ("#janajati").val(total4); 
      });
      JQ(document).on("input",".female2, .male2",function(){
      var ttt2 = JQ(".female").val() || 0;; 
        var ttt3 = JQ(".male").val() || 0;;
        var total3 = parseInt(ttt2) + parseInt(ttt3);
        JQ("#dalit").val(total3); 

        var ttt2 = JQ(".female1").val() || 0;; 
        var ttt3 = JQ(".male1").val() || 0;;
        var total4 = parseInt(ttt2) + parseInt(ttt3);
        JQ("#janajati").val(total4);

        var ttt2 = JQ(".female2").val() || 0;; 
        var ttt3 = JQ(".male2").val() || 0;;
        var total5 = parseInt(ttt2) + parseInt(ttt3);
        JQ("#anya_ghar").val(total5); 
        var total_population = total3 + total4 + total5;
        JQ(".tot4").val(total_population); 
      });

    </script>