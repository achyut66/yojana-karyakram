<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php 
   
  if(isset($_POST['merge']))
  {
     $plan_id = implode("-",$_POST['plan_id']);
     redirect_to("plan_form.php?plan_id=".$plan_id);
  }
$search_result =  Plandetails1::find_by_sql("select * from plan_details1");
           
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना जोड्नुहोस  :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile"></h2>
                   
                    <div class="OurContentFull">
                    	<h2>योजना / कार्यक्रम विवरण  : </h2>
                       
                    <form method="post">
                        <input type="submit" name="merge" value="योजना जोड्नुहोस" class="btn"/><br><br>
                     <table class="table table-bordered table-responsive table-striped">
                                <tr>   
                                    <th>दर्ता नं </th>
                                    <th>नाम </th>
                                    <th>किसिम</th>
                                    <th> बिषयगत क्षेत्रको किसिम</th>
                                    <th>शिर्षकगत किसिम:</th>
                                    <th>उपशिर्षकगत किसिम:</th>
                                    <th>अनुदानको किसिम:</th>
                                    <th>विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                    <th>छान्नुहोस्</th>
                                 
                                </tr>
                                <?php 
                                $total = 0;
                                foreach($search_result as $data):?>
                                <tr>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td>
                                    	<form method="get">
                                    	<select name="type"  onchange="form.submit();">
                                    		<option value="0" <?php if($data->type==0){?> selected="selected" <?php } ?>>योजना</option>
                                    		<option value="1" <?php if($data->type==1){?> selected="selected" <?php } ?>>कार्यक्रम</option>
                                    	</select>
                                    	<input type="hidden" name="update_id" value="<?=$data->id?>" />
                                    	<input type="hidden" name="page_no" value="<?=$page_no?>" />
                                    </form>
                                    </td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><input type="checkbox" name="plan_id[]" value="<?=$data->id?>"</td>
                                    
                                  </tr>
                         <?php 
                         $total+= $data->investment_amount;
                         endforeach;?>
                         <tr>
                              <td colspan="8">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total));?></td>
                             <td >&nbsp; </td>
                         </tr>
                     </table>
            </form>
                        
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
