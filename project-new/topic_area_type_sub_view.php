<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$main_topics = Topicarea::find_all();
	$datas= Topicareatype::find_all();
	?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको उपशिर्षकगत किसिम :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको उपशिर्षकगत किसिम | <a href="topic_area_type_sub.php" class="btn">योजनाको उपशिर्षकगत किसिम थप्नुहोस[+]</a> | <a href="settings.php" class="btn">पछि जानुहोस</a></h2>
                    <div class="OurContentFull">
                    	<h2>योजनाको उपशिर्षकगत किसिम</h2>
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered ">
                                          <?php foreach($main_topics as $main):
                                                $datas = Topicareatype::find_by_topic_area_id($main->id);
                                           ?>
                                            <tr>
                                                <td colspan="4" class="myCenter"><strong><?=$main->name?></strong></td>
                                            </tr>
                                            <tr class="trMainheading">
                                            <th class="myCenter">सि. नं.</th>
                                            <th class="myCenter">योजनाको शिर्षकगत किसिम</th>
                                            <th class="myCenter">सच्याउनुहोस् </th>
                                          </tr>
                                                    <?php $i = 1; foreach($datas as $data): 
                                                        $sub_topics = Topicareatypesub::find_by_topic_area_type_id($data->id);
//                                                    print_r($sub_topics);
                                                    ?>
                                          <?php if(!empty($sub_topics)){?>
                                                    <tr class="subtype">
                                                        <th class="myCenter"><?php echo convertedcit($i);?> </th> <th class="myCenter"><?php echo $data->topic_area_type; ?></th><th>&nbsp;</th>
                                                    </tr>
                                          <?php }else{}?>
                                                            <?php $j=1; foreach ($sub_topics as $sub): ?>
                                          <form method="post" action="topic_area_type_sub_delete.php">
                                                                <tr>
                                                                    <td class="myCenter"><?=convertedcit($j)?></td>
                                                                    <td class="myCenter"><?=$sub->topic_area_type_sub?></td>
                                                                    <td class="myCenter">
                                                                        <a href="topic_area_type_sub_edit.php?id=<?=$sub->id?>" class="btn">सच्याउनुहोस्</a>
                                                                        <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                                        <input type="hidden" name="id" value="<?=$sub->id?>">
                                                                    </td>
                                                                </tr>
                                          </form>
                                                            <?php $j++; endforeach; ?>
                                                    <?php $i++; endforeach; ?>
                                          <?php endforeach; ?>
                                        </table>
                        </div>
                  </div>
                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>