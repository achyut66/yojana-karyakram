<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();

if($mode!="administrator" && $mode!="superadmin" && $mode!="user")
{
    die("ACCESS DENIED");
}
$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);
$customer_selected = Costumerassociationdetails0::find_by_plan_id($_SESSION['set_plan_id']);
$details = Costumerassociationdetails::find_by_plan_id($_SESSION['set_plan_id']);
$more_details = Moreplandetails::find_by_plan_id($_SESSION['set_plan_id']);
$address= getAddress();
?>
<?php include("menuincludes/header1.php"); ?>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
    <div id="body_wrap_inner"> 
		<div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
                 <div style="margin: -33px auto 25px auto; text-align: center; font-family: Georgia, Times New Roman, serif; width: 1200px; height: 900px; position: relative;">
        
      <div style="position: absolute; top: 59px; left: 2px;"><img src="images/1100.gif" /></div>
      
        <div style="padding: 130px 198px 9px 99px;">
                        <br>
                        <div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
                        <h5 class="margin1em letter_title_three"> अनुसूची १</h5>
                        <center> (<?php echo SITE_LOCATION;?>को योजना तथा कार्यक्रम सञ्चालन सम्बन्धी कार्यविधि २०७४ को दफा ६ (१) संग सम्बन्धित ) </center>
                          <h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo "उपभोक्ता समिति दर्ता प्रमाणपत्र ।";
                                                }?>
                                            </u>
                                        </div>
                        <div class="myspacer"></div>
                        <div class="printContent">
                            
                            <div class="myspacer"></div>

                            <div class="banktextdetails1">
                            
                                <div class="mycontent">
                                    <table class="table borderless table-responsive">
                                        <tr>
                                            <td> दर्ता नं :- <?=convertedcit($plan_selected->id)?> </td>
                                            <td> </td>
                                            <td> दर्ता मिति :-  <?=convertedcit(generateCurrDate())?> </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">१. उपभोक्ता समितिको नाम :<?= $customer_selected->program_organizer_group_name?> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>२. ठेगाना :-<?= SITE_NAME." - ".convertedcit($customer_selected->program_organizer_group_address)?>  </td>
                                            <td></td>
                                            <td>३. उपभोक्ता समिति गठन भएको मिति :-  <?= convertedcit($more_details->samiti_gathan_date)?> </td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td>४. योजना संचालन हुने स्थान :-  :<?= $customer_selected->place_to_organize?> </td>
                                            <td></td>
                                            <td>५. उद्देश्य :- :<?= $customer_selected->reason?>  </td>
                                            <td></td>
                                        </tr>
                                      
                                        <tr>
                                            <td colspan="4">पदाधिकारीहरुको विवरण :- </td>
                                        </tr>
                                    </table>
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
                             <?php $i=1;foreach($details as $data):
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
                                    <td class="myCenter"><?php echo SITE_NAME.' - '.convertedcit($data->address);?></td>
                                     <td class="myCenter"><?php echo $gender;?> </td>
                                    <td class="myCenter"><?php echo convertedcit($data->cit_no);?></td>
                                    <td class="myCenter"><?php echo $data->issued_district;?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </table>
                            <div class="oursignatureleft" style="float:right; margin-top: 30px;"> चेक/सिफारिस गर्ने       </div>
                                    <div class=""> ७. योजनाको संक्षिप्त विवरण</div>
                                    <br>
                                    <br>
                                    <div class="">८. आन्य </div>
                     
                              

                                </div><!-- bank details ends -->
                                <div class="myspacer"></div>

                            </div>
                        </div>
                    </div>
                  </div>
                </div><!-- main menu ends -->
         
    </div><!-- top wrap ends -->
    