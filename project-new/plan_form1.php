<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
//echo Contingency:: find_by_type(1);
if ($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;

if (isset($_POST['search'])) {
    if (empty($_POST['sn'])) {
        $sql="select * from plan_details1 where program_name LIKE '%".$_POST['program']."%'";
    } else {
        $sql="select * from plan_details1 where id='".$_POST['sn']."'";
        $results= Plandetails1::find_by_sql($sql);
    }
    //print_r($result);exit;
}
$data1=Plandetails1::find_by_id($_GET['id']);
$anudanData = PlanDetailsAnudan::find_by_plan_id($_GET['id']);
//print_r($data1);
$data2 = Plandetails1::find_by_sql("select * from plan_details1 where topic_area_investment_id=5 and id =".$_GET['id']);//print_r($data2);
$postnames=  Postname::find_all();
$units = Units::find_all();
$SettingbhautikPariman = SettingbhautikPariman::find_all();
$SettingbhautikParimanParent = SettingbhautikPariman::find_all_parents();
?>

<?php include("menuincludes/header.php");  ?>
<title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING;?>
</title>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="maincontent">
        <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | <a href="upabhoktasamitidashboard.php" class="btn">पछि
                जानुहोस</a></h2>
        <div class="OurContentFull">
            <div class="myMessage"><?php echo $message;?>
            </div>
            <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?>
            </h1>
            <div class="userprofiletable">

                <?php $data = Plandetails1::find_by_id($_GET['id']);?>
                <?php $invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']);
                if (empty($invest_details)) {
                    $invest_details = Plantotalinvestment::setEmptyObjects();
                }
                !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस";
                $bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'], 1);
                ?>
                <div>
                    <h3><?php echo $data->program_name; ?>
                    </h3>
                    <form method="post" enctype="multipart/form_data" action="save_plandetails1.php">

                        <table class="table table-bordered">
                            <div class="inputWrap100">
                                <h1> योजनाको कुल लागत अनुमान </h1>
                                <div class="inputWrap33 inputWrapLeft">
                                    <!--<div class="titleInput"> मुख्य  भौतिक लक्ष :</div>-->
                                    <!--<div class="newInput"><input type="text" required name="unit_total" value="<?=$invest_details->unit_total?>"
                    />
                  </div>-->
                                    <!--<div class="titleInput">भौतिक ईकाई:</div>-->
                                    <!--<div class="newInput"><select name="unit_id">-->
                                    <!--  <option value="">--छान्नुहोस् --</option>-->
                                    <!--  <?php foreach ($units as $unit): ?>-->
                                    <!--    <option value="<?=$unit->id?>" <?php if ($invest_details->unit_id==$unit->id) { ?>
                  selected="selected" <?php } ?> ><?=$unit->name?>
                  </option>-->
                                    <!--  <?php endforeach; ?>-->
                                    <!--</select></div>-->
                                    <input class="newInput" type="hidden" id="kul_budget"
                                           value="<?php echo $data1->investment_amount;?>">
                                    <div class="titleInput">योजनाको लागि छुटाइएको बजेट : (<?php echo convertedcit($data1->investment_amount);?>)
                                    </div>

                                    <div class="text"><b>कुल लागत अनुमानित रकम : </b></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="checkbox" name="kul_lagat_con" id="kul_lagat_con" value="1" <?php if ($invest_details->kul_lagat_con==1) {
                                                echo 'checked="checked"';
                                            }?>
                                            />
                                            <span style="color: red">
                                                कुल लागतबाट कन्टेन्जेन्सी
                                                <span class="con_value"></span>
                                                काट्ने भएमा टिक लगाउनुहोस
                                              </span>

                                            <div>
                                                <input
                                                        type="checkbox"
                                                        name="marmat_value_kul_lagat"
                                                        id="marmat_value_kul_lagat"
                                                        value="1"
                                                    <?php if ($invest_details->marmat_value_kul_lagat>0) {
                                                        echo 'checked="checked"';
                                                    }?>
                                                />
                                                <span style="color: red">
                                              मर्मत संहार
                                              <span class="marmat_value"></span>
                                              काट्ने भएमा टिक लगाउनुहोस
                                            </span>
                                            </div>

                                            <input type="text" name="kul_lagat_anuman" id="kul_lagat_anuman"
                                                   value="<?=number_format($invest_details->kul_lagat_anuman, 2, '.', '');?>" />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="titleInput">
                                        <?php echo SITE_TYPE;?>बाट अनुदान :
                                        <br>
                                        <input type="checkbox" name="anudan_con" id="anudan_con" value="1" <?php if ($invest_details->anudan_con==1) {
                                            echo 'checked="checked"';
                                        }?>
                                        />
                                        <span style="color: red">
                      कन्टेन्जेन्सी
                      <span class="con_value"></span>
                      काट्ने भएमा टिक लगाउनुहोस
                    </span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" name="agreement_gauplaika" id="agreement_gauplaika"
                                                   value="<?php if ($invest_details->agreement_gauplaika) {
                                                       echo $invest_details->agreement_gauplaika;
                                                   } else {
                                                       echo $data1->investment_amount;
                                                   };?>" />
                                        </div>
                                    </div>
                                    <div>

                                    </div>
                                    <div>
                                        <input
                                                type="checkbox"
                                                name="marmat_value_new"
                                                id="marmat_value_new"
                                                value="1"
                                            <?php if ($invest_details->marmat_value_new>0) {
                                                echo 'checked="checked"';
                                            }?>
                                        />
                                        <span style="color: red">
                      मर्मत संहार
                      <span class="marmat_value"></span>
                      काट्ने भएमा टिक लगाउनुहोस
                    </span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="newInput"><input type="hidden" readonly="true" name="marmat_new"
                                                                         value="<?php echo $invest_details->marmat_new;?>"
                                                                         id="marmat_new" /></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="newInput"><input type="hidden"
                                                                         value="<?php echo $invest_details->marmat_old;?>"
                                                                         name="marmat_old" id="marmat_name" style="max-width: 100px" placeholder="प्रतिशत(%)"></div>
                                        </div>
                                    </div>
                                    <div class="marmat_empty_notification" style="color:red"></div>
                                    <div class="myspacer20"></div>
                                    <marquee><b><?php echo $data1->program_name;?></b>
                                    </marquee>
                                </div>

                                <div class="inputWrap33 inputWrapLeft">

                                    <div id="anudan_container">
                                        <div class="anudan_item">
                                            <div class="titleInput">
                                                <div style="display:flex">
                                                    <input style="margin-bottom: 4px" name="agreement_other_title" type="text"
                                                           value="<?php if (empty($invest_details->agreement_other_title)) {
                                                               echo 'अन्य निकायबाट प्राप्त अनुदान :';
                                                           } else {
                                                               echo $invest_details->agreement_other_title;
                                                           } ?>">
                                                    <button class="remove_anudan" data-anudan-id="0"
                                                            style="color:red;border:none;cursor:pointer">X</button>
                                                </div>
                                                <input type="checkbox" name="aanya_nikaya_con" id="aanya_nikaya_con" value="1" <?php if ($invest_details->aanya_nikaya_con==1) {
                                                    echo 'checked="checked"';
                                                }?>
                                                />
                                                <span style="color: red">
                  कन्टेन्जेन्सी
                  <span class="con_value"></span>
                  काट्ने भएमा टिक लगाउनुहोस
                </span> <br>

                                                <div>
                                                    <input
                                                            type="checkbox"
                                                            name="marmat_value_aanya_nikaya"
                                                            id="marmat_value_aanya_nikaya"
                                                            value="1"
                                                        <?php if ($invest_details->marmat_value_aanya_nikaya>0) {
                                                            echo 'checked="checked"';
                                                        }?>
                                                    />
                                                    <span style="color: red">
                    मर्मत संहार
                    <span class="marmat_value"></span>
                    काट्ने भएमा टिक लगाउनुहोस
                  </span>
                                                </div>


                                                <input
                                                        type="checkbox"
                                                        name="aanya_nikaya_add"
                                                        id="aanya_nikaya_add"
                                                        value="1"
                                                    <?php if ($invest_details->aanya_nikaya_add==1) { echo 'checked="checked"';} ?>
                                                />
                                                <span style="color: red">पालिका खातामा पैसा जम्मा गर्ने होइन भने टिक लगाउनुहोस </span>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="newInput">
                                                        <input type="text" required name="agreement_other" id="agreement_other"
                                                               value="<?=$invest_details->agreement_other?>" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="padding:0">
                                                    <div class="newInput">
                                                        <input
                                                                type="text"
                                                                value=""
                                                                id="aanya_nikaya_cond_per"
                                                                name="aanya_nikaya_cond_per"
                                                                style="max-width: 100px; display: none"
                                                                readonly
                                                        >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="anudan_item">
                                            <div class="titleInput">
                                                <div style="display:flex">
                                                    <input name="other_agreement_title" style="margin-bottom: 4px" type="text"
                                                           value="<?php if (empty($invest_details->other_agreement_title)) {
                                                               echo 'अन्य साझेदारी :';
                                                           } else {
                                                               echo $invest_details->other_agreement_title;
                                                           } ?>">
                                                    <button class="remove_anudan" data-anudan-id="1"
                                                            style="color:red;border:none;cursor:pointer">X</button>
                                                </div>
                                                <input type="checkbox" name="aanya_sajhedari_con" id="aanya_sajhedari_con" value="1" <?php if ($invest_details->aanya_sajhedari_con==1) {
                                                    echo 'checked="checked"';
                                                }?>
                                                />
                                                <span style="color: red">
                  कन्टेन्जेन्सी
                  <span class="con_value"></span>
                  काट्ने भएमा टिक लगाउनुहोस
                </span>

                                                <div>
                                                    <input
                                                            type="checkbox"
                                                            name="marmat_value_aanya_sajhedari"
                                                            id="marmat_value_aanya_sajhedari"
                                                            value="1"
                                                        <?php if ($invest_details->marmat_value_aanya_sajhedari>0) {
                                                            echo 'checked="checked"';
                                                        }?>
                                                    />
                                                    <span style="color: red">
                    मर्मत संहार
                    <span class="marmat_value"></span>
                    काट्ने भएमा टिक लगाउनुहोस
                  </span>
                                                </div>

                                                <input
                                                        type="checkbox"
                                                        name="aanya_sajhedari_add"
                                                        id="aanya_sajhedari_add"
                                                        value="1"
                                                    <?php if ($invest_details->aanya_sajhedari_add==1) { echo 'checked="checked"';} ?>
                                                />
                                                <span style="color: red">पालिका खातामा पैसा जम्मा गर्ने होइन भने टिक लगाउनुहोस </span>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="newInput">
                                                        <input type="text" required name="other_agreement" id="other_agreement"
                                                               value="<?=$invest_details->other_agreement?>" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="padding:0">
                                                    <div class="newInput">
                                                        <input
                                                                type="text"
                                                                value=""
                                                                id="aanya_sajhedari_cond_per"
                                                                name="aanya_sajhedari_cond_per"
                                                                style="max-width: 100px; display: none"
                                                                readonly
                                                        >
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <?php $remaining_anudan_index = 0; ?>
                                        <?php foreach ($anudanData as $ad): ?>
                                            <div class="anudan_item">
                                                <div class="titleInput">
                                                    <div style="display:flex">
                                                        <input style="margin-bottom: 4px" name="remaining_title[]" type="text"
                                                               value="<?php echo $ad->title ?>">
                                                        <button class="remove_anudan" data-anudan-id="1"
                                                                style="color:red;border:none;cursor:pointer">X</button>
                                                    </div>
                                                    <input type="checkbox" name="remaining_con[]" id="remaining_con" class="remaining_con"
                                                           value="<?php echo $remaining_anudan_index ?>"
                                                        <?php if ($ad->is_contingency==1) {
                                                            echo 'checked="checked"';
                                                        }?>
                                                    />
                                                    <span style="color: red">
                  कन्टेन्जेन्सी
                  <span class="con_value"></span>
                  काट्ने भएमा टिक लगाउनुहोस
                </span>

                                                    <div>
                                                        <input
                                                                type="checkbox"
                                                                name="marmat_value_remaining[]"
                                                                id="marmat_value_remaining"
                                                                class="marmat_value_remaining"
                                                                value="<?php echo $remaining_anudan_index ?>"
                                                            <?php if ($ad->is_marmat==1) {
                                                                echo 'checked="checked"';
                                                            }?>
                                                        />
                                                        <span style="color: red">
                    मर्मत संहार
                    <span class="marmat_value"></span>
                    काट्ने भएमा टिक लगाउनुहोस
                  </span>
                                                    </div>

                                                    <input
                                                            type="checkbox"
                                                            name="remaining_add[]"
                                                            id="remaining_add"
                                                            class="remaining_add"
                                                            value="<?php echo $remaining_anudan_index ?>"
                                                        <?php if ($ad->is_anudan_add==1) {
                                                            echo 'checked="checked"';
                                                        }?>
                                                    />
                                                    <span style="color: red">पालिका खातामा पैसा जम्मा गर्ने होइन भने टिक लगाउनुहोस </span>
                                                </div>

                                                <div class="newInput">
                                                    <input type="text" required name="remaining_anudan[]" id="remaining_anudan" class="remaining_anudan"
                                                           value="<?php echo $ad->value ?>" />
                                                </div>
                                            </div>
                                            <?php $remaining_anudan_index++; endforeach; ?>
                                    </div>
                                    <center>
                                        <button id="handleAddNew" class="btn">ADD NEW</button>
                                    </center>
                                    <br>

                                    <?php if (!empty($data2)) {
                                        ?>
                                        <div class="titleInput">उपभोक्ताबाट नगद साझेदारी :<br><input type="checkbox" name="nagad_sajhedari_con"
                                                                                                     id="nagad_sajhedari_con" value="1" <?php if ($invest_details->nagad_sajhedari_con==1) {
                                                echo 'checked="checked"';
                                            } ?>/>
                                            <span style="color: red">कन्टेन्जेन्सी <span class="con_value"></span> काट्ने भएमा टिक लगाउनुहोस </span>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-2">
                                                <div class="newInput">
                                                    <input
                                                            type="text"
                                                            value="<?php echo $invest_details->sajhedari_per; ?>"
                                                            id="nagad_sajhedari"
                                                            name="sajhedari_per"
                                                            placeholder="प्रतिशत(%)"
                                                            style="max-width: 100px">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="newInput"><input type="text" required name="costumer_agreement_1" id="costumer_agreement_1"
                                                                             value="<?php echo $data1->investment_amount; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding:0">
                                                <div class="newInput">
                                                    <input
                                                            type="text"
                                                            value=""
                                                            id="nagad_sajhedari_cond_per"
                                                            name="nagad_sajhedari_cond_per"
                                                            style="max-width: 100px; display: none"
                                                            readonly
                                                    >
                                                </div>
                                            </div>
                                            <input type="hidden" value="1" id="withvalue">
                                        </div>
                                        <div class="nagad_sajhedari_empty_notification" style="color:red"></div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="titleInput">
                                            उपभोक्ताबाट नगद साझेदारी :<br>
                                            <input
                                                    type="checkbox"
                                                    name="nagad_sajhedari_con"
                                                    id="nagad_sajhedari_con"
                                                    value="1"
                                                <?php if ($invest_details->nagad_sajhedari_con==1) { echo 'checked="checked"';} ?>
                                            />
                                            <span style="color: red">कन्टेन्जेन्सी <span class="con_value"></span> काट्ने भएमा टिक लगाउनुहोस </span><br>

                                            <div>
                                                <input
                                                        type="checkbox"
                                                        name="marmat_value_nagad_sajhedari"
                                                        id="marmat_value_nagad_sajhedari"
                                                        value="1"
                                                    <?php if ($invest_details->marmat_value_nagad_sajhedari>0) {
                                                        echo 'checked="checked"';
                                                    }?>
                                                />
                                                <span style="color: red">
                मर्मत संहार
                <span class="marmat_value"></span>
                काट्ने भएमा टिक लगाउनुहोस
              </span>
                                            </div>

                                            <input
                                                    type="checkbox"
                                                    name="nagad_sajhedari_add"
                                                    id="nagad_sajhedari_add"
                                                    value="1"
                                                <?php if ($invest_details->nagad_sajhedari_add==1) { echo 'checked="checked"';} ?>
                                            />
                                            <span style="color: red">पालिका खातामा पैसा जम्मा गर्ने होइन भने टिक लगाउनुहोस </span>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-2" style="padding:0">
                                                <div class="newInput">
                                                    <input
                                                            type="text"
                                                            value="<?php echo $invest_details->sajhedari_per; ?>"
                                                            id="nagad_sajhedari"
                                                            name="sajhedari_per"
                                                            placeholder="प्रतिशत(%)"
                                                            style="max-width: 100px"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="newInput"><input type="text" required name="costumer_agreement" id="costumer_agreement"
                                                                             value="<?php echo $invest_details->costumer_agreement; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding:0">
                                                <div class="newInput">
                                                    <input
                                                            type="text"
                                                            value=""
                                                            id="nagad_sajhedari_cond_per"
                                                            name="nagad_sajhedari_cond_per"
                                                            style="max-width: 100px; display: none"
                                                            readonly
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="2" id="withvalue">
                                        <div class="nagad_sajhedari_empty_notification" style="color:red"></div>
                                        <?php
                                    }
                                    ?>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput">कार्यदेश दिएको रकम :</div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="newInput">
                                                <input type="text" readonly="true" name="bhuktani_anudan" id="bhuktani_anudan"
                                                       value="<?=$invest_details->bhuktani_anudan?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" value="<?=round($invest_details->bhuktani_anudan/$invest_details->total_investment * 100, 2)?>%" name="karyadesh_per" id="karyadesh_per" readonly="true"
                                                   style="max-width: 100px" placeholder="प्रतिशत(%)">
                                        </div>
                                    </div>
                                    <div class="titleInput">उपभोक्ताबाट जनश्रमदान :</div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="newInput">
                                                <input type="text" required name="costumer_investment" id="costumer_investment"
                                                       value="<?php echo $invest_details->costumer_investment;?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="newInput">
                                                <input type="text"
                                                       value="<?=round($invest_details->costumer_investment/$invest_details->total_investment * 100, 2)?>%"
                                                       name="user_per" readonly="readonly" style="max-width: 100px" id="user_per">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="janashramdan_empty_notification" style="color:red"></div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा :</div>
                                    <div class="newInput"><input type="text" name="total_investment" readonly="true" id="total_investment"
                                                                 value="<?=$invest_details->total_investment;?>" />
                                    </div>
                                    <div class="saveBtn myCenter myWidth100"><input type="hidden" name="create_id"
                                                                                    value="<?=$invest_details->id?>" class="btn" />
                                    </div>

                                    <p> कन्टेन्जेन्सी : <span id="contingency_data">0</span></p>
                                    <p id="added_marmat_samhar">
                                        मर्मत संहार : <span id="added_marmat_samhar_data"></span></p>
                                </div>
                                <input type="hidden" name="contingency" id="contingency">
                                <input type="hidden" name="aanya_contingency" id="aanya_contingency">
                                <input type="hidden" name="aanya_sajadari_contingency" id="aanya_sajadari_contingency">
                                <input type="hidden" name="nagad_contingency" id="nagad_contingency">


                                <div class="myspacer"></div>
                                <input type="hidden" name="plan_id" id="plan_id"
                                       value="<?=$_GET['id']?>" class="btn" />
                                <center>
                                    <input type="submit" name="submit" value="<?=$value?>"
                                           class="btn">
                                </center>
                            </div>
                </div><!-- input wrap 33 ends -->
                <div class="myspacer"></div>
            </div><!-- input wrap 100 ends -->

            <table class="table table-bordered">
                <tr>
                    <th>सि. नं </th>
                    <th>परिमाणको मुख्य शिर्षक
                        <div
                                class="btn"
                                data-toggle="modal"
                                id="add_new_title"
                                data-target="#newModal"
                        >
                            नया शिर्षक थप्नुहोस [+]
                        </div>
                    </th>
                    <th>परिमाणको शिर्षक </th>
                    <th>परिमाण</th>
                    <th>भौतिक इकाई </th>
                    <th style="5%;">#</th>
                </tr>
                <?php if (empty($bhautik_details)) {?>
                <?php } else {
                    $i=1;
                    foreach ($bhautik_details as $result):
                        ?>
                        <tr class="remove_plan_form_details">
                            <td class="sn" name="sn" id="sn_<?=$i?>" value="<?=$i?>"><?=$i?>
                            </td>
                            <td>
                                <select class="parent_details_id" name="parent_details_id[]" style="min-width: 100%;">
                                    <option value="">--------</option>
                                    <?php foreach ($SettingbhautikParimanParent as $data):?>
                                        <option value="<?=$data->id?>" <?php if ($data->id==$result->parent_id) {
                                            echo 'selected="selected"';
                                        } ?>><?=$data->name?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select class="details_id" required name="details_id[]" style="min-width: 100%;">
                                    <option value="">--------</option>
                                    <?php foreach ($SettingbhautikPariman as $data):
                                        if ($data->id==$result->details_id) {
                                            ?>
                                            <option
                                                    value="<?=$data->id?>"
                                                <?php
                                                if ($data->id==$result->details_id) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>
                                            ><?=$data->name?>
                                            </option>
                                        <?php } endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="qty[]"
                                       value="<?=$result->qty?>" /></td>
                            <td>
                                <select name="unit_id[]">
                                    <option value="">--छान्नुहोस् --</option>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?=$unit->id?>" <?php if ($unit->id==$result->unit_id) {
                                            echo 'selected="selected"';
                                        } ?>><?=$unit->name?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="width:5%;">
                                <button class="remove_btn" id="remove_btn_<?=$i?>">
                                    <img src="images/cross.png" style="height: 20px; width: 20px;">
                                </button>
                            </td>
                        </tr>

                        </tr>
                        <?php $i++;
                    endforeach;
                }?>
                <tbody id="join_table_plan_form_1">
                </tbody>
            </table>
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newModalLabel">नया परिमाणको शिर्षक थप्नुहोस</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="titleInput">भौतिक लक्ष्यको शिर्षक:</div>
                                    <div class="newInput">
                                        <input type="text"  id="new_title_name" value="<?php echo $data->name;?>">
                                    </div>
                                    <div class="titleInput">मुख्य शिर्षक छ भने छानुहोस:</div>
                                    <select name="new_parent_id" id="new_parent_id" class="form-control" >
                                        <option value="-1">छानुहोस</option>
                                    </select>
                                    <br>
                                    <div class="saveBtn myWidth100">
                                        <input id="save_new_parent" value="सेभ गर्नुहोस" class="btn">
                                    </div>
                                    <div class="myspacer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="plan_id" id="plan_id"
                   value="<?=$_GET['id']?>" class="btn" />
            <input type="hidden" name="create_id" id="plan_id"
                   value="<?=$invest_details->id?>" class="btn" />
            <div class="row">
                <div class="col-md-3">
                    <div class="add_plan_form1 btn" style="width:100%">थप्नुहोस [+]</div>
                </div>
                <div class="col-md-3">
                    <div class="remove_plan_form1 btn " style="width:100%">हटाउनुहोस [-]</div>
                </div>
                <div class="col-md-3">
                    <input type="submit" style="width:100%" name="submit"
                           value="<?=$value?>" class="submit btn ">
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div><!-- input wrap 33 ends -->
    <div class="myspacer"></div>
    <input type="hidden" id="hidden_contigency_value">
    <input type="hidden" id="hidden_marmatsamhar_value">
