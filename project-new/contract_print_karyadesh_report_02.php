<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
}
$ward_address=WardWiseAddress();
        $address= getAddress();
$data=  Contractentryfinal::find_by_status(1,$_GET['id']);
$contractor_details=  Contractordetails::find_by_id($data->contractor_id);
    $data1=  Plandetails1::find_by_id($_GET['id']);
    $fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
 $result= Contractmoredetails::find_by_plan_id($_GET['id']);
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्यादेश  पत्र । print page:: <?php echo SITE_SUBHEADING;?></title>
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
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">कार्यादेश | पत्र <a class="btn" href="contract_letter_dashboard.php"> पछी  जानुहोस </a> </h2>
                  
                    <div class="OurContentFull" >
                        <form method="get" action="contract_print_karyadesh_report_02_final.php">
                    	<h2>कार्यादेश पत्र  दिईएको बारे ।
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div></h2>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                    <div class="myspacer"></div>
                                    
									
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino"> योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer"></div>
										
											<div class="subject"><u>विषय:- कार्यादेश दिईएको बारे ।</u></div>
										<div class="myspacer"></div>
                                                                                <div class="bankname">श्री <?php echo $contractor_details->contractor_name; ?><br/>
                                                                                  <?= $contractor_details->contractor_address?>
                                       
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											
                                                                                          यस कार्यालयको स्वीकृत बार्षिक योजना अनुसार तपशिलको विवरणमा उल्लेख भए बमोजिमको योजना संचालन गर्न  मिति <?=  convertedcit($result->miti) ?> गते तपाई सँग भएको संझौतामा उल्लिखत शर्तहरु लागु हुने गरी यस कार्यालयको मिति <?=  convertedcit($result->work_order_date) ?> को निर्णय अनुसार यो कार्यादेश दिईएको छ । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">आर्थिक बर्ष : </td>
                                                    <td><?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?></td>
                                                </tr>
                                                <tr>
                                                <td>योजनाको नाम : </td>
                                                <td><?php echo $data1->program_name; ?></td>
                                          </tr>
                                           <tr>
                                               <td>बिषयगत क्षेत्र किसिम : </td>
                                               <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>शिर्षकगत किसिम : </td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td>उपशिर्षकगत किसिम :  </td>
                                                    <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td>विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                <tr>	
                                                	<td>कार्यादेश दिईएको रकम रु : </td>
                                                    <td>रु.<?php echo convertedcit(placeholder($result->work_order_budget));?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना संचालन हुने स्थान :  </td>
                                                    <td><?php echo convertedcit($result->venue);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($result->start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($result->completion_date);?></td>
                                                </tr>
                                                
                                                

                                            </table></form>
                                        </div>
                                        <div class="myspacer20"></div>
                                        <div class="oursignature mymarginright"> सदर गर्ने <br> 
                                                                                    <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
										<!--<div class="oursignatureleft mymarginright"> तयार गर्ने  <br/>-->
          <!--                                                                          <select name="worker2" class="form-control worker" id="worker_2">-->
          <!--                                                                              <option value="">छान्नुहोस्</option>-->
          <!--                                                                              <?php foreach($workers as $worker){?>-->
          <!--                                                                              <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>-->
          <!--                                                                              <?php }?>-->
          <!--                                                                          </select>-->
          <!--                                                                          <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">-->
          <!--                                                                      </div>-->
                                        <div class="oursignatureleft mymarginright"> योजना शाखा   <br/>
                                            <select name="worker3" class="form-control worker" id="worker_3">
                                                <option value="">छान्नुहोस्</option>
                                                <?php foreach($workers as $worker){?>
                                                <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                <?php }?>
                                            </select>
                                            <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                                        </div>
                                        <!--<div class="oursignatureleft margin4"> आर्थिक प्रशासन शाखा <br/> -->
                                        <!--    <select name="worker4" class="form-control worker" id="worker_4">-->
                                        <!--        <option value="">छान्नुहोस्</option>-->
                                        <!--        <?php foreach($workers as $worker){?>-->
                                        <!--        <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>-->
                                        <!--        <?php }?>-->
                                        <!--    </select>-->
                                        <!--    <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>"></form>-->
                                        <!--</div>-->
										
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                     
                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>