<?php require_once("includes/initialize.php");
//error_reporting(-1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
//{
  //redirectUrl();
//}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$a=0;
if(isset($_GET['break_plan_id']))
{
  $a=1;  
  $parent_plan_id = $_GET['break_plan_id'];
}
if(isset($_GET['plan_id']))
{
    $plan_ids= $_GET['plan_id'];
    $plan_id_array = explode("-",$plan_ids);
   // print_r($plan_id_array);
    $sum=0;
    //$amount_array = array($plan_result->investment_amount);
    $amount_array = array();
    foreach($plan_id_array as $aa)
    {
    //    echo $a;exit;
        $plan_result = Plandetails1::find_by_id($aa);
        
        //echo "<pre>";print_r($plan_result);
        $sum += $plan_result->investment_amount;
        //print_r($sum);
        array_push($amount_array, $plan_result->investment_amount);
        //$amount_array = array($plan_result->investment_amount);//print_r($amount_array);
    }
    //print_r($amount_array);
}

if(isset($_POST['submit']))
{
    //exit('here');
    $data=new Plandetails1();
   // $data->sn=$_POST['sn'];
     $data->budget_id = implode(",", $_POST['budget_id']);
    $data->fiscal_id=$_POST['fiscal_id'];
    $data->type=$_POST['type'];
    $data->expenditure_type=$_POST['expenditure_type'];
    $data->parishad_sno=$_POST['parishad_sno'];
    $data->topic_area_id=$_POST['topic_area_id'];
    $data->topic_area_type_id=$_POST['topic_area_type_id'];
    $data->topic_area_type_sub_id=$_POST['topic_area_type_sub_id'];
    $data->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
    $data->topic_area_investment_id=$_POST['topic_area_investment_id'];
    $data->ward_no=$_POST['ward_no'];
    $data->program_name=$_POST['program_name'];
    $data->investment_amount=$_POST['investment_amount'];
    $data->first=$_POST['first'];
    $data->second=$_POST['second'];
    $data->third=$_POST['third'];
    
    if($plan_id=$data->save())
    {
      
         $up_array = explode("-", $_POST['update_plan_id']);
         //print_r($up_array);
            if(!empty($_POST['update_plan_id']))
            {
                    foreach($up_array as $b)
                    {
                       $plan_result11 = Plandetails1::find_by_id($b);   
                       
                       $plan_result11->investment_amount = 0;
                       $plan_result11->save();
                    }
                    $merge= new Mergeplandetails();
                    //print_r($merge);exit;
                    $merge->plan_id = $plan_id;
                    $merge->parent_plan_ids = $_GET['plan_id'];
                    $merge->merged_amount = $sum;
                    $merge->save();
            }
    if(isset($_POST['break_plan_id']))
        {
            savechildplan($plan_id, $_POST['break_plan_id'],$_POST['investment_amount']);
            
            
        }
    
    $session->message("नया योजना दर्ता न० ".$plan_id);
	redirect_to("plan_form.php");
    }
	
}
$postnames = Postname::find_all();
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
//print_r($topic_area_investment_source);
$bank_details=  Bankinformation::find_all();
$fiscals=  Fiscalyear::find_all();
$budget_result= Topicbudget::find_all();
//echo "<pre>";print_r($budget_result);echo "</pre>";exit;
$expenditure_type=1;
?>

