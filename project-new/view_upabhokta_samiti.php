<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//$sql="select * from plan_details1 where sn='".$_POST['name']."' limit 1";


?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">उपभोक्ता समिति  विवरण हेर्नुहोस| <a href="upabhokta_details_report.php" class="btn">पछि जानुहोस 
</a></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
  
                       <?php $data2=Costumerassociationdetails0::find_by_plan_id($_GET['plan_id']);?>
                        <?php if(empty($data2)){?><h3  class="myheader">उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3  class="myheader">उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                        <div class="mycontent"><?php 
                                $data3=Costumerassociationdetails::find_by_plan_id($_GET['plan_id']);?>
                            <div class="inputWrap100">
                            	<div class="inputWrap50 inputWrapLeft">
                                	<div class="titleInput">योजनाको संचालन गर्ने समितिको नाम: <span class="underline"><?php echo $data2->program_organizer_group_name;?></span></div>
                                </div><!-- input wrap 50 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">ठेगाना: <span class="underline"><?php echo SITE_NAME.convertedcit($data2->program_organizer_group_address);?></span></div>
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
                                    <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->address);?></td>
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