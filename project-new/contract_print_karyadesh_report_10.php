<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$datas= Contractentryfinal::find_by_plan_id($_SESSION['set_plan_id']);
if(isset($_POST['submit']))
{
    $contractor_id=$_POST['contractor_id'];
    redirect_to("contract_print_karyadesh_report_10.php?id=".$_SESSION['set_plan_id']."&contractor_id=".$_POST['contractor_id']);
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
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>धरौटी फिर्ता सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">धरौटी फिर्ता  पत्र || <a href="contractdharauti_dashboard.php" class="btn">पछि जानुहोस </a> </h2>
                   
                   <div class="bankReport">
                            <form method="post">
                                निर्माण ब्य्वोसायी  छान्नुहोस :
                                <select name="contractor_id">
                                    <option value="">छान्नुहोस् </option>
                                    <?php foreach($datas as $data):?>
                                    <option value="<?php echo $data->id;?>" <?php if($data->id == $contractor_id){ echo 'selected="selected"';}?>><?php echo Contractordetails::getName($data->contractor_id);?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="submit" name="submit" value="खोज्नुहोस "/>
                            </form>
                        </div>
                     <?php if(isset($_GET['contractor_id'])){
                      $contract_final=  Contractentryfinal::find_by_id($_GET['contractor_id']);
                     $contractor_details=  Contractordetails::find_by_id($contract_final->contractor_id);
                     $data1=  Plandetails1::find_by_id($_GET['id']);
                     $fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
                     $result= Contractmoredetails::find_by_plan_id($_GET['id']);
                     $contract_info=  Contractinfo::find_by_plan_id($_GET['id']);
                    $data= Contractentryfinal::find_by_id($_GET['contractor_id']);
//                    print_r($data);exit;
                    $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                     $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_SESSION['set_plan_id']);
                    if($data->status==1)
                    {
                        $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$data->id);
                        $analysis_amount=  Contractanalysisbasedwithdraw::getTotalDharautiPayableAmount($_SESSION['set_plan_id']);
                        $final_amount=  Contractamountwithdrawdetails::find_by_plan_id($_SESSION['set_plan_id']);
                        $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount + $analysis_amount + $final_amount->final_due_amount;
                        $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
                       $final_amount=$final_dharauti_amount - $amount;
                        $max_count=  Contractdharautifirta::getMaxInsallmentByPlanIdAndContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
                       $total_result=  Contractdharautifirta::find_by_max_plan_and_contractor($max_count,$_SESSION['set_plan_id'],$_GET['contractor_id']);
                    }
                    else
                    {
                        $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$data->id);
                        $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_GET['id']);
                         $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount;
                        $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
                       $final_amount=$final_dharauti_amount - $amount;
                       $max_count=  Contractdharautifirta::getMaxInsallmentByPlanIdAndContractorId($_SESSION['set_plan_id'],$_GET['contractor_id']);
                       $total_result=  Contractdharautifirta::find_by_max_plan_and_contractor($max_count,$_SESSION['set_plan_id'],$_GET['contractor_id']);
                    }
                    $step_count_result = Contractdharautifirta::find_by_contractor_id_plan_id($data->id,$_SESSION['set_plan_id']);
                    $count = count($step_count_result);
                    echo $count;
                    $setp_array=array();
            
                  for($i=1;$i<=$count;$i++)
                   {
                       array_push($setp_array, $inst_array[$i]);
                   }
        
                         ?>
                    <div class="OurContentFull" >
                    	<h2>धरौटी फिर्ता पत्र बारे ।</h2>
                       
                        <div class="myPrint"><a href="contract_print_karyadesh_report_10_final.php?id=<?php echo $_SESSION['set_plan_id'];?>&contractor_id=<?php echo $_GET['contractor_id'];?>" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                     	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
	                                <h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
								    <h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
                                    
									
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino"> योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:-धरौटी फिर्ता सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
                                                                                <div class="bankname">श्रीमान्
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत बार्षिक योजना अनुसार देहायको योजना  ठेक्का मार्फत संचालन गर्न मिति <?php echo convertedcit($contract_info->created_date);?> को ठेक्का सुचना अनुसार श्री <?php echo $contractor_details->contractor_name;?> को नाममा रहेको धरौटी रकम नियम अनुसार  फिर्ताका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु ।
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
                                                	<td>फर्म/कम्पनीको नाम: </td>
                                                    <td><?php echo $contractor_details->contractor_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td>ठेगाना: </td>
                                                    <td><?php echo $contractor_details->contractor_address;?></td>
                                                </tr>
                                                <tr>
                                                	<td>जम्मा धरौटी कट्टी रकम :: </td>
                                                    <td><?php echo convertedcit(placeholder($final_dharauti_amount));?></td>
                                                </tr>
                                                 <tr>
                                                	<td> हाल सम्म फिर्ता भएको जम्मा धरौटी रकम <?=getInstString($setp_array)?> </td>
                                                    <td><?php echo convertedcit(placeholder($amount));?></td>
                                                </tr>
                                               
                                                <tr>
                                                	<td>बाँकि धरौटी कट्टी रकम :: </td>
                                                    <td><?php echo convertedcit(placeholder($final_amount));?></td>
                                                </tr>

                                            </table>
                                        </div>
										
										<div class="myspacer"></div>
									</div>
                            
                                
                            </div>
                     
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
                     </div><!-- top wrap ends --><?php };?>
    <?php include("menuincludes/footer.php"); ?>