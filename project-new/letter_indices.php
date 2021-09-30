<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
} ?>
<?php include("menuincludes/header.php"); ?>
<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $form_data = LetterIndices::find_by_id($_POST['update_id']);
    } else {
        $form_data = new LetterIndices();
    }

    //$data->sn= $_POST['sn'];
    $form_data->letter_index = $_POST['letter_index'];
    $form_data->letter_index_nepali = $_POST['letter_index_nepali'];
    $form_data->letter_table = $_POST['letter_table'];
    $form_data->table_property = $_POST['table_property'];
//    $form_data->amount = $_POST['percent']/100;
    if ($form_data->save()) {
        echo alertBox("डाटा सेव भयो ||", "letter_indices.php");
    }
}

if (isset($_GET['id'])) {
    $data = LetterIndices::find_by_id($_GET['id']);

} else {
    $data = LetterIndices::setEmptyObjects();
}
$budget_result = LetterIndices::find_all();
?>
<!-- js ends -->
<title>वार्ड नं हाल्नुहोस : <?php echo SITE_SUBHEADING; ?></title>

</head>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="maincontent">
        <h2 class="headinguserprofile">पत्रहरुको विवरण हाल्नुहोस | <a href="settings.php" class="btn">पछि जानुहोस </a>
        </h2>
        <div class="myMessage"><?php echo $message; ?></div>
        <div class="OurContentFull">

            <h2>पत्रहरुको अनुक्रमणिका विवरण हाल्नुहोस </h2>
            <div class="userprofiletable">
                <form method="post" enctype="multipart/form-data">
                    <div class="inputWrap">
                        <div class="titleInput">पत्रको अनुक्रमणिका अंग्रेजीमा</div>
                        <div class="newInput"><input type="text" name="letter_index" value="<?php echo $data->letter_index; ?>"
                                                     required></div>

                        <div class="titleInput">पत्रको अनुक्रमणिका नेपालीमा</div>
                        <div class="newInput"><input type="text" name="letter_index_nepali" value="<?php echo $data->letter_index_nepali; ?>"
                                                     required></div>

                        <div class="titleInput">पत्रको अनुक्रमणिकाको टेबल</div>
                        <div class="newInput"><input type="text" name="letter_table" value="<?php echo $data->letter_table; ?>"
                                                     required></div>

                        <div class="titleInput">पत्रको अनुक्रमणिकाको टेबलको मान</div>
                        <div class="newInput"><input type="text" name="table_property" value="<?php echo $data->table_property; ?>"
                                                     required></div>

                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस"
                                                               class="btn"> <input type="hidden" name="update_id"
                                                                                   value="<?= $data->id ?>"/></div>
                        <div class="myspacer"></div>

                    </div><!-- input wrap ends -->

                </form>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td class="myCenter"><strong>सि.नं.</strong></td>
                        <td class="myCenter"><strong>पत्रको अनुक्रमणिका अंग्रेजीमा</strong></td>
                        <td class="myCenter"><strong>पत्रको अनुक्रमणिका नेपालीमा</strong></td>
                        <td class="myCenter"><strong>पत्रको अनुक्रमणिकाको टेबल</strong></td>
                        <td class="myCenter"><strong>पत्रको अनुक्रमणिकाको टेबलको मान</strong></td>
                        <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                    </tr>
                    <?php $i = 1;
                    foreach ($budget_result as $result): ?>
                        <tr>
                            <td class="myCenter"><?php echo convertedcit($i); ?></td>
                            <td class="myCenter"><?php echo convertedcit($result->letter_index); ?></td>
                            <td class="myCenter"><?php echo convertedcit($result->letter_index_nepali); ?></td>
                            <td class="myCenter"><?php echo convertedcit($result->letter_table); ?></td>
                            <td class="myCenter"><?php echo convertedcit($result->table_property); ?></td>
                            <form method="post" action="indices_delete.php">
                            <td class="myCenter">
                                <a href="letter_indices.php?id=<?php echo $result->id; ?>" class="btn">सच्याउनुहोस</a>
                                <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                <input type="hidden" name="id" value="<?=$result->id?>">
                            </td>
                            </form>
                        </tr>
                        <?php $i++;
                    endforeach; ?>
                </table>

            </div>
        </div>
    </div><!-- main menu ends -->

</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
