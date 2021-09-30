var JQ = jQuery.noConflict();
JQ(document).ready(function(){
    function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
    }
    JQ('#tableFixHead').on('scroll', function() {
  JQ('thead', this).css('transform', 'translateY('+ this.scrollTop +'px)');
});
//for calculator
 JQ(document).on("click","#calc_close",function() {
//         debugger;
             var textbox_id =JQ('#textbox_id').text();
            var calc_value=JQ('#display_cacl_value').val();
            JQ('#'+textbox_id).val(calc_value);
            JQ('#textbox_id').text("");
            var res = textbox_id.split('-');
              
        var counter = res[res.length-1];
        if(!isNaN(counter))
        {
                var break_class = "break_row-"+counter;
                if(JQ("."+break_class).length!=0)
                {
                    var total_parinam = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
                    var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                    var sub_total = total_parinam * task_rate;
                    JQ("#total_rate-"+counter).val(sub_total);
                }
                // if not via break
                else
                {
                    
                    var mylength = parseFloat(JQ("#length-"+counter).val()  || 1 );
                    var breadth = parseFloat(JQ("#breadth-"+counter).val() || 1);
                    var height = parseFloat(JQ("#height-"+counter).val()  || 1);
                    var task_count = parseFloat(JQ("#task_count-"+counter).val() || 1);
                    var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                    
                     var total = parseFloat(task_count * mylength * breadth * height);
                     JQ("#total_evaluation-"+counter).val(total.toFixed(2));
                     var total_evaluation = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
                     var total_amount = task_rate * total_evaluation;
                     JQ("#total_rate-"+counter).val(total_amount);
                     
                }
                 var count = 1;
                      var sub_total = 0;
                      JQ("input[name~='total_rate[]']").each(function () {
                            var total_amount = parseFloat(JQ(this).val()) || 0 ;
                            sub_total = parseFloat(sub_total) + total_amount;
                            count++;
                      });
                     var type = parseInt(JQ("#type").val()) || 0;
                     if(type==0)
                     {
                        JQ("#sub_total").val(sub_total.toFixed(2));

                     }
                  if(type==1)
                 {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                 }
                 if(type===2)
                 {
                    //var contingency = parseFloat(sub_total*.03);
                    var overhead = parseFloat(sub_total*.15);
                    var vat_amount = parseFloat((sub_total+overhead)*.13);
                    var grand_total = sub_total + vat_amount + overhead;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                    //JQ("#contingency").val(contingency);
                    JQ("#vat_amount").val(vat_amount.toFixed(2));
                    JQ("#overhead").val(overhead.toFixed(2));
                    JQ("#grand_total").val(grand_total.toFixed(2));
                    
                 }
                
                
        }
        else
        {
              var main_counter_res = counter.split("_");
//             alert(main_counter_res);
               var main_counter = main_counter_res[main_counter_res.length-2];
               if(isNaN(counter))
               {
                    var mylength    = parseFloat(JQ("#length-"+counter).val()  || 1 );
                    var breadth     = parseFloat(JQ("#breadth-"+counter).val() || 1);
                    var height      = parseFloat(JQ("#height-"+counter).val()  || 1);
        //                var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                    var task_count  = parseFloat(JQ("#task_count-"+counter).val() || 1);

                    var total               = mylength * breadth * height * task_count;
                    var formatted_total     = total.toFixed(2);
                    JQ("#total_evaluation-"+counter).val(formatted_total);
                }
                
                var sub_total = 0;
                var total_parinam = 0;
                var deduct_amount = 0;
               
                JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                        if(JQ("#"+check_id).is(":checked"))
                        {
                            var deduct_val = parseFloat(JQ(this).val()) || 0;
                            deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                        }
                        else
                        {
                              total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                        }
                        
                  });
                 
                  total_parinam = total_parinam - deduct_amount;
                  var formatted_total_parinam = total_parinam.toFixed(2);
                  sub_total = parseFloat(sub_total) + parseFloat(formatted_total_parinam);
                  var formatted_sub_total = sub_total.toFixed(2);
                 JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                 var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                 var total_amount = task_rate*formatted_sub_total;
                 JQ("#total_rate-"+main_counter).val(total_amount);
//                 var total_evaluation = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
//                 var total_amount = task_count * task_rate * total_evaluation;
//                  JQ("#total_rate-"+counter).val(total_amount);
                  var count = 1;
                  var sub_total = 0;
                  JQ("input[name~='total_rate[]']").each(function () {
                        var total_amount = parseFloat(JQ(this).val()) || 0 ;
                        sub_total = parseFloat(sub_total) + total_amount;
                        count++;
                  });
                 var type = parseInt(JQ("#type").val()) || 0;
                 if(type==0)
                 {
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     
                 }
                if(type==1)
                 {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                 }
                 if(type===2)
                 {
                    //var contingency = parseFloat(sub_total*.03);
                    var overhead = parseFloat(sub_total*.15);
                    var vat_amount = parseFloat((sub_total+overhead)*.13);
                    var grand_total = sub_total + vat_amount + overhead;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                    //JQ("#contingency").val(contingency);
                    JQ("#vat_amount").val(vat_amount.toFixed(2));
                    JQ("#overhead").val(overhead.toFixed(2));
                    JQ("#grand_total").val(grand_total.toFixed(2));
                    
                 }
        }
               
         
     });