<?php include("menuincludes/header.php"); ?>
<title>नया योजना विवरण दर्ता फाराम :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">नया योजनाको विवरण | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
            
            <div class="OurContentFull">
					<div class="myMessage"> <?php echo $message;?></div>
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                
                <div class="userprofiletable">
                 <h3 id="total_topic_budget" style="display: none;"></h3><h3 id="remaining_budget_show" style="display: none;" ></h3>
                  
                  <form method="post" enctype="multipart/form_data" >
                  
                  <div class="inputWrap2">
                   <?php if($a==1)
                   { 
                                $parent_plan = Plandetails1::find_by_id($parent_plan_id);
                                $child_sum_amount=0;
                                $child_result = Childplandetails::find_plan_ids_by_parent_plan_id($parent_plan_id);
                              ?>
                                 <?php if(empty($child_result))
                                  {
                                        $parent_investment_amount = $parent_plan->investment_amount;

                                        ?>
                                      <h3>मुख्य योजना: <?= $parent_plan->program_name ?> ||  विनियोजित बजेट : रु. <?= convertedcit(placeholder($parent_plan->investment_amount)) ?></h3>
                                 <?php 
                                  } 
                                  else
                                  { 
                                        $all_child  = find_all_child_plan_by_parent_id($parent_plan_id);
                                        foreach($all_child as $child):
                                          $child_sum_amount+=$child->investment_amount;   
                                        ?>
                                       <?php endforeach; ?>
                                         <h3>मुख्य योजना: <?= $parent_plan->program_name ?> ||  विनियोजित बजेट : रु. <?= convertedcit(placeholder($parent_plan->investment_amount +$child_sum_amount)) ?></h3>
                                          <?php
                                           foreach($all_child as $child):
                                         ?>
                                        <h3>योजना : <?= $child->program_name ?> || विनियोजित रकम : रु. <?= convertedcit(placeholder($child->investment_amount)) ?></h3>
                                    <?php endforeach; 
                                           $parent_investment_amount = $parent_plan->investment_amount + $child_sum_amount;
                                   } 

                                          $remaining_amount = $parent_investment_amount - $child_sum_amount;
                                       ?>     
                                   <h3>मुख्य योजनाको  बाकी विनियोजित रकम : रु. <?= convertedcit(placeholder($remaining_amount)) ?> </h3>        
                                  <h3>माथीको योजनाको भित्रको नया योजनाको विवरण भर्नुहोस</h3>
              <?php } 
                 
               else { ?> 
                  <h3>नया योजनाको विवरण भर्नुहोस </h3>
              <?php } ?> 
                  
                	<h1>नया योजनाको विवरण भर्नुहोस</h1>
                    <div class="inputWrap33 inputWrapLeft">
                    	<div class="titleInput">आर्थिक वर्ष :</div>
                        <div class="newInput"><select id="fiscal_id"  name="fiscal_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($fiscals as $data):?>
                                                    <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                                    <?php endforeach;?>
                                                </select>
                        </div>
                        <div class="titleInput">बजेट उपशिर्षक :</div>
                        <div class="newInput"> <select id="budget_ids" name="budget_id[]" class="budget_id">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($budget_result as $data):?>
                                                    <option value="<?php echo $data->id;?>" ><?php echo $data->name;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                
                        </div>
                        <div class="appendme"></div>
                        <div class="titleInput">बिनियोजन श्रोत र व्याख्या:  :</div>
                        <div class="newInput"><textarea  id="parishad_sno"  name="parishad_sno" ></textarea></div>
                        <div class="titleInput">खर्च किसिम छान्नुहोस् :</div>
                        <div class="newInput"><select name="expenditure_type  " >
                                            			<option value="">--छान्नुहोस्--</option>
                                                                <option value="1" <?php if($expenditure_type==1){ echo 'selected="selected"';}?>>पुँजीगत खर्च </option>
                                            			<option value="2" <?php if($expenditure_type==2){ echo 'selected="selected"';}?>>चालु खर्च </option>
                                            		</select></div>
                        <div class="titleInput">किसिम छान्नुहोस् :</div>
                        <div class="newInput"><select name="type" required>
                                                            <?php if($a==1)
                                                                { ?>
                                                         	<option value="0">योजना</option>
                                            		  <?php } else 
                                                                {?>
                                                                <option value="">--छान्नुहोस्--</option>
                                            			<option value="0">योजना</option>
                                            			<option value="1">कार्यक्रम</option>
                                                          <?php } ?>
                                            			
                                            		</select></div>
                    </div><!-- input wrap 33 ends -->
                    <div class="inputWrap33 inputWrapLeft">
                    	<div class="titleInput">योजना / कार्यक्रमको नाम :</div>
                        <div class="newInput"><textarea id="topic_name" name="program_name" ></textarea></div>
                        <div class="titleInput"> योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम: </div>
                        <div class="newInput"><select name="topic_area_id" id="topic_area_id" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                        <div id="topic_area_type_id"></div>
                        <div id="topic_area_type_sub_id"></div>
                        <div class="titleInput">योजना / कार्यक्रमको अनुदानको किसिम:  </div>
                        <div class="newInput"><select name="topic_area_agreement_id" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_agreement as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                         
                                                    
                        
                    </div><!-- input wrap 33 ends -->
                    <div class="inputWrap33 inputWrapLeft">
                    	<div class="titleInput">योजना / कार्यक्रमको विनियोजन किसिम:</div>
                         <div class="newInput"><select name="topic_area_investment_id[]" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_investment as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                        <?php endforeach; ?>
                                                    </select></div>
                         <div class="titleInput">वार्ड नं :</div>
                         <div class="newInput"><input type="text" id="topic_name"  name="ward_no" ></div>
                         <div class="titleInput">अनुदान रु :</div>
                         <div class="newInput"><input type="text"  name="investment_amount" id="investment_first" value="<?php echo !empty($sum)?$sum:0?>" ></div>
                         <div class="titleInput">पहिलो चौमासिक: </div>
                         <div class="newInput"><input type="text"  name="first" id="first" value="0" ></div>
                         <div class="titleInput">दोस्रो चौमासिक:</div>
                         <div class="newInput"><input type="text"  name="second" id="second" value="0" ></div>
                         <div class="titleInput">तेस्रो चौमासिक:</div>
                         <div class="newInput"><input type="text"  name="third" id="third" value="0" ></div>
                         <div class="saveBtn myCenter"><input type="submit" id="first_check" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                    </div><!-- input wrap 33 ends -->
                    <div class="myspacer"></div>
                    
                  </div><!-- input wrap ends -->
                 <?php //if($a==1):  ?> 
                 <?php if(isset($_GET['plan_id'])) : ?>
                 <input type="hidden" name="update_plan_id" value="<?=$_GET['plan_id'];?>">
                 <?php endif;?>
                    
                    <?php if(!empty($_GET['break_plan_id'])) : ?>
                        <input type="hidden" name="break_plan_id" value="<?= $_GET['break_plan_id'] ?>">
                        <input type="hidden" class="remaining_amount_check" value="<?= $remaining_amount ?>">
                    <?php endif;?>
                      
                      
                   <?php //endif; ?>     
                     
 </form>


                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    
    <script>
    JQ(document).ready(function(){
        JQ(document).on("click","#anudan_kisim",function() {
        var anudan_name= JQ("#anudan_name").val();
        var param = {};
        param.anudan_name= anudan_name;
        JQ.post('add_anudan_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ("#appent_anudan_kisim").html(obj.html);
        });
    });
    JQ(document).on("click","#bisyaghat_chhetra",function() {
        var topic_name_add= JQ("#topic_name_add").val();
        var budget_add= JQ("#budget_add").val();
        var param = {};
        param.budget_add= budget_add;
        param.topic_name_add= topic_name_add;
        JQ.post('add_bisayaghat_chhetra.php',param,function(res){
            var obj = JSON.parse(res);
            JQ("#append_bisayaghat").html(obj.html);
        });
    });
    JQ(document).on("click","#shirhagat_kisim",function() {

        var topic_id_add= JQ("#topic_id_add").val();
        var topic_name_add= JQ("#topic_shirsagat_name_add").val();
        var budget_add= JQ("#budget_shirsagat_add").val();
        var param = {};
        param.budget_add= budget_add;
        param.topic_name_add= topic_name_add;
        param.topic_id= topic_id_add;
        JQ.post('add_shirsagat_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ(".append_sirsagat").html(obj.html);
        });
    });
    JQ(document).on("click","#upashirhagat_kisim",function() {

        var topic_id_add           = JQ("#topic_area_id").val();
        var topic_area_type_id_add = JQ("[name=topic_area_type_id]").val();
        var topic_area_type_sub    = JQ("#topic_area_type_sub_name").val();
//                            alert(topic_id_add +" - "+ topic_area_type_id_add +" - "+topic_area_type_sub);return false;
        var param = {};
        param.topic_id_add            = topic_id_add;
        param.topic_area_type_id_add  = topic_area_type_id_add;
        param.topic_area_type_sub     = topic_area_type_sub;

        JQ.post('add_upashirsagat_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ(".append_upasirsagat").html(obj.html);
        });
    });

    JQ(document).on("click", "#add", function () {
        var num = JQ(".remove_anudan_details").length;
        var counter = num + 2;
        //           alert(counter);return false;
        var param = {};
        param.counter = counter;
        JQ.post('get_anudan_details.php', param, function (res) {
            var obj = JSON.parse(res);
            //alert(obj.html);
            JQ("#detail_add_table").append(obj.html);
            //JQ('#interest_amount_'+id).val(obj.interest_amount);

            // alert(obj.interest_amount);
        });
    });

    JQ(document).on("click", "#remove_topic", function () {
        JQ('.remove_anudan_details_topic').last().remove();

    });

    JQ(document).on("click", "#add_topic", function () {
        var num = JQ(".remove_anudan_details_topic").length;
        var counter = num + 2;
        //           alert(counter);return false;
        var param = {};
        param.counter = counter;
        JQ.post('get_anudan_details_topic.php', param, function (res) {
            var obj = JSON.parse(res);
            //alert(obj.html);
            JQ("#detail_add_table_topic").append(obj.html);
            //JQ('#interest_amount_'+id).val(obj.interest_amount);

            // alert(obj.interest_amount);
        });
    });

    JQ(document).on("click", "#remove", function () {
        JQ('.remove_anudan_details').last().remove();

    });
        JQ(document).on("change",".budget_id",function() {
        var budget_id = JQ(".budget_id").val()||0;
        var fiscal_id = JQ(".fiscal_id").val()||0;
        var param = {};
        param.budget_id = budget_id;
         param.fiscal_id = fiscal_id;
        JQ.post('get_remaining_budget.php',param,function(res){
        var obj = JSON.parse(res);
        var total_investment=parseFloat(obj.total_investment);
        var budget_amount = parseFloat(obj.budget_amount);
        if(budget_amount < total_investment)
        {
            alert("बजेट रकम सकिएको छ ..!!!");return false;
        }
        else if(obj.budget_amount==0)
        {
            alert("बजेट रकम भरिएको छैन ,कृपया सेटिंगमा गएर बजेट रकम भर्नुहोस्");return false;
        }
        else
        {
            //JQ('.appendme').html('<h1>hello</h1>');
                JQ("#total_topic_budget").show();
                JQ("#remaining_budget_show").show();
              JQ("#total_topic_budget").html(obj.total_amount);
              JQ("#remaining_budget_show").html(obj.remaining_amount);
          }     
            });
    }); 
    //      JQ('.select2').select2({
    //         multiple: true,
    //         placeholder: 'बजेट उपशिर्षक'
    //     });
    //   // JQ('#budget_id').trigger('change');
    // });
    </script>
    <?php include("menuincludes/footer.php"); ?>