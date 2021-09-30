<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$topic_area = Topicarea::find_all();
//print_r($topic_area);
	?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बिषयगत क्षेत्र  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	        <div class="maincontent">
                    <h2 class="headinguserprofile">बिषयगत क्षेत्र | <a href="topic_area.php" class="btn">बिषयगत क्षेत्र थप्नुहोस [+]</a> | <a href="settings.php" class="btn">पछि जानुहोस </a> </h2>
                   
                    <div class="OurContentFull">
                    	<h2>बिषयगत क्षेत्र: </h2>
                        <div class="userprofiletable">
                        	
							<div class="myMessage"><?php echo $message;?></div>
                            
                                    	<table class="table table-bordered table-hover">
                                          <tr>
                                          	
                                            <td class="myCenter"><strong>सि. नं.</strong></td>
                                            <td class="myCenter"><strong>बिषयगत क्षेत्रको नाम</strong></td>
                                            <td class="myCenter"><strong> बजेट रकम </strong></td>
                                            <td class="myCenter"><strong>सच्च्याउनुहोस्</strong></td>

                                          </tr>
                                          <?php $j=1; foreach($topic_area as $data): 
                                              $shrot_result = TopicAreaBudgetShrot::find_by_topic_area_id($data->id);?>
                                                    <tr>
                                                        <td class="myCenter"> <?php echo convertedcit($j); ?></td>
                                                        <td class="myCenter">
                                                            <strong>   <?php echo $data->name;?></strong> <br>
                                                            <span style="float: right;">
                                                                <?php $i=1; foreach($shrot_result as $datas):?>
                                                                <span> <?=convertedcit($i)?>. <?=  ShrotDetails::getName($datas->shrot_id)?></span><br>
                                                                <?php  $i++; endforeach;?>
                                                            </span>
                                                        </td>
                                                          <td class="myCenter">
                                                              <?php echo convertedcit($data->budget+0);?><br>
                                                               <span style="float: right;">
                                                                    <?php foreach($shrot_result as $dataa):?>
                                                                   <span> <?=convertedcit($dataa->budget + 0 )?></span><br>
                                                                    <?php endforeach;?>
                                                               </span>
                                                          </td>
<!--                                                        <form method="post">-->
                                                        <form method="post" action="topic_delete.php">
                                                        <td class="myCenter">
                                                            <a href="topic_area_edit.php?id=<?php echo $data->id; ?>" class="btn">सच्च्याउनु होस्</a>
                                                            <span>
                                                                <button class="button btn-danger">हटाउनुहोस</button>
                                                                <input type="hidden" name="id" value="<?=$data->id?>">
                                                            </span>
                                                        </td>
                                                        </form>
                                                    </tr>
                                          <?php $j++; endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>