//ends here
JQ(document).on("input","input[name~='length[]'], input[name~='breadth[]'],input[name~='height[]'],input[name~='total_evaluation[]'],input[name~='task_rate[]'],input[name~='task_count[]']",function() {
                var id_selected = JQ(this).attr("id");
                var res = id_selected;
                var counter = res[res.length-1];
                var break_class = "break_row-"+counter;
                if(JQ("."+break_class).length!=0)
                {
                    var total_parinam = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
                    var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                    var sub_total = total_parinam * task_rate;
                    JQ("#total_rate-"+counter).val(sub_total);
                }
                // if not via break
                else
                {
                    
                    var mylength = parseFloat(JQ("#length-"+counter).val()  || 1 );
                    var breadth = parseFloat(JQ("#breadth-"+counter).val() || 1);
                    var height = parseFloat(JQ("#height-"+counter).val()  || 1);
                    var task_count = parseFloat(JQ("#task_count-"+counter).val() || 1);
                    var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                    
                     var total = parseFloat(task_count * mylength * breadth * height);
                     JQ("#total_evaluation-"+counter).val(total.toFixed(2));
                     var total_evaluation = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
                     var total_amount = task_rate * total_evaluation;
                     JQ("#total_rate-"+counter).val(total_amount);
                     
                }
                 var count = 1;
                      var sub_total = 0;
                      JQ("input[name~='total_rate[]']").each(function () {
                            var total_amount = parseFloat(JQ(this).val()) || 0 ;
                            sub_total = parseFloat(sub_total) + total_amount;
                            count++;
                      });
                     var type = parseInt(JQ("#type").val()) || 0;
                     if(type==0)
                     {
                        JQ("#sub_total").val(sub_total.toFixed(2));

                     }
                     if(type==1)
                     {
                        var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                        var public_anudan = sub_total - bhuktani_anudan;
                        JQ("#sub_total").val(sub_total.toFixed(2));
                         JQ("#public_anudan").val(public_anudan.toFixed(2));
                         JQ("#grand_total").val(sub_total.toFixed(2));
                     }
                     if(type===2)
                     {
                        //var contingency = parseFloat(sub_total*.03);
                        var overhead = parseFloat(sub_total*.15);
                        var vat_amount = parseFloat((sub_total+overhead)*.13);
                        var grand_total = sub_total + vat_amount + overhead;
                        JQ("#sub_total").val(sub_total.toFixed(2));
                        //JQ("#contingency").val(contingency);
                        JQ("#vat_amount").val(vat_amount.toFixed(2));
                        JQ("#overhead").val(overhead.toFixed(2));
                        JQ("#grand_total").val(grand_total.toFixed(2));
                     }
                
                 
                
         
     });
     
     JQ(document).on("input","input[name^='length-'], input[name^='breadth-'],input[name^='height-'],input[name^='total_evaluation-'],input[name^='task_count-']",function() {
                var id_selected = JQ(this).attr("id");
                var res = id_selected.split("-");
                var counter = res[res.length-1];
                var main_counter_res = counter.split("_");
                var main_counter = main_counter_res[main_counter_res.length-2];
               
                var mylength    = parseFloat(JQ("#length-"+counter).val()  || 1 );
                var breadth     = parseFloat(JQ("#breadth-"+counter).val() || 1);
                var height      = parseFloat(JQ("#height-"+counter).val()  || 1);
//                var task_rate = parseFloat(JQ("#task_rate-"+counter).val() || 0);
                var task_count  = parseFloat(JQ("#task_count-"+counter).val() || 1);
                
                var total               = mylength * breadth * height * task_count;
                var formatted_total     = total.toFixed(2);
                JQ("#total_evaluation-"+counter).val(formatted_total);
                var sub_total = 0;
                var total_parinam = 0;
                var deduct_amount = 0;
               
                JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                        if(JQ("#"+check_id).is(":checked"))
                        {
                            var deduct_val = parseFloat(JQ(this).val()) || 0;
                            deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                        }
                        else
                        {
                              total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                        }
                        
                  });
                 
                  total_parinam = total_parinam - deduct_amount;
                  var formatted_total_parinam = total_parinam.toFixed(2);
                  sub_total = parseFloat(sub_total) + parseFloat(formatted_total_parinam);
                  var formatted_sub_total = sub_total.toFixed(2);
                 JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                 var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                 var total_amount = task_rate*formatted_sub_total;
                 JQ("#total_rate-"+main_counter).val(total_amount);
