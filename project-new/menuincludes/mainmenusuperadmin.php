<?php
require_once("includes/initialize.php");
$mode= getUserMode();
$user = getUser();
//print_r($user);
$fy = Fiscalyear::find_by_id(1);//print_r($fy);
if(isset($_SESSION['set_plan_id']))
{
//    echo $_SESSION['set_plan_id'];exit;
    $upobhokta_result=  Plantotalinvestment::find_by_plan_id($_SESSION['set_plan_id']);
    $amanat_result = AmanatLagat::find_by_plan_id($_SESSION['set_plan_id']);
    $thekka_result=  Contractinfo::find_by_plan_id($_SESSION['set_plan_id']);
    $samiti_result=  Samitiplantotalinvestment::find_by_plan_id($_SESSION['set_plan_id']);
    $karyakram_result=  Programmoredetails::find_by_program_id($_SESSION['set_plan_id']);
}
?>
<style>
    /*ul {*/
    /*color: #dbcece;*/
    /*    border: none;*/
    /*    font: bold 14px sans-serif;*/
    /*    background: MediumSeaGreen;*/
    /*-webkit-transition: background 1s; /* For Safari 3.0 to 6.0
    transition: background 1s; /* For modern browsers
/*}*/
    /*ul:hover {*/
    /*    background: #3cc16e;*/
    /*}*/
