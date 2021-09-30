<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = ShrotDetails::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new ShrotDetails();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->name= $_POST['name'];
//    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "setting_shrot.php");
    }
}

if(isset($_GET['id']))
{
    $data= ShrotDetails::find_by_id($_GET['id']);
   
}
else
{
    $data = ShrotDetails::setEmptyObjects();
}
$budget_result= ShrotDetails::find_all();
//print_r($budget_result);
?>
<!-- js ends -->
<title>बजेट स्रोत हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">बजेट स्रोत  हाल्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2>बजेट स्रोत  हाल्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<div class="titleInput">बजेट स्रोत:</div>
                                    <div class="newInput"><input type="text"  name="name" value="<?php echo $data->name;?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                 
                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>बजेट स्रोत </strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):
    ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo $result->name;?></td>
                                    <form method="post" action="shrot_delete.php">
                                        <td class="myCenter">
                                        <a href="setting_shrot.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
                                        <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                        <input type="hidden" name="id" value="<?=$result->id?>">
                                    </td>
                                    </form>
                                </tr>
                                <?php $i++; 
                                endforeach;?>
                            </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>