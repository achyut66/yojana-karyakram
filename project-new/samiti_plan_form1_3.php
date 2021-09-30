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
         //echo $_POST['update'];exit;
          $data3 = Samitimoreplandetails::find_by_plan_id($_POST['plan_id']); 
          $delete_details = Samitiprofitablefamilydetails::find_by_plan_id($_POST['plan_id']);
          $delete_details ->delete();
          
          
        }
     else
     {
        $data3 = new Samitimoreplandetails();
      
     }
   //योजना सम्बन्धी अन्य विवरण
//   print_r($_POST);exit;
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
       
       //योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण
        $data0=new Samitiprofitablefamilydetails();
       $data0->pariwar_population=$_POST['pariwar_population'];
        $data0->female=$_POST['female'];
        $data0->male=$_POST['male'];
        $data0->total=$_POST['total'];
        $data0->plan_id=$_POST['plan_id'];
          $data0->created_date=date("Y-m-d",time());
        $data0->save();
}
if(isset($_GET['id'])){
$more_plan_details = Samitimoreplandetails::find_by_plan_id($_GET['id']);

$profitable_family1= Samitiprofitablefamilydetails::find_by_type_id(0,$_GET['id']);

    $value="अपडेट गर्नुहोस"; 
    $update = 1;
if(empty($profitable_family1))
{
    $profitable_family1 = Samitiprofitablefamilydetails::setEmptyObjects(); 
    $value="सेभ गर्नुहोस";
    $update = 0; 
}
if(empty($more_plan_details))
{
    $more_plan_details = Samitimoreplandetails::setEmptyObjects();
    $value="सेभ गर्नुहोस";
    $update = 0; 
}
//redirec_to("samiti_letters_select.php");
}

$postnames=  Workerdetails::find_by_sql("select * from worker_details where status=1");
//print_r($postnames);exit;

?>

