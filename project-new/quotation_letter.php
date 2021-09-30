<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
$date = date('Y-m-d', time());
$ward_address = WardWiseAddress();
$address = getAddress();
if (isset($_POST['submit'])) {

//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';exit;
    $letter = new LetterFormat();

    if ((!empty($_POST['update_id'])) && (!empty($_POST['letter_type_copy']))) {
        //  echo 'edit wala value';exit;
        $letter = LetterFormat::find_by_id($_POST['update_id']);
        $letter->letter_type = $_POST['letter_type_copy'];
    } else {
        $letter->letter_type = $_POST['letter_type'];
    }
    //echo 'save wala value';exit;
    $letter->date = date('Y-m-d', time());

    $letter->plan_type = $_POST['plan_type'];
    $letter->letter_text = $_POST['letter_text'];
    $letter->save();
}
//$plan_id = 1;
//$data1=  Plandetails1::find_by_id($plan_id);
//$fiscal = FiscalYear::find_by_id($data->fiscal_id);

//$ward_address=WardWiseAddress();
//$address= getAddress();
//$workers = Workerdetails::find_all();
//$url = get_base_url(1);
//$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
//$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();
//
//if(!empty($print_history))
//{
//    $worker1 = Workerdetails::find_by_id($print_history->worker1);
//    $worker2 = Workerdetails::find_by_id($print_history->worker2);
//    $worker3 = Workerdetails::find_by_id($print_history->worker3);
//    $worker4 = Workerdetails::find_by_id($print_history->worker4);
//}
//else
//{
//    $print_history = PrintHistory::setEmptyObject();
//    if(empty($worker1))
//    {
//        $worker1 = Workerdetails::setEmptyObject();
//    }
//    if(empty($worker2))
//    {
//        $worker2 = Workerdetails::setEmptyObject();
//    }
//    if(empty($worker3))
//    {
//        $worker3 = Workerdetails::setEmptyObject();
//    }
//    if(empty($worker4))
//    {
//        $worker4 = Workerdetails::setEmptyObject();
//    }
//}
//?>
<?php //$data1=  Plandetails1::find_by_id($_GET['id']);
//$result = Plantotalinvestment::find_by_plan_id($_GET['id']);
//if(!empty($result))
//{
//    $data2=  Plantotalinvestment::find_by_plan_id($_GET['id']);
//    $data3= Moreplandetails::find_by_plan_id($_GET['id']);
//    $name = "उपभोक्ताबाट";
//
//}
//else
//{
//    $data2= AmanatLagat::find_by_plan_id($_GET['id']);
//    $data3= Amanat_more_details::find_by_plan_id($_GET['id']);
//    $name = "";
//
//}
//$percent = ($data2->costumer_investment/$data2->total_investment ) * 100;
//$percent_final = round( $percent, 2, PHP_ROUND_HALF_UP);
//// echo $percent_final;exit;
//$link = get_return_url($_GET['id']);
//?>
<?php
//$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
//$fiscal = FiscalYear::find_by_id($data1->fiscal_id);
//$cont = get_contingency_for_plan($_GET['id']);
////echo $data2->agreement_gaupalika;exit;
//$final_cont = $data2->agreement_gauplaika * $cont;
//?>

<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>पत्र</title>

</head>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">


    <div class="maincontent">
        <h2 class="headinguserprofile"><a href="<?= $link ?>" class="btn">पछि जानुहोस </a></h2>

        <div class="OurContentFull">
            <a class="btn btn-primary" style="text-align: right;!important;" href="quotation_letter_view.php">पत्र
                हेर्नुहोस्</a>
            <form method="post">
                <div class="centered">
                    योजनाको किसिम :
                    <select name="plan_type" required id="plan_type">
                        <option value=""></option>
                        <option value="6">योजना कोटेसन् मार्फत</option>
                    </select>
                    &nbsp;&nbsp;पत्रको नाम:
                    <input type="text" name="letter_type" id="letter_type_text" required>

                    पत्रको किसिम :
                    <select id="letter_type" name="letter_type_copy">
                        <option value=""></option>

                    </select>
                    </br></br>

                    <div class="row" style="margin-left: 10px;">

                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="row row-editor" style="margin-left: 10px; border: 1px solid fff;">
                        <div class="editor" id="" style="height: 400px; width: 950px !important;">


                        </div>
                    </div>
                </div>
                <input type="hidden" id="letter_text" name="letter_text"/>


                <br>
                <input type="hidden" name="update_id" id="update_id" value="">
                <input type="submit" id="submit" class="btn btn-primary pull-right" name="submit"
                       value="सेभ गर्नुहोस्" onclick="return confirm('के तपाई निश्चित हुनुन्छ ?');"
                       style="margin-left: 10px;">
            </form>
        </div>

        <div class="userprofiletable" id="div_print">
            <div class="printPage">
            </div>
            <div class="myspacer"></div>
        </div>
        <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
    </div>
</div>
</div>
</div><!-- main menu ends -->

</div><!-- top wrap ends -->

<?php include("menuincludes/footer.php"); ?>


