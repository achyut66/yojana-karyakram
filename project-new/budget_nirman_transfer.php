<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user =  getUser();
if($user->mode!="superadmin")
{
    die("Permission Denied.....");
}
?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    for($i=0;$i<count($_POST['approve']);$i++)
    {
        $data= SettignBudgetNirman::find_by_id($_POST['approve'][$i]);
        $data->status=2;
        $data->save();
        $detail= new Plandetails1();
        $detail->program_name            = $data->program_name;
        $detail->topic_area_id           = $data->topic_id;
        $detail->ward_no                 = $data->ward_no;
        $detail->topic_area_type_id      = $data->topic_area_type_id;
        $detail->topic_area_type_sub_id  = $data->topic_area_type_sub_id;
        $detail->investment_amount       = $data->amount;
        $detail->budget_id               = $data->budget_id;
        $detail->save();
    }
        echo alertBox("नया योजना दर्ता भयो ||", "budget_nirman_transfer.php");
}

$budget_result= Ward::find_all();
$topic_area=  Topicarea::find_all();
$budget_nirman_result = SettignBudgetNirman::find_by_sql("select * from budget_nirman where status=1");
$budget_results= Topicbudget::find_all();
?>
<!-- js ends -->
<title>बजेट निर्माण  : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">बजेट निर्माणबाट योजना दर्ता गर्नुहोस | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                       
                        <h2>बजेट निर्माणबाट योजना दर्ता गर्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                        	    <div style="overflow-x:auto;">
                                    <table class="table table-bordered table-hover">
                                        <tr>
                                            <th>सि.नं </th>
                                            <th>योजनाको नाम </th>
                                            <th>संचालन हुने स्थान </th>
                                            <th>वार्ड नं </th>
                                            <th>बिषयगत क्षेत्र </th>
                                            <th>शिर्षकगत किसिम:</th>
                                            <th>उपशिर्षकगत किसिम</th>
                                            <th>बजेट शिर्षक </th>
                                            <th>रकम</th>
                                        </tr>
                                       <?php
                                            $i=1;
                                        if(empty($budget_nirman_result))
                                        {
                                            echo "<h2><b>No Data To Transfer</b></h2>";
                                        }
                                        else
                                        {
                                                foreach($budget_nirman_result as $data){
                                                    $topic_area_type_sub=  Topicareatypesub::find_by_topic_area_type_id($data->topic_area_type_id);
                                              $topic_area_types = Topicareatype::find_by_topic_area_id($data->topic_id);
                                                ?>
                                            <tr  <?php if($i!=1){?>class="remove_nirman_details"<?php }?>>
                                            <td class="sn" name="sn" id="sn_<?=$i?>" value="<?=$i?>"><?=$i?></td>
                                            <td><textarea name="program_name[]" readonly="true"><?=$data->program_name?></textarea></td>
                                                <td><textarea name="address[]" readonly="true"><?=$data->address?></textarea></td>
                                                <td><textarea type="text" name="ward_no[]" readonly="true"><?=$data->ward_no?></textarea></td>
                                                <td>
                                                    <select name="topic_id[]" id="topic_area_id" readonly="true">
                                                       <option value="">--छान्नुहोस्--</option>
                                                                <?php foreach($topic_area as $topic): ?> 
                                                       <option value="<?php echo $topic->id?>" <?php if($data->topic_id==$topic->id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
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
                                                <select name="topic_area_type_sub_id[]" id="topic_area_type_sub_id_<?=$i?>" >
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
                                                <td><teatarea type="text" name="amount[]" readonly="true"><?=$data->amount?></teatarea></td>
                                                <input type="hidden" name="approve[]" value="<?=$data->id?>"/>
                                            </tr>

                                                    <?php 
                                                    $i++;
                                            } 
                                        }    
                                       ?>
                                        </table>
                                        </div>
                                    
                                      <div class="inputWrap100">
<!--                            	<div class="inputWrap33 inputWrapLeft"><div class="add_nirman btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove_nirman btn myWidth100">हटाउनुहोस [-]</div></div>-->
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="दर्ता गर्नुहोस " class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                            	<div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                                </form>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>