<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();

if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
 if(empty($_GET['ward_no']))
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id";
    }
    else
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id where b.ward_no=".$_GET['ward_no'];
        
    }
    $result = $database->query($sql);
?>
<?php include("menuincludes/header1.php"); ?>

    <div id="body_wrap_inner"> 
		<div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
					<!--<div class="subjectboldright">रिपोर्ट हेर्नुहोस  </div>-->				
                    <div class="printContent">  
			  <h2></h2>
                                  <table class="table table-bordered table-hover">
                                      <tr>
                                          <td colspan="6" style="text-align: center;"><?php if(empty($_GET['ward_no'])){ echo "उपभोक्ता समिति  विवरण हेर्नुहोस"; }else{ echo "वडा नं ".convertedcit($_GET['ward_no'])." को उपभोक्ता समिति विवरण हेर्नुहोस ";} ?></td>
                                      </tr>
                                      <tr>
                                            <td class="myCenter"><strong>सि नं </strong></td>
                                            <td class="myCenter"><strong>दर्ता नं </strong></td>
                                            <td class="myCenter"><strong>योजनाको नाम </strong></td>
                                             <td class="myCenter"><strong>उपभोक्ता समितिको नाम </strong></td>
                                             <td class="myCenter"><strong>अनुदान रकम</strong></td>
                                            <td class="myCenter"><strong>उपभोक्ताबाट नगद साझेदारी</strong></td>
                                        </tr>
                                      <?php $i=1;while($data= mysqli_fetch_object($result)):
                                        $customer_result = Costumerassociationdetails0::find_by_plan_id($data->id);
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
                                            <td class="myCenter"><?=$data->costumer_agreement?></td>
                                         </tr>
                                       <?php $i++;endwhile;?>
                                  </table>  
                           		
                </div>
                  </div>
                </div><!-- main menu ends -->
         
    </div><!-- top wrap ends -->
    