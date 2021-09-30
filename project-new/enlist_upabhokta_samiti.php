<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//error_reporting(1);
  $group_heading = Costumerassociationdetails0::find_by_id($_GET['id']);
  $group_details = Costumerassociationdetails::find_by_plan_id($group_heading->plan_id);
  
   $value="सेभ गर्नुहोस";
   $update = 0; 
  if(!empty($group_heading) || !empty($group_details))
    {
      $value="अपडेट गर्नुहोस"; 
      $update = 1;
    }  
	 if(empty($group_heading))
	  {
		$group_heading = Costumerassociationdetails0::setEmptyObjects();
	  }
 
//echo "<pre>"; print_r($data); echo "</pre>"; exit;
?>

<?php include("menuincludes/header.php"); ?>
<title> <?=$plan_selected->program_name?> :: <?php echo SITE_SUBHEADING;?> </title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
           	
                
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
                                <h2 class="headinguserprofile">उपभोक्ता समिति सम्बन्धी विवरण | <a href="enlist_usamiti.php" class="btn">पछि जानुहोस</a></h2>
		 
               <?php if(!empty($group_details)): ?>                 
                                
            
              
                <div class="userprofiletable">
                   <h3>उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                                <div class="inputWrap50">
                                	<div class="titleInput">योजनाको संचालन गर्ने  उपभोक्ता समितिको नाम:</div>
                                        <div class="newInput"><b><?= $group_heading->program_organizer_group_name ?></b></div>
                                        <div class="titleInput">योजनाको संचालन गर्ने  उपभोक्ता समितिको ठेगाना: <span class="underline"><b><?php echo SITE_LOCATION;?></b> </span></div>
                                    <div class="newInput">वार्ड नम्बर : <b><?= convertedcit($group_heading->program_organizer_group_address) ?></b></div>
                                <div class="newInput">उपभोक्ता समिति दर्ता नं: <b><?= convertedcit($group_heading->id) ?></b></div>
                                	
                                    <div class="myspacer"></div>
                                </div><!-- input wrap 50 ends -->
                    
         
                    <table class="table table-bordered">
                               <tr>
                                    <td class="thWidth4 myCenter"><strong>सि.नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नाम/थर</strong></td>
                                    <td class="thWidth5 myCenter"><strong>वडा नं</strong></td>
                                    <td class="thWidth5 myCenter"><strong>लिङ्ग :</strong></td>
                                    <td class="thWidth17 myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="thWidth17 myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="thWidth17 myCenter"><strong>मोबाइल  नं</strong></td>
                                    
                                </tr>
               
                  
                    <h3 class="myheader">उपभोक्ता समिति</h3>
                                                         
                                    <?php $i = 1; foreach($group_details as $group_detail): 
                                        $postname = Postname::find_by_id($group_detail->post_id);
                                       // print_r($postname);exit;
                                        switch($group_detail->gender):
                                            case 1:
                                           $gender = "पुरुष";
                                            break;
                                            case 2:
                                           $gender = "महिला";
                                            break;
                                            case 3:
                                           $gender = "अन्य";
                                            break;
                                            default :
                                           $gender="-";
                                        endswitch;
                                    
                                        
                                        ?>
                                  
                                 
                                    <td><?=$i?></td>
                                     <td>
                                       <?= $postname->name ?>
                                     </td>
                                    <td><?=$group_detail->name?></td>
                                    <td>
                                         <?= convertedcit($group_detail->address) ?>
                                     </td>
                                    <td> 
                                        <?= $gender  ?>
                                     </td>
                                    <td><?= convertedcit($group_detail->cit_no) ?></td>
                                    <td><?=$group_detail->issued_district?></td>
                                    <td><?= convertedcit($group_detail->mobile_no) ?></td>
                                 </tr>
                               <?php $i++; endforeach; ?>
                            
                                <tbody id="detail_add_table"  class="detail_post table table-bordered table-responsive">
                                
                            </tbody>
                            </table>
                         <?php endif; ?>
                           	
                                          


            
                </div>
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>