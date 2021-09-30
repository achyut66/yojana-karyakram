<?php  require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    $final_result= Rule::find_by_plan_id($_POST['plan_id']);
    $plan_id=$_POST['plan_id'];
    $result=  Plandetails1::find_by_id($plan_id);
}
if(isset($_POST['save']))
{
//    print_r($_POST);exit;
    if($_POST['update']==1)
    {
        $result= Rule::find_by_plan_id($_POST['plan_id']);
        foreach($result as $data)
        {
            $data->delete();
        }
    }
    for($i=0;$i<count($_POST['rule']);$i++)
    {
        $data=new Rule();
        $data->rule= $_POST['rule'][$i];
        $data->plan_id = $_POST['plan_id'];
        $data->save();
    }
    
        echo alertBox("डेटा थप सफल ","settings_rules.php");
    
}
echo $_POST['id'];
?>
<!-- js ends -->
<title>सर्तहरु थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">सर्तहरु थप्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>सर्तहरु थप्नुहोस</h1>
                                    <div class="titleInput">दर्ता नं.</div>
                                    <div class="newInput"><input type="text"  name="plan_id"  value="<?php echo $_GET['id'];?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                   
                                    </form>
                            <?php if(isset($_POST['submit'])){?>
                               
                            <form method="post">
                                <div class="inputWrap">
                                	<h1>सर्तहरु थप्नुहोस</h1>
                                        
                                    <div class="titleInput">योजनाको नाम</div> 
                                    <div class="newInput"><input type="text"  name="program_name" readonly="true" value="<?php echo  $result->program_name;?>"  required></div>
                                   <div class="titleInput">सर्तहरु हल्नुहोस:</div>
                                    <?php if(!empty($final_result)){
                                  $update=1; $i=1;foreach($final_result as $data):?>
                                  
                                    <div <?php if($i!=1){?> class="remove_rules_details" <?php } ?>><textarea name="rule[]" ><?=$data->rule?></textarea></div>
                                       
                                 <?php  $i++ ; endforeach;
                                }
                                else
                                {
                                    $update=0;
                                ?>
                                    
                                    <div class="newInput"><textarea name="rule[]" placeholder="सर्त हाल्नुहोस "></textarea></div>
                                <?php } ?>
                               
                                    <p id="add_rules"></p>
                                    <input  type="hidden" name="plan_id" value="<?=$plan_id?>"/>
                                    <div class="inputWrap100">
                                            <div class="inputWrap33 inputWrapLeft"><div class="add_more_rules btn myWidth100">थप्नुहोस [+]</div></div>
                                            <div class="inputWrap33 inputWrapLeft"><div class="remove_more_rules btn myWidth100">हटाउनुहोस [-]</div></div>
                                            <div class="inputWrap33 inputWrapLeft"><input type="submit" name="save" value="सेब गर्नुहोस" class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                                            <div class="myspacer"></div>
                                    </div><!-- input wrap 100 ends -->
                           	    </div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                
                            </form>
                        
                                
                                
                                
                                <?php 
                                }
                                 ?>

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>