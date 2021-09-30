var JQ= jQuery.noConflict();
JQ(document).ready(function(){
 // payment,contingency calculate function mulyankan adhar ma bhuktani
    JQ(document).on("click","#calculate_analysis",function() {
         var estimated_amount = parseFloat(JQ("#analysis_estimated_amount").val() || 0);
        var hid_total_evaluated = parseFloat(JQ("#hid_total_evaluated").val() || 0);
        var plan_evaluated_amount = parseFloat(JQ("#evaluated_amount").val() || 0);
        //console.log(plan_evaluated_amount);
        var karyadesh_rakam = parseFloat(JQ("#karyadesh_rakam").val()||0);
        // var rakam = 25000;
        // var karyadesh_rakam = parseFloat(karyadesh_rakam_1)+parseFloat(rakam);
        //console.log(karyadesh_rakam);
        var advance_amount = parseFloat(JQ("#advance_payment").val() || 0);
        var plan_id = JQ("#plan_id").val();
        var khud_mulyankan = parseFloat(hid_total_evaluated) + parseFloat(plan_evaluated_amount);
        JQ("#khud_evaluated_amount").val(khud_mulyankan.toFixed(2));
          var param = {};
         param.plan_id= plan_id;
          JQ.post('get_contingency_for_plan.php',param,function(res){
             var obj = JSON.parse(res);
             var val  = parseFloat(obj.html);
             var con_glob =  parseFloat(val);
             con_glob = con_glob*100;
             //console.log(con_glob);
            // Getting kul Lagat values
            var payment_percent     = ((karyadesh_rakam/estimated_amount) * 100);
            var agreement_gaupalika = (JQ("#hid_agreement_gauplaika").val() || 0);
            var agreement_other     = JQ("#hid_agreement_other").val() || 0;
            var other_agreement     = (JQ("#hid_other_agreement").val() || 0);
            var costumer_agreement  = (JQ("#costumer_agreement").val() || 0);
            
            //Getting Each Percentage Kul Lagat
            
            var gaupalika_percent = (agreement_gaupalika/estimated_amount)*100;
            var agreement_other_percent =(agreement_other/estimated_amount)*100; 
            var other_agreement_percent = (other_agreement/estimated_amount)*100;
            var costumer_agreement_percent = (costumer_agreement/estimated_amount)*100;
            
            //Getting each Net Amount 
            var gauplaika_amount =  (gaupalika_percent * plan_evaluated_amount  )/100;
            var agreement_other_amount =(agreement_other_percent *  plan_evaluated_amount)/100;     
            var other_agreement_amount =(other_agreement_percent *  plan_evaluated_amount)/100;
            var costumer_agreement_amount =(costumer_agreement_percent *  plan_evaluated_amount)/100;
                
            // Sum Of All Amount 
             var payable_amount = parseFloat(gauplaika_amount)+parseFloat(agreement_other_amount)+parseFloat(other_agreement_amount)+parseFloat(costumer_agreement_amount);
             var payable_amount = payable_amount.toFixed(2);
             //console.log(payable_amount);
             payment_percent       = payment_percent.toFixed(8);
             //console.log(payment_percent);
             //Actual Payment Amount
              var amount_to_be_paid = ((plan_evaluated_amount*payment_percent)/100);
              var amount_to_be_paid = amount_to_be_paid.toFixed(2);
              //console.log(amount_to_be_paid);
              //Actual Contingecy
              var final_contingency = parseFloat(payable_amount)-parseFloat(amount_to_be_paid);
              
              var marmat_rate = JQ("#marmat_rate").val(); 
              //console.log(marmat_rate);
              var marmat_result = parseFloat(marmat_rate/100) * parseFloat(gauplaika_amount);
              //console.log(marmat_result);
               
              var amount_without_con = parseFloat(amount_to_be_paid + final_contingency);
              var total_paid_amount = amount_to_be_paid - advance_amount - marmat_result;
                    
            var sum = 0;
          JQ('input[name^="katti[]"]').each( function() {
             var id_selected = JQ(this).attr('id');
             var res = id_selected.split("_");
             var counter = res[res.length-1];
             var katti_percent = parseFloat(JQ("#katti_percent_"+counter).val()||0);
             var amount = amount_without_con * (katti_percent/100);
             var net_amount = payable_amount - amount;
            //alert(katti_percent);
             
             sum +=amount;
             amount= amount.toFixed(2);
             //console.log(amount);
             JQ("#katti_"+counter).val(amount);
             //console.log(counter);
        });
        //console.log(sum);
        var total_katti = final_contingency + advance_amount+marmat_result + sum;
        var final_total_paid_amount = parseFloat(total_paid_amount);
            JQ("#contengency_amount").val(final_contingency.toFixed(2));
            JQ("#renovate_amount").val(marmat_result.toFixed(2));
            //JQ("#total_amount_deducted").val(total_katti.toFixed(2));
             JQ("#payable_amount").val(amount_without_con.toFixed(2));
             //JQ("#total_paid_amount").val(final_total_paid_amount.toFixed(2));
             
            // peski and contingency and after marmat kul bhuktani rakam
            var total_after_all_1 = parseFloat(amount_without_con)-parseFloat(advance_amount)-parseFloat(marmat_result);
            var total_after_all = total_after_all_1.toFixed(2);
            //console.log(total_after_all);
            JQ("#after_cont_all").val(total_after_all);
            JQ("#final_t_amount").val(total_after_all);
    });
});
//मूल्यांकनको आधारले भुक्तानीको लागि  समाप्त//       
//calculations for mulyankan ko adhar ma bhuktani ends here;
//calculation for Final Antim bhuktani Begins
//अन्तिम भुक्तानीको लागि 

   JQ(document).on("click","#final_check",function() {
        var check_inst = JQ("#check_inst").val();
        var check_advance = JQ("#check_advance").val();
        var estimated_amount = parseFloat(JQ("#estimated_amount").val() || 0);
        var karyadesh_rakam = parseFloat(JQ("#karyadesh_amount").val() || 0);
        // console.log(karyadesh_rakam);
        var advance_amount = parseFloat(JQ('#advance_payment').val()||0);
        var analysis_total = parseFloat(JQ("#analysis_total_evaluated_amount").val() || 0);// Total Mulyankan in Analysis Bhuktani
        // console.log(analysis_total);
        var payment_till_now = parseFloat(JQ("#payment_till_now").val() || 0); //Payment in Mulyankan
        var haal_mulyankan = parseFloat(JQ("#haal_mulyankan").val() || 0); // Hall Mulyankan in Final
        var total_mulyankan = parseFloat(haal_mulyankan) + parseFloat(analysis_total);
        //console.log(total_mulyankan);
        JQ("#plan_evaluated_amount").val(total_mulyankan.toFixed(2));
    // var analysis_khud_mulyankan = parseFloat(JQ('#plan_evaluated_amount').val()||0); // Getting Khud Mulyankan in Final
        var analysis_khud_mulyankan = total_mulyankan.toFixed(2); // Getting Khud Mulyankan in Final
    //Checking if Mulyankan Amount Exceeding the estimate or not
    if(estimated_amount<= analysis_khud_mulyankan)
     {
         var net_mulyankan = estimated_amount;
          var result_ghati = 0;
     }
     else
     {
         var net_mulyankan = analysis_khud_mulyankan;
         var result_ghati = estimated_amount - analysis_khud_mulyankan;
     }
     console.log(net_mulyankan);
     //checking ends here
            var payment_percent     = ((karyadesh_rakam/estimated_amount) * 100);
            var agreement_gaupalika = (JQ("#hid_agreement_gauplaika").val() || 0);
            var agreement_other     = JQ("#hid_agreement_other").val() || 0;
            var other_agreement     = (JQ("#hid_other_agreement").val() || 0);
            var costumer_agreement  = (JQ("#customer_agreement").val() || 0);
            
            //Getting Each Percentage Kul Lagat
            
            var gaupalika_percent = (agreement_gaupalika/estimated_amount)*100;
            var agreement_other_percent =(agreement_other/estimated_amount)*100; 
            var other_agreement_percent = (other_agreement/estimated_amount)*100;
            var costumer_agreement_percent = (costumer_agreement/estimated_amount)*100;
            
           gaupalika_percent =  gaupalika_percent.toFixed(8);
           agreement_other_percent =  agreement_other_percent.toFixed(8);
           other_agreement_percent =  other_agreement_percent.toFixed(8);
           costumer_agreement_percent =  costumer_agreement_percent.toFixed(8);
            //Getting each Net Amount 
//            alert(net_mulyankan-analysis_total);
            var gauplaika_amount =  (gaupalika_percent * (net_mulyankan- analysis_total)  )/100;
            var agreement_other_amount =(agreement_other_percent *  (net_mulyankan- analysis_total))/100;     
            var other_agreement_amount =(other_agreement_percent *  (net_mulyankan- analysis_total))/100;
            var costumer_agreement_amount =(costumer_agreement_percent *  (net_mulyankan- analysis_total))/100;
//                alert(gaupalika_percent + " " +  agreement_other_percent + " " +  other_agreement_percent + " " +  costumer_agreement_percent);
            // Sum Of All Amount 
//            alert(gauplaika_amount + " " + agreement_other_amount + " " + other_agreement_amount+ " " + costumer_agreement_amount  );
             var payable_amount = parseFloat(gauplaika_amount)+parseFloat(agreement_other_amount)+parseFloat(other_agreement_amount)+parseFloat(costumer_agreement_amount);
             payment_percent       = payment_percent.toFixed(8);
             
             //Actual Payment Amount
              var amount_to_be_paid = (((net_mulyankan - analysis_total)*payment_percent)/100);
              //console.log(amount_to_be_paid);
              var final_contingency = parseFloat(payable_amount - amount_to_be_paid);// Getting Contingency
//              alert(payable_amount.toFixed(2) + " " + amount_to_be_paid.toFixed(2) + " " + final_contingency.toFixed(2));
              var amount_without_contingency = amount_to_be_paid + final_contingency; // Amount Without Contingency
              
              //checking if analysis is present or absent and if only advance is present
              var advance_katti =0;
               if(check_advance==1)
              {
                  var actual_payment_amount =  parseFloat(amount_to_be_paid - advance_amount);
                  advance_katti= advance_amount;
              }
              else
              {
                  var actual_payment_amount = parseFloat(amount_to_be_paid);
              }
              //checking ends here
              //console.log(actual_payment_amount);
              var net_ghati_amout = parseFloat(result_ghati * payment_percent)/100;//Getting Net Ghati Amount If Mulyankan is Less Than Estimate 
              
              //Getting Marmat Samhar Amount
              var marmat_rate = JQ("#marmat_rate").val(); 
              var marmat_result = parseFloat(marmat_rate/100) * parseFloat(gauplaika_amount);
             // Marmat Samhar Ends here;
             
              var total_katti =parseFloat(final_contingency + marmat_result);//Getting Total Katti
              
              //Getting Final Payment Amount includig all katti
             var final_payment_amount = parseFloat(actual_payment_amount - marmat_result);
             //console.log(final_payment_amount);
             
              var sum = 0;
           JQ('input[name^="katti[]"]').each( function() {
             var id_selected = JQ(this).attr('id');
             var res = id_selected.split("_");
             var counter = res[res.length-1];
             var katti_percent = parseFloat(JQ("#katti_percent_"+counter).val()||0);
             var amount = amount_without_contingency * (katti_percent/100);
    //         var net_amount = payable_amount - amount;
//             alert(katti_percent);
             //for katti
               sum +=amount;
               
             amount= amount.toFixed(4);
             JQ("#katti_"+counter).val(amount);
        });
        var final_total_paid_amount = parseFloat(final_payment_amount - sum); 
        total_katti += sum; 
             JQ("#final_bhuktani_ghati_amount").val(net_ghati_amout.toFixed(2));
             JQ("#final_renovate_amount").val(marmat_result.toFixed(2));
             JQ("#final_contengency_amount").val(final_contingency.toFixed(2));
             JQ("#kaam_ghati_katti_rakam").val(amount_without_contingency.toFixed(2));
             JQ("#final_total_amount_deducted").val(total_katti.toFixed(2));
             JQ("#final_total_paid_amount").val(final_total_paid_amount.toFixed(2));
             JQ("#final_t_amount").val(final_total_paid_amount.toFixed(2));
        });
});