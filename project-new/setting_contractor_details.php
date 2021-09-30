<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Contractordetails::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Contractordetails();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->contractor_name= $_POST['contractor_name'];
     $form_data->contractor_address= $_POST['contractor_address'];
      $form_data->contractor_contact= $_POST['contractor_contact'];
      $form_data->pan_no            = $_POST['pan_no'];
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "setting_contractor_details.php");
    }
}

if(isset($_GET['id']))
{
    $data= Contractordetails::find_by_id($_GET['id']);
}
else
{
    $data =  Contractordetails::setEmptyObjects();
}
$budget_result=  Contractordetails::find_all();
?>
<!-- js ends -->
<title>निर्माण ब्यवोसायी थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">निर्माण ब्यवोसायी थप्नुहोस |  <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                 <div class="myMessage"><?php echo $message;?></div>
                 <div class="OurContentFull">
                    
                        <h2>निर्माण ब्यवोसायी थप्नुहोस</h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<div class="titleInput">निर्माण ब्यवोसायीको नाम : </div>
                                    <div class="newInput"><input type="text" name="contractor_name"  required  value="<?php echo $data->contractor_name;?>"  /></div>
                                    <div class="titleInput">प्यान नं. : </div>
                                    <div class="newInput"><input type="text" name="pan_no"  required  value="<?php echo $data->pan_no;?>"  /></div>
                                    <div class="titleInput">ठेगाना : </div>
                                    <div class="newInput"><input type="text" name="contractor_address"  required   value="<?php echo $data->contractor_address;?>"/></div>
                                    <div class="titleInput">सम्पर्क : </div>
                                    <div class="newInput"><input type="text" name="contractor_contact"  required   value="<?php echo $data->contractor_contact;?>"/></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn">
                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>निर्माण ब्यवोसायीको नाम </strong></td>
                                    <td class="myCenter"><strong>प्यान नं.</strong></td>
                                     <td class="myCenter"><strong>ठेगाना </strong></td>
                                      <td class="myCenter"><strong>सम्पर्क</strong></td>
                                     <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo $result->contractor_name;?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->pan_no);?></td>
                                    <td class="myCenter"><?php echo $result->contractor_address;?></td>
                                    <td class="myCenter"><?php echo $result->contractor_contact;?></td>
                                    <form method="post" action="contractor_delete.php">
                                    <td class="myCenter">
                                        <a href="setting_contractor_details.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
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