<?php require_once("includes/initialize.php"); ?>
<?php
	$mode=getUserMode();
if($mode!="superadmin")
{
    die("ACCESS DENIED");
}
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php
if(isset($_POST['submit']))
{
//    print_r($_POST);exit;
    $record = User1::find_by_sql("select * from user1 where username='".$_POST['username']."'");
//    print_r($record);exit;
    if(!empty($record))
    {
        echo alertBox("Username Already Exist...","user1.php");
    }
    else{
    $user=new User1();
    $user->name=$_POST['name'];
    $user->phone=$_POST['phone'];
    $user->email=$_POST['email'];
    $user->username=$_POST['username'];
    $user->status=$_POST['status'];
    $user->mode=$_POST['mode'];
    $user->ward=$_POST['ward'];
    $user->ward_add= $_POST['ward_add'];
    $user->topic_area_id = $_POST['topic_area_id'];
    $user->topic_area_type_id = $_POST['topic_area_type_id'];
    $user->password=md5($_POST['password']);
    if($user->save())
    {
          echo alertBox("User Created Sucessfully...","user_details.php");
   
    }
    }
}
$topic_area=  Topicarea::find_all();

?>
<?php include("menuincludes/header.php"); 
include 'menu/header_script.php';?>
<!-- js ends -->
<title>User Profile :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्रयोगकर्ताको  प्रोफाइल | <a href="user_details.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                            <div class="myMessage"><?php echo $message;?></div>
                            <form method="post">
                            <div class="inputWrap100">
                            	<h1>प्रयोगकर्ता थप्नुहोस </h1>
                            	<div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">प्रयोगकर्ताको नाम : </div>
                                    <div class="newInput"><input type="text" name="name" required></div>
                                    <div class="titleInput">सम्पर्क न. : </div>
                                    <div class="newInput"><input type="text" name="phone" required></div>
                                    <div class="titleInput">वार्ड न. : </div>
                                    <div class="newInput"><select name="ward" >
                                                    <option value="">छान्नुहोस् </option>
                                                    <option value="1">१  </option>
                                                    <option value="2">२  </option>
                                                    <option value="3">३  </option>
                                                    <option value="4">४   </option>
                                                    <option value="5">५  </option>
                                                    <option value="6">६  </option>
                                                    <option value="7">७  </option>
                                                    <option value="8">८   </option>
                                                    <option value="9">९  </option>
                                                    <option value="10">१०  </option>
                                                    <option value="11">११  </option>
                                             </select></div>
                                    <div class="titleInput">वडा ठेगाना : </div>
                                    <div class="newInput"><input type="text" name="ward_add"></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">इमेल ठेगाना : </div>
                                    <div class="newInput"><input type="email" name="email" required></div>
                                    <div class="titleInput">कार्यरत अवस्था : </div>
                                    <div class="newInput"><input type="radio" name="status" value="1"/>Active |
                                    <input type="radio" name="status" value="0"/>Inactive </div>
                                    <div class="titleInput">मोड : </div>
                                    <div class="newInput"><select name="mode">
                                            <option value="">छान्नुहोस्</option>
                                            <option value="superadmin">सुपर एडमिन</option>
                                                <option value="administrator">एडमिन</option>
                                                <option value="subadmin">सबएडमिन</option>
                                                  <option value="section">शाखा</option>
                                            <option value="user">प्रयोगकर्ता </option>
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
                                	<div class="titleInput">युजरनेम : </div>
                                    <div class="newInput"><input type="text" name="username" required></div>
                                    <div class="titleInput">पास्वोर्ड : </div>
                                    <div class="newInput"><input type="password" name="password" required id="new_password"></div>
                                    <div class="titleInput">पास्वोर्ड पुनः हाल्नुहोस : </div>
                                    <div class="newInput"><input type="password" name="password1" required id="confirm_password" oninput="myFunction()"   ><span id="demo"></span></div>	
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="इन्ट्री गर्नुहोस" class="btn"></div>
                                </div><!-- input wrap 33 ends -->
                                
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                            
                            </form>
                        </div>

                        
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>