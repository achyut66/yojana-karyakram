<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Topicbudget::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Topicbudget();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->name= $_POST['name'];
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "setting_budget_topic.php");
    }
}
if(isset($_GET['id']))
{
    $data= Topicbudget::find_by_id($_GET['id']);
}
else
{
    $data =  Topicbudget::setEmptyObjects();
}
$budget_result=  Topicbudget::find_all();
//print_r($budget_result);exit;
?>
<!-- js ends -->
<title>बजेट उपशिर्षक थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">बजेट उपशिर्षक थप्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                  <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>बजेट उपशिर्षक थप्नुहोस</h1>
                                    <div class="titleInput">बजेट उपशिर्षकको नाम:</div>
                                    <div class="newInput"><input type="text" id="topic_name" name="name" value="<?php echo $data->name;?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" />
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                            </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>बजेट उपशिर्षकको नाम</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo $result->name;?></td>
                                    <form method="post" action="budget_topic_delete.php">
                                    <td class="myCenter">
                                        <a href="setting_budget_topic.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
                                        <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                        <input type="hidden" name="id" value="<?=$result->id?>">
                                    </td>
                                </tr>
                                <?php $i++; 
                                endforeach;?>
                            </table>

                       </div>
                 </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>