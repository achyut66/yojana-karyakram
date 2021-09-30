<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user = getUser();
if($user->mode=="user")
{
  $datas=  Plandetails::find_by_sql("select * from plan_details1 where ward_no=".$user->ward);
}
elseif($user->mode=="section")
{
  $datas=  Plandetails::find_by_sql("select * from plan_details1 where topic_area_id=".$user->topic_area_id." and topic_area_type_id=".$user->topic_area_type_id);
}
else
{
  $datas = Plandetails1::find_all();

}
$counted_result=  getOnlyRegisteredPlans(0);
$final_array=$counted_result['final_count_array'];
$topic_area_investment_id="";
$search_text="";
$search_ward="";

if(isset($_GET['submit']))
{   
  $sql = "select * from plan_details1 ";
    //echo $sql;
  $type=$_GET['type'];
  $topic_area_investment_id=$_GET['topic_area_investment_id'];
//    echo $topic_area_investment_id;exit;
  $search_text=$_GET['search_text'];
  $search_ward=$_GET['search_ward'];
  $program_name = $_GET['program_name'];
  if($user->mode=="user")
  {
    if($search_ward==$user->ward)
    {
      $search_ward=$user->ward;
    }
    else
    {
      echo alertBox("कृपया आफ्नो वार्ड को मात्र खोज्नुहोला...!!!","view_all_plans.php");
    }
  }
  else
  {
    $search_ward=$_GET['search_ward'];
  }

  if(empty($_GET['id']))
  {
    if(($type!="") && empty($topic_area_investment_id))
    {
      $sql .=" where type='".$type."' ";

    }
    if(!empty($topic_area_investment_id) && $type=="")
    {
      $sql .=" where topic_area_investment_id='".$topic_area_investment_id."'";

    }
    if(!empty($topic_area_investment_id) && $type!="" && empty($search_ward))
    {
      $sql .=" where type='".$type."' and topic_area_investment_id='".$topic_area_investment_id."'";

    }
    if(!empty($topic_area_investment_id) && $type!="" && !empty($search_ward))
    {
      $sql .=" where type='".$type."' and topic_area_investment_id='".$topic_area_investment_id."' and ward_no=".$search_ward;
    }
    if(!empty($search_text))
    {
      $sql ="select * from plan_details1 where id =".$search_text;
    }
    if(!empty($search_ward) && empty($topic_area_investment_id) && $type=="" && $search_text=="")
    {
      $sql ="select * from plan_details1 where  ward_no='".$search_ward."'";
    }
    if(!empty($program_name))
    {
     $sql="select * from plan_details1 where program_name LIKE '%".$program_name."%'";
   }

 }

//  echo $sql;exit;
    //$sql="select * from plan_details1 where topic_area_id='".$_GET['topic_area_id']."' and topic_area_investment_id='".$_GET['topic_area_investment_id']."'or id='".$_GET['search_text']."' ";
 $datas = Plandetails1::find_by_sql($sql);
//    print_r($datas);exit;


}
//echo count($datas);exit;
$fiscals=  Fiscalyear::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area=  Topicarea::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<style>
/*td:hover {*/
/*    background-color: lightyellow;*/
/*}*/
  table {
    
    width: 100%;
    border: none;
    
  }
  th,td {
    padding: 8px;
    text-align: left;
    border-bottom: 3px solid #ddd;
    /*background: #3cc16e;*/
  }

  tr:nth-child(even) {background-color: #f2f2f2;
      border-radius: 10px;
  }
  /*tr:hover {background-color:#f2f2f2;}*/
