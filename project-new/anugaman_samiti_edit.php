<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	$topic_area = Topicarea::find_all();
	?>
<?php include("menuincludes/header.php"); 
$datas = AnugamanSamitiBibaran::find_all();
//print_r($datas);
?>
<!-- js ends -->
<title>अनुगमन समिति विवरण  :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	        <div class="maincontent">
                    <h2 class="headinguserprofile">अनुगमन समिति विवरण  |</a> <a href="settings.php" class="btn">पछि जानुहोस </a> </h2>
                    <div class="OurContentFull">
                    	<h2>अनुगमन समिति विवरण : </h2>
                        <div class="userprofiletable">
							<div class="myMessage"><?php echo $message;?></div>
                                <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="thWidth15 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth20 myCenter"><strong>नामथर</strong></td>
                                    <!--<td class="thWidth15 myCenter"><strong>वडा नं </strong></td>-->
                                    <td class="thWidth20 myCenter"><strong>पदनाम</strong></td>
                                    <td class="thWidth20 myCenter"><strong>लिगं</strong></td>
                                    <!--<td class="thWidth20 myCenter"><strong>मोबाइल नं</strong></td>-->
                                    <td class="myCenter"><strong>सच्च्याउनुहोस्</strong></td>
                                </tr>
                                <?php foreach($datas as $data1):?>
                                <tr>
                                  <?php $posts = Postname::find_by_id($data1->post_id);
                                  ?>
                                   <td><?php echo $posts->name;?></td>
                                   <td><?php echo $data1->name;?></td>
                                   <!--<td><?php echo $data1->address;?></td>-->
                                   <td><?php echo $data1->post_name;?></td>
                                   <td><?php
                                        if($data1->gender == 1){
                                            echo 'पुरुष';
                                        } elseif($data1->gender == 2 ){
                                            echo 'महिला';
                                        } else {
                                            echo 'अन्य';
                                        }
                                  ?></td>
                                   <!--<td><?php echo $data1->mobile_no;?></td>-->
                                   <td class="myCenter"><a href="anugaman_samiti_bibaran.php?id=<?php echo $data1->id; ?>" class="btn">सच्च्याउनु होस्</a></td>
                                </tr>
                                <?php endforeach;?>
                         </table>
                        </div>
                  </div>
                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>