</style>
<div class="mainmenu">
    <nav>
        <ul>
            <li><a href="index.php">गृह पृष्ठ</a></li>
            <?php if($mode=="superadmin" || $mode=="user"):?>
                <li><a href="settings.php">सेटिंग</a>
                    <ul>
                        <?php if($mode=="superadmin" || $mode=="user"):?>
                            <li><a href="plan_form_view.php">योजना विवरण सच्याउनुहोस</a></li>
                        <?php endif;?>
                        <?php if($mode=="superadmin"):?>
                            <li><a href="plan_form_test.php">Excel अपलोड</a></li>
                            <li><a href="settings_fiscal.php">आर्थिक वर्ष</a></li>
                            <li><a href="settings_topic.php">विषयगत क्षेत्र</a></li>
                            <li><a href="topic_area_type_view.php">योजनाको शिर्षकगत किसिम</a>
                            <li><a href="topic_area_type_sub_view.php">योजनाको उपशिर्षकगत किसिम</a></li>
                            <li><a href="view_topic_area_agreement.php">योजनाको अनुदानको किसिम</a></li>
                            <li><a href="view_topic_area_investment.php">योजनाको विनियोजन किसिम</a></li>
                            <li><a href="settings_unit.php">भौतिक इकाई </a></li>
                            <li><a href="view_post.php">पद</a></li>
                            <li><a href="view_worker_details.php">कार्यकारी व्यक्ति विवरण</a></li>
                            <li><a href="view_bank_information.php">बैंक रेकोर्ड</a></li>
                            <li><a href="plan_form_delete.php">योजना विवरण हटाउनुहोस्</a></li>
                            <li><a href="program_settings.php">सूची दर्ता</a></li>
                            <li><a href="setting_budget_topic.php">बजेट शिर्षक थप्नुहोस</a></li>
                            <li><a href="setting_budget_topic_profile.php">बजेट शिर्षकमा  रकम  थप्नुहोस</a></li>
                            <!--<li><a href="view_ekmusta_budget.php">एकमुस्ट खर्च प्रबिस्टी</a></li>-->
                            <li><a href="setting_documents.php">कागजात थप्नुहोस</a></li>
                            <li><a href="setting_contractor_details.php">निर्माण ब्यवोसायी थप्नुहोस</a></li>
                            <li><a href="settings_rules.php">सर्तहरु थप्नुहोस</a></li>
                            <li><a href="settings_contingency.php">कन्टिनजेन्सी प्रतिशत हल्नुहोस</a></li>
                            <li><a href="settings_marmat_samhar.php">मर्मत संहार प्रतिशत हल्नुहोस</a></li>
                            <li><a href="settings_ward_no.php">वार्ड नं हल्नुहोस</a></li>
                            <li><a href="setting_shrot.php">बजेट स्रोत </a></li>
                            <li><a href="settings_katti_wiwarn.php">कट्टी विवरण</a></li>
                            <li><a href="upabhokta_samiti_info.php">कार्यक्रम संचालन गर्ने उपभोक्ता समिति</a></li>
                            <li><a href="settings_upabhokta_samiti_add.php">उपभोक्ता समिति सूची दर्ता भर्नुहोस्</a></li>
                        <?php endif;?>
                    </ul>
                </li>

                <li><a href="plan_form_new.php">नया योजना / कार्यक्रम दर्ता </a></li>
            <?php endif;?>
            <?php if($mode=="superadmin" || $mode=="administrator" || $mode=="user" || $mode=="section"):?>
                <li><a href="view_plan_dashboard.php">योजना / कार्यक्रम हेर्नुहोस </a>
                    <ul>
                        <li><a href="view_all_plans.php">योजना / कार्यक्रम विवरण हेर्नुहोस </a></li>
                        <?php if($mode!="section"):?>
                            <li><a href="view_budgetwise_plan.php">बजेट शिर्षक अनुसार योजना / कार्यक्रम हेर्नुहोस</a></li>
                        <?php endif;?>

                        <li><a href="view_topic_wise_report.php">बिषयगत क्षेत्रको किसिम अनुसार योजना/कार्यक्रम हेर्नुहोस</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if($mode=="administrator" || $mode=="superadmin" || $mode=="user" || $mode=="section"):?>
                <li><a href="yojanasanchalandash.php">योजना संचालन प्रक्रिया</a>
                    <ul>
                        <li><a href="setid.php">उपभोक्ता समिती मार्फत</a>
                            <?php if(!isset($_SESSION['set_plan_id'])){
                            }
                            elseif(empty($upobhokta_result))
                            {

                            }else{

                                ?>
                                <ul>
                                    <li><a href="kul_lagat_dashboard.php">योजनाको कुल लागत अनुमान / फोटो हाल्नुहोस</a></li>
                                    <li><a href="plan_form1_1.php">उपभोक्ता समिति विवरण</a></li>
                                    <li><a href="plan_form1_2.php">अनुगमन समिति विवरण</a></li>
                                    <li><a href="plan_form1_3.php">योजना सम्बन्धी अन्य विवरण</a></li>
                                    <li><a href="letters_select.php">पत्रहरु</a>
                                        <ul>
                                            <li><a href="print_bank_report08.php">संझौताको टिप्पणी</a></li>
                                            <li><a href="print_bank_report02.php">संझौता पत्र</a></li>
                                            <li><a href="print_bank_report_05.php">संझौता कार्यदेश</a></li>
                                            <li><a href="dashboard_bhuktani.php">योजनाको सिफारिस </a>
                                                <ul>
                                                    <li><a href="print_bank_report_12.php">अन्तिम भुक्तानीको सिफारिस</a></li>
                                                    <li><a href="print_bank_report_13.php">मुल्यांकनको आधारमा  भुक्तानीको सिफारिस </a></li>
                                                </ul>
                                            </li>
                                            <li><a href="print_bank_report03_yojana.php">पेश्की संझौताको टिप्पणी</a></li>
                                            <li><a href="print_bank_report_04.php">पेश्की संझौताको कार्यदेश</a></li>
                                            <li><a href="print_bank_report01.php">बैंक खाता संचालनको पत्र</a></li>
                                            <li><a href="print_bank_report07.php">म्यादको थपको टिप्पणी</a></li>
                                            <li><a href="print_bank_report06.php">म्यादको थपको पत्र</a></li>
                                            <li><a href="print_bank_report_09.php">मुल्यांकनको आधारमा भुक्तानीको टिप्पणी</a></li>
                                            <li><a href="print_bank_report_11.php">अन्तिम भुक्तानीको टिप्पणी</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="bhuktani_select.php">भुक्तानी</a>
                                        <ul>
                                            <li><a href="plan_form2.php">पेश्की भुक्तानी</a></li>
                                            <li><a href="plan_form4.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                                            <li><a href="plan_form5.php">अन्तिम भुक्तानी</a></li>
                                            <li><a href="additionaldate.php">म्याद थप</a></li>
                                            <li><a href="yojanadharauti.php">धरौटी फिर्ता</a></li>

                                        </ul>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>

                        <li><a href="amanat_setid.php">अमानत मार्फत</a>
                            <?php if(!isset($_SESSION['set_plan_id'])){
                            }
                            elseif(empty($amanat_result))
                            {

                            }else{

                                ?>
                                <ul>
                                    <li><a href="amanat_lagat_dashboard.php">योजनाको कुल लागत अनुमान / फोटो हाल्नुहोस</a></li>
                                    <li><a href="amanat_more_details.php">योजना सम्बन्धी अन्य विवरण</a></li>
                                    <li><a href="amanat_letter_select.php">पत्रहरु</a>
                                        <ul>
                                            <li><a href="print_bank_report08.php">संझौताको टिप्पणी</a></li>
                                            <li><a href="print_bank_report_05.php">संझौता कार्यदेश</a></li>
                                            <!--                                        <li><a href="dashboard_bhuktani.php">योजनाको सिफारिस </a>
                                                                                        <ul>
                                                                                            <li><a href="print_bank_report_12.php">अन्तिम भुक्तानीको सिफारिस</a></li>
                                                                                            <li><a href="print_bank_report_13.php">मुल्यांकनको आधारमा  भुक्तानीको सिफारिस </a></li>
                                                                                        </ul>
                                                                                    </li>-->
                                            <li><a href="print_bank_report03_yojana.php">पेश्की संझौताको टिप्पणी</a></li>
                                            <li><a href="print_bank_report_04.php">पेश्की संझौताको कार्यदेश</a></li>
                                            <li><a href="print_bank_report01.php">बैंक खाता संचालनको पत्र</a></li>
                                            <li><a href="print_bank_report07.php">म्यादको थपको टिप्पणी</a></li>
                                            <li><a href="print_bank_report06.php">म्यादको थपको पत्र</a></li>
                                            <li><a href="print_bank_report_09.php">मुल्यांकनको आधारमा भुक्तानीको टिप्पणी</a></li>
                                            <li><a href="print_bank_report_11.php">अन्तिम भुक्तानीको टिप्पणी</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="amanat_bhuktani_dashboard.php">भुक्तानी</a>
                                        <ul>
                                            <li><a href="plan_form2.php">पेश्की भुक्तानी</a></li>
                                            <li><a href="plan_form4.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                                            <li><a href="plan_form5.php">अन्तिम भुक्तानी</a></li>
                                            <li><a href="additionaldate.php">म्याद थप</a></li>
                                            <li><a href="yojanadharauti.php">धरौटी फिर्ता</a></li>

                                        </ul>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>

                        <li><a href="samiti_setid.php">संस्था मार्फत</a>
                            <?php if(!isset($_SESSION['set_plan_id']))
                            {
                            }
                            elseif(empty($samiti_result))
                            {


                            }else{?>
                                <ul>
                                    <li><a href="samiti_kul_lagat_dashboard.php">योजनाको कुल लागत अनुमान / फोटो हाल्नुहोस</a></li>
                                    <li><a href="samiti_plan_form1_1.php">संस्था / समिति विवरण </a></li>
                                    <li><a href="samiti_plan_form1_2.php">अनुगमन समिति विवरण</a></li>
                                    <li><a href="samiti_plan_form1_3.php">योजना सम्बन्धी अन्य विवरण</a></li>
                                    <li><a href="samiti_letters_select.php">पत्रहरु</a>
                                        <ul>
                                            <li><a href="samjhauta_tippani_letter.php">संझौताको टिप्पणी</a></li>
                                            <li><a href="samjhauta_letter.php">संझौता पत्र</a></li>
                                            <li><a href="samiti_samjhauta_karyadesh.php">संझौता कार्यदेश</a></li>
                                            <li><a href="samiti_peski_samjhauta_tippani.php">पेश्की संझौताको टिप्पणी</a></li>
                                            <li><a href="samiti_peski_samjhauta_karyadesh.php">पेश्की संझौताको कार्यदेश</a></li>
                                            <li><a href="samiti_bank_letter.php">बैंक खाता संचालनको पत्र</a></li>
                                            <li><a href="samiti_additional_date_tippani_letter.php">म्यादको थपको टिप्पणी</a></li>
                                            <li><a href="samiti_add_date_letter.php">म्यादको थपको पत्र</a></li>
                                            <li><a href="samiti_analysis_letter.php">मुल्यांकनको आधारमा भुक्तानीको टिप्पणी</a></li>
                                            <li><a href="samiti_final_letter.php">अन्तिम भुक्तानीको टिप्पणी</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="samiti_bhuktani_select.php">भुक्तानी</a>
                                        <ul>
                                            <li><a href="plan_form2.php">पेश्की भुक्तानी </a></li>
                                            <li><a href="form4.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                                            <li><a href="plan_form5.php">अन्तिम भुक्तानी</a></li>
                                            <li><a href="additionaldate.php">म्याद थप</a></li>
                                            <li><a href="samiti_yojanadharauti.php">धरौटी फिर्ता </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            <?php }?>
                        </li>
                        <li><a href="contract_set_id.php">ठेक्का मार्फत</a>
                            <?php if(!isset($_SESSION['set_plan_id'])){
                            }
                            elseif(empty($thekka_result))
                            {
                            }else{?>
                            <ul>
                                <li><a href="">सुचिकृत फर्म कम्पनी</a>
                                    <ul>
                                        <li><a href="view_contract_info.php">ठेक्का सूचना दर्ता</a></li>
                                        <li> <a href="view_contract_invitation_for_bid.php">ठेक्का बोलपत्र बिक्रि किताब </a></li>
                                        <li><a href="view_contract_invitation_entry.php">ठेक्का बोलपत्र दर्ता किताब </a></li>
                                        <li><a href="view_contract_bid_final.php">ठेक्का खोलिएको फारम</a></li>
                                        <li><a href="view_contract_entry_final.php">ठेक्का कबोल फारम</a></li>
                                        <li><a href="contract_bid_form_view.php">ठेक्का बोलिने फारम </a></li>
                                        <li><a href="contract_form1.php">ठेक्काको कुल लागत अनुमान</a></li>
                                        <li><a href="contract_form2.php">ठेक्का संचालन विवरण</a></li>
                                        <li><a href="contract_letter_dashboard.php">पत्रहरु</a>
                                            <ul>
                                                <li><a href="contract_print_karyadesh_report_09.php">ठेक्का सम्झौताको टिप्पणी </a></li>
                                                <li><a href="contract_print_karyadesh_report_08.php"> ठेक्का संझौता पत्र</a></li>
                                                <li><a href="contract_print_karyadesh_report_02.php">कार्यदेश पत्र</a></li>
                                                <li><a href="contract_print_karyadesh_report_03.php">पेश्की कार्यदेशको टिप्पणी</a></li>
                                                <li><a href="contract_print_karyadesh_report_04.php">म्याद थप को टिप्पणी </a></li>
                                                <li><a href="contract_print_karyadesh_report_05.php">म्याद थप को पत्र  </a></li>
                                                <li><a href="contract_print_karyadesh_report_06.php">मुल्यांकनको आधारमा भुक्तानीको  टिप्पणी</a></li>
                                                <li><a href="contract_print_karyadesh_report_07.php">अन्तिम भुक्तानीको टिप्पणी</a></li>
                                                <li><a href="contract_print_karyadesh_report_10.php">धरौटी फिर्ता</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contract_bhuktani_dashboard.php">भुक्तानी</a>
                                            <ul>
                                                <li><a href="contingency_expenditure.php">कन्टेन्जेन्सी खर्च </a></li>
                                                <li><a href="contract_advance.php">पेश्की भुक्तानी </a></li>
                                                <li><a href="contract_form3.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                                                <li><a href="contract_final.php">अन्तिम भुक्तानी</a></li>
                                                <li><a href="contract_additionaldate.php">म्याद थप</a></li>
                                                <li><a href="contractdharauti_dashboard.php">धरौटी फिर्ता </a>
                                                    <ul>
                                                        <li><a href="contractdharauti.php">थप धरौटी जम्मा </a>
                                                        <li><a href="contract_dharauti_firta.php">धरौटी फिर्ता </a>
                                                        <li><a href="contract_print_karyadesh_report_10.php">धरौटी फिर्ता पत्र </a>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="">ई-बिडिंग मार्फत</a>
                                    <ul>
                                        <li><a href="ethekka_kul_lagat.php">ठेक्काको कुल लागत</a></li>
                                        <li><a href="ethekka_lagat_info_form.php">ठेक्का सम्बन्धि विवरण</a></li>
                                        <li><a href="contract_letter_dashboard.php">पत्रहरु</a>
                                            <ul>
<!--                                                <li><a href="contract_print_karyadesh_report_09.php">परामर्श सेवा खरिद गर्ने सम्बन्धमा</a></li>-->
                                                <li><a href="ethekka_tippani_patra.php">लागत अनुमान स्वीकृत गरि कार्य अगाडी बढाउने सम्बन्धमा</a></li>
                                                <li><a href="ethekka_aashay_suchana.php">आशयको सूचना प्रकाशन सम्बन्धमा</a></li>
                                                <li><a href="ethekka_bolpatra_aashay.php">बोलपत्र स्वीकृत गर्ने आशयको सूचना</a></li>
                                                <li><a href="ethekka_jamanat_fukuwa.php">कार्य सम्पादन जमानत फुकुवा सम्बन्धमा</a></li>
                                                <li><a href="ethekka_bolpatra_samjhauta.php">बोलपत्र स्वीकृत एवं सम्झौता सम्बन्धमा</a></li>
                                                <li><a href="ethekka_samjhauta.php">सम्झौता गर्न आउने सम्बन्धमा</a></li>
                                                <li><a href="ethekka_karyadesh_patra.php">कार्यादेश सम्बन्धमा</a></li>
<!--                                                <li><a href="contract_print_karyadesh_report_10.php">धरौटी फिर्ता</a></li>-->
                                            </ul>
                                        </li>
                                        <li><a href="contract_bhuktani_dashboard.php">भुक्तानी</a>
                                            <ul>
                                                <li><a href="contract_advance.php">पेश्की भुक्तानी </a></li>
                                                <li><a href="contract_form3.php">मुल्यांकनको आधारमा भुक्तानी</a></li>
                                                <li><a href="contract_final.php">अन्तिम भुक्तानी</a></li>
                                                <li><a href="contract_additionaldate.php">म्याद थप</a></li>
                                                <li><a href="contractdharauti_dashboard.php">धरौटी फिर्ता </a>
                                                    <ul>
                                                        <li><a href="contractdharauti.php">थप धरौटी जम्मा </a>
                                                        <li><a href="contract_dharauti_firta.php">धरौटी फिर्ता </a>
                                                        <li><a href="contract_print_karyadesh_report_10.php">धरौटी फिर्ता पत्र </a>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <?php }endif;?>
                        <li>
                            <a href="quotation_setid.php">कोटेसन् मार्फत</a>
                        </li>
                    </ul>
                </li>

            <?php if($mode=="superadmin" || $mode=="subadmin"):?>
                <li><a href="estimate_dashboard.php">प्राबिधिक इष्टिमेट तथा मुल्यांकन</a>
                    <ul>
                        <li><a href="estimate_dashboard.php">प्राबिधिक इष्टिमेट तथा मुल्यांकन विवरण </a>
                            <ul>
                                <li><a href="estimate_setid.php">योजना खोज्नुहोस</a>
                                    <?php if(isset($_SESSION['set_plan_id'])){
                                        ?><ul>
                                            <!--<li><a href="estimate_anudan_details.php">अनुदान सम्बन्धी विवरण </a></li>-->
                                            <li><a href="estimate_lagat_anuman.php">इष्टिमेटको कुल लागत अनुमान </a></li>
                                            <li><a href="napi_lagat_dashboard.php">नापी किताब </a></li>
                                            <li><a href="print_estimate_pratibedan.php">कार्यसम्पन्न प्रतिबेदन </a></li>
                                            <li><a href="bill_dashboard.php">रनिङ्ग  बिल </a></li>
                                            <!--<li><a href="estimate_paperdashboard.php">पत्रहरु </a></li>-->
                                        </ul><?php } ?>
                                </li>
                            </ul>
                        </li>
                        <li><a href="estimate_yojana_list.php">इष्टिमेट भएको योजना  </a></li>
                    </ul>
                </li>
            <?php endif;?>
            <?php if($mode=="administrator" || $mode=="superadmin" || $mode=="user" || $mode=="section"):?>
                <li><a href="setprogramid.php">कार्यक्रम संचालन प्रकृया</a>
                    <ul> <?php if(!isset($_SESSION['set_plan_id']))
                        {
                        }
                        elseif(empty($karyakram_result))
                        {


                        }else{?>
                            <li><a href="program_more_details.php">कार्यक्रम संचालन विवरण</a></li>
                            <li><a href="program_payment.php">पेश्की भुक्तानी</a></li>
                            <li><a href="program_additional_date.php">कार्यक्रम म्याद थप</a></li>
                            <li><a href="letters_select_programs.php">पत्रहरु</a>
                                <ul>
                                    <li><a href="print_karyadesh_report_01.php">कार्यदेशको टिप्पणी</a></li>
                                    <li><a href="print_karyadesh_report_02.php">कार्यदेश पत्र</a></li>
                                    <li><a href="print_karyadesh_report_03.php">पेश्की कार्यदेशको टिप्पणी</a></li>
                                    <li><a href="print_karyadesh_report_04.php">पेश्की कार्यदेश पत्र</a></li>
                                    <li><a href="print_karyadesh_report_05.php">म्यादको थपको टिप्पणी</a></li>
                                    <li><a href="#">म्यादको थपको पत्र</a></li>
                                    <li><a href="print_karyadesh_report_12.php">भुक्तानीको सिफारिस</a></li>
                                    <li><a href="print_karyadesh_report_07.php">अन्तिम भुक्तानीको टिप्पणी </a></li>
                                    <li><a href="#">फोटो हाल्नुहोस्</a></li>
                                    <li><a href="print_karyadesh_report_13.php">संझौता पत्र</a></li>
                                </ul>
                            </li>
                            <li><a href="program_payment_final.php">अन्तिम भुक्तानी</a></li><?php }?>
                    </ul>
                </li>
            <?php endif;    ?>
            <?php if($mode=="administrator" || $mode=="superadmin"|| $mode=="user" ):?>
                <li><a href="report_dashboard.php">रिपोर्ट हेर्नुहोस</a>
                    <ul>
                        <li><a href="report.php">आन्तरिक रिपोर्ट हेर्नुहोस</a></li>
                        <li><a href="mainreport.php">आंसिक मुख्य रिपोर्ट हेर्नुहोस</a></li>
                        <li><a href="mainreport1.php">योजनाको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस</a></li>
                        <li><a href="mainreport2.php">कार्यक्रमको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस</a></li>
                        <li><a href="bhautik_pragati_report.php">भौतिक लक्ष्यको  रिपोर्ट हेर्नुहोस</a></li>
                        <li><a href="sanchalan_prakriya_report.php">संचालन प्रक्रिया अनुसार रिपोर्ट </a></li>
                        <li><a href="kar_katti_report.php">कर कट्टी विवरण </a></li>
                        <li><a href="anusuchi_dashboard.php">खर्च प्रतिबेदन </a>
                            <ul>
                                <li><a href="anusuchi_1.php">खर्च प्रतिबेदन सारांस</a></li>
                                <li><a href="anusuchi_2.php">खर्च प्रतिबेदन बिस्तृत</a></li>
                                <li><a href="sarans_expenditure_report.php">बिषयगत क्षेत्र / बजेट उपशीर्षक अनुसार खर्च विवरण</a></li>
                                <li><a href="anudan_expenditure_report.php">अनुदान अनुसार खर्च विवरण</a></li>
                                <li><a href="expenditure_type_wise_report.php">खर्च किसिम अनुसार रिपोर्ट हेर्नुहोस</a></li>
                            </ul>
                        </li>
                        <li><a href="sarans_report.php">बिनियोजन सारांस हेर्नुहोस </a></li>
                        <li><a href="detail_final_report1.php">अनुसूची-१ रिपोर्ट </a></li>
                        <li><a href="detail_final_report2.php">अनुसूची-२ रिपोर्ट </a></li>
                        <li><a href="added_plan_report.php">जोडिएको योजनाको रिपोर्ट</a></li>
                        <li><a href="separated_plan_report.php">टुक्रिएको योजनाको रिपोर्ट</a></li>
                    </ul>
                </li>
            <?php endif;?>
            <?php if($mode=="superadmin"):?>
                <li><a href="user_details.php">प्रयोगकर्ता थप्नुहोस</a></li>
                <li><a href="#">बजेट निर्माण </a>
                    <ul>
                        <li><a href="budget_nirman.php">बजेट निर्माण गर्नुहोस </a></li>
                        <?php if($mode=="superadmin"):?>
                            <li><a href="budget_nirman_approve.php">बजेट स्वीकृत गर्नुहोस </a></li>
                            <li><a href="budget_nirman_transfer.php">बजेटबाट योजना बनाउनुहोस </a></li>
                        <?php endif;?>
                    </ul>
                </li>
            <?php endif;?>
        </ul>
    </nav>
</div><!-- main menu ends -->
