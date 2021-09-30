<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$user = getUser();
error_reporting(-1);
//echo Get_empty_plan();
$type="";
$ward ="";
$max_ward = Ward::find_max_ward_no();
?>
<?php include("menuincludes/header.php"); ?>

<?php 
if(isset($_POST['submit'])):
    // ठेक्का मार्फत 
    $contract_result=  Contract_total_investment::find_all();
    $cout0 = count($contract_result);
    $thekka_anu = 0;
    foreach($contract_result as $contract_result):
        $thekka_anu +=  $contract_result->agreement_gaupalika;
    endforeach;
    
    $contract_with= Contractamountwithdrawdetails::find_all();
    $kharcha_rakam = 0;
    foreach($contract_with as $contract_with):
        $kharcha_rakam += $contract_with->final_total_paid_amount;
    endforeach;
    
    $baki_thekka = $thekka_anu - $kharcha_rakam;
    
    //end of thekka //
        
    // उपभोक्ता मार्फत//
    $upabhokta_result= Plantotalinvestment::find_all();
    $cout1 = count($upabhokta_result);
    $gaunpalika_anu = 0;
    foreach($upabhokta_result as $upabhokta_result):
        $gaunpalika_anu +=  $upabhokta_result->agreement_gauplaika;
    endforeach;
    
    $upabhokta_with= Planamountwithdrawdetails::find_all();
    $kharcha_rakam_upa = 0;
    foreach($upabhokta_with as $upabhokta_with):
        $kharcha_rakam_upa += $upabhokta_with->final_total_paid_amount;
    endforeach;
    
    $baki_upa = $gaunpalika_anu - $kharcha_rakam_upa;
    
    // end of upabhokta //
    
    // संस्था मार्फत //
    $sanstha_result= Samitiplantotalinvestment::find_all();
    $cout2 = count($sanstha_result);
    $sanstha_anu = 0;
    foreach($sanstha_result as $sanstha_result):
        $sanstha_anu +=  $sanstha_result->agreement_gauplaika;
    endforeach;
    
    $sanstha_with= Samitiplanamountwithdrawdetails::find_all();
    $kharcha_rakam_sanstha = 0;
    foreach($sanstha_with as $sanstha_with):
        $kharcha_rakam_sanstha += $sanstha_with->final_total_paid_amount;
    endforeach;
    
    $baki_sanstha = $sanstha_anu - $kharcha_rakam_sanstha;
    
    //end of sanstha //
    
    // अमानत मार्फत //
    $amanat_result= AmanatLagat::find_all();
    $cout3 = count($amanat_result);
    $amanat_anu = 0;
    foreach($amanat_result as $amanat_result):
        $amanat_anu +=  $amanat_result->agreement_gauplaika;
    endforeach;
    // end of amanat//
    
    // कोटेसन मार्फत //
    $quotation_result= Quotationtotalinvestment::find_all();
    $cout4 = count($quotation_result);
    $kotesan_anu = 0;
    foreach($quotation_result as $quotation_result):
        $kotesan_anu +=  $quotation_result->gaupalika_anudan;
    endforeach;
    
    // $kotesan_with= Quotationamountwithdraw::find_all();
    // $kharcha_rakam_kotesan = 0;
    // foreach($kotesan_with as $kotesan_with):
    //     $kharcha_rakam_kotesan += $kotesan_with->final_total_paid_amount;
    // endforeach;
    //end of kotesan//
