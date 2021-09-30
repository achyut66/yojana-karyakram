<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$two_digit=array(0=>"",1=>"एक",2=>"दुइ",3=>"तीन",4=>"चार",5=>"पाच",6=>"छ",7=>"सात",8=>"आठ",9=>"नौ",10=>"दश",11=>"एघार",12=>"बाह्र",13=>"तेह्र",14=>"चौध",15=>"पन्ध्र" ,16=>"सोह्र",
    17=>"सत्र",18=>"अठार",19=>"उन्नाइस",20=>"बिस",21=>"एक्काइस", 22=>"बाइस", 23=>"तेईस", 24=>"चौविस", 25=>"पच्चिस", 26=>"छब्बिस", 27=>"सत्ताइस", 28=>"अठ्ठाईस", 29=>"उनन्तिस", 
    30=>"तिस", 31=>"एकत्तिस", 32=>"बत्तिस", 33=>"तेत्तिस" ,34=>"चौँतिस", 35=>"पैँतिस", 36=>"छत्तिस", 37=>"सैँतीस", 38=>"अठतीस", 39=>"उनन्चालीस", 
    40=>"चालीस", 41=>"एकचालीस", 42=>"	बयालीस", 43=>"त्रियालीस", 44=>"चवालीस", 45=>"पैँतालीस", 46=>"छयालीस", 47=>"सच्चालीस", 48=>"अठचालीस", 49=>"उनन्चास", 
    50=>"पचास", 51=>"एकाउन्न", 52=>"बाउन्न", 53=>"त्रिपन्न", 54=>"चउन्न", 55=>"पचपन्न", 56=>"छपन्न", 57=>"सन्ताउन्न", 58=>"अन्ठाउन्न", 59=>"उनन्साठी", 
    60=>"साठी", 61=>"एकसट्ठी", 62=>"बयसट्ठी", 63=>"त्रिसट्ठी", 64=>"चौंसट्ठी", 65=>"पैंसट्ठी", 66=>"छयसट्ठी", 67=>"सतसट्ठी", 68=>"अठसट्ठी", 69=>"उनन्सत्तरी", 
    70=>"सत्तरी", 71=>"एकहत्तर", 72=>"बहत्तर", 73=>"त्रिहत्तर", 74=>"चौहत्तर", 75=>"पचहत्तर", 76=>"छयहत्तर", 77=>"सतहत्तर", 78=>"अठहत्तर", 79=>"उनासी", 
    80=>"असी", 81=>"एकासी", 82=>"बयासी", 83=>"त्रियासी", 84=>"चौरासी", 85=>"पचासी", 86=>"छयासी", 87=>"सतासी", 88=>"अठासी", 89=>"उनान्नब्बे", 
    90=>"नब्बे", 91=>"एकान्नब्बे", 92=>"बयानब्बे", 93=>"त्रियान्नब्बे", 94=>"चौरान्नब्बे", 95=>"पन्चानब्बे", 96=>"छयान्नब्बे", 97=>"सन्तान्नब्बे", 98=>"अन्ठान्नब्बे", 99=>"उनान्सय");
$matra="मात्र |";
  $data1=  Plandetails1::find_by_id($_GET['id']);
    	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
         $data=  Contract_bid::find_by_plan_id($_GET['id']);
         $result= Contractmoredetails::find_by_plan_id($_GET['id']);
         $data2=Contractstartingfund::find_by_plan_id($_GET['id']);
         $data3=  Contractinfo::find_by_plan_id($_GET['id']);
       $data4= Contractentryfinal::find_by_plan_id($_GET['id']);
         $data5=  Contractentryfinal::find_by_status(1,$_GET['id']);
         $name=  Contractordetails::find_by_id($data5->contractor_id);
         
 $ward_address=WardWiseAddress();
 $address= getAddress();
 $date_selected= $_GET['date_selected'];
$url = get_base_url();
$user = getUser();
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
$print_history->type_name1 = $_GET['type_name1'];
// $print_history->type_name2 = $_GET['type_name2'];
// $print_history->type_name3 = $_GET['type_name3'];
// $print_history->type_name4 = $_GET['type_name4'];
// $print_history->letter_type = $_GET['letter_type'];