</style>
<body>
  <?php include("menuincludes/topwrap.php"); ?>
  <div id="body_wrap_inner">
    <div class="maincontent">
      <h2 class="headinguserprofile">योजना विवरण हेर्नुहोस | <a href="view_plan_dashboard.php" class="btn">पछि जानुहोस</a></h2>
      <?php echo $message;?>
      <div class="OurContentFull">
        <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
        <div class="userprofiletable">
          <div class="ourHeader">योजना हेर्नुहोस </div>
          <?php if($user->mode!="user" && $user->mode!="section"):?>
            <form method="get">
              <table class="table table-bordered table-responsive" style="table-layout: auto;table-border:2px;">
                <tr>
                 <td class="myCenter">किसिम छान्नुहोस्
                   <select name="type" class="form-control">
                     <option value="" >---छान्नुहोस्---</option>
                     <option value="0"  >योजना</option>
                     <option value="1" >कार्यक्रम</option>
                   </select>
                 </td>
                 <td class="myCenter"> योजनाको विनियोजन किसिम:<select name="topic_area_investment_id" class="form-control">
                   <option value="">---छान्नुहोस्---</option>
                   <?php foreach($topic_area_investment as $topic): ?>
                     <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_investment_id){?> selected="selected"<?php } ?>><?php echo $topic->name;  ?></option>
                   <?php endforeach; ?>
                 </select>
               </td>
               <td class="myCenter">वार्ड नं :<input type="text" name="search_ward" class="input100percent" value="<?php echo $search_ward;?>"/></td>
               <td class="myCenter">दर्ता नं : <input type="text" name="search_text" class="input100percent" value="<?php echo $search_text;?>"/></td>
               <td>योजनाको नाम </td>
               <td><textarea name="program_name" ><?php echo $program_name;?></textarea></td>
               <td class="myCenter"><input type="submit" name="submit" value="खोज्नुहोस" class="btn-success" /></td>
               <td class="myCenter"><a href="view_all_plans.php"><input type="button" class="btn-danger" value="रद्द गर्नुहोस" /> </a></td>
             </tr>
           </table>   
         </form>
       <?php endif;?>
       <?php if($user->mode=="section" || $user->mode=="superadmin" || $user->mode=="administrator" || $user->mode=="user"):?>
        <td><div class="">
               <a href="print_view_all_plans.php?type=<?=$_GET['type']?>&topic_area_investment_id=<?=$_GET['topic_area_investment_id']?>&search_text=<?=$_GET['search_text']?>&ward=<?=$_GET['search_ward']?>&topic_area_id=<?=$user->topic_area_id?>&topic_area_type_id=<?=$user->topic_area_type_id?>" target="_blank">
                   <input type="button" class="btn-success" value="प्रिन्ट गर्नुहोस">
               </a></div>
          </td><?php endif;?>
          <table class="table table-bordered table-hover">
           <tr>
            <th class="myCenter">सि नं </th>
            <th class="myCenter">दर्ता नं</th>
            <th class="myCenter">राजपत्र नं</th>
            <th class="myCenter">शिर्षक नं</th>
            <th class="myCenter">योजना / कार्यक्रमको नाम</th>
            <th class="myCenter">परिमाण</th>
            <th class="myCenter">बिषयगत क्षेत्रको किसिम</th>
            <th class="myCenter">योजनाको शिर्षकगत किसिम</th>
            <?php if(empty($user->mode=="user")){?>
            <th class="myCenter">योजनाको उपशिर्षकगत किसिम</th>
            <?php }else{}?>
            <th class="myCenter">अनुदानको किसिम</th>
            <th class="myCenter">विनियोजन किसिम</th>
            <th class="myCenter">वार्ड नं</th>
            <th class="myCenter">अनुदान रकम (रु.)</th>
            <th class="myCenter">खर्च रकम</th>
            <th class="myCenter">बाँकि रकम</th>
            <th class="myCenter">योजना संचालन स्थिति</th>
            <th class="myCenter">संचालन विवरण</th>
          </tr>
          <?php 
          $total_net_payable=0;
          $total_remaining=0;
          $i=1;
          foreach($datas as $data):


           if($data->type==0)
           {  
            $budget=  Ekmustabudget::find_by_plan_id($data->id);
            if(!empty($budget))
            {
              $net_payable_amount =$budget->total_expenditure;
              $remaining_amount= $data->investment_amount - $net_payable_amount; 
            }
            else{ 
             $contract_result= Contract_total_investment::find_by_plan_id($data->id);
             if(empty($contract_result))
             {
               $data->investment_amount = get_investment_amount($data->id);
               if(in_array($data->id, $final_array))
               {
                 $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                 $remaining_amount=$data->investment_amount - $net_payable_amount; 
               }
               else
               {

                 $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                      //                                             echo $net_payable_amount;exit;
                 $remaining_amount= $data->investment_amount - $net_payable_amount; 
               } 
             }
             else
             {
               if(in_array($data->id, $final_array))
               {
                $net_payable_amount=get_contract_net_kharcha_amount($data->id);

                $remaining_amount=$data->investment_amount - $net_payable_amount; 
              }
              else
              {

               $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
               $remaining_amount=$data->investment_amount - $net_payable_amount; 
             }  

           }
         }
       }
       else
       {
        $budget=  Ekmustabudget::find_by_plan_id($data->id);
        if(!empty($budget))
        {
          $net_payable_amount =$budget->total_expenditure;
          $remaining_amount= $data->investment_amount - $net_payable_amount; 
        }
        else
        {
          $program_result=Programpaymentfinal::find_by_program_id1($data->id);
          $advance_total = Programpayment::get_total_payment_amount($data->id);
          $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
          $net_payable_amount = $advance_total + $net_total_amount_total;
          if(empty($net_payable_amount))
          {
            $remaining_amount=$data->investment_amount;
          }
          else
          {
            $remaining_amount=($data->investment_amount)-($net_payable_amount);

          }
        }
      }
      $customer_lagat = Plantotalinvestment::find_by_plan_id($data->id);
      $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
      $contract_plan_total= Contractinfo::find_by_plan_id($data->id);
      $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
      $quotation_lagat = Quotationtotalinvestment::find_by_plan_id($data->id);
      $if_bhuk = Planamountwithdrawdetails::find_by_plan_id($data->id);
      $if_contract_bhuk = Contractamountwithdrawdetails::find_by_plan_id($data->id);
      $if_samiti_bhuk = Samitiplanamountwithdrawdetails::find_by_plan_id($data->id);
