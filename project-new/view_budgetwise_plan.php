<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$datas = Plandetails1::find_all();
$budget_id="";
$fiscal_id="";

if(isset($_POST['submit']))
{   
    
    $sql = "select * from plan_details1 ";
    $budget_id=$_POST['budget_id'];
    
    $fiscal_id=$_POST['fiscal_id'];
    
    if(empty($_POST['id']))
    {
        if(!empty($budget_id))
        {
            $sql .=" where budget_id='".$budget_id."' ";
            
        }
        $sql.="and fiscal_id=".$fiscal_id;
    }
//  echo $sql;exit;
    //$sql="select * from plan_details1 where topic_area_id='".$_GET['topic_area_id']."' and topic_area_investment_id='".$_GET['topic_area_investment_id']."'or id='".$_GET['search_text']."' ";
    $datas = Plandetails1::find_by_sql($sql);
   //$budget_result=  Topicbudgetprofile::find_by_id($budget_id);
   $fiscal_result=  Fiscalyear::find_by_id($fiscal_id);
  $budge_name=  Topicbudget::find_by_id($budget_id);
    
}
//echo count($datas);exit;
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
$budget_result=Topicbudget::find_all();
?>
<?php include("menuincludes/header.php"); ?>
<style>
  <style>
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
  }
  .borderless table {
    border-top-style: none;
    border-left-style: none;
    border-right-style: none;
    border-bottom-style: none;
}
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>
</style>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
            <h2 class="headinguserprofile">बजेट शिर्षक अनुसार योजना/कार्यक्रम हेर्नुहोस | <a href="view_plan_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <div class="userprofiletable">
				  
                                  <form method="post">
                                      
		<table class="table table-bordered table-hover">
                    <tr>            
                                <td class="myCenter"> आर्थिक वर्ष :</td>
                                  <td class="myCenter">
                                      <select name="fiscal_id" class="form-control">
                                          <option value="">--छान्नुहोस्--</option>
                                          <?php foreach($fiscals as $data):?>
                                          <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php } ?>><?php echo convertedcit($data->year);?></option>
                                          <?php endforeach;?>
                                      </select>
                              </td>
                              
                               <td class="myCenter">बजेट उपशिर्षक :</td>
                                <td class="myCenter">
                                    <select required name="budget_id" class="form-control">
                                        <option value="">--छान्नुहोस्--</option>
                                        <?php foreach($budget_result as $data):?>
                                        <option value="<?php echo $data->id;?>" <?php if($data->id==$budget_id){?>selected="selected"<?php }?>><?php echo $data->name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </td>
                                <td class="myCenter"><input type="submit" name="submit" value="खोज्नुहोस" class="button btn-success" /></td>
                                <td class="myCenter"><a href="view_budgetwise_plan.php"><input type="button" class="btn-danger" value="रद्द गर्नुहोस" /> </a></td>
                    </tr>
                             
                         </table>   
					</form>
					
            <?php if(isset($_POST['submit'])){ ?>
                              <div class="myPrint"><a target="_blank" href="print_budgetwise_plan.php?budget_id=<?php echo $budget_id;?>&fiscal_id=<?php echo $fiscal_id;?>">प्रिन्ट गर्नुहोस</a></div><br><br>           
               <div class="printPage">
		  <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
		        <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1">कार्यक्रम / योजना बजेट उप शीर्षक अनुसार बिनियोजन</h5>
                          <div class="myspacer"></div>
                          <div class="printContent">आर्थिक वर्ष : <?= convertedcit($fiscal_result->year);?>  <br>  बजेट उप शीर्षक :<b><?= $budge_name->name;?></div>
                     <table class="table table-bordered table-responsive">
                       
                            <tr>
                              <th rowspan="2" class="myCenter">सि.नं.</th>
                              <th rowspan="2" class="myCenter">दर्ता नं</th>
                              <th rowspan="2" class="myCenter">कार्यक्रम/आयोजनाको नाम</th>
                              <th rowspan="2" class="myCenter">ठेगाना</th>
                              <th rowspan="2" class="myCenter">क्षेत्र</th>
                              <th rowspan="2" class="myCenter">उपक्षेत्र</th>
                              <th colspan="4" class="myCenter">विनियोजन रु.</th>
                              <th rowspan="2" class="myCenter">कैफियत</th>
                            </tr>
                            <tr>
                              <th class="myCenter">प्रथम चौमासिक</th>
                              <th class="myCenter">दोश्रो चौमासिक</th>
                              <th class="myCenter">तेस्रो चौमासिक</th>
                              <th class="myCenter">जम्मा अनुदान</th>
                            </tr>
                            <?php
                            $first_total=0;
                            $second_total=0;
                            $third_total=0;
                            $total=0;
                            $i=1;foreach($datas as $data):
                                $total_amount= $data->first + $data->second + $data->third;?>
                            <tr>
                              <td><?php echo convertedcit($i);?></td>
                              <td><?php echo convertedcit($data->id);?></td>
                              <td><?php echo convertedcit($data->program_name);?></td>
                              <td><?php echo SITE_LOCATION;?>-<?php echo convertedcit($data->ward_no);?></td>
                              <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                              <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                              <td><?php echo convertedcit(placeholder($data->first));?></td>
                              <td><?php echo convertedcit(placeholder($data->second));?></td>
                              <td><?php echo convertedcit(placeholder($data->third));?></td>
                              <td><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                              <td>&nbsp;</td>
                              
                            </tr>
                         <?php $i++; 
                         $first_total +=$data->first;
                         $second_total +=$data->second;
                         $third_total +=$data->third;
                         $total +=$data->investment_amount;
                         endforeach;?>
                            </tr>
                            <tr>
                              <th colspan="6" class="myCenter">कुल जम्मा </th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($first_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($second_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($third_total));?></th>
                              <th  class="myCenter"><?php echo convertedcit(placeholder($total));?></th>
                              <th  class="myCenter">&nbsp;</th>
                            </tr>
                       </table>
                      </div></div>
            <?php } ?>
        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>