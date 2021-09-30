<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user =  getUser();
?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if($user->mode=="superadmin")
    {
        $budget_nirman_result = SettignBudgetNirman::find_all();
    }
    else
    {
        $budget_nirman_result = SettignBudgetNirman::find_by_sql("select * from budget_nirman where ward_no=".$user->ward);
    }

    for($i=0;$i<count($_POST['program_name']);$i++)
    {
        $data= new SettignBudgetNirman();
        $data->program_name                = $_POST['program_name'][$i];
        $data->address                     = $_POST['address'][$i];
        $data->ward_no                     = $_POST['ward_no'][$i];
        $data->topic_id                    = $_POST['topic_id'][$i];
        $data->budget_id                   = $_POST['budget_id'][$i];
        $data->topic_area_type_id          = $_POST['topic_area_type_id'][$i];
        $data->topic_area_type_sub_id      = $_POST['topic_area_type_sub_id'][$i];
        $data->amount                      = $_POST['amount'][$i];
        $data->save();
    }
        echo alertBox("डाटा सेव भयो ||", "budget_nirman.php");
}

$budget_result= Ward::find_all();
$topic_area=  Topicarea::find_all();
//print_r($topic_area);
if($user->mode=="superadmin")
{
    $budget_nirman_result = SettignBudgetNirman::find_all();
}
else
{
    $budget_nirman_result = SettignBudgetNirman::find_by_sql("select * from budget_nirman where ward_no=".$user->ward);
}
$budget_results= Topicbudget::find_all();
// echo "<pre>";
// print_r($budget_nirman_result);

?>
<!-- js ends -->
<title>बजेट निर्माण  : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">बजेट निर्माण  | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                        <h2>बजेट निर्माण</h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                        	    <div style="overflow-x:auto;">
                                    <table class="table table-bordered table-hover">
                                        <tr>
                                            <th>सि.नं </th>
                                            <th>योजनाको नाम </th>
                                            <th>संचालन हुने स्थान </th>
                                            <th>संचालन हुने वार्ड नं </th>
                                            <th>बिषयगत क्षेत्र </th>
                                            <th>शिर्षकगत किसिम</th>
                                            <th>उपशिर्षकगत किसिम</th>
                                            <th>बजेट शिर्षक </th>
                                            <th>बजेट रकम</th>
                                        </tr>
                                        <?php if(empty($budget_nirman_result)){?>
                                            <td>1</td>
                                            <td><textarea name="program_name[]"></textarea></td>
                                            <td><textarea name="address[]"></textarea></td>
                                            <td><textarea name="ward_no[]"></textarea></td>
                                            <!--<td><input type="text" size="4" width="50%" name="ward_no[]" /></label></td>-->
                                            <td>
                                                <select name="topic_id[]" id="topic_area_id_1" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>"><?php echo $topic->name?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td id="topic_area_type_1">
                                                
                                            </td>
                                            <td id="topic_area_type_sub_1">
                                                
                                            </td>
                                            <td>
                                                <select name="budget_id[]" id="budget_id" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($budget_results as $budget): ?> 
                                                   <option value="<?php echo $budget->id?>"><?php echo $budget->name?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><textarea type="text" name="amount[]"></textarea></td>
                                            <td></td>
                                
                                        </tr>
                                        <?php }else{
                                            $i=1;
                                            foreach($budget_nirman_result as $data){
                                              $topic_area_type_sub=  Topicareatypesub::find_by_topic_area_type_id($data->topic_area_type_id);
                                              $topic_area_types = Topicareatype::find_by_topic_area_id($data->topic_id);
//                                              print_r($topic_area_type_sub);
//                                              echo "<br>";
//                                              echo "<br>";
//                                              echo "<br>";
//                                              print_r($topic_area_types);
                                              ?>
                                        <tr  <?php if($i!=1){?>class="remove_nirman_details"<?php }?>>
                                        <td class="sn" name="sn" id="sn_<?=$i?>" value="<?=$i?>"><?=$i?></td>
                                            <td><textarea name="program_name[]"><?=$data->program_name?></textarea></td>
                                            <td><textarea name="address[]"><?=$data->address?></textarea></td>
                                            <td><textarea name="ward_no[]"><?=$data->ward_no?></textarea></td>
                                            <!--<td><textarea type="text" name="ward_no[]"><?=$data->ward_no?></textarea></td>-->
                                            <td>
                                                <select name="topic_id[]" id="topic_area_id_<?=$i?>" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area as $topic): ?> 
                                                   <option value="<?php echo $topic->id?>" <?php if($data->topic_id==$topic->id){ echo 'selected="selected"';}?>><?php echo $topic->name?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td id="topic_area_type_<?=$i?>">
                                                <select name="topic_area_type_id[]" id="topic_area_type_id_<?=$i?>" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_types as $topics): ?> 
                                                   <option value="<?php echo $topics->id?>" <?php if($data->topic_area_type_id==$topics->id){ echo 'selected="selected"';}?>><?php echo $topics->topic_area_type;  ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                             <td id="topic_area_type_sub_<?=$i?>">
                                                <select name="topic_area_type_sub_id[]" id="topic_area_type_sub_id_<?=$i?>">
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($topic_area_type_sub as $topicd): ?> 
                                                   <option value="<?php echo $topicd->id?>" <?php if($data->topic_area_type_sub_id==$topicd->id){ echo 'selected="selected"';}?>><?php echo $topicd->topic_area_type_sub;  ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="budget_id[]" id="budget_id" >
                                                   <option value="">--छान्नुहोस्--</option>
                                                            <?php foreach($budget_results as $budget): ?> 
                                                   <option value="<?php echo $budget->id?>" <?php if($data->budget_id==$budget->id){ echo 'selected="selected"';}?>><?php echo $budget->name;  ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><textarea type="text" name="amount[]"><?=$data->amount?></textarea></td>
                                            <?php
                                        if($i!=1){
                                        ?>
                                         <td><button class="remove_btn" id="remove_btn_<?=$i?>"><img src="images/cross.png" style="height: 20px; width: 20px;"></button></td></tr>
                                        <?php }?>
                                        <tr>
                                                <?php 
                                                $i++;
                                        } 
                                        }?>
                                        <tbody id="append_nirman"></tbody>
                                    </table>
                                </div>
                                <div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft"><div class="add_nirman btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove_nirman btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                            	<div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                            </form>
                    
        </div><!-- main menu ends -->
