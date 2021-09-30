<?php 
error_reporting(1);
        require_once("includes/initialize.php");
       
        
	if($session->is_logged_in()){ redirect_to("index.php");}
	if(isset($_POST['submit']))
	{
            
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
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
                		<h2>लगइन गर्नुहोस्</h2>
                        <div class="logo">
                        	<img src="images/logo_login.png" alt="Logo " />
                            
                            
                        </div>
                        <div id="inputplaceholder">
                        <?php echo $message; ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div id="myusername">
                                <input id="username" type="text" name="username" class="username" placeholder="insert username" required="required" />
                            </div>
                            <div id="mypassword">
                                <input type="password" class="password" name="password" placeholder="insert password"/>
                            </div>
                            
                            <div id="keeplogin">
                                <input id="loginkeeping" name="loginkeeping" value="loginkeeping" type="checkbox">
                                <label for="loginkeeping">Keep me logged in</label>
                            </div>
                            <div id="submit">
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