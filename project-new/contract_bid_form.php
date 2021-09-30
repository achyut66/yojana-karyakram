<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if(isset($_POST['submit']))
{
    $data = new Contract_bid();
    $data->status=0;
    $data->enlist_id = $_POST['enlist_id'];
    $data->bid_amount = $_POST['bid_amount'];
    $data->plan_id=$_POST['plan_id'];
    if($data->save())
    {
    $session->message("अपडेट सफल भयो ");
    redirect_to("contract_bid_form_view.php");
    }
}
//$datas=  Plandetails1::find_by_plan_id($_GET['id']);
$postnames=  Postname::find_all();
$units = Units::find_all();
 $sql="select * from enlist where type=0";
  $enlist=Enlist::find_by_sql($sql);
    
//print_r($units);exit;
?>

<?php include("menuincludes/header.php"); ?>
<title>ठेक्का बोलिने फारम  :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
		<div class="">
    		<div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">ठेक्का बोलिने फारम </h2>
           
            <div class="OurContentFull">
					<div class="myMessage"><?php echo $message;?></div>
               
                <div class="userprofiletable">
                 
                    <?php $data = Plandetails1::find_by_id($_GET['id']);
                

                    ?>
                     <div>
                         <h3><?php echo $data->program_name;?></h3>
                            <form method="post" enctype="multipart/form_data" >
                                
                             <h3>ठेक्का बोलिने फारम </h3>
                           <table class="table table-bordered">
                            <tr>
                          <th scope="row">योजना संचालन गर्ने फर्म/कम्पनी</th>
                                        <td>  
                                            <select required name='enlist_id'>
                                            <option value=''>--छान्नुहोस् --</option>";
                                            <?php foreach($enlist as $datas):?>
                                            <option value="<?php echo $datas->id;?>"<?php if($invest_details->enlist_id==$datas->id){ echo 'selected="selected"';}?>><?php echo $datas->name0;?></option>
                                            <?php endforeach;?>
                                      </select>
                                        </td>
                             </tr>
                             <tr>
                                 <th width="176" scope="row"><?php echo SITE_TYPE;?>बाट अनुदान</th>
                                 <td width="176"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                          </tr>
                            <tr>
                                <th scope="row">ठेक्का कबोल गरेको कुल रकम </th>
                                <td><input required type="text" name="bid_amount"</td>
                           </tr>
                          
                                  
                        </table>
                        <div class="myspacer"></div>
                        
                        <input type="hidden" name="plan_id" value="<?=$_GET['id']?>" />
                         <input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere">
                                          
 </form>
          

                </div> 
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>