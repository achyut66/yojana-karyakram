var JQ = jQuery.noConflict();
JQ(document).ready(function(){
    JQ(document).on("input","#advance_rate,#payable_amounts",function() {
        var advance_rate = JQ("#advance_rate").val() || 0;
        var contract_advance_amount =JQ("#contract_advance_amount").val()||0;
//        alert(contract_advance_amount);return false;
        var payable_amounts =JQ("#payable_amounts").val() || 0;
        var sum = 0;
           JQ('input[name^="katti[]"]').each( function() {
             var id_selected = JQ(this).attr('id');
             var res = id_selected.split("_");
             var counter = res[res.length-1];
             var katti_percent = parseFloat(JQ("#katti_percent_"+counter).val()||0);
             var amount = payable_amounts * (katti_percent/100);
    //         var net_amount = payable_amount - amount;
//             alert(katti_percent);
             
               sum +=amount;
             amount= amount.toFixed(4);
             JQ("#katti_"+counter).val(amount);
        });
        var advance_result = (advance_rate/100) * contract_advance_amount;
        var total = parseFloat(advance_result)+ parseFloat(sum); 
        JQ("#advance_payments").val(advance_result);
        JQ("#total_amount_deductedd").val(total);

    });
//   JQ(document).on("input","#advance_payments, #renovate_amounts, #due_amounts, #disaster_management_amounts",function() {
//        var renovate_amounts = JQ("#renovate_amounts").val() || 0;
//        var due_amounts = JQ("#due_amounts").val() || 0;
//        var disaster_management_amounts = JQ("#disaster_management_amounts").val() || 0;
//        var advance_payments = JQ("#advance_payments").val() || 0;
//        var payable_amounts = JQ("#payable_amounts").val() || 0;
//        var total_amounts= parseFloat(renovate_amounts) + parseFloat(due_amounts) + parseFloat(disaster_management_amounts) + parseFloat(advance_payments);
//        var total_remaining_amounts=  parseFloat(payable_amounts)- parseFloat(total_amounts);
//         //alert(total_paid_amount); return false;
//        JQ("#total_amount_deductedd").val(total_amounts);
//        JQ("#total_paid_amounts").val(total_remaining_amounts);
//        
//
//    });
     JQ(document).on("input","#payable_amounts",function() {
        var payable_amounts = JQ("#payable_amounts").val() || 0;
        var total_amount_deductedd = JQ("#total_amount_deductedd").val() || 0;
        var total_remaining_amounts=  parseFloat(payable_amounts)- parseFloat(total_amount_deductedd);
        JQ("#total_paid_amounts").val(total_remaining_amounts);
        

    });
    JQ(document).on("click",".add_more_rules",function() {
         var num=JQ(".remove_rule_details").length;
           var counter=num+2;
           //alert(counter);
           var param = {};
        param.counter= counter;
        JQ.post('get_rules.php',param,function(res){
               var obj = JSON.parse(res);
           //alert(obj.html);
               JQ("#add_rules").append(obj.html);
               //JQ('#interest_amount_'+id).val(obj.interest_amount);
               
              // alert(obj.interest_amount);
            });
    });
     
     JQ(document).on("click",".remove_more_rules",function() {
         JQ('.remove_rules_details').last().remove();
        
    });
JQ(document).on("input","input[name~='bid_amount[]'],input[name~='total_bid_amount[]'],input[name~='reduce_rate[]'],input[name~='final_reduced_amount[]']",function() {
                var id_selected = JQ(this).attr("id");
                var ps = JQ("#ps_amt").val()||0;
                var id_split= id_selected.split("-");
                var counter= id_split[id_split.length-1];
                var radio = JQ("input[type='radio'][name='bill_type-"+counter+"']");
                var is_checked = 0;
                if(radio.is(":checked"))
                {
//                    alert("here");
                    is_checked =  JQ("input[type='radio'][name='bill_type-"+counter+"']:checked").val();
                    var bid_amount = parseFloat(JQ("#bid_amount-"+counter).val()||0);
                    if(is_checked==1)
                    {
                        var net_total = bid_amount + parseFloat(ps);
                    }
                   else if(is_checked==2)
                    {
                        var total = parseFloat(bid_amount)*0.13;
                        var net_total = parseFloat(bid_amount) + total + parseFloat(ps);
                    }
                    else
                    {
                        net_total=0;
                    }
                    JQ("#total_bid_amount-"+counter).val(net_total);
                }
                var total_bid_amount=JQ("#total_bid_amount-"+counter).val();
                var reduce_rate=parseFloat(JQ("#reduce_rate-"+counter).val()||0);
                var total_bid_amount=parseFloat(JQ("#total_bid_amount-"+counter).val()||0)
                var reduced_percent = reduce_rate / 100;
                var reduce_amount= total_bid_amount * reduced_percent;
                var total_reduced_amount = total_bid_amount - reduce_amount;
                JQ("#final_reduced_amount-"+counter).val(total_reduced_amount);
                    
                 });
    JQ(document).on("click",".radioBtnClass",function() {
        var id_selected = JQ(this).attr("name");
        var ps = JQ("#ps_amt").val()||0;
        //console.log(ps);
        var id_split= id_selected.split("-");
        var counter= id_split[id_split.length-1];
        var radio = JQ("input[type='radio'][name='bill_type-"+counter+"']");
        var is_checked = 0;
        if(radio.is(":checked"))
                {
//                    alert("here");
                    is_checked =  JQ("input[type='radio'][name='bill_type-"+counter+"']:checked").val();
                    var bid_amount = parseFloat(JQ("#bid_amount-"+counter).val()||0);
                    if(is_checked==1)
                    {
                        var net_total = bid_amount + parseFloat(ps);
                    }
                   else if(is_checked==2)
                    {
                        var total = parseFloat(bid_amount)*0.13;
                        var net_total = parseFloat(bid_amount) + total + parseFloat(ps);
                    }
                    else
                    {
                        net_total=0;
                    }
                    JQ("#total_bid_amount-"+counter).val(net_total);
                }
                 var total_bid_amount=JQ("#total_bid_amount-"+counter).val();
                var reduce_rate=parseFloat(JQ("#reduce_rate-"+counter).val()||0);
                var total_bid_amount=parseFloat(JQ("#total_bid_amount-"+counter).val()||0)
                var reduced_percent = reduce_rate / 100;
                var reduce_amount= total_bid_amount * reduced_percent;
                var total_reduced_amount = total_bid_amount - reduce_amount;
                JQ("#final_reduced_amount-"+counter).val(total_reduced_amount);
            });
    
 });