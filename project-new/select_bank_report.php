<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!checkAccess("administrator"))
{
    $session->message("Undefined Access !!");
    redirect_to("index.php");
}
?>
<?php
$datas=  Bankinformation::find_all();
if(isset($_POST['submit'])){
    redirect_to("print_bank_report01.php?id=".$_POST['bank_id']);
}
?>

<?php include("menuincludes/header.php"); ?>
<title>नया योजना विवरण दर्ता फाराम :: <?php echo SITE_SUBHEADING;?></title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">नया योजना विवरण दर्ता फाराम / <a href="index.php">Go Back</a></h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/planformmenu.php");?>
            </div>	
            
               
            <div class="OurContentRight">
					<div class="myMessage"> <?php echo $message;?></div>
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                 <form method="post" enctype="multipart/form_data" >
                     बैंकको नाम:<br>
                     <select name="bank_id">
                         <option value="">select</option>
                         <?php foreach($datas as $data):?>
                         <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                         <?php endforeach;?>
                     </select><br>
                                        
                     <input type="submit" name="submit" value="SELECT" class="submithere"/>

                    </form>


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>