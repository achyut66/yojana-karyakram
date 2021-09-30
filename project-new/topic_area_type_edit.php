<?php require_once("includes/initialize.php"); 	
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php
$id=$_GET['id'];
$topicarea=  Topicarea::find_all();
$topicareatype= Topicareatype::find_by_id($id);
 $shrot_result = TopicAreaTypeBudgetShrot::find_by_topic_area_type_id($id);
if(isset($_POST['submit']))
{       
	$topic = Topicareatype::find_by_id($_POST['post_id']);
        //print_r($topic); exit;
	//$topic->sn= $_POST['sn'];
	$topic->topic_area_id = $_POST['topic_area_id'];
        $topic->topic_area_type = $_POST['topicareatype'];
        $topic->budget = $_POST['budget'];
        $topic->save();
         foreach($shrot_result as $a)
        {
            $a->delete();
        }
        for($i=0;$i<count($_POST['budgets']);$i++)
           {
               $result = new TopicAreaTypeBudgetShrot();
               $result->shrot_id = $_POST['shrot_id'][$i];
               $result->budget = $_POST['budgets'][$i];
               $result->topic_area_id = $_POST['topic_area_id'];
               $result->topic_area_type_id = $_POST['post_id'];
               $result->save();
           }
           echo alertBox("थप सफल ","topic_area_type_view.php");
}
$result_shrot = ShrotDetails::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको शिर्षकगत किसिम सच्याउनुहोस् :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको शिर्षकगत किसिम सच्याउनुहोस्  | <a href="topic_area_type_view.php" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	    <form method="post" enctype="multipart/form-data">
                                	<div class="inputWrap">
                                    	<h1>योजनाको शिर्षकगत किसिम सच्याउनुहोस्</h1>
                                        <div class="titleInput">बिषयगत क्षेत्र : </div>
                                        <div class="newInput"><select name="topic_area_id" required>
                                               <option value="">--छान्नुहोस्--</option>
                                                   	<?php foreach($topicarea as $topic): ?> 
                                               <option value="<?php echo $topic->id?>" <?php if($topicareatype->topic_area_id==$topic->id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
                                                    <?php endforeach; ?>
                                                </select></div>
                                        <div class="titleInput">आयोजनाको शिर्षकगत किसिम : </div>
                                        <div class="newInput"><input type="text" id="topic_name" name="topicareatype" value="<?php echo $topicareatype->topic_area_type;?>"></div>
                                        <div class="titleInput">बजेट रकम </div>
                                            <div class="newInput"><input type="text" id="" name="budget" required value="<?php echo $topicareatype->budget;?>"></div>
                                        <table class="table table-bordered table-hover">
                                                <tr>
                                                    <th> सि.नं </th>
                                                    <th> श्रोतको नाम </th>
                                                    <th> बजेट रकम </th>
                                                </tr>
                                                <?php $i=1; foreach($shrot_result as $dataa){
//                                                    print_r($dataa);?>
                                                <tr <?php if($i!=1){?> class="remove_shrot_details" <?php } ?>>
                                                    <td><?=convertedcit($i)?></td>
                                                    <td>
                                                        <select name="shrot_id[]">
                                                            <option value="">--------</option>
                                                            <?php foreach($result_shrot as $result):?>
                                                            <option value="<?=$result->id?>" <?php if($result->id == $dataa->shrot_id){ echo 'selected="selected"';}?>><?=$result->name?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="budgets[]" value="<?=$dataa->budget?>"/> </td>
                                                </tr>
                                                <?php $i++; } ?>
                                                <tbody id="add_more_shrot"></tbody>
                                            </table>
                                            
                                            
                                            
                                         <div class="inputWrap33 inputWrapLeft"><div class="add_shrot btn myWidth100">थप्नुहोस [+]</div></div>
                                           <div class="inputWrap33 inputWrapLeft"><div class="remove_shrot btn myWidth100">हटाउनुहोस[-]</div></div>
                                      <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                         <input type="hidden" name="post_id" value="<?php echo $topicareatype->id; ?>" />
                                    	<div class="myspacer"></div>
                                    </div><!-- inpur wrap ends -->
                                    	
				
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>