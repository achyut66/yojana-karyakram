<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
	?>
  <?php
if(isset($_POST['submit']))
{       
   $data= Bankinformation::find_by_id($_POST['update_id']);
   $data->name=$_POST['name'];
   $data->address=$_POST['address'];
   if($data->save())
    {
        $session->message(" बैंक विवरण  थप सफल");
        redirect_to("view_bank_information.php");
    }
}
$data= Bankinformation::find_by_id($_GET['id']);

?>
<?php include("menuincludes/header.php");

?>
<!-- js ends -->
<title> बैंक विवरण सच्याउनुहोस्  </title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">  बैंक विवरण  सच्याउनुहोस् | <a href="view_bank_information.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	  <form method="post" enctype="multipart/form-data">
                              	<div class="inputWrap">
                                	<h1>बैंक विवरण सच्याउनुहोस् </h1>
                                    <div class="titleInput">बैंकको नाम : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="name" value="<?php echo $data->name;?>"></div>
                                    <div class="titleInput">बैंकको ठेगाना : </div>
                                    <div class="newInput"><input type="text" id="topictype_name" name="address" value="<?php echo $data->address;?>"></div>
                                    <div class="saveBtn myWidth100"><input type="submit" name="submit" value="सच्याउनु होस्" class="btn"></div>
                                    <input type="hidden" name="update_id" value="<?php echo $data->id?>"/>
                                	<div class="myspacer"></div>
                                </div><!-- title wrap ends -->
                               </form>
                                    
                                    

                        </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>