<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
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
		<div class="">
    		<div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | </h2>
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
					
					
					
					
					
                <h2>योजनाको फोटो </h2>
                <div class="userprofiletable myCenter">
               <?php
		    
		$folder_1 = 'yojana_picture/1/'.$plan_id."/";
		$folder_2 = 'yojana_picture/2/'.$plan_id."/";
		$folder_3 = 'yojana_picture/3/'.$plan_id."/";
		$folder_4 = 'yojana_picture/4/'.$plan_id."/";
		$folder_array = array(1=>$folder_1,2=>$folder_2,3=>$folder_3,4=>$folder_4);
$name_array=array(1=>"काम सुरु हुनु भन्दा अगाडी को फोटो ",2=>"मुल्याकन हुन बखतको फोटो",3=>"काम सम्पन्न भएको फोटो",4=>"योजनाको  लागत इस्टमेट, मुल्यांकन सम्बन्धि   फोटो ");

   for($i=1;$i<5;$i++)
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
                                //print_r($photos); exit;
                                //$a=glob($folder_1."/*.*");

                                        foreach ($photos as $b)
                                          {
                                           //  $image='<img src='.$folder_array[$i].$b->pic.' width="100" height="100">';
                                           // echo $image;
                                          ?>
                                      <a href="<?php echo $folder_array[$i].$b->pic; ?>" data-lightbox="lightbox[<?php echo $i; ?>]"><img src='<?php echo 
                                       $folder_array[$i].$b->pic;?>' width="100" height="100"></a>    
                                     <a href="delete_image.php?id=<?php echo $b->id;?>" ><img src="picture/wrong.png" height="10px" width="10px" style="margin-bottom:100px;"></a>
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

		
		?>

                
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
      <link href="lightbox/src/css/lightbox.css" rel="stylesheet">
      <script src="lightbox/src/js/lightbox.js"></script>