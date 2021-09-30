<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$data= Contractinfo::find_by_plan_id($_SESSION['set_plan_id']);
if($data->contract_type==1)
{
    $type="भ्याट सहित";
}
else
{
    $type="भ्याट बाहेक";
}
        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का सूचना प्रकाशन हेर्नुहोस  ::<?php echo SITE_SUBHEADING;?></title>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">ठेक्का सूचना प्रकाशन हेर्नुहोस | <a href="contract_info.php" class="btn">ठेक्का सूचना प्रकाशन थप्नुहोस +</a> | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull">
                    	<h2>ठेक्का सूचना प्रकाशन हेर्नुहोस</h2>
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                                        <?php if(!empty($data)):
                                                            $plan_name=  Plandetails1::find_by_id($data->plan_id);?>
                                                        <h3><?php echo $plan_name->program_name;?></h3>
                              <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"><strong>दर्ता नं</strong></td>
                                            <td class="myCenter"><strong>ठेक्का किसिम </strong></td>
                                            <td class="myCenter"><strong>ठेक्का नं </strong></td>
                                            <td class="myCenter"><strong>ठेक्का रकम</strong> </td>
                                            <td class="myCenter"><strong>पी.एस रकम</strong> </td>
                                            <td class="myCenter"><strong>कुल ठेक्का रकम</strong> </td>
                                            <td class="myCenter"><strong>प्रकाशित मिति</strong></td>
                                            <td class="myCenter"><strong>बोलपत्र दाखिला गर्नुपर्ने अन्तिम मिति</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस</strong></td>

                                          </tr>
                                          <tr>
                                               <td class="myCenter"><?php echo convertedcit($data->plan_id);?></td>
                                              <td class="myCenter"><?php echo $type;?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->thekka_id);?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->amount);?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->ps);?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->contract_amount);?></td>
                                               <td class="myCenter"><?php echo convertedcit($data->created_date);?></td>
                                                <td class="myCenter"><?php echo convertedcit($data->last_entry_date);?></td>
                                               <td class="myCenter"><a href="contract_info.php" class="btn">सच्याउनुहोस</a></td>
                                          </tr>
                                         
                                        </table>
                                                        <?php endif;?>
                                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
        
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>