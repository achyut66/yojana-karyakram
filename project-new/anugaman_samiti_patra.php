<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

//exit;
$ward_address=WardWiseAddress();
$address= getAddress();
$data5= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
// echo "<pre>";
// print_r($datas);
$worker=Moreplandetails::find_by_plan_id($_GET['id']);
$rules_result = Rule::find_by_plan_id($_GET['id']);
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$workers = Workerdetails::find_all();
//print_r($workers);
if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
    $worker5 = Workerdetails::find_by_id($print_history->worker5);
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
    if(empty($worker5))
    {
        $worker5 = Workerdetails::setEmptyObject();
    }
}
$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();
$anugaman_details = AnugamanPatra::find_by_id($_GET['id']);
//print_r($anugaman_details);
?>
<?php $data1=  Plandetails1::find_by_id($_GET['id']);
//print_r($data1);
?>
<?php $data=  Plandetails1::find_by_id($_GET['id']);
$invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']); 
$more_plan_details = Moreplandetails::find_by_plan_id($_GET['id']);
$data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
//print_r($data4);
//print_r($more_plan_details);
$fiscal = FiscalYear::find_by_id($data->fiscal_id);
?>
<?php $profitable_family= Profitablefamilydetails::find_by_plan_id($_GET['id']); //print_r($profitable_family);?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>अनुगमन संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <style>
::placeholder {
  color: red;
  opacity: 1; /* Firefox */
}
 table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }
                          input{
                              background: #eeeeee;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
</style>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
            <form method="post" action="anugaman_samiti_patra_final.php">
            <h2 class="headinguserprofile">अनुगमन संझौता फाराम | <a href="letters_select.php" class="btn">पछि जानुहोस </a>
            <div class="myPrint">
            <input type="hidden" name="id" value="<?=$_GET['id']?>" />
            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div></h2>
            <div class="OurContentFull">
                    <div class="userprofiletable">
                        <div class="printPage">
                            <div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
                            <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                            <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                            <h4 class="marginright1 letter_title_two"><?php echo SITE_ZONE;?></h4>
                            <h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
                            <h5 class="margin1em letter_title_three">योजना/ आयोजना/ कार्यक्रमको प्रगति अनुगमन फारम</h5>
                            <h5 class="margin1em letter_title_three">(कार्यक्रम प्रारम्भ भएपछि गरिने)</h5>
                            <div class="myspacer"></div>
                            <div class="printContent">
                               <div class="mydate"><input type="text" name="date_selected" value="<?php 
                               echo $date;?>" id="nepaliDate5" /></div>
                               <div class="patrano">आर्थिक वर्ष: <?php echo convertedcit($fiscal->year); ?></div>
                               <div class="patrano"> योजना दर्ता नं: <?php echo convertedcit($_GET['id']) ?>  </div>
                               <div class="chalanino">चलानी नं: </div>
                               <div class="myspacer"></div>
                                <div class="subject" border="none">
                                    <u>बिषय :- <label style="margin-left: 5px;">
                                            <input type="text" style="border:none" class="no-outline" name="subject" value="अनुगमन सम्झौता फारम "/></label></u>
                                </div>
                               <div class="myspacer20"></div>
                               <div class="text" style="margin-left: 20px">
                                   <input type="hidden" value="<?php echo $_GET['id'];?>" name="plan_id">
                                <table class="table table-borderless"> 
                               
                                  <tr class="table-borderless">१.योजनाको नाम:-  <strong><?php echo $data1->program_name;?></strong></tr><br>
                                  <tr class="table-borderless">२.योजना / आयोजना / कार्यक्रम संचालन स्थल :- <strong><?php echo SITE_LOCATION;?></strong>  वार्ड नं:- <strong><?php echo $data1->ward_no;?></strong></tr><br>
                                  <tr class="table-borderless">३.योजना / आयोजना / कार्यक्रम संचालनको उदेश्य :-<strong><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></strong></tr><br>
                                  <tr class="table-borderless">४.योजना / आयोजना / कार्यक्रम ठेकेदार वा उपभोक्ता समिति मध्य कुन मार्फत संचालन भएको हो :-
                                  <label><input type="textfield" value="<?=$anugaman_details->thek?>" name="thek" color="red" style="border:none" placeholder="यहाँ टाइप गर्नुहोस्" size="70"></input></label>
                                
                                  </tr><br>
                                  <hr>
                                  <tr style="padding-right: 10px" class="table-borderless"><u>४.२ उपभोक्ता समिति मार्फत भए :-</u></tr><br>
                                  <tr class="table-borderless">४.२.१ उपभोक्ता समितिको नाम :- <strong><?php echo $data5->program_organizer_group_name; ?></strong></tr><br>
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
                                  <tr class="table-borderless">४.२.१२ अनुगमन गरिदा योजनाको अवस्था :-<label> 
                                  <input type="textfield" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" name="anugaman" size="70" value="<?=$anugaman_details->anugaman?>"></input></label></tr><br>
                                  <tr class="table-borderless">४.२.१३ प्राबिधिकबाट भएको कामको मुल्यांकन रु :-<label>
                                  <input type="textfield" style="border:none" placeholder="यहाँ टाइप गर्नुहोस्" name="prabidhik" value="<?=$anugaman_details->prabidhik?>"></input></label></tr><br>
                                  <tr class="table-borderless">४.२.१४ होडिङ्ग बोर्ड उपयुक्त स्थानमा राखे वा नराखेको :-<label>
                                  <input type="textfield" style="border:none" placeholder="यहाँ टाइप गर्नुहोस्" name="hording" size="80" value="<?=$anugaman_details->hording?>"></input></label></tr><br>
                                  <tr class="table-borderless">४.२.१५ योजना / आयोजना / कार्यक्रमको खाता राखे वा नराखेको :-<label>
                                  <input type="textfield" value="<?=$anugaman_details->khata?>" style="border:none" placeholder="यहाँ टाइप गर्नुहोस्" name="khata" size="80"></input></label></tr><br>
                                  <hr>
                                  <tr class="table-borderless"><u>५. योजना / आयोजना / कार्यक्रमबाट लाभान्वित हुने :-</u></tr><br>
                                  <tr class="table-borderless">१) घरपरिवार संख्या :- <strong><?php echo convertedcit($profitable_family->kul1);?></strong></tr><br>
                                  <tr class="table-borderless">२) लाभान्वित जनसंख्या :- <strong><?php echo convertedcit($profitable_family->total6);?></strong></tr><br>
                                  <tr class="table-borderless">क) महिला : <strong><?php echo convertedcit($profitable_family->anya_mahila);?></strong>    ख) पुरुष :  <strong><?php echo convertedcit($profitable_family->anya_purush);?></strong>   ग) यौन अल्पसंख्यक (ट्रान्स-जेण्डेर):______घ) बालबालिका :______ङ) जेष्ठ नागरिक:_____
                                  च) फरक क्षमता भएका व्यक्ति (अपांग):_____छ) अन्य :______</tr><br>
                                  <tr class="table-borderless">३) समुदाय :- <label>
                                      <input type="textfield" value="<?=$anugaman_details->samuday;?>" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" name="samuday" size="80"></input></label></tr><br>
                                  <tr class="table-borderless">क) दलित : <strong><?php echo convertedcit($profitable_family->dalit_ghar);?></strong>  ख) आदिबासी/जनजाति: <strong><?php echo convertedcit($profitable_family->aadhibasi_ghar);?></strong> ग) मधेसी,मुस्लिम पिछडा वर्ग: ____________ घ) अन्य:<strong><?php echo convertedcit($profitable_family->anya_ghar);?></strong></tr><br>
                                  <tr class="table-borderless">६. उपभोक्ता समितिले प्राप्त गरेको किस्ता विवरण :-
                                  <label><input type="textfield" style="border:none" value="<?=$anugaman_details->kista?>" placeholder="यहाँ टाइप गर्नुहोस्" name="kista" size="80"></input></label>
                                  </tr><br>
                                  <tr class="table-borderless">७. योजना / आयोजना / कार्यक्रमको अनुगमन अवधि सम्मको भौतिक उपलब्धि :-
                                  <label><input type="textfield" style="border:none" placeholder="यहाँ टाइप गर्नुहोस्" name="bhautik" size="80"></input></label></tr><br>
                                  
                                  <tr class="table-borderless">८. अनुगमन तथा सुपरिवेक्षणको उदेस्य (नियमित वा आकस्मिक) :-
                                   <input type="textfield" name="udeshya" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" size="80"></input></tr><br>
                                   
                                  <tr class="table-borderless">९. अनुगमन तथा सुपरिवेक्षण गर्दा देखिएका योजना / आयोजना / कार्यक्रमगत समस्याहरु :-
                                   <input type="textfield" name="samasya" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" size="80"></input></tr><br>
                                   
                                  <tr class="table-borderless">१०. समस्या समाधानका लागि स्थानीय स्तरमा गरिएको प्रयास :-
                                   <input type="textfield" name="prayas" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" size="80"></input></tr><br>
                                   
                                  <tr class="table-borderless">११. अनुगमन तथा सुपरिवेक्षण गर्ने समिति,कार्यदल तथा अधिकारीले स्थानीय स्तरमा दिएको सुझाव :-
                                   <input type="textfield" name="sujhab" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" size="80"></input></tr><br>
                                   
                                  <tr class="table-borderless">१२. अनुगमन तथा सुपरिवेक्षण गर्ने समिति,कार्यदल तथा अधिकारीको कार्यान्वयन गर्ने निकायलाई सुझाव :-
                                   <input type="textfield" name="sujhab1" placeholder="यहाँ टाइप गर्नुहोस्" style="border:none" size="80"></input></tr><br>
                                  <div class="myspacer20"></div>
                              </table>
                              </form>
                              <hr>
                          </div>
                            <!--<div style="margin-left: 20px">-->
                            <!--<p><u><strong>अनुगमन तथा सुपरिबेक्षण प्रतिवेदन पेश गर्ने (वडा अनुगमन)</strong></u></p>-->
                            <!--<div class="myspacer"></div>-->
                            <div class="mycontent">
                            
                        <div>
                            <p><u><strong>अनुगमन तथा सुपरिबेक्षण प्रतिवेदन पेश गर्ने (पालिका स्तरीय अनुगमन)</strong></u></p>
                            <div class="myspacer"></div>
                            <div class="mycontent">
                        <table class="table table-bordered table-responsive">
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
                            <div class="myspacer"></div>
                            <p><u><strong>आमन्त्रित </strong></u></p>
                            <label>
                                <select name="worker1" class="form-control worker" id="worker_1" >
                                    <option value="">छान्नुहोस्</option>
                                        <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                        <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                            </form>
                            </label>
                            <label>
                                <select name="worker2" class="form-control worker" id="worker_2" >
                                    <option value="">छान्नुहोस्</option>
                                        <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                        <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                            </form>
                            </label>
                            <label>
                                <select name="worker3" class="form-control worker" id="worker_3" >
                                    <option value="">छान्नुहोस्</option>
                                        <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                        <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                            </form>
                            </label>
                            <label>
                                <select name="worker4" class="form-control worker" id="worker_4" >
                                    <option value="">छान्नुहोस्</option>
                                        <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                        <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>">
                            </form>
                            </label>
                            <label>
                                <select name="worker5" class="form-control worker" id="worker_5" >
                                    <option value="">छान्नुहोस्</option>
                                        <?php foreach($workers as $worker){?>
                                            <option value="<?=$worker->id?>" <?php if($print_history->worker5 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                        <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_5" value="<?=$worker5->post_name?>">
                            </form>
                            </label>
                          <input value="+" type="button" class="add_more_a" /></button>
                        </div>   
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
<?php include("menuincludes/footer.php"); ?>