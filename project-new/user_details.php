<?php require_once("includes/initialize.php");
$mode=getUserMode();
if($mode!="superadmin" && $mode!="administrator")
{
    die("ACCESS DENIED");
}
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$datas=  User1::find_all();
?>
<title>User Profile :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
<?php 
include("menuincludes/topwrap.php"); 
require_once("menuincludes/header.php");
include("menu/header_script.php");?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">प्रयोगकर्ताको  प्रोफाइल | <a href="user1.php" class="btn">प्रयोगकर्ता थप्नुहोस+</a> | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>प्रयोगकर्ता हेर्नुहोस </h2>
                        <div class="userprofiletable">
                            <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"><strong>प्रयोगकर्ताको नाम</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क न</strong></td>
                                            <td class="myCenter"><strong>वार्ड न</strong></td>
                                            <td class="myCenter"><strong>इमेल ठेगाना</strong></td>
                                            <td class="myCenter"><strong>कार्यरत अवस्था</strong> </td>
                                            <td class="myCenter"><strong>मोड</strong></td>
                                            <td class="myCenter"><strong>युजरनेम</strong></td>
                                             <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                             
                                        </tr>
                                        <?php foreach($datas as $data):
                                        
                                            switch($data->status)
                                            {
                                                case 1:
                                                    $status="कार्यरत";
                                                    break;
                                                case 0:
                                                    $status="कार्य समाप्त";
                                                    break;
                                            }
                                            switch($data->mode)
                                            {
                                                case 'superadmin':
                                                    $mode="सुपर एडमिन";
                                                    break;
                                                case 'administrator':
                                                    $mode="एडमिन";
                                                    break;
                                                case 'user':
                                                    $mode="प्रयोगकर्ता";
                                                    break;
                                                 case 'subadmin':
                                                    $mode="सब-एडमिन";
                                                    break; 
                                                case 'section':
                                                    $mode="शाखा";
                                            }
                                            ?>
                                        <tr>
                                            <td class="myCenter"><?php echo $data->name;?></td>
                                            <td class="myCenter"><?php echo $data->phone;?></td>
                                            <td class="myCenter"><?php echo $data->ward;?></td>
                                            <td class="myCenter"><?php echo $data->email;?></td>
                                            <td class="myCenter"><?php echo $status;?></td>
                                            <td class="myCenter"><?php echo $mode;?></td>
                                            <td class="myCenter"><?php echo $data->username;?></td>
                                            <td class="myCenter"><a href="user_edit.php?id=<?=$data->id?>" class="btn">सच्याउनुहोस</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                        </table>
                        </div>

                        
                    </div>
                </div><!-- main menu ends -->
              
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>