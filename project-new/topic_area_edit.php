<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
  $id=$_GET['id'];
  $shrot_result = TopicAreaBudgetShrot::find_by_topic_area_id($id);
if(isset($_POST['submit']))
{
        $topic = Topicarea::find_by_id($_POST['update_id']);
	$topic->name = $_POST['name'];
        $topic->budget= $_POST['budget'];
	$topic->save();
        foreach($shrot_result as $a)
        {
            $a->delete();
        }
for($i=0;$i<count($_POST['budgets']);$i++)
   {
       $result = new TopicAreaBudgetShrot();
       $result->shrot_id = $_POST['shrot_id'][$i];
       $result->budget = $_POST['budgets'][$i];
       $result->topic_area_id = $_POST['update_id'];
       $result->save();
   }
   echo alertBox("थप सफल ","settings_topic.php");
}

$topic= Topicarea::find_by_id($id);
$result_shrot = ShrotDetails::find_all();
//print_r($result_shrot);
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बिषयगत क्षेत्र सच्याउनुहोस् :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                <div class="maincontent">
                    <h2 class="headinguserprofile">बिषयगत क्षेत्र | <a href="settings_topic.php" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	   <form method="post" enctype="multipart/form-data">
                                    	<div class="inputWrap">
                                        	<h1>बिषयगत क्षेत्र सच्याउनुहोस् </h1>	
                                            <div class="titleInput">बिषयगत क्षेत्रको नाम</div>
                                            <div class="newInput"><input type="text" id="topic_name" name="name" value="<?php echo $topic->name;?>" required></div>
                                            <div class="titleInput">बजेट रकम </div>
                                            <div class="newInput"><input type="text" id="" name="budget" required value="<?php echo $topic->budget;?>"></div>
                                         
                                            
                                            
                                            
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
                                         </div><!-- input wrap ends -->
                                        
                                        
                                <input type="hidden" name="update_id" value="<?php echo $topic ->id; ?>" />
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>