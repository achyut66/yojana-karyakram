<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
if(isset($_POST['submit']))
{
    if(!empty($_POST['create_id'])&& !empty($_POST['update_id'])&& !empty($_POST['material_update_id']))
    {
        $data=  Estimateanudandetails::find_by_id($_POST['create_id']);
        $result=  Estimateotheragreement::find_by_id($_POST['update_id']);
        $material=  Materialanudan::find_by_id($_POST['material_update_id']);
    }
    else
    {
         $data=  new Estimateanudandetails();
          $result=new Estimateotheragreement();
          $material=new Materialanudan();
    }
   
    $data->investment_amount=$_POST['investment_amount'];
    $data->other_source=$_POST['other_source'];
    $data->samiti_investment=$_POST['samiti_investment'];
    $data->other_agreement=$_POST['other_agreement'];
    $data->total_investment=$_POST['total_investment'];
    $data->plan_id=$_POST['plan_id'];
    $data->save();
   if(isset($_POST['check_detail']))
   {
        $result->total_investment_amount=$_POST['total_investment_amount'];
        $result->other_investment=$_POST['other_investment'];
        $result->total_amount=$_POST['total_amount'];
        $result->plan_id=$_POST['plan_id'];
        $result->save();
   }
   if(isset($_POST['check']))
   {
       $material->external_source=$_POST['external_source'];
       $material->state_gov=$_POST['state_gov'];
       $material->local_level=$_POST['local_level'];
       $material->sub_gov =$_POST['sub_gov'];
       $material->foreign_gov =$_POST['foreign_gov'];
       $material->other_nikaya =$_POST['other_nikaya'];
       $material->plan_id =$_POST['plan_id'];
       $material->save();
   }
}
$data1=Plandetails1::find_by_id($_GET['id']);
$invest_details = Estimateanudandetails::find_by_plan_id($_GET['id']); 
                         if(empty($invest_details))
                          {
                            $invest_details = Estimateanudandetails::setEmptyObjects(); 
                          }
                          $details=  Estimateotheragreement::find_by_plan_id($_GET['id']);
                             if(empty($details))
                          {
                            $details = Estimateotheragreement::setEmptyObjects(); 
                          }
                          $material_details= Materialanudan::find_by_plan_id($_GET['id']);
                             if(empty($material_details))
                          {
                            $material_details = Materialanudan::setEmptyObjects(); 
                          }
                          !empty($invest_details->id) && !empty($details->id) && !empty($material_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस";
?>
<?php include("menuincludes/header.php"); ?>
<title>अनुदान सम्बन्धी विवरण भर्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
	
        <div class="maincontent">
            <h2 class="headinguserprofile">अनुदान सम्बन्धी विवरण | <a href="estimatedashboard.php" class="btn">पछि जानुहोस </a></h2>
          
                
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
                 <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?></h1>
                <div class="userprofiletable">
               
                    <?php $data = Plandetails1::find_by_id($_GET['id']);?>
                   
                     <div>
                            <h3><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                            <h3>अनुदान सम्बन्धी विवरण भर्नुहोस</h3>
                       <table class="table table-bordered" >
                            <tr>
                              <td><?php echo SITE_TYPE;?>बाट अनुदान रकम :</td>
                              <td><input type="text" readonly="true" id="investment_amount" name="investment_amount" value="<?php echo $data1->investment_amount;?>"></td>
                            </tr>
                            <tr>
                              <td>अन्य निकायबाट प्राप्त निकाशा अनुदान रकम :</td>
                              <td><input type="text" id="other_source" name="other_source" value="<?=$invest_details->other_source?>"></td>
                            </tr>
                            <tr>
                              <td>समितिबाट नगद साझेदारी <?php echo SITE_TYPE;?>मा जम्मा गरेको    रकम :</td>
                              <td><input type="text" id="samiti_investment" name="samiti_investment" value="<?=$invest_details->samiti_investment?>"></td>
                            </tr>
                            <tr>
                              <td>अन्य साझेदारी निकासा रकम :</td>
                              <td><input type="text" id="other_agreements" name="other_agreement" value="<?=$invest_details->other_agreement?>"></td>
                            </tr>
                            <tr>
                              <td> जम्मा अनुदान रकम :</td>
                              <td><input type="text" readonly="true" id="total_investment" name="total_investment" value="<?=$invest_details->total_investment?>"></td>
                            </tr>
                            <br>
                             <tr>
                                 <td> <b>अन्य साझेदरी सम्बन्धी विवरण भएमा भर्नुहोस :<b></td>
                              <td><input type="checkbox"  id="check_details" name="check_detail" value="yes"></td>
                            </tr>
                            <tbody id="check_detail_div" style="display:none;">
                             <tr>
                              <td>जम्मा अनुदान रकम :</td>
                              <td><input type="text" id="total_investment_amount" name="total_investment_amount" value="<?=$details->total_investment_amount?>"></td>
                            </tr>
                            <tr>
                              <td>अन्य साझेदारी संस्थाबाट समितिमा प्राप्त हुने रकम    :</td>
                              <td><input type="text" id="other_investment" name="other_investment" value="<?=$details->other_investment?>"></td>
                            </tr>
                            <tr>
                              <td>कुल जम्मा</td>
                              <td><input type="text" readonly="true" id="total_amount" name="total_amount"value="<?=$details->total_amount?>"></td>
                            </tr>
                            </tbody>
                              <tr>
                                 <td> <b>बस्तुगत अनुदान सम्बन्धी विवरण भएमा भर्नुहोस :<b></td>
                              <td><input type="checkbox"  id="check" name="check" value="yes"></td>
                            </tr>
                            <tbody id="check_div" style="display:none;">
                                <tr>
                                          <td>संघ बाट:</td>
                                          <td><input type="text" id="" name="external_source" value="<?php echo $material_details->external_source;?>"></td>
                                        </tr>
                                        <tr>
                                          <td>प्रदेश बाट:</td>
                                          <td><input type="text" id="" name="state_gov" value="<?php echo $material_details->state_gov;?>"></td>
                                        </tr>
                                        <tr>
                                          <td>स्थनीय तहबाट</td>
                                          <td><input type="text"  id="" name="local_level" value="<?php echo $material_details->local_level;?>"></td>
                                        </tr>
                                        <tr>
                                          <td>गैर सहकारी संघसंस्थाबाट</td>
                                          <td><input type="text"   name="sub_gov" value="<?php echo $material_details->sub_gov;?>"></td>
                                        </tr>
                                        <tr>
                                          <td>विदेशी दातृ संघसंस्थाबाट</td>
                                          <td><input type="text"  id="" name="foreign_gov" value="<?php echo $material_details->foreign_gov;?>"></td>
                                        </tr>
                                         <tr>
                                          <td>अन्य निकायबाट </td>
                                          <td><input type="text"   name="other_nikaya" value="<?php echo $material_details->other_nikaya;?>"></td>
                                        </tr>
                            </tbody>
                       </table>
                           
                            </div>
                            
                            <input type="hidden" name="create_id" value="<?=$invest_details->id?>" />
                             <input type="hidden" name="update_id" value="<?=$details->id?>" />
                             <input type="hidden" name="material_update_id" value="<?=$material_details->id?>" />
                            <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>">
                           <input type="submit" name="submit" value="<?=$value?>" class="btn">
                                          
 </form>
                       </div>
                 </div>
           </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>