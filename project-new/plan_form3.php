<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(isset($_POST['submit']))
{
          //योजना संचालनमा उपभोक्ता समितिको नाममा बैक खाता नभएमा     
        $data5= new Bankdetails();
        $data5->bank_name=$_POST['bank_name'];
        $data5->bank_address=$_POST['bank_address'];
        $data5->costumer_name=$_POST['costumer_name'];
        $data5->costumer_address=$_POST['costumer_address'];
        $data5->authority1=$_POST['authority1'];
        $data5->authority3=$_POST['authority3'];
        $data5->authority2=$_POST['authority2'];
        $data5->plan_id=$_POST['plan_id'];
        $data5->save();

}
if(isset($_POST['search'])){
 if(empty($_POST['sn'])) {  
    $sql="select * from plan_details1 where program_name LIKE '%".$_POST['program']."%'";
 }
 else
 {
     $sql="select * from plan_details1 where sn='".$_POST['sn']."'";
    
 }
 $results= Plandetails1::find_by_sql($sql);

//print_r($result);exit;
}
$bank_details= Bankinformation::find_all();
//print_r($bank_details);exit;
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">योजना विवरण दर्ता फाराम</h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
                <?php echo $message;?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php if(!isset($_GET['id'])){?>
                      <form  method="post">
                      योजनाको नाम:<input type="text" name="program"/>
                      दर्ता फाराम नं:<input type="text" name="sn"/>
                       <input type="submit" name="search" value="SEARCH"/>
                    </form>
             
                    
            <?php if(isset($_POST['search'])):?>
                    <table border="2">
                        <tr>
                            <th>दर्ता फाराम नं</th>
                            <th>योजनाको नाम</th>
                        </tr>
                        <?php  foreach($results as $result):?>
                        <tr>
                            <td><?php echo $result->sn;?></td>
                            <td><a href="plan_form3.php?id=<?php echo $result->id;?>"><?php echo $result->program_name;?></a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <?php endif;?>
               <?php } else {?>
                    <?php $data=  Plandetails1::find_by_id($_GET['id']);?>
                     <div>
                            <form method="post" enctype="multipart/form_data" >
                                 <h3>योजना संचालनमा उपभोक्ता समितिको नाममा बैक खाता नभएमा </h3>
                                <tr>
                                    <td>योजनाको नाम</td>
                                    <td> <input type="text" name="program_name" value="<?php echo $data->program_name; ?>"/></td>
                                </tr>
                                <input type="hidden" name="plan_id" value="<?php echo $_GET['id'];?>"/>
                                   <tr>
                                <table class="table table-bordered">
                                  <tr>
                                    <td width="167">बैंकको नाम</td>
                                    <td width="171">
                                        <select name="bank_name">
                                            <option value="">छान्नुस</option>
                                             <?php foreach($bank_details as $data): ?>
                                             <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                                             <?php endforeach;?>
                                        </select></td>
                                  </tr>
                                  <tr>
                                    <td>बैंकको ठेगाना</td>
                                    <td>
                                        <select name="bank_address">
                                            <option value="">छान्नुस</option>
                                             <?php foreach($bank_details as $data): ?>
                                             <option value="<?=$data->id?>"><?=$data->address?></option>
                                             <?php endforeach;?>
                                        </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>उपभोक्ताको नाम</td>
                                    <td><input type="text" name="costumer_name"/></td>
                                  </tr>
                                  <tr>
                                    <td>ठेगाना</td>
                                    <td><input type="text" name="costumer_address"/></td>
                                  </tr>
                                  <tr>
                                    <td>खाता संचालकहरुको नाम</td>
                                    <td><input type="text" name="authority1" placeholder="अध्यक्ष"/>
                                   <input type="text" name="authority2" placeholder="सचिब"/>
                                    <input type="text" name="authority3" placeholder="कोषाध्यक्ष"/></td>
                                  </tr>
                                </table></br></br>
                             
                        <input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere">
                                          
 </form>

               <?php }?>
                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>