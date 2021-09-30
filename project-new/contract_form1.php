<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if(isset($_POST['submit']))
{
//    print_r($_POST);exit;
    if(!empty($_POST['create_id']))
    {
            $data = Contract_total_investment::find_by_id($_POST['create_id']);	
    }
    else
    {
            $data = new Contract_total_investment();
    }

    $_POST['created_date']=date("Y-m-d",time());
    if($data->savePostData($_POST))
    {
    $session->message("अपडेट सफल भयो ");
    redirect_to("contract_form2.php?id=".$_POST['plan_id']);
    }
}
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

$postnames=  Postname::find_all();
$units = Units::find_all();
 $sql="select * from enlist where type=0";
  $enlist=Enlist::find_by_sql($sql);
  $contract_info=  Contractinfo::find_by_plan_id($_GET['id']);
 
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
		<div class="">
    		<div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">ठेक्काको कुल लागत अनुमान | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
          
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
               
                <div class="userprofiletable">
                 <?php if(!isset($_GET['id'])){?>
                      <form  method="post">
                      <table class="table table-bordered">
                      	<tr>
                        	<td>योजनाको नाम:</td>
                            <td><input type="text" name="program"/></td>
                        </tr>
                        <tr>
                        	<td>दर्ता फाराम नं:</td>
                            <td><input type="text" name="sn"/> </td>
                        </tr>
                        <tr>
                        	<td>&nbsp; </td>
                            <td><input type="submit" name="search" value="खोज्नुहोस" class="btn"/></td>
                        </tr>
                       
                      
                       
                       </table>
                    </form>
             
                    
            <?php if(isset($_POST['search'])):?>
                    <table class="table table-bordered">
                        <tr>
                            <th>दर्ता फाराम नं</th>
                            <th>योजनाको नाम</th>
                        </tr>
                        <?php  foreach($results as $result):?>
                        <tr>
                            <td><?php echo $result->sn;?></td>
                            <td><a href="plan_form1.php?id=<?php echo $result->id;?>"><?php echo $result->program_name;?></a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <?php endif;?>
               <?php } else { ?>
                    <?php 
                    $bid_message="";
                    $data = Plandetails1::find_by_id($_GET['id']);
                    $contract_total= $data->investment_amount * 0.03;
                    $contract_total_investment= $data->investment_amount- $contract_total;
                    $contract_bid = Contractentryfinal::find_by_sql("select * from contract_entry_final where status=1 and plan_id=".$_GET['id']." limit 1");
                   
                    $contract_result=  array_shift($contract_bid);
//                    print_r($contract_result);exit;
                               if(empty($contract_result->total_bid_amount))
                               {
                                   $bid_amount=0;
                                  echo alertBox("ठेक्का कबोल गर्नुहोस्","contract_invitation_bid_form_view.php");
                                  
                               }
                               else
                               {
                                   $bid_amount=$contract_result->total_bid_amount;
                               }
                               if(empty($contract_result->contractor_id))
                               {
                                   $name="";
                               }
                               else
                               {
                                    $result= Contractordetails::find_by_id($contract_result->contractor_id);
                                   $name= $result->contractor_name;
//                                   echo $name;exit;
                               }
 ?>
                    <?php $invest_details =  Contract_total_investment::find_by_plan_id($_GET['id']); 
                         if(empty($invest_details))
                          {
                            $invest_details = Contract_total_investment::setEmptyObjects(); 
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस"; 

                    ?>
                     <div>
                            <h3><?php echo $data->program_name; ?></h3>
                            <form method="post" enctype="multipart/form_data" >
                             <h3>ठेक्काको कुल लागत अनुमान</h3>
                        <table class="table table-bordered">
                          <tr>
                            <th scope="row">भौतिक परिणाम</th>
                            <td >  <input type="text" required name="unit_total" value="<?=$invest_details->unit_total?>" />
                                
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">भौतिक ईकाई</th>
                            <td > <select name="unit_id">
                                    <option value="">--छान्नुहोस् --</option>
                                    <?php foreach($units as $unit): 
                                                        print_r($unit);?>
                                      <option value="<?=$unit->id?>" <?php if($invest_details->unit_id==$unit->id){ ?> selected="selected" <?php } ?> ><?=$unit->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                          </tr>
                          
                          <tr>
                            <th width="176" scope="row">गाँउपालिकाबाट अनुदान</th>
                            <td width="176"><input type="text" readonly="true"  name="agreement_gaupalika"  value="<?=$data->investment_amount?>" /></td>
                          </tr>
                          
                          <tr>
                            <th scope="row">कुल ठेक्का रकम जम्मा </th>
                            <td><input type="text" name="total_investment" readonly="true"  id="contract_total_investment" value="<?=$contract_info->contract_amount;?>"/></td>
                          </tr>
                         <tr>
                            <th scope="row">ठेक्का कबोल गरेको कुल रकम </th>
                            <td><input type="text"  name="contract_total_amount" id="contract_total_amount" value="<?=$bid_amount?>"/></td><span style="color:red;"><?php echo $bid_message;?></span>
                          </tr>
                           <tr>
                            <th scope="row">कार्यदेश दिएको  रकम</th>
                            <td><input type="text"  name="bhuktani_anudan" readonly="true" id="contract_bhuktani_anudan" value="<?=$bid_amount?>"/></td>
                          </tr>
                             <th scope="row">योजना संचालन गर्ने फर्म/कम्पनी</th>
                             <td>
                                 <select name="contractor_id">
                                     <option value="<?php echo $contract_result->contractor_id;?>"><?php echo $name;?></option>
                                 </select>
                             </td>
                          </tr>
                                     
                        </table>
                        <div class="myspacer"></div>
                        <input type="hidden" name="create_id" value="<?=$invest_details->id?>" class="btn"/>
                        <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" class="btn"/>
                         <input type="submit" name="submit" value="<?=$value?>" class="btn">
                                          
 </form>
               <?php } ?>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>