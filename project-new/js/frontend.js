var JQ = jQuery.noConflict();
JQ(document).ready(function(){
    var base_url = 'http://pdmt.com.np/finalplan/';
 JQ(".ndp-click-trigger").html('मिति');
	JQ(document).on("click","#edititem",function() {
	 	var column_name = JQ(this).attr('name');
		JQ('.edit_item').show();
  });
  
  
  //new
   function convertnum(num) {
    var number = JQ.trim(num);
    var numbers = number.split('');
    var count = numbers.length;total_bid_amount-1
    var n = '';
    for (var i = 0; i < count; i++) {

        switch (numbers[i]) {
            case "०": n += 0; break;
            case "१": n += 1; break;
            case "२": n += 2; break;
            case "३": n += 3; break;
            case "४": n += 4; break;
            case "५": n += 5; break;
            case "६": n += 6; break;
            case "७": n += 7; break;
            case "८": n += 8; break;
            case "९": n += 9; break;           
            case ".": n += '.'; break;
            case "-": n += '-'; break; 
            case ",": break;           
            default: n += numbers[i];
        }
    }
    n = JQ.trim(n);
    return n;
};

 //regex validation function for input number
   function ValidateInputNumber(numValue) {
    var engNum = numValue;
    var numRegex = new RegExp(/^[+-]?(\d+\.\d+|\d+\.|\.\d+|\d+)([eE][+-]?\d+)?$/);
    //var dtRegex = new RegExp(/^[0-3]?[०-९]\/[01]?[०-९]\/[12][90][०-९][०-९]JQ/);
    //var dtRegex = new RegExp(/^[0-3]?[०-९]\/[01]?[०-९]\/[12][90][०-९][०-९]JQ/);
    //var dtRegex = new RegExp(/^[0-3]?[0-9]\/[01]?[0-9]\/[12][90][0-9][0-9]JQ/);
    return numRegex.test(engNum);
}
//regex validation function for input date
function ValidateDate(dtValue) {    
    var dtRegex = new RegExp(/^(\d{4})([\-])(\d{1,2})\2(\d{1,2})$/);
    //var dtRegex = new RegExp(/^[0-3]?[०-९]\/[01]?[०-९]\/[12][90][०-९][०-९]JQ/);
    //var dtRegex = new RegExp(/^[0-3]?[०-९]\/[01]?[०-९]\/[12][90][०-९][०-९]JQ/);
    //var dtRegex = new RegExp(/^[0-3]?[0-9]\/[01]?[0-9]\/[12][90][0-9][0-9]JQ/);
    return dtRegex.test(dtValue);
}

 function checkInput()
 {
    JQ('.checkInput').on('input', function (e) {
       // alert('here');return false;
       var dtVal = convertnum(JQ(this).val()) || 0;
       if (dtVal == "") { return true; }
       if (dtVal == " ") { return true; }
       if (!ValidateInputNumber(dtVal)) {
           alert("कृपया अंक मात्र हाल्नुहोला");
           JQ(this).val(dtVal.slice(0, -1));
           e.preventDefault();
       }
       else {
       JQ(this).val(dtVal).focus();
       }
   });
}
 JQ('.checkInput').on('input', function (e) {
    var dtVal = convertnum(JQ(this).val()) || 0;
    if (dtVal == "") { return true; }
    if (dtVal == " ") { return true; }
    if (!ValidateInputNumber(dtVal)) {
        alert("कृपया अंक मात्र हाल्नुहोला");
        JQ(this).val(dtVal.slice(0, -1));
        e.preventDefault();
    }
    else {
    JQ(this).val(dtVal).focus();
    }
});
  
  // new end
  
  
    JQ(document).on("click",".add_shrot",function() {
    var num=JQ(".remove_shrot_details").length;
    var counter=num+2;
    //           alert(counter);return false;
    var param = {};
    param.counter= counter;
    JQ.post('get_shrot.php',param,function(res){
        var obj = JSON.parse(res);
    //alert(obj.html);
        JQ("#add_more_shrot").append(obj.html);
        //JQ('#interest_amount_'+id).val(obj.interest_amount);

       // alert(obj.interest_amount);
     });
    });
     
     JQ(document).on("click",".remove_shrot",function() {
         JQ('.remove_shrot_details').last().remove();
        
    });
    
    

    JQ(document).on("blur","#plan_id_contingency",function() {
        var plan_id = JQ("#plan_id_contingency").val();
//        alert(plan_id);return false;
        var param = {};
        param.plan_id= plan_id;
        JQ.post('get_plan_name.php',param,function(res){
        var obj = JSON.parse(res);
//        alert(obj.html);return false;
        JQ("#id_name_value").html(obj.html);
       
            });
    });  
    

        JQ(document).on("click","#remove_training",function(){
            var id_selected = JQ(".training_row").last().attr('id');
            var res = id_selected.split("_");
            var id = res[res.length-1];
            var selected_total = parseFloat(JQ("#total_"+id).val());
            var grand_total = parseFloat(JQ("#grand_total").val());
            var new_total  = grand_total - selected_total;
            var id_selected = JQ(".training_row").last().attr('id');
            var res = id_selected.split("_");
            var id = res[res.length-1];
            var selected_total = parseFloat(JQ("#total_"+id).val());
            var grand_total = parseFloat(JQ("#grand_total").val());
            var new_total  = grand_total - selected_total;
            JQ("#grand_total").val(new_total);
            JQ(".training_row").last().remove(); 
        });
        
        
         JQ(document).on("input","#getuname",function() {
        var plan_id = JQ(this).val();
        var param = {};
        param.plan_id= plan_id;
        JQ.post('get_plan_name_by_id.php',param,function(res){
        var obj = JSON.parse(res);
       JQ("#showuname").html(obj.html);
       
            });
    });  
    
    
    
        JQ(document).on("input","input[name~='rate[]'],input[name~='quantity[]']",function(){
           var id_selected = JQ(this).attr("id");
           var res = id_selected.split("_");
           var id = res[res.length-1];
           var rate = parseFloat(JQ("#rate_"+id).val())||0;
           var quantity = parseFloat(JQ("#quantity_"+id).val())||0;
           var max_sn = JQ(".max_sn").length;
           var total = rate * quantity;
           JQ("#total_"+id).val(total);
           var grand_total = 0;
           for(var i=1;i<=max_sn;i++)
           {
               grand_total += parseFloat(JQ("#total_"+i).val()) || 0;
           }
           JQ("#grand_total").val(grand_total);
        });
    
    
    JQ(document).on("change","#contingency_type",function() {
        var type = JQ("#contingency_type").val();
//        alert(type);return false;
        if(type=="1")
        {
            JQ("#id_heading").hide();
            JQ("#id_value") .hide();
            JQ("#id_name") .hide();
            JQ("#id_name_value") .hide();
        }
        else
        {
            JQ("#id_heading").show() ;
            JQ("#id_value").show() ;
            JQ("#id_name") .show();
            JQ("#id_name_value") .show();
        }
            
          
    });  
    JQ(document).on("input",".radioBtnClass,#ps_amt",function() {
         var contract_type = JQ("input[type='radio'].radioBtnClass:checked").val();
         var amount=JQ("#amount").val()||0;
         var ps = JQ("#ps_amt").val()||0;
        if(contract_type.length==0)
       {
           return false;
       }
       else if(contract_type==1)
        {
            var net_total=parseFloat(amount) + parseFloat(ps);
        }
        else
        {
            var total=parseFloat(amount)*0.13;
            var net_total=parseFloat(amount) + total + parseFloat(ps);
        }
         
         JQ("#contract_amount").val(net_total.toFixed(2));
            });
            
    // JQ(document).on("input","#amount,#ps_amt",function(){
    //     //alert("here"); 
    //     var tot_amt = JQ("#amount").val()||0;
    //     //console.log(tot_amt);
    //     var ps = JQ("#ps_amt").val()||0;
    //     //console.log(ps);
    //     var net = parseFloat(tot_amt)+parseFloat(ps);
    //     JQ("#contract_amount").val(net.toFixed(2));
    // });
    
    JQ(document).on("change","#contractor_id",function() {
        var contractor_id = JQ("#contractor_id").val()||0;
        var param = {};
        param.contractor_id = contractor_id;
        JQ.post('get_contract_invitation_list.php',param,function(res){
        var obj = JSON.parse(res);
        JQ("#contractor_address").val(obj.contractor_address);
        JQ("#contractor_contact").val(obj.contractor_contact);
            });
    });  
    JQ(document).on("input","#amount",function() {
        var contract_type = JQ("input[type='radio'].radioBtnClass:checked").val();
        var amount=JQ("#amount").val()||0;
        var ps = JQ("#ps_amt").val()||0;
       if(contract_type.length==0)
       {
           return false;
       }
       else if(contract_type==1)
        {
            var net_total=parseFloat(amount) + parseFloat(ps);
        }
        else
        {
            var total=parseFloat(amount)*0.13;
            var net_total=parseFloat(amount) + total + parseFloat(ps);
        }
         
         JQ("#contract_amount").val(net_total.toFixed(2));
    });
    
    //check total budget and remaining budget 
  JQ(document).on("change","#budget_id",function() {
        var budget_id = JQ("#budget_id").val()||0;
        var fiscal_id = JQ("#fiscal_id").val()||0;
        var param = {};
        param.budget_id = budget_id;
         param.fiscal_id = fiscal_id;
//        alert(budget_id);return false;
        JQ.post('get_remaining_budget.php',param,function(res){
        var obj = JSON.parse(res);
        var total_investment=parseFloat(obj.total_investment);
        var budget_amount = parseFloat(obj.budget_amount);
        if(budget_amount < total_investment)
        {
            alert("सकिएको छ ..!!!");return false;
        }
        else if(obj.budget_amount==0)
        {
            alert("बजेट रकम भरिएको छैन ,कृपया सेटिंगमा गएर बजेट रकम भर्नुहोस्");return false;
        }
        else
        {
            //JQ('.appendme').html('<h1>hello</h1>');
                JQ("#total_topic_budget").show();
                //JQ("#remaining_budget_show").show();
              JQ("#total_topic_budget").html(obj.total_amount);
              //JQ("#remaining_budget_show").html(obj.remaining_amount);
          }     
            });
    }); 
     JQ(document).on("input","#second",function() {
        var first = JQ("#first").val() || 0;
        var investment_first=JQ("#investment_first").val() ;
         var second = JQ("#second").val() || 0;
         var net_total=parseFloat(first) + parseFloat(second);
         var net_total1=parseFloat(investment_first)-parseFloat(net_total);
         JQ("#third").val(net_total1);
    });
    
    
  JQ(document).on("click","#first_check",function() {
        var first = parseFloat(JQ("#first").val()) || 0;
        var investment_first = parseFloat(JQ("#investment_first").val()) || 0 ;
        var second = parseFloat(JQ("#second").val()) || 0;
        var third = parseFloat(JQ("#third").val()) || 0;
        var total = parseFloat(first) + parseFloat(second);
        var total1 = parseFloat(total) + parseFloat(third);
	if(first > investment_first)
        {
            alert("amount exceeded");
            return false;
        }
         if(second==0 && (first!=0 && first<investment_first))
        {
            alert("amount less");
            return false;
        }
        if(total > investment_first)
        {
             alert("amount exceeded");
            return false;
        }
         if(total1 > investment_first)
        {
             alert("amount exceeded");
            return false;
        }
       var investment_amount = parseFloat(JQ('.investment_amount_check').val());
       var check_amount      = parseFloat(JQ('.remaining_amount_check').val()) || 0;
        if(check_amount !=0)
        {
           if(investment_amount > check_amount)
           {
               alert("अनुदान रकम मिलेन");
               return false;
           }
       }  
        return true;
    });
    JQ(document).on("change",".worker",function() {
        var id_selected = JQ(this).attr("id");
        var res = id_selected.split("_");
        var id  = res[res.length-1]; 
        var postname = JQ(this).val();
        var param = {};
        param.postname = postname;
        JQ.post('get_authority_post.php',param,function(res){
        var obj = JSON.parse(res);
        JQ("#post_"+id).val(obj.html);
        });
    });  
    JQ(document).on("change",".authority_name1",function() {
        var postname = JQ(this).val();
        var param = {};
        param.postname = postname;
        JQ.post('get_authority_post.php',param,function(res){
        var obj = JSON.parse(res);
//        alert(obj.html);exit;
        JQ(".authority_post1").val(obj.html);
            });
    });  
    JQ(document).on("click","#plan_dharauti_check",function() {
            var check_dharauti_amount = JQ("#check_dharauti_amount").val() || 0;
          
            var check_return_amount = JQ("#check_return_amount").val() || 0;
            
            if(parseFloat(check_return_amount) > parseFloat(check_dharauti_amount))
            {
                alert("धरौटी कट्टी रकम भन्दा धरौटी कट्टी फिर्ता रकम धेरै लिन मिल्दैन  ..!!!!");
                
            }
            else{
            	
                return true;
            }
          return false;
          
        });
    JQ(document).on("click","#dharauti_check",function() {
            var dharauti_amount = JQ("#dharauti_amount").val() || 0;
          
            var return_amount = JQ("#return_amount").val() || 0;
            
            if(parseFloat(return_amount) > parseFloat(dharauti_amount))
            {
                alert("धरौटी कट्टी रकम भन्दा धरौटी कट्टी फिर्ता रकम धेरै लिन मिल्दैन  ..!!!!");
                
            }
            else{
            	
                return true;
            }
          return false;
          
        });
     JQ(document).on("click","#rakam_check",function() {
            var evaluated_amounts = JQ(".evaluated_amounts").val() || 0;
          
            var payable_amounts = JQ(".payable_amounts").val() || 0;
            
            if(parseFloat(evaluated_amounts) < parseFloat(payable_amounts))
            {
                alert("योजनाको मुल्यांकन रकम भुक्तानी दिनु पर्ने कुल बाँकी  रकम भन्दा कम छ ..!!!!");
                
            }
            else{
            	
                return true;
            }
          return false;
          
        });
    JQ(document).on("input","#contract_total_amount",function() {
        var contract_total_amount = JQ(this).val();
      
         JQ('#contract_bhuktani_anudan').val(contract_total_amount);
    });
  JQ(document).on("input",".remaining_sample,.final_deducted_one,.final_one,.due_one,.disaster_one",function() {
        var remaining_sample = JQ(".remaining_sample").val() || 0;
       var final_one = JQ(".final_one").val() || 0;
        var due_one = JQ(".due_one").val() || 0;
        var disaster_one = JQ(".disaster_one").val() || 0;
        var total_sample_deducted=  parseFloat(final_one)+parseFloat(due_one)+ parseFloat(disaster_one);
        
        var total_amount_sample=  parseFloat(remaining_sample)- parseFloat(total_sample_deducted);
        
        JQ("#total_sample").val(total_amount_sample);
        

    });
      JQ(document).on("input","#final_one,#due_one,#disaster_one",function() {
        var final_one = JQ("#final_one").val() || 0;
        var due_one = JQ("#due_one").val() || 0;
        var disaster_one = JQ("#disaster_one").val() || 0;
        var total_amountss=  parseFloat(final_one)+parseFloat(due_one)+ parseFloat(disaster_one);
        JQ("#final_deducted_one").val(total_amountss);
        

    });
   
  
     
    JQ(document).on("input","input[name~='ward']",function() {
  var val = JQ(this).val();
  
  
JQ(".ward option[value="+val+"]").attr('selected', 'selected');
// if(".ward option[value]").attr('')

     });
        
        JQ(document).on("change","#authority_name",function() {
        var postname = JQ(this).val();
        var param = {};
        param.postname = postname;
        JQ.post('get_authority_post.php',param,function(res){
        var obj = JSON.parse(res);
//        alert(obj.html);exit;
        JQ("#authority_post").val(obj.html);
            });
    });  
        JQ(document).on("click",".submit2",function() {
          
        var work_budget = JQ(".work_budget").val();
        var remaining_amount = JQ(".remaining_amount").val();
//        alert(remaining_amount);exit;
            if (parseFloat(work_budget) > parseFloat(remaining_amount) )
            {
              alert("कार्यादेश दिईएको रकम मिलेन");
              return false;
            }  
            else
            {
            return true;    
            }
            
}); 

     JQ(document).on("change","#sn_payment",function() {
        var sn = JQ(this).val();
        var program_id =JQ("#program_id").val();
        var param = {};
        param.sn = sn;
        param.program_id= program_id;
        JQ.post('get_enlist_and_budget_by_sn.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('.enlist1').html(obj.html);
                JQ('#budget').val(obj.budget);
            });
    });
    
     JQ(document).on("click","#submit_payment",function() {
        var budget = parseFloat(JQ('#work_order_budget').val());
        var karyadesh =parseFloat(JQ("#budget").val());
       if(budget>karyadesh)
       {
           alert("पेस्की दिईएको रकम मिलेन");
           return false;
       }
      });


    JQ(document).on("change",".show",function() {
        var selected = JQ(this).val() || 0;
        var param = {};
        var type_id = selected ;
        
        param.type_id = type_id;
        
        JQ.post('get_program_enlist.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('#type').html(obj.html);
            });
    });
      JQ(document).on("change","#show2",function() {
    
        var selected = JQ(this).val();

        var param = {};
        
        if(selected=="0")
        {
              var type_id = 0;
        }
        else if(selected=="1")
        {
              var type_id = 1;
        }
        else if(selected=="2")
        {
             var type_id = 2;
        }
           else if(selected=="3")
        {
             var type_id = 3;
        }
          else if(selected=="4")
        {
             var type_id =4;
        }

        param.type_id = type_id;
        
        
        JQ.post('get_program_enlist.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('#type3').html(obj.html);
            });
    });
     JQ(document).on("change",".sn",function() {
        var sn = JQ(this).val();
        var program_id =JQ("#program_id").val();
        var param = {};
        param.sn = sn;
        param.program_id= program_id;
        JQ.post('get_enlist_by_sn.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('.enlist1').html(obj.html);
            });
    });
    JQ(document).on("change",".sn1",function() {
        var sn = JQ(this).val();
        var program_id =JQ("#program_id1").val();
        var param = {};
        param.sn = sn;
        param.program_id= program_id;
        JQ.post('get_enlist_by_sn.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('.enlist2').html(obj.html);
            });
    });
    
    JQ(document).on("change",".sn5",function() {
        var sn = JQ(this).val();
        var program_id =JQ(".program_id").val();
      
        var param = {};
        param.sn = sn;
        param.program_id= program_id;
        JQ.post('get_program_final_details.php',param,function(res){
                var obj = JSON.parse(res);
//                alert(obj.html);exit;
                JQ('.enlist5').html(obj.html);
                JQ('.program_payment').val(obj.payment);
                JQ('.work_order_budget').val(obj.work_order_budget);
                JQ('.net_total_amount').val(obj.net_total_amount);
                JQ('.total_amount').val(obj.total_amount);
                 
               
            });
    });



     JQ(document).on("input",".deposit_amount",function() {
        var deposit_amount = JQ(this).val();
        var selected =JQ(".sn5").val();
        var work_order_budget= JQ(".work_order_budget").val();
       
        if(!selected)
        {
            alert ("कर्यादेस न छान्नुहोस्");
             return false;
        }
        var program_payment= JQ(".program_payment").val();
        var total_amount= parseFloat(deposit_amount)+parseFloat(program_payment);
        var net_total= parseFloat(work_order_budget)-parseFloat(total_amount);
         JQ('.total_amount').val(total_amount);
         JQ('.net_total_amount').val(net_total);
    });
  JQ(document).on("change","#sn_deposit",function() {
        var id = JQ(this).val();
        var program_id=JQ('.program_id').val();
        var param = {};
        param.id = id;
        param.program_id = program_id;
        JQ.post('get_deposit_amount.php',param,function(res){
        var obj = JSON.parse(res);
//        alert(obj.html);exit;
        JQ("#deposit_amount").val(obj.html);
         JQ("#total_deposit").val(obj.html);
        JQ("#period").val(obj.period);
        JQ("#period_no").val(obj.period_no);
         JQ("#enlist_id").val(obj.enlist_id);
        // alert(obj.enlist_id);
            });
    });  
      JQ(document).on("click","#submitdeposit",function() {
            var total_deposit = parseFloat( JQ("#total_deposit").val()) || 0;
            var input_deposit = parseFloat( JQ("#deposit_amount").val()) || 0;
            if(input_deposit > total_deposit)
            {
                alert("धरौटी कट्टी रकम भन्दा धरौटी कट्टी फिर्ता रकम धेरै लिन मिल्दैन !! ");
                return false;
            }
            else
            {
            	
                return true;
            }
         
          
        });
    
     JQ(document).on("click",".add_more",function() {
           // alert("here");
           var num=JQ(".remove_post_detail").length;
           
           var counter=num+2;
           var ward = JQ("#ward").val();
           //alert(ward);
            //alert(counter);
           var param = {};
        param.counter= counter;
        param.ward =ward;
       
        JQ.post('getpostdetails.php',param,function(res){
               var obj = JSON.parse(res);
               // alert(obj.html);
               JQ("#detail_add_table").append(obj.html);
               //JQ('#interest_amount_'+id).val(obj.interest_amount);
               
              // alert(obj.interest_amount);
            });
    });
     
   JQ(document).on("click",".submit",function(){
        var gender = "gender";
        
        //var genderid= JQ("#genderid").val();
       var male = 0;
       var female = 0;
       var others = 0;
       var total = 0;
       var fpercent= 0;
     JQ('select.gender').each(function () {
                        var val = JQ(this).find(":selected").val();
                        //alert(val);
          total++;              
     if(val==1){
         male++;
     } 
     if(val==2){
         female++;
     }
     if(val==3){
         others++;
     }
     });
     fpercent= (100/total)*female;
     
     
     if(fpercent<33){
         alert("३३ % महिलाको संख्या पुगेन |");
         return false;
         
     }
   else{
        
    
     var ada=0;
     var upada=0;
     var kosada=0;
     var sachip=0;
     var sadasya=0;
     var sanyojak=0;
      JQ('select.post').each(function () {
                    var value = JQ(this).find(":selected").val();

                    if (value==1){
                        ada++;
                    }
                 if (value==2){
                     upada++;
                 }
                  if (value==3){
                     sachip++
                 }
                  if (value==4){
                     kosada++;
                 }
                  if (value==5){
                     sadasya++;
                 }
                  if (value==6){
                     sanyojak++;
                 }
      }); 
                 
                if (ada>1){
                    alert("अध्यक्षको संख्या बेसी भॊ");
                return false;
                
                }
                else if (upada>1){
                    alert("उपाध्यक्षको संख्या बेसी भॊ");
                    return false;
                }
                else if (sachip>1){
                    alert("सचिबको संख्या बेसी भॊ");
                 return false;
                }
                else if (kosada>1){
                    alert("कोषाध्यक्षको संख्या बेसी भॊ");
                 return false;
                }
               else if (sanyojak>1){
                    alert("संयोजकको संख्या बेसी भॊ");
                 return false;
                }
               else if (sadasya>11){
                    alert("सदस्यको संख्या बेसी भॊ");
                 return false;
                }
                else{
                     return true;
                }
           
    
   }});
       
     
    JQ(document).on("click",".submit1",function(){
        var gender1 = "gender1";
        //var genderid= JQ("#genderid").val();
       var male = 0;
       var female = 0;
       var others = 0;
       var total = 0;
       var fpercent= 0;
     JQ('select.gender1').each(function () {
                        var val = JQ(this).find(":selected").val();
                        //alert(val);
          total++;              
     if(val==1){
         male++;
     } 
     if(val==2){
         female++;
     }
     if(val==3){
         others++;
     }
     });
     
     if(female<1){
         alert("महिला संख्या मिलेन ");
         return false;
         
     }
else{
    return true;
}      
    });   
		JQ(document).on("input",".column",function() {
            var total = 0;
            var classname = JQ(this).attr("class");
			//alert(classname);
          // var inputname = JQ(this).attr("name");
            //var idname = inputname.substr(0,4);
            JQ('input[type="text"].'+classname).each(function () {
                        var val = JQ(this).val();
                       
                        if(val=="")
                        {
                            val = 0;
                           
                        }
                        
                      total = parseFloat(total) + parseFloat(val);
					  JQ("#"+classname+"-value").val(total);
        });
	});
	JQ(document).on("click",".submit",function() {
            var plan_evaluated_amount = JQ("#plan_evaluated_amount").val() || 0;
          
            var remaining_payment_amount = JQ("#final_bhuktani_ghati_amount").val() || 0;
            
            if(parseFloat(plan_evaluated_amount) < parseFloat(remaining_payment_amount))
            {
                alert("योजनाको मुल्यांकन रकम भुक्तानी दिनु पर्ने कुल बाँकी रकम भन्दा कम छ ..!!!!");
                
            }
            else{
            	
                return true;
            }
          return false;
          
        });
    	JQ(document).on("input","#agreement_gauplaika, #agreement_other, #other_agreement, #costumer_agreement, #bhuktani_anudan, #costumer_investment",function() {
           var con_glob = 0;
            var plan_id = JQ("#plan_id").val()||0;
            var agreement_gaupalika = JQ("#agreement_gauplaika").val() || 0;
            var agreement_other = JQ("#agreement_other").val() || 0;
           var other_agreement = JQ("#other_agreement").val() || 0;
           var costumer_agreement = JQ("#costumer_agreement").val() || 0;
           var costumer_investment = JQ("#costumer_investment").val() || 0;
          var total = parseFloat(agreement_gaupalika) + parseFloat(agreement_other) + parseFloat(other_agreement);
          var param = {};
          param.plan_id= plan_id;
            
          JQ.post('get_contingency_for_plan.php',param,function(res){
                    var obj = JSON.parse(res);
                     var val  = parseFloat(obj.html);
                     con_glob = parseFloat(con_glob) + parseFloat(val);
                     
          var total1 = parseFloat(total) * con_glob;
          var total2=  parseFloat(total) - parseFloat(total1);
          var total3 = total2 + parseFloat(costumer_agreement);
           JQ("#bhuktani_anudan").val(total3);
          var floatRegex = /^-?\d+(?:[.,]\d*?)?$/;
           var total4 = parseFloat(total3) + parseFloat(costumer_investment);
          if(!floatRegex.test(total3) && !floatRegex.test(total4))
          {
            var total5=parseInt(total4);  
          }
          else
          {
            var total5 = parseFloat(total4.toFixed(2));  
          }
            
           JQ("#total_investment").val(total5);
                     
            });
        
          });
	
	JQ(document).on("input","#work_budget",function() {
            var total = 0;
             var total_budget = JQ('#total_budget').val();
        var work_budget = JQ('#work_budget').val();
                                 
                      total = parseFloat(total_budget) - parseFloat(work_budget);
					  JQ("#remaining_budget").val(total);
        });
	
	
    	JQ(document).on("input",".row1, .row2, .row3, .row4, .row5, .row6, .row7, .row8",function() {
            var total = 0;
            var classname = JQ(this).attr("class");
            var inputname = JQ(this).attr("name");
            var idname = inputname.substr(0,4);
            JQ('input[type="text"].'+classname).each(function () {
                        var val = JQ(this).val();
                        if(val=="")
                        {
                            val = 0;
                           
                        }
                        
                      total = parseFloat(total) + parseFloat(val);
        });
        JQ("#"+classname+"-value").val(total);
	
            
        });
       JQ(document).on("click","#add_pics",function() {
         JQ.post('getpicsdetails.php',function(res){
             var obj = JSON.parse(res);
               JQ("#pics_add_table").append(obj.html);
             
            });
    });
      JQ(document).on("click","#remove_pics",function() {
       JQ('.remove_pics_detail').last().remove();
        
        
    }); 
    
    JQ(document).on("click",".showhide",function() {

        var selected = JQ(this).val();
        if(selected=="1")
        {
            JQ("#staff").show();
             JQ("#company").hide();
             JQ("#group").hide();
             JQ("#working-field").hide();
             JQ("#other-field").hide();
              JQ("#upabhokta-field").hide();
        }
        else if(selected=="0")
        {
            JQ("#staff").hide();
             JQ("#group").hide();
             JQ("#company").show();
             JQ("#working-field").hide();
              JQ("#other-field").hide();
               JQ("#upabhokta-field").hide();
        }
        else if(selected=="2")
        {
           JQ("#staff").hide();
           JQ("#company").hide();
           JQ("#group").show();
           JQ("#working-field").hide();
            JQ("#other-field").hide();
             JQ("#upabhokta-field").hide();

        }
         else if(selected=="3")
        {
           JQ("#staff").hide();
           JQ("#company").hide();
           JQ("#group").hide();
           JQ("#working-field").show();
            JQ("#other-field").hide();
             JQ("#upabhokta-field").hide();

        }
        else if(selected=="4")
        {
           JQ("#staff").hide();
           JQ("#company").hide();
           JQ("#group").hide();
           JQ("#working-field").hide();
            JQ("#other-field").show();
             JQ("#upabhokta-field").hide();

        }
        //  else if(selected=="5")
        // {
        //   JQ("#staff").hide();
        //   JQ("#company").hide();
        //   JQ("#group").hide();
        //   JQ("#working-field").hide();
        //   JQ("#other-field").hide();
        //   JQ("#upabhokta-field").show();

        // }
    });

    JQ(document).on("keyup","#confirm_password",function() {
        var password = JQ('#password').val();
        var confirm_password = JQ('#confirm_password').val();
        if(confirm_password==="")
        {
            JQ('#check_password').html("");
        }
        else
        {
           if(password===confirm_password)
            {
                var html = '<img src="images/right.png" width="32px" height="32px">';
                JQ('#check_password').html(html);
            }
            else
            {
               var html = '<img src="images/wrong.png" width="32px" height="32px">';
               JQ('#check_password').html(html);
            }
        }
    });
    JQ(document).on("click",".header1",function() {
          $header = JQ(this);
          //getting the next element
          $content = $header.next();
          //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
          $content.slideToggle(700, function () {
              //execute this after slideToggle is done
              //change text of header based on visibility of content div
             
          });
    });
    JQ(document).on("click",".myheader",function() {
          $header = JQ(this);
          //getting the next element
          $content = $header.next();
          //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
          $content.slideToggle(700, function () {
              //execute this after slideToggle is done
              //change text of header based on visibility of content div
             
          });
    });
	
        
	JQ(document).on("click",".add_picture",function() {
        var param = {};
         JQ.post('getpicturedetails.php',param,function(res){
               var obj = JSON.parse(res);
                //alert(obj.html);
               JQ("#picture_add_table").append(obj.html);
             
            });
    });
      JQ(document).on("click",".remove_picture",function() {
       JQ('.remove_picture_detail').last().remove();
        
        
    });
    JQ(document).on("click",".remove_more",function() {
       JQ('.remove_post_detail').last().remove();
        
        
    });
    JQ(document).on("click",".remove",function() {
         JQ('.remove_post_detail_more').last().remove();
        
    });
    JQ(document).on("click",".add",function() {
         var num=JQ(".remove_post_detail_more").length;
           var counter=num+2;
            var param = {};
        param.counter= counter;
        JQ.post('getpostdetailsmore.php',param,function(res){
               var obj = JSON.parse(res);
            JQ("#detail_add_more_table").append(obj.html);
               //JQ('#interest_amount_'+id).val(obj.interest_amount);
             
            });
    });
	JQ(document).on("click","#add_calc",function() {
        var counter = JQ('.calculate').length;
        var param = {};
        param.counter = counter;
        JQ.post('getcalculatediv.php',param,function(res){
               var obj = JSON.parse(res);
               JQ('.calculate').after(obj.html);

			   //JQ('#interest_amount_'+id).val(obj.interest_amount);
               
             
            });
    });
   /*check needed
   JQ(document).on("click",".remove",function() {
        JQ(this).closest("tbody").remove();
        
        
    });*/
  JQ(document).on("click","#done",function() {
        JQ("#myform :input").prop("disabled", true);
        JQ("#myform :select").prop("disabled", true);
        
    });
    
    // check payable_amount against advance_payment if its first installment
   JQ(document).on("submit","#analysis_form",function() {
        var payment_count = JQ("#payment_evaluation_count").val();
        
       if(payment_count==1)
            {
              var payable_amount = JQ("#payable_amount").val() || 0;
              var advance_payment = JQ("#advance_payment").val() || 0;
              payable_amount = parseFloat(payable_amount);
              advance_payment = parseFloat(advance_payment); 
               if(payable_amount<advance_payment)
               {
                   alert("पहिलो किस्तामा भुक्तानी रकम पेस्की रकम भन्दा कम !! पुन रकम चेक गर्नुहोस ");
                   return false;
               }
            }
        
    });
    
   // final antim payment contingency calculate function
