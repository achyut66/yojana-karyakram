<?php require_once("includes/initialize.php"); 
	if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
  <?php
if(isset($_POST['submit']))
{       
   $data= Workerdetails::find_by_id($_POST['update_id']);
   $data->post_name=$_POST['post_name'];
   $data->authority_name=$_POST['authority_name'];
   $data->authority_ward_no=$_POST['authority_ward_no'];
   $data->status=$_POST['status'];
   if($data->save())
    {
        $session->message(" विवरण  थप सफल");
        redirect_to("view_worker_details.php");
    }
}
$data= Workerdetails::find_by_id($_GET['id']);

?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title> कार्यकारी व्यक्ति विवरण :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="maincontent">
                    <h2 class="headinguserprofile">कार्यकारी व्यक्ति विवरण | <a href="view_worker_details.php" class="btn">पछि जानुहोस</a> </h2>
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	 <form method="post" enctype="multipart/form-data">
                             		<div class="inputWrap">
                                    	<h1>कार्यकारी व्यक्ति विवरण  सच्याउनुहोस् </h1>
                                        <div class="titleInput">पदको नाम : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="post_name" value="<?php echo $data->post_name;?>"></div>
                                        <div class="titleInput">आधिकारिक व्यक्ति : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="authority_name" value="<?php echo $data->authority_name;?>"></div>
                                        <div class="titleInput">वार्ड नं : </div>
                                        <div class="newInput"><input type="text" id="topictype_name" name="authority_ward_no" value="<?php echo $data->authority_ward_no;?>" required ></div>
                                        <div class="titleInput">कार्य अवधि : </div>
                                        <div class="newInput">ACTIVE : <input type="radio" name="status" value="1" <?php if($data->status==='1'){ echo "checked='checked'";}?>> &nbsp&nbsp INACTIVE : <input type="radio" name="status" value="0"<?php if($data->status==='0'){ echo "checked='checked'";}?>></div>
                                        <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                                        <input type ="hidden" name="update_id" value="<?php echo $data->id;?>"/>
                                    	<div class="myspacer"></div>
                                    </div><!-- input wrap ends -->
                            </form>
                      </div>
                </div>
          </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>