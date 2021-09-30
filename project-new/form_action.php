<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(isset($_POST['submit']))
{
   // योजनाको कुल लागत अनुमान
    $total_investment= new Plantotalinvestment();
    $total_investment->plan_id=$_POST['plan_id'];
    $total_investment->agreement_gauplaika=$_POST['agreement_gauplaika'];
    $total_investment->agreement_other=$_POST['agreement_other'];
    $total_investment->costumer_agreement=$_POST['costumer_agreement'];
    $total_investment->other_agreement=$_POST['other_agreement'];
    $total_investment->costumer_investment=$_POST['costumer_investment'];
    $total_investment->total_investment=$_POST['total_investment'];
  $total_investment->save();
    
    
//        
    $session->message("successfully saved");    
    redirect_to("plan_form1.php");
        
     // echo "<pre>"; print_r($_POST); echo "</pre>";     

}
?>