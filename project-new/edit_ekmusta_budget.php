<?php  require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
    $id=$_GET['id'];
    $data=  Ekmustabudget::find_by_id($id);
    $result=  Plandetails1::find_by_id($data->plan_id);
if(isset($_POST['save']))
{
    $data=Ekmustabudget::find_by_id($_POST['update_id']);
    $data->total_expenditure=$_POST['total_expenditure'];
   
    if($data->save())
    {
        echo alertBox("डेटा थप सफल ","view_ekmusta_budget.php");
    }
   
}

?>
<!-- js ends -->
<title>एकमुस्ट खर्च प्रबिस्टी सच्याउनुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">एकमुस्ट खर्च प्रबिस्टी सच्याउनुहोस | <a href="view_ekmusta_budget.php" class="btn">पछि जानुहोस </a></h2>
             <div class="myMessage"><?php echo $message;?></div>
             <div class="OurContentFull">
                 <div class="userprofiletable">
                      
                            <form method="post">
                                <div class="inputWrap">
                                	<h1>एकमुस्ट खर्च प्रबिस्टी सच्याउनुहोस</h1>
                                    <div class="titleInput">जम्मा अनुदान : </div>
                                    <div class="newInput"><input type="text"  name="investment_amount" readonly="true" value="<?php echo  $result->investment_amount;?>"  required></div>
                                    <div class="titleInput">एकमुस्ट खर्च : </div>
                                    <div class="newInput">
                                    	<input type="text"  name="total_expenditure" value="<?php echo $data->total_expenditure;?>"  required>
                                    </div>
                                    <div class="saveBtn myWidth100">
                                    	<input type="submit" name="save" value="सेभ गर्नुहोस" class="btn">
                                   		<input  type="hidden" name="update_id" value="<?=$data->id;?>" />
                                    </div>
                                    <div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                
                                
                            </form>
                        
                      </div>
                </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>