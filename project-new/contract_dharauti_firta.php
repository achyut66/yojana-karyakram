<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$contractbid_final= Contractentryfinal::find_by_plan_id($_SESSION['set_plan_id']);
//print_r($contractbid_final);exit;
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);


$plan_selected = Plandetails1::find_by_id($_SESSION['set_plan_id']);

?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><?=$plan_selected->program_name?> | <a href="contractdharauti_dashboard.php" class="btn">पछि जानुहोस</a></h2>
           
                <?php echo $message;?>
            <div class="OurContentFull">
                
              <div class="userprofiletable">
                  <h3>धरौटी फिर्ता </h3>
                        <table class="table table-bordered">
                            <tr> 
                                <th>सि नं</th>
                                <th>निर्माण ब्यवोसायीको नाम</th>
                                <th>जम्मा धरौटी रकम </th>
                                <th>धरौटी फिर्ता रकम </th>
                                <th>धरौटी बाकी रकम </th>
                                <th>फिर्ता गर्नुहोस</th>
                            </tr>
                             <?php $i=1;foreach($contractbid_final as $data):
//    print_r($data);exit;
                                 $bid_result=  Contractbidfinal::find_by_contractor_id($data->contractor_id,$_SESSION['set_plan_id']);
                                 $contractbid_result= Contractbidfinal::find_by_contractor_id($data->id,$_SESSION['set_plan_id']);
                                $contractor_details=  Contractordetails::find_by_id($data->contractor_id);
                             if($data->status==1)
                                    {
                                        $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$data->id);
//                                        echo $data->dharauti_amount."=".$get_amount;exit;
                                        $analysis_amount=  Contractanalysisbasedwithdraw::getTotalDharautiPayableAmount($_SESSION['set_plan_id']);
//                                        echo $analysis_amount;exit;
                                        $final_amount=  Contractamountwithdrawdetails::find_by_plan_id($_SESSION['set_plan_id']);
                                        $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount + $analysis_amount + $final_amount->final_due_amount;
                                        $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$data->id);
                                       $final_amount=$final_dharauti_amount - $amount;
                                    }
                                    else
                                    {
                                         $get_amount=  Contractdharautiadd::getTotalPayableAmount($_SESSION['set_plan_id'],$data->id);
                                         $final_dharauti_amount=$bid_result->dharauti_amount + $get_amount;
                                        $amount=  Contractdharautifirta::getTotalPayableAmountByContractorId($_SESSION['set_plan_id'],$data->id);
                                       $final_amount=$final_dharauti_amount - $amount;
                                    }
//                                    echo $amount;exit;
                                 ?>
                            <tr>
                                <td><?php echo convertedcit($i)?></td>
                                <td><?php echo Contractordetails::getName($data->contractor_id);?></td>
                                <td><?php echo convertedcit(placeholder($final_dharauti_amount));?></td>
                                <td><?php echo convertedcit(placeholder($amount));?></td>
                                <td><?php echo convertedcit(placeholder($final_amount));?></td>
                                <td><a href="contract_dharauti_firta1.php?contractor_id=<?php echo $data->id;?>" class="btn">फिर्ता गर्नुहोस</a></td>
                                  
                            </tr>
                             <?php $i++;endforeach;?>
                        
                        </table>
                    
                </div>
                  
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>