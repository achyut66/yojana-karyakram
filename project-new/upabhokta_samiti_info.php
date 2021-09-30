<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(isset($_POST['submit']))
{
   // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
    // उपभोक्ता समिति  सम्बन्धी विवरण 
     if($_POST['update']==1)
     {
       $data = Upabhoktasamitiprofile::find_by_id($_POST['update_id']); 
       $delete_details = Upabhoktasamitidetails::find_by_tol_id($_POST['update_id']);
       foreach ($delete_details as $delete_detail) {
            $delete_detail->delete();
       }
     }
     else
     {
        $data = new Upabhoktasamitiprofile();
      
     }
     $data->program_organizer_group_name=$_POST['program_organizer_group_name'];
     $data->program_organizer_group_address=$_POST['program_organizer_group_address'];
     $data->plan_id=$_POST['plan_id'];
     $data->created_date=$_POST['created_date'];
     $data->created_date_english=  DateNepToEng($_POST['created_date']);
     $tol_id = $data->save();
     
    
     for($i=0;$i<count($_POST['post_id_0']);$i++)
    {
       $data1 =new Upabhoktasamitidetails();
       $data1->tol_id= $tol_id;
       $data1->post_id =$_POST['post_id_0'][$i];
       $data1->name= $_POST['name'][$i];
       $data1->address = $_POST['address'][$i];
       $data1->gender = $_POST['gender'][$i];
       $data1->cit_no = $_POST['cit_no'][$i];
       $data1->issued_district = $_POST['issued_district'][$i];
       $data1->mobile_no = $_POST['mobile_no'][$i];
       $data->created_date = $_POST['created_date'];
       $data->created_date_english = DateNepToEng($_POST['created_date']);
       $data1->save();
    }
    echo alertBox("थप सफल ","upabhokta_samiti_profile_view.php");
}

$postnames=  Postname::find_all();
if(isset($_GET['id']))
{
  $group_heading = Upabhoktasamitiprofile::find_by_id($_GET['id']);
 
  $group_details = Upabhoktasamitidetails::find_by_tol_id($_GET['id']);
  
  
  if(!empty($group_heading) || !empty($group_details))
    {
      $value="अपडेट गर्नुहोस"; 
      $update = 1;
    }  
    
	 if(empty($group_heading))
	  {
		$group_heading = Upabhoktasamitiprofile::setEmptyObjects();
	  }
}
 if(empty($group_heading))
    {
         $value="सेभ गर्नुहोस";
         $update = 0; 
    }
//echo "<pre>"; print_r($data); echo "</pre>"; exit;
?>

