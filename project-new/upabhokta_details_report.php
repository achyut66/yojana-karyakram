<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
error_reporting(1);
$max_ward = Ward::find_max_ward_no();
$user = getUser();

?>
<?php include("menuincludes/header.php"); ?>
<!-- ठेक्का मार्फत  -->
<?php 
if(isset($_POST['submit'])):
    if(empty($_POST['ward_no']))
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id";
    }
    else
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id where b.ward_no=".$_POST['ward_no'];
        
    }
    $result = $database->query($sql);
    
    endif;
?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">उपभोक्ता विवरण हेर्नुहोस  | <a href="index.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                
                <div class="userprofiletable">
				  
                                  <form method="post" onsubmit="form.submit()" >
                                 
                                          <div class="inputWrap">
                                  		<h1>उपभोक्ता विवरण हेर्नुहोस</h1>
                                        
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
                                 
       
         
                                 <?php if(isset($_POST['submit'])):?>
                     <div class="myPrint"><a target="_blank" href="upabhokta_samiti_print.php?ward_no=<?=$_POST['ward_no']?>">प्रिन्ट गर्नुहोस</a></div><div class="myPrint"><a class="" href="upabhokta_samiti_excel.php?ward_no=<?=$_POST['ward_no']?>">Export to EXCEL</a></div>
        <div class="exporte"></div><br> 
                                    <h2><?php if(empty($_POST['ward_no'])){ echo "उपभोक्ता समिति  विवरण हेर्नुहोस"; }else{ echo "वडा नं ".convertedcit($_POST['ward_no'])." को उपभोक्ता समिति विवरण हेर्नुहोस ";} ?></h2>
                                    
                                  <table class="table table-bordered table-hover">
                                          
                                      <tr>
                                            <td class="myCenter"><strong>सि नं </strong></td>
                                            <td class="myCenter"><strong>दर्ता नं </strong></td>
                                            <td class="myCenter"><strong>योजनाको नाम </strong></td>
                                             <td class="myCenter"><strong>उपभोक्ता समितिको नाम </strong></td>
                                             <td class="myCenter"><strong>अनुदान रकम</strong></td>
                                            <td class="myCenter"><strong>उपभोक्ताबाट नगद साझेदारी</strong></td>
                                            <td class="myCenter"><strong>पुरा विवरण हेर्नुहोस</strong></td>
                                      </tr>
                                      <?php $i=1; while($data = mysqli_fetch_object($result)):
                                          if(!empty($data->id))
                                          {
                                                $customer_result = Costumerassociationdetails0::find_by_plan_id($data->id);
                                          }
                                          else
                                          {
                                              $customer_result = Costumerassociationdetails0::setEmptyObjects();
                                          }
                                        if(!empty($customer_result))
                                      {
                                          $name= $customer_result->program_organizer_group_name;
                                      }
                                      else
                                      {
                                          $name="";
                                      }
                                      if($data->costumer_agreement==0)
                                      {
                                          continue;
                                      }
                                          ?>
                                       <tr>
                                          <td class="myCenter"><?=convertedcit($i)?></td>
                                        <td class="myCenter"><?=convertedcit($data->id)?> </td>
                                        <td class="myCenter"><?= $data->program_name?></td>
                                        <td class="myCenter"><?=$name?></td>
                                         <td class="myCenter"><?=convertedcit(placeholder($data->investment_amount))?></td>
                                         <td class="myCenter"><?=convertedcit(placeholder($data->costumer_agreement))?></td>
                                         <td><a href="view_upabhokta_samiti.php?plan_id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस </a></td>
                                        </tr>
                                       <?php $i++;endwhile;?>
                                  </table>  
                                  <?php endif;?>
					
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>