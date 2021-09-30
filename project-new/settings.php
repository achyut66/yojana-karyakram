<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
error_reporting(1);
$mode = getUserMode();
if ($mode != "administrator" && $mode != "superadmin" && $mode !="user") {
    die("ACCESS DENIED");
} ?>

<?php include("menuincludes/header.php"); ?>
    <!-- js ends -->
<title>सेटिंग :: <?php echo SITE_SUBHEADING; ?></title>
<!--<style>-->
<!--    .grid-container {-->
<!--      display: grid;-->
<!--      grid-column-gap: 0px;-->
<!--      grid-row-gap:5px;-->
<!--      grid-template-columns: 300px 300px 300px 300px;-->
<!--      background-color: #98AFC7;-->
<!--      padding: 10px;-->
<!--    }-->
    
<!--    .grid-item {-->
<!--      background-color: rgba(255, 255, 255, 0.8);-->
<!--      border: 3px solid rgba(0, 0, 0, 0.8);-->
<!--      padding: 5px;-->
<!--      font-size: 20px;-->
<!--      text-align: center;-->
<!--    }-->
<!--</style>-->
</head>
    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">

        <div class="maincontent">
            <h2 class="headinguserprofile">सेटिंग | <a href="index.php" class="btn">पछि जानुहोस</a></h2>

            <div class="OurContentFull">
                <div class="dashboardcontent">
                    <?php if($mode=="superadmin"):?>
                    <a href="settings_fiscal.php">
                        <div class="userprofile25">
                            <h4>आर्थिक वर्ष</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_topic.php">
                        <div class="userprofile25">
                            <h4>बिषयगत क्षेत्र</h4>
                            <div class="dashimg">
                                <img src="images/report-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="topic_area_type_view.php">
                        <div class="userprofile25">
                            <h4>योजनाको शिर्षकगत किसिम</h4>
                            <div class="dashimg">
                                <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="topic_area_type_sub_view.php">
                        <div class="userprofile25">
                            <h4>योजनाको उपशिर्षकगत किसिम</h4>
                            <div class="dashimg">
                                <img src="images/patra-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="view_topic_area_agreement.php">
                        <div class="userprofile25">
                            <h4>योजनाको अनुदानको किसिम</h4>
                            <div class="dashimg">
                                <img src="images/new_plan_icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="view_topic_area_investment.php">
                        <div class="userprofile25">
                            <h4>योजनाको विनियोजन किसिम</h4>
                            <div class="dashimg">
                                <img src="images/upabhokta-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_unit.php">
                        <div class="userprofile25">
                            <h4>योजनाको भौतिक इकाई</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin" || $mode=="user"):?>
                    <a href="view_post.php">
                        <div class="userprofile25">
                            <h4>पद</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="view_worker_details.php">
                        <div class="userprofile25">
                            <h4>कार्यकारी व्यक्ति विवरण</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin"):?>
                    <a href="view_bank_information.php">
                        <div class="userprofile25">
                            <h4>बैंक रेकोर्ड</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin" || $mode=="user"):?>
                    <a href="plan_form_view.php">
                        <div class="userprofile25">
                            <h4>योजना विवरण सच्याउनुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin"):?>
                    <a href="yojana_merge.php">
                        <div class="userprofile25">
                            <h4>योजना विवरण जोड्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin"):?>
                    <a href="plan_form_delete.php">
                        <div class="userprofile25">
                            <h4>योजना विवरण हटाउनुहोस्</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    
                    <a href="program_settings.php">
                        <div class="userprofile25">
                            <h4>सूची दर्ता</h4>
                            <div class="dashimg">
                                <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="enlist_usamiti.php">
                        <div class="userprofile25">
                            <h4>उपभोक्ता समिति सूची दर्ता हेर्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_upabhokta_samiti_add.php">
                        <div class="userprofile25">
                            <h4>उपभोक्ता समिति सूची दर्ता भर्नुहोस्</h4>
                            <div class="dashimg">
                                <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="setting_budget_topic.php">
                        <div class="userprofile25">
                            <h4>बजेट शिर्षक थप्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="setting_budget_topic_profile.php">
                        <div class="userprofile25">
                            <h4>बजेट शिर्षकमा रकम थप्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="view_ekmusta_budget.php">
                        <div class="userprofile25">
                            <h4>एकमुस्ट खर्च प्रबिस्टी</h4>
                                <div class="dashimg">
                                    <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="setting_documents.php">
                        <div class="userprofile25">
                            <h4>कागजात थप्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/dataentry-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin" || $mode=="user"):?>
                    <a href="setting_contractor_details.php">
                        <div class="userprofile25">
                            <h4>निर्माण व्यवसायी थप्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin"):?>
                    <a href="settings_rules.php">
                        <div class="userprofile25">
                            <h4>सर्तहरु थप्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_contingency.php">
                        <div class="userprofile25">
                            <h4>कन्टिनजेन्सी प्रतिशत हल्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                        <a href="settings_bipat.php">
                            <div class="userprofile25">
                                <h4>विपत प्रतिशत हल्नुहोस</h4>
                                <div class="dashimg">
                                    <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                                </div>
                            </div>
                        </a>
                    <a href="settings_marmat_samhar.php">
                        <div class="userprofile25">
                            <h4>मर्मत संहार प्रतिशत हल्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_ward_no.php">
                        <div class="userprofile25">
                            <h4>वार्ड नं हल्नुहोस</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="upabhokta_samiti_info.php">
                        <div class="userprofile25">
                            <h4>कार्यक्रम संचालन गर्ने उपभोक्ता समिति</h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="setting_shrot.php">
                        <div class="userprofile25">
                            <h4>बजेट स्रोत </h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_katti_wiwarn.php">
                        <div class="userprofile25">
                            <h4>कट्टी विवरण </h4>
                            <div class="dashimg">
                                <img src="images/setting-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="settings_bhautik_lakshya.php">
                        <div class="userprofile25">
                            <h4>भौतिक लक्ष्यको शिर्षक</h4>
                            <div class="dashimg">
                                <img src="images/patra-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <a href="anugaman_samiti_bibaran_view.php">
                        <div class="userprofile25">
                            <h4>नगरपालिका अनुगमन समिति विवरण भर्नुहोस् </h4>
                            <div class="dashimg">
                                <img src="images/patra-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                    <?php if($mode=="superadmin" || $mode=="user"):?>
                    <a href="letter_indices.php">
                        <div class="userprofile25">
                            <h4>पत्रको अनुक्रमणिका</h4>
                            <div class="dashimg">
                                <img src="images/pen-icon.png" alt="Settings Icons" class="dashimg">
                            </div>
                        </div>
                    </a>
                    <?php endif;?>
                   
                </div>
                


            </div>
        </div><!-- main menu ends -->

    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
