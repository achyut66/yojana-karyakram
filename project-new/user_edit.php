<?php require_once("includes/initialize.php"); ?>
<?php
	$mode=getUserMode();
if($mode!="superadmin")
{
    die("ACCESS DENIED");
}
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user_id = $_GET['id'];
$user1 = User1::find_by_id($user_id);
?>
<?php
if(isset($_POST['submit']))
  {
     
    $user= User1::find_by_id($_POST['update_id']);
    $user->name=$_POST['name'];
    $user->phone=$_POST['phone'];
    $user->email=$_POST['email'];
    $user->username=$_POST['username'];
    $user->status=$_POST['status'];
    $user->mode=$_POST['mode'];
    $user->topic_area_id = $_POST['topic_area_id'];
    $user->topic_area_type_id = $_POST['topic_area_type_id'];
    $user->ward=$_POST['ward'];
    $user->ward_add = $_POST['ward_add'];
    if(!empty($_POST['password']))
    {
          if($_POST['password'] != $_POST['password1'])
            {
               echo  alertBox("नया पस्स्वोर्ड पुन हाल्नुहोस् ","user_edit.php?id=".$_POST['update_id']);
                exit;
            }
            $user->password = md5($_POST['password']);
    }
    if($user->save())
    {
       echo alertBox("User Edited Sucessfully", "user_details.php");
    }
  }
  $ward_array= array(0,1,2,3,4,5,6,7,8,9,10,11);
  $budget_result=Topicbudget::find_all();
  $topic_area=  Topicarea::find_all();

?>
<?php include("menuincludes/header.php"); 
include 'menu/header_script.php';?>
<!-- js ends -->
<title>प्रयोगकर्ता सच्याउनुहोस् :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्रयोगकर्ता सच्याउनुहोस् | <a href="user_details.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                            <?php echo $message;?>
                            <form method="post">
                               <div class="inputWrap100"> 
                                <div class="inputWrap33 inputWrapLeft">
                                <div class="titleInput">नाम:</div>
                                <div class="newInput"><input type="text" name="name" required value="<?= $user1->name ?>"></div>
                              <div class="titleInput">नम्बर:</div>
                              <div><input type="text" name="phone" required value="<?= $user1->phone ?>"></div>
                              <div class="titleInput">वार्ड:</div>
                              <div class="newInput">
                              <select name="ward" class="form-control">
                                                    <option value="">छान्नुहोस् </option>
                                        <?php foreach($ward_array as $ward): ?>     
                                                    <option <?php if($ward== $user1->ward){echo 'selected="selected"';} ?> value="<?= $ward ?>"><?= convertedcit($ward) ?></option>
                                         <?php endforeach; ?>           
                              </select></div>
                                    <div class="titleInput">वडा ठेगाना:</div>
                                    <div><input type="text" name="ward_add" required value="<?= $user1->ward_add ?>"></div>
                               </div><!-- input wrap 33 ends -->
                              <div class="inputWrap33 inputWrapLeft">
                              <div class="titleInput">ई-मेल:</div>
                                <div class="newInput"><input type="email" name="email" required value="<?= $user1->email ?>"></div>
                              <div class="titleInput">कार्यरत अवस्था :</div>
                                    <div class="newInput"><input <?php if($user1->status==1){echo 'checked="checked"';} ?> type="radio" name="status" value="1"/>Active|
                                    <input <?php if($user1->status==0){echo 'checked="checked"';} ?> type="radio" name="status" value="0"/>Inactive </div>
                              <div class="titleInput"> मोड :</div>
                                  
                                    <div class="newInput">
                                        <select name="mode">
                                            <option value="">छान्नुहोस्</option>
                                            <option value="superadmin" <?php if($user1->mode=="superadmin"){echo 'selected="selected"';} ?>>सुपर एडमिन</option>
                                                <option value="administrator" <?php if($user1->mode=="administrator"){echo 'selected="selected"';} ?>>एडमिन</option>
                                                 <option value="subadmin" <?php if($user1->mode=="subadmin"){echo 'selected="selected"';} ?>>सबएडमिन</option>
                                            <option value="user" <?php if($user1->mode=="user"){echo 'selected="selected"';} ?>>प्रयोगकर्ता </option>
                                             <option value="section" <?php if($user1->mode=="section"){echo 'selected="selected"';} ?>>शाखा</option>
                                        </select>
                                    </div>
                              <div class="titleInput">योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम:</div>
                                 <div class="newInput">
                                      <select name="topic_area_id" id="topic_area_id" >
                                        <option value="">--छान्नुहोस्--</option>
                                                 <?php foreach($topic_area as $topic): ?> 
                                        <option value="<?php echo $topic->id;?>" <?php if($user1->topic_area_id==$topic->id){echo 'selected="selected"';} ?>><?php echo $topic->name;  ?></option>
                                             <?php endforeach; ?>
                                    </select>
                                      </div>
                                 </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                             <div id="topic_area_type_id"></div>
                              <div class="titleInput">यूसरनेम :</div>
                                <div class="newInput"><input type="text" name="username" required value="<?= $user1->username ?>"></div>
                              <div class="titleInput">पस्स्वर्ड :</div>
                              <div class="newInput"><input type="password" name="password"  id="new_password" autocomplete="off"></div>
                              <div class="titleInput">पास्स्वोर्ड पुनः हाल्नुहोस :</div>
                              <div class="newInput"><input type="password" name="password1"  id="confirm_password" oninput="myFunction()" ><span id="demo"></span></div>
                              
                              <input type="hidden" name="update_id" value="<?=(int) $_GET['id']?>" />
                            <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सच्याउनुहोस" class="btn"></div>
                        </div><!-- input wrap 33 ends -->\
                               </div>
                            </form>
                        </div>

                        
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>