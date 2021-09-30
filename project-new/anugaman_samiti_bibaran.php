<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//$plan_selected = Plandetails1::find_by_id($_GET['id']);
if(isset($_POST['submit']))
{
    //अनुगमन समिति सम्बन्धी विवरण

    for($i=0;$i<count($_POST['post_id_1']);$i++)
    {
       $data2 =new AnugamanSamitiBibaran();
       $data2->post_id =$_POST['post_id_1'][$i];
       $data2->name = $_POST['name_1'][$i];
       $data2->address = $_POST['address_1'][$i];
       $data2->gender = $_POST['gender_1'][$i];
       $data2->mobile_no = $_POST['mobile_no_1'][$i];
       $data2->post_name = $_POST['post_name'][$i];
       //$data2->created_date=date("Y-m-d",time());
       $data2->save();
    }
    echo alertBox("थप सफल ","anugaman_samiti_bibaran.php");
}
$post="select * from postname where type=1";
$postnames=  Postname::find_by_sql($post);
$datas_1 = AnugamanSamitiBibaran::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बिषयगत क्षेत्र  :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent">
         <h2 class="headinguserprofile">अनुगमन समिति सम्बन्धी विवरण  | <a href="anugaman_samiti_bibaran_view.php" class="btn">पछि जानुहोस </a></h2>
            <?php echo $message;?>
            <div class="OurContentFull">
                <div class="userprofiletable">
                    <h3 class="myheader"> योजनाको विवरण</h3>
                      <h3>अनुगमन समिति सम्बन्धी विवरण </h3>
                       <form method="post" enctype="multipart/form_data">
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                               <table class="detail_posts table table-bordered table-hover">
                                <tr>
                                    <td class="thWidth10 myCenter"><strong>सि.नं.</strong></td>
                                    <td class="thWidth10 myCenter"><strong>पद</strong></td>
                                    <td class="thWidth20 myCenter"><strong>नामथर</strong></td>
                                    <td class="thWidth20 myCenter"><strong>पदनाम</strong></td>
                                    <td class="thWidth10 myCenter"><strong>लिगं</strong></td>
                                </tr>
                                <?php if(empty($datas)){ $update=0;  $value="सेभ गर्नुहोस"; ?>
                                <tr>
                                    <td>1</td>
                                     <td>
                                         <select name="post_id_1[]"  class="post" required>
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>"><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input type="text" name="name_1[]" required class="input100percent"/></td>
                                    <td><input type="text" name="post_name[]" required class="input100percent"/></td>
                                     <td>
                                         <select  class="gender1" name="gender_1[]">
                                             <option value="1">पुरुष</option>
                                             <option value="2">महिला</option>
                                             <option value="3">अन्य</option>
                                        </select>
                                     </td>
                                 </tr>
                            <?php } else{  $update=1; $value="अपडेट गर्नुहोस"; $i=1; foreach($datas as $data): ?>
                                <tr <?php  if($i!=1){?> class="remove_post_detail_more" <?php } ?>>
                                    <td><?=$i?></td>
                                     <td>
                                         <select class="post" name="post_id_1[]">
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                             <option value="<?=$name->id?>" <?php if($data->post_id==$name->id){?> selected="selected" <?php }?>><?=$name->name?></option>
                                             <?php endforeach;?>
                                            </select>
                                     </td>
                                    <td><input class="input100percent" type="text" name="name_1[]" value="<?=$data->name?>" /></td>
                                    <td><input class="input100percent" type="text" name="post_name[]" value=""></td>
                                     <td>
                                         <select  class="input100percent" name="gender_1[]" class="gender1">
                                             <option value="1"  <?php if($data->gender==1){?> selected="selected" <?php } ?> >पुरुष</option>
                                             <option value="2"  <?php if($data->gender==2){?> selected="selected" <?php } ?> >महिला</option>
                                             <option value="3"  <?php if($data->gender==3){?> selected="selected" <?php } ?> >अन्य</option>
                                        </select>
                                     </td>
                                 </tr>
                            <?php $i++; endforeach; } ?>
                                <tbody id="detail_add_more_table" class="table table-bordered table-hover"></tbody>
                            </table>
                            <div class="inputWrap100">
                                <div class="inputWrap33 inputWrapLeft"><div class="add btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="<?=$value?>" class="submit btn myWidth100"></div><input type="hidden" name="update" value="<?=$update?>">
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                       </form>
                    </div>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>सी.नं</td>
                        <td class="thWidth15 myCenter"><strong>पद</strong></td>
                        <td class="thWidth20 myCenter"><strong>नामथर</strong></td>
                        <td class="thWidth20 myCenter"><strong>पदनाम</strong></td>
                        <td class="thWidth20 myCenter"><strong>लिगं</strong></td>
                        <td class="myCenter"><strong>सच्च्याउनुहोस्</strong></td>
                    </tr>
                    <?php $i=1;foreach($datas_1 as $data1):?>
                        <tr>
                            <?php $posts = Postname::find_by_id($data1->post_id);
                            ?>
                            <td><?php echo convertedcit($i)?></td>
                            <td><?php echo $posts->name;?></td>
                            <td><?php echo $data1->name;?></td>
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
                            <form method="post" action="anugaman_delete.php">
                            <td class="myCenter">
                                <input type="hidden" value="<?=$data1->id?>" name="id">
                                <span><button class="button btn-danger" value="">हटाउनुहोस</button></span>
                            </td>
                            </form>
                        </tr>
                    <?php $i++;endforeach;?>
                </table>
                  </div>

                </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>