<script>

    var myEditor;

    var param = {};
    var items = [];
    JQ.post('get_all_indices.php', param, function (res) {
        var obj = JSON.parse(res);
        //console.log(res);
//        alert(obj.html);exit;
        var data = obj.data;
        items = data;
       


        // alert(obj.enlist_id);
    });
    // const items = [
    //     { id: '[[yojana]]', userId: '1', name: 'मन्दिर निर्माण', link: 'https://www.imdb.com/title/tt0460649/characters/nm0000439' },
    //     { id: '[[mulyankanRakam]]', userId: '2', name: '2001', link: 'https://www.imdb.com/title/tt0460649/characters/nm0004989' },
    //     { id: '[[marshmallow]]', userId: '3', name: 'Marshall Eriksen', link: 'https://www.imdb.com/title/tt0460649/characters/nm0781981' },
    //     { id: '[[rsparkles]]', userId: '4', name: 'Robin Scherbatsky', link: 'https://www.imdb.com/title/tt0460649/characters/nm1130627' },
    //     { id: '[[tdog]]', userId: '5', name: 'Ted Mosby', link: 'https://www.imdb.com/title/tt0460649/characters/nm1102140' }
    // ];

    JQ(document).on("click", "#submit", function () {
        var data = myEditor.getData();
       // console.log(data);
        JQ('#letter_text').val(data);


    });

    function getFeedItems(queryText) {
       // console.log(queryText);
        // As an example of an asynchronous action, return a promise
        // that resolves after a 100ms timeout.
        // This can be a server request or any sort of delayed action.
        return new Promise(resolve => {
            setTimeout(() => {
                const itemsToDisplay = items
                    // Filter out the full list of all items to only those matching the query text.
                    .filter(isItemMatching)
                    // Return 10 items max - needed for generic queries when the list may contain hundreds of elements.
                    .slice(0, 10);

                resolve(itemsToDisplay);
            }, 50);
        });

        // Filtering function - it uses `name` and `username` properties of an item to find a match.
        function isItemMatching(item) {
            // Make the search case-insensitive.
            const searchString = queryText.toLowerCase();


            // Include an item in the search results if name or username includes the current user input.
            return (
                item.name.toLowerCase().includes(searchString) ||
                item.id.toLowerCase().includes(searchString)
            );
        }
    }

    function customItemRenderer(item) {
        const itemElement = document.createElement('span');

        itemElement.classList.add('custom-item');
        itemElement.id = `mention-list-item-id-${item.userId}`;
        itemElement.textContent = `${item.id} `;

        const usernameElement = document.createElement('span');

        usernameElement.classList.add('custom-item-username');
        usernameElement.textContent = item.name;

        itemElement.appendChild(usernameElement);

        return itemElement;
    }

    DecoupledDocumentEditor
        .create(document.querySelector('.editor'), {

            toolbar: {
                items: [
                    'heading',
                    '|',
                    'fontSize',
                    'fontFamily',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'highlight',
                    '|',
                    'alignment',
                    '|',
                    'numberedList',
                    'bulletedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'todoList',
                    'link',
                    'blockQuote',
                    'imageUpload',
                    'insertTable',
                    'mediaEmbed',
                    '|',
                    'undo',
                    'redo'
                ]
            },
            language: 'en',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
            mention: {
                feeds: [
                    {
                        marker: '[',
                        feed: getFeedItems,
                        itemRenderer: customItemRenderer
                    }
                ]
            },

        })
        .then(editor => {

            // if (typeof editor.config.contentsCss == 'string') {
            //     editor.config.contentsCss=[editor.config.contentsCss,"/css/style.css"];
            // } else {
            //     if (!contains(editor.config.contentsCss,"/css/style.css")) {
            //         editor.config.contentsCss.push("/css/style.css");
            //     }
            // }

            myEditor = editor;
            window.editor = myEditor;


            //  Set a custom container for the toolbar.
            document.querySelector('.document-editor__toolbar').appendChild(editor.ui.view.toolbar.element);
            // document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: 8b7q7fdksnho-ucn1dsls94e0');
            console.error(error);
        });

    JQ(document).on("change", "#plan_type", function () {
        var param = {};
        var plan_type = JQ(this).val() || 0;
        param.plan_type = plan_type;
        JQ.post('get_letter_type.php', param, function (res) {
            var obj = JSON.parse(res);
//        alert(obj.html);exit;
            JQ('#letter_type').html(obj.html);
        });
    });
    JQ(document).on("change", "#letter_type", function () {
        var param = {};
        var plan_type = JQ('#plan_type').val() || 0;
        var letter_type = JQ('#letter_type').val() || 0
        // alert(letter_type);
        param.plan_type = plan_type;
        param.letter_type = letter_type;
        JQ.post('get_letter_format.php', param, function (res) {
            var obj = JSON.parse(res);
           // console.log(obj);
        //     // alert(obj.html);return false;
        //     // debugger;
             myEditor.setData(obj.html);
        //     // JQ('#view_editor').html(obj.html);
            JQ('#update_id').val(obj.update_id);
            JQ('#letter_type_text').prop('required', false);
         });
    });


</script>


</body>
