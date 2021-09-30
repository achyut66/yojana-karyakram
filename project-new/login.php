<?php 
error_reporting(1);
        require_once("includes/defines.php");
        require_once("includes/session.php");
//	require_once('includes/database.php');
        require_once('includes/database_object.php');
        require_once('includes/functions.php');
	if($session->is_logged_in()){ redirect_to("index.php");}
	if(isset($_POST['submit']))
	{
           $session->set_fiscal_year($_POST['fiscal_id']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
//                    require_once('includes/config1.php');
                    require_once('includes/database.php');
                    require_once("includes/user1_class.php");
                    $found_user = User1::authenticate_for_user($username, $password);
               //($found_user);exit;
		 if ($found_user)
		{
                     $session->login($found_user);	
			redirect_to('index.php');
		}
		else
		{
                    echo alertBox("Username or password did not match","login.php");
		}
	}
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>Login Panel ::<?=SITE_SUBHEADING?></title>
</head>
<body>
    <div id="top_wrap">
        <div class="container">
            <div class="content row">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                	<h1><?php echo SITE_LOCATION;?> : <?php echo SITE_SUBHEADING;?> <img src="images/flag.gif" alt="Nepal Flag Flapping" /></h1> 
                </div>
            </div>
        </div>	
    </div><!-- top wrap ends -->
    <div id="body_wrap">
        <div class="container">
            <div class="content row">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="loginwrap">
                		<h2>लगइंन गर्नुहोस् </h2>
                        <div class="logo">
                        	<img src="images/janani.png" alt="Logo " />
                        </div>
                        <div class="myspacer"></div>
                        <div id="inputplaceholder">
                        <?php echo $message; ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div id="myusername">
                                <input id="username" type="text" name="username" class="username" placeholder="प्रयोगकर्ता युजरनेम" required="required" />
                            </div>
                            <div id="mypassword">
                                <input type="password" class="password" name="password" placeholder="प्रयोगकर्ता पासवर्ड"/>
                            </div>
                            <div style="margin-top:15px;">
                            *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
                            </div>
                            <div id="fiscalyear" style="margin-top:10px;">
                                <span> आ.ब छान्नुहोस् :- </span>
                                <select  name="fiscal_id" required="required">
                                    <option>----------</option>
                                    <option value="1" selected="selected"><?=convertedcit(2078.2079)?></option>
                                </select>
                             </div>
                            <div style="margin-top:15px;">
                            *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
                            </div>
                            <!--<div id="keeplogin">-->
                            <!--    <input id="loginkeeping" name="loginkeeping" value="loginkeeping" type="checkbox">-->
                            <!--    <label for="loginkeeping">Keep me logged in</label>-->
                            <!--</div>-->
                            <div id="submit" style="margin-top:10px;">
                                <input type="submit" name="submit" class="login" value="Login"/>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>