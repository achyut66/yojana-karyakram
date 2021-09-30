<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user=getUser();
if(isset($_POST['search'])){
  if(!is_numeric($_POST['sn']))
        {
            $program_name= $_POST['sn'];
            $sql="select * from plan_details1 where program_name LIKE '%".$program_name."%'";
            $datas = Plandetails1::find_by_sql($sql);

        }
        else
        {
            $result= Plandetails1::find_by_id($_POST['sn']);
           if($result->type==1)
            {
                $result = "";
            }
        //print_r($result);exit;
        } if(!is_numeric($_POST['sn']))
        {
            $program_name= $_POST['sn'];
            $sql="select * from plan_details1 where program_name LIKE '%".$program_name."%'";
            $datas = Plandetails1::find_by_sql($sql);

        }
        else
        {
            $result= Plandetails1::find_by_id($_POST['sn']);
           if($result->type==1)
            {
                $result = "";
            }
        //print_r($result);exit;
        }
}

if(isset($_GET['id']))
{
  setPlanId($_GET['id']);
  redirect_to("estimate_dashboard_check.php");
}
$postnames=  Postname::find_all();
$units = Units::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<title>योजना खोज्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना खोज्नुहोस | <a href="estimate_dashboard.php"> पछि जानुहोस </a></h2>
           
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
                <h2>योजना खोज्नुहोस </h2>
                <div class="userprofiletable">
               
                      <form  method="post">
                      <form  method="post">
                      	<div class="inputWrap">
                        	<h1>योजना खोज्नुहोस </h1>
                            <div class="titleInput">योजनाको  नाम / दर्ता फाराम नं:</div>
                            <div class="newInput"><input type="text" name="sn" required/></div>
                            <div class="saveBtn myCenter"><input type="submit" name="search" value="खोज्नुहोस" class="btn"/></div>
                        </div><!-- input wrap ends -->
                        
                    </form>
                      <?php if(!empty($datas)):?>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th class="myCenter">सि नं </th>     
                            <th class="myCenter">दर्ता नं</th>
                            <th class="myCenter">योजना / कार्यक्रमको नाम </th>
                            <th class="myCenter">पुरा विवरण  </th>
                        </tr>
                        <?php $i=1;foreach($datas as $data):?>
                        <tr>
                            <td><?= convertedcit($i);?></td>
                            <td><?=convertedcit($data->id);?></td>
                            <td><?=$data->program_name?></td>
                            <td><a href="setestimate.php?id=<?=$data->id?>" class="btn">खोज्नुहोस </a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <?php endif;?>
                    </form>
              </div>
              <?php if(isset($_POST['search'])  || isset($_GET['id'])):?>
              	 <?php if(empty($result)){?>
                 		<h3>No Records Found</h3>
                 <?php } elseif($user->mode=="administrator"||$user->mode=="subadmin"||$user->mode=="superadmin") 
                                {
                                        setPlanId($result->id);
  					redirect_to("estimate_dashboard_check.php");  
                                }
                           elseif($user->mode=="user"& $user->ward==$result->ward_no)     
                                { 	
                                    setPlanId($result->id);
                                             redirect_to("estimate_dashboard_check.php");
                                }
                            else
                            {
                                ?>
                                
                                <h3>कृपया आफ्नो वार्ड को मात्र खोज्नुहोस आन्यथा सम्बन्धित निकायमा रिपोर्ट जानेछ !!!!!</h3>
                   
                   <?php } ?>
              <?php endif;?>
                
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>