<?php include("menuincludes/header.php"); ?>
<title> <?=$plan_selected->program_name?> :: <?php echo SITE_SUBHEADING;?> </title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
           	
                
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
				<h2 class="headinguserprofile">कार्यक्रम संचालन गर्ने उपभोक्ता समिति सम्बन्धी विवरण | <a href="tol_bikash_samiti_profile_view.php" class="btn">पछि जानुहोस</a></h2>
		 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <h2><?=$plan_selected->program_name?></h2>
                <div class="userprofiletable">
                  
                     <div>
                            <form method="post" enctype="multipart/form_data">
                            		
                                <h3>उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                                <div class="inputWrap50">
                                	<div class="titleInput">कार्यक्रम संचालन गर्ने उपभोक्ता समितिको नाम:</div>
                                    <div class="newInput"><input type="text" name="program_organizer_group_name" value="<?=$group_heading->program_organizer_group_name?>"  class="input100percent" /></div>
                                    <div class="titleInput">कार्यक्रम संचालन गर्ने उपभोक्ता समितिको ठेगाना: <span class="underline"><?php echo SITE_LOCATION;?> </span></div>
                                    <div class="newInput">वार्ड नम्बर : <input type="text" name="program_organizer_group_address" id="ward"  value="<?=$group_heading->program_organizer_group_address?>" ></div>
                                <div class="titleInput">मिती:</div>
                                    <div class="newInput"><input type="text" name="created_date" value="<?=$group_heading->created_date?>"  class="input100percent" id="nepaliDate3"/></div>
                                   	<div class="myspacer"></div>
                                </div><!-- input wrap 50 ends -->
                               <table class="detail_post table table-bordered table-hover">
                                <tr>
                                    <td class="thWidth4 myCenter"><strong>सि.नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नाम/थर</strong></td>
                                    <td class="thWidth5 myCenter"><strong>वडा नं</strong></td>
                                    <td class="thWidth5 myCenter"><strong>वार्ड नम्बर :</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="thWidth17 myCenter"><strong>मोबाइल  नं</strong></td>
                                    
                                </tr>
                                <?php if(empty($group_details)){ ?>
                                <tr>
                                    <td>1</td>
                                     <td>
                                         <select name="post_id_0[]" class="post" required>
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td ><input type="text" name="name[]" required class="input100percent"/></td>
                                   <td>
                                         <select  class="ward" name="address[]">
                                             <option value="">छान्नुस</option>
                                             <?php for($i=1;$i<13;$i++):?>
                                             
                                             <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                <?php endfor; ?>
                                         </select>
                                     </td>
                                     <td> 
                                         <select class="gender"  name="gender[]">
                                             <option  name="male" value="1">पुरुष</option>
                                             <option  name="female" value="2">महिला</option>
                                             <option  name="others" value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]" required  class="input100percent" /></td>
                                    <td><input type="text" name="issued_district[]" required class="input100percent" value="<?=SITE_ZONE?>"/></td>
                                    <td><input type="text" name="mobile_no[]" required class="input100percent"/></td>
                                 </tr>
                                <?php } else {?>
                                    <?php $i = 1; foreach($group_details as $group_detail): ?>
                                  
                                    <tr <?php  if($i!=1){?> class="remove_post_detail" <?php } ?>>
                                    <td><?=$i?></td>
                                     <td>
                                         <select name="post_id_0[]" class="post" required>
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($group_detail->post_id==$name->id){?> selected="selected" <?php } ?>><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input type="text" name="name[]" value="<?=$group_detail->name?>" required class="input100percent"/></td>
                                    <td>
                                         <select  class="ward" name="address[]">
                                             <option value="">छान्नुस</option>
                                             <?php for($j=1;$j<13;$j++):?>
                                             
                                             <option value="<?php echo $j;?>" <?php if($group_detail->address==$j){ echo 'selected="selected"';}?>><?php echo $j;?></option>
                                                <?php endfor; ?>
                                         </select>
                                     </td>
                                    <td> 
                                         <select name="gender[]" class="gender" required>
                                             <option value="1" <?php if($group_detail->gender==1){?> selected="selected" <?php } ?> >पुरुष</option>
                                             <option <?php if($group_detail->gender==2){?> selected="selected" <?php } ?>  value="2">महिला</option>
                                             <option <?php if($group_detail->gender==3){?> selected="selected" <?php } ?>  value="3">अन्य</option>
                                        </select>
                                     </td>
                                    <td><input type="text" name="cit_no[]"  value="<?=$group_detail->cit_no?>" class="input100percent" required/></td>
                                    <td><input type="text" name="issued_district[]"  value="<?=$group_detail->issued_district?>" class="input100percent" required/></td>
                                    <td><input type="text" name="mobile_no[]"  value="<?=$group_detail->mobile_no?>" class="input100percent" required/></td>
                                 </tr>
                               <?php $i++; endforeach; ?>
                                <?php } ?>
                                <tbody id="detail_add_table"  class="detail_post table table-bordered table-responsive">
                                
                            </tbody>
                            </table>
                                <input type="hidden" name="update_id" value="<?=$group_heading->id?>"
                            <div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft"><div class="add_more btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove_more btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="<?=$value?>" class="submit btn myWidth100" /></div><input type="hidden" name="update" value="<?=$update?>">
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                           	
                            </form>

           
                </div>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>