<?php include("menuincludes/header.php"); ?>
<title><?=$data1->program_name ?> :: <?php echo SITE_SUBHEADING;?></title>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना सम्बन्धी अन्य विवरण  | <a href="anyasamitidasboard.php" class="btn">पछी जानुहोस </a></h2>
            <h2 class="headinguserprofile"><?=$data1->program_name ?> | दर्ता न :<?=convertedcit($_GET['id'])?></h2>
            	
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                    ?>
                    <h3 class="myheader">योजनाको विवरण</h3>
                    <div class="mycontent" style="display: none;" >
                     <table class="table table-bordered table-responsive">
                                        
                                        <tr>
                                            <td>आर्थिक वर्ष</td>
                                            <td><?php echo convertedcit($fiscal->year); ?></td>
                                        </tr> <tr>
                                            <td>दर्ता नं</td>
                                            <td><?php echo convertedcit($data->id);?></td>
                                          </tr>
                                          <tr>
                                            <td>योजनाको नाम</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>
                                         <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></td>
                                          </tr>
                                          <tr>
                                            <td>आयोजना सचालन हुने स्थान</td>
                                            <td><b><?php echo SITE_LOCATION;?>-<?php echo convertedcit($data->ward_no); ?></b></td>
                                            
                                           </tr>
                                           <tr>
                                            <td> अनुदान रु</td>
                                            <td><?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                       </table>
                     </div>
                      <?php $data=  Samitiplantotalinvestment::find_by_plan_id($data->id);?>
                        <h3  class="myheader"> योजनाको कुल लागत अनुमान </h3>
                        <div class="mycontent" style="display: none;">
                         <?php 
                            if(empty($data))
                            {
                                echo "योजनाको कुल लागत अनुमान विवरण भरिएको छैन ";
                            }
                               else{
                                $unit = Units::find_by_id($data->unit_id);?>
                          <table class="table table-bordered table-responsive">
                            
                            
                             <tr>
                                <td> भौतिक ईकाईको  परिणाम</td>
                                <td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                              <tr>
                              <th width="176" scope="row"><?php echo SITE_TYPE;?>बाट अनुदान</th>
                              <td> <?php echo convertedcit($data->agreement_gauplaika);?></td>
                            </tr>
                            <tr>
                              <th scope="row">अन्य निकायबाट प्राप्त अनुदान</th>
                              <td><?php echo convertedcit($data->agreement_other);?></td>
                            </tr>
                            <tr>
                              <th scope="row">संस्था / समितिबाट नगद साझेदारी</th>
                              <td><?php echo convertedcit($data->costumer_agreement);?></td>
                            </tr>
                            <tr>
                              <th scope="row">अन्य साझेदारी</th>
                              <td><?php echo convertedcit($data->other_agreement);?></td>
                            </tr>
                            <tr>
                              <th scope="row">संस्था / समितिबाट जनश्रमदान</th>
                              <td><?php echo convertedcit($data->costumer_investment);?></td>
                            </tr>
                            <tr>
                              <th scope="row">कुल लागत अनुमान जम्मा </th>
                              <td><?php echo convertedcit($data->total_investment);?></td>
                            </tr>
                           
                          </table>
                               <?php } ?>
                        </div>
                     <div>
                         <h3 class="myheader">संस्था / समिति  सम्बन्धी विवरण </h3>
                     
                        
                        
                            <?php 
                               $data = Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                               $group_details = Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);
                            ?>
                            <div class="mycontent" style="display: none;">
                              <table class="table table-bordered">
                             <tr>
                                <td> योजनाको संचालन गर्ने संस्था / समितिको  नाम:</td>
                                <td><?=$data->program_organizer_group_name?></td>
                              <tr>
                              <td>ठेगाना:</td>
                              <td> <?php echo SITE_NAME.$data->program_organizer_group_address;?></td>
                            </tr>
                            
                          </table>
                          <table class="detail_post table table-bordered">
                                <tr>
                                    <th>सिनं</th>
                                    <th>पद</th>
                                    <th>नामथर</th>
                                    <th>वडा नं </th>
                                    <th>लिगं</th>
                                    <th>नागरिकता नं</th>
                                    <th>जारी जिल्ला</th>
                                    <th>मोवायल नं</th>
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
                    <?php $datas = Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);

                    ?>
                      <h3 class="myheader">अनुगमन समिति सम्बन्धी विवरण </h3>
                          <div class="mycontent" style="display: none;">
                            <table class="detail_posts table table-bordered">
                                <tr>
                                    <th>सिनं</th>
                                    <th>पद</th>
                                    <th>नामथर</th>
                                   <th>वडा नं </th>
                                    <th>लिगं</th>
                                    <th>मोवायल नं</th>
                                  
                                </tr>
                            <?php $i=1; foreach($datas as $data): 
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
                        <tr>
                            <td><b>योजनाको नाम:</b></td>
                                    <td><u><?php echo $data1->program_name; ?></u></td>
                                </tr>
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
               
                          <table class="table table-bordered">
                              <?php if(empty($more_plan_details)){?>
                                
                                  <tr>
                                    <td>योजना शुरु हुने मिति</td>
                                    <td><input type="text" name="yojana_start_date" id="nepaliDate3" /></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्पन्न हुने मिति</td>
                                    <td><input type="text" name="yojana_sakine_date" id="nepaliDate5" /></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                     <td>
                                         <select name="samjhauta_party" required id="authority_name" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party==$name->id){?> selected="selected" <?php } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $more_plan_details->post_id_3;?>"/></td>
                                  </tr>
                                  
                                  <tr>
                                    <td>योजना सम्झौता मिती</td>
                                    <td><input type="text" name="miti" id="nepaliDate15" /></td>
                                  </tr>
                              <?php }else{ ?>
                                 
                                  <tr>
                                    <td>योजना शुरु हुने मिति</td>
                                    <td><input type="text" name="yojana_start_date" required id="nepaliDate3" value="<?php echo $more_plan_details->yojana_start_date;?>"/></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्पन्न हुने मिति</td>
                                    <td><input type="text" name="yojana_sakine_date" required id="nepaliDate5" value="<?php echo $more_plan_details->yojana_sakine_date;?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                     <td>
                                         <select name="samjhauta_party" required id="authority_name" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                           <option value="<?=$name->id?>" <?php if($more_plan_details->samjhauta_party == $name->id){ echo "selected='selected'";  } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $more_plan_details->post_id_3;?>"/></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्झौता मिती</td>
                                    <td><input type="text" name="miti"  required  id="nepaliDate15" value="<?php echo $more_plan_details->miti;?>"/></td>
                                  </tr>
                              <?php }?>
                          </table></br></br>
                        <h3>योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                           <table class="table table-bordered table-responsive">
                                <tr>
                                 
                                  <td colspan="5" style="text-align:center">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                	
                                    <td>घर परिवार संख्या</td>
                                  <td>महिला</td>
                                  <td >पुरुष</td>
                                  <td >जम्मा</td>
                                </tr>
                                
                                 
                                  <tr>
                                 
                                  <td><input type="text" class="row1-family input100percent" name="pariwar_population" value="<?php echo $profitable_family1->pariwar_population;?>"/></td>
                                 <td ><input type="text" class="row2"  name="female" value="<?php echo $profitable_family1->female;?>"/></td>
                                  <td><input type="text" class="row2"    name="male" value="<?php echo $profitable_family1->male;?>"/></td>
                                  <td><input type="text" id="row2-value" class="input100percent" name="total" value="<?php echo $profitable_family1->total;?>"/></td>
                                  </tr>
                             
                          </table></br></br>
                           <input type="hidden" name="update" value="<?=$update?>">
                           <input type="submit" name="submit" value="<?=$value?>" class="submithere">
                           
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