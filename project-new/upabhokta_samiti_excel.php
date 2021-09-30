<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();

if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
 if(empty($_GET['ward_no']))
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id";
    }
    else
    {
        $sql="select * from plan_total_investment as a left join plan_details1 as b on a.plan_id=b.id where b.ward_no=".$_GET['ward_no'];
        
    }
    $result = $database->query($sql);
	
    $output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body><table class="table table-bordered table-hover">
    <tr>
    <td colspan="6" style="text-align: center;">'; if(empty($_GET['ward_no'])){ $output.= "उपभोक्ता समिति  विवरण हेर्नुहोस"; }else{ $output.= "वडा नं ".convertedcit($_GET['ward_no'])." को उपभोक्ता समिति विवरण हेर्नुहोस ";} $output.='</td>
    </tr>
    <tr>
    <td class="myCenter"><strong>सि नं </strong></td>
    <td class="myCenter"><strong>दर्ता नं </strong></td>
    <td class="myCenter"><strong>योजनाको नाम </strong></td>
    <td class="myCenter"><strong>उपभोक्ता समितिको नाम </strong></td>
    <td class="myCenter"><strong>अनुदान रकम</strong></td>
    <td class="myCenter"><strong>उपभोक्ताबाट नगद साझेदारी</strong></td>
    </tr>';
    $i=1;while($data= mysqli_fetch_object($result)):
    $customer_result = Costumerassociationdetails0::find_by_plan_id($data->id);
     if(!empty($data->id))
        {
              $customer_result = Costumerassociationdetails0::find_by_plan_id($data->id);
        }
        else
        {
            $customer_result = Costumerassociationdetails0::setEmptyObjects();
        }
    if(!empty($customer_result))
    {
    $name= $customer_result->program_organizer_group_name;
    }
    else
    {
    $name="";
    }
    if($data->costumer_agreement==0)
    {
    continue;
    }

    $output.='<tr>
    <td class="myCenter">'.convertedcit($i).'</td>
    <td class="myCenter">'.convertedcit($data->id).' </td>
    <td class="myCenter">'.$data->program_name.'</td>
    <td class="myCenter">'.$name.'</td>
   <td class="myCenter">'.convertedcit(placeholder($data->investment_amount)).'</td>
    <td class="myCenter">'.$data->costumer_agreement.'</td>
    </tr>';
    $i++;endwhile;
$output.='</table></body></html>';  
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=upobhokta_report_details.xls");
echo $output;
                           		
              