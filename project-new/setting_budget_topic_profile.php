<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); 
 error_reporting(E_ALL);
?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Topicbudgetprofile::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Topicbudgetprofile();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->fiscal_id = $_POST['fiscal_id'];
    $form_data->budget_topic_id = $_POST['budget_topic_id'];
    $form_data->amount = $_POST['amount'];
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "setting_budget_topic_profile.php");
    }
}

if(isset($_GET['id']))
{
    $data = Topicbudgetprofile::find_by_id($_GET['id']);
    $fiscal_selected = Fiscalyear::find_by_id($data->fiscal_id);
    $budget_topic_selected = Topicbudget::find_by_id($data->budget_topic_id);
}
else
{
    $data =  Topicbudgetprofile::setEmptyObjects();
    $fiscal_selected = Fiscalyear::setEmptyObjects();
    $budget_topic_selected = Topicbudget::setEmptyObjects();
}
$fiscals = Fiscalyear::find_all();
$budget_topic_result=  Topicbudget::find_all();
$budget_topic_profiles = Topicbudgetprofile::find_by_sql("select * from topic_budget_profile order by fiscal_id desc");
?>
<!-- js ends -->
<title>बजेट उपशिर्षक थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>
</head>
<style>
    <style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }
  .borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
}
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
</style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">बजेट उपशिर्षक थप्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                  <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    	<div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap50">
                                	<h2>बजेट उपशिर्षक थप्नुहोस </h2>
                                	<div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">आर्थिक वर्ष : </div>
                                        <div class="newInput"><select name="fiscal_id">
                                                    <option value="">छान्नुहोस्</option>
                                                    <?php foreach($fiscals as $fiscal):?>
                                                    <option value="<?php echo $fiscal->id;?>"<?php if($fiscal->is_current==$fiscal->id){?> selected="selected" <?php }?> <?php if($fiscal_selected->id==$fiscal->id){?> selected="selected" <?php } ?>><?php echo $fiscal->year;?></option>
                                                    <?php endforeach;?>
                                                </select></div>
                                        <div class="titleInput">बजेट उपशिर्षकको नाम : </div>
                                        <div class="newInput"><select name="budget_topic_id">
                                                    <option value="">छान्नुहोस्</option>
                                                    <?php foreach($budget_topic_result as $result):?>
                                                    <option value="<?php echo  $result->id;?>" <?php if($budget_topic_selected->id==$result->id){?> selected="selected"<?php } ?>><?php echo $result->name;?></option>
                                                    <?php endforeach;?>
                                                </select></div>
                                    </div><!-- input wrap 50 ends -->
                                    <div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">रकम : </div>
                                        <div class="newInput"><input type="text" name="amount" value="<?php echo $data->amount; ?>" /></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                        <input  type="hidden" name="update_id" value="<?=$data->id?>" />
                                    </div><!-- input wrap 50 ends -->
                                	<div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                                    
                            </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>आर्थिक वर्ष</strong></td>
                                    <td class="myCenter"><strong>बजेट उपशिर्षकको नाम</strong></td>
                                    <td class="myCenter"><strong>रकम</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_topic_profiles as $result):
//                                    print_r($result);
                                    ?>
                                <?php $fiscal_get = Fiscalyear::find_by_id($result->fiscal_id); ?>
                                <?php $budget_get = Topicbudget::find_by_id($result->budget_topic_id); ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($fiscal_get->year);?></td>
                                    <td class="myCenter"><?php echo $budget_get->name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->amount);?></td>
                                    <form method="post" action="budget_topic_profile_delete.php">
                                    <td class="myCenter">
                                        <a href="setting_budget_topic_profile.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
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