//     JQ(document).on("input","#estimated_amount,#plan_evaluated_amount",function() {
//        var check_inst = JQ("#check_inst").val();
//        var estimated_amount = parseFloat(JQ("#estimated_amount").val() || 0);
//        var mulyankan_amount = parseFloat(JQ("#plan_evaluated_amount").val() || 0);
//        var karyadesh_amount = parseFloat(JQ("#karyadesh_amount").val() || 0);
//        var advance_amount = parseFloat(JQ('#advance_payment').val()||0);
//        var analysis_total = parseFloat(JQ("#analysis_total_evaluated_amount").val() || 0);
//        var total_evaluated_amount = analysis_total + mulyankan_amount;
//        var result_ghati = estimated_amount - total_evaluated_amount;
//        // alert(result_ghati);
//        var plan_id = JQ("#plan_id").val();
//        var payment_percent = (karyadesh_amount / estimated_amount)*100;
//        payment_percent = payment_percent.toFixed(4);
//        var param = {};
//         param.plan_id= plan_id;
//          JQ.post('get_contingency_for_plan.php',param,function(res){
//                    var obj = JSON.parse(res);
//                     var val  = parseFloat(obj.html);
//                     var con_glob =  parseFloat(val);
//                     con_glob = con_glob * 100;
//             if(estimated_amount<= total_evaluated_amount)
//              {
//                 var net_mulyankan = (estimated_amount);
//                 var kam_ghati_amount =0;
//              }
//              else
//              {
//                //   alert("here");
//                  var kam_ghati_amount = ((result_ghati) * payment_percent)/100;
//                //   alert(kam_ghati_amount);
//                  var net_mulyankan = mulyankan_amount;
//              }
//              var payment_amount = (net_mulyankan * payment_percent)/100; 
//              var marmat_rate = JQ("#marmat_rate").val(); 
//              var marmat_result = parseFloat(marmat_rate/100) * parseFloat(payment_amount);
//              var final_amount = (payment_amount * 100)/(100 - con_glob);
//              var final_contingency = final_amount - payment_amount;
//              if(analysis_total == 0)
//              {
//              var final_payment_amount = payment_amount - advance_amount;
//              }
//              else
//              {
//                var final_payment_amount = payment_amount;
//              }
//           var amount_without_con = final_payment_amount + final_contingency;
//            var sum = 0;
//           JQ('input[name^="katti[]"]').each( function() {
//             var id_selected = JQ(this).attr('id');
//             var res = id_selected.split("_");
//             var counter = res[res.length-1];
//             var katti_percent = parseFloat(JQ("#katti_percent_"+counter).val()||0);
//             var amount = amount_without_con * (katti_percent/100);
//    //         var net_amount = payable_amount - amount;
////             alert(katti_percent);
//             
//               sum +=amount;
//             amount= amount.toFixed(4);
//             JQ("#katti_"+counter).val(amount);
//        });
//              var total_katti = marmat_result + final_contingency + parseFloat(sum); 
//              final_payment_amount = amount_without_con - total_katti;
//             JQ("#final_bhuktani_ghati_amount").val(kam_ghati_amount.toFixed(4));
//             JQ("#final_renovate_amount").val(marmat_result);
//             JQ("#final_contengency_amount").val(final_contingency.toFixed(2));
//             JQ("#kaam_ghati_katti_rakam").val(amount_without_con.toFixed(2));
//             JQ("#final_total_amount_deducted").val(total_katti.toFixed(2));
//             JQ("#final_total_paid_amount").val(final_payment_amount.toFixed(2));
//      
//        });
//        
//        // alert( new_contingency + " | " + amount_to_be_paid + " | " + new_payable_amount ); return false;
//      });
//      
//     JQ(document).on("input","#final_renovate_amount,#final_dpr_amount, #final_due_amount, #final_disaster_management_amount,#customer_agreement",function() {
//        var advance_payment = 0;
//        var kaam_ghati_katti_rakam = JQ("#kaam_ghati_katti_rakam").val();
//        var final_contingency_amount =JQ("#final_contengency_amount").val(); 
//        var final_renovate_amount = JQ("#final_renovate_amount").val() || 0;
//        var final_dpr_amount = JQ("#final_dpr_amount").val() || 0;
//        var final_due_amount = JQ("#final_due_amount").val() || 0;
//        var final_disaster_management_amount = JQ("#final_disaster_management_amount").val() || 0;
//        var customer_agreement = parseFloat(JQ("#customer_agreement").val()||0);
//        var final_total_amount_deducted = parseFloat(final_due_amount) + parseFloat(final_disaster_management_amount) + parseFloat(advance_payment) + parseFloat(final_contingency_amount) + parseFloat(final_renovate_amount ) +  parseFloat(final_dpr_amount );
//        var final_total_paid_amount = parseFloat(kaam_ghati_katti_rakam) - final_total_amount_deducted;
//        JQ("#final_total_amount_deducted").val(final_total_amount_deducted.toFixed(2));
//        JQ("#final_contengency_amount").val(final_contingency_amount);
//        JQ("#final_total_paid_amount").val(final_total_paid_amount.toFixed(2));
//
//   
//});
//     
//   // payment contingency calculate function mulyankan adhar ma bhuktani
//    JQ(document).on("input","#evaluated_amount,#analysis_estimated_amount",function() {
//         var estimated_amount = parseFloat(JQ("#analysis_estimated_amount").val() || 0);
//        var plan_evaluated_amount = parseFloat(JQ("#evaluated_amount").val() || 0);
//        var karyadesh_rakam = parseFloat(JQ("#karyadesh_rakam").val()||0);
//        var payment_evaluation_count = parseFloat(JQ("#payment_evaluation_count").val());
//        var advance_amount=0;
//        if(payment_evaluation_count==1)
//        {
//            advance_amount = parseFloat(JQ("#advance_payment").val() || 0);
//        }
//        var plan_id = JQ("#plan_id").val();
//          var param = {};
//         param.plan_id= plan_id;
//          JQ.post('get_contingency_for_plan.php',param,function(res){
//             var obj = JSON.parse(res);
//             var val  = parseFloat(obj.html);
//                // alert(val);return false;
//             var con_glob =  parseFloat(val);
//             con_glob = con_glob*100;
//                 
//              var payment_percent   = ((karyadesh_rakam/estimated_amount) * 100);
//             
//              payment_percent       = payment_percent.toFixed(3)
//              var janashramdan      = ((100 - payment_percent) * plan_evaluated_amount)/100;
//              var amount_to_be_paid = ((plan_evaluated_amount*payment_percent)/100);
//              var final_amount = (amount_to_be_paid*100)/(100- con_glob);
//              var final_contingency = final_amount - amount_to_be_paid;
//              var total_katti = final_contingency + advance_amount;
//              var total_paid_amount = amount_to_be_paid - advance_amount;
//                    
//                     JQ("#contengency_amount").val(final_contingency.toFixed(2));
//                      JQ("#janshramdan_amount").val(janashramdan.toFixed(2));
//                       JQ("#total_amount_deducted").val(total_katti.toFixed(2));
//                      JQ("#payable_amount").val(final_amount.toFixed(2));
//                      JQ("#total_paid_amount").val(total_paid_amount.toFixed(2));
//                      
//                      
//          });
//     
//          });
//
//    JQ(document).on("input","#payable_amount,#evaluated_amount",function() {        
//        var payable_amount = JQ("#payable_amount").val() || 0;
//        var amount_paid = JQ(".inst_amount");
//        var net_payable_amount = JQ("#net_payable_amount").html();
//        var plan_id = JQ("#plan_id").val();
//        var payment_count = JQ("#payment_evaluation_count").val();
//        var inst_amount = 0;
//        if(amount_paid.length>0)
//        {
//           
//            JQ(".inst_amount").each(function(){
//                    var addval = JQ(this).val();
//                     inst_amount = inst_amount + parseFloat(addval);
//             });
//        }
//       
//         var param = {};
//          param.plan_id= plan_id;
//            
//          JQ.post('get_contingency_for_plan.php',param,function(res){
//                    var obj = JSON.parse(res);
//                     var val  = parseFloat(obj.html);
//                     var con_glob =  parseFloat(val);
////                     alert(con_glob);return false;
//        var sum = 0;
//        JQ('input[name^="katti[]"]').each( function() {
//             var id_selected = JQ(this).attr('id');
//             var res = id_selected.split("_");
//             var counter = res[res.length-1];
//             var katti_percent = parseFloat(JQ("#katti_percent_"+counter).val()||0);
//             var amount = payable_amount * (katti_percent/100);
//    //         var net_amount = payable_amount - amount;
//             sum +=amount;
//             amount= amount.toFixed(4);
//             JQ("#katti_"+counter).val(amount);
//        });
//        var marmat_rate = JQ("#marmat_rate").val();
//        var marmat_amount = parseFloat(payable_amount) * (marmat_rate/100);
//        JQ("#renovate_amount").val(marmat_amount.toFixed(4));
//        var contingency = parseFloat(payable_amount)* con_glob;
//        var advance_payment = JQ("#advance_payment").val() || 0;
//        if(payment_count>1)
//        {
//            advance_payment = 0;
//            inst_amount = 0;
//        }
//       
//        var total_amount_deducted = parseFloat(contingency) + parseFloat(sum) + parseFloat(advance_payment)+ parseFloat(marmat_amount);
////        alert(total_amount_deducted);return false;
//        var total_paid_amount = parseFloat(payable_amount) - total_amount_deducted - inst_amount ;
//        JQ("#total_amount_deducted").val(total_amount_deducted.toFixed(4));
//        JQ("#contengency_amount").val(contingency.toFixed(4));
//        //JQ("#renovate_amount").val(marmat_result);
//        JQ("#total_paid_amount").val(total_paid_amount.toFixed(2));
//
//    });
//})
	JQ(document).on("input","input[name~='main_topic_no[]']",function() {
													  
		var myclass = JQ(this).attr("class");
    var res = myclass.split("_");
    var counter = res[res.length-1];
    var topic_no = JQ('.main_topic_no_'+counter).val();
		var param = {};
        param.topic_no = topic_no;
       
            JQ.post('getparentopics.php',param,function(res){
                var obj = JSON.parse(res);
				          JQ("#parent_topic_"+counter).html(obj.html);
                  
			});
       
        
    });
	JQ(document).on("input","input[name~='sub_topic_no[]']",function() {
    var myclass = JQ(this).attr("class");
    var res = myclass.split("_");
    var counter = res[res.length-1];
    var qty = JQ('.qty_'+counter).val();
		var sub_topic_no = JQ('.sub_topic_no_'+counter).val();
		var topic_no = JQ('.main_topic_no_'+counter).val();
    var param = {};
    param.topic_no = topic_no;
		param.sub_topic_no = sub_topic_no;
    param.qty = qty;
            JQ.post('getsubtopics.php',param,function(res){
                var obj = JSON.parse(res);

          JQ("#sub_topic_"+counter).html(obj.html);
				  JQ(".total_amount_"+counter).html(obj.amt); 
              var net_total = 0;
              var length = JQ(".calculate").length;
              var amount = 0;
              var newamt = 0;
              for(i = 1; i <=length;  i++) { 
                amount = JQ(".total_amount_"+i).html();
                newamt = parseInt(amount);
                net_total += newamt;

              }
          
          JQ("#net_total").val(net_total);
                
	});
       
        
    });
  JQ(document).on("input","input[name~='qty[]']",function() {
    var myclass = JQ(this).attr("class");
    var res = myclass.split("_");
    var counter = res[res.length-1];
    var qty = JQ('.qty_'+counter).val();
    var sub_topic_no = JQ('.sub_topic_no_'+counter).val();
    var topic_no = JQ('.main_topic_no_'+counter).val();
    var param = {};
    param.topic_no = topic_no;
    param.sub_topic_no = sub_topic_no;
    param.qty = qty;
            JQ.post('getamountfromqty.php',param,function(res){
                var obj = JSON.parse(res);

          JQ("#sub_topic_"+counter).html(obj.html);
          JQ(".total_amount_"+counter).html(obj.amt);
           var net_total = 0;
              var length = JQ(".calculate").length;
              var amount = 0;
              var newamt = 0;
              for(i = 1; i <=length;  i++) { 
            amount = JQ(".total_amount_"+i).html();
            newamt = parseInt(amount);
            net_total += newamt;
            
          }
          
          JQ("#net_total").val(net_total);
      });
       
        
    });
  // topic area dynamic selection 
  JQ(document).on("change","#topic_area_id",function() {
    var topic_id = JQ(this).val();
    var param = {};
    
        param.topic_id = topic_id;
       // param.myclass = myclass;
            JQ.post('gettopicareatype.php',param,function(res){
                var obj = JSON.parse(res);

                  JQ("#topic_area_type_id").html(obj.html);
                  //false;
      });
       
        
    });

  // sub topic area dynamic selection 
  JQ(document).on("change","#topic_area_type_id",function() {
    var topic_id = JQ(this).val();
	
    var param = {};
    
        param.topic_id = topic_id;
       // param.myclass = myclass;
            JQ.post('gettopicareatypesub.php',param,function(res){
                var obj = JSON.parse(res);

                  JQ("#topic_area_type_sub_id").html(obj.html);
                  //false;
      });
       
        
    });
	JQ(document).on("change","select[name~='parent_id[]']",function() {
		var parent_id = JQ(this).val();
		var myclass = JQ(this).attr("class");
		var param = {};
		
        param.parent_id = parent_id;
        param.myclass = myclass;
            JQ.post('getsubtopics.php',param,function(res){
                var obj = JSON.parse(res);

                  JQ("#sub_topic").html(obj.html);
                  //false;
			});
       
        
    });
	JQ(document).on("change","#sub_topic_id",function() {
		var sub_id = JQ('#sub_topic_id').val();
		var param = {};
        param.sub_id = sub_id;
        
            JQ.post('getsubtopicno.php',param,function(res){
                var obj = JSON.parse(res);
				JQ("#topic_no_display").html(obj.html);
                  false;
			});
       
        
    });

	JQ(document).on("click","#calcmaturitydate",function() {

        var mydate = JQ('#nepaliDate5').val();
		
        var param = {};
        param.mydate =mydate;
      JQ.post('calculate_maturity.php',param,function(res){
               var obj = JSON.parse(res);
			  alert(obj.msg); false;
               JQ('#nepaliDate9').val(obj.mat_date);
			   false;
               
              // alert(obj.interest_amount);
            });
    });
	JQ(document).on("click","#generateschedule",function() {

        var myclass = JQ(this).attr('class');
		
        var param = {};
        param.myclass =myclass;
      JQ.post('generate_schedule.php',param,function(res){
               var obj = JSON.parse(res);
			  	alert(obj.msg); false;
               JQ('#schedule').html(obj.html);
			   false;
               
              // alert(obj.interest_amount);
            });
    });
    JQ(document).on("click","#find_member",function() {

        var member_cit = JQ("#member_cit").val();
        
        var param = {};
        param.member_cit =member_cit;
        JQ.post('get_member.php',param,function(res){
               var obj = JSON.parse(res);
               JQ('#found_member').html(obj.html);
               //JQ('#dialog').open();
               // for dialog box

    
              // alert(obj.interest_amount);
            });
    });
	 JQ(document).on("click","#find_account_member",function() {

        var member_cit = JQ("#member_cit").val();
        
        var param = {};
        param.member_cit =member_cit;
        JQ.post('get_account_member.php',param,function(res){
               var obj = JSON.parse(res);
               JQ('#found_member').html(obj.html);
               //JQ('#dialog').open();
               // for dialog box

    
              // alert(obj.interest_amount);
            });
    });
    JQ(document).on("change","#acc_type",function() {
        var acc_type_selected = JQ('#acc_type').val();

        var param = {};
        param.acc_type_selected = acc_type_selected;
        if(acc_type_selected!='')
        {
            JQ.post('populate_instalment_type.php',param,function(res){
                var obj = JSON.parse(res);

                
                  JQ("#installment_type").html(obj.installment_type_html);
                  JQ('#product_type').html(obj.product_type_html);
                    false;
            });
        }
        else
        {
              JQ("#installment_type").html('');
                  JQ('#product_type').html('');
                    false;
        }
            
        
    });
    JQ(document).on("change","#zone",function() {
		var zone = JQ('#zone').val();
        var param = {};
        param.zone = zone;
        
            JQ.post('getdistricts.php',param,function(res){
                var obj = JSON.parse(res);

                  JQ("#district").html(obj.html);
                  JQ('#product_type').html(obj.product_type_html);
                    false;
            });
       
        
    });
    JQ(document).on("click",".descblock",function() {
    	var textblock = JQ(this).attr('name');
    	var styleval = JQ(textblock).css('display');
    	if(styleval =="block"){
    		JQ(textblock).hide();
    	}
    	else{
    		JQ(textblock).show();	
    	}
    	//alert(styleval); false;
    });

    JQ("#uploadOnClick").on("click", function() {
    	//alert("here uplaod"); false;
        var uploadfile = JQ('#upload')[0].files[0];
          //alert(uploadfile); false; 
    //var form_data = new FormData(file_data);                  
    //form_data.append("file", file_data);
    //var data = {

    //	option: 'com_manuscript',
    //	task: 'uploadImage',
    //	form_data: form_data
    //};
    //alert(form_data);   false;                          
    	var param = {};
        param.option = 'com_manuscript';
        param.task = 'uploadImage';
        param.uploadfile = uploadfile;
		//param.tmp_name = tmp_name;
		 JQ.post('index.php',param,function(res){
               
                alert(res);
            });
	});
	
        JQ(document).on("click","#add_training",function(){
           var count = parseInt(JQ(".sn").length) + parseInt(JQ(".training_row").length) +1;
           var param = {};
           param.count  = count;
           JQ.post("get_training_div.php",param,function(res){
               var obj = JSON.parse(res);
               JQ("#training_div").append(obj.html);
           });
           
        });
        
        JQ(document).on("click","#remove_training",function(){
            var id_selected = JQ(".training_row").last().attr('id');
            var res = id_selected.split("_");
            var id = res[res.length-1];
            var selected_total = parseFloat(JQ("#total_"+id).val());
            var grand_total = parseFloat(JQ("#grand_total").val());
            var new_total  = grand_total - selected_total;
            JQ("#grand_total").val(new_total);
            JQ(".training_row").last().remove(); 
        });
      
        
});
