<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    $data=new Topicarea(); 
    //$data->sn= $_POST['sn'];
    $data->name= $_POST['name'];
   $data->budget= $_POST['budget'];
    $topic_id=$data->save();
//   for($i=0;$i<count($_POST['budgets']);$i++)
//   {
//       $result = new TopicAreaBudgetShrot();
//       $result->shrot_id = $_POST['shrot_id'][$i];
//       $result->budget = $_POST['budgets'][$i];
//       $result->topic_area_id = $topic_id;
//       $result->save();
//   }
   echo alertBox("थप सफल ","topic_area.php");
}
$shrot_result= ShrotDetails::find_all();
?>
<!-- js ends -->
<title>बिषयगत क्षेत्र थप्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">बिषयगत क्षेत्र थप्नुहोस | <a href="settings_topic.php" class="btn">पछि जानुहोस </a></h2>
                   
                        <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                                    	<div class="inputWrap">
                                        	<h1>बिषयगत क्षेत्र थप्नुहोस </h1>
                                        	<div class="titleInput">बिषयगत क्षेत्रको नाम</div>
                                            <div class="newInput"><input type="text" id="topic_name" name="name" required></div>
                                            <div class="titleInput">बजेट रकम </div>
                                            <div class="newInput"><input type="text" id="" name="budget" ></div>
                                            <!--<table class="table table-bordered table-hover">-->
                                            <!--    <tr>-->
                                            <!--        <th> सि.नं </th>-->
                                            <!--        <th> श्रोतको नाम </th>-->
                                            <!--        <th> बजेट रकम </th>-->
                                            <!--    </tr>-->
                                            <!--    <tr>-->
                                            <!--        <td><?=convertedcit(1)?></td>-->
                                            <!--        <td>-->
                                            <!--            <select name="shrot_id[]">-->
                                            <!--                <option value="">--------</option>-->
                                            <!--                <?php foreach($shrot_result as $result):?>-->
                                            <!--                <option value="<?=$result->id?>"><?=$result->name?></option>-->
                                            <!--                <?php endforeach;?>-->
                                            <!--            </select>-->
                                            <!--        </td>-->
                                            <!--        <td><input type="text" name="budgets[]"/> </td>-->
                                            <!--    </tr>-->
                                            <!--    <tbody id="add_more_shrot"></tbody>-->
                                            <!--</table>-->
                                           <!-- <div class="inputWrap33 inputWrapLeft"><div class="add_shrot btn myWidth100">थप्नुहोस [+]</div></div>-->
                                           <!--<div class="inputWrap33 inputWrapLeft"><div class="remove_shrot btn myWidth100">हटाउनुहोस[-]</div></div>-->
                                      <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                        </div><!-- input wrap ends -->
                                        
                                    </form>
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>