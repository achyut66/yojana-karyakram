<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

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
?>
    <?php $data1 =  Plandetails1::find_by_id($_GET['id']);//print_r($data1);
    $data2 =  Moreplandetails::find_by_plan_id($_GET['id']);//print_r($data2);
    $data3 =  Costumerassociationdetails0::find_by_plan_id($_GET['id']);//print_r($data3);
    $data4 = Plantotalinvestment::find_by_plan_id($_GET['id']);
    //print_r($data4);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$costumer_ass = Costumerassociationdetails::find_by_plan_id($_GET['id']);//print_r($costumer_ass);
	//$group_heading = Costumerassociationdetails::find_by_plan_id ($_GET['id']);
	?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना हस्तान्तरण सम्झौता । print page:: <?php echo SITE_SUBHEADING;?></title>
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
    	    <form method="get" action="yojana_hastantaran_samjhauta_print.php">
                    <h2 class="headinguserprofile">सिफारिस सम्बन्धमा | <a href="dashboard_bhuktani.php" class="btn">पछि जानुहोस</a> 
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    </h2>
                    <div class="OurContentFull" >
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
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                        <div class="myspacer20"></div>
										<div class="subject"><u>विषय:- योजना हस्तान्तरण संझौता  |</u></div>
									<div class="banktextdetails">
										<br>१. योजनाको नाम :-<span>
										    <strong><u><?php echo $data1->program_name;?></u></strong>
										</span>
										<br>२. योजना रहेको स्थान :-<span>
										    <strong><u><?php echo $data3->program_organizer_group_name.'-'.'वडा नं'.' '.convertedcit($data3->program_organizer_group_address)?></u></strong>
										</span>
										<br>३. लागत अनुमान :-<span>
										    रु.<strong><?php echo convertedcit($data1->investment_amount)?></strong>/-
										</span>
										<br>४. खुद लागत :-<span>
										    रु. <strong><?php echo convertedcit($data4->total_investment)?></strong>/-
										</span>
										<br>५. योजना सम्पन्न मिति :-<span> 
										    <strong><?php echo convertedcit($data2->yojana_sakine_date)?></strong>
										</span>
										<br>६. जाँचपास मिति :-<span>
										    _ _ _ _/_ _/_ _
										</span>
										<br>७. हस्तान्तरणका शर्तहरु :-<span></span>
										<div class="" style="margin-left:35px">
										<br><span>
										    क) <?php echo SITE_TYPE;?> समेतको श्रोतबाट निर्मित योजनाको संरक्षण उपभोक्ता समिति/उपभोक्ता स्वयंले गर्नुपर्ने छ ।
										</span><br>
										<span>
										    ख) स्तरोन्नतीको काम बाहेक मर्मत संहारकोलागि गा.पा.बाट श्रोत लगानी गरिने छैन । 
										</span><br>
										<span>
										    ग) उपभोक्ताबाट पूर्ण संरक्षण, नियमित र्मतसंहार गरिएको योजनाहरुमात्र आगामी आ.व.हरुमा योजना स्तरोन्नतीको लागि गा.पा.ले प्राथमिकता दिने छ ।
										</span><br>
										<span>
										    घ) नयाँ ट्रयाक खोलिएको सडकको हकमा सडकको भित्ता तर्फ नाली निर्माण गरि सडकको संरक्षण, खाल्टा          खुल्टी पुर्ने जस्ता मर्मत संभारका कार्य उपभोक्ताले गर्नुपर्ने छ, नगरेमा उक्त नयाँ सडकको पुन निर्माण र भविश्यमा स्तरोन्नती गा.पा. बाट गरिने छैन । 
										</span><br>
										<span>
										    ङ) सिचाइ कुलोको हकमा उक्त कूलोबाट सिंचित खेतधनी मात्र उपभोक्ता मानिने छ । 
										</span><br>
										<span>
										    च) खाने पानी वितरण लाइनको मर्मत संभार गा.पा. श्रोतबाट हुने छैन, उपभोक्ता स्वयंले गर्नु पर्ने छ ।
										</span><br>
										<span>
										    छ) खानेपानी पूर्ण ब्यवस्थित भइ धारा वितरण पश्चात दर्तावाल उ.स.द्वारा सशुल्क वितरण गर्ने र उठेको       शुल्कबाट एक कोष खडागरी नियमित मर्मत संभारको ब्यावस्था समन्धित उ.स.ले उक्त कोषबाट गर्नु पर्ने छ ।
										</span>
										</div>
									</div>
										<div class="myspacer30"></div>
										<div class="oursignatureleft mymarginright">वडाध्यक्ष<br/>
                                                                                     <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
										<div class="oursignature mymarginright">उपभोक्ताको तर्फबाट<br>
										<?php $i=1; foreach($costumer_ass as $cs):?>
										    <table class="table-bordered table-responsive">
										        <tr>
										            <td width="33%"><?php echo convertedcit($i).')'.'.'.$cs->name?></td>
										            <td placeholder="fsdfsfds"></td>
										        </tr>
										    </table>
										<?php $i++; endforeach;?>
									</div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->