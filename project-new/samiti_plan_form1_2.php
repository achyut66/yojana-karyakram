<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//get_access_to_third_form($_GET['id']);
$plan_selected = Plandetails1::find_by_id($_GET['id']);
if(isset($_POST['submit']))
{
    //अनुगमन समिति सम्बन्धी विवरण
  
    if($_POST['update']==1)
     {
        $delete_details = Samitiinvestigationassociationdetails::find_by_plan_id($_POST['plan_id']);
        foreach ($delete_details as $delete_detail) {
            $delete_detail->delete();
        }
     }   
    for($i=0;$i<count($_POST['post_id_1']);$i++)
    {
       $data2 =new Samitiinvestigationassociationdetails();
       $data2->plan_id = $_POST['plan_id'];
       $data2->post_id =$_POST['post_id_1'][$i];
       $data2->name = $_POST['name_1'][$i];
       $data2->address = $_POST['address_1'][$i];
       $data2->gender = $_POST['gender_1'][$i];
       $data2->mobile_no = $_POST['mobile_no_1'][$i];
       $data2->created_date=date("Y-m-d",time());
       $data2->save();
    }
    redirect_to("samiti_plan_form1_3.php");
}
if(isset($_POST['search'])){
 if(empty($_POST['sn'])) {  
    $sql="select * from plan_details1 where program_name LIKE '%".$_POST['program']."%'";
 }
 else
 {
     $sql="select * from plan_details1 where id='".$_POST['sn']."'";
    
 }
 $results= Plandetails1::find_by_sql($sql);

//print_r($result);exit;
}
$post="select * from postname where type=1";
$postnames=  Postname::find_by_sql($post);
$group_heading = Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
?>
<?php include("menuincludes/header.php"); ?>
<title><?=$plan_selected->program_name?> :: <?php echo SITE_SUBHEADING;?></title>
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
    <div class="">
        <div class="maincontent">
         <h2 class="headinguserprofile">अनुगमन समिति सम्बन्धी विवरण  | <a href="anyasamitidasboard.php" class="btn">पछी जानुहोस </a></h2>
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | दर्ता न :<?=convertedcit($_GET['id'])?></h2>
                <?php echo $message;?>
                    <div class="OurContentFull">
                        <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                        <div class="userprofiletable">
                              <?php if(!isset($_GET['id'])){?>
                                  <form  method="post">
                                  	<table class="table table-bordered table-responsive">
                                    	<tr>
                                        	<td>योजनाको नाम: </td>
                                            <td> <input type="text" name="program"/></td>
                                        </tr>
                                        <tr>
                                        	<td>दर्ता फाराम नं:</td>
                                            <td><input type="text" name="sn"/></td>
                                        </tr>
                                        <tr>
                                        	<td>&nbsp;</td>
                                            <td> <input type="submit" name="search" value="SEARCH"/></td>
                                        </tr>
                                     </table>
                                </form>
            <?php if(isset($_POST['search'])):?>
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th>दर्ता फाराम नं :</th>
                            <th>योजनाको नाम :</th>
                        </tr>
                        <?php  foreach($results as $result):?>
                        <tr>
                            <td><?php echo $result->sn;?></td>
                            <td><a href="plan_form1_2.php?id=<?php echo $result->id;?>"><?php echo $result->program_name;?></a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <?php endif;?>
               <?php } else {?>
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                    ?>
                    <h3 class="myheader"> योजनाको विवरण</h3>
                    <div class="mycontent"  style="display:none;">
                     <table class="table table-bordered" >
                                        
                                        <tr>
                                            <td class="myWidth50">आर्थिक वर्ष :</td>
                                            <td><?php echo convertedcit($fiscal->year); ?></td>
                                        </tr> <tr>
                                            <td>दर्ता नं :</td>
                                            <td><?php echo convertedcit($data->id);?></td>
                                          </tr>
                                           <tr>
                                            <td>योजनाको नाम :</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>
                                         <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम :</td>
                                                <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम :</td>
                                               <td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम :</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम :</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम :</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></td>
                                          </tr>
                                          <tr>
                                            <td>योजना सचालन हुने स्थान :</td>
                                            <td> <?php echo SITE_NAME.convertedcit($data->ward_no); ?></td>
                                            
                                           </tr>
                                           <tr>
                                            <td>अनुदान रकम :</td>
                                            <td>रु. <?php echo convertedcit($data->investment_amount);?></td>
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
                                <th class="myWidth50">भौतिक ईकाईको  परिणाम :</th>
                                <td>रु. <?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                              <tr>
                              <th ><?php echo SITE_TYPE;?>बाट अनुदान :</th>
                              <td>रु. <?php echo convertedcit($data->agreement_gauplaika);?></td>
                            </tr>
                            <tr>
                              <th >अन्य निकायबाट प्राप्त अनुदान :</th>
                              <td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                            </tr>
                            <tr>
                              <th >संस्था / समिति नगद साझेदारी :</th>
                              <td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                            </tr>
                            <tr>
                              <th >अन्य साझेदारी :</th>
                              <td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                            </tr>
                            <tr>
                              <th >संस्था / समितिबाट जनश्रमदान :</th>
                              <td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                            </tr>
                            <tr>
                              <th >कुल लागत अनुमान जम्मा :</th>
                              <td>रु. <?php echo convertedcit($data->total_investment);?></td>
                            </tr>
                           
                          </table>
                               <?php } ?>
                        </div>
                     <div>
                         <h3 class="myheader">संस्था / समिति सम्बन्धी विवरण </h3>
                     
                        
                        
                            <?php 
                               $data = Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                               $group_details = Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);
                            ?>
                            <div class="mycontent" style="display: none;">
                              <table class="table table-bordered table-responsive">
                             <tr>
                                <td class="myWidth50"> योजनाको संचालन गर्ने संस्था / समितिको  नाम:</td>
                                <td><?=$data->program_organizer_group_name?></td>
                              <tr>
                              <td> ठेगाना:</td>
                              <td> <?php echo SITE_NAME.convertedcit($data->program_organizer_group_address);?></td>
                            </tr>
                            
                          </table>
                          <table class="detail_post table table-bordered table-responsive">
                                <tr>
                                    <th>सि.न.ं</th>
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
                                    <td><?=convertedcit($group_detail->address)?></td>
                                    <td><?=$gender?></td>
                                    <td><?=convertedcit($group_detail->cit_no)?></td>
                                    <td><?=$group_detail->issued_district?></td>
                                    <td><?=convertedcit($group_detail->mobile_no)?></td>
                                </tr>
                            <?php $i++; endforeach; ?>
                            </table>
                        </div>
                      <?php $datas = Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);?>
                      <h3>अनुगमन समिति सम्बन्धी विवरण </h3>
                       <form method="post" enctype="multipart/form_data">
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                               <table class="detail_posts table table-bordered table-responsive">
                                <tr>
                                    <th class="thWidth10">सि.नं.</th>
                                    <th class="thWidth15">पद</th>
                                    <th class="thWidth20">नामथर</th>
                                    <th class="thWidth15">वडा नं </th>
                                    <th class="thWidth20">लिगं</th>
                                    <th class="thWidth20">मोवायल नं</th>
                                    
                                </tr>
                                <?php if(empty($datas)){ $update=0;  $value="सेभ गर्नुहोस"; ?>
                                <tr>
                                    <td>1</td>
                                     <td>
                                         <select name="post_id_1[]"  class="post" required>
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input type="text" name="name_1[]" required class="input100percent"/></td>
                                    <td><input type="text" name="address_1[]" required value="<?php echo $group_heading->program_organizer_group_address?>" class="input100percent"/></td>
                                     <td> 
                                         <select  class="gender1" name="gender_1[]">
                                            
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="mobile_no_1[]" class="input100percent" required/></td>
                                 </tr>
                                 <tr>
                                    <td>2</td>
                                     <td>
                                         <select name="post_id_1[]"  class="post" required>
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input type="text" name="name_1[]" required class="input100percent"/></td>
                                    <td><input type="text" name="address_1[]" value="<?php echo $group_heading->program_organizer_group_address?>" required class="input100percent"/></td>
                                     <td> 
                                         <select  class="gender1" name="gender_1[]">
                                            
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="mobile_no_1[]" class="input100percent" required/></td>
                                 </tr>
                            <?php } else{  $update=1; $value="अपडेट गर्नुहोस"; $i=1; foreach($datas as $data): ?>

                                <tr <?php  if($i!=1){?> class="remove_post_detail_more" <?php } ?>>
                                    <td><?=$i?></td>
                                     <td>
                                         <select class="post" name="post_id_1[]">
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($data->post_id==$name->id){?> selected="selected" <?php }?>><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input class="input100percent" type="text" name="name_1[]" value="<?=$data->name?>" /></td>
                                    <td><input  class="input100percent" type="text" name="address_1[]" value="<?=$data->address?>" /></td>
                                     <td> 
                                         <select  class="input100percent" name="gender_1[]" class="gender1">
                                            
                                             <option value="1"  <?php if($data->gender==1){?> selected="selected" <?php } ?> >पुरुष</option>
                                             <option value="2"  <?php if($data->gender==2){?> selected="selected" <?php } ?> >महिला</option>
                                             <option value="3"  <?php if($data->gender==3){?> selected="selected" <?php } ?> >अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" class="input100percent" name="mobile_no_1[]" value="<?=$data->mobile_no?>" /></td>
                                 </tr>
                                 
                            <?php $i++; endforeach; } ?>
  
                            </table>
                            <table id="detail_add_more_table" class="table table-bordered table-responsive">
                                
                            </table>
                            <table class="table table-borderless">
      <tr>
                            
            <td><div class="add ">थप्नुहोस</div></td>
                <td> <div class="remove marginright20">हटाउनुहोस्</div></td>
                             <input type="hidden" name="update" value="<?=$update?>">
                             
                             
                            <td> <div class="marginright20"><input type="submit" name="submit" value="<?=$value?>" class=" submithere"></div></td>
                                
</tr>
                              </table>     
                         <div class="myspacer"></div>
                         
                                          
 </form>
               <?php }?>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>