<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Ward::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Ward();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->ward= $_POST['ward'];
//    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "settings_ward_no.php");
    }
}

if(isset($_GET['id']))
{
    $data= Ward::find_by_id($_GET['id']);
   
}
else
{
    $data = Ward::setEmptyObjects();
}
$budget_result= Ward::find_all();
?>
<!-- js ends -->
<title>वार्ड नं हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">वार्ड नं हाल्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2>वार्ड नं हाल्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<div class="titleInput">वार्ड नं :</div>
                                    <div class="newInput"><input type="text"  name="ward" value="<?php echo $data->ward;?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->ward);?></td>
                                    <td class="myCenter"><a href="settings_ward_no.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a></td>
                                </tr>
                                <?php $i++; 
                                endforeach;?>
                            </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>