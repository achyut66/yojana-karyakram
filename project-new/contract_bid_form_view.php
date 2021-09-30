<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$datas= Contract_bid::find_by_sql("select * from contract_bid where plan_id=".$_SESSION['set_plan_id']);
//        print_r($datas);exit;
        
if(isset($_POST['submit']))
{
   $bid_result=  Contract_bid::find_by_sql("select * from contract_bid where status=1 and plan_id=".$_POST['plan_id']);
   if(empty($bid_result))
   {
     $result=  Contract_bid::find_by_id($_POST['bid']);
      $result->status=1;
       if($result->save())
       {
           $link="contract_form1.php?id=".$_POST['plan_id'];
           redirect_to($link);
       }
   }
   else
   { 
       $link="contract_bid_form_view.php";
       echo alertBox("ठेक्का कबोल भैसकेको छ ", $link);
   }
}

        ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का बोलिएको रिपोर्ट हेर्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>

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
                                    <div class="settingsMenu2"><a href="contract_bid_form.php">ठेक्का बोलिने फारम थप्नुहोस +</a></div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            <div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                 <form method="post">
                                    	<table class="table table-bordered">
                                          <tr>
                                              <th>छान्नुहोस् </th>
                                            <th>सि. नं.</th>
                                                <th>योजना संचालन गर्ने फर्म/कम्पनी</th>
                                            <th>ठेक्का कबोल गरेको कुल रकम </th>
                                            <th>हटाउनुहोस्</th>

                                          </tr>
                                          <?php $i=1;foreach($datas as $data): 
                                              
                ?>
                                          <tr>
                                                        <td><input type="radio" name="bid" value="<?php echo $data->id;?>"<?php if($bid_result->id==$data->id){ echo 'selected="selected"';}?>></td>
                                                        <td><?php echo convertedcit($i); ?></td>
                                                        <td><?php echo Enlist::getName1($data->enlist_id);?></td>
                                                        <td><?php echo $data->bid_amount;?></td>
                                                        <td><a href="delete_contract_bid.php?id=<?php echo $data->id;?>">हटाउनुहोस्</a></td>
                                                    <input type="hidden" name="plan_id" value="<?php echo $data->plan_id?>">
                                                    <input type="hidden" name="update_id" value="<?php echo $data->id?>">
                                                    </tr>
                                                
                                          <?php $i++;endforeach; ?>
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