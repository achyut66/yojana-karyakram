<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$data1= Contractinfo::find_by_plan_id($_SESSION['set_plan_id']);
//print_r($data);
	$datas= Contractinvitationentry::find_by_plan_id($_SESSION['set_plan_id']);
//        print_r($datas);exit;
        
if(isset($_POST['submit']))
{
//    echo count($_POST['bill_type']);
//    echo "<pre>";print_r($_POST);echo "</pre>";exit;
   for($i=0;$i < count($_POST['bid_amount']);$i++)
   {
//       echo $_POST['bid_type'][$i+1];exit;
        $j=$i+1;
        $data = new Contractentryfinal();
        $data->bill_type = $_POST['bill_type-'.$j];
        $data->bid_amount=$_POST['bid_amount'][$i];
        $data->total_bid_amount=$_POST['total_bid_amount'][$i];
//        $data->reduce_rate=$_POST['reduce_rate'][$i];
//        $data->final_reduced_amount=$_POST['final_reduced_amount'][$i];
        $data->created_date=$_POST['created_date'];
        $data->created_date_english = DateNepToEng($_POST['created_date']);
        $data->contractor_id=$_POST['contractor_id'][$i];
        $data->plan_id=$_POST['plan_id'];
        $data->save();
   }
   echo alertBox("थप सफल ","view_contract_entry_final.php");
}

        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का कबोल  फारम  :: <?php echo SITE_SUBHEADING;?></title>
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
                    <h2 class="headinguserprofile">ठेक्का कबोल  फारम | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>ठेक्का कबोल  फारम</h2>
                        <div class="">
                        	<div class="settingsMenuWrap1">
                                   
                            </div>
                            <div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                 <form method="post">
                                    	<table class="table table-bordered">
                                          <tr>
                                             <th>सि. नं.</th>
                                            <th>निर्माण ब्यवोसायीको नाम</th>
                                            <th> प्रकार छान्नुहोस्</th>
                                            
                                            <th>ठेक्का कबोल गरेको कुल रकम </th>
                                            <th>पी.एस रकम</th>
                                            <th>कुल रकम </th>
                                            <th>बैंक ग्यारेन्टी पत्र </th>
                                            <th>धरौटी खातामा जम्मा गरिएको रकम </th>
                                          </tr>
                                          <?php $i=1;foreach($datas as $data): 
                                              $result= Contractordetails::find_by_id($data->contractor_id);
                                          $contract_result=Contractbidfinal::find_by_contractor_id($data->contractor_id,$_SESSION['set_plan_id']);
//                                          print_r($contract_result);exit;
                                          $invest_details=2;
                ?>
                                          <tr>
                                                        <td><?php echo convertedcit($i); ?></td>
                                                        <td><?php echo $result->contractor_name;?></td>
                                                        <td id="bill_type_row-<?=$i?>">
                                                            <input type="radio"  name="bill_type-<?=$i?>" class="radioBtnClass" value="1" /> &nbsp;भ्याट सहित &nbsp;&nbsp;<br> 
                                                            <input type="radio" name="bill_type-<?=$i?>" class="radioBtnClass" value="2" required <?php if($invest_details == 2){ echo 'checked="checked"';  } ?> /> &nbsp;भ्याट बाहेक</td>
                                                         <td><input type="text" class="myWidth100" id="bid_amount-<?=$i?>" name="bid_amount[]" /></td>
                                                         <td><input type="text" id="ps_amt" value="<?php echo $data1->ps;?>"></td>
                                                         <td><input type="text" class="myWidth100" id="total_bid_amount-<?=$i?>" name="total_bid_amount[]" /></td>
<!--                                                          <td><input type="text" class="myWidth100" id="reduce_rate-<?=$i?>" name="reduce_rate[]" /></td>
                                                           <td><input type="text" class="myWidth100" id="final_reduced_amount-<?=$i?>" name="final_reduced_amount[]" /></td>-->
                                                           <td><textarea lass="myWidth100" name="bank_guarentee[]"><?php echo $contract_result->bank_guarentee;?></textarea></td>
                                                           <td><input type="text" class="myWidth100" name="dharauti_amount[]" value="<?php echo $contract_result->dharauti_amount;?>"/></td>
                                                    <input type="hidden" name="plan_id" value="<?php echo $data->plan_id?>">
                                                    <input type="hidden" name="contractor_id[]" value="<?php echo $data->contractor_id?>">
                                                    </tr>
                                                
                                          <?php $i++;endforeach; ?>
                                                    <tr>
                                                        <td colspan="8">  <input type="text" name="created_date" readonly="true" id="nepaliDate10"/></td>
                                                    </tr>
                                        </table>
                                                           
                                                            <input type="submit" value="सेभ गर्नुहोस" name="submit" class="btn"/> 
                               </form>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>   