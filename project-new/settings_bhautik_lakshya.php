<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>
<?php
if(isset($_POST['submit']))
{
    if($_POST['update_id'] == '0')
    {
        $form_data = SettingbhautikPariman::find_by_id($_POST['update_id']);
    } elseif (!empty($_POST['update_id'])) {
        $form_data = SettingbhautikPariman::find_by_id($_POST['update_id']);
    }
    else
    {
        $form_data = new SettingbhautikPariman();
    }

    //$data->sn= $_POST['sn'];
    $form_data->name= $_POST['name'];
    if(!empty($_POST['parent_id'])) {
        $form_data->parent_id= $_POST['parent_id'];
    } else if($_POST['parent_id'] == 0) {
        $form_data->parent_id= $_POST['parent_id'];
    }
//    $form_data->amount = $_POST['percent']/100;
    if($form_data->save())
    {
        echo alertBox("डाटा सेव भयो ||", "settings_bhautik_lakshya.php");
    }
}

if(isset($_GET['id']))
{
    $data= SettingbhautikPariman::find_by_id($_GET['id']);

}
else
{
    $data = SettingbhautikPariman::setEmptyObjects();
}
$budget_result= SettingbhautikPariman::find_all_parents();
?>
    <!-- js ends -->
    <title>भौतिक लक्ष्यको शिर्षक हाल्नुहोस : <?php echo SITE_SUBHEADING;?></title>

    </head>

    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent">
            <h2 class="headinguserprofile">भौतिक लक्ष्यको शिर्षक| <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <h2>भौतिक लक्ष्यको शिर्षक</h2>
                <div class="userprofiletable">
                    <form method="post" enctype="multipart/form-data">
                        <input hidden="update_id" value="<?=$_GET['id']?>"/>
                        <div class="inputWrap">
                            <div class="titleInput">भौतिक लक्ष्यको शिर्षक:</div>
                            <div class="newInput"><input type="text"  name="name" value="<?php echo $data->name;?>" required></div>
                            <div class="titleInput">मुख्य शिर्षक छानुहोस:</div>
                            <select name="parent_id" class="form-control" >
                                <option value="-1">छानुहोस</option>
                                <?php
                                foreach($budget_result as $result):?>
                                    <option <?php if($data->parent_id == $result->id){echo 'selected';}  ?> value="<?php echo $result->id?>"><?php echo $result->name?></option>
                                <?php endforeach;?>
                            </select>
                            <br>
                            <div class="saveBtn myWidth100"><input type="submit"   name="submit" value="सेभ गर्नुहोस" class="btn">                                    <input  type="hidden" name="update_id" value="<?=$data->id?>" /></div>
                            <div class="myspacer"></div>

                        </div><!-- input wrap ends -->

                    </form>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td class="myCenter"><strong>सि.नं.</strong></td>
                            <td class="myCenter"><strong>भौतिक लक्ष्यको शिर्षक </strong></td>
                            <td class="myCenter"><strong>उपशिर्षक</strong></td>
                            <td class="myCenter"><strong>सच्याउनुहोस</strong></td>
                        </tr>
                        <?php $i=1;foreach($budget_result as $result):?>
                            <tr>
                                <td class="myCenter"><?php echo convertedcit($i);?></td>
                                <td class="myCenter"><?php echo convertedcit($result->name);?></td>
                                <td class="myCenter">
                                    <button
                                            data-toggle="modal"
                                            data-target="#newModal"
                                            class="btn subdata"
                                            data-id="<?php echo $result->id; ?>"
                                    >उपशिर्षक हेर्नुहोस</butt></td>
                                <form method="post" action="bhautik_delete.php">
                                <td class="myCenter">
                                    <a href="settings_bhautik_lakshya.php?id=<?php echo $result->id;?>" class="btn">सच्याउनुहोस</a>
                                    <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                    <input type="hidden" name="id" value="<?=$result->id?>">
                                </td>
                                </form>
                            </tr>
                            <?php $i++;
                        endforeach;?>
                    </table>

                </div>
            </div>

            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal_subdata">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- main menu ends -->

    </div><!-- top wrap ends -->
    <script>
        JQ(document).ready(function() {
            JQ(document).on("click", ".subdata", function() {
                var id = JQ(this).attr("data-id");
                var param = {};
                param.id = id;
                param.subdata = true;
                var target = JQ('#modal_subdata');
                JQ.post('get_bhautik_pariman_sub_details.php', param, function(res) {
                    var obj = JSON.parse(res);
                    target.html(obj.html)
                });
            });
        });
    </script>
<?php include("menuincludes/footer.php"); ?>