</div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script>
    var JQ = jQuery.noConflict();
     JQ(document).on("click",".add_nirman",function() {
        var num=JQ(".remove_nirman_details").length;
    var counter=num+2;
//   alert(counter);return false;
    var param = {};
    param.counter= counter;
    JQ.post('get_budget_nirman_html.php',param,function(res){
        var obj = JSON.parse(res);
//    alert(obj.html);
        JQ("#append_nirman").append(obj.html);
        //JQ('#interest_amount_'+id).val(obj.interest_amount);

       // alert(obj.interest_amount);
     });
    });
      JQ(document).on("click",".remove_nirman",function() {
         JQ('.remove_nirman_details').last().remove();
        
    });
     JQ(document).on("click",".remove_btn",function() {
         JQ(this).closest('tr').remove();
            var i = 1;
            JQ(".sn").each(function(){
                    JQ(this).html(i+1);
                    i++;
            });
       
        
    });
    JQ(document).on("change","select[name^='topic_id[]']",function() {
        var id_selected = JQ(this).attr('id');
        var res = id_selected.split("_");
        var counter = res[res.length-1];
        var topic_id = JQ(this).val();
        var param = {};

            param.topic_id = topic_id;
            param.counter = counter;
           // param.myclass = myclass;
                JQ.post('get_budget_topic_area_type.php',param,function(res){
                    var obj = JSON.parse(res);

                      JQ("#topic_area_type_"+counter).html(obj.html);
                      //false;
          });
       
        
    });

  // sub topic area dynamic selection 
  JQ(document).on("change","select[name^='topic_area_type_id[]']",function() {
    var id_selected = JQ(this).attr('id');
    var res = id_selected.split("_");
    var counter = res[res.length-1];
    var topic_id = JQ(this).val();
	
    var param = {};
    
        param.topic_id = topic_id;
       // param.myclass = myclass;
            JQ.post('get_budget_topic_area_type_sub.php',param,function(res){
                var obj = JSON.parse(res);

                  JQ("#topic_area_type_sub_"+counter).html(obj.html);
                  //false;
      });
       
        
    });
    </script>