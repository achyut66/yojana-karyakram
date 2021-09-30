<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$user = getUser();
$max_ward = Ward::find_max_ward_no();
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();?>
<?php include("menuincludes/header.php"); ?>
<?php
$plan_type="";
$topic_area_id="";
$type="";
$total_amount=0;
$total_remaining_amount=0;
$total_investment_amount=0;
$final_array= array();
$total_amount_array=array();
$total_investment_amount_array=array();
$total_remaining_amount_array=array();

if(isset($_POST['submit']))
{   
//    print_r($_POST);exit;

  $fiscal_id=$_POST['fiscal_id'];

  $topic_area_id=$_POST['topic_area_id'];

//    $sql="select * from plan_details1 where fiscal_id=$fiscal_id and type=$type and topic_area_id=$topic_area_id and topic_area_type_id=$topic_area_type_id and topic_area_type_sub_id=$topic_area_type_sub_id";
//    $result=  Plandetails1::find_by_sql($sql);
  $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,1,$_POST['ward_no']);
   //echo "<pre>"; print_r($topic_area_type_ids); echo "</pre>"; exit;

}

?>
<style>
  <style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }
  .borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
}
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
</style>
<body>
  <?php include("menuincludes/topwrap.php"); ?>
  <div id="body_wrap_inner"> 

    <div class="maincontent">
      <h2 class="headinguserprofile"> कार्यक्रमको बिस्तृत मुख्य रिपोर्ट | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>

      <div class="OurContentFull">

        <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
        <div class="userprofiletable">

          <form method="post">
           <div class="inputWrap">
             <h1> कार्यक्रमको बिस्तृत मुख्य रिपोर्ट हेर्नुहोस </h1>
             <div class="titleInput">आर्थिक वर्ष </div>
             <div class="newInput"><select name="fiscal_id">
              <option value="">--छान्नुहोस्--</option>
              <?php foreach($fiscals as $data):?>
                <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
              <?php endforeach;?>
            </select></div>
            <div class="titleInput">कार्यक्रमको बिषयगत क्षेत्रको किसिम: </div>
            <div class="newInput"><select name="topic_area_id" id="topic_area_id" required>
              <option value="">--छान्नुहोस्--</option>
              <?php foreach($topic_area as $topic): ?> 
                <option value="<?php echo $topic->id?>" <?php if($topic_area_id==$topic->id){ echo 'selected="selected"';}?>><?php echo $topic->name;  ?></option>
              <?php endforeach; ?>
            </select></div>
            <div class="titleInput">वार्ड छान्नुहोस् :</div>
            <?php if($mode=="user"):?> 
              <div class="newInput"><select name="ward_no">
               <option value="<?=$user->ward?>"><?=convertedcit($user->ward)?></option>
             </select></div>
             <?php else:?>
              <div class="newInput"><select name="ward_no">
                <option value="">-छान्नुहोस्-</option>
                <?php for($i=1;$i<=$max_ward;$i++):?>
                  <option value="<?=$i?>" <?php if($ward==$i){ echo 'selected="selected"';}?>><?=convertedcit($i)?></option>
                <?php endfor;?>
              </select></div>
            <?php endif;?>
            <div class="saveBtn myWidth100"><input type="submit" name="submit" value="खोज्नुहोस" class="btn"></div>
            <div class="myspacer"></div>
          </div><!-- input wrap ends -->


        </form>



        <?php if(isset($_POST['submit'])):?>              
          <div class="myPrint"><a target="_blank" href="mainreport2_print.php?ward_no=<?=$_POST['ward_no']?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>">प्रिन्ट गर्नुहोस</a></div>
          <div class="myPrint">
            
           <!--  <a  href="mainreport2_excel.php?ward_no=<?=$_POST['ward_no']?>&topic_area_id=<?php echo $topic_area_id;?>&fiscal_id=<?php echo $fiscal_id;?>">EXPORT TO EXCEL</a> -->
             
           </div><br>
            <div style="text-align:center;">
              <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
              <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>


            </div>
            <table class="table table-bordered table-hover"> 
             <div class="myCenter"><strong><?php if(!empty($_POST['ward_no'])){echo "वार्ड नं ".convertedcit($_POST['ward_no'])." को ". Topicarea::getName($_POST['topic_area_id']);}else{ echo Topicarea::getName($_POST['topic_area_id']) ;}?>का कार्यक्रमहरु हेर्नुहोस  </strong></div>
             <tr class="title_wrap">
              <td class="myCenter"><strong>सि.नं.</strong></td>
              <td class="myCenter"><strong>कार्यक्रमको नाम</strong></td>
              <td class="myCenter"><strong>वडा नं</strong></td>
              <td class="myCenter"><strong>अनुदानको किसिम</strong></td>
              <td class="myCenter"><strong>कार्यक्रमको विनियोजित बजेट</strong></td>
              <td class="myCenter"><strong>कार्यक्रमको खर्च भएको रकम</strong></td>
              <td class="myCenter"><strong>कार्यक्रमको बाकी  रकम</strong></td>

            </tr>

            <?php foreach($topic_area_type_ids as $topic_area_selected)
            { ?>





             <tr >            
               <td colspan="7" class="myCenter">
                 <strong> <span  style="text-align:center;"><?php echo Topicareatype::getName($topic_area_selected); ?></strong></td>
                 </tr>
                 <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,1,$_POST['ward_no']);  ?>
                 <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):

                  if(empty($_POST['ward_no']))
                  {

                    $sql = "select * from plan_details1 where type=1 and topic_area_id=".$topic_area_id." 
                    and topic_area_type_id=".$topic_area_selected
                    .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                    .          " and fiscal_id=".$fiscal_id;    
                  }
                  else
                  {
                   $sql = "select * from plan_details1 where ward_no=".$_POST['ward_no']." and type=1 and topic_area_id=".$topic_area_id." 
                   and topic_area_type_id=".$topic_area_selected
                   .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                   .          " and fiscal_id=".$fiscal_id;    
                 }
                 $result =  Plandetails1::find_by_sql($sql);


                 ?>
                 <?php 

                 $total_amount=0;
                 $total_remaining_amount=0;
                 $total_investment_amount=0;
                 ?>


                 <?php if(!empty($result)):  ?>


                  <tr> <td colspan="7" class="myCenter"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 





                  <?php

                  $j=1; 
                  foreach($result as $data)
                  { 

                   $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                   $amount= Programmoredetails::getSum($data->id);
                   if(empty($amount))
                   {
                    $remaining_amount=$data->investment_amount;
                  }
                  else
                  {
                    $remaining_amount=($data->investment_amount)-($amount);
                    $total_investment_amount+=$amount;
                  }
                  $total_amount+=$data->investment_amount;
                  $total_remaining_amount+=$remaining_amount;

                  ?>

                  <tr>

                    <td class="myCenter"><?php echo convertedcit($j);?></td>
                    <td class="myCenter"><?php echo $data->program_name; ?></td>
                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                    <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                    <td class="myCenter"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                    <td class="myCenter"><?php echo convertedcit(placeholder($amount));?></td>
                    <td class="myCenter"><?php echo convertedcit(placeholder($remaining_amount));?></td>

                  </tr>

                  <?php

                  $j++ ; 
                }
              endif;

              ?>  

              <tr>
               <td colspan="4">जम्मा</td>
               <td><?= convertedcit(placeholder($total_amount)) ?></td>
               <td><?= convertedcit(placeholder($total_investment_amount)) ?></td>
               <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
             </tr>                 
             <?php
             array_push($total_amount_array,$total_amount);
             array_push($total_investment_amount_array,$total_investment_amount);
             array_push($total_remaining_amount_array,$total_remaining_amount);


           endforeach;
           $add1=array_sum($total_amount_array);
           $add2=array_sum($total_investment_amount_array);
           $add3=array_sum($total_remaining_amount_array);
         } ?>

         <tr>
           <td colspan="4"><strong>कुल जम्मा</strong></td>
           <td><?= convertedcit(placeholder($add1)) ?></td>
           <td><?= convertedcit(placeholder($add2)) ?></td>
           <td><?= convertedcit(placeholder($add3)) ?></td>
         </tr> 
       </table>
     <?php endif;?>                   

   </div>
 </div>
</div><!-- main menu ends -->

</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>