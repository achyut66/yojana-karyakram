<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//get_access_to_third_form($_GET['id']);
$plan_selected = Plandetails1::find_by_id($_GET['id']);
$user = getUser();
//print_r($user);
if(isset($_POST['submit']))
{
    //अनुगमन समिति सम्बन्धी विवरण
  
    if($_POST['update']==1)
     {
        $delete_details = investigationassociationdetails::find_by_plan_id($_POST['plan_id']);
        foreach ($delete_details as $delete_detail) {
            $delete_detail->delete();
        }
     }   
    for($i=0;$i<count($_POST['post_id_1']);$i++)
    {
       $data2 =new investigationassociationdetails();
       $data2->plan_id = $_POST['plan_id'];
       $data2->post_id =$_POST['post_id_1'][$i];
       $data2->name = $_POST['name_1'][$i];
       $data2->address = $_POST['address_1'][$i];
       $data2->gender = $_POST['gender_1'][$i];
       $data2->mobile_no = $_POST['mobile_no_1'][$i];
       $data2->created_date=date("Y-m-d",time());
       $data2->save();
    }
    if($user->mode==user){
        echo alertBox("थप्न सफल ","letters_select.php ");
    }else{
        echo alertBox("थप्न सफल ","plan_form1_3.php ");
    }
        
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

?>

<?php include("menuincludes/header.php"); ?>
<title><?=$plan_selected->program_name?> :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
         <h2 class="headinguserprofile">अनुगमन समिति सम्बन्धी विवरण  | <a href="upabhoktasamitidashboard.php" class="btn">पछि जानुहोस </a></h2>
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
                    	<div class="inputWrap100">
                        	<div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">आर्थिक वर्ष : <span class="underline"><?php echo convertedcit($fiscal->year); ?></span></div>
                                <div class="titleInput">आर्थिक वर्ष : <span class="underline"><?php echo convertedcit($fiscal->year); ?></span></div>
                                <div class="titleInput">दर्ता नं : <span class="underline"><?php echo convertedcit($data->id);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको बिषयगत क्षेत्रको नाम : <span class="underline"><?php echo Topicarea::getName($data->topic_area_id); ?></span></div>
                                <div class="titleInput">योजनाको  शिर्षकगत नाम : <span class="underline"><?php echo Topicareatype::getName($data->topic_area_type_id); ?></span></div>
                                <div class="titleInput">योजनाको  उपशिर्षकगत नाम : <span class="underline"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको अनुदानको किसिम : <span class="underline"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">योजनाको नाम : <span class="underline"><?php echo $data->program_name;?></span></div>
                                <div class="titleInput">योजना सचालन हुने स्थान : <span class="underline"><?php echo SITE_LOCATION;?>- <?php echo convertedcit($data->ward_no); ?></span></div>
                                <div class="titleInput">अनुदान रकम : <span class="underline">रु. <?php echo convertedcit($data->investment_amount);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="myspacer"></div>
                        </div><!-- inpur wrap 100 ends -->
                     </div>
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
                            	<div class="titleInput">भौतिक ईकाईको  परिणाम : <span class="underline">रु. <?=convertedcit($data->unit_total)?> <?=$unit->name?></span></div>
                                <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान : <span class="underline">रु. <?php echo convertedcit($data->agreement_gauplaika);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">अन्य निकायबाट प्राप्त अनुदान : <span class="underline">रु. <?php echo convertedcit($data->agreement_other);?></span></div>
                                <div class="titleInput">उपभोक्ताबाट नगद साझेदारी : <span class="underline">रु. <?php echo convertedcit($data->costumer_agreement);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">अन्य साझेदारी : <span class="underline">रु. <?php echo convertedcit($data->other_agreement);?></span></div>
                                <div class="titleInput">उपभोक्ताबाट जनश्रमदान : <span class="underline">रु. <?php echo convertedcit($data->costumer_investment);?></span></div>
                                <div class="titleInput">कुल लागत अनुमान जम्मा : <span class="underline">रु. <?php echo convertedcit($data->total_investment);?></span></div>
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
                                        <span class="underline"><?=$data->program_organizer_group_name?></span></div>
                                    </div><!-- input wrap 50 ends -->
                                    <div class="inputWrap50 inputWrapLeft">
                                		<div class="titleInput">योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना: <br>
                                        <span class="underline"> <?php echo SITE_NAME.convertedcit($data->program_organizer_group_address);?></span></div>
                                    </div><!-- input wrap 50 ends -->
                                	<div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                              <table class="detail_post table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.न.</strong></td>
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
                                    <td><?=convertedcit($group_detail->address)?></td>
                                    <td><?=$gender?></td>
                                    <td><?=convertedcit($group_detail->cit_no)?></td>
                                    <td><?=$group_detail->issued_district?></td>
                                    <td><?=convertedcit($group_detail->mobile_no)?></td>
                                </tr>
                            <?php $i++; endforeach; ?>
                            </table>
                        </div>
                      <?php $datas = Investigationassociationdetails::find_by_plan_id($_GET['id']);?>
                      <h3>अनुगमन समिति सम्बन्धी विवरण </h3>
                       <form method="post" enctype="multipart/form_data">
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                               <table class="detail_posts table table-bordered table-hover">
                                <tr>
                                    <td class="thWidth10 myCenter"><strong>सि.नं.</strong></td>
                                    <td class="thWidth15 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth20 myCenter"><strong>नामथर</strong></td>
                                    <td class="thWidth15 myCenter"><strong>वडा नं </strong></td>
                                    <td class="thWidth20 myCenter"><strong>लिगं</strong></td>
                                    <!--<td class="thWidth20 myCenter"><strong>मोबाइल नं</strong></td>-->
                                    
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
                                    <td><input type="text" name="address_1[]" value="<?=$data->address?>" required class="input100percent"/></td>
                                     <td> 
                                         <select  class="gender1" name="gender_1[]">
                                            
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <!--<td><input type="text" name="mobile_no_1[]" class="input100percent" required/></td>-->
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
                                    <!--<td><input type="text" class="input100percent" name="mobile_no_1[]" value="<?=$data->mobile_no?>" /></td>-->
                                 </tr>
                                 
                            <?php $i++; endforeach; } ?>
                            	<tbody id="detail_add_more_table" class="table table-bordered table-hover"></tbody>
  
                            </table>
                            
                            <div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft"><div class="add btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="<?=$value?>" class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                            
                            
                         
                                          
 </form>
               <?php }?>

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>