$type = $_POST['type'];
$ward = $_POST['ward_no'];
endif;
?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
            <h2 class="headinguserprofile">आन्तरिक रिपोर्ट हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">
                <div class="userprofiletable">
                                  <form method="post" onsubmit="form.submit()" >
                                  <div class="inputWrap">
                                  		<h1>आन्तरिक रिपोर्ट हेर्नुहोस</h1>
                                        <div class="titleInput">योजना / कार्यक्रम  खोज्नुहोस:</div>
                                        <div class="newInput"><select name="type"  onchange="form.submit();">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0" <?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
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
                                         <div class="saveBtn myWidth100"><input type="submit" class="btn" name="submit" value="खोज्नुहोस"/></div>   
                                        <div class="myspacer"></div>    	
                                  </div><!-- input wrap ends -->
                                  </form>
                                  <?php $nagar_plans = Plandetails1::find_by_sql("select * from plan_details1 where ward_no = 0");//echo "<pre>";print_r($nagar_plans);?>
                                  <?php if(isset($_POST['submit'])):
                                  $type=$_POST['type'];    
                                  ?>
                                    <div class="myPrint"><a target="_blank" href="report_print.php?type=<?= $type ?>&ward_no=<?=$ward?>">प्रिन्ट गर्नुहोस</a></div><div class="myPrint"><a class="" href="report_excel.php?type=<?php echo $type;?>&ward_no=<?=$ward?>">Export to EXCEL</a></div>
                                    <div class="exporte"></div><br> 
                                     <?php if(!empty($ward)){
                                          echo "<h2>".convertedcit($ward)." नं वार्ड को ".get_type_nepali($type)." हेर्नुहोस </h2>";
                                      }
                        ?>
                        <table class="table table-bordered table-hover table-striped">
                          <tr>
                            <td class="myCenter"><strong>योजना  रिपोर्ट </strong></td>
                            <td class="myCenter"><strong>जम्मा  सम्झौता भएका योजनाहरु</strong></td>
                            <td class="myCenter"><strong>जम्मा  गाउँपालिका अनुदान </strong></td>
                            <td class="myCenter"><strong>हाल सम्मको खर्च </strong></td>
                            <td class="myCenter"><strong>बाँकी रकम </strong></td>
                            <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                        </tr>
                        <tr>
                          <td class="myCenter">उपभोक्ता समिति मार्फतका योजनाहरु </td>
                          <td class="myCenter"><?php echo convertedcit($cout1);?></td>
                          <td class="myCenter"><?php echo convertedcit($gaunpalika_anu)?></td>
                          <td class="myCenter"><?php echo convertedcit($kharcha_rakam_upa)?></td>
                          <td class="myCenter"><?php echo convertedcit($baki_upa)?></td>
                          <td class="myCenter"><a href="upabhokta_samjhauta_report.php" class="btn">थप विवरण</a></td>
                        </tr>
                        <tr>
                          <td class="myCenter">ठेक्का मार्फत सम्झौता भएका योजनाहरु </td>
                          <td class="myCenter"><?php echo convertedcit($cout0);?></td>
                          <td class="myCenter"><?php echo convertedcit($thekka_anu)?></td>
                          <td class="myCenter"><?php echo convertedcit($kharcha_rakam)?></td>
                          <td class="myCenter"><?php echo convertedcit($baki_thekka)?></td>
                          <td class="myCenter"><a href="thekka_samjhauta_report.php" class="btn">थप विवरण</a></td>
                        </tr>
                        <tr>
                          <td class="myCenter">संस्था मार्फत सम्झौता भएका योजनाहरु </td>
                          <td class="myCenter"><?php echo convertedcit($cout2);?></td>
                          <td class="myCenter"><?php echo convertedcit($sanstha_anu)?></td>
                          <td class="myCenter"><?php echo convertedcit($kharcha_rakam_sanstha)?></td>
                          <td class="myCenter"><?php echo convertedcit($baki_sanstha)?></td>
                          <td class="myCenter"><a href="" class="btn">थप विवरण</a></td>
                        </tr>
                        <tr>
                          <td class="myCenter">अमानत मार्फत सम्झौता भएका योजनाहरु </td>
                          <td class="myCenter"><?php echo convertedcit($cout3);?></td>
                          <td class="myCenter"><?php echo convertedcit($amanat_anu)?></td>
                          <td class="myCenter"></td>
                          <td class="myCenter"></td>
                          <td class="myCenter"><a href="" class="btn">थप विवरण</a></td>
                        </tr>    
                        <tr>
                          <td class="myCenter">कोटेशन मार्फत सम्झौता भएका योजनाहरु</td>
                          <td class="myCenter"><?php echo convertedcit($cout4);?></td>
                          <td class="myCenter"><?php echo convertedcit($kotesan_anu)?></td>
                          <td class="myCenter"></td>
                          <td class="myCenter"></td>
                          <td class="myCenter"><a href="" class="btn">थप विवरण</a></td>
                        </tr>
                        </table> 
                        <?php endif;?>
</div>
</div>
</div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>