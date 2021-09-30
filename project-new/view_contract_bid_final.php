<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$result= Contractbidfinal::find_by_plan_id($_SESSION['set_plan_id']);
//print_r($result);exit;
$datas= Contractinvitationentry::find_by_plan_id($_SESSION['set_plan_id']);
        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का खोलिएको फारम हेर्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>
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
                    <h2 class="headinguserprofile">ठेक्का खोलिएको फारम हेर्नुहोस | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	<!--<h2>ठेक्का खोलिएको फारम हेर्नुहोस</h2>-->
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                    <div class="settingsMenu2"><a href="contract_bid_final.php">ठेक्का खोलिएको फारम थप्नुहोस +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div>
                            <div class="myMessage"><?php echo $message;?></div>
                                                        <?php if(!empty($result)):?>
                                                        <h3>ठेक्का खोलिएको फारम हेर्नुहोस</h3>
                                                        <a href="edit_contract_bid_final.php?id=<?php echo $_SESSION['set_plan_id'];?>"><button class="btn">सच्याउनुहोस</button></a><br><br>
                              <table class="table table-bordered">
                                        <tr>
                                            <th>सि. नं.</th>
                                            <th>निर्माण ब्यवोसायीको नाम</th>
                                           <th>बैंकको नाम </th>
                                            <th>ठेगाना </th>
                                            <th>बैंक ग्यारेन्टी रकम</th>
                                            <th>बैंक ग्यारेन्टी रकम अवधि</th>
                                            <th>धरौटी खातामा जम्मा गरिएको रकम </th>
                                            <th>मिति</th>
                                            <th>कैफियत</th>
                                            
                                          </tr>
                                          <?php $i=1; foreach($result as $data):
                                              
                                              if($data->bill_type==1)
                                              {
                                                  $bill_type="भ्याट सहित";
                                              }
                                              else
                                              {
                                                   $bill_type="भ्याट बाहेक";
                                              }
                                               $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                                          ?>
                                          <tr>
                                                <td><?php echo convertedcit($i); ?></td>
                                                <td><?php echo $contractor_details->contractor_name;?></td>
                                                 <td><?php echo $data->bank_name;?></td>
                                                  <td><?php echo $data->bank_address;?></td>
                                                   <td><?php echo convertedcit($data->bank_guarentee);?></td>
                                                <td><?php echo convertedcit($data->bank_guarentee_date);?></td>
                                               <td><?php echo convertedcit(placeholder($data->dharauti_amount));?></td>
                                                <td><?php echo convertedcit($data->created_date);?></td>
                                                 <td><?php echo $data->details;?></td>
                                              </tr>
                                          <?php $i++;endforeach;?>
                                        </table>
                                                        <?php endif;?>
                                          
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>