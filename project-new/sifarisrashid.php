<?php require_once("includes/initialize.php"); 
		require_once("zonelist.php");
	?>
<?php
	
	if(!$session->is_logged_in()){ redirect_to("logout.php");}
	if(isset($_POST['submit']))
	{
		
	}

	$fiscals = FiscalYear::find_all();
	$parent_topics = Topic::find_parent_topic();
		
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>नगदी रशिद  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">नगदी रशिद </h2>
                    <div class="OurContentLeft">
                   	  <?php include("menuincludes/nagadirashidmenu.php"); ?>
                    </div><!-- our content left ends -->
                    <div class="OurContentRight1">
                    	<h2>नगदी रशिद काट्नुहोस</h2>
                        <div class="userprofiletable">
                        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" id="myform" >
                            <table class="table table-bordered" id="mytable">
                                 
                                  <tr>
                                    <td >करदाताको नाम  :</td>
                                    <td colspan="3"><input type="text"  name="name" required></td>
                                    
                                  </tr>
                                  
                                  <tr>
                                    <td>अञ्चल : </td>
                                    <td><select name="zone" id="zone" required>
                                    		<?php $i = 1; foreach($zonelist as $key => $value): ?>
                                            		<?php if($i==1) { $selected_zone = $value; } ?>
                                            		<option value="<?=$value?>"><?=$value?> </option>
                                            <?php $i++; endforeach; ?>       
                                        </select>                                    </td>
                                    <td>मिति : </td>
                                    <td><input type="text" id="nepaliDate5"   name="date_nepali" value="<?php echo convertedcit(generateCurrDate()); ?>" required></td>
                                  </tr>
                                  <tr>
                                    <td>जिल्ला :</td>
                                    <td id="district"><select name="district">
                                    			<?php 
                                    					$districts = $zones[$selected_zone];
														foreach($districts as $district): ?> 
													<option value="<?php echo $district; ?>"><?php echo $district; ?></option>
                                                    <?php endforeach; ?>
                                    			</select>                                    </td>
                                    <td>गा. वि. स. / न. पा : </td>
                                    <td><input type="text"  name="metro" value="<?php echo SITE_LOCATION;?>" required></td>
                                  </tr>
                                  <tr>
                                    <td>वडा : </td>
                                    <td><input type="text"  name="ward_no" value="6" required> </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
								  
								  <tbody class="calculate">
                                  <tr>
                                    <td colspan="2">
										मुख्य शीर्षक: 
                                    <input type="text" name="main_topic_no[]" class="main_topic_no_1" /></td>
                                    <td colspan="2" id="parent_topic_1">                                    </td>
                                   </tr>
                                   <tr>
                                   <td colspan="2" >
                                   		सहायक शीर्षक: 
                                        <input type="text" class="sub_topic_no_1" name="sub_topic_no[]" />                                   </td>
                                   <td colspan="2" id="sub_topic_1">                                   </td>
                                   </tr>
								   <tr>
                                     <td>परिणाम</td>
                                    <td><input type="text" class="qty_1" name="qty[]" value="1" size="10" /></td>
                                      <td>जम्मा</td>
                                    <td class="total_amount_1"></td>
                                   </tr>
                                   </tbody>
								   <tr>
								  		<td colspan="4"  class="submithere"><a href="#" id="add_calc">Add More</a></td>
								  </tr>
								   <tr>
								   		<td colspan="2">कुल जम्मा</td>
										<td colspan="2"><input type="text"  id="net_total" name="net_total" /></td>
								   </tr>
								   	<tr>
									 <td >&nbsp;</td>
                                     <td colspan="3" ><input type="submit" name="submit" value="प्रिन्ट गर्नुहोस " class="submithere" /></td>	
                                   </tr>
                                </table>
						  </form>
                        </div><!-- our content right ends -->                     

                        
                    </div><!-- our content right 1 ends -->
                    <div class="OurContentFarRight">
                        	<h2 class="headinguserprofile1">शिर्षकहरु:</h2>
                            <div class="farRight">
                            	<table class="table table-bordered">
                                          <tr>
                                          	
                                            <th>शिर्षक नं.</th>
                                            <th>शिर्षकको नाम</th>
                                            
                                            
                                          </tr>
                                          <?php $parent_topics = Topic::find_parent_topic(); foreach($parent_topics as $parent): ?>
                                          	<tr>
                                            	
                                            	<td colspan="2"><strong><?php echo convertedcit($parent->topic_no)." . ". $parent->topic_name; ?></strong></td>
                                                
                                            </tr>
                                            <?php $topics = Topic::find_by_parent_id($parent->id);
												foreach($topics as $topic)
												{
												?>
                                                	<tr>
                                                    	<td align="right"><?php echo convertedcit($topic->topic_no); ?></td>
                                                        <td><?php echo $topic->topic_name; ?>( <?php echo convertedcit($topic->rate); ?> )</td>
                                                        
                                                       
                                                    </tr>
                                                <?php
												
												}
											 ?>
                                          <?php endforeach; ?>
                                        </table>
                            </div><!-- far right ends -->
                        </div><!-- our content far right ends -->
                  
                </div>
                
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>