<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$datas = Programdetails::find_all();
$topic_area_id="";
$topic_area_investment_id="";
$search_text="";
if(isset($_GET['submit']))
{   
   $sql = "select * from program_details ";
   $topic_area_id=$_GET['topic_area_id'];
    $topic_area_investment_id=$_GET['topic_area_investment_id'];
    $search_text=$_GET['search_text'];
    if(empty($_GET['id']))
    {
        if(!empty($topic_area_id) && empty($topic_area_investment_id))
        {
            $sql .=" where topic_area_id='".$topic_area_id."' ";
            
        }
        if(!empty($topic_area_investment_id) && empty($topic_area_id))
        {
            $sql .=" where topic_area_investment_id='".$topic_area_investment_id."' ";
            
        }
        if(!empty($topic_area_investment_id) && !empty($topic_area_id))
        {
            $sql .=" where topic_area_id='".$topic_area_id."' and topic_area_investment_id='".$topic_area_investment_id."' ";
            
        }
        if(!empty($search_text))
        {
            $sql ="select * from program_details where id =".$search_text;
            
        }
        
    }
    //$sql="select * from plan_details1 where topic_area_id='".$_GET['topic_area_id']."' and topic_area_investment_id='".$_GET['topic_area_investment_id']."'or id='".$_GET['search_text']."' ";
    $datas = Programdetails::find_by_sql($sql);
    
}

$fiscals=  Fiscalyear::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area=  Topicarea::find_all();
?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">कार्यक्रम विवरण हेर्नुहोस </h2>
         	
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3>कार्यक्रम हेर्नुहोस </h3>
                                  <form method="get" >
						<table class="table table-bordered table-responsive">
                            <tr>
                                <td> कार्यक्रमको बिषयगत क्षेत्रको किसिम: </td>
                                <td><select name="topic_area_id" id="topic_area_id" onchange="form.submit()" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_id){?> selected="selected"<?php } ?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                              </td>&nbsp;
                                  <td> कार्यक्रमको विनियोजन किसिम:</td>
					<td><select name="topic_area_investment_id" onchange="form.submit()" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_investment_id){?> selected="selected"<?php } ?>><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
													</td>
                                <td>दर्ता नं</td>
                            	<td><input type="text" name="search_text" class="input100percent" value="<?php echo $search_text;?>"/></td>
                                <td><input type="submit" name="submit" value="खोज्नुहोस" class="submithere" /></td>
                                <td><div class="submitnew"><a class="btn" href="view_all_plans.php">रद्द गर्नुहोस </a></div></td>
                            </tr>
                             
                         </table>   
					</form>
					
                
                   
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                    <th >दर्ता नं</th>
                                    <th> कार्यक्रमको नाम</th>
                                    <th>  कार्यक्रमको बिषयगत क्षेत्रको किसिम</th>
                                    <th>कार्यक्रमको शिर्षकगत किसिम:</th>
                                    <th>  कार्यक्रमको उपशिर्षकगत किसिम:</th>
                                    <th>  कार्यक्रमको अनुदानको किसिम:</th>
                                    <th>कार्यक्रमको विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                    <th>विवरण हेर्नुहोस </th>
                                </tr>
                                <?php foreach($datas as $data):?>
                                <tr>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><!--<a href="view_plan_form.php?id=<?=$data->id?>">-->पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php endforeach;?>
                                 <?php    
                         $total=0;
                        foreach($datas as $data): 
                         $total+=$data->investment_amount;  endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit($total);?></td>
                             <td >&nbsp; </td>
                         </tr>
                     </table>
                    
                         
                    
                        


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>