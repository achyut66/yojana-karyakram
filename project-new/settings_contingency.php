<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

?>

<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Contingency::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Contingency();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->plan_id = $_POST['plan_id'];
    $form_data->type = $_POST['type'];
    $form_data->percent= $_POST['percent'];
    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "settings_contingency.php");
    }
}

if(isset($_GET['id']))
{
    $data= Contingency::find_by_id($_GET['id']);
   
}
else
{
    $data = Contingency::setEmptyObjects();
}
$budget_result= Contingency::find_all();
$final_result = Contingency::find_by_sql("select * from contingency where type=1");
?>
<!-- js ends -->
<title>कन्टेन्जेन्सी कट्टी रकम हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">कन्टेन्जेन्सी कट्टी रकम हाल्नुहोस  | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2>कन्टेन्जेन्सी कट्टी रकम हाल्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                    <div class="titleInput">कन्टेन्जेन्सी प्रकार :</div>
                                    <div class="newInput">
                                        <select name="type" id="contingency_type">
                                            <option value="">---------</option>
                                            <?php
                                            if(empty($final_result))
                                            {
                                            ?>
                                            <option value="1" <?php if($data->type==1){ echo 'selected="selected"';}?>>एकमुष्ठ</option>
                                            <?php }
                                            
                                            ?><?php
                                            if(!empty($_GET['id']))
                                            {
                                            ?>
                                            <option value="1" <?php if($data->type==1){ echo 'selected="selected"';}?>>एकमुष्ठ</option>
                                            <?php }
                                            
                                            ?>
                                            <option value="2"  <?php if($data->type==2){ echo 'selected="selected"';}?>>योजना अनुसार</option>
                                        </select>
                         
                                    </div>
                                    <div class="titleInput" id="id_heading" style="display: none;">योजना दर्ता नं :</div>
                                    <div class="newInput" id="id_value" style="display: none;"> <input type="text" id="plan_id_contingency" name="plan_id" value="<?php echo $data->plan_id;?>" ></div>
                                    
                                    <div class="titleInput" id="id_name" style="display: none;">योजनाको नाम  :</div>
                                    <div class="newInput" id="id_name_value" style="display: none;"> </div>
                                    
                                    <div class="titleInput">कन्टेन्जेन्सी कट्टी प्रतिसत:</div>
                                    <div class="newInput"><input type="text"  name="percent" value="<?php echo $data->percent;?>" required></div>
                                    
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                     <td class="myCenter"><strong>प्रकार</strong></td>
                                     <td class="myCenter"><strong>योजना दर्ता नं </strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम  </strong></td>
                                     <td class="myCenter"><strong>कन्टेन्जेन्सी कट्टी प्रतिसत</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):
                                   if($result->type==1){  $name="एकमुष्ठ";}
                                  else if($result->type==2)
                                   {$name="योजना अनुसार";}
                                   else{$name="";}
                                   $details = Plandetails1::find_by_id($result->plan_id);
?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                     <td class="myCenter"><?php echo $name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->plan_id);?></td>
                                    <td class="myCenter"><?php echo $details->program_name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->percent);?></td>
                                    <form method="post" action="contingency_delete.php">
                                    <td class="myCenter">
                                        <a href="settings_contingency.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
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