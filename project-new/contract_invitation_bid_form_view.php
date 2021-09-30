<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$datas= Contractentryfinal::find_by_plan_id($_SESSION['set_plan_id']);
        $new_result=  Contractentryfinal::find_by_status(1,$_SESSION['set_plan_id']);
//        print_r($new_result);exit;
if(isset($_POST['submit']))
{
   $bid_result=  Contractentryfinal::find_by_status(1,$_POST['plan_id']);
//   print_r($bid_result);exit;
   if(empty($bid_result))
   {
     $result=  Contractentryfinal::find_by_id($_POST['bid']);
      $result->status=1;
      $result->approved_date=$_POST['approved_date'];
      $result->approved_date_english=  DateNepToEng($_POST['approved_date']);
       if($result->save())
       {
           $link="contract_form1.php?id=".$_POST['plan_id'];
           redirect_to($link);
       }
   }
   else
   {
       $bid_result->status= 0;
       $bid_result->save();
       $result=  Contractentryfinal::find_by_id($_POST['bid']);
      $result->status=1;
      $result->approved_date=$_POST['approved_date'];
      $result->approved_date_english=  DateNepToEng($_POST['approved_date']);
       if($result->save())
       {
           $link="contract_form1.php?id=".$_POST['plan_id'];
           redirect_to($link);
       }
   }
}

        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का बोलिएको रिपोर्ट हेर्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>
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
                    <h2 class="headinguserprofile">ठेक्का बोलिएको रिपोर्ट हेर्नुहोस | <a href="contract_dashboard.php">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>ठेक्का बोलिएको रिपोर्ट हेर्नुहोस</h2>
                        <div class="userprofiletable">
                        	<div class="settingsMenuWrap1">
                                   
                            </div>
                            <div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                 <form method="post">
                                    	<table class="table table-bordered">
                                          <tr>
                                              <th>छान्नुहोस् </th>
                                            <th>सि. नं.</th>
                                            <th>निर्माण ब्यवोसायीको नाम</th>
                                            <th>ठेक्का कबोल गरेको कुल रकम </th>
                                            

                                          </tr>
                                          <?php $i=1;foreach($datas as $data): 
                                              $result= Contractordetails::find_by_id($data->contractor_id);
                ?>
                                          <tr>
                                                        <td><input type="radio" name="bid" value="<?php echo $data->id;?>"<?php if($data->status==1){ echo 'checked="checked"';}?>></td>
                                                        <td><?php echo convertedcit($i); ?></td>
                                                        <td><?php echo $result->contractor_name;?></td>
                                                        <td><?php echo convertedcit(placeholder($data->total_bid_amount));?></td>
                                                    <input type="hidden" name="plan_id" value="<?php echo $data->plan_id?>">
                                                    <input type="hidden" name="update_id" value="<?php echo $data->id?>">
                                                    </tr>
                                                
                                          <?php $i++;endforeach; ?>
                                                    <tr >
                                                        <td colspan="4">  <input type="text" name="approved_date" readonly="true" id="nepaliDate10" value="<?php echo $new_result->approved_date;?>"/></td>
                                                    </tr>
                                        </table>
                                                            <input type="submit" value="कबोल गर्नुहोस" name="submit" class="btn"/> 
                               </form>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>