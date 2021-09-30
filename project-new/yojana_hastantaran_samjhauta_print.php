<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$date_selected= $_GET['date_selected'];
$url = get_base_url();
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];
$print_history->save();
if(!empty($_GET['worker1']))
{
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker2']))
{
$worker2 = Workerdetails::find_by_id($_GET['worker2']);
}
else
{
    $worker2 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker3']))
{
$worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker4']))
{
$worker4 = Workerdetails::find_by_id($_GET['worker4']);
}
else

{
    $worker4 = Workerdetails::setEmptyObject();
}
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$costumer_ass = Costumerassociationdetails::find_by_plan_id($_GET['id']);//print_r($costumer_ass);
	?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title> सिफारिस सम्बन्धमा | print page:: <?php echo SITE_SUBHEADING;?></title>
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
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="image-wrapper">
                                    
                                    <div class="textCenter" style="font-size:22px"><u><?php echo SITE_LOCATION;?> र उपभोक्ता समितिविच भएको योजना हस्तान्तरण संझौता ।</u></div>
									<div class="myspacer20"></div>
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
										<div class="oursignatureleft mymarginright" style="margin-right: 5%;">वडाध्यक्ष<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="oursignature mymarginright">उपभोक्ताको तर्फबाट<br>
										<?php $i=1; foreach($costumer_ass as $cs):?>
										    <table class="table-bordered">
										        <tr>
										            <td width="45%"><?php echo convertedcit($i).' '.')'.$cs->name?></td>
										            <td>&nbsp;</td>
										        </tr>
										    </table>
										<?php $i++; endforeach;?>
									</div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->