//      echo "<pre>";
//      print_r($if_samiti_bhuk);
      if($data->type==1)
      {
        $link = "program_total_view.php?id=".$data->id;
        $sanchalan_prakiya = "कार्यक्रम मार्फत ";
      }
      elseif($data->type==0 && !empty($samiti_plan_total))
      {
        $link="view_samiti_plan_form.php?id=".$data->id; 
        $sanchalan_prakiya = "संस्था / समिति मार्फत ";
      }
      elseif($data->type==0 && !empty($contract_plan_total))
      {
        $link="view_all_contract.php?id=".$data->id; 
        $sanchalan_prakiya = "ठेक्का मार्फत ";
      }
      elseif($data->type==0 && !empty($amanat_lagat))
      {
        $link= "view_all_amanat.php?id=".$data->id;
        $sanchalan_prakiya = "अमानत मार्फत ";
      }
      elseif($data->type==0 && !empty($customer_lagat))
      {
       $link="view_plan_form.php?id=".$data->id;   
       $sanchalan_prakiya = "उपभोक्ता मार्फत ";
      }
      elseif($data->type==0 && !empty($quotation_lagat)){
          $link ="view_quotation_form.php?id=".$data->id;
          $sanchalan_prakiya = "कोटेसन मार्फत";
      }
      else
      {
         $link="";
         $sanchalan_prakiya = "सम्झौता हुन बाँकि";
      }
     //print_r($data);
     ?>
     <tr>
      <td><?php echo convertedcit($i);?></td>
      <td><?php echo convertedcit($data->id);?></td>
      <td>
          <?php 
            if(!empty($data->rajpatra_no)){
                echo convertedcit($data->rajpatra_no);
            }else{
                echo "---";
            }
          ?>
      </td>
      <td>
          <?php
            if(!empty($data->topic_no)){
                echo convertedcit($data->topic_no);
            }else{
                echo "---";
            }
          ?>
      </td>
      <td><?php echo $data->program_name;?></td>
      <td>
          <?php if(!empty($data->qty)){
              echo convertedcit($data->qty);echo "-";echo"पटक";
          }else{
              echo "---";
          }?>
      </td>
      <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
      <td><?php echo convertedcit(Topicareatype::getName($data->topic_area_type_id));?></td>
      <?php if(empty($user->mode=="user")){?>
      <td><?php echo convertedcit(Topicareatypesub::getName($data->topic_area_type_sub_id));?></td>
      <?php }else{}?>
      <td><?php echo convertedcit(Topicareaagreement::getName($data->topic_area_agreement_id));?></td>
      <td><?php echo convertedcit(Topicareainvestment::getName($data->topic_area_investment_id));?></td>
      <td><?php echo convertedcit($data->ward_no);?></td>
      <td style="width:10%"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
      <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
      <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
      <td style="width:10%;background-color:#C9EDFF;">
          <?php if(!empty($customer_lagat)){?>
            <div style="color:blue;"> <?php echo $sanchalan_prakiya ?>
                <?php if(!empty($if_bhuk)){?>
                    <div style="background-color:lime;">(भुक्तानी भैसकेको)</div>
                <?php }else{?>
                    <div style="background-color:#FAF884;">(सम्झौता भएको)</div>
                <?php }?>
            </div>
            <?php }elseif(!empty($amanat_lagat)){?>
            <div style="color:#FF00FF;"> <?php echo $sanchalan_prakiya ?>
                <?php if(!empty($if_bhuk)){?>
                    <div style="background-color:lime;">(भुक्तानी भैसकेको)</div>
                <?php }else{?>
                    <div style="background-color:#FAF884;">(सम्झौता भएको)</div>
                
            </div>
            <?php }?>
            <?php }elseif(!empty($samiti_plan_total)){?>
            <div style="color:black;"> <?php echo $sanchalan_prakiya ?>
                <?php if(!empty($if_samiti_bhuk)){?>
                    <div style="background-color:lime;">(भुक्तानी भैसकेको)</div>
                <?php }else{?>
                    <div style="background-color:#FAF884;">(सम्झौता भएको)</div>
                
            </div>
            <?php }?>
            <?php }elseif(!empty($contract_plan_total)){?>
            <div style="color:#999999;"> <?php echo $sanchalan_prakiya ?>
                <?php if(!empty($if_contract_bhuk)){?>
                    <div style="background-color:lime;">(भुक्तानी भैसकेको)</div>
                <?php }else{?>
                    <div style="background-color:#FAF884;">(सम्झौता भएको)</div>
                
            </div>
            <?php }?>
            <?php }elseif(!empty($quotation_lagat)){?>
            <div style="color:#800080;"> <?php echo $sanchalan_prakiya ?>
                <?php if(!empty($if_bhuk)){?>
                    <div style="background-color:lime;">(भुक्तानी भैसकेको)</div>
                <?php }else{?>
                    <div style="background-color:#FAF884;">(सम्झौता भएको)</div>
                
            </div>
            <?php }?>
          <?php }elseif($data->type==1){?>
            <div style="color:#FA84E8;"> <?php echo $sanchalan_prakiya ?></div>
          <?php }else{?>
            <div style="color:red;"> <?php echo $sanchalan_prakiya ?> </div>
          <?php }?>
      </td>
      <td><a href="<?php echo $link; ?>"><input type="button" class="btn-success" value="पुरा विवरण"></a></td>
    </tr>
    <?php $i++;
    $total_net_payable +=$net_payable_amount;
    $total_remaining +=$remaining_amount;
  endforeach;?>
  <?php    
  $total=0;
  foreach($datas as $data): 
   $total+=$data->investment_amount;  

 endforeach;?>
 <tr>
  <?php if(empty($user->mode=="user")){?>
  <td colspan="12" class="text-center">जम्मा रकम </td>     
  <?php }else{?>
  <td colspan="11" class="text-center">जम्मा रकम </td>     
  <?php }?>
  <td>रु.<?php echo convertedcit(placeholder($total));?></td>
  <td>रु.<?php echo convertedcit(placeholder($total_net_payable));?></td>
  <td>रु.<?php echo convertedcit(placeholder($total_remaining));?></td>
  <td colspan="3"></td>

</tr>
</table>

</div>
</div>
</div><!-- main menu ends -->

</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>