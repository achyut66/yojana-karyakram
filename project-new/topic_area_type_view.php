<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$datas= Topicareatype::find_all();
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजनाको शिर्षकगत किसिम :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">योजनाको शिर्षकगत किसिम  | <a href="topic_area_type.php" class="btn">योजनाको शिर्षकगत किसिम थप्नुहोस +</a> | <a href="settings.php" class="btn">पछि जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                    	<h2>योजनाको शिर्षकगत किसिम</h2>
                        <div class="userprofiletable">
                        	<div class="myspacer"></div>
							<div class="myMessage"><?php echo $message;?></div>
                                    	<table class="table table-bordered table-hover">
                                          <tr>
                                          	
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>बिषयगत क्षेत्रको नाम</strong></td>
                                            <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                             <td class="myCenter"><strong> बजेट रकम </strong></td>
                                            <td class="myCenter"><strong>सच्च्याउनुहोस्</strong></td>

                                          </tr>
                                          <?php $i=1;foreach($datas as $data):
//                                              print_r($data);
                                               $shrot_result = TopicAreaTypeBudgetShrot::find_by_topic_area_type_id($data->id);?>
                                              
                                                    <tr>
                                                        <td class="myCenter"><?php echo convertedcit($i); ?></td>
                                                        <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id);?></td>
                                                        <td class="myCenter">
                                                            <strong><?php echo $data->topic_area_type;?></strong><br>
                                                          <span style="float: right;">
                                                                <?php $j=1; foreach($shrot_result as $datas):?>
                                                                <span> <?=convertedcit($j)?>. <?=  ShrotDetails::getName($datas->shrot_id)?></span><br>
                                                                <?php  $j++; endforeach;?>
                                                            </span>
                                                        </td>
                                                           <td class="myCenter">
                                                               <strong> <?php echo convertedcit($data->budget+0);?></strong><br>
                                                           <span style="float: right;">
                                                                    <?php foreach($shrot_result as $dataa):?>
                                                                   <span> <?=convertedcit($data->budget + 0 )?></span><br>
                                                                    <?php endforeach;?>
                                                               </span>
                                                           </td>
                                                        <form method="post" action="topic_area_type_delete.php">
                                                        <td class="myCenter">
                                                            <a href="topic_area_type_edit.php?id=<?php echo $data->id; ?>" class="btn">सच्च्याउनु होस्</a>
                                                            <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                            <input type="hidden" name="id" value="<?=$data->id?>">
                                                        </td>
                                                        </form>
                                                    </tr>
                                                
                                          <?php $i++;endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>