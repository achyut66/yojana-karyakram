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
 $check_customer = Contractinfo::find_by_plan_id($_POST['sn']);
 $first_check= Samitiplantotalinvestment::find_by_plan_id($_POST['sn']);
$amanat = AmanatLagat::find_by_plan_id($_POST['sn']);
if($result->type==1)
{
    echo alertBox("निम्न दर्ता नं कार्यक्रम अन्तर्गत भएकाले यसलाई कार्यक्रम संचालन प्रकिया बाट चलाउनुहोस","setid.php");
}
if(empty($result))
{
    echo alertBox("निम्न दर्ता नं भेटिएन ..","setid.php");
}
//if($result)
 

 if($result->type==1 || !empty($check_customer) || !empty($first_check) || !empty($amanat))
 {
     $result = "";
 }
//print_r($result);exit;
}
}

if(isset($_GET['id']))
{
  setPlanId($_GET['id']);
  redirect_to("upabhoktasamitidashboard.php");
}
$postnames=  Postname::find_all();
$units = Units::find_all();
?>

<?php include("menuincludes/header.php"); ?>
<title>योजना खोज्नुहोस :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">उपभोक्ता समिति मार्फत योजना खोज्नुहोस | <a href="yojanasanchalandash.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
                
                <div class="userprofiletable">
               
                      <form  method="post">
                      	<div class="inputWrap">
                        	<h1>योजना खोज्नुहोस </h1>
                            <div class="titleInput">योजनाको  नाम / दर्ता फाराम नं:</div>
                            <div class="newInput">
                                <input type="text" name="sn" id="sn" required/></div>
                            <div class="newInput">
                            <input type="button" id="edit_btn" value="सच्याउनुहोस" class="button btn-success"/>
                                <input type="submit" name="search" value="खोज्नुहोस" class="button btn-primary"/></div>
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
                            <td><a href="setid.php?id=<?=$data->id?>" class="btn">खोज्नुहोस </a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <?php endif;?>
              </div>
              <?php if(isset($_POST['search']) || isset($_GET['id'])):
                  if(empty($_GET['id']))
                  {
                      $id= $result->id;
                  }
                  else
                  {
                      $id= $_GET['id'];
                  }
                  ?>
              	 <?php if(empty($result)){?>
                 		<h3>No Records Found</h3>
                 <?php } elseif($user->mode=="administrator"||$user->mode=="subadmin"||$user->mode=="superadmin") 
                                {
                                        setPlanId($id);
  					redirect_to("upabhoktasamitidashboard.php");  
                                }
                           elseif($user->mode=="user"& $user->ward==$result->ward_no)     
                                { 	
                                    setPlanId($id);
                                    redirect_to("upabhoktasamitidashboard.php");
                                }
                                  elseif($user->mode=="section" & $result->topic_area_id==$user->topic_area_id & $result->topic_area_type_id==$user->topic_area_type_id)
                                {
                                    setPlanId($id);
                                    redirect_to("upabhoktasamitidashboard.php");
                                }
                            else
                            {
                                ?>
                                <h3 style="color: red">कृपया आफ्नो वार्ड को मात्र खोज्नुहोस आन्यथा सम्बन्धित निकायमा रिपोर्ट जानेछ !!!!!</h3>
                   <?php } ?>
              <?php endif;?>
                
                  </div>
                </div><!-- main menu ends -->
             
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script>
        JQ(document).ready(function(){
             JQ(document).on("click","#edit_btn",function() {
                 if (window.confirm('योजना / कार्यक्रम बिबरण सम्पादन गर्नु पर्छ ??'))
                    {
                       var id = JQ("#sn").val();
                       window.location = 'plan_form_edit.php?id='+id;
                        
                    }
                    // else
                    // {
                    //     window.location = 'upabhoktasamitidashboard.php';
                    // }
            });
        });
    </script>
   