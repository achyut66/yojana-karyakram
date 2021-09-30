<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user=getUser();
if(isset($_POST['search'])){
if(!is_numeric($_POST['sn']))
{
    echo alertBox("कृपया नम्बर हल्नुहोस ","amanat_setid.php");
}
 $result= Plandetails1::find_by_id($_POST['sn']);
 $check_customer = Contractinfo::find_by_plan_id($_POST['sn']);
 $first_check= Samitiplantotalinvestment::find_by_plan_id($_POST['sn']);
 $upobhokta_samiti = Plantotalinvestment::find_by_plan_id($_POST['sn']);
  if($result->type==1)
{
    echo alertBox("निम्न दर्ता नं कार्यक्रम अन्तर्गत भएकाले यसलाई कार्यक्रम संचालन प्रकिया बाट चलाउनुहोस","amanat_setid.php");
}
 if(empty($result))
{
    echo alertBox("निम्न दर्ता नं भेटिएन ..","amanat_setid.php");
}
 

 if($result->type==1 || !empty($check_customer) || !empty($first_check) || !empty($upobhokta_samiti))
 {
     $result = "";
 }
//print_r($result);exit;
}

if(isset($_GET['id']))
{
  setPlanId($_GET['id']);
  redirect_to("amanatdashboard.php");
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
            <h2 class="headinguserprofile">अमनात मार्फत योजना खोज्नुहोस | <a href="yojanasanchalandash.php" class="btn">पछि जानुहोस</a></h2>
            <div class="OurContentFull">
				<div class="myMessage"><?php echo $message;?></div>
                
                <div class="userprofiletable">
               
                      <form  method="post">
                      	<div class="inputWrap">
                        	<h1>योजना खोज्नुहोस </h1>
                            <div class="titleInput">योजना दर्ता फाराम नं:</div>
                            <div class="newInput">
                                <input type="text" class= "checkInput" id="sn" name="sn" required/></div>
                            <div class="saveBtn myCenter">
                            <div type="newInput">
                            <input type="button" id="edit_btn" class="button btn-success" value="सच्याउनुहोस" />
                                <input type="submit" name="search" value="खोज्नुहोस" class="button btn-primary" /></div>
                        </div><!-- input wrap ends -->
                        
                    </form>
              </div>
              <?php if(isset($_POST['search'])):?>
              	 <?php if(empty($result)){?>
                 		<h3>No Records Found</h3>
                 <?php } elseif($user->mode=="administrator"||$user->mode=="subadmin"||$user->mode=="superadmin") 
                                {
                                        setPlanId($result->id);
  					redirect_to("amanatdashboard.php");  
                                }
                           elseif($user->mode=="user"& $user->ward==$result->ward_no)     
                                { 	
                                    setPlanId($result->id);
                                             redirect_to("amanatdashboard.php");
                                }
                                elseif($result->topic_area_id==$user->topic_area_id && $result->topic_area_type_id==$user->topic_area_type_id)
                                {
                                    setPlanId($result->id);
                                    redirect_to("amanatdashboard.php");
                                }
                            else
                            {
                                ?>
                                
                                <h1>कृपया आफ्नो वार्ड को मात्र खोज्नुहोस आन्यथा सम्बन्धित निकायमा रिपोर्ट जानेछ !!!!!</h1>
                   
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
                         //alert(id);
                       window.location = 'plan_form_edit.php?id='+id;
                        
                    }
                    // else
                    // {
                    //     window.location = 'amanatdashboard.php';
                    // }
            });
        });
    </script>