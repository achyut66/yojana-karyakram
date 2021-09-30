<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
?>

<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = YojanaBank::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new YojanaBank();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->name = $_POST['name'];
    $form_data->ward_no = $_POST['ward_no'];
    $form_data->budget= $_POST['budget'];
    $form_data->remarks = $_POST['remarks'];
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "yojana_bank.php");
    }
}

if(isset($_GET['id']))
{
    $data= YojanaBank::find_by_id($_GET['id']);
   
}
else
{
    $data = YojanaBank::setEmptyObjects();
}
$budget_result= YojanaBank::find_all();
//$final_result = Contingency::find_by_sql("select * from contingency where type=1");
?>
<!-- js ends -->
<title> <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile"> योजना बैक  </h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2> योजना बैक  </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                    <div class="titleInput">योजनाको नाम :</div>
                                    <div class="newInput">
                                        <input type="text" name="name" value="<?=$data->name?>"/>
                                    </div>
                                    <div class="titleInput" id="id_heading" >वार्ड नं :</div>
                                    <div class="newInput" id="id_value" > <input type="text"  name="ward_no" value="<?=$data->ward_no?>" /></div>
                                    
                                    <div class="titleInput" id="id_name">अनुमानित बजेट :</div>
                                    <div class="newInput" id="id_name_value" > <input type="text"  name="budget"  value="<?=$data->budget?>"/> </div>
                                    
                                    <div class="titleInput">कैफियत</div>
                                    <div class="newInput"><textarea name="remarks"><?=$data->remarks?></textarea></div>
                                    <input type="hidden" value="update_id" value="<?=$data->id?>"/>
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                     <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                     <td class="myCenter"><strong>वार्ड नं  </strong></td>
                                    <td class="myCenter"><strong>अनुमानित बजेट </strong></td>
                                     <td class="myCenter"><strong>कैफियत</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):
                                 
?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                     <td class="myCenter"><?php echo $result->name;?></td>
                                    <td class="myCenter"><?php echo $result->ward_no;?></td>
                                    <td class="myCenter"><?php echo $result->budget;?></td>
                                    <td class="myCenter"><?php echo $result->remarks;?></td>
                                    <td class="myCenter"><a href="yojana_bank.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a></td>
                                </tr>
                                <?php $i++; 
                                endforeach;?>
                            </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>