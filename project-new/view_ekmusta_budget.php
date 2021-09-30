<?php  require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
$result=  Ekmustabudget::find_all();
// echo"<pre>";
// print_r($result);
?>
<!-- js ends -->
<title>एकमुस्ट खर्च प्रबिस्टी थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
            <h2 class="headinguserprofile">एकमुस्ट खर्च प्रबिस्टी हेर्नुहोस | <a href="setting_ekmusta_budget.php" class="btn">एकमुस्ट खर्च प्रबिस्टी थप्नुहोस</a> | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>                    
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2>एकमुस्ट खर्च प्रबिस्टी हेर्नुहोस</h2>
                        <div class="userprofiletable">
                        	    	<table class="table table-bordered table-hover">
                                            <tr>
                                                <td class="myCenter"><strong>दर्ता नं.</strong></td>
                                                <td class="myCenter"><strong>योजना / कार्यक्रमको नाम</strong></td>
                                                <td class="myCenter"><strong>बिषयगत क्षेत्रको किसिम</strong></td>
                                                <td class="myCenter"><strong>जम्मा अनुदान </strong></td>
                                                <td class="myCenter"><strong>एकमुस्ट खर्च रकम </strong></td>
                                                <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                                <td class="myCenter"><strong>टिप्पणी र आदेश </td>
                                            </tr>
                                            <?php foreach($result as $data){
                                                $investment=  Plandetails1::find_by_id($data->plan_id);
                                                // echo"<pre>";
                                                // print_r($investment);
?>
                                            <tr>
                                                <td class="myCenter"><?php echo convertedcit($data->plan_id); ?></td>
                                                 <td class="myCenter"><?php echo $investment->program_name; ?></td>
                                                  <td class="myCenter"><?php echo Topicarea::getName($investment->topic_area_id) ;?></td>
                                               <td class="myCenter"><?php echo convertedcit(placeholder($investment->investment_amount)); ?></td>
                                                <td class="myCenter"><?php echo convertedcit(placeholder($data->total_expenditure)); ?></td>
                                                <td class="myCenter"><a href="edit_ekmusta_budget.php?id=<?php echo $data->id;?>" class="btn">सच्याउनुहोस</a></td>
 						<td class="myCenter"><a href="bhuktani_rakam.php?id=<?php echo $data->id;?>" class="btn">टिप्पणी</a></td>                                          
                                            </tr>
                                            <?php } ?>
                                       
                            </table>
                      </div>
                </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>