//                 var total_evaluation = parseFloat(JQ("#total_evaluation-"+counter).val() || 0);
//                 var total_amount = task_count * task_rate * total_evaluation;
//                  JQ("#total_rate-"+counter).val(total_amount);
                  var count = 1;
                  var sub_total = 0;
                  JQ("input[name~='total_rate[]']").each(function () {
                        var total_amount = parseFloat(JQ(this).val()) || 0 ;
                        sub_total = parseFloat(sub_total) + total_amount;
                        count++;
                  });
                 var type = parseInt(JQ("#type").val()) || 0;
                 if(type==0)
                 {
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     
                 }
                 if(type==1)
                 {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                 }
                 if(type===2)
                 {
                    //var contingency = parseFloat(sub_total*.03);
                    var overhead = parseFloat(sub_total*.15);
                    var vat_amount = parseFloat((sub_total+overhead)*.13);
                    var grand_total = sub_total + vat_amount + overhead;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                    //JQ("#contingency").val(contingency);
                    JQ("#vat_amount").val(vat_amount.toFixed(2));
                    JQ("#overhead").val(overhead.toFixed(2));
                    JQ("#grand_total").val(grand_total.toFixed(2));
                    
                 }
                 
                
         
     });
JQ(document).on("input","#investment_amount,#other_source,#samiti_investment,#other_agreements",function() {
                var investment_amount = JQ("#investment_amount").val()||0;
		 var other_source = JQ("#other_source").val()||0;
                 var samiti_investment = JQ("#samiti_investment").val()||0;
                 var other_agreements = JQ("#other_agreements").val()||0;
//                 alert(other_agreement);return
                 var total=parseFloat(investment_amount) + parseFloat(other_source) + parseFloat(samiti_investment) + parseFloat(other_agreements);
	         JQ("#total_investment").val(total);
                
            });
            
 JQ(document).on("input","#total_investment_amount,#other_investment",function() {
        var total_investment_amount = JQ("#total_investment_amount").val()||0;
        var other_investment = JQ("#other_investment").val()||0;
        var total1=parseFloat(total_investment_amount) + parseFloat(other_investment);
        JQ("#total_amount").val(total1);
    });
