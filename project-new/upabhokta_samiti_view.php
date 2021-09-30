<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">कार्यक्रम संचालन गर्ने उपभोक्ता समिति विवरण  | <a href="tol_bikash_samiti_profile_view.php" class="btn">पछि जानुहोस 
</a></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
  
                       <?php $data2= Upabhoktasamitiprofile::find_by_id($_GET['id']);?>
                        <?php if(empty($data2)){?><h3  class="myheader">कार्यक्रम संचालन गर्ने उपभोक्ता समिति सम्बन्धी विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3  class="myheader">उपभोक्ता समिति सम्बन्धी विवरण </h3>
                        <div class="mycontent"><?php 
                                $data3= Upabhoktasamitidetails::find_by_tol_id($_GET['id']);?>
                            <div class="inputWrap100">
                            	<div class="inputWrap50 inputWrapLeft">
                                    <div class="titleInput"><b>कार्यक्रम संचालन गर्ने उपभोक्ता समितिको नाम:</b> <span class="underline">&nbsp;&nbsp;<u><?php echo $data2->program_organizer_group_name;?></u></span></div>
                                </div><!-- input wrap 50 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput"><b>ठेगाना:</b> <span class="underline"> &nbsp;&nbsp;<u><?php echo SITE_NAME." - ".convertedcit($data2->program_organizer_group_address);?></u></span></div>
                                </div><!-- input wrap 50 ends -->
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                            
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>ठेगाना</strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="myCenter"><strong>मोबाइल नं</strong></td>
                                    
                                </tr>
                             <?php $i=1;foreach($data3 as $data):
                                 if($data->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($data->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                                 
                                 ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"> <?php echo Postname::getName($data->post_id);?> </td>
                                    <td class="myCenter"><?php echo $data->name;?></td>
                                    <td class="myCenter"><?php echo SITE_NAME." - ".convertedcit($data->address);?></td>
                                     <td class="myCenter"><?php echo $gender;?> </td>
                                    <td class="myCenter"><?php echo convertedcit($data->cit_no);?></td>
                                    <td class="myCenter"><?php echo $data->issued_district;?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </table>
                        </div>
                        <?php } ?>
                       
                          </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>