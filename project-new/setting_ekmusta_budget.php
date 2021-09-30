<?php  require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    $final_result=  Ekmustabudget::find_by_plan_id($_POST['plan_id']);
    $plan_id=$_POST['plan_id'];
    $result=  Plandetails1::find_by_id($plan_id);
//    print_r($result);exit;
}
if(isset($_POST['save']))
{
    $data=new Ekmustabudget();
    $data->plan_id=$_POST['plan_id'];
   $data->total_expenditure=$_POST['total_expenditure'];
   
    if($data->save())
    {
        echo alertBox("डेटा थप सफल ","view_ekmusta_budget.php");
    }
   
}

?>
<!-- js ends -->
<title>एकमुस्ट खर्च प्रबिस्टी थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">एकमुस्ट खर्च प्रबिस्टी थप्नुहोस | <a href="view_ekmusta_budget.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<h1>एकमुस्ट खर्च प्रबिस्टी थप्नुहोस</h1>
                                    <div class="titleInput">दर्ता नं.</div>
                                    <div class="newInput"><input type="text"  name="plan_id"  required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                   
                                    </form>
                            <?php if(isset($_POST['submit'])){
                                if(!empty($final_result)){
                                    echo "<h3>यस योजनाको एकमुस्ट खर्च प्रबिस्टी भरिएको छ ..|</h3>";
                                }
                                else
                                {
                                ?>
                            <form method="post">
                                <div class="inputWrap">
                                	<h1>एकमुस्ट खर्च प्रबिस्टी थप्नुहोस</h1>
                                    <div class="titleInput">जम्मा अनुदान:</div>
                                    <div class="newInput"><input type="text"  name="investment_amount" readonly="true" value="<?php echo  $result->investment_amount;?>"  required></div>
                                    <div class="titleInput">एकमुस्ट खर्च:</div>
                                    <div class="newInput"><input type="text"  name="total_expenditure" value=""  required></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="save" value="सेव गर्नुहोस" class="btn">
                                   <input  type="hidden" name="plan_id" value="<?=$plan_id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                
                            </form>
                        
                                
                                
                                
                                <?php 
                                }
                                } ?>

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>