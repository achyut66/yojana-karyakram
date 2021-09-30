 
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

<!--use the fa-lg (33% increase), fa-2x, fa-3x, fa-4x, or fa-5x classes-->

 <?php // require_once("menuincludes/header.php"); 
 $fy = Fiscalyear::find_by_id(1);//print_r($fy);
 $user = getUser();
 $fy = Fiscalyear::find_by_id(1);//print_r($fy);
 ?>
<div id="top_wrap1"> 
<!--<div>आ.व: <?php echo convertedcit($fy->year);?></div>-->
                <div class="col col-lg-8 col-md-6 col-sm-12 col-xs-12 title">
                    <a href="index.php" title="ड्यासबोर्डमा जानुहोस"><h1><?php echo SITE_LOCATION;?> <span class="myRight myFlag"> <img src="images/flag.gif" alt="Nepal Flag Flapping" height="35em" /></span></h1></a>
                </div>
                <div class="col col-lg-4 col-md-6 col-sm-12 col-xs-12 toplink">
                    <ul>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-2x" style="color:red"></i></a></li>
                        
                        <li style="margin-top:6px; font-size:16px;"><a href="#"><?php echo $user->name;?>-<?php echo $user->ward;?></a></li>
                    </ul>
                    <ul>
                        <li style="margin-top:6px; font-size:16px;"><a href="#">आ.व:- <?php echo convertedcit($fy->year);?></a></li>
                    </ul>
                    <!--<ul>-->
                    <!--    <li><a href="update_user.php">प्रयोगकर्ता सच्याउनुहोस</a></li>-->
                    <!--</ul>-->
                </div>
</div><!-- top wrap ends -->
</body>
</html>
<?php require_once("menuincludes/mainmenusuperadmin.php");?>