// JQ(document).on("change","select[name~='task_id[]']",function() {
//        var id_selected = JQ(this).attr("id");
//        var res = id_selected;
//        var counter = res[res.length-1];
//        var task_id = JQ(this).val();
//        if(task_id=='')
//        {
//            alert("कृपया क्षेत्र छान्नुहोला ");
//            return false;
//        }
//         else{
//        var param = {};
//          param.counter= counter;
//        param.task_id = task_id;
//        JQ.post('get_estimate_task.php',param,function(res){
//                var obj = JSON.parse(res);
////                alert(obj.html);exit;
//                JQ("#task_name_column-"+counter).html(obj.html);
//                
//            });
//         }
//     });
     // getting the sub estimate section 
     JQ(document).on("click",".get_measurement",function() {
        var id_selected = JQ(this).attr("id");
        var res = id_selected;
        var result = res.split("-");
        var estimate_sub_id = result[result.length-1];
        var counter = result[result.length-2];
        var estimate_sub_name = result[result.length-3];
        
       //. var task_id = JQ("#task_id-"+counter).val();
        //var task_name = JQ("#task_name-"+counter).val();
        var html = '<input type="hidden" name="estimate_sub_id[]" value="'+estimate_sub_id+'" />'+'<span class="change_estimate_sub" id="counter-'+counter+'">'+estimate_sub_name+'</span>';
        JQ("#estimate_sub-"+counter).html(html);
        JQ('#dialog_show').modal('hide');
     });
