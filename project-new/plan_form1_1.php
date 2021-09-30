<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$plan_selected = Plandetails1::find_by_id($_GET['id']);
//print_r($plan_selected);
if(isset($_POST['submit']))
{
     if($_POST['update']==1)
     {
     $data = Costumerassociationdetails0::find_by_plan_id($_POST['plan_id']); 
     $delete_details = Costumerassociationdetails::find_by_plan_id($_POST['plan_id']);
     foreach ($delete_details as $delete_detail) {
     $delete_detail->delete();
       }
     }
     else
     {
        $data = new Costumerassociationdetails0();
     }
     $data->program_organizer_group_name=$_POST['program_organizer_group_name'];
     $data->program_organizer_group_address=$_POST['program_organizer_group_address'];
     $data->plan_id=$_POST['plan_id'];
     $data->address_new = $_POST['address_new'];
     
     $data->created_date=date("Y-m-d",time());
     $data->save();
     for($i=0;$i<count($_POST['post_id_0']);$i++)
    {
       $data1 =new Costumerassociationdetails();
       $data1->plan_id= $_POST['plan_id'];
       $data1->post_id =$_POST['post_id_0'][$i];
       $data1->name= $_POST['name'][$i];
       $data1->address = $_POST['address'][$i];
       $data1->gender = $_POST['gender'][$i];
       $data1->cit_no = $_POST['cit_no'][$i];
       $data1->issued_district = $_POST['issued_district'][$i];
       $data1->mobile_no = $_POST['mobile_no'][$i];
       $data1->created_date=date("Y-m-d",time());
       $data1->save();
    }
    $mobile_number = $_POST['mobile_no'][0];
        $token = 'YCqXA7za1JqQDAOj1470EZsdomWHecGkOJkE';
        $to = $mobile_number;
        $sender    = '9851117526';
        $contract_title = $plan_selected->program_name;
        $message = $plan_selected->program_name. ' उपभोक्ता समिति (द. न-' .$plan_selected->id.') को अध्यक्ष हुनु भएकोमा  धन्यवाद !'.PHP_EOL ;
        $message .= SITE_NAME;
        // set post fields
        $content =[
            'token'=>rawurlencode($token),
            'to'=>rawurlencode($to),
            'sender'=>rawurlencode($sender),
            'message'=>rawurldecode($message),
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://beta.thesmscentral.com/api/v3/sms?");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
    echo alertBox("थप सफल ","plan_form1_2.php");
}
if(isset($_POST['search'])){
 if(empty($_POST['sn'])) {  
    $sql="select * from plan_details1 where program_name LIKE '%".$_POST['program']."%'";
 }
 else
 {
     $sql="select * from plan_details1 where id='".$_POST['sn']."'";
    
 }
 $result= Plandetails1::find_by_id($_POST['sn']);
}
$postnames=  Postname::find_all();
$post1 = Postname::find_by_id(1);
//print_r($post1->id);
$post2 = Postname::find_by_id(3);
$post3 = Postname::find_by_id(4);
$post4 = Postname::find_by_id(5);

//print_r($postnames);
if(isset($_GET['id']))
{
  $group_heading = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
  $group_details = Costumerassociationdetails::find_by_plan_id($_GET['id']);
   $value="सेभ गर्नुहोस";
   $update = 0; 
  if(!empty($group_heading) || !empty($group_details))
    {
      $value="अपडेट गर्नुहोस"; 
      $update = 1;
    }  
	 if(empty($group_heading))
	  {
		$group_heading = Costumerassociationdetails0::setEmptyObjects();
		$naame = $plan_selected->program_name." ".SITE_SAMITI;
	  }
	  else
	  {
	      $naame = $group_heading->program_organizer_group_name;
	  }
}
?>
<?php include("menuincludes/header.php"); ?>
<title> <?=$plan_selected->program_name?> :: <?php echo SITE_SUBHEADING;?> </title>
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
        <div class="maincontent">
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message; //print_r($message);?></div>
				<h2 class="headinguserprofile">उपभोक्ता समिति सम्बन्धी विवरण | <a href="upabhoktasamitidashboard.php" class="btn">पछि जानुहोस</a> | <a href="plan_form1_2.php" class="btn">अगाडी  जानुहोस</a></h2>
		 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <h2><?=$plan_selected->program_name?> - (<?php echo $plan_selected->parishad_sno;?>)</h2>
                <div class="userprofiletable">
                    <?php if(!isset($_GET['id'])){?>
                      <form  method="post">
                       योजनाको नाम:<input type="text" name="program"/>
                     दर्ता फाराम नं:<input type="text" name="sn"/>
                       <input type="submit" name="search" value="SEARCH"/>
                    </form>
            <?php if(isset($_POST['search'])):?>
                    <table class="table table-bordered">
                        <tr>
                            <th>दर्ता फाराम नं</th>
                            <th>योजनाको नाम</th>
                        </tr>
                        <tr>
                            <td><?php echo $result->sn;?></td>
                            <td><a href="plan_form1_1.php?id=<?php echo $result->id;?>"><?php echo $result->program_name;?></a></td>
                        </tr>
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
                                <div class="titleInput"><td>दर्ता नं : <span class="underline"><?php echo convertedcit( $data->id);?></span></div>
                                <div class="titleInput"><td>योजनाको नाम : <span class="underline"><?php echo $data->program_name;?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको बिषयगत क्षेत्रको नाम : <span class="underline"><?php echo Topicarea::getName($data->topic_area_id); ?></span></div>
                                <div class="titleInput">योजनाको  शिर्षकगत नाम : <span class="underline"><?php echo Topicareatype::getName($data->topic_area_type_id); ?></span></div>
                                <div class="titleInput">योजनाको  उपशिर्षकगत नाम : <span class="underline"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको अनुदानको किसिम : <span class="underline"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">योजनाको विनियोजन किसिम : <span class="underline"><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">योजना सचालन हुने स्थान : <span class="underline"><?php echo SITE_LOCATION;?>- <?php echo convertedcit($data->ward_no); ?></span></div>
                                <div class="titleInput">अनुदान रकम  : <span class="underline">रु. <?php echo convertedcit($data->investment_amount);?></span></div>
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
                                <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान : <span class="underline">रु. <?php echo convertedcit($data->agreement_gauplaika);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">अन्य निकायबाट प्राप्त अनुदान : <span class="underline">रु. <?php echo convertedcit($data->agreement_other);?></span></div>
                                <div class="titleInput">उपभोक्ताबाट नगद साझेदारी : <span class="underline"><?php echo convertedcit($data->costumer_agreement);?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">अन्य साझेदारी : <span class="underline"><?php echo convertedcit($data->other_agreement);?></span></div>
                                <div class="titleInput">उपभोक्ताबाट जनश्रमदान : <span class="underline">रु. <?php echo convertedcit($data->costumer_investment);?></span></div>
                                <div class="titleInput">कुल लागत अनुमान जम्मा : <span class="underline">रु. <?php echo convertedcit($data->total_investment);?></span></div>
                            </div><!-- input wrap 33 ends -->
                          	<div class="myspacer"></div>
                          </div><!-- input wrap 100 ends -->
                          	<?php } ?>
                        </div><!-- my content ends -->
                     <div>
                            <form method="post" enctype="multipart/form_data">
                            	<input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                     			
                                <h3>उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                                <div class="inputWrap50">
                                	<div class="titleInput">योजनाको संचालन गर्ने  उपभोक्ता समितिको नाम:</div>
                                    <div class="newInput"><input type="text" name="program_organizer_group_name" value="<?=$naame?>"  class="input100percent" /></div>
                                    <div class="titleInput">योजनाको संचालन गर्ने  उपभोक्ता समितिको ठेगाना: <span class="underline"><?php echo SITE_LOCATION;?> </span></div>
                                    <div class="newInput">वडा नम्बर : <input type="text" name="program_organizer_group_address" id="ward"  
                                    value=
                                    "<?php
                                        echo ($plan_selected->ward_no);
                                    ?>">
                                    </div>
                                    <div class="newInput">योजना संचालन स्थान : <input type="text" name="address_new" id="address_new"  
                                    value=
                                    "<?php echo $group_heading->address_new
                                    ?>">
                                    </div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap 50 ends -->
                               <table class="detail_post table table-bordered table-hover">
                                <tr>
                                    <td class="thWidth4 myCenter"><strong>सि.नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नाम/थर</strong></td>
                                    <td class="thWidth5 myCenter"><strong>वडा नं</strong></td>
                                    <td class="thWidth5 myCenter"><strong>लिङ्ग :</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="thWidth17 myCenter"><strong>मोबाइल  नं</strong></td>
                                </tr>
                                <?php if(empty($group_details)){ ?>
                                <tr>
                                    <td>1</td>
                                     <td>
                                         <!--<button type="btn btn-primary" name="post_id_0[]" value="<?php echo $post1->id;?>"><?php echo $post1->name?></button>-->
                                        <select name="post_id_0[]" class="post">
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]" class="input100percent"/></td>
                                   <td>
                                       <input type="text" name="address[]" id="kos" value="<?php echo $plan_selected->ward_no;?>" size="4">
                                         <!--<select  class="ward" name="address[]">-->
                                         <!--    <option value="">छान्नुस</option>-->
                                         <!--    <?php for($i=1;$i<13;$i++):?>-->
                                             
                                         <!--    <option value="<?php echo $i;?>"><?php echo $i;?></option>-->
                                         <!--       <?php endfor; ?>-->
                                         <!--</select>-->
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"  class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]" class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]" class="input100percent"/></td>
                                 </tr>
                                 <tr>
                                    <td>2</td>
                                     <td>
                                         <!--<input type="text" name="post_id_0[]" value="<?php echo $post2->name;?>" readonly="true">-->
                                         <select name="post_id_0[]" class="post" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]"  class="input100percent"/></td>
                                   <td>
                                       <input type="text" name="address[]" id="kos0" value="<?php echo $plan_selected->ward_no;?>">
                                         <!--<select  class="ward" name="address[]">-->
                                         <!--    <option value="">छान्नुस</option>-->
                                         <!--    <?php for($i=1;$i<13;$i++):?>-->
                                             
                                         <!--    <option value="<?php echo $i;?>"><?php echo $i;?></option>-->
                                         <!--       <?php endfor; ?>-->
                                         <!--</select>-->
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"   class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]"  class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]"  class="input100percent"/></td>
                                 </tr>
                                 <tr>
                                    <td>3</td>
                                     <td>
                                         <!--<input type="text" name="post_id_0[]" value="<?php echo $post3->name;?>" readonly="true">-->
                                         <select name="post_id_0[]" class="post" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]"  class="input100percent"/></td>
                                   <td>
                                       <input type="text" name="address[]" id="kos1" value="<?php echo $plan_selected->ward_no;?>">
                                         <!--<select  class="ward" name="address[]">-->
                                         <!--    <option value="">छान्नुस</option>-->
                                         <!--    <?php for($i=1;$i<13;$i++):?>-->
                                             
                                         <!--    <option value="<?php echo $i;?>"><?php echo $i;?></option>-->
                                         <!--       <?php endfor; ?>-->
                                         <!--</select>-->
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"   class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]"  class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]"  class="input100percent"/></td>
                                 </tr>
                                 <tr>
                                    <td>4</td>
                                     <td>
                                         <!--<input type="text" name="post_id_0[]" value="<?php echo $post4->name;?>" readonly="true">-->
                                         <select name="post_id_0[]" class="post" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]"  class="input100percent"/></td>
                                   <td>
                                       <input type="text" name="address[]" id="kos2" value="<?php echo $plan_selected->ward_no;?>">
                                         <!--<select  class="ward" name="address[]">-->
                                         <!--    <option value="">छान्नुस</option>-->
                                         <!--    <?php for($i=1;$i<13;$i++):?>-->
                                             
                                         <!--    <option value="<?php echo $i;?>"><?php echo $i;?></option>-->
                                         <!--       <?php endfor; ?>-->
                                         <!--</select>-->
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"   class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]"  class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]"  class="input100percent"/></td>
                                 </tr>
                                 <tr>
                                    <td>5</td>
                                     <td>
                                         <!--<input type="text" name="post_id_0[]" value="<?php echo $post4->name;?>" readonly="true">-->
                                         <select name="post_id_0[]" class="post" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]"  class="input100percent"/></td>
                                   <td>
                                       <input type="text" name="address[]" id="kos3" value="<?php echo $plan_selected->ward_no;?>">
                                         <!--<select  class="ward" name="address[]">-->
                                         <!--    <option value="">छान्नुस</option>-->
                                         <!--    <?php for($i=1;$i<13;$i++):?>-->
                                             
                                         <!--    <option value="<?php echo $i;?>"><?php echo $i;?></option>-->
                                         <!--       <?php endfor; ?>-->
                                         <!--</select>-->
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"   class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]"  class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]"  class="input100percent"/></td>
                                 </tr>
                                 
                                <?php } else {?>
                                    <?php $i = 1; foreach($group_details as $group_detail): ?>
                                  
                                    <tr <?php  if($i!=1){?> class="remove_post_detail" <?php } ?>>
                                    <td><?=$i?></td>
                                     <td>
                                            <select name="post_id_0[]" class="post" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($group_detail->post_id==$name->id){?> selected="selected" <?php } ?>><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input type="text" name="name[]" value="<?=$group_detail->name?>"  class="input100percent"/></td>
                                    <td>
                                        
                                         <select  class="ward" name="address[]">
                                             <option value="">छान्नुस</option>
                                             <?php for($j=1;$j<13;$j++):?>
                                             
                                             <option value="<?php echo $j;?>" <?php if($group_detail->address==$j){ echo 'selected="selected"';}?>><?php echo $j;?></option>
                                                <?php endfor; ?>
                                         </select>
                                     </td>
                                    <td> 
                                         <select name="gender[]" class="gender" >
                                             <option value="1" <?php if($group_detail->gender==1){?> selected="selected" <?php } ?> >पुरुष</option>
                                             <option <?php if($group_detail->gender==2){?> selected="selected" <?php } ?>  value="2">महिला</option>
                                             <option <?php if($group_detail->gender==3){?> selected="selected" <?php } ?>  value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"  value="<?=$group_detail->cit_no?>" class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]"  value="<?=$group_detail->issued_district?>" class="input100percent" /></td>
                                    <td><input type="text" name="mobile_no[]"  value="<?=$group_detail->mobile_no?>" class="input100percent" /></td>
                                 </tr>
                               <?php $i++; endforeach; ?>
                                <?php } ?>
                                <tbody id="detail_add_table"  class="detail_post table table-bordered table-responsive">
                                
                            </tbody>
                            </table>
                            <div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft"><div class="add_more btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove_more btn myWidth100">हटाउनुहोस [-]</div></div>
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
    <script>
        JQ(document).ready(function(){
           JQ(document).on("click","#ward",function(){
              $ward = JQ("#ward").val();
              JQ("#kos").val($ward)||0;
              JQ("#kos0").val($ward)||0;
              JQ("#kos1").val($ward)||0;
              JQ("#kos2").val($ward)||0;
              JQ("#kos3").val($ward)||0;
              //alert('alert'); 
           }); 
        });
    </script>