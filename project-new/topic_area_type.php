<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
if(isset($_POST['submit']))
{
	$topic = new Topicareatype();
	$topic->topic_area_id=$_POST['topic_id'];
        $topic->topic_area_type=$_POST['name'];
        $topic->budget = $_POST['budget'];
        $topic_area_sub_id = $topic->save();
        //$topic->sn=$_POST['sn'];
        for($i=0;$i<count($_POST['budgets']);$i++)
   {
       $result = new TopicAreaTypeBudgetShrot();
       $result->shrot_id = $_POST['shrot_id'][$i];
       $result->budget = $_POST['budgets'][$i];
       $result->topic_area_id = $_POST['topic_id'];
       $result->topic_area_type_id = $topic_area_sub_id;
       $result->save();
   }
   echo alertBox("थप सफल ","topic_area_type_view.php");
       
}
$topic_result= Topicarea::find_all();
$shrot_result= ShrotDetails::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको शिर्षकगत किसिम थप्नुहोस :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको शिर्षकगत किसिम थप्नुहोस | <a href="topic_area_type_view.php" class="btn">पछि जानुहोस</a>  </h2>
                    
                <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                                 <div class="inputWrap">
                                    <h1>योजनाको शिर्षकगत किसिम  थप्नुहोस </h1>
                                 	<div class="titleInput">बिषयगत क्षेत्रको नाम:</div>
                                    <div class="newInput"><select name="topic_id" required>
                                                	<option value="">--छान्नुहोस्--</option>
                                                   	<?php foreach($topic_result as $data): ?> 
                                                    <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                                                    <?php endforeach; ?>
                                                </select></div>
                                     <div class="titleInput">आयोजनाको शिर्षकगत किसिम:</div>
                                     <div class="newInput"><input type="text" id="topic_name" name="name" required></div>
                                     <div class="titleInput">बजेट रकम </div>
                                            <div class="newInput"><input type="text" id="" name="budget" required></div>
                                    
                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <th> सि.नं </th>
                                                    <th> श्रोतको नाम </th>
                                                    <th> बजेट रकम </th>
                                                </tr>
                                                <tr>
                                                    <td><?=convertedcit(1)?></td>
                                                    <td>
                                                        <select name="shrot_id[]">
                                                            <option value="">--------</option>
                                                            <?php foreach($shrot_result as $result):?>
                                                            <option value="<?=$result->id?>"><?=$result->name?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="budgets[]"/> </td>
                                                </tr>
                                                <tbody id="add_more_shrot"></tbody>
                                            </table>
                                            <div class="inputWrap33 inputWrapLeft"><div class="add_shrot btn myWidth100">थप्नुहोस [+]</div></div>
                                           <div class="inputWrap33 inputWrapLeft"><div class="remove_shrot btn myWidth100">हटाउनुहोस[-]</div></div>
                                      <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                          <div class="myspacer"></div>
                                 </div><!-- input wrap ends -->
                                        

                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>