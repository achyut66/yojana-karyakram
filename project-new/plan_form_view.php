<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php 
   $search_result = array(0=>"",1=>"");
  $search_text=" ";
  $search_ward="";
  if(isset($_GET['submit']))
  {
       $search_text=$_GET['search_text'];
       $search_ward=$_GET['search_ward'];
       if(!empty($search_text))
       {
      $sql="select * from plan_details1 where id=".$search_text;
     
      
       }
       if(!empty($search_ward))
        {
            $sql ="select * from plan_details1 where  ward_no=".$search_ward;
          
            
        }
        $search_result[1] = Plandetails1::find_by_sql($sql);
  }
  if(isset($_GET['type']))
  {
  	$plan_update = Plandetails1::find_by_id($_GET['update_id']);
  	$plan_update->type = 1 - $plan_update->type;
  	$plan_update->save();
  }
(isset($_GET['page_no']))? $page_no=$_GET['page_no'] : $page_no=1;
            if(!isset($_GET['search_text']))
            {
                     $search_result =  Plandetails1::set_page_query($page_no,20,"plan_form_view.php");
                    // print_r//provides result in array
                         $a = $page_no -1;
                         if($page_no>1 && empty($search_result[1])){//empty checks if key 1 of result array is empty
                             $link="plan_form_view.php?page_no=".$a;
                             redirect($link);
                         }
            }
            
$mode= getUserMode();
$user = getUser();

$user_ward = $user->ward;
//print_r($user_ward);
$plan_details_ward = Plandetails1::find_by_sql("select * from plan_details1 where ward_no =".$user_ward);
// echo "<pre>";
// print_r($plan_details_ward);
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>आयोजनाको विनियोजन श्रोत  :: <?php echo SITE_SUBHEADING;?></title>
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
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजना / कार्यक्रम विवरण  | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>
                   
                    <div class="OurContentFull">
                    	
                        <form method="get" >
                            <div class="inputWrap">
                            	<h1>योजना / कार्यक्रम विवरण</h1>
                                <div class="titleInput">दर्ता नं :</div>
                                <div class="newInput"><input type="text" name="search_text"  value="<?php echo $search_text;?>"/></div>
                                <div class="titleInput">वार्ड नं :</div>
                                <div class="newInput"><input type="text" name="search_ward"  value="<?php echo $search_ward;?>"/></div>
                                <div class="saveBtn"><input type="submit" name="submit" value="खोज्नुहोस" class="btn" /> | <a class="btn" href="plan_form_view.php">रद्द गर्नुहोस </a></div>
                                
                            	<div class="myspacer"></div>
                            </div><!-- input wrap ends -->
					</form>
                        
                     <table class="table table-bordered table-hover">
                                <tr>   
                                    <td class="myCenter">दर्ता नं </td>
                                    <td class="myCenter">नाम </td>
                                    <td class="myCenter">किसिम</td>
                                    <td class="myCenter">बिषयगत क्षेत्रको किसिम</td>
                                    <td class="myCenter">शिर्षकगत किसिम:</td>
                                    <td class="myCenter">उपशिर्षकगत किसिम:</td>
                                    <td class="myCenter">अनुदानको किसिम:</td>
                                    <td class="myCenter">विनियोजन किसिम:</td>
                                    <td class="myCenter">वार्ड नं :</td>
                                    <td class="myCenter">अनुदान रु :</td>
                                    <?php if($mode=="superadmin"):?>
                                    <td class="myCenter">सच्याउनुहोस् </td>
                                    <?php endif;?>
                                    <td class="myCenter">टुक्राउनुहोस् </td>
                                    
                                </tr>
                                <?php foreach($search_result[1] as $data):?>
                                <?php if($mode=="superadmin"){?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter">
                                    <form method="get">
                                    	<select name="type"  onchange="form.submit();">
                                    		<option value="0" <?php if($data->type==0){?> selected="selected" <?php } ?>>योजना</option>
                                    		<option value="1" <?php if($data->type==1){?> selected="selected" <?php } ?>>कार्यक्रम</option>
                                    	</select>
                                    	<input type="hidden" name="update_id" value="<?=$data->id?>" />
                                    	<input type="hidden" name="page_no" value="<?=$page_no?>" />
                                    </form>
                                    </td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>    
                                    <td class="myCenter"><a href="plan_form_edit.php?page_no=<?php echo $page_no;?>&id=<?php echo $data->id;?>" class="btn">सच्याउनुहोस् </a></td>
                                    <td class="myCenter">  <a class="btn" href="plan_form.php?break_plan_id=<?= $data->id ?>">टुक्राउनु होस्</a> </td>
                                    </tr>
                                    <?php }else{?>
                                    
                                    <?php foreach($plan_details_ward as $plan_details_ward)://echo"<pre>";print_r($plan_details_ward);?>
                                    
                                    <tr>
                                    <td class="myCenter"><?php echo convertedcit($plan_details_ward->id);?></td>
                                    <td class="myCenter"><?php echo $plan_details_ward->program_name;?></td>
                                    <td class="myCenter">
                                    <form method="get">
                                    	<select name="type"  onchange="form.submit();">
                                    		<option value="0" <?php if($data->type==0){?> selected="selected" <?php } ?>>योजना</option>
                                    		<option value="1" <?php if($data->type==1){?> selected="selected" <?php } ?>>कार्यक्रम</option>
                                    	</select>
                                    	<input type="hidden" name="update_id" value="<?=$plan_details_ward->id?>" />
                                    	<input type="hidden" name="page_no" value="<?=$page_no?>" />
                                    </form>
                                    </td>
                                    <td class="myCenter"><?php echo Topicarea::getName($plan_details_ward->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($plan_details_ward->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($plan_details_ward->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareaagreement::getName($plan_details_ward->topic_area_agreement_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($plan_details_ward->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($plan_details_ward->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($plan_details_ward->investment_amount);?></td> 
                                    <td class="myCenter"> <a class="btn" href="plan_form.php?break_plan_id=<?= $plan_details_ward->id ?>">टुक्राउनु होस्</a> </td>
                                </tr>
                                <?php endforeach;}?>
                         <?php endforeach;?>
                         <tr>
                              <td colspan="8">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder(Plandetails1::get_total_investment()));?></td>
                             <td colspan="2">&nbsp; </td>
                         </tr>
                     </table>
                    
                      <?php
                echo $search_result[0];//pagination html exist in key 0 of result array
?>
                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
