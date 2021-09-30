<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$plan_id= $_GET['plan_id'];
$folder_3 = 'yojana_picture/3/'.$plan_id."/";
?>
<?php include("menuincludes/header1.php"); ?>
<?php

?>
<body>

  <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
            <h4 class="headinguserprofile"> काम सम्पन्न भएको फोटो</h4>
            
         
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
            
				

        
                                  
                                           <div style="text-align:center;">
                                           <?php    
                                              if(folder_exist($folder_3))
                {      
                            if (dir_is_empty($folder_3))
                            {
                                echo "पी डी एफ भेटिएन <br><br> ";
                            }
                            else
                            {
                                $photos = Upload::find_photos_by_planid_and_type_id($plan_id,3);
//                                echo $folder_3."<br>";
//                                print_r($photos); exit;
                                //$a=glob($folder_1."/*.*");

                                        foreach ($photos as $b)
                                          {
                                           //  $image='<img src='.$folder_array[$i].$b->pic.' width="100" height="100">';
                                           // echo $image;
                                          ?>
                                               <div class="imgBox"><img src=' <?=$folder_3.$b->pic?>' width="100" height="100" style="float:right"></div> 
                                       
                                          <?php
                                            //echo $folder_1.'/'.$photo->pic;
                                          }
                                       
                            }
                }
                ?>  
                         </div>
   

                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->