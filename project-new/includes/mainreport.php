<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$topic_area=  Topicarea::find_all();?>
<?php include("menuincludes/header.php"); ?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{   
    $type=$_POST['type'];
    $topic_area_id=$_POST['topic_area_id'];
    $sql="select * from plan_details1 where topic_area_id=$topic_area_id and type=$type";
    $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic_area_id);
    //print_r($topic_area_type_ids); exit;
//    foreach($topic_area_type_ids as $topic_selected)
//    {
//        
//        echo $topic_selected->topic_area_type." | ".  Plandetails1::count_by_topic_area_type_id($topic_selected->id);
//        echo"<br/>";
//    }
//    $result=  Plandetails1::find_by_sql($sql);
////    echo "<pre>";
////        print_r($result);echo "</pre>";
////    
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
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
             
            <div class="OurContentRight">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3>मुख्य रिपोर्ट हेर्नुहोस </h3>
                  <form method="post">
                    <table class="table table-bordered">
                         <tr>
                                <td>किसिम छान्नुहोस्</td>
                                <td>
                                        <select name="type" required>
                                                <option value="">--छान्नुहोस्--</option>
                                                <option value="0">योजना</option>
                                                <option value="1">कार्यक्रम</option>
                                        </select>
                                </td>
                        </tr>               
                        <tr>
                            <td> योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम: </td>
                                <td><select name="topic_area_id" id="topic_area_id" required>
                                       <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($topic_area as $topic): ?> 
                                       <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                            <?php endforeach; ?>
                                        </select>
                            </td>
                        </tr>
                        
                                           <tr>
                                               <td> <input type="submit" name="submit" value="खोज्नुहोस" class="submithere"></td>
                                           </tr>
                    </table>
                      
                </form>
                    <?php if(isset($_POST['submit'])):?>              
                                  <div class="myPrint"><a target="_blank" href="mainreport_final.php?topic_area_id=<?php echo $topic_area_id;?> & topic_area_type_id=<?php echo $topic_area_type_id;?>">प्रिन्ट गर्नुहोस</a></div>
                                  <div style="text-align:center;">
                                   <table class="table table-bordered table-responsive">
                                                <tr>    
                                                    <th>सि.न </th>
                                                    <th>योजनाको बिषयगत क्षेत्रको किसिम</th>
                                                    <th>योजनाको शिर्षकगत किसिम:</th>
                                                    <th>कुल संख्या  :</th>
                                                    <th>कुल अनुदान रु :</th>
                                                    <th>विवरण हेर्नुहोस </th>
                                                </tr>
                                     <?php            
                                     $i=1;
                                     foreach($topic_area_type_ids as $topic_selected)
    :?>
        
                                                <tr>
                                                     <td><?php echo convertedcit($i);?></td>
                                                    <td><?php echo Topicarea::getName($topic_area_id);;?></td>
                                                    <td><?php echo $topic_selected->topic_area_type;?></td>
                                                    <td><?php echo convertedcit(Plandetails1::count_by_topic_area_type_id($topic_selected->id));?></td>
                                                    <td><?php echo convertedcit(placeholder(Plandetails1::get_total_investment_by_topic_area_type_id($topic_selected->id)));?></td>
                                                    <td><a href="view_plan_form.php?id=<?=$data->id?>">पुरा विवरण हेर्नुहोस</a></td>
                                                </tr>
                                         <?php $i++; endforeach;?>
                                                <tr>
                                 </table>
                </div>
                                  <?php endif;?>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>