$print_history->save();
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
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
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>ठेक्का संझौता सम्बन्धमा :: Print page:: <?php echo SITE_SUBHEADING;?></title>
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
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
                                    <div style="color:red">
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
									</div>
                    <div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div></div>
									
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:- ठेक्का सम्झौता गर्ने सम्बन्धमाबन्धमा |</div>
										<div class="myspacer20"></div>
                                                                     
                                                                               <div class="bankname">श्रीमान् </div>
										<div class="banktextdetails"  >
                                                                                    यस कार्यालयको आ.ब <?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?> को कार्यक्रम अनुसार  <b><u><?php echo$data1->program_name;?></u></b> योजना ठेक्का मार्फत संचालन गर्ने गरी मिति  <?php echo convertedcit($data3->created_date);?> मा  सुचना प्रकाशन गरिएकोमा उक्त योजना ठेक्का मार्फत संचालन गर्न तपशिल बमोजिमका फर्म/कम्पनीले ठेक्काको बोलपत्र पेश भएको। 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                              <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td>सि.नं</td>
                                                    <td>फर्म/कम्पनीको नाम</td>
                                                    <td>ठेगाना</td>
                                                    <td>कबोल रु अंकमा( भ्याट बाहेक  )</td>
                                                     <td>कबोल रु अंकमा (भ्याट सहित) </td>
                                                    <td>कबोल रु अक्षरमा </td>
                                                    <td>कैफियत</td>
                                                    
                                                </tr>
                                                <?php $i=1;
                                                foreach($data4 as $data):
                                                    if(!empty($data))
                                                    {
                                                     $result= Contractordetails::find_by_id($data->contractor_id);
//                                                     print_r($result);exit;
                                                    }
                                                $contract_bid_final=  Contractbidfinal::find_by_contractor_id($data->contractor_id, $data->plan_id);

                                                    ?>
                                                <tr>
                                                    <td><?php echo convertedcit($i);?></td>
                                                   <td><?php echo $result->contractor_name;?></td>
                                                    <td><?php echo $result->contractor_address;?></td>
                                                      <td><?= convertedcit(placeholder($data->bid_amount))?></td>
                                                    <td><?= convertedcit(placeholder($data->total_bid_amount))?></td>
                                                    <td><?php echo convert($data->total_bid_amount);?></td>
                                                    <td><?php echo $contract_bid_final->details;?></td>
                                                </tr>
                                                <?php $i++;endforeach;?>

                                            </table>
                                        </div>
                                        <div class="bankdetails">
                                          माथि उल्लेखित फर्म/कम्पनीहरुबाट प्राप्त बोलपत्र प्रस्ताब मध्ये सबै भन्दा घटी कबोल गर्ने श्री <?php echo $name->contractor_name;?> को रित पुर्बकको कबोल अंक सबै भन्दा घटी रकम ( भ्याट बाहेक ) रु <?php echo convertedcit(placeholder($data5->bid_amount));?>   अक्षरुपी <?= convert($data5->bid_amount)?> मात्र भएकाले सार्बजनिक खरिद ऐन  २०६३ को नियम २५ बमोजिम निज सँग ठेक्का संझौताको लागी निर्णयार्थ यो टिप्पणी पेश गरेको छु । 
                                        </div>
										<div class="myspacer30"></div>
	
<div class="oursignature mymarginright"> सदर गर्ने  <br>
<?php 
    if(!empty($worker1))
    {
        echo $worker1->authority_name."<br/>";
        echo $worker1->post_name;
    }
?>
</div>
<div class="oursignatureleft mymarginright">तयार गर्ने  <br/>
    <?php 
        if(!empty($worker2))
        {
            echo $worker2->authority_name."<br/>";
            echo $worker2->post_name;
        }
    ?>
</div>

<div class="oursignatureleft mymarginright"> पेश गर्ने <br/> 
<?php 
    if(!empty($worker3))
    {
        echo $worker3->authority_name."<br/>";
        echo $worker3->post_name;
    }
?>
</div>

<div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने   <br/>
    <?php 
        if(!empty($worker4))
        {
            echo $worker4->authority_name."<br/>";
            echo $worker4->post_name;
        }
    ?>
</div>
<div class="myspacer"></div>
										
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->