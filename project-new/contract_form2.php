<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if(isset($_POST['submit']))
{   
    if(!empty($_POST['create_id']))
    {
        $result= Contractmoredetails::find_by_id($_POST['create_id']);
    }
    else
    {
        $result=  new Contractmoredetails(); 
    }
        $result->completion_date_english= DateNepToEng($_POST['completion_date']);
        $result->start_date_english= DateNepToEng($_POST['start_date']);
        $result->post_id_3=$_POST['post_id_3'];
    if($result->savePostData($_POST))
    {
     $session->message("अपडेट सफल भयो ");
    redirect_to("contract_letter_dashboard.php?id=".$_POST['plan_id']);
    }
}
?>
<?php
$data=  Contract_total_investment::find_by_plan_id($_GET['id']);//print_r($data);
$postnames=  Workerdetails::find_by_sql("select * from worker_details where status=1");
//print_r($data);
$data1= Plandetails1::find_by_id($_GET['id']);
?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>ठेक्का संचालन विवरण :: <?php echo SITE_SUBHEADING;?></title>
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
</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम संचालन विवरण  | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                    
                <div class="OurContentFull">
                    <div class="userprofiletable">
                    <h3><?php echo $data1->program_name;?> :: <?="विनियोजित बजेट रु ".convertedcit(placeholder($data1->investment_amount))?></h3>
            <?php $invest_details = Contractmoredetails::find_by_plan_id($_GET['id']); //print_r($invest_details);
                         if(empty($invest_details))
                          {
                            $invest_details = Contractmoredetails::setEmptyObjects(); 
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस"; 

                    ?>
                            
                        <div>
                            <h3>ठेक्का संचालन विवरण भर्नुहोस्  </h3>
                                 
                                 <form method="post">
                                 <table class="table table-bordered" >
                                     
                                    <tr>
                                        <td width="238">योजनाको विनियोजित बजेट रु</td>
                                        <td><input type="text" readonly="true" id="total_budget" name="budget" value="<?php echo $data->agreement_gaupalika;?>" ></td>
                                    </tr>

                                    <tr>
                                        <td width="238">कार्यादेश दिने निर्णय भएको मिति</td>
                                        <td><input type="text" id="nepaliDate9" name="work_order_date" value="<?php echo $invest_details->work_order_date;?>" ></td>
                                    </tr>
                                    
                                    <tr>                                            
                                        <td width="238">कार्यादेश दिईएको रकम रु</td>
                                        <td><input type="text" id="work_budget" name="work_order_budget" value="<?php echo $invest_details->work_order_budget;?>" ></td>
                                    </tr>
                                     
                                    <tr>                                           
                                        <td width="238">योजनाको शुरु हुने मिति</td>
                                        <td><input type="text" id="nepaliDate3" value="<?php echo $invest_details->start_date;?>"  name="start_date" ></td>
                                    </tr>
                                    
                                    <tr>                                         
                                        <td width="238">योजना सम्पन्न हुने मिति</td>
                                        <td><input type="text" id="nepaliDate5" name="completion_date" value="<?php echo $invest_details->completion_date;?>"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="238">योजना संचालन हुने स्थान</td>
                                        <td><input type="text" id="topictype_name" name="venue"  value="<?php echo $invest_details->venue;?>"></td>
                                    </tr>
                                    <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                     <td>
                                         <select name="samjhauta_party" required id="authority_name" >
                                             <option value="">छान्नुस</option>
                                             <?php foreach($postnames as $name): ?>
                                           <option value="<?=$name->id?>" <?php if($invest_details->samjhauta_party == $name->id){ echo "selected='selected'";  } ?>><?=$name->authority_name?></option>
                                             <?php endforeach;?>
                                            </select>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                   <td><input id="authority_post" type="text" name="post_id_3"  required value="<?php echo $invest_details->post_id_3;?>"/></td>
                                  </tr>
                                    <tr>
                                    <td>मिती</td>
                                    <td><input type="text" name="miti"  required  id="nepaliDate15" value="<?php echo $invest_details->miti;?>"/></td>
                                  </tr>
                                </table>
                                
                                
                         <h3>कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3> 
                               <table class="table table-bordered ">
                                <tr>
                                	
                                    <th class="text-center">घर परिवार संख्या</th>
                                  <th class="text-center">महिला</th>
                                  <th class="text-center">पुरुष</th>
                                  <th class="text-center">जम्मा</th>
                                </tr>
                                
                                 
                                  <tr>
                                  <td><input type="text" class="row1-family input100percent" name="total_family_members" value="<?php echo $invest_details->total_family_members;?>"/></td>
                                  <td><input type="text" class="row2"  name="female" value="<?php echo $invest_details->female;?>"/></td>
                                  <td><input type="text" class="row2"    name="male"  value="<?php echo $invest_details->male;?>"/></td>
                                  <td><input type="text" id="row2-value" class="input100percent" name="total_members" value="<?php echo $invest_details->total_members;?>"/></td>
                                  </tr>               
                                             
                               </table>
                           <table class="table table-bordered">    
                                    <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" id="submit1" name="submit" value="<?=$value?>" class="btn"></td>
                                        <td><input type="hidden" id="" name="plan_id" value="<?php echo $data->plan_id;?>" class="btn"></td>
                                         <td><input type="hidden" id="" name="create_id" value="<?php echo $invest_details->id;?>" class="btn"></td>
                                      
                                    </tr>
                                </table>
                                 </form> 
                                 
                          

                                 </div> 
                   
                        </div>
                    </div>
                </div><!-- main menu ends -->
            </div>
        </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>