<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
//print_r($_POST);exit;
{
  redirectUrl();
}
if(isset($_POST['submit']))
{
    $data = new AnugamanPatra();
    
    $data->plan_id = $_POST['plan_id'];
    $data->thek = $_POST['thek'];
    $data->anugaman = $_POST['anugaman'];
    $data->prabidhik = $_POST['prabidhik'];
    $data->hording = $_POST['hording'];
    $data->khata = $_POST['khata'];
    $data->samuday = $_POST['samuday'];
    $data->kista = $_POST['kista'];
    $data->bhautik = $_POST['bhautik'];
    $data->udeshya = $_POST['udeshya'];
    $data->samasya = $_POST['samasya'];
    $data->prayas = $_POST['prayas'];
    $data->sujhab = $_POST['sujhab'];
    $data->sujhab1 = $_POST['sujhab1'];
    
    $data->save();
    //print_r($data);
}
$anugaman_details = AnugamanPatra::find_by_id($_GET['id']);
//print_r($anugaman_details);
$ward_address=WardWiseAddress();
$address= getAddress(); 
$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
//        print_r($datas);exit;
$worker=Moreplandetails::find_by_plan_id($_GET['id']);
$rules_result = Rule::find_by_plan_id($_GET['id']);
$date_selected= $_GET['date_selected'];
$url = get_base_url();
$user = getUser();
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$workers = Workerdetails::find_all();
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];
$print_history->worker5 = $_GET['worker5'];
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
if(!empty($_GET['worker5']))
{
  $worker5 = Workerdetails::find_by_id($_GET['worker5']);
}
else
{
  $worker5 = Workerdetails::setEmptyObject();
}
if(empty($print_history))
{
  $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->save();
?>
<?php $data1=  Plandetails1::find_by_id($_GET['id']);
$invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']); 
$more_plan_details = Moreplandetails::find_by_plan_id($_GET['id']);
$data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
?>
<?php $data=  Plandetails1::find_by_id($_GET['id']);

$fiscal = FiscalYear::find_by_id($data->fiscal_id);

?>
<?php $profitable_family= Profitablefamilydetails::find_by_plan_id($_GET['id']); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>अनुगमन संझौता फाराम  print page:: <?php echo SITE_SUBHEADING;?></title>
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
      <h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
      <h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
      <h4 class="marginright1 letter_title_two"><?php echo SITE_ZONE;?></h4>
      <h5 class="marginright1 letter_title_three" style="margin-left:138px"><?php echo $ward_address;?></h5>
      <h5 class="margin1em letter_title_three" style="margin-left:128px">योजना/ आयोजना/ कार्यक्रमको प्रगति अनुगमन फारम</h5>
      <h5 class="margin1em letter_title_three" style="margin-left:140px">(कार्यक्रम प्रारम्भ भएपछि गरिने)</h5>
      </div>
      <div class="myspacer"></div>
      <div class="printContent">
        <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
        <div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>  </div>
        <div class="chalanino"> चलानी नं . : </div>
        <div class="myspacer"></div>
        <div class="banktextdetails1 ">
            <div class="subject">
                <u>विषय:-
                    <?php if(!empty($_GET['subject'])){
                        echo $_GET['subject'];
                    }else{
                        echo "अनुगमन सम्झौता फारम ।";
                    }?>
                </u>
            </div>
          <div class="myspacer20"></div>
          <div class="text" style="margin-left: 20px">
            <table class="table table-borderless"> 

              <tr class="table-borderless">१.योजनाको नाम:-  <strong><?php echo $data1->program_name;?></strong></tr><br>
              <tr class="table-borderless">२.योजना / आयोजना / कार्यक्रम संचालन स्थल :- <strong><?php echo SITE_LOCATION;?></strong>  वार्ड नं:- <strong><?php echo convertedcit($data1->ward_no);?></strong></tr><br>
              <tr class="table-borderless">३.योजना / आयोजना / कार्यक्रम संचालनको उदेश्य :-<strong><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></strong></tr><br>
              <tr class="table-borderless">४.योजना / आयोजना / कार्यक्रम ठेकेदार वा उपभोक्ता समिति मध्य कुन मार्फत संचालन भएको हो :-
              <u><?php echo $anugaman_details->thek;?></u>
              </tr><br>
              <hr>
              <tr style="padding-right: 10px" class="table-borderless"><u>४.२ उपभोक्ता समिति मार्फत भए :-</u></tr><br>
              <tr class="table-borderless">४.२.१ उपभोक्ता समितिको नाम :- <strong><?php echo $data4->program_organizer_group_name; ?></strong></tr><br>
              <?php $pn = Costumerassociationdetails::find_by_plan_id_post_id($_GET['id'],'1'); //print_r($pn);?>
              <tr class="table-borderless">४.२.२ उपभोक्ता समितिको अध्यक्षको नाम :- <strong><?php echo $pn->name;?></strong></tr><br>
              <tr class="table-borderless">४.२.३ ठेगाना :- <strong><?php echo $pn->issued_district;?></strong></tr><br>
              <tr class="table-borderless">४.२.४ लागत अनुमान :- <strong><?php echo convertedcit($invest_details->total_investment);?></strong></tr><br>
              <tr class="table-borderless">४.२.५ सम्झौता रकम रु :- <strong><?php echo convertedcit($invest_details->total_investment);?></strong></tr><br>
              <tr class="table-borderless">४.२.६ नगरपालिका/संस्थाले बेहोर्ने रकम रु :- <strong><?php echo convertedcit($invest_details->agreement_gauplaika);?></strong></tr><br>
              <tr class="table-borderless">४.२.७ जनसहभागिता रु :- <strong><?php echo convertedcit($invest_details->costumer_investment);?></strong></tr><br>
              <tr class="table-borderless">४.२.८ अन्य निकायको सहभागिता भए नाम र ब्येहोरेको रकम रु :- <strong><?php echo convertedcit($invest_details->costumer_agreement);?></strong></tr><br>
              <tr class="table-borderless">४.२.९ सम्झौता भएको मिति :- <strong><?php echo convertedcit($more_plan_details->miti);?></strong></tr><br>
              <tr class="table-borderless">४.२.१० योजना / आयोजना / कार्यक्रम शुरु हुने मिति :-<strong><?php echo convertedcit($more_plan_details->yojana_start_date);?></strong></tr><br>
              <tr class="table-borderless">४.२.११ योजना / आयोजना / कार्यक्रम सम्पन्न हुने मिति :- <strong><?php echo convertedcit($more_plan_details->yojana_sakine_date);?></strong></tr><br>
              <tr class="table-borderless">४.२.१२ अनुगमन गरिदा योजनाको अवस्था :-
              <u><?php echo $anugaman_details->anugaman?></u>
              </tr><br>
              <tr class="table-borderless">४.२.१३ प्राबिधिकबाट भएको कामको मुल्यांकन रु :-
              <u><?php echo $anugaman_details->prabidhik?></u>
              </tr><br>
              <tr class="table-borderless">४.२.१४ होडिङ्ग बोर्ड उपयुक्त स्थानमा राखे वा नराखेको :-
              <u><?php echo $anugaman_details->hording;?></u>
              </tr><br>
              <tr class="table-borderless">४.२.१५ योजना / आयोजना / कार्यक्रमको खाता राखे वा नराखेको :-
              <u><?php echo $anugaman_details->khata?></u>
              </tr><br>
              <hr>
              <tr class="table-borderless"><u>५. योजना / आयोजना / कार्यक्रमबाट लाभान्वित हुने :-</u></tr><br>
              <tr class="table-borderless">१) घरपरिवार संख्या :- <strong><?php echo convertedcit($profitable_family->kul1);?></strong></tr><br>
              <tr class="table-borderless">२) लाभान्वित जनसंख्या :- <strong><?php echo convertedcit($profitable_family->total6);?></strong></tr><br>
              <tr class="table-borderless">क) महिला : <strong><?php echo convertedcit($profitable_family->anya_mahila);?></strong>    ख) पुरुष :  <strong><?php echo convertedcit($profitable_family->anya_purush);?></strong>   ग) यौन अल्पसंख्यक (ट्रान्स-जेण्डेर):______घ) बालबालिका :______ङ) जेष्ठ नागरिक:_____
              च) फरक क्षमता भएका व्यक्ति (अपांग):_____छ) अन्य :______</tr><br>
              <tr class="table-borderless">३) समुदाय :-<u><?php echo $anugaman_details->samuday?></u></tr><br>
              <tr class="table-borderless">क) दलित : <strong><?php echo convertedcit($profitable_family->dalit_ghar);?></strong>  ख) आदिबासी/जनजाति: <strong><?php echo convertedcit($profitable_family->aadhibasi_ghar);?></strong> ग) मधेसी,मुस्लिम पिछडा वर्ग: ____________ घ) अन्य:<strong><?php echo convertedcit($profitable_family->anya_ghar);?></strong></tr><br>
              <tr class="table-borderless">६. उपभोक्ता समितिले प्राप्त गरेको किस्ता विवरण :-
              <u><?php echo $anugaman_details->kista?></u>
              </tr><br>
              <tr class="table-borderless">७. योजना / आयोजना / कार्यक्रमको अनुगमन अवधि सम्मको भौतिक उपलब्धि :- 
              <u><?php echo $anugaman_details->bhautik?></u>
              </tr><br>
              <tr class="table-borderless">८. अनुगमन तथा सुपरिवेक्षणको उदेस्य (नियमित वा आकस्मिक) :- 
              <u><?php echo $anugaman_details->udeshya?></u>
              </tr><br>
              <tr class="table-borderless">९. अनुगमन तथा सुपरिवेक्षण गर्दा देखिएका योजना / आयोजना / कार्यक्रमगत समस्याहरु :-
              <u><?php echo $anugaman_details->samasya?></u>
              </tr><br>
              
              <tr class="table-borderless">१०. समस्या समाधानका लागि स्थानीय स्तरमा गरिएको प्रयास :-
              <u><?php echo $anugaman_details->prayas?></u>
              </tr><br>
              
              <tr class="table-borderless">११. अनुगमन तथा सुपरिवेक्षण गर्ने समिति,कार्यदल तथा अधिकारीले स्थानीय स्तरमा दिएको सुझाव :-
              <u><?php echo $anugaman_details->sujhab?></u>
              </tr><br>
              
              <tr class="table-borderless">१२. अनुगमन तथा सुपरिवेक्षण गर्ने समिति,कार्यदल तथा अधिकारीको कार्यान्वयन गर्ने निकायलाई सुझाव :-
              <u><?php echo $anugaman_details->sujhab1?></u>
              </tr>
              
            </table>
            <hr>
          <!--<div style="margin-left: 20px">-->
          <!--                  <p><u><strong>अनुगमन तथा सुपरिबेक्षण प्रतिवेदन पेश गर्ने (वडा अनुगमन)</strong></u></p>-->
          <!--                  <div class="myspacer"></div>-->
                            <div class="mycontent">
                            
                <div class="myspacer"></div>
                <p><u><strong>अनुगमन तथा सुपरिबेक्षण प्रतिवेदन पेश गर्ने (पालिका स्तरीय अनुगमन)</strong></u></p>
                            <div class="myspacer"></div>
                            <div class="mycontent">
                    <table class="table table-bordered">
                        <?php $data4=  AnugamanSamitiBibaran::find_all();
                        ?>
                        <tr>
                          <td class="myCenter" ><strong>सि.नं</strong>.</td>
                          <td class="myCenter"><strong>पद</strong></td>
                          <td class="myCenter"><strong>नामथर</strong></td>
                          <td class="myCenter"><strong>पदनाम</strong></td>                    
                        </tr>
                        <?php $i=1;foreach($data4 as $data):
                                                  
                        if($data->gender==1){
                         $gender="पुरुष ";
                       }
                       elseif($data->gender==2)
                       {
                        $gender="महिला";
                      }?>
                      <tr>
                        <td class="myCenter"><?php echo convertedcit($i);?></td>
                        <td class="myCenter"><?php echo Postname::getName($data->post_id);?></td>
                        <td class="myCenter"><?php echo $data->name;?></td>
                        <td class="myCenter"><?php echo $data->post_name;?></td>
                      </tr>
                      <?php  $i++; endforeach; ?>
                    </table>
            <p><u><strong>आमन्त्रित </strong></u></p>
              <?php 
                if(!empty($worker1))
                {
                    echo $worker1->authority_name." "."$worker1->post_name";
                }
                ?>
                <br>
                <?php 
                if(!empty($worker2))
                {
                    echo $worker2->authority_name." "."$worker2->post_name";
                }
                ?>
                <br>
                <?php 
                if(!empty($worker3))
                {
                    echo $worker3->authority_name." "."$worker3->post_name";
                }
                ?>
                <br>
                <?php 
                if(!empty($worker4))
                {
                    echo $worker4->authority_name." "."$worker4->post_name";
                }
                ?>
                <br>
                <?php 
                if(!empty($worker5))
                {
                    echo $worker5->authority_name." "."$worker5->post_name";
                }
                ?>
          </div>
          <div class="myspacer25"></div>
          <hr>
        </div>
      </div><!-- yojana ends -->
    </div><!-- bank details ends -->
    <div class="myspacer"></div>
  </div>
  <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
</div>
</div>
</div>
</div><!-- main menu ends -->
</div>
</div>   
</div><!-- top wrap ends -->