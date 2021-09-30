<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}

$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();?>
<?php include("menuincludes/header.php"); ?>
<?php
$plan_type="";
$topic_area_id="";
$type="";
$total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
$counted_result = getOnlyRegisteredPlans();

if(isset($_POST['submit']))
{   
//    print_r($_POST);exit;
   
    $fiscal_id=$_POST['fiscal_id'];
    
    $topic_area_id=$_POST['topic_area_id'];
   
//    $sql="select * from plan_details1 where fiscal_id=$fiscal_id and type=$type and topic_area_id=$topic_area_id and topic_area_type_id=$topic_area_type_id and topic_area_type_sub_id=$topic_area_type_sub_id";
//    $result=  Plandetails1::find_by_sql($sql);
    $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
   //echo "<pre>"; print_r($topic_area_type_ids); echo "</pre>"; exit;

}

?>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"> मुख्य रिपोर्ट हेर्नुहोस  </h2>
            <div class="OurContentLeft">
                 <?php include("menuincludes/report_dashboard.php");?>
            </div>	
             
            <div class="OurContentRight">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3>मुख्य रिपोर्ट हेर्नुहोस </h3>
                  <form method="post">
                    <table class="table table-bordered">
                                  <tr>
                                        <td>आर्थिक वर्ष </td>
                                        <td>
                                            <select name="fiscal_id">
                                                <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($fiscals as $data):?>
                                                <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                  </tr>
                                  <tr>
                                            <td>योजनाको बिषयगत क्षेत्रको किसिम: </td>
					    <td>
                                                <select name="topic_area_id" id="topic_area_id" required>
                                                        <option value="">--छान्नुहोस्--</option>
                                                                 <?php foreach($topic_area as $topic): ?> 
                                                        <option value="<?php echo $topic->id?>" <?php if($topic_area_id==$topic->id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
                                                             <?php endforeach; ?>
                                                </select>
                                            </td>
                                  </tr>
                                    
                                          
                                           <tr>
                                               <td>&nbsp;</td>
                                               <td> <input type="submit" name="submit" value="खोज्नुहोस" class="submithere"></td>
                                           </tr>
                    </table>
                      
                </form>
                    
                    
                    
            <?php if(isset($_POST['submit'])):?>              
                 <div class="myPrint"><a target="_blank" href="mainreport_final.php?topic_area_id=<?php echo $topic_area_id;?> & topic_area_type_id=<?php echo $topic_area_type_id;?>">प्रिन्ट गर्नुहोस</a></div><br><br>  
                 <div style="text-align:center;">
                                                        <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                                                 <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>
                                            
                                               
                 </div><br><br>  
             <table class="table table-bordered table-responsive mytable"> 
            <strong> <span  style="text-align:left;"> <?php echo Topicarea::getName($_POST['topic_area_id']);?></span></strong><br>
                  <tr>
                                                <th>सिनं</th>
                                                <th>योजनाको नाम</th>
                                                <th>वडा नं</th>
                                                <th>अनुदानको किसिम</th>
                                                <th>योजनाको अनुदान रु</th>
                                                <th>योजनाको हाल सम्म लागेको भुक्तानी</th>
                                                <th>योजनाको कुल बाँकी रकम</th>
                                                                    
                                              </tr>
    
           <?php 
           
           foreach($topic_area_type_ids as $topic_area_selected)
                         { ?>
                                  
                          
                            
                          
                          
                           <tr >            
                               <td colspan="7"><div style="text-align:center;">
                                               <strong> <span  style="text-align:center;"><?php echo Topicareatype::getName($topic_area_selected); ?></span></strong><br>
                                   </div></td>
                           </tr>
                           <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,0);  ?>
                                         <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                      
                    
                                                        $sql = "select * from plan_details1 where type=0 and topic_area_id=".$topic_area_id." 
                                                            and topic_area_type_id=".$topic_area_selected
                                                 .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                                 .          " and fiscal_id=".$fiscal_id;    
                                                        $result =  Plandetails1::find_by_sql($sql);
                                                  
                                                         
                                                        ?>
                                                        <?php 
                                                        
                                                        $total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
                                                        ?>
   
                                                    
<?php if(!empty($result)):  
                                 $final_array=$counted_result['final_count_array'];?>
                       
                                              <tr> <td colspan="7"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
                                       
                                          
                                             


                                              <?php

                                              $j=1; 
                                            foreach($result as $data)
                                            { 
                                            
                                                      if(in_array($data->id, $final_array))
                                                            {
                                                                $net_payable_amount=$data->investment_amount;
                                                                 $remaining_amount=0; 
                                                            }
                                                            else
                                                            {
                                                                 $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                            }
                                      $total_investment+=$data->investment_amount;
                                                  $total_net_payable_amount +=$net_payable_amount;
                                                 $total_remaining_amount +=$remaining_amount;
                                      
                                      ?>

                                                      <tr>
                                                          
                                                        <td><?php echo convertedcit($j);?></td>
                                                        <td><?php echo $data->program_name; ?></td>
                                                        <td><?php echo convertedcit($data->ward_no);?></td>
                                                        <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                                        <td><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                                        <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                                        <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
                                                       
                                                      </tr>
                                                       
                                                      <?php

                                                      $j++ ; 
                                                      
                                            }
                                  endif;
                                  
                                            ?>  
                                             
                 <tr>
                                                         <td colspan="4">जम्मा</td>
                                                         <td><?= convertedcit(placeholder($total_investment)) ?></td>
                                                         <td><?= convertedcit(placeholder($total_net_payable_amount )) ?></td>
                                                         <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
                                                      </tr>                 
                     <?php endforeach;
                } ?>
                
                                                    
                                                      </table><br><br>
        <?php endif;?>                   
                     
            </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>