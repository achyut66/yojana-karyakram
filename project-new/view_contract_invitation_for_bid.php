<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$result= Contractinvitationforbid::find_by_plan_id($_SESSION['set_plan_id']);
        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का बोलपत्र बिक्रि किताब  हेर्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>
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
                    <h2 class="headinguserprofile">ठेक्का बोलपत्र बिक्रि किताब  हेर्नुहोस | <a href="contract_invitation_for_bid.php" class="btn">ठेक्का बोलपत्र बिक्रि किताब फारम थप्नुहोस +</a> |<a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>ठेक्का बोलपत्र बिक्रि किताब  हेर्नुहोस</h2>
                        <div class="userprofiletable">
                        	<div class="myPrint"><a href="print_contract_invitation_for_bid.php?plan_id=<?php echo $_SESSION['set_plan_id'];?>" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                             <div class="myspacer"></div><br>
							<div class="myMessage"><?php echo $message;?></div>
                              
                              <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"><strong>दर्ता नं</strong></td>
                                            <td class="myCenter"><strong>निर्माण ब्यवोसायीको नाम </strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क</strong> </td>
                                            <td class="myCenter"><strong>पेश गरेको कागजातको वर्ग</strong></td>
                                             <td class="myCenter"><strong>रसिद नं.</strong></td>
                                             <td class="myCenter"><strong>बोलपत्र दस्तुर</strong></td>
                                             <td class="myCenter"><strong>बोलपत्र बिक्रि मिति</strong></td>
                                             <td class="myCenter"><strong>सच्याउनुहोस</strong></td>

                                          </tr>
                                          <?php foreach($result as $data):
                                              $document_type=array("1"=>"क","2"=>"ख","3"=>"ग","4"=>"घ","5"=>"ङ","6"=>"च");
                                              $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                                              
?>
                                          <tr>
                                              <td class="myCenter"><?php echo convertedcit($data->bid_id);?></td>
                                              <td class="myCenter"><?php echo $contractor_details->contractor_name;?></td>
                                              <td class="myCenter"><?php echo $contractor_details->contractor_address;?></td>
                                              <td class="myCenter"><?php echo convertedcit($contractor_details->contractor_contact);?></td>
                                              <td class="myCenter"><?php echo $document_type[$data->document_type];?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->bill_no);?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->bid_fee);?></td>
                                              <td class="myCenter"><?php echo convertedcit($data->contract_date);?></td>
                                              <td class="myCenter"><a href="edit_contract_invitation_for_bid.php?id=<?php echo $data->id;?>" class="btn">सच्याउनुहोस</a></td>
                                          </tr>
                                          <?php endforeach;?>
                                        </table>
                                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>