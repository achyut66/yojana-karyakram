<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 
if(isset($_POST['submit']))
{
    //echo "<pre>"; print_r($_FILES); echo "</pre>";

 for($i=0;$i<count($_FILES['pic']['name']);$i++)
      {
         //echo $_POST['type_id']; exit;
		// print_r($_FILES);exit;
		    $root_folder = $_POST['plan_id'];
		    $type_folder = $_POST['type_id'];
		    if (!file_exists('yojana_picture/'.$root_folder)) 
		    {
		        
                mkdir("yojana_picture/" . $root_folder, 0777);
            
		    }
		    if(!file_exists('yojana_picture/'.$root_folder.'/'.$type_folder))
		    {
		          mkdir('yojana_picture/'.$root_folder.'/'.$type_folder, 0777);
		    }
            $name                   = rand(10000,1000000000).$_FILES['pic']['name'][$i];
            $folder_path            = 'yojana_picture/'.$root_folder.'/'.$type_folder;
			$upload                 = new Upload();
            $upload->plan_id        = $_POST['plan_id'];
            $upload->type_id        = $_POST['type_id'];
            $upload->pic            = $name;
            $upload->save(); 
         
                            if(FALSE !== ($path = folder_exist($folder_path)))
                                    {
                                        move_uploaded_file($_FILES['pic']['tmp_name'][$i],$folder_path."/".$name); 
                                    }
                            else
                                    {
                                        mkdir($folder_path);
                                        move_uploaded_file($_FILES['pic']['tmp_name'][$i],$folder_path."/".$name);
                                    }
           
     }
     
    
     $session->message("फोटो हाल्न सफल!",1); 
     redirect_to("photos_upload.php");   

     
 }
 if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$id=$_GET['id'];
$plan_id=$id;   
?>

<?php include("menuincludes/header.php"); ?>
<title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
		
        <div class="maincontent">
            <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | <a href="upabhoktasamitidashboard.php" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
					
                <h2>योजनाको फोटो </h2>
                <div class="userprofiletable">
                	<?php
		    
		$folder_1 = 'yojana_picture/'.$plan_id.'/1/';
		$folder_2 = 'yojana_picture/'.$plan_id.'/2/';
		$folder_3 = 'yojana_picture/'.$plan_id.'/3/';
		$folder_4 = 'yojana_picture/'.$plan_id.'/4/';
		$folder_array = array(1=>$folder_1,2=>$folder_2,3=>$folder_3);
$name_array=array(1=>"काम सुरु हुनु भन्दा अगाडी को फोटो ",2=>"मुल्याकन हुन बखतको फोटो",3=>"काम सम्पन्न भएको फोटो");

   for($i=1;$i<4;$i++)
{                  echo "<h3>".$name_array[$i]."</h3>";
                    if(folder_exist($folder_array[$i]))
                {      
                            if (dir_is_empty($folder_array[$i]))
                            {
                                echo "फोटो भेटिएन <br><br> ";
                            }
                            else
                            {
                                $photos = Upload::find_photos_by_planid_and_type_id($plan_id,$i);
                                        foreach ($photos as $b)
                                          {
                                          ?>
                                      <a href="<?php echo $folder_array[$i].$b->pic; ?>" data-lightbox="lightbox[<?php echo $i; ?>]"><img src='<?php echo 
                                       $folder_array[$i].$b->pic;?>' width="100" height="100"></a>    
                                     <a href="delete_image.php?id=<?php echo $b->id;?>&type_id=<?=$i?>" ><img src="picture/wrong.png" height="10px" width="10px" style="margin-bottom:100px;"></a>
                                          <?php
                                            //echo $folder_1.'/'.$photo->pic;
                                          }
                                          echo "<br><br>";
                            }
                }
                else
                            {
                            echo "फोटो भेटिएन <br><br>"   ; 
                            }
 
}
  echo "<h3>योजनाको  लागत इस्टमेट, मुल्यांकन सम्बन्धि पी डी एफ</h3>";
     if(folder_exist($folder_4))
                {      
                            if (dir_is_empty($folder_4))
                            {
                                echo "पी डी एफ भेटिएन <br><br> ";
                            }
                            else
                            {
                                $photos = Upload::find_photos_by_planid_and_type_id($plan_id,4);
                                //print_r($photos); exit;
                                //$a=glob($folder_1."/*.*");

                                        foreach ($photos as $b)
                                          {
                                           //  $image='<img src='.$folder_array[$i].$b->pic.' width="100" height="100">';
                                           // echo $image;
                                          ?>
                                     <div class="myCenter"><a href="<?php echo $folder_4.$b->pic; ?>" ><img src='images/pdf-icon.png' width="100" height="100"> <?= $b->pic;  ?></a></div> 
                                       <div class="myCenter">    
                                     <a href="delete_image.php?id=<?php echo $b->id;?>&type_id=4" ><img src="picture/wrong.png" height="10px" width="10px" style="margin-bottom:100px;"></a></div>
                                          <?php
                                            //echo $folder_1.'/'.$photo->pic;
                                          }
                                          echo "<br><br>";
                            }
                }
                else
                            {
                            echo "पी डी एफ भेटिएन<br><br>"   ; 
                            }


		
		?>

                 <form method="post" enctype="multipart/form-data" >
                 	<div class="inputWrap">
                    	<h1>किसिम </h1>
                        <div class="newInput">
                        	<select name="type_id">
                                <option value="">-छान्नुहोस-</option>
                                <option value="1">काम सुरु हुनु भन्दा अगाडी को फोटो</option>
                                <option value="2">मुल्याकन हुन बखतको फोटो </option>
                                <option value="3">काम सम्पन्न भएको फोटो </option>
                                <option value="4">योजनाको  लागत इस्टमेट, मुल्यांकन सम्बन्धि पी डी एफ </option>
                                           
                            </select>
                         </div>
                         <div class="newInput">
                         	<input type="file" name="pic[]" />
                         </div>
                         <div id="pics_add_table" class="newInput"></div>
                         <div class="add_more btn" id="add_pics">थप्नुहोस</div>
                         <div class="remove_more btn" id="remove_pics">हटाऊनुहोस्</div>
                         <div class="myspacer"></div>
                         <div class="titleInput myCenter myWidth100"><input type="submit" value="अपलोड गर्नुहोस " name="submit" class="btn"/></div>
                         
                    </div><!-- input wrap ends -->
                <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
               </form>
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
      <link href="lightbox/src/css/lightbox.css" rel="stylesheet">
      <script src="lightbox/src/js/lightbox.js"></script>