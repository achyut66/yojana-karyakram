       
//संझौता गरी रकम किस्तामा दिनु पर्ने भएमा
        $data3=new Withdrawplaninstallmentdetails();
        $data3->first_installment=$_POST['first_installment'];
        $data3->second_installment=$_POST['second_installment'];
        $data3->third_installment=$_POST['third_installment'];
        $data3->fourth_installment=$_POST['fourth_installment'];
         $data3->last_installment=$_POST['last_installment'];
        $data3->plan_id=$plan_id;
        $data3->save();
                              
 
                        