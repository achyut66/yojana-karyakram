<?php require_once("includes/initialize.php"); 
error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
 $ward_address=WardWiseAddress();
 $address= getAddress();
   $inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
?>
    <?php
    $program_id=$_GET['id'];
    $data1= Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
    $sn_result= Programpaymentdepositreturn::find_by_program_id($program_id);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
        if(isset($_POST['submit']))
        {
            $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $_POST['sn']);
             if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                        //   print_r($u_samiti);exit;
                           $name= $u_samiti->program_organizer_group_name;
                            $address1 = SITE_LOCATION.', वडा न: '.convertedcit($u_samiti->program_organizer_group_address);
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);  
                             $address1 = Enlist::getAddress($program_more_details->enlist_id);
                       }   
            $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $_POST['sn']);
            $program_payment= Programpayment::find_by_program_id_and_sn($_GET['id'],$_POST['sn']);
            $period= Programpaymentdepositreturn::maxPeriodForProgram($program_id, $_POST['sn']);
            $program_deposit_return=Programpaymentdepositreturn::find_by_program_id_sn_and_period($program_id,$_POST['sn'],$period);
          
        }
        
        
        ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>रकम भुक्तानी सम्बन्धमा ।  print page:: Kanepokhari Gaupalika</title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">विषय:- धरौटी फिर्ता सम्बन्धि || <a href="letters_select_programs.php" class="btn">पछी जानुहोस </a> </h2>
                   
                    <div class="OurContentFull" >
                          <form method="post">
                           <table class="table table-bordered">
                                            <tr>
                                            <td>कार्यादेश नं:</td>
                                            <td>
                                                 <select required class="sn1" name="sn">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($sn_result as $sn):?>
                                                    <option value="<?= $sn->sn ?>"><?= $sn->sn ?></option>
                                                    <?php endforeach;?>
                                                    <input type="hidden" value="<?= $program_id ?>" id="program_id1">
                                                </select>   
                                            </td>
                                            </tr>
                                            <tr class="enlist2">
                                                
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <input type="submit" value="खोज्नुहोस" name="submit" class="btn"/>
                                                </td>
                                            </tr>
                                        </table>                           
                        </form>
                        <?php if(!empty($program_deposit_return)):?>
                    	<h2>विषय:- धरौटी फिर्ता सम्बन्धि ।</h2> 
                       	<form method="get" action="print_karyadesh_report_14_final.php?id=<?=$_GET['id']?>" target="_blank" >
                            <div class="myPrint"><input type="hidden" name="id" value="<?=$program_id?>" />
                            <input type="hidden" name="detail_id" value="<?=$program_more_details->id?>" />
                            <input type="hidden" name="sn" value="<?=$_POST['sn'] ?>" />
                            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                                         <h1 class="margin1em letter_title_one">कानेपोखरी गाउँपालिका</h1>
												<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
												<h5 class="margin1em letter_title_three"><?php echo $ward_address;?> मोरंग</h5>
                                    <div class="subjectbold letter_subject">टिप्पणी आदेश</div>
                                    </div>
									<div class="myspacer"></div>
									
									<div class="printContent">
											<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate(); ?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										
<div class="chalanino">कार्यक्रम दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
										<div class="myspacer20"></div>
										
										<div class="subject">   विषय:- धरौटी फिर्ता सम्बन्धि ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्रीमान् 
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न <?= $name ?>लाई मिति <?= convertedcit($program_more_details->work_order_date)  ?>  मा कार्यदेश दिईएकोमा तोकिएको समय भित्रै काम सम्पन गरि  <?= $inst_array[$program_deposit_return->period] ?> धरौटी  रकम फिर्ता  माग गरेकाले तपशिल बमोजिम धरौटी फिर्ता  दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                 
                                            <table class="table table-bordered table-responsive myWidth100">
                                                <tr>
                                                	<td class="myWidth50">कार्यादेश नं: </td>
                                                    <td> <?php echo convertedcit($program_more_details->sn);?></td>
                                                </tr>                                            	
                                                <tr>
                                                	<td >बिनियोजीत स्रोत :  </td>
                                                    <td><?php echo $data1->parishad_sno ;?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यक्रमको नाम : </td>
                                                    <td><?php echo convertedcit($data1->program_name);?></td>
                                                </tr>
                                                <tr>
                                                	<td>भुक्तानी पाउनेको नाम: </td>
                                                    <td><?= $name ?></td>
                                                </tr>
                                                <tr>
                                                	<td>भुक्तानी पाउनेको ठेगाना: </td>
                                                    <td><?= $address1 ?></td>
                                                </tr>
                                               
                                                <tr>
                                                	<td>कार्यादेश  दिईएको रकम : </td>
                                                        <td>रु. <?php echo convertedcit(placeholder($program_more_details->work_order_budget));?></td>
                                                </tr>
                                              
                                                <!-- change made-->
                                               
                                                <tr>
                                                	<td>धरौटी कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($program_payment_final->deposit_amount));?></td>
                                                </tr>
                                                <tr>
                                                    <td>धरौटी फिर्ता रकम : </td>
                                                    <td> रु.<?php echo convertedcit(placeholder($program_deposit_return->deposit_amount));?></td>
                                                </tr>

                                            </table>
                                        </div>
                                     
										
										<div class="myspacer20"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>
									</div>
									 <?php endif ;?>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>