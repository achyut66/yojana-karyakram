<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = KattiWiwarn::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new KattiWiwarn();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->topic = $_POST['topic'];
    $form_data->percent = $_POST['percent'];
    $form_data->what_is = $_POST['what_is'];
//    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "settings_katti_wiwarn.php");
    }
}

if(isset($_GET['id']))
{
    $data= KattiWiwarn::find_by_id($_GET['id']);
   
}
else
{
    $data = KattiWiwarn::setEmptyObjects();
}
$budget_result= KattiWiwarn::find_all();
//echo"<pre>";
//print_r($budget_result);
//foreach ($budget_result as $br):
//    endforeach;
?>
<!-- js ends -->
<title>कट्टी विवरण हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">कट्टी विवरण हाल्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                        <h2>कट्टी विवरण हाल्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                    <div class="newInput">
                                        <select class="form-control" name="what_is">
                                            <option>---छानुहोस---</option>
                                            <option value="1">उपभोक्ता समिति</option>
                                            <option value="2">कार्यक्रम मार्फत</option>
                                            <option value="3">ठेक्का मार्फत</option>
                                            <option value="4">संस्था समिति</option>
                                            <option value="5">कोटेसन मार्फत</option>
                                            <option value="6">अमानत मार्फत</option>
                                        </select>
                                    </div>
                                	<div class="titleInput">शिर्षक</div>
                                    <div class="newInput"><input type="text"  name="topic" value="<?php echo $data->topic;?>" required></div>
                                    <div class="titleInput">कट्टी प्रतिशत</div>
                                    <div class="newInput"><input type="text"  name="percent" value="<?php echo $data->percent;?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>शिर्षक</strong></td>
                                    <td class="myCenter"><strong>कट्टी प्रतिशत</strong></td>
                                    <td class="myCenter"><strong>मार्फत</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):
//                                    print_r($result);
//                                    print_r($budget_result->what_is);exit();
                                    ?>
                                    <?php
                                    if($result->what_is==1){
                                        $kar_name = "<div style='color: red'>उपभोक्ता</div>";
                                    }elseif($result->what_is==2){
                                        $kar_name = "<div style='color: green'>कार्यक्रम</div>";
                                    }elseif($result->what_is==3){
                                        $kar_name = "ठेक्का";
                                    }elseif($result->what_is==4){
                                        $kar_name = "संस्था";
                                    }elseif($result->what_is==5){
                                        $kar_name = "कोटेसन";
                                    }else{
                                        $kar_name = "अमानत";
                                    }
                                    ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->topic);?></td>
                                    <td class="myCenter"><?php echo convertedcit($result->percent);?></td>
                                    <td class="myCenter"><?php echo $kar_name?></td>
                                    <form method="post" action="katti_delete.php">
                                    <td class="myCenter">
                                        <a href="settings_katti_wiwarn.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
                                        <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                        <input type="hidden" name="id" value="<?=$result->id?>">
                                    </td>
                                    </form>
                                </tr>
                                <?php $i++; 
                                endforeach;?>
                            </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>