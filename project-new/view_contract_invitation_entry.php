<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$result= Contractinvitationentry::find_by_plan_id($_SESSION['set_plan_id']);
        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का बोलपत्र दर्ता किताब हेर्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>
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
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">ठेक्का बोलपत्र दर्ता किताब  हेर्नुहोस | <a href="contract_invitation_entry.php" class="btn">ठेक्का बोलपत्र दर्ता किताब फारम थप्नुहोस +</a> | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>ठेक्का बोलपत्र दर्ता किताब हेर्नुहोस</h2>
                        <div class="userprofiletable">
                        	<div class="myPrint"><a href="print_contract_invitation_entry.php?plan_id=<?php echo $_SESSION['set_plan_id'];?>" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                             
                            <div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                                        <?php if(!empty($result)):?>
                              <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"><strong>दर्ता नं</strong></td>
                                            <td class="myCenter"><strong>निर्माण ब्यवोसायीको नाम </strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क</strong> </td>
                                            <td class="myCenter"><strong>बोलपत्र दर्ता मिति</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस</strong></td>

                                          </tr>
                                          <?php foreach($result as $data):
                                              $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                                              
?>
                                          <tr>
                                               <td class="myCenter"><?php echo convertedcit($data->bid_id);?></td>
                                              <td class="myCenter"><?php echo $contractor_details->contractor_name;?></td>
                                              <td class="myCenter"><?php echo $contractor_details->contractor_address;?></td>
                                              <td class="myCenter"><?php echo $contractor_details->contractor_contact;?></td>
                                               <td class="myCenter"><?php echo convertedcit($data->darta_miti);?></td>
                                               <td class="myCenter"><a href="edit_contract_invitation_entry.php?id=<?php echo $data->plan_id;?>&contract_id=<?php echo $data->id;?>" class="btn">सच्याउनुहोस</a></td>
                                          </tr>
                                          <?php endforeach;?>
                                        </table>
                                                        <?php endif;?>
                                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>