//      JQ(document).on("change","select[name~='task_id[]']",function() {
//            var task_id = JQ(this).val();
//            var id_selected = JQ(this).attr("id");
//            var res = id_selected;
//            var result = res.split("-");
//            var counter = result[result.length-1];
//            var task_name = JQ("#task_name-"+counter).val();
//            var estimate_html;
//            if(task_id=='')
//              {
//                        alert("कृपया नाम छान्नुहोला ");
//                       return false;
//               }
//            else{
//                    var param = {};
//                      param.counter= counter;
//                    param.task_id = task_id;
//                    JQ.post('get_specifications.php',param,function(res){
//                            var obj = JSON.parse(res);
//                            estimate_html = obj.estimate_html;
//                               var html = ' <div class="modal-dialog" role="document">'+
//                   '<div class="modal-content">'+
//                     '<div class="modal-header">'+
//                       '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
//                       '<h4 class="modal-title">Specification छान्नुहोस्</h4>'+
//                     '</div>'+
//                     '<div class="modal-body" style="font-size:14 px">'+estimate_html+
//                  '</div>'+
//                  '<div class="modal-footer">'+
//                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
//                  '</div>'+
//                '</div>'+
//              '</div>';
////                           JQ("#estimate_sub-"+counter).html(obj.estimate_html);
//                            JQ("#unit-"+counter).html(obj.output);
//                            JQ("#dialog_show").html(html);
//                            JQ('#dialog_show').modal('show');
//                        });
//                       
//                }
//      });
    JQ(document).on("change","select[name~='task_name[]']",function() {
            var id_selected = JQ(this).attr("id");
            var res = id_selected;
            var result = res.split("-");
            var counter = result[result.length-1];
                
            var task_name = JQ("#task_name-"+counter).val();
            var estimate_html;
            if(task_name=='')
              {
                        alert("कृपया नाम छान्नुहोला ");
                       return false;
               }
            else{
                    var param = {};
                      param.counter= counter;
                    param.task_name = task_name;
                    JQ.post('get_estimate_task_unit.php',param,function(res){
                            var obj = JSON.parse(res);
                            estimate_html = obj.estimate_html;
                               var html = ' <div class="modal-dialog" role="document">'+
                   '<div class="modal-content">'+
                     '<div class="modal-header">'+
                       '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                       '<h4 class="modal-title">छान्नुहोस्</h4>'+
                     '</div>'+
                     '<div class="modal-body" style="font-size:14 px">'+estimate_html+
                  '</div>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                  '</div>'+
                '</div>'+
              '</div>';
//                           JQ("#estimate_sub-"+counter).html(obj.estimate_html);
                            JQ("#unit-"+counter).html(obj.output);
                            JQ("#dialog_show").html(html);
                            JQ('#dialog_show').modal('show');
                        });
                       
                }
      });
        
       // for the estimate sub category change 
      JQ(document).on("click",".change_estimate_sub",function() {
            var id_selected = JQ(this).attr("id");
            var res = id_selected;
            var result = res.split("-");
            var counter = result[result.length-1];
                
            var task_name = JQ("#task_name-"+counter).val();
            var estimate_html;
            if(task_name=='')
              {
                        alert("कृपया नाम छान्नुहोला ");
                       return false;
               }
            else{
                    var param = {};
                      param.counter= counter;
                    param.task_name = task_name;
                    JQ.post('get_estimate_task_unit.php',param,function(res){
                            var obj = JSON.parse(res);
                            estimate_html = obj.estimate_html;
                               var html = ' <div class="modal-dialog" role="document">'+
                   '<div class="modal-content">'+
                     '<div class="modal-header">'+
                       '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                       '<h4 class="modal-title">छान्नुहोस्</h4>'+
                     '</div>'+
                     '<div class="modal-body" style="font-size:14 px">'+estimate_html+
                  '</div>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                    '<button type="button" class="btn btn-primary">Save changes</button>'+
                  '</div>'+
                '</div>'+
              '</div>';
//                           JQ("#estimate_sub-"+counter).html(obj.estimate_html);
                            JQ("#unit-"+counter).html(obj.output);
                            JQ("#dialog_show").html(html);
                            JQ('#dialog_show').modal('show');
                        });
                       
                }
      }); 
     JQ(document).on("click",".add",function() {
        var num=JQ(".remove_estimate_detail").length;
        var counter=num+2; 
        var param = {};
        param.counter= counter;
//        alert(counter);return false;
        JQ.post('get_estimate_details.php',param,function(res){
               var obj = JSON.parse(res);
//               alert(obj.html);return false;
               JQ("#estimate_add_more_table").append(obj.output);
             
            });
    });
    JQ(document).on("click",".remove",function() {
       // alert("here");
       var last = JQ('.remove_estimate_detail').last();
        var last_id = last.attr("id");
        var last_id_array = last_id.split("-");
        var counter_selected  = last_id_array[last_id_array.length - 1];
        var break_class_selected = "break_row-"+counter_selected;
        var total_output_row_selected = "total_output_row-"+counter_selected;
        JQ("."+break_class_selected).each(function () {
                     JQ("#"+this.id).remove();
                      
        });
        last.remove();
        JQ("#"+total_output_row_selected).remove();
        
        var main_counter = counter_selected;
        var sub_total = 0;
                var total_parinam = 0;
                var deduct_amount = 0;
               
                JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                        if(JQ("#"+check_id).is(":checked"))
                        {
                            var deduct_val = parseFloat(JQ(this).val()) || 0;
                            deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                        }
                        else
                        {
                              total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                        }
                        
                  });
                 
                  total_parinam = total_parinam - deduct_amount;
                  var formatted_sub_total = total_parinam.toFixed(2);
                 JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                 var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                 var total_amount = task_rate*formatted_sub_total;
                 JQ("#total_rate-"+main_counter).val(total_amount);

                 var count = 1;
                  var sub_total = 0;
                  JQ("input[name~='total_rate[]']").each(function () {
                        var total_amount = parseFloat(JQ(this).val()) || 0 ;
                        sub_total = parseFloat(sub_total) + total_amount;
                        count++;
                  });
                 var type = parseInt(JQ("#type").val()) || 0;
                 if(type==0)
                 {
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     
                 }
                 if(type==1)
                 {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                 }
                 if(type===2)
                 {
//                    var contingency = parseFloat(sub_total*.03);
                    var overhead = parseFloat(sub_total*.15);
                    var vat_amount = parseFloat((sub_total+overhead)*.13);
                    var grand_total = sub_total + vat_amount + overhead;
                    JQ("#sub_total").val(sub_total.toFixed(2));
//                    JQ("#contingency").val(contingency);
                    JQ("#vat_amount").val(vat_amount.toFixed(2));
                    JQ("#overhead").val(overhead.toFixed(2));
                    JQ("#grand_total").val(grand_total.toFixed(2));
                 }
            

    });
    // deleting all the row including its break rows 
    JQ(document).on("click",".row_delete",function() {
       // alert("here");
       if(confirm("Are you sure you want to delete this?"))
       { 
            var last_id = JQ(this).attr("id");
            var last_id_array = last_id.split("-");
            var counter_selected  = last_id_array[last_id_array.length - 1];
            var break_class_selected = "break_row-"+counter_selected;
            var total_output_row_selected = "total_output_row-"+counter_selected;
            JQ("."+break_class_selected).each(function () {
                         JQ("#"+this.id).remove();

            });
            JQ("#"+total_output_row_selected).remove();
            JQ("#remove_estimate_detail-"+counter_selected).remove();
            var main_counter = counter_selected;
            var sub_total = 0;
                    var total_parinam = 0;
                    var deduct_amount = 0;

                    JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                            var evaluate_id = this.id;
                            var evaluate_result = evaluate_id.split("-");
                            var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                            if(JQ("#"+check_id).is(":checked"))
                            {
                                var deduct_val = parseFloat(JQ(this).val()) || 0;
                                deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                            }
                            else
                            {
                                  total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                            }

                      });

                      total_parinam = total_parinam - deduct_amount;
                      var formatted_sub_total = total_parinam.toFixed(2);
                     JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                     var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                     var total_amount = task_rate*formatted_sub_total;
                     JQ("#total_rate-"+main_counter).val(total_amount);

                     var count = 1;
                      var sub_total = 0;
                      JQ("input[name~='total_rate[]']").each(function () {
                            var total_amount = parseFloat(JQ(this).val()) || 0 ;
                            sub_total = parseFloat(sub_total) + total_amount;
                            count++;
                      });
                        JQ("#sub_total").val(sub_total.toFixed(2));


       }    
    });
    
     JQ(document).on("click",".del_row",function() {
            if(confirm("Are you sure you want to delete this?"))
            {   
                var id_selected = JQ(this).attr("id");
                var res = id_selected;
                var counter = res[res.length-1];
                JQ("#remove_estimate_detail-"+counter).remove();
                var count = 1;
                var sub_total = 0;
                JQ("input[name~='total_rate[]']").each(function () {
                      var total_amount = parseFloat(JQ(this).val()) || 0;
                      sub_total = parseFloat(sub_total) + total_amount;
                      count++;
                });
                  JQ("#sub_total").val(sub_total);
            }
            
         

    });
    JQ(document).on("click","#check_details",function() {
                
                if(JQ(this).is(':checked'))
                {
                    JQ("#check_detail_div").show();
                    var total_investment = JQ("#total_investment").val()||0;
		    JQ("#total_investment_amount").val(total_investment);
                   JQ("#total_amount").val(total_investment);
                }
                else
                {
                    JQ("#check_detail_div").hide();
                }
                
            });
             JQ(document).on("click","#check",function() {
                
                if(JQ(this).is(':checked'))
                {
                    JQ("#check_div").show();
                   
                }
                else
                {
                    JQ("#check_div").hide();
                }
                
            });
          JQ(document).on("click",".break",function() {
                
                var id_selected = JQ(this).attr("id");
                var res = id_selected.split("-");
                var counter = res[res.length-1];
                var mycount = parseInt(counter);
                var break_row_length = JQ(".break_row-"+counter).length;
               var row_id = "remove_estimate_detail-"+counter;
                var task_id = "task_id-"+counter;
                var task_name = "task_name-"+counter;
               // JQ("#"+task_id).attr("disabled","true");
                //JQ("#"+task_name).attr("disabled","true");
//                for(var i=1; i<5; i++)
//                {
//                    JQ("#"+row_id+" td:nth-child("+i+")").attr("rowspan",mycount+1);
//                }
                        var break_row_class = "break_row-" + counter;
                        if(break_row_length > 0){
                            var test_row_id = JQ('.' + break_row_class).last('tr').attr('id');
                           var splitted_test=test_row_id.split('-');
                           var again_split=splitted_test[splitted_test.length-1].split('_');
                           var test_counter=again_split[again_split.length-1];
                        }else{
                            var test_counter=0;
                        }
                        


                var param = {};
                param.counter = counter;
                param.break_row_length = test_counter;
                param.sn=break_row_length;
                JQ.post('getmeasurementdiv.php',param,function(res){
                    var obj = JSON.parse(res);
                    if(break_row_length==0)
                    {
//                        var val6 = JQ("#remove_estimate_detail-"+counter+" td:nth-child(6)").val();
                        for(i=3;i<13;i++)
                        {
                           if(i==8)
                           {
                               continue;
                           }
                            JQ("#remove_estimate_detail-"+counter+" td:eq("+i+")").html("");
                        }
                        JQ("#remove_estimate_detail-"+counter).after(obj.html);
                        var first_break_row_count = parseInt(break_row_length) +1;
                        var first_break_row_id = "break_row-"+counter+"_"+first_break_row_count;
                        
                        JQ("#"+first_break_row_id).after(obj.total_output_row);
                    }
                    else
                    {
//                        var break_row_id = "break_row-"+counter+"_"+break_row_length;
//                        JQ("#"+break_row_id).after(obj.html);
                        //change
                        var break_row_class = "break_row-" + counter;
                        var break_row_id = JQ('.' + break_row_class).last('tr').attr('id');
                        //alert(break_row_id);return false;
                        JQ("#" + break_row_id).after(obj.html);
                    }
                    
             
            });
        });
        /*
         * removing the break row and calculating again
         */
         JQ(document).on("click",".remove_break",function() {
            if(confirm("Are you sure you want to delete this?"))
            {
                var id_selected = JQ(this).attr("id");
                var split_id = id_selected.split("-");

                var class_selected  = JQ(this).closest('tr').attr('class');
                var class_length    = JQ("."+class_selected).length;
                
                var res             = id_selected;
                var result          = res.split("-");
                var break_count     = result[result.length-1];
                var break_row       = break_count;
                var break_no_res    = break_row.split("_");
                var counter         = break_no_res[break_no_res.length-2];
                JQ("#break_row-"+break_row).remove();
               
                if(class_length==1)
                {
                    JQ("#total_output_row-"+counter).remove(); 
                    var param           = {};
                    param.counter = counter;
                    JQ.post("get_main_row_html.php",param,function(res){
                        var obj = JSON.parse(res);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(3)").html(obj.html_5);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(4)").html(obj.html_6);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(5)").html(obj.html_7);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(6)").html(obj.html_8);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(7)").html(obj.html_9);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(9)").html(obj.html_11);
                        JQ("#remove_estimate_detail-"+counter+" td:eq(10)").html(obj.html_12);
                        
                    });
                 
                }
                var k = 1;
                var res = id_selected.split("-");
                var counter_res = res[res.length-1];
                var main_counter_res = counter_res.split("_");
                var main_counter = main_counter_res[main_counter_res.length-2];
                var sub_total = 0;
                var total_parinam = 0;
                var deduct_amount = 0;
               
                JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var break_row_id = "break_row-"+evaluate_result[evaluate_result.length-1];
                        var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                        if(JQ("#"+check_id).is(":checked"))
                        {
                            var deduct_val = parseFloat(JQ(this).val()) || 0;
                            deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                        }
                        else
                        {
                              total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                        }
                        
                  });
                 JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var break_row_id = "break_row-"+evaluate_result[evaluate_result.length-1];
                        var break_main_no_res = evaluate_result[evaluate_result.length-1].split("_");
                        var break_main_no = break_main_no_res[break_main_no_res.length-2];
                        JQ("#"+break_row_id+ " td:eq(1)").html(break_main_no+"."+k);
                        k++;
                 });
                total_parinam = total_parinam - deduct_amount;
                var formatted_sub_total = total_parinam.toFixed(2);
                JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                var total_amount = task_rate*formatted_sub_total;
                JQ("#total_rate-"+main_counter).val(total_amount);

                var count = 1;
                var sub_total = 0;
                JQ("input[name~='total_rate[]']").each(function () {
                        var total_amount = parseFloat(JQ(this).val()) || 0 ;
                        sub_total = parseFloat(sub_total) + total_amount;
                        count++;
                });
                var type = parseInt(JQ("#type").val()) || 0;
                if(type==0)
                {
                   JQ("#sub_total").val(sub_total.toFixed(2));
                }
                if(type==1)
                {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                }
                if(type===2)
                {
//                   var contingency = parseFloat(sub_total*.03);
                   
                   var overhead = parseFloat(sub_total*.15);
                   var vat_amount = parseFloat((sub_total+overhead)*.13);
                   var grand_total = sub_total + vat_amount + overhead;
                   JQ("#sub_total").val(sub_total.toFixed(2));
//                   JQ("#contingency").val(contingency);
                   JQ("#vat_amount").val(vat_amount.toFixed(2));
                   JQ("#overhead").val(overhead.toFixed(2));
                   JQ("#grand_total").val(grand_total.toFixed(2));
                }
            }
       });
       JQ(document).on("click",".deduct_part",function() {
            
                var id_selected = JQ(this).attr("id");
                var split_id = id_selected.split("-");
                var class_selected  = JQ(this).closest('tr').attr('class');
                var class_length    = JQ("."+class_selected).length;
                
                var res             = id_selected;
                var result          = res.split("-");
                var break_count     = result[result.length-1];
                var break_row       = break_count;
                var break_no_res    = break_row.split("_");
                var counter         = break_no_res[break_no_res.length-2];
                
                var res = id_selected.split("-");
                var counter_res = res[res.length-1];
                var main_counter_res = counter_res.split("_");
                var main_counter = main_counter_res[main_counter_res.length-2];
                var sub_total = 0;
                var total_parinam = 0;
                var deduct_amount = 0;
               
                JQ("input[name~='total_evaluation-"+main_counter+"[]']").each(function () {
                        var evaluate_id = this.id;
                        var evaluate_result = evaluate_id.split("-");
                        var check_id = "deduct-"+evaluate_result[evaluate_result.length-1];
                        if(JQ("#"+check_id).is(":checked"))
                        {
                            var deduct_val = parseFloat(JQ(this).val()) || 0;
                            deduct_amount = parseFloat(deduct_amount) + parseFloat(deduct_val);
                        }
                        else
                        {
                              total_parinam = parseFloat(total_parinam) +  (parseFloat(JQ(this).val()) || 0) ;
                        }
                        
                  });
                 
                  total_parinam = total_parinam - deduct_amount;
                  var formatted_sub_total = total_parinam.toFixed(2);
                 JQ("#total_evaluation-"+main_counter).val(formatted_sub_total);
                 var task_rate = parseFloat(JQ("#task_rate-"+main_counter).val() || 0);
                 var total_amount = task_rate*formatted_sub_total;
                 JQ("#total_rate-"+main_counter).val(total_amount);

                  var count = 1;
                  var sub_total = 0;
                  JQ("input[name~='total_rate[]']").each(function () {
                        var total_amount = parseFloat(JQ(this).val()) || 0 ;
                        sub_total = parseFloat(sub_total) + total_amount;
                        count++;
                  });
                 var type = parseInt(JQ("#type").val()) || 0;
                 if(type==0)
                 {
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     
                 }
                 if(type==1)
                 {
                    var bhuktani_anudan =  parseFloat(JQ("#bhuktani_anudan").val());
                    var public_anudan = sub_total - bhuktani_anudan;
                    JQ("#sub_total").val(sub_total.toFixed(2));
                     JQ("#public_anudan").val(public_anudan.toFixed(2));
                     JQ("#grand_total").val(sub_total.toFixed(2));
                 }
                 if(type===2)
                 {
//                    var contingency = parseFloat(sub_total*.03);
                    var overhead = parseFloat(sub_total*.15);
                    var vat_amount = parseFloat((sub_total+overhead)*.13);
                    var grand_total = sub_total + vat_amount + overhead;
                    JQ("#sub_total").val(sub_total);
//                    JQ("#contingency").val(contingency);
                    JQ("#vat_amount").val(vat_amount.toFixed(2));
                    JQ("#overhead").val(overhead.toFixed(2));
                    JQ("#grand_total").val(grand_total.toFixed(2));
                 }
            
       });
       // for bill
       JQ(document).on("input","#bhuktani_bill_amount",function() {
        var current_total = parseFloat(JQ("#current_total").html()) || 0;
        var khud_total    = parseFloat(JQ("#khud_total").html()) || 0;
        var total_back_amount = parseFloat(JQ("#total_back_amount").html()) || 0;
        
        var total_bhuktani_amount = parseFloat(JQ("#total_bhuktani_amount").html()) || 0;
        // checking the payable amount 
        var payable_amount = khud_total - total_back_amount;
        var bhuktani_bill_amount = parseFloat(JQ("#bhuktani_bill_amount").val()) || 0;
        if(bhuktani_bill_amount > payable_amount)
        {
            alert("भुक्तानी रकम बढी भयो");
            return false;
        }
        var total_back_amount = parseFloat(JQ("#total_back_amount").html()) || 0;
//        alert(total_bhuktani_amount + " - " + bhuktani_bill_amount + " - " + total_back_amount);
         var bhuktani_rem_amount = total_bhuktani_amount - bhuktani_bill_amount - total_back_amount;
         JQ("#bhuktani_rem_amount").val(bhuktani_rem_amount);
    });
});