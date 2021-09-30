<?php require_once("includes/initialize.php"); ?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
?>
<?php 
$user = getUser();


if(isset($_POST['submit']))
{   
    $data=  User1::find_by_id($user->id);
//    print_r($data);exit;
    if($data->password==md5($_POST['password']))
    {
        if(md5($_POST['password1'])==md5($_POST['password2']))
        {
            $data->username=$_POST['username'];
            $data->password=md5($_POST['password1']);
            $data->update_date=  date("Y-m-d", time());
            if($data->save())
            {
                $session->message("udated successfully");
                redirect_to("update_user.php");
            }
        }
        else{
             $session->message(" password not matched");
             redirect_to("update_user.php");
        }
    }
    else{
        $session->message("current password incorrect");
         redirect_to("update_user.php");
    }
}
?>
<?php include("menuincludes/header.php"); ?>
<title>User Profile :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); 
    include("menu/header_script.php");?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्रयोगकर्ताको  प्रोफाइल</h2>
                  
                    <div class="OurContentFull">
                    	<h2>प्रयोगकर्ता थप्नुहोस </h2>
                        <div class="userprofiletable">
                            <?php echo $message; ?>
                            <form method="post">
                            <table class="table table-bordered table-responsive">
                              <tr>
                                <td>युजरनेम:</td>
                                <td><input type="text" name="username" required value="<?php echo $user->username;?>"></td>
                              </tr>
                              <tr>
                                <td>पास्स्वोर्ड :</td>
                                <td><input type="password" name="password" required></td>
                              </tr>
                              <tr>
                                <td>नया पास्स्वोर्ड हाल्नुहोस  :</td>
                                <td><input type="password" name="password1" id="new_password" required></td>
                              </tr>
                              <tr>
                                <td>नया  पास्स्वोर्ड  फेरी हाल्नुहोस:</td>
                                <td><input type="password" name="password2" id="confirm_password" oninput="myFunction()" required><span id="demo"></span></br></br></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" name="submit" value="इन्ट्री गर्नुहोस" class="submithere"></td>
                              </tr>
                              
                            </table>
                            </form>
                        </div>

                        
                    </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>