</div><!-- input wrap 100 ends -->
</form>

<?php include("menuincludes/footer.php"); ?>
<script>
    //  marmat samhar:

    JQ(document).ready(function() {


        //starter check
        var total_investment = +JQ('#total_investment').val();
        var nagad_sajhedari_add_checked = JQ('#nagad_sajhedari_add').prop('checked');
        if(nagad_sajhedari_add_checked){
            var costumer_agreement = +JQ('#costumer_agreement').val();
            JQ('#nagad_sajhedari_cond_per').val(`${(costumer_agreement / total_investment * 100).toFixed(2)}%`);
            JQ('#nagad_sajhedari_cond_per').css('display','block');
        } else {
            JQ('#nagad_sajhedari_cond_per').css('display','none');
        }

        var aanya_nikaya_add_checked = JQ('#aanya_nikaya_add').prop('checked');
        if(aanya_nikaya_add_checked){
            var agreement_other = +JQ('#agreement_other').val();
            JQ('#aanya_nikaya_cond_per').val(`${(agreement_other / total_investment * 100).toFixed(2)}%`);
            JQ('#aanya_nikaya_cond_per').css('display','block');
        } else {
            JQ('#aanya_nikaya_cond_per').css('display','none');
        }

        var aanya_sajhedari_add_checked = JQ('#aanya_sajhedari_add').prop('checked');
        if(aanya_sajhedari_add_checked){
            var other_agreement = +JQ('#other_agreement').val();
            JQ('#aanya_sajhedari_cond_per').val(`${(other_agreement / total_investment * 100).toFixed(2)}%`);
            JQ('#aanya_sajhedari_cond_per').css('display','block');
        } else {
            JQ('#aanya_sajhedari_cond_per').css('display','none');
        }


        var plan_id = JQ("#plan_id").val() || 0;
        var param = {};
        param.plan_id = plan_id;
        JQ.post('get_contingency_for_plan.php', param, function(res) {
            var parseObj = JSON.parse(res);
            JQ('.con_value').each(function() {
                JQ(this).html(`(${parseObj.html* 100}%)`);
                JQ('#hidden_contigency_value').val(parseObj.html);
                var contingency = totalKatti(true);
                JQ('#contingency_data').html(contingency);
            });

        });
        JQ.post('get_marmat_samhar_for_plan.php', param, function(res) {
            var parseObj = JSON.parse(res);
            JQ('#hidden_marmatsamhar_value').val(parseObj.html);
            JQ('.marmat_value').each(function(){
                JQ(this).html(`(${parseObj.html* 100}%)`);
            });
            JQ('#marmat_name').val(parseObj.html * 100);
            var agreement_gaupalika = JQ('#agreement_gauplaika').val();
            if(JQ('#marmat_value_new').prop('checked')) {
                JQ('#marmat_new').val((parseFloat(agreement_gaupalika) * parseObj.html).toFixed(2));
            } else {
                JQ('#marmat_new').val(0);
            }
            totalMarmatSamhar();
        });

        JQ(document).on("click", ".add_plan_form1", function() {
            var num = JQ(".remove_plan_form_details").length;
            var counter = num + 1;
            var param = {};
            param.counter = counter;
            JQ.post('get_bhautik_pariman_details.php', param, function(res) {
                var obj = JSON.parse(res);
                JQ("#join_table_plan_form_1").append(obj.html);
                JQ("#new_parent_id").append(obj.new_data);
            });
        });

        JQ(document).on("change", ".parent_details_id", function() {
            var param = {};
            param.id = +JQ(this).val();
            var target = JQ(this).parent().parent().find("td:eq(2)")
            JQ.post('get_bhautik_pariman_sub_details.php', param, function(res) {
                var obj = JSON.parse(res);
                target.html(obj.html)
            });
        });

        JQ(document).on("click", "#add_new_title", function() {
            var num = JQ(".remove_plan_form_details").length;
            var counter = num + 1;
            var param = {};
            param.counter = counter;
            JQ.post('get_bhautik_pariman_details.php', param, function(res) {
                var obj = JSON.parse(res);
                JQ("#new_parent_id").html(obj.new_data);
            });
        });

        JQ(document).on("click", "#save_new_parent", function() {
            var new_title_name = JQ('#new_title_name').val();
            if(!new_title_name){
                alert("परिमाणको शिर्षक");
                return;
            }
            var new_parent_id = JQ('#new_parent_id').val();
            var param = {
                name: new_title_name,
                parent_id: new_parent_id,
                save: true
            };

            JQ.post('create_bhautik_pariman.php', param, function(res) {
                var obj = JSON.parse(res);
                if(obj.parent_id == -1) {
                    var o = new Option(obj.name, obj.id);
                    JQ('.parent_details_id').append(o);
                }
                JQ('#new_title_name').val('');
                alert('नया परिमाणको शिर्षक थपिएको छ।');
                JQ('#newModal').modal('toggle');
            });


        });

        JQ(document).on("click", ".remove_plan_form1", function() {
            JQ('.remove_plan_form_details').last().remove();
        });

        JQ(document).on("click", ".remove_btn", function() {
            JQ(this).closest('tr').remove();
            var i = 1;
            JQ(".sn").each(function() {
                JQ(this).html(i + 1);
                i++;
            });
        });

        JQ(document).on('input',
            '#agreement_gauplaika, #nagad_sajhedari, #agreement_other, #other_agreement, #costumer_agreement, #costumer_investment, .remaining_anudan, #kul_lagat_anuman',
            function() {
                var nagar_anu = +JQ('#agreement_gauplaika').val() || 0;
                var marmat_name = +JQ('#marmat_name').val() || 0;
                var nagad_sajhedari = +JQ('#nagad_sajhedari').val() || 0;
                var selected_item_id = JQ(this).attr('id');
                var contigency_value = +JQ('#hidden_contigency_value').val();
                var marmatsamhar_value = +JQ('#hidden_marmatsamhar_value').val();

                if(nagar_anu > +JQ('#kul_budget').val()) {
                    alert('योजनाको लागि छुटाइएको बजेट भन्दा धेरै हुन सक्दैन');
                    JQ('#agreement_gauplaika').val('');
                    return;
                }
                var total_percent = parseInt(marmat_name) + parseInt(nagad_sajhedari);
                if (total_percent >= 100) {
                    alert('प्रतिशत १०० हुन सक्दैन');
                    JQ('#nagad_sajhedari').val('');
                    return;
                }
                var marmat_new = marmat_name / 100 * nagar_anu;
                var nagad_new = nagad_sajhedari / 100 * nagar_anu;
                JQ('#marmat_new').val(marmat_new.toFixed(2));

                if (JQ(this).attr('id') === 'costumer_agreement') {
                    // costumer_agreement to percent
                    var costumer_agreement = +JQ("#costumer_agreement").val() || 0;
                    JQ('#nagad_sajhedari').val(parseFloat(costumer_agreement) / parseFloat(nagar_anu) * 100);
                } else if (JQ(this).attr('id') === 'nagad_sajhedari') {
                    JQ('#costumer_agreement').val(nagad_new.toFixed(2));
                }

                var contingency = totalKatti(true);
                JQ('#contingency_data').html(contingency);

                calculateTotal();

            });

        function totalAnudan() {
            var nagar_anu = JQ('#agreement_gauplaika').val() || 0;
            var agreement_other = JQ('#agreement_other').val() || 0;
            var other_agreement = JQ('#other_agreement').val() || 0;
            var nagad_sajhedari = JQ('#nagad_sajhedari').val() || 0;
            var costumer_agreement = nagad_sajhedari / 100 * nagar_anu;
            var total = parseFloat(other_agreement) + parseFloat(agreement_other) + parseFloat(costumer_agreement);
            //check for remaining cons
            var index = 0;
            JQ('.remaining_anudan').each(function() {
                var remaining_anudan = JQ('.remaining_anudan').eq(index).val();
                total += parseFloat(remaining_anudan);
                index++;
            });

            return total;
        }

        function totalKatti(onlyContingency = false) {
            var kul_lagat_anuman = +JQ('#kul_lagat_anuman').val();
            var kul_lagat_con_checked = JQ('#kul_lagat_con').prop('checked');

            var nagar_anu = JQ('#agreement_gauplaika').val() || 0;
            var anudan_con_checked = JQ('#anudan_con').prop('checked');

            var agreement_other = JQ('#agreement_other').val() || 0;
            var agreement_other_checked = JQ('#aanya_nikaya_con').prop('checked');

            var other_agreement = JQ('#other_agreement').val() || 0;
            var other_agreement_checked = JQ('#aanya_sajhedari_con').prop('checked');

            var nagad_sajhedari = JQ('#nagad_sajhedari').val() || 0;
            var costumer_agreement = nagad_sajhedari / 100 * nagar_anu;
            var nagad_sajhedari_checked = JQ('#nagad_sajhedari_con').prop('checked');

            var contigency_percent = JQ('#hidden_contigency_value').val() || 0;
            var totalKatti = 0;

            if (kul_lagat_con_checked) {
                totalKatti += parseFloat(kul_lagat_anuman) * parseFloat(contigency_percent);
            }
            if (anudan_con_checked) {
                totalKatti += parseFloat(nagar_anu) * parseFloat(contigency_percent);
            }
            if (!onlyContingency) {
                totalKatti += parseFloat(totalMarmatSamhar());
            }
            if (agreement_other_checked) {
                totalKatti += parseFloat(agreement_other) * parseFloat(contigency_percent);
            }
            if (other_agreement_checked) {
                totalKatti += parseFloat(other_agreement) * parseFloat(contigency_percent);
            }
            if (nagad_sajhedari_checked) {
                totalKatti += parseFloat(costumer_agreement) * parseFloat(contigency_percent);
            }
            //check for remaining cons
            var index = 0;
            JQ('.remaining_con').each(function() {
                if (JQ(this).prop('checked')) {
                    var remaining_anudan = JQ('.remaining_anudan').eq(index).val();
                    totalKatti += parseFloat(remaining_anudan) * parseFloat(contigency_percent);
                }
                index++;
            });
            return totalKatti;
        }

        function calculateJanashram() {
            var kul_lagat_anuman = +JQ('#kul_lagat_anuman').val();
            var kul_lagat_con_checked = JQ('#kul_lagat_con').prop('checked');
            var bhuktani_anudan = +JQ('#bhuktani_anudan').val();
            var agreement_gauplaika = +JQ('#agreement_gauplaika').val();
            var total_investment = +JQ('#total_investment').val();

            var added_value = 0;

            var nagad_sajhedari_add_checked = JQ('#nagad_sajhedari_add').prop('checked');
            if(nagad_sajhedari_add_checked){
                var costumer_agreement = +JQ('#costumer_agreement').val();
                added_value +=costumer_agreement;
                JQ('#nagad_sajhedari_cond_per').val(`${(costumer_agreement / total_investment * 100).toFixed(2)}%`);
                JQ('#nagad_sajhedari_cond_per').css('display','block');
            } else {
                JQ('#nagad_sajhedari_cond_per').css('display','none');
            }

            var aanya_nikaya_add_checked = JQ('#aanya_nikaya_add').prop('checked');
            if(aanya_nikaya_add_checked){
                var agreement_other = +JQ('#agreement_other').val();
                added_value += agreement_other;
                JQ('#aanya_nikaya_cond_per').val(`${(agreement_other / total_investment * 100).toFixed(2)}%`);
                JQ('#aanya_nikaya_cond_per').css('display','block');
            } else {
                JQ('#aanya_nikaya_cond_per').css('display','block');
            }

            var aanya_sajhedari_add_checked = JQ('#aanya_sajhedari_add').prop('checked');
            if(aanya_sajhedari_add_checked){
                var other_agreement = +JQ('#other_agreement').val();
                added_value += other_agreement;
                JQ('#aanya_sajhedari_cond_per').val(`${(other_agreement / total_investment * 100).toFixed(2)}%`);
                JQ('#aanya_sajhedari_cond_per').css('display','block');
            } else {
                JQ('#aanya_sajhedari_cond_per').css('display','none');
            }

            //check for remaining anudan add
            var index = 0;
            JQ('.remaining_add').each(function() {
                if (JQ(this).prop('checked')) {
                    var remaining_anudan = +JQ('.remaining_anudan').eq(index).val();
                    added_value += remaining_anudan;
                }
                index++;
            });

            var janashram = kul_lagat_anuman - bhuktani_anudan - added_value;
            if (kul_lagat_con_checked) {
                janashram = bhuktani_anudan - agreement_gauplaika - added_value + totalKatti();
            }
            if (janashram >= 0) {
                JQ('#costumer_investment').val(janashram.toFixed(2));
                JQ('#user_per').val(`${(janashram / total_investment * 100).toFixed(2)}%`);
            }
        }

        function calculateKulLagatCon() {
            var kul_lagat_anuman = +JQ('#kul_lagat_anuman').val();
            var agreement_gauplaika = +JQ('#agreement_gauplaika').val();
            var kul_lagat_con_checked = JQ('#kul_lagat_con').prop('checked');
            var contigency_percent = +JQ('#hidden_contigency_value').val();
            var contingency = kul_lagat_anuman * contigency_percent;
            if (kul_lagat_con_checked) {
                return parseFloat(2 * contingency - agreement_gauplaika + kul_lagat_anuman);
            } else {
                return 0;
            }
        }

        function calculateTotal() {
            var nagar_anu = +JQ('#agreement_gauplaika').val();
            var kul_lagat_anuman = +JQ('#kul_lagat_anuman').val();
            var katti = totalKatti();
            var total_anudan = totalAnudan();
            var total_karyadesh = parseFloat(nagar_anu) - katti + total_anudan + calculateKulLagatCon();
            JQ('#bhuktani_anudan').val(total_karyadesh.toFixed(2));
            calculateJanashram();
            var costumer_investment = +JQ('#costumer_investment').val() || 0;
            var total_investment = total_karyadesh + parseFloat(costumer_investment);
            var kul_lagat_con_checked = JQ('#kul_lagat_con').prop('checked');
            if (kul_lagat_con_checked) {
                JQ('#bhuktani_anudan').val(kul_lagat_anuman.toFixed(2));
            }
            var nagad_sajhedari_add_checked = JQ('#nagad_sajhedari_add').prop('checked');
            var added_value = 0;
            if(nagad_sajhedari_add_checked){
                var costumer_agreement = +JQ('#costumer_agreement').val();
                added_value +=costumer_agreement;
            }

            var aanya_nikaya_add_checked = JQ('#aanya_nikaya_add').prop('checked');
            if(aanya_nikaya_add_checked){
                var agreement_other = +JQ('#agreement_other').val();
                added_value += agreement_other;
            }

            var aanya_sajhedari_add_checked = JQ('#aanya_sajhedari_add').prop('checked');
            if(aanya_sajhedari_add_checked){
                var other_agreement = +JQ('#other_agreement').val();
                added_value += other_agreement;
            }

            //check for remaining anudan add
            var index = 0;
            var reamining_anduan_checked = false;
            JQ('.remaining_add').each(function() {
                if (JQ(this).prop('checked')) {
                    reamining_anduan_checked = true;
                    var remaining_anudan = +JQ('.remaining_anudan').eq(index).val();
                    added_value += remaining_anudan;
                }
                index++;
            });

            JQ('#total_investment').val((total_investment + added_value).toFixed(2));
            if(kul_lagat_con_checked) {
                JQ('#bhuktani_anudan').val((kul_lagat_anuman - added_value).toFixed(2));
                JQ('#total_investment').val((kul_lagat_anuman + totalKatti() + added_value).toFixed(2));
            } else {
                JQ('#bhuktani_anudan').val((total_karyadesh - added_value).toFixed(2));
            }
            JQ('#karyadesh_per').val(`${(+JQ('#bhuktani_anudan').val() / +JQ('#total_investment').val() * 100).toFixed(2)}%`)
            calculateJanashram();
        }

        JQ(document).on("click",
            "#anudan_con, #marmat_value_new, .marmat_value_remaining, .remaining_add, #marmat_value_kul_lagat, #marmat_value_aanya_nikaya, #marmat_value_aanya_sajhedari, #marmat_value_nagad_sajhedari, #aanya_nikaya_con,#aanya_sajhedari_con,#nagad_sajhedari_con, .remaining_con, #kul_lagat_con, #nagad_sajhedari_add, #aanya_nikaya_add, #aanya_sajhedari_add",
            function() {

                var selected_item_id = JQ(this).attr('id');
                var marmatsamhar_value = JQ('#hidden_marmatsamhar_value').val();

                var contingency = totalKatti(true);
                JQ('#contingency_data').html(contingency);

                totalMarmatSamhar();
                calculateTotal();
            });


        function totalMarmatSamhar() {
            var total_marmat_samhar = 0;
            var marmatsamhar_value = JQ('#hidden_marmatsamhar_value').val();
            var marmat_value_new_checked = JQ('#marmat_value_new').prop('checked')
            if(marmat_value_new_checked) {
                var agreement_gauplaika = +JQ('#agreement_gauplaika').val();
                total_marmat_samhar += agreement_gauplaika * parseFloat(marmatsamhar_value);
            }

            var marmat_value_kul_lagat_checked = JQ('#marmat_value_kul_lagat').prop('checked')
            if(marmat_value_kul_lagat_checked) {
                var kul_lagat_anuman = +JQ('#kul_lagat_anuman').val();
                total_marmat_samhar += kul_lagat_anuman * parseFloat(marmatsamhar_value);
            }

            var marmat_value_aanya_nikaya_checked = JQ('#marmat_value_aanya_nikaya').prop('checked')
            if(marmat_value_aanya_nikaya_checked) {
                var agreement_other = +JQ('#agreement_other').val();
                total_marmat_samhar += agreement_other * parseFloat(marmatsamhar_value);
            }

            var marmat_value_aanya_sajhedari_checked = JQ('#marmat_value_aanya_sajhedari').prop('checked')
            if(marmat_value_aanya_sajhedari_checked) {
                var other_agreement = +JQ('#other_agreement').val();
                total_marmat_samhar += other_agreement * parseFloat(marmatsamhar_value);
            }

            var marmat_value_nagad_sajhedari_checked = JQ('#marmat_value_nagad_sajhedari').prop('checked')
            if(marmat_value_nagad_sajhedari_checked) {
                var costumer_agreement = +JQ('#costumer_agreement').val();
                total_marmat_samhar += costumer_agreement * parseFloat(marmatsamhar_value);
            }


            //check for remaining marmat
            var index = 0;
            JQ('.marmat_value_remaining').each(function() {
                if (JQ(this).prop('checked')) {
                    var remaining_anudan = JQ('.remaining_anudan').eq(index).val();
                    total_marmat_samhar += parseFloat(remaining_anudan) * parseFloat(marmatsamhar_value);
                }
                index++;
            });


            total_marmat_samhar = total_marmat_samhar.toFixed(2);
            JQ('#added_marmat_samhar_data').html(total_marmat_samhar);
            return total_marmat_samhar;
        }


        function generateClassIdentifier(aanya_nikaya, aanya_sajhedari, remaining) {
            return JQ('.anudan_item').length === 0 ? aanya_nikaya :
                JQ('.anudan_item').length === 1 ? aanya_sajhedari : remaining;
        }

        JQ(document).on('click', '#handleAddNew', function(e) {
            e.preventDefault();

            const checkboxName = generateClassIdentifier('aanya_nikaya_con', 'aanya_sajhedari_con', 'remaining_con');
            const checkboxAddName = generateClassIdentifier('aanya_nikaya_add', 'aanya_sajhedari_add', 'remaining_add');
            const marmatAddName = generateClassIdentifier('marmat_value_aanya_nikaya', 'marmat_value_aanya_sajhedari', 'marmat_value_remaining');
            const inputName = generateClassIdentifier('agreement_other', 'other_agreement', 'remaining_anudan');
            const inputConPer = generateClassIdentifier('aanya_nikaya_cond_per', 'aanya_sajhedari_cond_per', 'remaining_anudan_cond_per');
            const itemId = generateClassIdentifier('1', '1', JQ('.anudan_item').length - 2);

            const html = `<div class="anudan_item">
                  <div class="titleInput">
                  <div style="display:flex">
                      <input required style="margin-bottom: 4px" name="${checkboxName === 'remaining_con' ? 'remaining_title[]' : ''}"  type="text" value="अन्य साझेदारी :">
                      <button class="remove_anudan" data-anudan-id="1" style="color:red;border:none;cursor:pointer">X</button>
                    </div>
                    <input
                      type="checkbox"
                      name="${checkboxName === 'remaining_con' ? 'remaining_con[]' : checkboxName}"
                      id="${checkboxName}"
                      class="${checkboxName}"
                      value=${itemId}
                    />
                    <span style="color: red">
                      कन्टेन्जेन्सी
                      <span class="con_value">(${JQ('#hidden_contigency_value').val() * 100}%)</span>
                      काट्ने भएमा टिक लगाउनुहोस
                    </span>
                    <div>
                      <input
                        type="checkbox"
                        name="${marmatAddName === 'marmat_value_remaining' ? 'marmat_value_remaining[]' : marmatAddName}"
                        id="${marmatAddName}"
                        class="${marmatAddName}"
                        value=${itemId}
                      />
                      <span style="color: red">
                        मर्मत संहार
                        <span class="marmat_value">(${JQ('#hidden_marmatsamhar_value').val() * 100}%)</span>
                        काट्ने भएमा टिक लगाउनुहोस
                      </span>
                    </div>

                    <input
                      type="checkbox"
                      name="${checkboxAddName === 'remaining_add' ? 'remaining_add[]' : checkboxAddName}"
                      id="${checkboxAddName}"
                      class="${checkboxAddName}"
                      value=${itemId}
                    />
                    <span style="color: red">पालिका खातामा पैसा जम्मा गर्ने होइन भने टिक लगाउनुहोस </span>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="newInput">
                        <input
                          type="text"
                          required
                          name="${inputName === 'remaining_anudan' ? 'remaining_anudan[]' : inputName}"
                          id="${inputName}"
                          class="${inputName}"
                          value="0"
                        />
                      </div>
                    </div>
                    <div class="col-md-2" style="padding:0">
                      <div class="newInput">
                        <input
                          type="text"
                          value=""
                          name="${inputConPer === 'remaining_anudan_cond_per' ? 'remaining_anudan_cond_per[]' : inputConPer}"
                          id="${inputConPer}"
                          class="${inputConPer}"
                          style="max-width: 100px; display: none"
                          readonly
                        >
                      </div>
                    </div>
                  </div>
                </div>`
            JQ('#anudan_container').append(html)
        });
        JQ(document).on('click', '.remove_anudan', function(e) {
            e.preventDefault();
            JQ(this).parent().parent().parent().remove();

            calculateTotal();
        });
    });
</script>