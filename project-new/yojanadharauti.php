<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$program_details =  Plandetails1::find_by_id($_GET['id']);
$final_plan_result = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
$dharauti_amounts = Analysisbasedwithdraw::getTotalDharautiAmount($_GET['id']) +  $final_plan_result->final_due_amount;

if(isset($_POST['submit']))
{
    if(!empty($_POST['update_id']))
    {
       $data = Yojanadharauti::find_by_id($_POST['update_id']) ;
    }
    else
    {
        $data = new Yojanadharauti();
    }
    
        $data->dharauti_amount =$_POST['dharauti_amount'];
        $data->return_amount =$_POST['return_amount'];
        $data->plan_id = $_POST['plan_id'];
        $data->save();
        echo alertBox("थप सफल ...","yojanadharauti.php");
}
$dharauti_details =  Yojanadharauti::find_by_plan_id($_GET['id']);
if(!empty($dharauti_details))
{
    $dharauti_amount =$dharauti_details->dharauti_amount ;
    $value="अपड़ेट गर्नुहोस";
}
else
{
    $dharauti_amount = $dharauti_amounts;
    $dharauti_details= Yojanadharauti::setEmptyObjects();
    $value = "सेभ गर्नुहोस";
}
?>
<?php

?>
<?php
include("menuincludes/header.php");
?>
<!-- js ends -->
<title>धरौटी विवरण भर्नुहोस् :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        
                <div class="maincontent">
                    <h2 class="headinguserprofile">धरौटी  विवरण भर्नुहोस् | <a href="bhuktani_select.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                        
                        <div class="userprofiletable">
                            <form method="post" enctype="multipart/form-data">
                                <div class="inputWrap">
                                	<h1><?php echo $program_details->program_name;?></h1>
                                	<div class="titleInput">धरौटी कट्टी रकम:</div>
                                    <div class="newInput"><input type="text" name="dharauti_amount"  id="check_dharauti_amount" value="<?php echo $dharauti_amount ;?>"/></div>
                                    <div class="titleInput">धरौटी कट्टी फिर्ता :</div>
                                    <div class="newInput"><input type="text" name="return_amount" id="check_return_amount" value="<?php echo $dharauti_details->return_amount?>"/></div>
                                    <div class="saveBtn myWidth100">
                                    	<input type="submit" name="submit" value="<?=$value?>" class="btn" id="plan_dharauti_check" ></td>
                                    <input type="hidden" name="plan_id" value="<?=(int) $_GET['id']?>" />
                                         <input type="hidden" name="update_id" value="<?php echo $dharauti_details->id?>"/>
                                    </div>
                                    <div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                
                            </form>


                        </div>
                    </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>