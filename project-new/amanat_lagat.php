<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
//echo Contingency:: find_by_type(1);
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;

if(isset($_POST['search'])){
 if(empty($_POST['sn'])) {  
    $sql="select * from plan_details1 where program_name LIKE '%".$_POST['program']."%'";
 }
 else
 {
     $sql="select * from plan_details1 where id='".$_POST['sn']."'";
    
 }
 $results= Plandetails1::find_by_sql($sql);

//print_r($result);exit;
}
$data1=Plandetails1::find_by_id($_GET['id']);
$postnames=  Postname::find_all();
$units = Units::find_all();
$settingbhautikPariman = SettingbhautikPariman::find_all();
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'], 1);
$SettingbhautikParimanParent = SettingbhautikPariman::find_all_parents();
?>

<?php include("menuincludes/header.php"); ?>
<title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING;?></title>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
	    <div class="maincontent">
                <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | <a href="amanat_lagat_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
            <div class="myMessage"><?php echo $message;?></div>
                 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <div class="userprofiletable">
                 
                    <?php $data = Plandetails1::find_by_id($_GET['id']);?>
                    <?php $invest_details =  AmanatLagat::find_by_plan_id($_GET['id']); 
                         if(empty($invest_details))
                          {
                            $invest_details = AmanatLagat::setEmptyObjects(); 
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस"; 
                           $bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);
                    ?>
                     <div>
                            <h3><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" action="save_amanat_lagat.php">
                            
                                
                        
                        <table class="table table-bordered">
                        <div class="inputWrap100">
                        	<h1> योजनाको कुल लागत अनुमान </h1>
                            <div class="inputWrap33 inputWrapLeft">
                            	<!--<div class="titleInput">भौतिक परिणाम:</div>-->
                                <!--<div class="newInput"><input type="text" required name="unit_total" value="<?=$invest_details->unit_total?>" /></div>-->
                                <!--<div class="titleInput">भौतिक ईकाई:</div>-->
                                <!--<div class="newInput"><select name="unit_id">-->
                                <!--    <option value="">--छान्नुहोस् --</option>-->
                                <!--    <?php foreach($units as $unit): ?>-->
                                <!--      <option value="<?=$unit->id?>" <?php if($invest_details->unit_id==$unit->id){ ?> selected="selected" <?php } ?> ><?=$unit->name?></option>-->
                                <!--    <?php endforeach; ?>-->
                                <!--</select></div>-->
                               <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान :<br>
                               <input type="checkbox"  name="anudan_con" id="anudan_con" value="1" <?php if($invest_details->anudan_con==1){ echo 'checked="checked"';}?>/>  
                               <span style="color: red">कन्टेन्जेन्सी काट्ने भएमा टिक लगाउनुहोस </span></div>
   
                                <div class="newInput">
                               <input type="text" readonly="true" name="agreement_gauplaika" id="agreement_gauplaika" value="<?=$data->investment_amount?>" /></div>
                                <div class="titleInput">अन्य निकायबाट प्राप्त अनुदान :<br>
                                    <input type="checkbox"  name="aanya_nikaya_con" id="aanya_nikaya_con" value="1" <?php if($invest_details->aanya_nikaya_con==1){ echo 'checked="checked"';}?>/>  <span style="color: red">कन्टेन्जेन्सी काट्ने भएमा टिक लगाउनुहोस </span></div>
                                    <div class="newInput"><input type="text" required name="agreement_other" id="agreement_other" value="<?=$invest_details->agreement_other?>"/></div>

                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                                       
                                     <div class="titleInput">अन्य साझेदारी :<br>
                                     <input type="checkbox"  name="aanya_sajhedari_con" id="aanya_sajhedari_con" value="1" <?php if($invest_details->aanya_sajhedari_con==1){ echo 'checked="checked"';}?>/> <span style="color: red">कन्टेन्जेन्सी काट्ने भएमा टिक लगाउनुहोस </span> </div>
                                     <div class="newInput"><input type="text" required name="other_agreement" id="other_agreement" value="<?=$invest_details->other_agreement?>"/></div>
                                    
                                    <div class="titleInput">उपभोक्ताबाट नगद साझेदारी :<br>
                                    <input type="checkbox"  name="nagad_sajhedari_con" id="nagad_sajhedari_con" value="1" <?php if($invest_details->nagad_sajhedari_con==1){ echo 'checked="checked"';}?>/> <span style="color: red">कन्टेन्जेन्सी काट्ने भएमा टिक लगाउनुहोस </span></div>

                                    <div class="newInput"><input type="text" required name="costumer_agreement" id="costumer_agreement" value="<?=$invest_details->costumer_agreement?>"/></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">कार्यदेश दिएको रकम :</div>
                                <div class="newInput"><input type="text" readonly="true" name="bhuktani_anudan" id="bhuktani_anudan" value="<?=$invest_details->bhuktani_anudan?>"/></div>
                                <div class="titleInput"> जनश्रमदान :</div>
                                <div class="newInput"><input type="text" required name="costumer_investment" id="costumer_investment" value="<?=$invest_details->costumer_investment ?>"/></div>
                                <div class="titleInput">कुल लागत अनुमान जम्मा :</div>
                                <div class="newInput"><input type="text" name="total_investment" readonly="true" id="total_investment" value="<?=$invest_details->total_investment?>"/></div>
                                <div class="saveBtn myCenter myWidth100"><input type="hidden" name="create_id" value="<?=$invest_details->id?>" class="btn"/>
                            </div> 
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>सि. नं </th>
                                    <th>परिमाणको मुख्य शिर्षक
                                    </th>
                                    <th>परिमाणको शिर्षक </th>
                                    <th>परिमाण</th>
                                    <th>भौतिक इकाई </th>
                                    <th style="5%;">#</th>
                                </tr>
                                <?php if (empty($bhautik_details)) {?>
                                <?php } else {
                                    $i=1;
                                    foreach ($bhautik_details as $result):
                                        ?>
                                        <tr class="remove_plan_form_details">
                                            <td class="sn" name="sn" id="sn_<?=$i?>" value="<?=$i?>"><?=$i?>
                                            </td>
                                            <td>
                                                <select class="parent_details_id" name="parent_details_id[]" style="min-width: 100%;">
                                                    <option value="">--------</option>
                                                    <?php foreach ($SettingbhautikParimanParent as $data):?>
                                                        <option value="<?=$data->id?>" <?php if ($data->id==$result->parent_id) {
                                                            echo 'selected="selected"';
                                                        } ?>><?=$data->name?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="details_id" required name="details_id[]" style="min-width: 100%;">
                                                    <option value="">--------</option>
                                                    <?php foreach ($SettingbhautikPariman as $data):
                                                        if ($data->id==$result->details_id) {
                                                            ?>
                                                            <option
                                                                    value="<?=$data->id?>"
                                                                <?php
                                                                if ($data->id==$result->details_id) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?>
                                                            ><?=$data->name?>
                                                            </option>
                                                        <?php } endforeach; ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="qty[]"
                                                       value="<?=$result->qty?>" /></td>
                                            <td>
                                                <select name="unit_id[]">
                                                    <option value="">--छान्नुहोस् --</option>
                                                    <?php foreach ($units as $unit): ?>
                                                        <option value="<?=$unit->id?>" <?php if ($unit->id==$result->unit_id) {
                                                            echo 'selected="selected"';
                                                        } ?>><?=$unit->name?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="width:5%;">
                                                <button class="remove_btn" id="remove_btn_<?=$i?>">
                                                    <img src="images/cross.png" style="height: 20px; width: 20px;">
                                                </button>
                                            </td>
                                        </tr>

                                        </tr>
                                        <?php $i++;
                                    endforeach;
                                }?>
                                <tbody id="join_table_plan_form_1">
                                </tbody>
                            </table>
                        <input type="hidden" name="plan_id" id="plan_id" value="<?=$_GET['id']?>" class="btn"/>
                        <input type="hidden" name="create_id" id="plan_id" value="<?=$invest_details->id?>" class="btn"/>
                       <div class="inputWrap33 inputWrapLeft"><div class="add_plan_form1 btn myWidth100">थप्नुहोस [+]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><div class="remove_plan_form1 btn myWidth100">हटाउनुहोस [-]</div></div>
                                <div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit" value="<?=$value?>" class="submit btn myWidth100"></div> </div>
                            </div><!-- input wrap 33 ends -->
                            <div class="myspacer"></div>
                        </div><!-- input wrap 100 ends -->

 </form>


                </div>
                  </div>
                </div><!-- main menu ends -->
            <script>
                var JQ = jQuery.noConflict();
                        JQ(document).on("click",".add_plan_form1",function() {
                            var num=JQ(".remove_plan_form_details").length;
                        var counter=num+2;
                        //           alert(counter);return false;
                        var param = {};
                        param.counter= counter;
                        JQ.post('get_bhautik_pariman_details.php',param,function(res){
                            var obj = JSON.parse(res);
                        //alert(obj.html);
                            JQ("#join_table_plan_form_1").append(obj.html);
                            //JQ('#interest_amount_'+id).val(obj.interest_amount);

                           // alert(obj.interest_amount);
                         });
                        });

                         JQ(document).on("click",".remove_plan_form1",function() {
                             JQ('.remove_plan_form_details').last().remove();

                        });
                         JQ(document).on("click",".remove_btn",function() {
                             JQ(this).closest('tr').remove();
                                var i = 1;
                                JQ(".sn").each(function(){
                                        JQ(this).html(i+1);
                                        i++;
                                });


                        });
        JQ(document).on("input","#agreement_gauplaika, #agreement_other, #other_agreement, #costumer_agreement, #bhuktani_anudan, #costumer_investment",function() {
           var con_glob = 0;
            var plan_id = JQ("#plan_id").val()||0;
           var costumer_investment = JQ("#costumer_investment").val() || 0;
          var param = {};
          param.plan_id= plan_id;
            
          JQ.post('get_contingency_for_plan.php',param,function(res){
            var obj = JSON.parse(res);
            var val  = parseFloat(obj.html);
            con_glob = parseFloat(con_glob) + parseFloat(val);
          var gaupalika_check = JQ("input[name='anudan_con']:checked").val()||0;
          var aanya_nikaya_check = JQ("input[name='aanya_nikaya_con']:checked").val()||0;
          var aanya_sajhedari_check = JQ("input[name='aanya_sajhedari_con']:checked").val()||0;
          var nagad_sajhedari_check = JQ("input[name='nagad_sajhedari_con']:checked").val()||0;
          if(gaupalika_check==1)
          {
               var agreement_gaupalika = (JQ("#agreement_gauplaika").val() || 0);
               var con_agreement_gaupalika = (JQ("#agreement_gauplaika").val() || 0) * con_glob;
               var net_agreement_gaupalika = parseFloat(agreement_gaupalika) - parseFloat(con_agreement_gaupalika);
          }
          else
          {
               var net_agreement_gaupalika = JQ("#agreement_gauplaika").val() || 0;
          }
          if(aanya_nikaya_check==1)
          {
              var agreement_other = JQ("#agreement_other").val() || 0;
              var con_agreement_other = (JQ("#agreement_other").val() || 0) * con_glob;
              var net_agreement_other =parseFloat(agreement_other) - parseFloat(con_agreement_other);
          }
          else
          {
               var net_agreement_other = JQ("#agreement_other").val() || 0;
          }
          if(aanya_sajhedari_check==1)
          {
               var other_agreement = (JQ("#other_agreement").val() || 0);
               var con_other_agreement = (JQ("#other_agreement").val() || 0) * con_glob;
               var net_other_agreement = parseFloat(other_agreement) - parseFloat(con_other_agreement);
          }
          else
          {
              var net_other_agreement = JQ("#other_agreement").val() || 0;
          }
          if(nagad_sajhedari_check==1)
          {
               var costumer_agreement = (JQ("#costumer_agreement").val() || 0);
               var con_costumer_agreement = (JQ("#costumer_agreement").val() || 0) * con_glob;
               var net_costumer_agreement = parseFloat(costumer_agreement) - parseFloat(con_costumer_agreement);
          }
          else
          {
              var net_costumer_agreement = JQ("#costumer_agreement").val() || 0;   
          }
         
        var total = parseFloat(net_agreement_gaupalika) + parseFloat(net_agreement_other) + parseFloat(net_other_agreement)+parseFloat(net_costumer_agreement);
         JQ("#bhuktani_anudan").val(total);
           var total4 = parseFloat(total) + parseFloat(costumer_investment);
           JQ("#total_investment").val(total4.toFixed(4));
                     
            });
        
          });
          JQ(document).on("click","#anudan_con,#aanya_nikaya_con,#aanya_sajhedari_con,#nagad_sajhedari_con",function() {
           var con_glob = 0;
            var plan_id = JQ("#plan_id").val()||0;
           var costumer_investment = JQ("#costumer_investment").val() || 0;
          var param = {};
          param.plan_id= plan_id;
            
          JQ.post('get_contingency_for_plan.php',param,function(res){
            var obj = JSON.parse(res);
            var val  = parseFloat(obj.html);
            con_glob = parseFloat(con_glob) + parseFloat(val);
          var gaupalika_check = JQ("input[name='anudan_con']:checked").val()||0;
          var aanya_nikaya_check = JQ("input[name='aanya_nikaya_con']:checked").val()||0;
          var aanya_sajhedari_check = JQ("input[name='aanya_sajhedari_con']:checked").val()||0;
          var nagad_sajhedari_check = JQ("input[name='nagad_sajhedari_con']:checked").val()||0;
          if(gaupalika_check==1)
          {
               var agreement_gaupalika = (JQ("#agreement_gauplaika").val() || 0);
               var con_agreement_gaupalika = (JQ("#agreement_gauplaika").val() || 0) * con_glob;
               var net_agreement_gaupalika = parseFloat(agreement_gaupalika) - parseFloat(con_agreement_gaupalika);
          }
          else
          {
               var net_agreement_gaupalika = JQ("#agreement_gauplaika").val() || 0;
          }
          if(aanya_nikaya_check==1)
          {
              var agreement_other = JQ("#agreement_other").val() || 0;
              var con_agreement_other = (JQ("#agreement_other").val() || 0) * con_glob;
              var net_agreement_other =parseFloat(agreement_other) - parseFloat(con_agreement_other);
          }
          else
          {
               var net_agreement_other = JQ("#agreement_other").val() || 0;
          }
          if(aanya_sajhedari_check==1)
          {
               var other_agreement = (JQ("#other_agreement").val() || 0);
               var con_other_agreement = (JQ("#other_agreement").val() || 0) * con_glob;
               var net_other_agreement = parseFloat(other_agreement) - parseFloat(con_other_agreement);
          }
          else
          {
              var net_other_agreement = JQ("#other_agreement").val() || 0;
          }
          if(nagad_sajhedari_check==1)
          {
               var costumer_agreement = (JQ("#costumer_agreement").val() || 0);
               var con_costumer_agreement = (JQ("#costumer_agreement").val() || 0) * con_glob;
               var net_costumer_agreement = parseFloat(costumer_agreement) - parseFloat(con_costumer_agreement);
          }
          else
          {
              var net_costumer_agreement = JQ("#costumer_agreement").val() || 0;   
          }
         
        var total = parseFloat(net_agreement_gaupalika) + parseFloat(net_agreement_other) + parseFloat(net_other_agreement)+parseFloat(net_costumer_agreement);
         JQ("#bhuktani_anudan").val(total);
           var total4 = parseFloat(total) + parseFloat(costumer_investment);
           JQ("#total_investment").val(total4.toFixed(4));
                     
            });
        
          });
                JQ(document).on("change", ".parent_details_id", function() {
                    var param = {};
                    param.id = +JQ(this).val();
                    var target = JQ(this).parent().parent().find("td:eq(2)")
                    JQ.post('get_bhautik_pariman_sub_details.php', param, function(res) {
                        var obj = JSON.parse(res);
                        target.html(obj.html)
                    });
                    JQ(document).on("click", "#save_new_parent", function() {
                        var new_title_name = JQ('#new_title_name').val();
                        if(!new_title_name){
                            alert("परिमाणको शिर्षक");
                            return;
                        }
                        var new_parent_id = JQ('#new_parent_id').val();
                        var param = {
                            name: new_title_name,
                            parent_id: new_parent_id,
                            save: true
                        };
                });
                </script>
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>