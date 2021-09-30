<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if(isset($_POST['update_id']) && !empty($_POST['update_id']))
    {
        $form_data = Marmatsamhar::find_by_id($_POST['update_id']);
    }
    else 
    {
        $form_data = new Marmatsamhar();
    }
    
    //$data->sn= $_POST['sn'];
    $form_data->percent= $_POST['percent'];
    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "settings_marmat_samhar.php");
    }
}

if(isset($_GET['id']))
{
    $data= Marmatsamhar::find_by_id($_GET['id']);
   
}
else
{
    $data = Marmatsamhar::setEmptyObjects();
}
$budget_result= Marmatsamhar::find_all();
?>
<!-- js ends -->
<title>मर्मत संहार कोष कट्टी प्रतिसत हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
             <h2 class="headinguserprofile">मर्मत संहार कोष कट्टी प्रतिसत हाल्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                    <div class="myMessage"><?php echo $message;?></div>
                    <div class="OurContentFull">
                    
                        <h2>मर्मत संहार कोष कट्टी प्रतिसत हाल्नुहोस </h2>
                        <div class="userprofiletable">
                        	<form method="post" enctype="multipart/form-data">
                            	<div class="inputWrap">
                                	<div class="titleInput">मर्मत संहार कोष कट्टी प्रतिसत:</div>
                                    <div class="newInput"><input type="text"  name="percent" value="<?php echo $data->percent;?>" required></div>
                                    <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                                	<div class="myspacer"></div>
                                </div><!-- input wrap ends -->
                                    	
                                    </form>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>मर्मत संहार कोष कट्टी प्रतिसत</strong></td>
                                    <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                                </tr>
                                <?php $i=1;foreach($budget_result as $result):?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo $result->percent;?></td>
                                    <form method="post" action="marmat_delete.php">
                                    <td class="myCenter">
                                        <a href="settings_marmat_samhar.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
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